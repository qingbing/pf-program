<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类

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

$options = ['key', 'name'];
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