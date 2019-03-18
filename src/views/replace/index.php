<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类
use Html;
use Program\Models\ReplaceSetting;
use Tools\Labels;
use Tools\TableHeader;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-13
 * Version      :   1.0
 *
 * @var \Program\Components\Controller $this
 * @var array $pager
 * @var array $fixer
 */
echo Html::beginForm(['program/replace/index'], 'get', [
    'class' => 'form-inline margin-bottom',
]); ?>
    <dl class="form-group inline">
        <dt class="control-label">是否开放:</dt>
        <dd>
            <?php echo Html::dropDownList('is_open', (isset($fixer['is_open']) ? $fixer['is_open'] : ''), Labels::YesNo(null, true), [
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

$replaceType = ReplaceSetting::replaceType();
$this->widget('\Widgets\TableView', [
    'header' => TableHeader::getHeader('program-replace-list'),
    'dataProcessing' => function ($data) use ($replaceType) {

        $replace_label = [];
        foreach ($data->replace_type as $_key) {
            if (isset($replaceType[$_key])) {
                $replace_label[] = $replaceType[$_key];
            }
        }
        $operate = '<a href="' . $this->createUrl('edit', ['key' => $data->key]) . '" class="text-primary w-modal" data-mode="custom"><i class="fa fa-edit">编辑</i></a>';
        $operate .= ' <a href="' . $this->createUrl('delete', ['key' => $data->key]) . '" class="text-danger CONFIRM_AJAX" data-reload="true" data-message="确认删除该表头么？"><i class="fa fa-trash">删除</i></a>';
        $process = [
            'is_open' => Labels::YesNo($data->is_open),
            'replace_type' => implode('<br>', $replace_label),
            'operate' => $operate,
        ];
        return $process;
    },
    'data' => $pager['result'],
    'pager' => $pager,
]) ?>