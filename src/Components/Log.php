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
    const OPERATE_TYPE_ADMIN = 'admin';
    const OPERATE_TYPE_FORM_SETTING = 'form-setting';
    const OPERATE_TYPE_REPLACE_SETTING = 'replace-setting';
    const OPERATE_TYPE_BLOCK = 'block';
    // todo doing


    // todo
    const OPERATE_TYPE_NAV = 'nav';
    const OPERATE_TYPE_ACCESS = 'access';
    const OPERATE_TYPE_STATIC_CONTENT = 'static-content';

    /**
     * 是或否
     * @param bool|false $withAll
     * @return array
     */
    static public function type($withAll = false)
    {
        $data = [
            '' => '全部',
            self::OPERATE_TYPE_LOGIN => '登录日志',
            self::OPERATE_TYPE_PERSONAL => '自我维护',
            self::OPERATE_TYPE_MATE => '程序员管理',
            self::OPERATE_TYPE_ADMIN => '管理员管理',
            self::OPERATE_TYPE_TABLE_HEADER => '表头配置',
            self::OPERATE_TYPE_FORM_SETTING => '表单配置',
            self::OPERATE_TYPE_REPLACE_SETTING => '替换模板',
            self::OPERATE_TYPE_NAV => '导航管理',
            self::OPERATE_TYPE_ACCESS => '权限控制',
            self::OPERATE_TYPE_BLOCK => '区块管理',
            self::OPERATE_TYPE_STATIC_CONTENT => '静态内容',
        ];
        if (!$withAll) {
            array_shift($data);
        }
        return $data;
    }

}