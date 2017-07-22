<?php

namespace backend\controllers;

use backend\models\Goods;
use backend\models\GoodsCategory;
use backend\models\GoodsDayCount;
use backend\models\GoodsGallery;
use backend\models\GoodsIntro;
use flyok666\uploadifive\UploadAction;
use yii\web\HttpException;
use yii\web\Request;
use \kucha\ueditor\UEditor;
class GoodsController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $data = Goods::find()->all();
        return $this->render('index',['data'=>$data]);
    }
    public function actionAdd(){
        $model = new Goods();
        $content = new GoodsIntro();
        $categories = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        $request = new Request();
        $daycount = new GoodsDayCount();
        if($request->isPost){
            $model->load($request->post());
            $content->load($request->post());
            if ($model->validate()) {
                $count = GoodsDayCount::find()->where(['=','day',date('Y-m-d')])->count();
                if($count>0&&$count<10) {
                    $count='000'.($count+1);
                }elseif($count>=10&&$count<100){
                    $count='00'.($count+1);
                }elseif($count>=100&&$count<1000){
                    $count='0'.($count+1);
                }elseif($count>=1000&&$count<10000){
                    $count=$count+1;
                }



                $sn = "sn".date('Ymd').$count;
                //var_dump($sn);exit;

                $model->sn = $sn;
                $model->create_time = time();
                $model->save();
                if($model->save()){
                    $daycount->day = date('Y-m-d');
                    $daycount->count = $count;
                    $daycount->save();
                }
                $content->goods_id = $model->id;
                $content->save();
//                if(!$model->save()){
//                    var_dump($model->getErrors());exit;
//                    throw new HttpException('error');
//                }
                //var_dump($model);exit;
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['goods/index']);
            }else{
                //验证失败 打印错误信息
                var_dump($model->getErrors());exit;
            }

        }


        return $this->render('add',['model'=>$model,'content'=>$content,'categories'=>$categories]);
    }


    public function actionGallery(){
        $model = new GoodsGallery();
        return $this->render('add',['model'=>$model]);
    }

    public function actions() {
        return [
            's-upload' => [
                'class' => UploadAction::className(),
                'basePath' => '@webroot/upload',
                'baseUrl' => '@web/upload',
                'enableCsrf' => true, // default
                'postFieldName' => 'Filedata', // default
                //BEGIN METHOD
                'overwriteIfExist' => true,//如果文件已存在，是否覆盖
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    $filehash = uniqid() ."_". time();
                    $p1 = date('Ym');
                    $p2 = date('d');
                    return "{$p1}/{$p2}/{$filehash}.{$fileext}";
                },//文件的保存方式
                //END CLOSURE BY TIME
                'validateOptions' => [
                    'extensions' => ['jpg', 'png'],
                    'maxSize' => 1 * 1024 * 1024, //file size
                ],
                'beforeValidate' => function (UploadAction $action) {
                    //throw new Exception('test error');
                },
                'afterValidate' => function (UploadAction $action) {},
                'beforeSave' => function (UploadAction $action) {},
                'afterSave' => function (UploadAction $action) {
                    $action->output['fileUrl'] = $action->getWebUrl();//输出文件的相对路径
                },
            ],
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "{$_SERVER['HTTP_HOST']}",//图片访问路径前缀
                    "imagePathFormat" => "/upload/{yyyy}{mm}/{dd}/{rand:13}_{time}" ,//上传保存路径
                    "imageRoot" => \Yii::getAlias("@webroot"),
                ],

            ]

        ];
    }
    public function actionTest(){
        $count = GoodsDayCount::find()->where(['=','day',date('Y-m-d')])->count();
        var_dump($count);
    }
}
