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
 * Date         :   2019-03-04
 * Version      :   1.0
 *
 * @var \Program\Components\Controller $this
 * @var boolean $isSuper
 * @var \Abstracts\DbModel $model
 */

echo Html::beginForm('', 'post', [
    'id' => 'ajaxForm',
    'data-callback' => 'PL.saveModalCallback',
    'data-modal-reload' => 'true',
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);
$options = [
    'key',
    'name' => [
        'code' => 'name',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入类型别名',
        'ajax_url' => $this->createUrl('uniqueName', ['key' => $model->key]),
        'allow_empty' => false,
    ],
    'sort_order' => [
        'code' => 'sort_order',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_INTEGER,
        'tip_msg' => '请输入列表排序',
        'min' => '0',
        'allow_empty' => false,
    ],
];
if ($isSuper) {
    $options['is_open'] = [
        'code' => 'is_open',
        'input_type' => FormGenerator::INPUT_TYPE_SELECT,
        'input_data' => Labels::YesNo(),
        'allow_empty' => false,
    ];
}
$options['description'] = [
    'code' => 'description',
    'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
    'data_type' => FormGenerator::DATA_TYPE_STRING,
    'tip_msg' => '表头描述',
    'allow_empty' => true,
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