<?php
// 申明命名空间
namespace Program\Models;
// 引用类
use Abstracts\DbModel;
use Helper\Exception;
use UploadFile;
use UploadManager;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-15
 * Version      :   1.0
 *
 * This is the model class for table "pub_block_option".
 * The followings are the available columns in table 'pub_block_option':
 *
 * @property integer id
 * @property string key
 * @property string label
 * @property string link
 * @property string src
 * @property integer sort_order
 * @property integer is_open
 * @property integer is_enable
 * @property string description
 * @property string create_time
 * @property string update_time
 */
class BlockOption extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|BlockOption
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
        return 'pub_block_option';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['sort_order, is_open, is_enable', 'required'],
            ['sort_order, is_open, is_enable', 'numerical', 'integerOnly' => true],
            ['key, label, link, src, description', 'string', 'maxLength' => 255],
            ['create_time, update_time', 'safe'],
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
            'id' => '自增ID',
            'key' => '所属区块标识',
            'label' => '链接显示名称',
            'link' => '链接地址',
            'src' => '图片地址',
            'sort_order' => '排序',
            'is_open' => '是否对管理开放',
            'is_enable' => '是否启用发布显示',
            'description' => '描述',
            'create_time' => '创建时间',
            'update_time' => '更新时间',
        ];
    }

    /**
     * 在数据保存之前执行
     * @return bool
     * @throws Exception
     */
    protected function beforeSave()
    {
        $upload = UploadFile::getInstance($this, 'src');
        if ($upload) {
            // 保存老信息
            $blockPath = UploadManager::getPath('block');
            if (!is_dir($blockPath)) {
                @mkdir($blockPath, 0777);
            }
            $old_file = $blockPath . DS . $this->src;
            $filename = $this->key . '_' . time() . '.' . $upload->getExtensionName();
            // 上传文件
            if (!$upload->saveAs($blockPath . DS . $filename)) {
                throw new Exception('上传图像错误，请联系管理员');
            }
            // 保存信息
            $this->src = $filename;
            // 删除旧图片
            if (is_file($old_file)) {
                @unlink($old_file);
            }
        }
        return true;
    }

    /**
     * 在数据删除之后执行
     */
    protected function afterDelete()
    {
        $file = UploadManager::getPath('block') . DS . $this->src;
        if (is_file($file)) {
            @unlink($file);
        }
    }

    /**
     * 获取最终显示的图片链接
     * @return string|null
     */
    public function getImageSrc()
    {
        if ('' == $this->src) {
            return null;
        }
        return UploadManager::getUrl('block') . $this->src;
    }
}