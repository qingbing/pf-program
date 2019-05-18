<?php
$module = \Program\Components\Pub::getModule();
$user = \Program\Components\Pub::getUser();
?><div class="container-fluid">
    <a class="w-navbar-brand" href="<?php echo $module->createUrl('/default/index') ?>">Background For
        Programmer</a>
    <div class="w-navbar-ctrl btn btn-default"><span class="fa fa-bars"></span></div>
    <div class="w-navbar-main">
        <ul class="w-nav">
            <li><a href="<?php echo $module->createUrl('/personal/index'); ?>">个人信息</a></li>
            <li><a href="<?php echo $module->createUrl('/contact/index'); ?>">联系我们</a></li>
        </ul>

        <div class="w-navbar-right">
            <ul class="w-nav">
                <?php if ($user->getIsSuper()) { ?>
                    <li><a href="<?php echo $module->createUrl('/flush/runtime'); ?>" class="text-warning CONFIRM_AJAX" data-message="确认清理缓存么？">清理缓存</a></li>
                <?php } ?>
                <li>
                    <a href="<?php echo $module->createUrl('/personal/index'); ?>"><?php echo $user->getState('nickname'); ?></a>
                </li>
                <li><a href="<?php echo $module->createUrl('/login/logout'); ?>">退出</a></li>
            </ul>
        </div>
    </div>
</div>
    