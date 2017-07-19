<?php
/**
 * Created by PhpStorm.
 * User: love5
 * Date: 2017/7/18
 * Time: 19:38
 */
namespace backend\controllers;
use yii\web\Controller;

use backend\models\Article;
use yii\web\Request;
use yii\web\UploadedFile;
class ArticleController extends Controller{
    public function actionIndex()
    {
        $data = Article::find()->where('status>-1')->all();
        return $this->render('index',['data'=>$data]);
    }
    public function actionAdd(){
        $request = new Request();
        $model = new Article();
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
                return $this->redirect(['article/index']);
            }else{
                //验证失败 打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model]);
    }
    public function actionDel(){
        $id = $_GET['id'];
        $model = Article::findOne(['id'=>$id]);
        $model->status = '-1';
        //var_dump($id);exit;
        $model->save();
        return $this->redirect(['article/index']);
    }
    public function actionRecycle(){
        $data = Article::find()->where('status=-1')->all();
        return $this->render('index',['data'=>$data]);
    }
    public function actionRestore(){
        $id = $_GET['id'];
        $model = Article::findOne(['id'=>$id]);
        $model->status = '0';
        //var_dump($id);exit;
        $model->save();
        return $this->redirect(['article/index']);
    }
    public function actionEdit(){
        $request = new Request();
        $id = $_GET['id'];
        $model = Article::findOne(['id'=>$id]);
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
                return $this->redirect(['Article/index']);
            }else{
                //验证失败 打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('edit',['model'=>$model]);
    }
}