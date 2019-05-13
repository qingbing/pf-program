<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类

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

use Program\Models\BlockCategory;

$options = [
    'type' => [
        'callable' => ['\Program\Models\BlockCategory', 'types'],
        'type' => 'view',
    ],
    'key',
    'name',
    'description',
    'sort_order',
    'is_open' => [
        'callable' => ['\Tools\Labels', 'YesNo'],
        'type' => 'view',
    ],
    'is_enable' => [
        'callable' => ['\Tools\Labels', 'enable'],
        'type' => 'view',
    ],
    'create_time',
    'update_time',
];
if (BlockCategory::TYPE_CONTENT == $model->type) {
    $options['content'] = [
        'type' => 'view',
        'callable' => function () use ($model) {
            return $model->content;
        },
    ];
} else if (BlockCategory::TYPE_IMAGE_LINK == $model->type) {
    $options['content'] = [
        'type' => 'view',
        'callable' => function () use ($model) {
            return $model->content;
        },
    ];
    $options['src'] = [
        'code' => 'src',
        'type' => 'view',
        'callable' => function () use ($model) {
            if ('' != $model->src) {
                return '<img src="' . $model->getImageSrc() . '" width="180px" />';
            }
            return null;
        }
    ];
}
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => $options,
]); ?>
<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="button" class="btn btn-primary btn-block MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
    </dd>
</dl>