<?php
// 申明命名空间
namespace Program\Controllers;

// 引用类
use FormGenerator;
use Helper\HttpException;
use Html;
use Program\Components\Pub;
use Program\Models\BlockCategory;
use Tools\Labels;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-15
 * Version      :   1.0
 *
 * @var \Program\Components\Controller $this
 * @var \Program\Models\BlockCategory $category
 * @var \Program\Models\BlockOption $model
 */
\ClientScript::getInstance()->registerScriptFile(Pub::getAssetBaseUrl() . '/js/jquery.form.js');
echo Html::beginForm('', 'post', [
    'id' => 'ajaxForm',
    'data-callback' => 'PL.saveAjaxFileCallback',
    'data-modal-reload' => 'true',
    'class' => 'w-validate',
    'enctype' => 'multipart/form-data',
]);

$options = [
    'label' => [
        'code' => 'label',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入子项名称',
        'ajax_url' => $this->createUrl('uniqueLabel', ['key' => $category->key, 'id' => $model->id]),
        'allow_empty' => false,
    ],
];
$link = [
    'code' => 'link',
    'input_type' => FormGenerator::INPUT_TYPE_TEXT,
    'data_type' => FormGenerator::DATA_TYPE_STRING,
    'tip_msg' => '请输入链接地址',
    'allow_empty' => false,
];
$src = [
    'code' => 'src',
    'input_type' => FormGenerator::INPUT_TYPE_FILE,
    'file_extensions' => ['jpg', 'jpeg', 'png', 'gif'],
    'tip_msg' => '请上传图片',
    'allow_empty' => true,
];
switch ($category->type) {
    case BlockCategory::TYPE_CONTENT:
        break;
    case BlockCategory::TYPE_CLOUD_WORDS:
        $options['link'] = $link;
        break;
    case BlockCategory::TYPE_LINK_CLOUD_WORDS:
        $options['link'] = $link;
        break;
    case BlockCategory::TYPE_IMAGES:
        $options['src'] = $src;
        break;
    case BlockCategory::TYPE_LINKS:
        $options['link'] = $link;
        break;
    case BlockCategory::TYPE_IMAGE_LINKS:
        $options['link'] = $link;
        $options['src'] = $src;
        break;
    default :
        throw new HttpException('区块类型(type)不存在', 404);
}
$options['is_open'] = [
    'code' => 'is_open',
    'input_type' => FormGenerator::INPUT_TYPE_SELECT,
    'input_data' => Labels::YesNo(),
];
$options['is_enable'] = [
    'code' => 'is_enable',
    'input_type' => FormGenerator::INPUT_TYPE_SELECT,
    'input_data' => Labels::enable(),
];
$options['sort_order'] = [
    'code' => 'sort_order',
    'input_type' => FormGenerator::INPUT_TYPE_TEXT,
    'data_type' => FormGenerator::DATA_TYPE_INTEGER,
    'tip_msg' => '请输入排序',
    'min' => '0',
    'allow_empty' => false,
];
$options['description'] = [
    'code' => 'description',
    'input_type' => FormGenerator::INPUT_TYPE_TEXTAREA,
    'data_type' => FormGenerator::DATA_TYPE_STRING,
    'tip_msg' => '请输入子项含义',
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