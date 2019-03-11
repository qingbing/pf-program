<?php
// 申明命名空间
namespace Program\Controllers;

// 引用类
use FormGenerator;
use Helper\Coding;
use Html;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-07
 * Version      :   1.0
 *
 * @var \Program\Components\Controller $this
 * @var \Program\models\FormCategory $category
 * @var \Program\models\FormOption[] $models
 */
?>
<div class="margin-bottom">
    <a href="<?php echo $this->createUrl('add', ['key' => $category->key]); ?>" class="btn btn-primary w-modal">
        <i class="fa fa-plus">添加</i>
    </a>
    <a href="<?php echo $this->createUrl('refreshSortOrder', ['key' => $category->key]); ?>"
       class="btn btn-primary CONFIRM_AJAX" data-message="确认刷新表头选项顺序么？" data-reload="true"><i
                class="fa fa-refresh">刷新排序</i></a>
</div>
<table class="table table-hover table-bordered table-striped w-edit-table"
       data-ajax-url="<?php echo $this->createUrl('edit', ['key' => $category->key]); ?>"
       data-post-data='<?php echo Coding::json_encode(['key' => $category->key], true); ?>'>
    <thead>
    <tr>
        <th class="text-center" width="100px">字段名</th>
        <th class="text-center" width="100px">显示标签</th>
        <th class="text-center" width="60px">默认值</th>
        <th class="text-center" width="80px">输入类型</th>
        <th class="text-center" width="80px">数据类型</th>
        <th class="text-center" width="50px">显示排序</th>
        <th class="text-center" width="50px">允许空</th>
        <th class="text-center" width="50px">启用状态</th>
        <th class="text-center" width="240px">操作</th>
        <th class="text-center" width="150px">操作显示</th>
    </tr>
    </thead>
    <tbody>
    <?php
    $inputType = FormGenerator::inputType();
    $dataType = FormGenerator::dataType();
    foreach ($models as $model) {
        ?>
        <tr data-post-data='<?php echo Coding::json_encode(['id' => $model->id], true); ?>'
            data-tip=".w_display_status">
            <td class="text-left" data-name="code"><?php echo $model->code; ?></td>
            <td class="text-left" data-name="label"><?php echo $model->label; ?></td>
            <td class="text-left" data-name="default"><?php echo $model->default; ?></td>
            <td class="text-left">
                <?php echo $model->input_type ? $inputType[$model->input_type] : ' - '; ?>
            </td>
            <td class="text-left">
                <?php echo $model->data_type ? $dataType[$model->data_type] : ' - '; ?>
            </td>
            <td class="text-center" data-name="sort_order"><?php echo $model->sort_order; ?></td>
            <td class="text-center" data-name="allow_empty">
                <?php echo Html::checkBox('allow_empty', !!$model->allow_empty); ?>
            </td>
            <td class="text-center" data-name="is_enable">
                <?php echo Html::checkBox('is_enable', !!$model->is_enable); ?>
            </td>
            <td class="text-left" data-name="sort_order" data-type="upDown" data-reload="true"
                data-ajax-url="<?php echo $this->createUrl('upDown', ['key' => $category->key, 'id' => $model->id]) ?>">
                <a href="<?php echo $this->createUrl('editDetail', ['key' => $category->key, 'id' => $model->id]) ?>"
                   class="btn btn-primary w-modal" data-mode="custom"><i class="fa fa-edit">编辑</i></a>
                <a href="<?php echo $this->createUrl('delete', ['key' => $category->key, 'id' => $model->id]) ?>"
                   class="btn btn-danger CONFIRM_AJAX" data-reload="true" data-message="确认要删除该选项么？">
                    <i class="fa fa-trash">删除</i>
                </a>
            </td>
            <td class="w_display_status"></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
