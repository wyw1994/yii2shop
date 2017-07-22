<?php
/**
 * Created by PhpStorm.
 * User: love5
 * Date: 2017/7/21
 * Time: 16:15
 */
namespace backend\models;

use creocoder\nestedsets\NestedSetsQueryBehavior;

 class GoodsCategoryQuery extends \yii\db\ActiveQuery{
     public function behaviors() {
         return [
             NestedSetsQueryBehavior::className(),
         ];
     }
 }