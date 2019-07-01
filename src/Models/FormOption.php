<?php
// 申明命名空间
namespace Program\Models;

// 引用类
use Abstracts\DbModel;
use DbSupports\Builder\Criteria;
use FormGenerator;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-05-17
 * Version      :   1.0
 *
 * This is the model class for table "pub_form_option".
 * The followings are the available columns in table 'pub_form_option':
 *
 * @property integer id
 * @property string key
 * @property string code
 * @property string label
 * @property string default
 * @property string description
 * @property integer sort_order
 * @property string input_type
 * @property string data_type
 * @property string input_data
 * @property integer allow_empty
 * @property string compare_field
 * @property string pattern
 * @property string tip_msg
 * @property string error_msg
 * @property string empty_msg
 * @property integer min
 * @property string min_msg
 * @property integer max
 * @property string max_msg
 * @property string file_extensions
 * @property string callback
 * @property string ajax_url
 * @property string tip_id
 * @property string css_id
 * @property string css_class
 * @property string css_style
 * @property integer is_enable
 */
class FormOption extends DbModel
{
    /**
     * 获取 db-model 实例
     * @param string|null $className active record class name.
     * @return DbModel|FormOption
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
        return 'pub_form_option';
    }

    /**
     * 定义并返回模型属性的验证规则
     * @return array
     */
    public function rules()
    {
        return [
            ['sort_order, input_type, allow_empty, is_enable', 'required'],
            ['sort_order, allow_empty, min, max, is_enable', 'numerical', 'integerOnly' => true],
            ['key, code, label, default, compare_field, callback, tip_id, css_id, css_class', 'string', 'maxLength' => 100],
            ['description', 'string', 'maxLength' => 255],
            ['pattern, tip_msg, error_msg, empty_msg, min_msg, max_msg, file_extensions, ajax_url, css_style', 'string', 'maxLength' => 200],
            ['input_type', 'in', 'range' => ['text', 'select', 'textarea', 'editor', 'checkbox', 'checkbox_list', 'radio_list', 'password', 'hidden', 'file']],
            ['data_type', 'in', 'range' => ['required', 'email', 'url', 'ip', 'phone', 'mobile', 'contact', 'fax', 'zip', 'time', 'date', 'username', 'password', 'compare', 'preg', 'string', 'numeric', 'integer', 'money', 'file', 'select', 'choice', 'checked']],
            ['input_data', 'string'],
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
            'id' => 'Id',
            'key' => '所属表单',
            'code' => '字段名',
            'label' => '显示标签',
            'default' => '默认值',
            'description' => '描述',
            'sort_order' => '显示排序',
            'input_type' => '输入类型',
            'data_type' => '数据类型',
            'input_data' => '输入值列表',
            'allow_empty' => '允许为空',
            'compare_field' => '对比字段',
            'pattern' => '正则匹配',
            'tip_msg' => '提示信息',
            'error_msg' => '错误提示信息',
            'empty_msg' => '空提示信息',
            'min' => '最小值/长度',
            'min_msg' => '过小/短提示信息',
            'max' => '最大值/长度',
            'max_msg' => '太大/长提示信息',
            'file_extensions' => '文件后缀',
            'callback' => '验证回调函数',
            'ajax_url' => 'Ajax验证url',
            'tip_id' => '提示元素ID',
            'css_id' => '样式ID',
            'css_class' => '样式类',
            'css_style' => '表单样式',
            'is_enable' => '启用状态',
        ];
    }

    /**
     * 在数据插入之前执行
     * @return bool
     */
    protected function beforeSave()
    {
        switch ($this->input_type) {
            case FormGenerator::INPUT_TYPE_SELECT : //  select'; // data-type => select,choice
                if (FormGenerator::DATA_TYPE_SELECT !== $this->data_type && FormGenerator::DATA_TYPE_CHOICE !== $this->data_type) {
                    $this->addError('data_type', 'ELECT 的数据类型只支持 单选或多选');
                    return false;
                }
                $this->file_extensions = '';
                $this->compare_field = '';
                $this->pattern = '';
                $this->error_msg = '';
                if (FormGenerator::DATA_TYPE_SELECT === $this->data_type) {
                    $this->min = null;
                    $this->min_msg = '';
                    $this->max = null;
                    $this->max_msg = '';
                }
                break;
            case FormGenerator::INPUT_TYPE_CHECKBOX : //  checkbox'; // data-type => checked
                $this->data_type = FormGenerator::DATA_TYPE_CHECKED;
                $this->file_extensions = '';
                $this->compare_field = '';
                $this->input_data = '';
                $this->pattern = '';
                $this->error_msg = '';
                $this->min = null;
                $this->min_msg = '';
                $this->max = '';
                $this->max_msg = '';
                break;
            case FormGenerator::INPUT_TYPE_CHECKBOX_LIST : //  checkbox_list'; // data => choice
                $this->data_type = FormGenerator::DATA_TYPE_CHOICE;
                $this->file_extensions = '';
                $this->compare_field = '';
                $this->pattern = '';
                $this->error_msg = '';
                $this->ajax_url = '';
                $this->callback = '';
                break;
            case FormGenerator::INPUT_TYPE_RADIO_LIST : //  radio_list'; // data-type => checked
                $this->data_type = FormGenerator::DATA_TYPE_CHECKED;
                $this->file_extensions = '';
                $this->compare_field = '';
                $this->pattern = '';
                $this->error_msg = '';
                $this->min = null;
                $this->min_msg = '';
                $this->max = null;
                $this->max_msg = '';
                break;
            case FormGenerator::INPUT_TYPE_EDITOR : //  editor';
                $this->data_type = FormGenerator::DATA_TYPE_STRING;
                $this->file_extensions = '';
                $this->compare_field = '';
                $this->input_data = '';
                $this->pattern = '';
                break;
            case FormGenerator::INPUT_TYPE_PASSWORD : //  password'; // data-type => password,compare
                $this->data_type = FormGenerator::DATA_TYPE_PASSWORD;
                $this->file_extensions = '';
                $this->compare_field = '';
                $this->input_data = '';
                $this->pattern = '';
                $this->min = null;
                $this->min_msg = '';
                $this->max = null;
                $this->max_msg = '';
                break;
            case FormGenerator::INPUT_TYPE_FILE : //  file';
                $this->data_type = FormGenerator::DATA_TYPE_FILE;
                $this->compare_field = '';
                $this->input_data = '';
                $this->pattern = '';
                $this->default = '';
                $this->min = null;
                $this->min_msg = '';
                $this->max = null;
                $this->max_msg = '';
                $this->ajax_url = '';
                $this->callback = '';
                break;
            case FormGenerator::INPUT_TYPE_TEXT : //  text';
            case FormGenerator::INPUT_TYPE_TEXTAREA : //  textarea';
            case FormGenerator::INPUT_TYPE_HIDDEN : //  hidden';
            default:
                switch ($this->data_type) {
                    case FormGenerator::DATA_TYPE_REQUIRED:
                        $this->allow_empty = 1;
                        $this->file_extensions = '';
                        $this->compare_field = '';
                        $this->input_data = '';
                        $this->pattern = '';
                        $this->error_msg = '';
                        $this->min = null;
                        $this->min_msg = '';
                        $this->max = null;
                        $this->max_msg = '';
                        break;
                    case FormGenerator::DATA_TYPE_EMAIL:
                    case FormGenerator::DATA_TYPE_URL:
                    case FormGenerator::DATA_TYPE_IP:
                    case FormGenerator::DATA_TYPE_PHONE:
                    case FormGenerator::DATA_TYPE_MOBILE:
                    case FormGenerator::DATA_TYPE_CONTACT:
                    case FormGenerator::DATA_TYPE_FAX:
                    case FormGenerator::DATA_TYPE_ZIP:
                    case FormGenerator::DATA_TYPE_TIME:
                    case FormGenerator::DATA_TYPE_DATE:
                    case FormGenerator::DATA_TYPE_USERNAME:
                    case FormGenerator::DATA_TYPE_PASSWORD:
                        $this->file_extensions = '';
                        $this->compare_field = '';
                        $this->input_data = '';
                        $this->pattern = '';
                        $this->min = null;
                        $this->min_msg = '';
                        $this->max = null;
                        $this->max_msg = '';
                        break;
                    case FormGenerator::DATA_TYPE_COMPARE:
                        $this->file_extensions = '';
                        $this->input_data = '';
                        $this->pattern = '';
                        $this->allow_empty = '';
                        $this->empty_msg = '';
                        $this->min = null;
                        $this->min_msg = '';
                        $this->max = null;
                        $this->max_msg = '';
                        $this->ajax_url = '';
                        $this->callback = '';
                        break;
                    case FormGenerator::DATA_TYPE_PREG:
                        $this->file_extensions = '';
                        $this->compare_field = '';
                        $this->input_data = '';
                        $this->min = null;
                        $this->min_msg = '';
                        $this->max = null;
                        $this->max_msg = '';
                        break;
                    case FormGenerator::DATA_TYPE_STRING:
                    case FormGenerator::DATA_TYPE_NUMERIC:
                    case FormGenerator::DATA_TYPE_INTEGER:
                    case FormGenerator::DATA_TYPE_MONEY:
                    default:
                        $this->file_extensions = '';
                        $this->compare_field = '';
                        $this->input_data = '';
                        $this->pattern = '';
                        break;
//                    case FormGenerator::DATA_TYPE_SELECT: // 在 input_type => SELECT 中已经处理
//                        break;
//                    case FormGenerator::DATA_TYPE_CHOICE: // 在 input_type => SELECT,CHECKBOX-LIST 中已经处理
//                        break;
//                    case FormGenerator::DATA_TYPE_FILE: //  // 在 input_type => FILE 中已经处理
//                        break;
//                    case FormGenerator::DATA_TYPE_CHECKED: // 在 input_type => RADIO-LIST,CHECKBOX 中已经处理
//                        break;
                }
                break;
        }
        if ('' === $this->min) {
            $this->min = null;
        }
        if ('' === $this->max) {
            $this->max = null;
        }
        return true;
    }

    /**
     * 验证通过后执行
     * @throws \Exception
     */
    protected function afterValidate()
    {
        $criteria = new Criteria();
        $criteria->addWhere('`key`=:key')
            ->addParam(':key', $this->key);

        $cCode = clone($criteria);
        $cCode->addWhere('`code`=:code')
            ->addParam(':code', $this->code);

        $cLabel = clone($criteria);
        $cLabel->addWhere('`label`=:label')
            ->addParam(':label', $this->label);
        if ($this->getIsNewRecord()) {
            if (self::model()->count($cCode) > 0) {
                $this->addError('code', "该表单配置选项中已经存在\"{$this->code}\"");
            }
            if (self::model()->count($cLabel) > 0) {
                $this->addError('label', "该表单配置选项中已经存在\"{$this->label}\"");
            }
        } else {
            $cCode->addWhere('`id`!=:id')
                ->addParam(':id', $this->id);
            $cLabel->addWhere('`id`!=:id')
                ->addParam(':id', $this->id);
            if (self::model()->count($cCode) > 0) {
                $this->addError('code', "该表单配置选项中已经存在\"{$this->code}\"");
            }
            if (self::model()->count($cLabel) > 0) {
                $this->addError('label', "该表单配置选项中已经存在\"{$this->label}\"");
            }
        }
    }
}