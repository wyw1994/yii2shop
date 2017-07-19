<?php
/**
 * Created by PhpStorm.
 * User: love5
 * Date: 2017/7/18
 * Time: 18:01
 */
namespace backend\controllers;
use backend\models\Recycle;
use yii\web\Controller;

class BrandRecycle extends Controller{
    public function actionIndex(){
        $data = Recycle::find();
    }
}