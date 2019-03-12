<?php
// 申明命名空间
namespace Program\Controllers;

// 引用类
use FormGenerator;
use Html;
use Tools\Labels;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-07
 * Version      :   1.0
 *
 * @var \Program\Components\Controller $this
 * @var \Program\Models\FormCategory $category
 * @var \Program\Models\FormOption $model
 */

echo Html::beginForm('', 'post', [
    'id' => 'ajaxForm',
    'data-callback' => 'PL.saveModalCallback',
    'data-modal-reload' => 'true',
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);

$options = [
    'code' => [
        'code' => 'code',
        'css_id' => 'code',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入选项标识符',
        'ajax_url' => $this->createUrl('uniqueCode', ['key' => $category->key]),
        'allow_empty' => false,
        'callback' => 'changeInputType',
    ],
    'label' => [
        'code' => 'label',
        'css_id' => 'label',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入选项别名',
        'ajax_url' => $this->createUrl('uniqueLabel', ['key' => $category->key]),
        'allow_empty' => false,
    ],
    'sort_order' => [
        'code' => 'sort_order',
        'css_id' => 'sort_order',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_INTEGER,
        'tip_msg' => '请输入列表排序',
        'min' => '0',
        'allow_empty' => false,
    ],
    'is_enable' => [
        'code' => 'is_enable',
        'css_id' => 'is_enable',
        'input_type' => FormGenerator::INPUT_TYPE_SELECT,
        'input_data' => Labels::enable(),
    ],
    'description' => [
        'code' => 'description',
        'css_id' => 'description',
        'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入分类配置含义',
        'allow_empty' => true,
    ],
    'input_type' => [
        'code' => 'input_type',
        'css_id' => 'input_type',
        'input_type' => FormGenerator::INPUT_TYPE_SELECT,
        'input_data' => FormGenerator::inputType(),
        'callback' => 'inputTypeCallback',
    ],
    'data_type' => [
        'code' => 'data_type',
        'css_id' => 'data_type',
        'input_type' => FormGenerator::INPUT_TYPE_SELECT,
        'input_data' => FormGenerator::dataType(),
        'callback' => 'dataTypeCallback',
    ],
    'file_extensions' => [
        'code' => 'file_extensions',
        'css_id' => 'file_extensions',
        'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '文件上传时支持的文件后缀类型,用|分隔',
        'allow_empty' => true,
    ],
    'compare_field' => [
        'code' => 'compare_field',
        'css_id' => 'compare_field',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入对比选项别名',
        'allow_empty' => true,
    ],
    'input_data' => [
        'code' => 'input_data',
        'css_id' => 'input_data',
        'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入选择项目',
        'allow_empty' => true,
    ],
    'pattern' => [
        'code' => 'pattern',
        'css_id' => 'pattern',
        'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入正则表达式',
        'allow_empty' => true,
    ],
    'default' => [
        'code' => 'default',
        'css_id' => 'default',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入默认值',
        'allow_empty' => true,
    ],
    'tip_msg' => [
        'code' => 'tip_msg',
        'css_id' => 'tip_msg',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入提示信息',
        'allow_empty' => true,
    ],
    'error_msg' => [
        'code' => 'error_msg',
        'css_id' => 'error_msg',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入错误提示信息',
        'allow_empty' => true,
    ],
    'allow_empty' => [
        'code' => 'allow_empty',
        'css_id' => 'allow_empty',
        'input_type' => FormGenerator::INPUT_TYPE_SELECT,
        'input_data' => Labels::YesNo(),
    ],
    'empty_msg' => [
        'code' => 'empty_msg',
        'css_id' => 'empty_msg',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入空提示信息',
        'allow_empty' => true,
    ],
    'min' => [
        'code' => 'min',
        'css_id' => 'min',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_NUMERIC,
        'tip_msg' => '请输入最小值或长度',
        'allow_empty' => true,
    ],
    'min_msg' => [
        'code' => 'min_msg',
        'css_id' => 'min_msg',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入最小或最短时提示信息',
        'allow_empty' => true,
    ],
    'max' => [
        'code' => 'max',
        'css_id' => 'max',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_NUMERIC,
        'tip_msg' => '请输大最小值或长度',
        'allow_empty' => true,
    ],
    'max_msg' => [
        'code' => 'max_msg',
        'css_id' => 'max_msg',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入最大或最长时提示信息',
        'allow_empty' => true,
    ],
    'ajax_url' => [
        'code' => 'callback',
        'css_id' => 'callback',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入ajax验证URL',
        'allow_empty' => true,
    ],
    'callback' => [
        'code' => 'callback',
        'css_id' => 'callback',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入验证回调函数名',
        'allow_empty' => true,
    ],
    'tip_id' => [
        'code' => 'tip_id',
        'css_id' => 'tip_id',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入表单验证的信息提示元素ID',
        'allow_empty' => true,
    ],
    'css_id' => [
        'code' => 'css_id',
        'css_id' => 'css_id',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入表单元素ID',
        'allow_empty' => true,
    ],
    'css_class' => [
        'code' => 'css_class',
        'css_id' => 'css_class',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入表单元素类',
        'allow_empty' => true,
    ],
    'css_style' => [
        'code' => 'css_style',
        'css_id' => 'css_style',
        'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入表单元素的样式',
        'allow_empty' => true,
    ],
];
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => $options,
]); ?>
<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="submit" class="btn btn-primary btn-block" id="submitBtn"><i class="fa fa-save">保存</i></button>
    </dd>
    <dd class="col-sm-3 col-md-3 col-lg-3">
        <button type="button" class="btn btn-primary btn-block MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
    </dd>
</dl>
<?php echo Html::endForm(); ?>
<script type="text/javascript">
    let $input_type = $('#input_type');
    let $data_type = $('#data_type');
    let $file_extensions = $('#file_extensions');
    let $compare_field = $('#compare_field');
    let $input_data = $('#input_data');
    let $pattern = $('#pattern');
    let $default = $('#default');
    let $tip_msg = $('#tip_msg');
    let $error_msg = $('#error_msg');
    let $allow_empty = $('#allow_empty');
    let $empty_msg = $('#empty_msg');
    let $min = $('#min');
    let $min_msg = $('#min_msg');
    let $max = $('#max');
    let $max_msg = $('#max_msg');
    let $ajax_url = $('#ajax_url');
    let $callback = $('#callback');

    let PJ = {
        $changeFields: {
            // 'code' : $('#code').closest('dl'),
            // 'label' : $('#label').closest('dl'),
            // 'sort_order' : $('#sort_order').closest('dl'),
            // 'is_enable' : $('#is_enable').closest('dl'),
            // 'description' : $('#description').closest('dl'),
            // 'input_type' : $('#input_type').closest('dl'),

            'data_type': $data_type.closest('dl'),
            'file_extensions': $file_extensions.closest('dl'),
            'compare_field': $compare_field.closest('dl'),
            'input_data': $input_data.closest('dl'),
            'pattern': $pattern.closest('dl'),
            'default': $default.closest('dl'),
            'tip_msg': $tip_msg.closest('dl'),
            'error_msg': $error_msg.closest('dl'),
            'allow_empty': $allow_empty.closest('dl'),
            'empty_msg': $empty_msg.closest('dl'),
            'min': $min.closest('dl'),
            'min_msg': $min_msg.closest('dl'),
            'max': $max.closest('dl'),
            'max_msg': $max_msg.closest('dl'),
            'ajax_url': $ajax_url.closest('dl'),
            'callback': $callback.closest('dl'),

            // 'tip_id': $('#tip_id').closest('dl'),
            // 'css_id': $('#css_id').closest('dl'),
            // 'css_class': $('#css_class').closest('dl'),
            // 'css_style': $('#css_style').closest('dl'),
        },
        inputTypeField: {
            //'<?php //echo FormGenerator::INPUT_TYPE_TEXT; ?>//': ['data_type', 'file_extensions', 'compare_field', 'input_data', 'pattern', 'default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'min', 'min_msg', 'max', 'max_msg', 'ajax_url', 'callback'],
            '<?php echo FormGenerator::INPUT_TYPE_TEXT; ?>': ['data_type'],
            '<?php echo FormGenerator::INPUT_TYPE_TEXTAREA; ?>': ['data_type'],
            '<?php echo FormGenerator::INPUT_TYPE_HIDDEN; ?>': ['data_type'],
            '<?php echo FormGenerator::INPUT_TYPE_SELECT; ?>': ['data_type'], // data_type => [select, choice(muti)]
            '<?php echo FormGenerator::INPUT_TYPE_CHECKBOX; ?>': ['default', 'tip_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'],
            '<?php echo FormGenerator::INPUT_TYPE_CHECKBOX_LIST; ?>': ['input_data', 'default', 'tip_msg', 'allow_empty', 'empty_msg', 'min', 'min_msg', 'max', 'max_msg'],
            '<?php echo FormGenerator::INPUT_TYPE_RADIO_LIST; ?>': ['input_data', 'default', 'tip_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'],
            '<?php echo FormGenerator::INPUT_TYPE_EDITOR; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'min', 'min_msg', 'max', 'max_msg', 'ajax_url', 'callback'],
            '<?php echo FormGenerator::INPUT_TYPE_PASSWORD; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'],
            '<?php echo FormGenerator::INPUT_TYPE_FILE; ?>': ['file_extensions', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg']
        },
        dataTypeField: {
            '<?php echo FormGenerator::DATA_TYPE_REQUIRED; ?>': ['default', 'tip_msg', 'empty_msg', 'ajax_url', 'callback'], // required';
            '<?php echo FormGenerator::DATA_TYPE_EMAIL; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // email';
            '<?php echo FormGenerator::DATA_TYPE_URL; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // url';
            '<?php echo FormGenerator::DATA_TYPE_IP; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // ip';
            '<?php echo FormGenerator::DATA_TYPE_PHONE; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // phone';
            '<?php echo FormGenerator::DATA_TYPE_MOBILE; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // mobile';
            '<?php echo FormGenerator::DATA_TYPE_CONTACT; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // contact';
            '<?php echo FormGenerator::DATA_TYPE_FAX; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // fax';
            '<?php echo FormGenerator::DATA_TYPE_ZIP; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // zip';
            '<?php echo FormGenerator::DATA_TYPE_TIME; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // time';
            '<?php echo FormGenerator::DATA_TYPE_DATE; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // date';
            '<?php echo FormGenerator::DATA_TYPE_USERNAME; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // username';
            '<?php echo FormGenerator::DATA_TYPE_PASSWORD; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // password';
            '<?php echo FormGenerator::DATA_TYPE_COMPARE; ?>': ['compare_field', 'default', 'tip_msg', 'error_msg'], // compare';
            '<?php echo FormGenerator::DATA_TYPE_PREG; ?>': ['pattern', 'default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // preg';
            '<?php echo FormGenerator::DATA_TYPE_STRING; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'min', 'min_msg', 'max', 'max_msg', 'ajax_url', 'callback'], // string';
            '<?php echo FormGenerator::DATA_TYPE_NUMERIC; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'min', 'min_msg', 'max', 'max_msg', 'ajax_url', 'callback'], // numeric';
            '<?php echo FormGenerator::DATA_TYPE_INTEGER; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'min', 'min_msg', 'max', 'max_msg', 'ajax_url', 'callback'], // integer';
            '<?php echo FormGenerator::DATA_TYPE_MONEY; ?>': ['default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'min', 'min_msg', 'max', 'max_msg', 'ajax_url', 'callback'], // money';
            '<?php echo FormGenerator::DATA_TYPE_SELECT; ?>': ['input_data', 'default', 'tip_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'], // select';
            '<?php echo FormGenerator::DATA_TYPE_CHOICE; ?>': ['input_data', 'default', 'tip_msg', 'allow_empty', 'empty_msg', 'min', 'min_msg', 'max', 'max_msg', 'ajax_url', 'callback'] // choice';
            //'<?php //echo FormGenerator::DATA_TYPE_CHECKED; ?>//': ['input_data', 'default', 'tip_msg', 'allow_empty', 'empty_msg', 'ajax_url', 'callback'] // checked';
            //'<?php //echo FormGenerator::DATA_TYPE_FILE; ?>//': ['file_extensions', 'compare_field', 'input_data', 'pattern', 'default', 'tip_msg', 'error_msg', 'allow_empty', 'empty_msg', 'min', 'min_msg', 'max', 'max_msg', 'ajax_url', 'callback'], // file';
        },
        func: {
            changeInputType: function () {
                // 隐藏所有可能需要变化的字段
                H.each(PJ.$changeFields, function (key, $field) {
                    if ('input_type' !== key) {
                        $field.hide();
                    }
                });
                // 获取输入类型
                let inputType = $input_type.val();
                // 按照 input_type 显示
                if (!H.isArray(PJ.inputTypeField[inputType])) {
                    $.alert('未定义的输入类型', 'danger');
                    return;
                }
                H.each(PJ.inputTypeField[inputType], function (i, key) {
                    let $box = eval('$' + key);
                    $box.closest('dl').show();
                });
                /**
                 * 数据类型纠正
                 */
                    // 获取数据类型
                let dataType = $data_type.val();
                if (
                    '<?php echo FormGenerator::INPUT_TYPE_SELECT; ?>' === inputType
                    && ('<?php echo FormGenerator::DATA_TYPE_SELECT; ?>' !== dataType || '<?php echo FormGenerator::DATA_TYPE_CHOICE; ?>' !== dataType)
                ) {
                    $data_type.val('<?php echo FormGenerator::DATA_TYPE_SELECT; ?>');
                }
                PJ.func.changeDataType(true);
            },
            changeDataType: function () {
                // 获取输入类型
                let inputType = $input_type.val();
                // 获取数据类型
                let dataType = $data_type.val();
                // 不能选择 [ radioList=>checked, checkbox=>checked ]
                if ('<?php echo FormGenerator::DATA_TYPE_CHECKED; ?>' === inputType) {
                    $.alert('"勾选"数据类型只适用于"单选按钮组"或"勾选框"', 'danger');
                    return;
                }
                // 不能选择 [ input.file=>file ]
                if ('<?php echo FormGenerator::DATA_TYPE_FILE; ?>' === inputType) {
                    $.alert('"文件上传"数据类型只适用于"文件域"', 'danger');
                    return;
                }
                // inputType 为select 时，数据类型只能为"select" 或 "choice"
                if (
                    '<?php echo FormGenerator::INPUT_TYPE_SELECT; ?>' === inputType
                    && ('<?php echo FormGenerator::DATA_TYPE_SELECT; ?>' !== dataType && '<?php echo FormGenerator::DATA_TYPE_CHOICE; ?>' !== dataType)
                ) {
                    $.alert('SELECT 的数据类型只支持 单选或多选', 'danger');
                    return;
                }
                // 按照 data_type 显示
                if (!H.isArray(PJ.dataTypeField[dataType])) {
                    $.alert('未定义的数据类型', 'danger');
                    return;
                }
                H.each(PJ.dataTypeField[dataType], function (i, key) {
                    let $box = eval('$' + key);
                    $box.closest('dl').show();
                });
            }
        }
    };

    // 输入类型回调
    function inputTypeCallback() {
        PJ.func.changeInputType();
        return true;
    }

    // 数据类型回调
    function dataTypeCallback() {
        PJ.func.changeDataType();
        return true;
    }

    // 页面加载完后初始化
    $(window).on('load', function () {
        PJ.func.changeInputType();
    });
</script>
