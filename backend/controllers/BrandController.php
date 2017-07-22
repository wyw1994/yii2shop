<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\web\Request;
use yii\web\UploadedFile;
use flyok666\uploadifive\UploadAction;


class BrandController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $data = Brand::find()->where('status>-1')->all();
        return $this->render('index',['data'=>$data]);
    }
    public function actionAdd(){
        $request = new Request();
        $model = new Brand();
        //var_dump($request->isPost);exit;
        $model->imgFile = UploadedFile::getInstance($model,'imgFile');
        if($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                if ($model->imgFile) {
                    $path = \Yii::getAlias('@webroot') . '/upload/' . date('Ymd');
                    if (!is_dir($path)) {
                        mkdir($path);
                    }
                    $filename = '/upload/' . date('Ymd') . '/' . uniqid() . '.' . $model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot') . $filename, false);
                    $model->logo = $filename;
                }
                $model->save();
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['brand/index']);
            }else{
                //验证失败 打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionDel(){
        $id = $_GET['id'];
        $model = Brand::findOne(['id'=>$id]);
        $model->status = '-1';
        //var_dump($id);exit;
        $model->save();
        return $this->redirect(['brand/index']);
    }
    public function actionRecycle(){
        $data = Brand::find()->where('status=-1')->all();
        return $this->render('index',['data'=>$data]);
    }
    public function actionRestore(){
        $id = $_GET['id'];
        $model = Brand::findOne(['id'=>$id]);
        $model->status = '0';
        //var_dump($id);exit;
        $model->save();
        return $this->redirect(['brand/index']);
    }
    public function actionEdit(){
        $request = new Request();
        $id = $_GET['id'];
        $model = Brand::findOne(['id'=>$id]);
        $model->imgFile = UploadedFile::getInstance($model,'imgFile');
        if($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                if ($model->imgFile) {
                    $path = \Yii::getAlias('@webroot') . '/upload/' . date('Ymd');
                    if (!is_dir($path)) {
                        mkdir($path);
                    }
                    $filename = '/upload/' . date('Ymd') . '/' . uniqid() . '.' . $model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot') . $filename, false);
                    $model->logo = $filename;
                }
                $model->save();
                \Yii::$app->session->setFlash('success', '更新成功');
                return $this->redirect(['brand/index']);
            }else{
                //验证失败 打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('edit',['model'=>$model]);
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
                //'format' => [$this, 'methodName'],
                //END METHOD
                //BEGIN CLOSURE BY-HASH
                'overwriteIfExist' => true,//如果文件已存在，是否覆盖
                /* 'format' => function (UploadAction $action) {
                     $fileext = $action->uploadfile->getExtension();
                     $filename = sha1_file($action->uploadfile->tempName);
                     return "{$filename}.{$fileext}";
                 },*/
                //END CLOSURE BY-HASH
                //BEGIN CLOSURE BY TIME
                'format' => function (UploadAction $action) {
                    $fileext = $action->uploadfile->getExtension();
                    //$filehash = sha1(uniqid() . time());
                    $filehash = uniqid() ."_". time();
                    //$p1 = substr($filehash, 0, 2);
                    $p1 = date('Ym');
                    //$p2 = substr($filehash, 2, 2);
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
                    //$action->getFilename(); // "image/yyyymmddtimerand.jpg"
                    //$action->getWebUrl(); //  "baseUrl + filename, /upload/image/yyyymmddtimerand.jpg"
                    //$action->getSavePath(); // "/var/www/htdocs/upload/image/yyyymmddtimerand.jpg"
                    //将图片上传到七牛云
                    /*$qiniu = new Qiniu(\Yii::$app->params['qiniu']);
                    $qiniu->uploadFile(
                        $action->getSavePath(), $action->getWebUrl()
                    );
                    $url = $qiniu->getLink($action->getWebUrl());
                    $action->output['fileUrl']  = $url;*/
                },
            ],
        ];
    }
}
