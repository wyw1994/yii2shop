<?php
/**
 * Created by PhpStorm.
 * User: love5
 * Date: 2017/7/19
 * Time: 15:48
 */
//var_dump($content);exit;
$form = \yii\bootstrap\ActiveForm::begin();
//name	varchar(50)	名称
echo $form->field($model,'name');
//intro	text	简介
echo $form->field($model,'intro')->textarea();
//分类
echo $form->field($model,'article_category_id')->dropDownList(\backend\models\Article::getCategroyOptions());
//sort	int(11)	排序
echo $form->field($model,'sort');
//status	int(2)	状态(-1删除 0隐藏 1正常)
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Brand::getStatusOption());
echo  $form->field($content,'content')->textarea();
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();