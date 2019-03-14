<?php
// 申明命名空间
namespace Program\Models;
// 引用类
use Abstracts\DbModel;
use Helper\Coding;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-13
 * Version      :   1.0
 *
 * This is the model class for table "pub_replace_setting".
 * The followings are the available columns in table 'pub_replace_setting':
 *
 * @property string key
 * @property string name
 * @property string description
 * @property string x_flag
 * @property string template
 * @property string content
 * @property integer sort_order
 * @property integer is_enable
 * @property string replace_type
 * @property string replace_fields
 */
class ReplaceSetting extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|ReplaceSetting
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
        return 'pub_replace_setting';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['sort_order, is_enable', 'required'],
            ['sort_order, is_enable', 'numerical', 'integerOnly' => true],
            ['key, name, description', 'string', 'maxLength' => 255],
            ['x_flag', 'string', 'maxLength' => 50],
            ['replace_type', 'multiIn', 'range' => ['system', 'login', 'client']],
            ['template, content, replace_fields', 'string'],
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
            'key' => '标识符',
            'name' => '名称',
            'description' => '内容描述',
            'x_flag' => '在线编辑器标识符',
            'template' => '默认模板',
            'content' => '模板',
            'sort_order' => '排序',
            'is_enable' => '启用状态',
            'replace_type' => '替换类型',
            'replace_fields' => '自定义字段集',
        ];
    }

    /**
     * 在数据保存之前执行
     * @return bool
     * todo
     */
    protected function beforeSave()
    {
        $updateAttributes = $this->getUpdatedAttributes();
        if (in_array('replace_type', $updateAttributes)) {
            $replace_type = $this->replace_type;
            if (is_array($replace_type)) {
                $this->replace_type = implode(',', $replace_type);
            }
        }
        if (in_array('template', $updateAttributes)) {
            $replace = [];
            $supportFields = $this->supportFields();
            foreach (explode(',', $this->replace_type) as $type) {
                if (isset($supportFields[$type])) {
                    $replace = array_merge($replace, $supportFields[$type]);
                }
            }
            $replace = array_flip($replace);
            $template = str_replace($replace, array_keys($replace), $this->template);
            if (preg_match_all('#\{\{(.*)\::(.*)\}\}#U', $template, $matches)) {
                $r = array();
                foreach ($matches[0] as $k => $m) {
                    $_key = "{{{$matches[1][$k]}}}";
                    if (in_array($_key, $replace)) {
                        $replace["{{{$matches[1][$k]}::{$matches[2][$k]}}}"] = $_key;
                        continue;
                    }
                    $replace["{{{$matches[1][$k]}::{$matches[2][$k]}}}"] = $_key;
                    $r[$matches[1][$k]] = $matches[2][$k];
                }
                $this->replace_fields = Coding::json_encode($r, true);
            } else {
                $this->replace_fields = Coding::json_encode([]);
            }
            if (!empty($replace)) {
                $this->template = str_replace(array_keys($replace), $replace, $template);
            }
        }
        return true;
    }

    /**
     * 在数据删除之后执行
     */
    protected function afterDelete()
    {
        \KindEditor::removeEditor('replace', $this->x_flag);
    }

    /**
     * 在查询数据之后执行
     */
    protected function afterFind()
    {
        if (null !== $this->replace_type) {
            $this->replace_type = explode(',', $this->replace_type);
        }
        $replace = [];
        $supportFields = $this->supportFields();
        foreach ($this->replace_type as $type) {
            if (isset($supportFields[$type])) {
                $replace = array_merge($replace, $supportFields[$type]);
            }
        }
        $define = Coding::json_decode($this->replace_fields);
        $RDefine = [];
        if (!empty($define) && is_array($define)) {
            foreach ($define as $key => $label) {
                $RDefine["{{{$key}}}"] = "{{{$key}::{$label}}}";
            }
            $replace = array_merge($RDefine, $replace);
        }
        if (!empty($replace)) {
            $this->template = str_replace(array_keys($replace), $replace, $this->template);
        }
    }

    const TYPE_SYSTEM = 'system';
    const TYPE_LOGIN = 'login';
    const TYPE_CLIENT = 'client';

    /**
     * 替换类型
     * @return array
     */
    static public function replaceType()
    {
        return [
            self::TYPE_SYSTEM => '网站信息',
            self::TYPE_LOGIN => '登录信息',
            self::TYPE_CLIENT => '客户端信息',
        ];
    }

    /**
     * 系统级别支持的替换字段描述
     * @return array
     */
    public function supportFields()
    {
        return [
            self::TYPE_SYSTEM => [
                '{{company_name}}' => '{{company_name::公司名称}}',
                '{{site_name}}' => '{{site_name::网站名称}}',
                '{{site_version}}' => '{{site_version::站点版本}}',
                '{{site_copyright}}' => '{{site_copyright::网站版权}}',
                '{{site_back_no}}' => '{{site_back_no::备案号}}',
            ],
            self::TYPE_LOGIN => [
                '{{login_username}}' => '{{login_username::登录用户名}}',
                '{{login_uid}}' => '{{login_uid::登录用户ID}}',
                '{{login_nickname}}' => '{{login_nickname::登录用户昵称}}',
            ],
            self::TYPE_CLIENT => [
                '{{now_time}}' => '{{now_time::当前时间}}',
                '{{now_date}}' => '{{now_date::当前日期}}',
                '{{client_ip}}' => '{{client_ip::当前IP}}',
            ],
        ];
    }
}