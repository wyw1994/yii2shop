<?php
/**
 * Created by PhpStorm.
 * User: love5
 * Date: 2017/7/22
 * Time: 15:41
 */
use yii\web\JsExpression;
$form = \yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'photo')->hiddenInput();
echo \yii\bootstrap\Html::fileInput('test', NULL, ['id' => 'test']);
echo \flyok666\uploadifive\Uploadifive::widget([
    'url' => yii\helpers\Url::to(['goods/s-upload']),
    'id' => 'test',
    'csrf' => true,
    'renderTag' => false,
    'jsOptions' => [
        'formData'=>['someKey' => 'someValue'],
        'width' => 120,
        'height' => 40,
        'onError' => new JsExpression(<<<EOF
    function(file, errorCode, errorMsg, errorString) {
        console.log('The file ' + file.name + ' could not be uploaded: ' + errorString + errorCode + errorMsg);
    }
EOF
        ),
        'onUploadComplete' => new JsExpression(<<<EOF
    function(file, data, response) {
        data = JSON.parse(data);
        //console.log(data);
        if (data.error) {
            console.log(data.msg);
        } else {
            console.log(data.fileUrl);
            //将图片的地址赋值给logo字段
            $("#gallery-photo").val(data.fileUrl);
            //将上传成功的图片回显
            $("#img").attr('src',data.fileUrl);
        }
    }
EOF
        ),
    ]
]);
\yii\bootstrap\ActiveForm::end();
//回显图片
echo \yii\bootstrap\Html::img($model->logo?$model->logo:false,['id'=>'img','height'=>50]);