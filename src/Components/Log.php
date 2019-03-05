<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-02-28
 * Version      :   1.0
 */

namespace Program\Components;


use Abstracts\OperateLog;

class Log extends OperateLog
{
    /* @var string 数据表名 */
    protected $tableName = 'program_operate_log';

    /**
     * 必要的初始化操作
     * @throws \Helper\Exception
     */
    public function init()
    {
        parent::init();
        $this->user = Pub::getUser();
    }

    const OPERATE_TYPE_LOGIN = 'login';
    const OPERATE_TYPE_PERSONAL = 'personal';
    const OPERATE_TYPE_TABLE_HEADER = 'table-header';
    const OPERATE_TYPE_MATE = 'mate';
    // todo doing
    const OPERATE_TYPE_ADMIN = 'admin';


    // todo
    const OPERATE_TYPE_FORM_SETTING = 'form-setting';
    const OPERATE_TYPE_REPLACE_SETTING = 'replace-setting';
    const OPERATE_TYPE_NAV = 'nav';
    const OPERATE_TYPE_ACCESS = 'access';
    const OPERATE_TYPE_BLOCK = 'block';
    const OPERATE_TYPE_STATIC_CONTENT = 'static-content';
}