<?php
// 申明命名空间
namespace Program\Models;

// 引用类
use Abstracts\DbModel;
use DbSupports\Builder\Criteria;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-05-17
 * Version      :   1.0
 *
 * This is the model class for table "pub_header_category".
 * The followings are the available columns in table 'pub_header_category':
 *
 * @property string key
 * @property string name
 * @property string description
 * @property integer sort_order
 * @property integer is_open
 */
class HeaderCategory extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|HeaderCategory
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
        return 'pub_header_category';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['sort_order, is_open', 'required'],
            ['sort_order, is_open', 'numerical', 'integerOnly' => true],
            ['key, name', 'string', 'maxLength' => 100],
            ['description', 'string', 'maxLength' => 255],
            ['name', self::UNIQUE],
        ];
    }

    /**
     * 数据表关联
     * @return array
     */
    public function relations()
    {
        return [
            'subOptionCount' => [self::STAT, '\Program\Models\HeaderOption', 'key'],
        ];
    }

    /**
     * 获取属性标签（name=>label）
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'key' => '标志符',
            'name' => '别名',
            'description' => '描述',
            'sort_order' => '排序',
            'is_open' => '是否开放',
        ];
    }

    /**
     * 验证通过后执行
     * @throws \Exception
     */
    protected function afterValidate()
    {
        // 查询组件准备
        $criteria = new Criteria();
        if ($this->getIsNewRecord()) {
            // key 验证
            $cKey = clone $criteria;
            $cKey->addWhere('`key`=:key')
                ->addParam(':key', $this->key);
            if ($this->count($cKey) > 0) {
                $this->addError('key', "标识符{$this->key}已经存在");
            }
        } else {
            $criteria->addWhere('`key`!=:key')
                ->addParam(':key', $this->key);
        }
        // 标志验证
        $criteria->addWhere('`name`=:name')
            ->addParam(':name', $this->name);
        if ($this->count($criteria) > 0) {
            $this->addError('name', "别名{$this->name}已经存在");
        }
    }

    /**
     * 在数据删除之前执行
     * @return bool
     * @throws \Exception
     */
    protected function beforeDelete()
    {
        if ($this->getRelated('subOptionCount') > 0) {
            $this->addError('key', '还有子项目，不能删除');
            return false;
        }
        return true;
    }
}