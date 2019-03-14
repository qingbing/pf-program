<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类
use FormGenerator;
use Html;
use Program\Models\ReplaceSetting;
use Tools\Labels;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-13
 * Version      :   1.0
 *
 * @var \Program\Components\Controller $this
 * @var \Program\Models\ReplaceSetting $model
 */

echo Html::beginForm('', 'post', [
    'id' => 'ajaxForm',
    'data-callback' => 'PL.saveModalCallback',
    'data-modal-reload' => 'true',
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);
$options = [
    'key' => [
        'code' => 'key',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入标识符',
        'ajax_url' => $this->createUrl('uniqueKey'),
        'allow_empty' => false,
    ],
    'name' => [
        'code' => 'name',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入模板名称',
        'ajax_url' => $this->createUrl('uniqueName'),
        'allow_empty' => false,
    ],
    'replace_type' => [
        'code' => 'replace_type',
        'input_type' => FormGenerator::INPUT_TYPE_CHECKBOX_LIST,
        'input_data' => ReplaceSetting::replaceType(),
        'options' => [
            'separator' => "\t",
        ],
        'allow_empty' => true,
    ],
    'sort_order' => [
        'code' => 'sort_order',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_INTEGER,
        'tip_msg' => '请输入列表排序',
        'min' => '0',
        'allow_empty' => false,
    ],
    'is_enable' => [
        'code' => 'is_enable',
        'input_type' => FormGenerator::INPUT_TYPE_SELECT,
        'input_data' => Labels::enable(),
        'allow_empty' => false,
    ],
    'description' => [
        'code' => 'description',
        'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '描述',
        'allow_empty' => true,
    ],
    'template' => [
        'code' => 'template',
        'css_id' => 'template',
        'input_type' => FormGenerator::INPUT_TYPE_EDITOR,
        'editor' => [
            'mode' => \KindEditor::MODE_FULL,
            'openFlag' => true,
            'folder' => 'replace',
            'width' => '120%',
            'height' => '300px',
            'resizeType' => '2',
        ],
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

    <dl class="form-group row">
        <dt class="col-md-3 col-sm-3 col-lg-3 control-label"><label>参考支持字段</label>：</dt>
        <dd class="col-md-6 col-sm-6 col-lg-6 row"><?php
            $supportFields = $model->supportFields();
            foreach (ReplaceSetting::replaceType() as $key => $var) { ?>
                <div class="col-md-3 col-sm-3 col-lg-3 text-right"><code><?php echo $var; ?></code></div>
                <div class="col-md-9 col-sm-9 col-lg-9 row">
                    <?php foreach ($supportFields[$key] as $label) { ?>
                        <div class="text-left">
                            <pre><code><?php echo "{$label}"; ?></code></pre>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?></dd>
    </dl>
    <?php echo Html::endForm(); ?>