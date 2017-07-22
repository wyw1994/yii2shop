<?php
/**
 * Created by PhpStorm.
 * User: love5
 * Date: 2017/7/18
 * Time: 19:38
 */
namespace backend\controllers;
use backend\models\Article;
use backend\models\ArticleDetail;
use yii\web\Controller;

use backend\models\Article_category;
use yii\web\Request;
use yii\web\UploadedFile;
class ArticleController extends Controller{

    //列表展示
    public function actionIndex()
    {
        $data = Article::find()->where('status>-1')->all();

        return $this->render('index',['data'=>$data]);
    }
    //详情
    public function actionDetail(){

        $id = $_GET['id'];
        $data = Article::findOne(['id'=>$id]);
        $content = ArticleDetail::findOne(['article_id'=>$id]);

        return $this->render('detail',['data'=>$data,'content'=>$content]);
    }
    //分类添加
    public function actionAdd(){
        $request = new Request();
        $model = new Article();
        $content = new ArticleDetail();
        //var_dump($request->isPost);exit;
        //$model->imgFile = UploadedFile::getInstance($model,'imgFile');
        if($request->isPost) {
            $model->load($request->post());
            $content->load($request->post());
            if ($model->validate()) {
                /*if ($model->imgFile) {
                    $path = \Yii::getAlias('@webroot') . '/upload/' . date('Ymd');
                    if (!is_dir($path)) {
                        mkdir($path);
                    }
                    $filename = '/upload/' . date('Ymd') . '/' . uniqid() . '.' . $model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot') . $filename, false);
                    $model->logo = $filename;
                }*/
                $model->save();
                //var_dump($model->id);exit;
                $content->article_id = $model->id;
                $content->save();
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['article/index']);
            }else{
                //验证失败 打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add',['model'=>$model,'content'=>$content]);
    }
    //删除
    public function actionDel(){
        $id = $_GET['id'];
        $model = Article::findOne(['id'=>$id]);
        $model->status = '-1';
        //var_dump($id);exit;
        $model->save();
        return $this->redirect(['article/index']);
    }
    //回收站展示
    public function actionRecycle(){
        $data = Article::find()->where('status=-1')->all();
        return $this->render('index',['data'=>$data]);
    }
    //恢复回收站,默认恢复为 隐藏
    public function actionRestore(){
        $id = $_GET['id'];
        $model = Article::findOne(['id'=>$id]);
        $model->status = '0';
        //var_dump($id);exit;
        $model->save();
        return $this->redirect(['article/index']);
    }
    //修改
    public function actionEdit(){
        $request = new Request();
        $id = $_GET['id'];
        $model = Article::findOne(['id'=>$id]);
        $content = ArticleDetail::findOne(['article_id'=>$id]);
        // $model->imgFile = UploadedFile::getInstance($model,'imgFile');
        if($request->isPost) {
            $model->load($request->post());
            $content->load($request->post());
            if ($model->validate() && $content->validate()) {
                /* if ($model->imgFile) {
                     $path = \Yii::getAlias('@webroot') . '/upload/' . date('Ymd');
                     if (!is_dir($path)) {
                         mkdir($path);
                     }
                     $filename = '/upload/' . date('Ymd') . '/' . uniqid() . '.' . $model->imgFile->extension;
                     $model->imgFile->saveAs(\Yii::getAlias('@webroot') . $filename, false);
                     $model->logo = $filename;
                 }*/
                $model->save();
                $content->save();
                \Yii::$app->session->setFlash('success', '更新成功');
                return $this->redirect(['article/index']);
            }else{
                //验证失败 打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('edit',['model'=>$model,'content'=>$content]);
    }
























    //列表展示
    public function actionCategory()
    {
        $data = Article_category::find()->where('status>-1')->all();

        return $this->render('category',['data'=>$data]);
    }
    //分类添加
    public function actionAddCategory(){
        $request = new Request();
        $model = new Article_category();
        //var_dump($request->isPost);exit;
        //$model->imgFile = UploadedFile::getInstance($model,'imgFile');
        if($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                /*if ($model->imgFile) {
                    $path = \Yii::getAlias('@webroot') . '/upload/' . date('Ymd');
                    if (!is_dir($path)) {
                        mkdir($path);
                    }
                    $filename = '/upload/' . date('Ymd') . '/' . uniqid() . '.' . $model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot') . $filename, false);
                    $model->logo = $filename;
                }*/
                $model->save();
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['article/category']);
            }else{
                //验证失败 打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('add_category',['model'=>$model]);
    }
    //删除
    public function actionDelCategory(){
        $id = $_GET['id'];
        $model = Article_category::findOne(['id'=>$id]);
        $model->status = '-1';
        //var_dump($id);exit;
        $model->save();
        return $this->redirect(['article/category']);
    }
    //回收站展示
    public function actionRecycleCategory(){
        $data = Article_category::find()->where('status=-1')->all();
        return $this->render('category',['data'=>$data]);
    }
    //恢复回收站,默认恢复为 隐藏
    public function actionRestoreCategory(){
        $id = $_GET['id'];
        $model = Article_category::findOne(['id'=>$id]);
        $model->status = '0';
        //var_dump($id);exit;
        $model->save();
        return $this->redirect(['article/category']);
    }
    //修改
    public function actionEditCategory(){
        $request = new Request();
        $id = $_GET['id'];
        $model = Article_category::findOne(['id'=>$id]);
       // $model->imgFile = UploadedFile::getInstance($model,'imgFile');
        if($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
               /* if ($model->imgFile) {
                    $path = \Yii::getAlias('@webroot') . '/upload/' . date('Ymd');
                    if (!is_dir($path)) {
                        mkdir($path);
                    }
                    $filename = '/upload/' . date('Ymd') . '/' . uniqid() . '.' . $model->imgFile->extension;
                    $model->imgFile->saveAs(\Yii::getAlias('@webroot') . $filename, false);
                    $model->logo = $filename;
                }*/
                $model->save();
                \Yii::$app->session->setFlash('success', '更新成功');
                return $this->redirect(['article/category']);
            }else{
                //验证失败 打印错误信息
                var_dump($model->getErrors());exit;
            }
        }
        return $this->render('edit_category',['model'=>$model]);
    }
}