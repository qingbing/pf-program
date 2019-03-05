<?php
/* @var \Render\Abstracts\Controller $this */
/* @var string $content ; */
$this->beginContent('/layouts/html');
?>
    <div class="w-navbar w-navbar-top"><?php $this->widget('\Program\Widgets\Header'); ?></div>
    <div id="header-container"><!--  占位，漂浮 header 的高度 --></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 col-md-2 col-lg-2"><?php $this->widget('\Program\Widgets\LeftMenu'); ?></div>
            <div class="col-sm-10 col-md-10 col-lg-10">
                <h3 class="page-header"><?php if ($this->getClip('title')) {
                        echo $this->getClip('title');
                    } else {
                        echo $this->getId() . '/' . $this->getAction()->getId();
                    } ?></h3>
                <?php echo $content; ?></div>
        </div>
    </div>
    <div id="footer"><?php $this->widget('\Program\Widgets\Footer'); ?></div>
<?php $this->endContent(); ?>