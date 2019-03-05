<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-03-01
 * Version      :   1.0
 */

namespace Program\Widgets;


use Abstracts\OutputCache;

class Header extends OutputCache
{

    /**
     * 在 @link init() 之前运行
     * @return string|array|mixed
     */
    protected function generateId()
    {
        return [
            'program.widgets.header'
        ];
    }

    /**
     * 构建 cache-content ： 在 @link init() 之后运行
     * @return mixed|void
     * @throws \Exception
     */
    protected function generateContent()
    {
        $this->render('header', []);
    }
}