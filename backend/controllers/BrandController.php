<?php

namespace backend\controllers;

use backend\models\Brand;
use yii\web\Request;
use yii\web\UploadedFile;


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
}
