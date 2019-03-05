<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类
use Html;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-05
 * Version      :   1.0
 *
 * @var \Program\components\Controller $this
 */
?>
<h3 class="page-header">Welcome to <i><?php echo Html::encode(\PF::app()->name); ?></i></h3>
<div class="form-group row">
    <div class="alert alert-info">
        <p>Congratulations! You have successfully created your application.</p>
        <p>You may change the content of this page by modifying the following two files:</p>
    </div>
</div>
<ul>
    <li>View file: <code><?php echo __FILE__; ?></code></li>
    <li>Layout file: <code><?php echo $this->getLayoutFile($this->layout); ?></code></li>
</ul>
<blockquote>
    <p>
        For more details on how to further develop this application,
        please visit the <a href="<?php echo \PF::home(); ?>" target="_blank">official website</a>.
    </p>
</blockquote>