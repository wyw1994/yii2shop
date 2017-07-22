<?php
/**
 * Created by PhpStorm.
 * User: love5
 * Date: 2017/7/18
 * Time: 19:41
 */
namespace backend\models;
use yii\db\ActiveRecord;

class Article_category extends ActiveRecord{


    public static function getStatusOption($hidden=true){
        $option = [ -1=>'删除',0=>'隐藏',1=>'正常'];
        if($hidden){
            unset($option['-1']);
        }
        return $option;
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'article_category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['intro'], 'string'],
            [['sort', 'status'], 'integer'],
            [['name'], 'string', 'max' => 50],
            //[['logo'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => '标题',
            'intro' => '文章内容',
            //'logo' => 'LOGO',
            'sort' => '排序',
            'status' => '状态',
            //'imgFile' => 'LOGO',
        ];
    }

}