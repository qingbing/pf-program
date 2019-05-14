<?php
// 申明命名空间
namespace Program\Controllers;

// 引用类
use Html;
use Tools\TableHeader;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-05-14
 * Version      :   1.0
 *
 * @var \Program\Components\Controller $this
 * @var array $pager
 * @var array $fixer
 */
echo Html::beginForm(['program/staticPage/index'], 'get', [
    'class' => 'form-inline margin-bottom',
]); ?>
    <dl class="form-group inline">
        <dt class="control-label">引用代码:</dt>
        <dd>
            <?php echo Html::textField('code', (isset($fixer['code']) ? $fixer['code'] : ''), [
                'class' => 'form-control',
            ]); ?>
        </dd>
    </dl>
    <dl class="form-group inline">
        <dt class="control-label">关键字:</dt>
        <dd>
            <?php echo Html::textField('keyword', (isset($fixer['keyword']) ? $fixer['keyword'] : ''), [
                'class' => 'form-control',
            ]); ?>
        </dd>
    </dl>
    <dl class="form-group inline">
        <dd>
            <button class="btn btn-info"><i class="fa fa-search"></i>查询</button>
        </dd>
    </dl>
    <?php echo Html::endForm(); ?>
    <div class="margin-bottom">
        <a href="<?php echo $this->createUrl('add'); ?>" data-title="添加" class="w-modal btn btn-info">
            <i class="fa fa-plus">添加</i>
        </a>
    </div>
    <?php
$this->widget('\Widgets\TableView', [
    'header' => TableHeader::getHeader('program-static_content-list'),
    'dataProcessing' => function ($data) {

        $operate = '<a href="' . $this->createUrl('edit', ['id' => $data->id]) . '" class="text-primary w-modal" data-mode="custom"><i class="fa fa-edit">编辑</i></a>';
        $operate .= ' <a href="' . $this->createUrl('detail', ['id' => $data->id]) . '" class="text-info w-modal" data-mode="custom"><i class="fa fa-list-alt">详情</i></a>';
        $operate .= ' <a href="' . $this->createUrl('delete', ['id' => $data->id]) . '" class="text-danger CONFIRM_AJAX" data-reload="true" data-message="确认删除静态内容么？"><i class="fa fa-trash">删除</i></a>';

        $process = [
            'operate' => $operate,
        ];
        return $process;
    },
    'data' => $pager['result'],
    'pager' => $pager,
]) ?>