<?php

namespace merchant\components;

use Yii;

/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 21-Jan-16
 * Time: 20:22
 */
class MerchantHelper {

	private static $_options = null;
	
	static $dateFormat = [
	    
		'dd-mm-yyyy'=>"dd-mm-yyyy - default",
		'yyyy-mm-dd'=>"yyyy-mm-dd",
		//'d/m/yy'=>"d/m/yy",
		//'d/m/yyyy'=>"d/m/yyyy",
		
	    
	];
	
	static $timeFormat = [
		'24'=> "24 hour format",
		'12'=> "12 hour format",
	];


	public static function getTimeZone(){

		$tzlist = \DateTimeZone::listIdentifiers(\DateTimeZone::ALL);

		return $tzlist;
	}
	
	
	

	public static function merchantMenu() {
        return array(
            'activeCssClass' => 'active',
            'options' => ['class' => 'sidebar-menu'],
            //'itemOptions'=>array('class'=>'treeview '),
            'encodeLabels' => false,
            'items' => array(
                array('visible' => self::hasMerchantAccess("DashBoard"),
                    'active' => Yii::$app->controller->id == 'dashboard',
                    'tag' => "DashBoard",
                    'label' => '<i class="fa fa-home"></i>' . Yii::t("basicfield", "Dashboard"),
                    'url' => array('/dashboard')),
                array(
                    'label' => '<i class="fa fa-gears"></i>' . Yii::t("basicfield", "Merchant Section") . '<i class="fa fa-angle-left pull-right"></i>',
                    'options' => array('class' => ' ' . (in_array(Yii::$app->controller->action->id, ['index', 'additional', 'username', 'social', 'gallery', 'admin', 'index', 'setting']) && Yii::$app->controller->id == 'merchant-edit' ? 'active' : '')),
                    'url' => '#',
                    'visible' => Yii::$app->user->identity->role,
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('visible' => self::hasMerchantAccess("Merchant"), 'active' => Yii::$app->controller->action->id == 'index' && Yii::$app->controller->id == 'merchant-edit', 'tag' => "Merchant Main Info", 'label' => '<i class="fa fa-child"></i>' . Yii::t("basicfield", "Merchant Main Info"),
                            'url' => array('/merchant-edit')),
                        array('visible' => self::hasMerchantAccess("Merchant"), 'active' => Yii::$app->controller->action->id == 'additional', 'tag' => "Merchant Additional Info", 'label' => '<i class="fa fa-level-up"></i>' . Yii::t("basicfield", "Merchant Additional Info"),
                            'url' => array('/merchant-edit/additional')),
                        array('visible' => self::hasMerchantAccess("Merchant"), 'active' => Yii::$app->controller->action->id == 'username', 'tag' => "Username and Passwords", 'label' => '<i class="fa fa-key"></i>' . Yii::t("basicfield", "Username and Passwords"),
                            'url' => array('/merchant-edit/username')),
                        array('visible' => self::hasMerchantAccess("Merchant"), 'active' => Yii::$app->controller->action->id == 'social', 'tag' => "Social links", 'label' => '<i class="fa fa-share-alt-square"></i>' . Yii::t("basicfield", "Social links"),
                            'url' => array('/merchant-edit/social')),
                        array('visible' => self::hasMerchantAccess("Merchant"), 'active' => Yii::$app->controller->action->id == 'gallery', 'tag' => "Gallery", 'label' => '<i class="fa fa-file-image-o"></i>' . Yii::t("basicfield", "Gallery"),
                            'url' => array('/merchant-edit/gallery')),
                        array('visible' => self::hasMerchantAccess("Merchant"), 'active' => Yii::$app->controller->action->id == 'admin', 'tag' => "Administration info", 'label' => '<i class="fa fa-eye"></i>' . Yii::t("basicfield", "Administration info"),
                            'url' => array('/merchant-edit/admin')),
			array('visible' => self::hasMerchantAccess("Merchant"), 'active' => Yii::$app->controller->action->id == 'setting', 'tag' => "Administration Setting", 'label' => '<i class="fa fa-eye"></i>' . Yii::t("basicfield", "Administration Setting"),
                            'url' => array('/merchant-edit/setting')),
			
			array('visible' => self::hasMerchantAccess("merchant-appointment-cancel-setup"), 'active' => Yii::$app->controller->id == 'merchant-appointment-cancel-setup', 'tag' => "Appointment Cancel Setup", 'label' => '<i class="fa fa-calendar-plus-o"></i>' . Yii::t("basicfield", "Appointment Cancel Setup"),
                            'url' => array('/merchant-appointment-cancel-setup')),
                    ),
                ),
                array(
                    'label' => '<i class="fa fa-pie-chart"></i>' . Yii::t("basicfield", "Schedule Section") . '<i class="fa fa-angle-left pull-right"></i>',
                    'options' => array('class' => 'treeview ' . (in_array(Yii::$app->controller->action->id, ['schedule', 'eschedule', 'escheduleh']) || in_array(Yii::$app->controller->id, ['schedule-days-template', 'group-schedule-days-template']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('visible' => self::hasMerchantAccess("Merchant"), 'active' => Yii::$app->controller->action->id == 'schedule', 'tag' => "Merchant Schedule", 'label' => '<i class="fa fa-calendar"></i>' . Yii::t("basicfield", "Merchant Schedule"),
                            'url' => array('/merchant-edit/schedule')),
                        array('visible' => self::hasMerchantAccess("Merchant"), 'active' => Yii::$app->controller->action->id == 'eschedule', 'tag' => "Merchant Extra Schedule", 'label' => '<i class="fa fa-calendar-check-o"></i>' . Yii::t("basicfield", "Merchant Extra Schedule"),
                            'url' => array('/merchant-edit/eschedule')),
                        array('visible' => self::hasMerchantAccess("Merchant"), 'active' => Yii::$app->controller->action->id == 'escheduleh', 'tag' => "Merchant Extra Schedule History", 'label' => '<i class="fa fa-calendar-minus-o"></i>' . Yii::t("basicfield", "Merchant Extra Schedule  History"),
                            'url' => array('/merchant-edit/escheduleh')),
                        array('visible' => self::hasMerchantAccess("ScheduleDaysTemplate"), 'active' => Yii::$app->controller->id == 'schedule-days-template', 'tag' => "Schedule Days Template", 'label' => '<i class="fa fa-calendar-o"></i>' . Yii::t("basicfield", "Schedule Days Template"),
                            'url' => array('/schedule-days-template')),
                        array('visible' => self::hasMerchantAccess("GroupScheduleDaysTemplate"), 'active' => Yii::$app->controller->id == 'group-schedule-days-template', 'tag' => "Group Schedule Days Template", 'label' => '<i class="fa fa-calendar-plus-o"></i>' . Yii::t("basicfield", "Group Schedule Days Template"),
                            'url' => array('/group-schedule-days-template')),
			
                    )
                ),
                array(
                    'label' => '<i class="fa fa-cube"></i>' . Yii::t("basicfield", "Service Section") . '<i class="fa fa-angle-left pull-right"></i>',
                    'options' => array('class' => 'treeview ' . (in_array(Yii::$app->controller->id, ['service-subcategory', 'service-subcategory-group', 'addon']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('visible' => self::hasMerchantAccess("ServiceSubcategory"), 'active' => Yii::$app->controller->id == 'service-subcategory', 'tag' => "My Single Services", 'label' => '<i class="fa fa-bookmark"></i>' . Yii::t("basicfield", "My Single Services"),
                            'url' => array('/service-subcategory')),
                        array('visible' => self::hasMerchantAccess("ServiceSubcategoryGroup"), 'active' => Yii::$app->controller->id == 'service-subcategory-group', 'tag' => "ServiceSubcategoryGroup", 'label' => '<i class="fa fa-bookmark-o"></i>' . Yii::t("basicfield", "My Group Services"),
                            'url' => array('/service-subcategory-group')),
                        array('visible' => self::hasMerchantAccess("Addon"), 'tag' => "Addon", 'active' => Yii::$app->controller->id == 'addon', 'label' => '<i class="fa fa-plus"></i>' . Yii::t("basicfield", "Addon"),
                            'url' => array('/addon')),
                    ),
                ),
                array(
                    'label' => '<i class="fa fa-black-tie"></i>' . Yii::t("basicfield", "Staff Section"), '<i class="fa fa-angle-left pull-right"></i>',
                    'options' => array('class' => 'treeview ' . ((Yii::$app->controller->id == 'staff') ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('visible' => self::hasMerchantAccess("Staff"), 'active' => (Yii::$app->controller->id == 'staff') && (Yii::$app->controller->action->id == 'index'), 'tag' => "Staff", 'label' => '<i class="fa fa-heart"></i>' . Yii::t("basicfield", "Staff"),
                            'url' => array('/staff')),
                        array('visible' => self::hasMerchantAccess("ScheduleHistory"), 'active' => (Yii::$app->controller->id == 'staff') && (Yii::$app->controller->action->id == 'schedule-history'), 'tag' => "Staff", 'label' => '<i class="fa fa-calendar-minus-o"></i>' . Yii::t("basicfield", "Schedule and Vacation History"),
                            'url' => array('staff/schedule-history')),
                    )
                ),
                array('visible' => self::hasMerchantAccess("tablebook"), 'active' => Yii::$app->controller->action->id == 'index' && Yii::$app->controller->id == 'table-booking', 'tag' => "tablebook", 'label' => '<i class="fa fa-pie-chart"></i>' . Yii::t("basicfield", "Table Booking"),
                    'url' => array('/table-booking')),
                array('visible' => self::hasMerchantAccess("orders"), 'active' => Yii::$app->controller->id == 'order', 'tag' => "orders", 'label' => '<i class="fa fa-cart-plus"></i>' . Yii::t("basicfield", "Orders"),
                    'url' => array('/order')),
		
		array(
                    'label' => '<i class="fa fa-gift"></i>' . Yii::t("basicfield", "Gift Voucher") . '<i class="fa fa-angle-left pull-right"></i>',
                    'options' => array('class' => 'treeview ' . ((Yii::$app->controller->id == 'gift-voucher'  || Yii::$app->controller->id == 'gift-voucher-setting')? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('visible' => self::hasMerchantAccess("gift-voucher"), 'active' => (Yii::$app->controller->id == 'gift-voucher' && Yii::$app->controller->action->id == 'sales'), 'tag' => "orders",
                            'label' => '<i class="fa fa-list"></i>' . Yii::t("basicfield", "Voucher Sales"),
                            'url' => array('/gift-voucher/sales')),
                        array('visible' => self::hasMerchantAccess("gift-voucher"), 'active' => (Yii::$app->controller->id == 'gift-voucher' && Yii::$app->controller->action->id == 'index'), 'tag' => "orders",
                            'label' => '<i class="fa fa-folder"></i>' . Yii::t("basicfield", "Voucher Type"),
                            'url' => array('/gift-voucher')),
			array('visible' => self::hasMerchantAccess("gift-voucher-setting"), 'active' => (Yii::$app->controller->id == 'gift-voucher-setting' && Yii::$app->controller->action->id == 'index'), 'tag' => "gift-voucher-setting",
                            'label' => '<i class="fa fa-wrench"></i>' . Yii::t("basicfield", "Voucher Setting"),
                            'url' => array('/gift-voucher-setting')),
                        
                    ),
                ),
		
                array(
                    'label' => '<i class="fa fa-puzzle-piece"></i>' . Yii::t("basicfield", "Marketing Section") . '<i class="fa fa-angle-left pull-right"></i>',
                    'options' => array('class' => 'treeview ' . (in_array(Yii::$app->controller->id, ['voucher', 'loyalty-points', 'review']) ? 'active' : '')),
                    'url' => '#',
                    'submenuOptions' => array('class' => 'treeview-menu'),
                    'items' => array(
                        array('visible' => self::hasMerchantAccess("voucher"), 'active' => Yii::$app->controller->id == 'voucher', 'tag' => "orders",
                            'label' => '<i class="fa fa-bolt  "></i>' . Yii::t("basicfield", "Coupons"),
                            'url' => array('/voucher')),
                        array('visible' => self::hasMerchantAccess("voucher"), 'active' => Yii::$app->controller->id == 'voucher', 'tag' => "orders",
                            'label' => '<i class="fa fa-bolt  "></i>' . Yii::t("basicfield", "Birthday Coupons"),
                            'url' => array('/birthday-coupons')),
                        array('visible' => self::hasMerchantAccess("loyalty-points"), 'active' => Yii::$app->controller->id == 'loyalty-points', 'tag' => "loyalty-points", 'label' => '<i class="fa fa-thumbs-o-up"></i>' . Yii::t("basicfield", "Loyalty Points"),
                            'url' => array('/loyalty-points')),
                        array('visible' => self::hasMerchantAccess("review"), 'active' => Yii::$app->controller->id == 'review', 'tag' => "review", 'label' => '<i class="fa fa-star-half-o"></i>' . Yii::t("basicfield", "Customer reviews"),
                            'url' => array('/review')),
                    ),
                ),
                array('visible' => Yii::$app->user->identity->role, 'active' => Yii::$app->controller->action->id == 'payment', 'tag' => "PayPal settings", 'label' => '<i class="fa fa-paypal"></i>' . Yii::t("basicfield", "PayPal settings"),
                    'url' => array('/merchant-edit/payment')),
                array('visible' => Yii::$app->user->identity->role, 'active' => Yii::$app->controller->action->id == 'messagebird', 'tag' => "SMS settings", 'label' => '<i class="fa fa-dashboard"></i>' . Yii::t("basicfield", "Messagebird settings"),
                    'url' => array('/messagebird-details/index')),
                array('tag' => "Help",
                    'label' => '<i class="fa fa-question-circle"></i>' . Yii::t("basicfield", "Help"),
                    'linkOptions' => array('target' => '_blank'),
                    'template'=> '<a href="{url}" target="_blank">{label}</a>',
                    'url' => 'http://help.aondego.de/'),
                array('tag' => "Client Center",
                    'label' => '<i class="fa fa-info-circle"></i>' . Yii::t("basicfield", "Client Center"),
                    'linkOptions' => array('target' => '_blank'),
                    'template'=> '<a href="{url}" target="_blank">{label}</a>',
                    'url' => 'http://kundencenter.aondego.de/clients/login'),
                array('tag' => "logout", 'label' => '<i class="fa fa-sign-out"></i>' . Yii::t("basicfield", "Logout"),
                    'url' => array('/login/logout')),
            ),
            'submenuTemplate' => "\n<ul class='treeview-menu' role='menu'>\n{items}\n</ul>\n",
        );
    }

    /** NEW CODE ADDED FOR VERSION 2.1.1 */
    public static function hasMerchantAccess($tag = '') {
        
        return true;
        if (Yii::app()->user->identity->role) return true;
        $merchPermit = [];
        if (in_array($tag, $merchPermit)) return true;
        return false;
    }

    public static function getOptionAdmin($option_name = '') {

        if (is_null(self::$_options)) {
            $models = Option::model()->findAll(['select' => 'option_name, option_value']);
            if ($models) {
                self::$_options = CHtml::listData($models, 'option_name', 'option_value');
            }
        }
        return isset(self::$_options[$option_name]) ? self::$_options[$option_name] : '';
    }

    public static function getMerchantInfo() {
        return Yii::$app->user->model;
    }

    public static function allActions() {
        $data = [0 => 'autologin',
            1 => 'dashboard',
            2 => 'merchant',
            4 => 'packages',
            5 => 'serviceCategory',
            6 => 'serviceSubcategory',
            7 => 'orderStatus',
            8 => 'settings',
            10 => 'commisionsettings',
            11 => 'voucherNew',
            12 => 'merchantcommission',
            16 => 'emailsettings',
            17 => 'emailtpl',
            18 => 'customPage',
            19 => 'ratings',
            20 => 'contactSettings',
            21 => 'socialSettings',
            23 => 'manageLanguage',
            24 => 'seo',
            28 => 'client',
            29 => 'newsletter',
            30 => 'review',
            34 => 'paypalSettings',
            42 => 'paymentProvider',
            56 => 'reports',
            57 => 'rptMerchantReg',
            58 => 'rptMerchantPayment',
            59 => 'rptMerchanteSales',
            60 => 'rptmerchantsalesummary',
            62 => 'adminUser'
        ];
        return array_combine($data, $data);
    }

    public static function clientStatus() {
        return array(
            'pending' => Yii::t("basicfield", 'pending for approval'),
            'active' => Yii::t("basicfield", 'active'),
            'suspended' => Yii::t("basicfield", 'suspended'),
            'blocked' => Yii::t("basicfield", 'blocked'),
            'expired' => Yii::t("basicfield", 'expired')
        );
    }

    public static function getMerchantMembershipType() {
        return Yii::$app->user->model->is_commission;
    }

}
