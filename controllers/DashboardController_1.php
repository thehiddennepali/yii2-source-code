<?php
/**
 * Created by PhpStorm.
 * User: Strafun Dmytro <strafun.web@gmail.com>
 * Date: 24-Jan-16
 * Time: 20:29
 */

class DashboardController extends MerchantController {

    public function init(){
        $this->menu = false;
    }

    public function actionIndex()
    {
        
        $sales =  2;
        if(isset($_GET['sales'])){
            $sales = $_GET['sales'];
        }

        $this->render('index', array(
            'sales' => $sales
        ));
    }

} 