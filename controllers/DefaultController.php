<?php
namespace merchant\controllers;

class DefaultController extends Controller
{
	public function actionIndex()
	{
		return $this->render('index');
	}
}