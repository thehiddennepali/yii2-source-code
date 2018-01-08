<?php
namespace merchant\components;

use Yii;
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class EmailManager{
	
	public static function SiteLink(){
		return 'https://aondego.com/';
	}
    
	public static function adminEmail(){
	    return \frontend\models\Option::getValByName('global_admin_sender_email');
	}

	public static function adminSendEmail($subjectName, $bodyName, $variable, $emailProvider){



	    $subject = \frontend\models\Option::getValByName($subjectName);

	    $subject = self::getBody($subject, $variable);

	    $body = \frontend\models\Option::getValByName($bodyName);

	    $body = self::getBody($body, $variable);



	    if($emailProvider == 0){
		self::sendPhpEmail(self::adminEmail(), $subject, $body);
	    }else if($emailProvider == 1){
		$email = self::sendSmtpEmail(self::adminEmail(), $subject, $body);

	    }

	}
    
	public static function manageLoginDetail($model){
		
		$language = $model->language->code;
		$option = \frontend\models\Option::getValByName('email_tpl_merchant_manager_login', $language);
		$optionManager = \frontend\models\Option::getValByName('email_tpl_merchant_manager_login_manager', $language);

		$email_provider = \frontend\models\Option::getValByName('email_provider');
		$variable = [];

		$variable['merchant_name'] = $model->service_name;
		$variable['link'] = \yii\helpers\Html::a('Manager Login', Yii::$app->urlManager->createAbsoluteUrl('login/manager'));
		$variable['email'] = $model->manager_username;
		$variable['password'] = $model->manager_password;
		
		
		$subject = \frontend\models\Option::getValByName('email_tpl_sub_merchant_manager_login', $language);
		$subjectManager = \frontend\models\Option::getValByName('email_tpl_sub_merchant_manager_login_manager', $language);
		
		$subvariable = [];
		$subvariable['merchant_name'] = $model->service_name;

		$subject = self::getBody($subject, $subvariable);
		$subjectManager = self::getBody($subjectManager, $subvariable);
		
		
		$body = self::getBody($option, $variable);
		$bodyManager = self::getBody($optionManager, $variable);
            
		if($email_provider == 0){
		    self::sendPhpEmail($model->contact_email, $subject, $body);
		    self::sendPhpEmail($model->manager_username, $subjectManager, $bodyManager);
		}else if($email_provider == 1){
		    self::sendSmtpEmail($model->contact_email, $subject, $body);
		    self::sendSmtpEmail($model->manager_username, $subjectManager, $bodyManager);
		}
		
		

	}

        public static function voucher($model){
        
        $language = $model->merchant->language->code;
        $option = \frontend\models\Option::getValByName('email_tpl_customer_voucher', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        $variable = [];
        
        $variable['merchant_name'] = Yii::$app->user->identity->service_name;
        $variable['coupon'] = $model->voucher_name;
        if($model->voucher_type == 1){
            $coupon_value = $model->amount.'%';
        }else{
            $coupon_value = '€'.$model->amount;
        }
        
        $variable['coupon_amount'] = $coupon_value;
        
        $clients = \common\models\Client::find()->where(['status' => 1])->all();
        
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_voucher', $language);
        
        $subvariable = [];
        $subvariable['merchant_name'] = $model->merchant->service_name;
        
        $subject = self::getBody($subject, $subvariable);
        
        foreach ($clients as $client){
            
            $variable['first_name'] = $client->first_name;
            $variable['last_name'] = $client->last_name;
            
            $body = self::getBody($option, $variable);
            
            if($email_provider == 0){
                self::sendPhpEmail($client->email_address, $subject, $body);
            }else if($email_provider == 1){
                self::sendSmtpEmail($client->email_address, $subject, $body);
            }
            
        }
                
        
    }


    
    public static function cancelAppointment($order){
        $language = $order->merchant->language->code;
        $option = \frontend\models\Option::getValByName('email_tpl_customer_appointment_cancelled', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        $variable = [];
        $variable['first_name'] = $order->client_name;
        $variable['last_name'] = "";
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['merchant_address'] = $order->merchant->address;
        
        $variable['booked_service'] = $order->category->title;
        $variable['booked_seats'] = $order->no_of_seats;
        $variable['staff_member'] = $order->staff->name;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
       
        $variable['coupon_amount'] = "";
	$variable['coupon_used'] = "";
	
	$variable['loyalty_points_used'] = "";
	$variable['loyalty_points_amount'] = "";
	
	$variable['admin_logo'] = self::adminLogo();
	$variable['merchant_logo'] = self::merchantLogo($order->merchant);
	
	$variable['cancel_reason'] = $order->cancel_reason;
	
	if(!empty($order->voucher_id)){
		$coupon = \common\models\Voucher::findOne(['voucher_id' => $order->voucher_id]);
		if($coupon->voucher_type == 1){
		    $coupon_value = $coupon->amount.'%';
		}else{
		    $coupon_value = '€'.$coupon->amount;
		}

		$variable['coupon_amount'] = $coupon_value;
		$variable['coupon_used'] = $coupon->voucher_name;
	}
	
	if(!empty($order->loyalty_points)){
		$variable['loyalty_points_used'] = $order->loyalty_points;
		$variable['loyalty_points_amount'] = $order->loyalty_points_amount;
		
	}
        
        $body = self::getBody($option, $variable);
        
        
        
        //$subject = 'Appointment Cancel';
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_appointment_cancelled', $language);;
        
        $subvariable = [];
        $subvariable['merchant_name'] = $order->merchant->service_name;
        
        $subject = self::getBody($subject, $subvariable);
        
        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_appointment_cancelled', 'email_tpl_admin_appointment_cancelled', $variable, $email_provider);
        
        if($email_provider == 0){
            self::sendPhpEmail($order->client_email, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($order->client_email, $subject, $body);
        }
    }


    public static function newAppointmentMerchant($order){
        $language = $order->merchant->language->code;
        
        $option = \frontend\models\Option::getValByName('email_tpl_merchant_new_appointment', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        $variable = [];
        $variable['customer_name'] = $order->client->first_name.' '.$order->client->last_name;
        
        $variable['booked_service'] = $order->category->title;
        $variable['staff_member'] = $order->staff->name;
        $variable['booked_seats'] = $order->no_of_seats;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
        $variable['booking_total'] = $order->price;
        
	$variable['coupon_amount'] = "";
	$variable['coupon_used'] = "";
	
	$variable['loyalty_points_used'] = "";
	$variable['loyalty_points_amount'] = "";
	
	$variable['admin_logo'] = self::adminLogo();
	$variable['merchant_logo'] = self::merchantLogo($order->merchant);
	
	if(!empty($order->voucher_id)){
		$coupon = \common\models\Voucher::findOne(['voucher_id' => $order->voucher_id]);
		if($coupon->voucher_type == 1){
		    $coupon_value = $coupon->amount.'%';
		}else{
		    $coupon_value = '€'.$coupon->amount;
		}

		$variable['coupon_amount'] = $coupon_value;
		$variable['coupon_used'] = $coupon->voucher_name;
	}
	
	if(!empty($order->loyalty_points)){
		$variable['loyalty_points_used'] = $order->loyalty_points;
		$variable['loyalty_points_amount'] = $order->loyalty_points_amount;
		
	}
        
        $body = self::getBody($option, $variable);
        
        
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_merchant_new_appointment', $language);;
        
        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_new_appointment', 'email_tpl_admin_new_appointment', $variable, $email_provider);
        
        if($email_provider == 0){
            self::sendPhpEmail($order->merchant->contact_email, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($order->merchant->contact_email, $subject, $body);
        }
        
    }
    
    public static function modifiedAppointment($order){
        $language = $order->merchant->language->code;
        $option = \frontend\models\Option::getValByName('email_tpl_customer_appointment_modified', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        $variable = [];
        $variable['first_name'] = $order->client_name;
        $variable['last_name'] = "";
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['merchant_address'] = $order->merchant->address;
        $variable['booked_service'] = $order->category->title;
        $variable['booked_seats'] = $order->no_of_seats;
        $variable['staff_member'] = $order->staff->name;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
        $variable['booking_total'] = $order->price;
		$variable['currency_code'] = \common\components\Helper::getCurrencyCode($order->merchant);
	
		$variable['coupon_amount'] = "";
		$variable['coupon_used'] = "";

		$variable['loyalty_points_used'] = "";
		$variable['loyalty_points_amount'] = "";

		$variable['admin_logo'] = self::adminLogo();
		$variable['merchant_logo'] = self::merchantLogo($order->merchant);
	
	if(!empty($order->voucher_id)){
		$coupon = \common\models\Voucher::findOne(['voucher_id' => $order->voucher_id]);
		if($coupon->voucher_type == 1){
		    $coupon_value = $coupon->amount.'%';
		}else{
		    $coupon_value = '€'.$coupon->amount;
		}

		$variable['coupon_amount'] = $coupon_value;
		$variable['coupon_used'] = $coupon->voucher_name;
	}
	
	if(!empty($order->loyalty_points)){
		$variable['loyalty_points_used'] = $order->loyalty_points;
		$variable['loyalty_points_amount'] = $order->loyalty_points_amount;
		
	}
        
        
        $body = self::getBody($option, $variable);
        
        
        
        //$subject = 'Appointment Modified';
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_appointment_modified', $language);;
        
        $subvariable = [];
        $subvariable['merchant_name'] = $order->merchant->service_name;
        
        $subject = self::getBody($subject, $subvariable);
        
        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_appointment_modified', 'email_tpl_admin_appointment_modified', $variable, $email_provider);
        
        
        
        if($email_provider == 0){
            self::sendPhpEmail($order->client_email, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($order->client_email, $subject, $body);
        }

    }


    
    public static function newAppointment($order){
        $language = $order->merchant->language->code;
        $option = \frontend\models\Option::getValByName('email_tpl_customer_appointment', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        $variable = [];
        $variable['first_name'] = $order->client_name;
        $variable['last_name'] = "";
        $variable['merchant_name'] = $order->merchant->service_name;
        $variable['merchant_address'] = $order->merchant->address;
        $variable['booked_service'] = $order->category->title;
        $variable['staff_member'] = $order->staff->name;
        $variable['booked_seats'] = $order->no_of_seats;
        $variable['startdate'] = date('Y-m-d', strtotime($order->order_time));
        $variable['starttime'] = date('H:i:s', strtotime($order->order_time));
        $variable['endtime'] = date('H:i:s', strtotime("+{$order->category->time_in_minutes} minutes", strtotime($order->order_time)));
        $variable['booking_total'] = $order->price;
	
	$variable['coupon_amount'] = "";
	$variable['coupon_used'] = "";
	
	$variable['loyalty_points_used'] = "";
	$variable['loyalty_points_amount'] = "";
	
	$variable['admin_logo'] = self::adminLogo();
	$variable['merchant_logo'] = self::merchantLogo($order->merchant);
	
	if(!empty($order->voucher_id)){
		$coupon = \common\models\Voucher::findOne(['voucher_id' => $order->voucher_id]);
		if($coupon->voucher_type == 1){
		    $coupon_value = $coupon->amount.'%';
		}else{
		    $coupon_value = '€'.$coupon->amount;
		}

		$variable['coupon_amount'] = $coupon_value;
		$variable['coupon_used'] = $coupon->voucher_name;
	}
	
	if(!empty($order->loyalty_points)){
		$variable['loyalty_points_used'] = $order->loyalty_points;
		$variable['loyalty_points_amount'] = $order->loyalty_points_amount;
		
	}
        $variable['currency_code'] = \common\components\Helper::getCurrencyCode($order->merchant);
        
        $body = self::getBody($option, $variable);
        
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_appointment', $language);;
        
        $subvariable = [];
        $subvariable['merchant_name'] = $order->merchant->service_name;
        
        $subject = self::getBody($subject, $subvariable);
        
        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_new_appointment', 'email_tpl_admin_new_appointment', $variable, $email_provider);
        
        if($email_provider == 0){
            self::sendPhpEmail($order->client_email, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($order->client_email, $subject, $body);
        }

    }


    public static function passwordResetRequest($user){
        $language = $user->language->code;
        $option = \frontend\models\Option::getValByName('email_tpl_merchant_forgot_password', $language);
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        $variable = [];
        $variable['service_name'] = $user->service_name;
        $variable['link'] = Yii::$app->urlManager->createAbsoluteUrl(['login/reset-password', 'token' => $user->password_reset_token]);
        
        $body = self::getBody($option, $variable);
        
        
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_merchant_forgot_password', $language);;
        
        
        
        if($email_provider == 0){
            $email = self::sendPhpEmail($user->contact_email, $subject, $body);
        }else if($email_provider == 1){
            $email = self::sendSmtpEmail($user->contact_email, $subject, $body);
        }
        
         return $email;
    }
    
    
    
    public static function customerAccountActivate($customer, $merchantId = NULL){
        
        $option = \frontend\models\Option::getValByName('email_tpl_customer_user_welcome_activation');
        
        $email_provider = \frontend\models\Option::getValByName('email_provider');
        $variable = [];
        $variable['first_name'] = $customer->first_name;
        $variable['last_name'] = $customer->last_name;
        $variable['activation_key'] = $customer->activation_key;
        $variable['password'] = $customer->password;
	$variable['site_link'] = self::SiteLink();
	
	$variable['merchant_name'] = "";
		
	if(!empty($merchantId)){
		$merchant = \frontend\models\MtMerchant::findOne(['merchant_id' => $merchantId]);
		$variable['merchant_name'] = $merchant->service_name;

	}
        
        $body = self::getBody($option, $variable);
        
        $subject = 'Account Activation.';
        
        $subject = \frontend\models\Option::getValByName('email_tpl_sub_customer_user_welcome_activation', $language);;
        
        $adminEmail = self::adminSendEmail('email_tpl_sub_admin_new_customer_register', 'email_tpl_admin_new_customer_register', $variable, $email_provider);
        
        if($email_provider == 0){
            self::sendPhpEmail($customer, $subject, $body);
        }else if($email_provider == 1){
            self::sendSmtpEmail($customer, $subject, $body);
        }
        
        
    }
    
    public static function getBody($option, $variable){
        
        foreach($variable as $key => $value)
        {
                //print_r($value);
                $option = str_replace('{'.$key.'}', $value, $option);
        }
        
        return $option;
        
    }
    
    public static function sendPhpEmail($emailAddress, $subject, $body ){
        $headers = "From: appointmentapp.com<www-data@appointmentapp>\r\n";
        $headers .= "To: " . strip_tags($emailAddress) . " <" . $emailAddress . ">\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
        
        
        
        $email = @mail($emailAddress, $subject, $body, $headers);
        
        return $email;
        
	   
    }
    
    public static function sendSmtpEmail($emailAddress, $subject, $body ){
        
        $smtpHost = \frontend\models\Option::getValByName('smtp_host');
        $smtpPort = \frontend\models\Option::getValByName('smtp_port');
        $smtpUsername = \frontend\models\Option::getValByName('smtp_username');
        $smtpPassword = \frontend\models\Option::getValByName('smtp_password');
        
        $smtp = new \yii\swiftmailer\Mailer;
        $smtp->transport = [
            
            'class' => 'Swift_SmtpTransport',
            'host' => $smtpHost,
            'username' => $smtpUsername,
            'password' => $smtpPassword,
            'port' => $smtpPort,
            'encryption' => 'tls',
            
            
        ];
        
        $email = $smtp->compose()
        ->setFrom('noreply@aondego.com')
        ->setTo($emailAddress)
        ->setSubject($subject)
        ->setHtmlBody($body)
        ->send();
        
        
        
        return $email;
        
                

        
        
    }
    
	public static function adminLogo(){
		return Yii::$app->getRequest()->getHostInfo().'/img/logo-sign-210-grey.png';
	}
	
	public static function merchantLogo($model){
		
		$image = \Yii::getAlias('@webroot').'/upload/merchant/'.$model->merchant_id.'.jpg';
        
        
		if(file_exists($image))
			return Yii::$app->getRequest()->getHostInfo().Yii::$app->urlManager->baseUrl.'/upload/merchant/'.$model->merchant_id.'.jpg';
		else
			return Yii::$app->getRequest()->getHostInfo().'/img/logo-sign-210.png';
	}
    
}

