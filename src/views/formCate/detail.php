<?php
// 申明命名空间
namespace Program\Controllers;

// 引用类
use Html;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-07
 * Version      :   1.0
 *
 * @var \Program\Components\Controller $this
 * @var \Program\Models\FormCategory $model
 * @var bool $isSuper
 */
$options = [
    'key',
    'name',
    'is_setting' => [
        'callable' => ['\Tools\Labels', 'YesNo'],
        'type' => 'view',
    ],
    'is_enable' => [
        'callable' => ['\Tools\Labels', 'enable'],
        'type' => 'view',
    ],
];
if ($isSuper) {
    $options['is_open'] = [
        'callable' => ['\Tools\Labels', 'YesNo'],
        'type' => 'view',
    ];
}
array_push($options, 'sort_order');
array_push($options, 'description');
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => $options,
]); ?>
<dl class="form-group row">
    <dd class="col-sm-3 col-md-3 col-lg-3 col-sm-offset-3 col-md-offset-3 col-lg-offset-3">
        <button type="button" class="btn btn-primary btn-block MODAL-CLOSE"><i class="fa fa-close">关闭</i></button>
    </dd>
</dl>
<?php echo Html::endForm(); ?>
