<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类
use DbSupports\Builder\Criteria;
use Program\components\Controller;
use Program\Components\Log;
use Program\Components\Pub;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-05
 * Version      :   1.0
 */
class LogController extends Controller
{
    /* @var boolean 登录人员是否超管 */
    protected $isSuper;

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @param \Abstracts\Action $action
     * @return bool
     * @throws \Helper\Exception
     */
    protected function beforeAction($action)
    {
        $this->isSuper = Pub::getUser()->getIsSuper();
        return true;
    }

    /**
     * 默认action：操作日志
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $fixer = $this->getActionParams();
        // 数据准备
        $criteria = new Criteria();
        $criteria->setTable('program_operate_log')
            ->setOrder('`id` DESC');
        if (!$this->isSuper) {
            $criteria->addWhere('`uid`=:uid')
                ->addParam(':uid', \PF::app()->getUser()->getUid());
        }
        if (isset($fixer['type']) && '' !== $fixer['type']) {
            $criteria->addWhere('`type`=:type')
                ->addParam(':type', $fixer['type']);
        }
        // 分页数据查询
        $pager = Pub::getApp()->getDb()->pagination($criteria);
        // 设置页面标题
        $this->setPageTitle('操作日志');
        // 渲染页面
        $this->render('index', [
            'fixer' => $fixer,
            'pager' => $pager,
        ]);
    }

    /**
     * 登录日志
     * todo
     */
    public function actionLogin()
    {
        // 数据准备
        $criteria = new Criteria();
        $criteria->setTable('program_operate_log')
            ->addWhere('`type`=:type')
            ->addParam(':type', Log::OPERATE_TYPE_LOGIN)
            ->setOrder('`id` DESC');

        if (!$this->isSuper) {
            $criteria->addWhere('`uid`=:uid')
                ->addParam(':uid', Pub::getUser()->getUid());
        }
        // 分页数据查询
        $pager = Pub::getApp()->getDb()->pagination($criteria);
        // 设置页面标题
        $this->setPageTitle('登录日志');
        // 渲染页面
        $this->render('login', [
            'pager' => $pager,
        ]);
    }

    /**
     * 日志明细
     * todo
     */
    public function actionDetail()
    {
        // 数据准备
        $log = Pub::getApp()->getDb()->createFindCommand()
            ->setTable('program_operate_log')
            ->addWhere('`id`=:id')
            ->addParam(':id', $this->getActionParam('id'))
            ->queryRow();
        // 设置页面标题
        $this->setPageTitle('日志详情');
        // 渲染页面
        $this->layout = '/layouts/modal';
        $this->render('detail', [
            'log' => $log,
        ]);
    }
}