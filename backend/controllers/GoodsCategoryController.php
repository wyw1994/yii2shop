<?php

namespace backend\controllers;

use backend\models\GoodsCategory;
use yii\web\HttpException;
use yii\web\Request;

class GoodsCategoryController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = GoodsCategory::find()->orderBy('tree ASC , lft ASC')->all();
        return $this->render('index',['data'=>$model]);
    }


    public function actionAdd1(){
        $model = new GoodsCategory();
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            if($model->parent_id){
                //不是一级分类
                $cat = GoodsCategory::findOne(['id'=>$model->parent_id]);

                if($cat){
                    $model->prependTo($cat);
                }else{
                    throw new HttpException(404,"上级分类不存在.");
                }
            }else{
                //一级分类
                $model->makeRoot();
            }
            \Yii::$app->session->setFlash('success','添加分类成功');
            return $this->redirect('/goods-category/index');
        }

        return $this->render('add',['model'=>$model]);
    }
     public function actionTest(){
        /*$cat = new GoodsCategory();
        $cat->name = "根节点";
         $cat->makeRoot();*/

        $cat2 = new GoodsCategory();
        $cat2->name = "家电";
        $countries = GoodsCategory::findOne(['id'=>1]);
         $cat2->prependTo($countries);
        echo "操作完成";
     }
    public function actionAdd()
    {
        $model = new GoodsCategory(['parent_id'=>0]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){
            //$model->save();
            //判断是否是添加一级分类
            if($model->parent_id){
                //非一级分类

                $category = GoodsCategory::findOne(['id'=>$model->parent_id]);
                if($category){
                    $model->prependTo($category);
                }else{
                    throw new HttpException(404,'上级分类不存在');
                }

            }else{
                //一级分类
                $model->makeRoot();
            }
            \Yii::$app->session->setFlash('success','分类添加成功');
            return $this->redirect(['add']);

        }
        //获取所以分类数据
        $categories = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        return $this->render('add',['model'=>$model,'categories'=>$categories]);
    }
    public function actionEdit(){
         $request = new Request();
         $id = $_GET['id'];
         $model = GoodsCategory::findOne(['id'=>$id]);
        if($model->load(\Yii::$app->request->post()) && $model->validate()){





        }
        //获取所以分类数据
        $categories = GoodsCategory::find()->select(['id','parent_id','name'])->asArray()->all();
        return $this->render('edit',['model'=>$model,'categories'=>$categories]);

    }
}
