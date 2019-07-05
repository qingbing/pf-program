<?php
// 申明命名空间
namespace Program\Controllers;

// 引用类
use Helper\Coding;
use Html;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-04
 * Version      :   1.0
 *
 * @var \Program\Components\Controller $this
 * @var \Program\Models\HeaderCategory $category
 * @var \Program\Models\HeaderOption[] $models
 */
?>
<div class="margin-bottom">
    <a href="<?php echo $this->createUrl('add', ['key' => $category->key]); ?>" class="btn btn-primary w-modal">
        <i class="fa fa-plus">添加</i>
    </a>
    <a href="<?php echo $this->createUrl('refreshSortOrder', ['key' => $category->key]); ?>"
       class="btn btn-primary ACTION-HREF" data-message="确认刷新表头选项顺序么？" data-is-ajax="true" data-reload="true"><i
                class="fa fa-refresh">刷新排序</i></a>
</div>
<div class="row">
    <table class="table table-hover table-bordered table-striped w-edit-table"
           data-ajax-url="<?php echo $this->createUrl('edit', ['key' => $category->key]); ?>"
           data-post-data='<?php echo Coding::json_encode(['key' => $category->key], true); ?>'>
        <thead>
        <tr>
            <th class="text-center" width="100px">字段名</th>
            <th class="text-center" width="100px">显示名</th>
            <th class="text-center" width="60px">默认值</th>
            <th class="text-center" width="60px">宽度</th>
            <th class="text-center" width="50px">分类排序</th>
            <th class="text-center" width="100px">显示位置</th>
            <th class="text-center" width="50px">必选</th>
            <th class="text-center" width="50px">默认</th>
            <th class="text-center" width="50px">启用状态</th>
            <th class="text-center" width="50px">可排序</th>
            <th class="text-center" width="150px">操作</th>
            <th class="text-center" width="100px">操作显示</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($models as $model) {
            $cssClass = $model->cssClass();
            $options = [];
            if ($model->is_required) {
                $options['disabled'] = 'disabled';
            }
            ?>
            <tr data-post-data='<?php echo Coding::json_encode(['id' => $model->id], true); ?>'
                data-tip=".w_display_status">
                <td class="text-left" data-name="code"><?php echo $model->code; ?></td>
                <td class="text-left" data-name="label"><?php echo $model->label; ?></td>
                <td class="text-left" data-name="default"><?php echo $model->default; ?></td>
                <td class="text-left" data-name="width"><?php echo $model->width; ?></td>
                <td class="text-left" data-name="sort_order"><?php echo $model->sort_order; ?></td>
                <td class="text-left" data-name="css_class" data-type="select"
                    data-options='<?php echo Coding::json_encode($cssClass, true); ?>'><?php echo $cssClass[$model->css_class]; ?></td>
                <td class="text-center" data-name="is_required" data-reload="true">
                    <?php echo Html::checkBox('is_required', !!$model->is_required); ?>
                </td>
                <td class="text-center" data-name="is_default">
                    <?php echo Html::checkBox('is_default', !!$model->is_default, $options); ?>
                </td>
                <td class="text-center" data-name="is_enable">
                    <?php echo Html::checkBox('is_enable', !!$model->is_enable, $options); ?>
                </td>
                <td class="text-center" data-name="is_sortable">
                    <?php echo Html::checkBox('is_sortable', !!$model->is_sortable); ?>
                </td>
                <td class="text-center" data-name="sort_order" data-type="upDown" data-reload="true"
                    data-ajax-url="<?php echo $this->createUrl('upDown', ['key' => $category->key, 'id' => $model->id]) ?>">
                    <a href="<?php echo $this->createUrl('delete', ['key' => $category->key, 'id' => $model->id]) ?>"
                       class="btn btn-danger ACTION-HREF" data-message="确认要删除该选项么？" data-is-ajax="true" data-reload="true">
                        <i class="fa fa-trash">删除</i>
                    </a>
                </td>
                <td class="w_display_status"></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>