<?php
/**
 * Created by PhpStorm.
 * User: love5
 * Date: 2017/7/18
 * Time: 15:29
 */
$form = \yii\bootstrap\ActiveForm::begin();
    //name	varchar(50)	名称
echo $form->field($model,'name');
//intro	text	简介
echo $form->field($model,'intro')->textarea();
//logo	varchar(255)	LOGO图片
//echo $form->field($model,'imgFile')->fileInput();
//sort	int(11)	排序
echo $form->field($model,'sort');
//status	int(2)	状态(-1删除 0隐藏 1正常)
echo $form->field($model,'status',['inline'=>true])->radioList(\backend\models\Brand::getStatusOption());
echo \yii\bootstrap\Html::submitButton('提交',['class'=>'btn btn-success']);
\yii\bootstrap\ActiveForm::end();