<?php
/**
 * Created by PhpStorm.
 * User: love5
 * Date: 2017/7/22
 * Time: 11:08
 */
use yii\web\JsExpression;

$form = \yii\bootstrap\ActiveForm::begin();

    echo $form->field($model,'name');
   // echo $form->field($model,'goods_category_id')->dropDownList(\backend\models\Goods::getGoods_category_id());
echo $form->field($model,'goods_category_id')->hiddenInput();

    echo '<div>
        <ul id="treeDemo" class="ztree"></ul>
    </div>';
    echo $form->field($model,'brand_id')->dropDownList(\backend\models\Goods::getBrand_id());
    // 'logo' => 'LOGO图片',
    echo $form->field($model,'logo')->hiddenInput();
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
            $("#goods-logo").val(data.fileUrl);
            //将上传成功的图片回显
            $("#img").attr('src',data.fileUrl);
        }
    }
EOF
            ),
        ]
    ]);
    //回显图片
    echo \yii\bootstrap\Html::img($model->logo?$model->logo:false,['id'=>'img','height'=>50]);

//            'market_price' => '市场价格',
    echo $form->field($model,'market_price');
    //            'shop_price' => '商品价格',
    echo $form->field($model,'shop_price');
    //            'stock' => '库存',
    echo $form->field($model,'stock');
    //            'is_on_sale' => '是否在售(1在售 0下架)',
    echo $form->field($model,'is_on_sale',['inline'=>1])->radioList([1=>'正常',0=>'下架']);
    //            'status' => '状态(1正常 0回收站)',
    echo $form->field($model,'status',['inline'=>1])->radioList([1=>'正常',0=>'回收站']);
    //            'sort' => '排序',
    echo $form->field($model,'sort');
    echo $form->field($content, 'content')->widget(
    \kucha\ueditor\UEditor::className(),
    ['id'=>'content',
        'name'=>'content',
        'clientOptions' => [
            //编辑区域大小
            'initialFrameHeight' => '300',
        ]
    ]);

echo \yii\bootstrap\Html::submitButton('添加',['class'=>'btn btn-success']);

    \yii\bootstrap\ActiveForm::end();


$this->registerCssFile('@web/zTree/css/zTreeStyle/zTreeStyle.css');
//加载js文件
$this->registerJsFile('@web/zTree/js/jquery.ztree.core.js',['depends'=>\yii\web\JqueryAsset::className()]);

$categories[] = ['id'=>0,'parent_id'=>0,'name'=>'顶级分类','open'=>1];
$nodes = \yii\helpers\Json::encode($categories);
$this->registerJs(new \yii\web\JsExpression(
    <<<JS
var zTreeObj;
        // zTree 的参数配置，深入使用请参考 API 文档（setting 配置详解）
        var setting = {
            data: {
                simpleData: {
                    enable: true,
                    idKey: "id",
                    pIdKey: "parent_id",
                    rootPId: 0
                }
            },
            callback: {
		        onClick: function(event, treeId, treeNode){
		            //console.log(treeNode.id);
		            //将当期选中的分类的id，赋值给parent_id隐藏域
		            $("#goods-goods_category_id").val(treeNode.id);
		        }
	        }
        };
        // zTree 的数据属性，深入使用请参考 API 文档（zTreeNode 节点数据详解）
        var zNodes = {$nodes};
  
        zTreeObj = $.fn.zTree.init($("#treeDemo"), setting, zNodes);
        zTreeObj.expandAll(true);//展开全部节点

JS

));
?>

