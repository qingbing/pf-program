<?php
// 申明命名空间
namespace Program\Controllers;

// 引用类
use Helper\HttpException;
use Program\Models\BlockCategory;

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
$options = [
    'label' => [
        'code' => 'label',
        'type' => 'view'
    ],
];
$link = [
    'code' => 'link',
    'type' => 'view',
];
$is_blank = [
    'code' => 'is_blank',
    'type' => 'view',
    'callable' => ["Tools\Labels", "YesNo"]
];
$src = [
    'code' => 'src',
    'type' => 'view',
    'callable' => function () use ($model) {
        if ('' != $model->src) {
            return '<img src="' . $model->getImageSrc() . '" width="180px" />';
        }
        return null;
    }
];
switch ($category->type) {
    case BlockCategory::TYPE_CONTENT:
    case BlockCategory::TYPE_IMAGE_LINK:
        break;
    case BlockCategory::TYPE_CLOUD_WORDS:
        break;
    case BlockCategory::TYPE_CLOUD_WORDS_LINKS:
        $options['link'] = $link;
        $options['is_blank'] = $is_blank;
        break;
    case BlockCategory::TYPE_LIST:
        break;
    case BlockCategory::TYPE_LIST_LINKS:
        $options['link'] = $link;
        $options['is_blank'] = $is_blank;
        break;
    case BlockCategory::TYPE_IMAGES:
        $options['src'] = $src;
        break;
    case BlockCategory::TYPE_IMAGES_LINKS:
        $options['link'] = $link;
        $options['is_blank'] = $is_blank;
        $options['src'] = $src;
        break;
    default :
        throw new HttpException('区块类型(type)不存在', 404);
}
$options['is_open'] = [
    'code' => 'is_open',
    'type' => 'view',
    'callable' => ["Tools\Labels", "YesNo"]
];
$options['is_enable'] = [
    'code' => 'is_enable',
    'type' => 'view',
    'callable' => ["Tools\Labels", "enable"]
];
$options['sort_order'] = [
    'code' => 'sort_order',
    'type' => 'view',
];
$options['description'] = [
    'code' => 'description',
    'type' => 'view',
];
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => $options,
]); ?>
<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="button" class="btn btn-primary btn-block MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
    </dd>
</dl>