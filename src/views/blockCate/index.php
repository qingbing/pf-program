<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类
use Html;
use Program\Models\BlockCategory;
use Tools\Labels;
use Tools\TableHeader;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-15
 * Version      :   1.0
 *
 * @var \Program\Components\Controller $this
 * @var array $pager
 * @var array $fixer
 */
echo Html::beginForm(['program/blockCate/index'], 'get', [
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
        <dt class="control-label">启用状态:</dt>
        <dd>
            <?php echo Html::dropDownList('is_enable', (isset($fixer['is_enable']) ? $fixer['is_enable'] : ''), Labels::enable(null, true), [
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
    'header' => TableHeader::getHeader('program-block_category-list'),
    'dataProcessing' => function ($data) {
        $operate = '<a href="' . $this->createUrl('detail', ['key' => $data->key]) . '" class="text-info w-modal" data-mode="custom"><i class="fa fa-list-alt">详情</i></a>';
        $operate .= ' <a href="' . $this->createUrl('edit', ['key' => $data->key]) . '" class="text-primary w-modal" data-mode="custom"><i class="fa fa-edit">编辑</i></a>';
        $operate .= ' <a href="' . $this->createUrl('delete', ['key' => $data->key]) . '" class="text-danger CONFIRM_AJAX" data-reload="true" data-message="确认删除该选项么？"><i class="fa fa-trash">删除</i></a>';
        if (BlockCategory::TYPE_CONTENT == $data->type) {
            $operate .= ' <a href="' . $this->createUrl('content', ['key' => $data->key]) . '" class="text-warning w-modal" target="_blank"><i class="fa fa-edit">设置内容</i></a>';
        } else if (BlockCategory::TYPE_IMAGE_LINK == $data->type) {
            $operate .= ' <a href="' . $this->createUrl('image', ['key' => $data->key]) . '" class="text-warning w-modal" target="_blank"><i class="fa fa-edit">设置图片</i></a>';
        } else {
            $operate .= ' <a href="' . $this->createUrl('/blockOption/index', ['key' => $data->key]) . '" class="text-info" target="_blank"><i class="fa fa-list-alt">查看选项</i></a>';
        }
        $process = [
            'is_open' => Labels::YesNo($data->is_open),
            'is_enable' => Labels::enable($data->is_enable),
            'type' => BlockCategory::types($data->type),
            'subOptionCount' => $data->subOptionCount,
            'operate' => $operate,
        ];
        return $process;
    },
    'data' => $pager['result'],
    'pager' => $pager,
]) ?>