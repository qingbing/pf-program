<?php
// 申明命名空间
namespace Program\Controllers;

// 引用类
use FormGenerator;
use Html;
use Program\Components\Pub;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-15
 * Version      :   1.0
 *
 * @var \Program\Components\Controller $this
 * @var \Program\Models\BlockCategory $model
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
    'type' => [
        'callable' => ['\Program\Models\BlockCategory', 'types'],
        'type' => 'view',
    ],
    'key',
    'name',
    'description',
    'content' => [
        'code' => 'content',
        'input_type' => FormGenerator::INPUT_TYPE_TEXT,
        'data_type' => FormGenerator::DATA_TYPE_STRING,
        'tip_msg' => '请输入链接地址',
        'is_required' => true,
    ],
    'src' => [
        'code' => 'src',
        'input_type' => FormGenerator::INPUT_TYPE_FILE,
        'file_extensions' => ['jpg', 'jpeg', 'png', 'gif'],
        'tip_msg' => '请上传图片',
        'is_required' => true,
    ],
];
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => $options,
]); ?>
<dl class="form-group row">
    <dd class="col-md-9 col-sm-9 col-lg-9 col-md-offset-3 col-sm-offset-3 col-lg-offset-3"><img src="<?php echo $model->getImageSrc(); ?>" width="180px" /></dd>
</dl>
<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="submit" class="btn btn-primary btn-block" id="submitBtn"><i class="fa fa-save">保存</i></button>
    </dd>
    <dd class="col-sm-3 col-md-3 col-lg-3">
        <button type="button" class="btn btn-primary btn-block MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
    </dd>
</dl>
<?php echo Html::endForm(); ?>
