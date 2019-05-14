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
 * Date         :   2019-05-14
 * Version      :   1.0
 *
 * @var \Program\Components\Controller $this
 * @var \Program\Models\Nav $model
 * @var array $fixer
 */
echo Html::beginForm('', 'post', [
    'id' => 'ajaxForm',
    'data-callback' => 'PL.saveModalCallback',
    'data-modal-reload' => 'true',
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);

$options = [
    'label' => [
        'code' => 'label',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入导航标签',
        'ajax_url' => $this->createUrl('uniqueLabel', ['key' => $fixer['key'], 'id' => $model->id, 'parentId' => $model->parent_id]),
        'is_required' => true,
    ],
    'url' => [
        'code' => 'url',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入导航标签',
    ],
    'sort_order' => [
        'code' => 'sort_order',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_INTEGER,
        'tip_msg' => '请输入排序',
        'min' => '0',
        'is_required' => true,
    ],
    'is_category' => [
        'callable' => ['\Tools\Labels', 'YesNo'],
        'type' => 'view',
    ],
    'is_enable' => [
        'code' => 'is_enable',
        'input_type' => FormGenerator::INPUT_TYPE_SELECT,
        'input_data' => Labels::enable(),
        'is_required' => true,
    ],
    'is_open' => [
        'code' => 'is_open',
        'input_type' => FormGenerator::INPUT_TYPE_SELECT,
        'input_data' => Labels::YesNo(),
        'is_required' => true,
    ],
    'is_blank' => [
        'code' => 'is_blank',
        'input_type' => FormGenerator::INPUT_TYPE_SELECT,
        'input_data' => Labels::YesNo(),
        'is_required' => true,
    ],
    'description' => [
        'code' => 'description',
        'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '描述',
        'is_required' => false,
    ],
];
// 填写表单
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => $options,
]);
?>
<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="submit" class="btn btn-primary btn-block" id="submitBtn"><i class="fa fa-save">保存</i></button>
    </dd>
    <dd class="col-sm-3 col-md-3 col-lg-3">
        <button type="button" class="btn btn-primary btn-block MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
    </dd>
</dl>
<?php echo Html::endForm(); ?>
