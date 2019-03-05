<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-01
 * Version      :   1.0
 */

namespace Program\Controllers;


use Program\Components\Controller;

class ContactController extends Controller
{
    /**
     * 联系我们
     * @throws \Helper\Exception
     */
    public function actionIndex()
    {
        // 设置页面标题
        $this->setClip('title', '联系我们');
        // 渲染页面
        $this->render('index', []);
    }
}