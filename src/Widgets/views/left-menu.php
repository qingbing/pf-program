<?php
/* @var boolean $isSuper */
$module = \Program\Components\Pub::getModule();
?>
<div class="w-menu" data-name="program-bg-menu" data-share="true">
    <dl>
        <dt>个人信息</dt>
        <dd><a href="<?php echo $module->createUrl('personal/index'); ?>">个人信息</a></dd>
        <dd><a href="<?php echo $module->createUrl('personal/changeInfo'); ?>">修改信息</a></dd>
        <dd><a href="<?php echo $module->createUrl('personal/changeAvatar'); ?>">上传头像</a></dd>
        <dd><a href="<?php echo $module->createUrl('personal/resetPassword'); ?>">重置密码</a></dd>
    </dl>
    <dl>
        <dt>人员管理</dt>
        <?php if ($isSuper) { ?>
            <dd><a href="<?php echo $module->createUrl('mate/index'); ?>">程序员列表</a></dd>
        <?php } ?>
        <dd><a href="<?php echo $module->createUrl('admin/index'); ?>">管理员列表</a></dd>
    </dl>
    <dl>
        <dt>网站设置</dt>
        <dd><a href="<?php echo $module->createUrl('headerCate/index'); ?>">表头设置</a></dd>
        <dd><a href="<?php echo $module->createUrl('formCate/index'); ?>">表单配置</a></dd>
        <dd><a href="<?php echo $module->createUrl('replace/index'); ?>">替换模板</a></dd>
        <dd><a href="<?php echo $module->createUrl('blockCate/index'); ?>">区块管理</a></dd>
        <dd><a href="<?php echo $module->createUrl('static/index'); ?>">静态内容</a></dd>
    </dl>
    <dl>
        <dt>日志查看</dt>
        <dd><a href="<?php echo $module->createUrl('log/login'); ?>">登录日志</a></dd>
        <dd><a href="<?php echo $module->createUrl('log/index'); ?>">操作日志</a></dd>
    </dl>
</div>