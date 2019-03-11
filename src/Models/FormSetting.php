<?php
// 申明命名空间
namespace Program\Models;
// 引用类
use Abstracts\DbModel;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-07
 * Version      :   1.0
 *
 * This is the model class for table "pub_form_setting".
 * The followings are the available columns in table 'pub_form_setting':
 * 
 * @property string key
 * @property string content
 */
class FormSetting extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|FormSetting
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * 数据表名
     * @return string
     */
    public function tableName()
    {
        return 'pub_form_setting';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['key', 'string', 'maxLength' => 255],
            ['content', 'safe'],
        ];
    }

    /**
     * 数据表关联
     * @return array
     */
    public function relations()
    {
        return [];
    }

    /**
     * 获取属性标签（name=>label）
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'key' => '表单分类（来自form_category）',
            'content' => '表单配置项目值',
        ];
    }
}