<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类
use DbSupports\Builder\Criteria;
use Program\Components\Controller;
use Program\Components\Log;
use Program\Components\Pub;
use Program\Models\Admin;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-05
 * Version      :   1.0
 */
class AdminController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_ADMIN;

    /**
     * 默认action：管理员列表
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $fixer = $this->getActionParams();
        $criteria = new Criteria();
        if (isset($fixer['enable']) && '' !== $fixer['enable']) {
            $criteria->addWhere('`is_enable`=:enable');
            $criteria->addParam(':enable', $fixer['enable']);
        }
        if (isset($fixer['super']) && '' !== $fixer['super']) {
            $criteria->addWhere('`is_super`=:super');
            $criteria->addParam(':super', $fixer['super']);
        }
        if (isset($fixer['sex']) && '' !== $fixer['sex']) {
            $criteria->addWhere('`sex`=:sex');
            $criteria->addParam(':sex', $fixer['sex']);
        }
        if (isset($fixer['keyword']) && '' !== $fixer['keyword']) {
            $criteria->addWhereLike('username', $fixer['keyword']);
        }
        // 分页数据查询
        $pager = (new Admin())->pagination($criteria, true);
        // 设置页面标题
        $this->setPageTitle('管理员列表');
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'fixer' => $fixer,
            'pager' => $pager,
        ]);
    }

    /**
     * 添加管理员
     * @throws \Exception
     */
    public function actionAdd()
    {
        // 数据获取
        $model = new Admin();
        // 表单提交处理
        if (isset($_POST['Admin'])) {
            $this->logMessage = '添加管理员';
            $model->setAttributes($_POST['Admin']);
            $model->setAttribute('password', $model->generatePassword($model->password));
            $this->logKeyword = $model->username;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('添加管理员成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('添加管理员');
        // 渲染页面
        $this->render('add', [
            'model' => $model,
        ]);
    }

    /**
     * 编辑管理员
     * @throws \Exception
     */
    public function actionEdit()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['Admin'])) {
            $this->logMessage = '编辑管理员';
            $model->setAttributes($_POST['Admin']);
            $this->logKeyword = $model->username;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('编辑管理员成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('编辑管理员信息');
        // 渲染页面
        $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * 删除管理员
     * @throws \Exception
     */
    public function actionDelete()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['myPassword'])) {
            $this->logMessage = '删除管理员';
            if (!Pub::validMyPassword()) {
                $this->logData = '个人密码为空或不正确';
                $this->failure('个人密码为空或不正确');
            }
            $this->logKeyword = $model->username;
            if ($model->delete()) {
                $this->logData = $model->getAttributes();
                $this->success('删除管理员成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('删除管理员信息');
        // 渲染页面
        $this->render('confirm', [
            'model' => $model,
            'sureButton' => '确认删除',
        ]);
    }

    /**
     * 查看管理员信息
     * @throws \Exception
     */
    public function actionDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 设置页面标题
        $this->setPageTitle('查看管理员信息');
        // 渲染页面
        $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 管理员密码重置
     * @throws \Exception
     */
    public function actionResetPassword()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['Admin'])) {
            $this->logMessage = '管理员密码重置';
            if (!Pub::validMyPassword()) {
                $this->logData = '个人密码为空或不正确';
                $this->failure('个人密码为空或不正确');
            }
            $model->setAttributes($_POST['Admin']);
            $model->setAttribute('password', $model->generatePassword($model->password));
            $this->logKeyword = $model->username;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('管理员密码重置成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('管理员密码重置');
        // 渲染页面
        $this->render('reset_password', [
            'model' => $model,
        ]);
    }

    /**
     * 禁用管理员
     * @throws \Exception
     */
    public function actionForbid()
    {
        // 数据获取
        $model = $this->getModel();
        if ($model->is_enable == 0) {
            $this->throwHttpException(400, '用户已经为禁用状态');
        }
        // 表单提交处理
        if (isset($_POST['myPassword'])) {
            $this->logMessage = '禁用管理员';
            if (!Pub::validMyPassword()) {
                $this->logData = '个人密码为空或不正确';
                $this->failure('个人密码为空或不正确');
            }
            $this->logKeyword = $model->username;
            $model->is_enable = 0;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('禁用管理员成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('禁用管理员');
        // 渲染页面
        $this->render('confirm', [
            'model' => $model,
            'sureButton' => '确认禁用',
        ]);
    }

    /**
     * 启用管理员
     * @throws \Exception
     */
    public function actionEnable()
    {
        // 数据获取
        $model = $this->getModel();
        if ($model->is_enable == 1) {
            $this->throwHttpException(400, '用户已经为启用状态');
        }
        // 表单提交处理
        if (isset($_POST['myPassword'])) {
            $this->logMessage = '启用管理员';
            if (!Pub::validMyPassword()) {
                $this->logData = '个人密码为空或不正确';
                $this->failure('个人密码为空或不正确');
            }
            $this->logKeyword = $model->username;
            $model->is_enable = 1;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('启用管理员成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('启用管理员');
        // 渲染页面
        $this->render('confirm', [
            'model' => $model,
            'sureButton' => '确认启用',
        ]);
    }

    /**
     * 取消超级管理员
     * @throws \Exception
     */
    public function actionDisableSuper()
    {
        // 数据获取
        $model = $this->getModel();
        if ($model->is_super == 0) {
            $this->throwHttpException(403, '用户不是超级管理员');
        }
        // 表单提交处理
        if (isset($_POST['myPassword'])) {
            $this->logMessage = '取消超管';
            if (!Pub::validMyPassword()) {
                $this->logData = '个人密码为空或不正确';
                $this->failure('个人密码为空或不正确');
            }
            $this->logKeyword = $model->username;
            $model->is_super = 0;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('取消超管成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('取消超级管理员');
        // 渲染页面
        $this->render('confirm', [
            'model' => $model,
            'sureButton' => '取消超管',
        ]);
    }

    /**
     * 设为超级管理员
     * @throws \Exception
     */
    public function actionEnableSuper()
    {
        // 数据获取
        $model = $this->getModel();
        if ($model->is_super == 1) {
            $this->throwHttpException(403, '用户是超级管理员');
        }
        // 表单提交处理
        if (isset($_POST['myPassword'])) {
            $this->logMessage = '设置超管';
            if (!Pub::validMyPassword()) {
                $this->logData = '个人密码为空或不正确';
                $this->failure('个人密码为空或不正确');
            }
            $this->logKeyword = $model->username;
            $model->is_super = 1;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('设置超管成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('设置超级管理员');
        // 渲染页面
        $this->render('confirm', [
            'model' => $model,
            'sureButton' => '设置超管',
        ]);
    }

    /**
     * 获取操作用户
     * @return \Abstracts\DbModel|Admin|null
     * @throws \Exception
     */
    protected function getModel()
    {
        $uid = $this->getActionParam('uid');
        $model = Admin::model()->findByPk($uid);
        if (null === $model) {
            $this->throwHttpException(404, '用户不存在');
        }
        return $model;
    }

    /**
     * 检查用户名的唯一性
     * @throws \Exception
     */
    public function actionUniqueUsername()
    {
        // 获取参数
        $fixer = $this->getActionParams();
        // 组装验证内容
        $criteria = new Criteria();
        $criteria->addWhere('`username`=:username')
            ->addParam(':username', $fixer['param']);
        if (isset($fixer['uid']) && $fixer['uid']) {
            $criteria->addWhere('`uid`!=:uid')
                ->addParam(':uid', $fixer['uid']);
        }
        $count = Admin::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("用户名\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("用户名\"{$fixer['param']}\"可用");
        }
    }

    /**
     * 检查用户昵称的唯一性
     * @throws \Exception
     */
    public function actionUniqueNickname()
    {
        // 获取参数
        $fixer = $this->getActionParams();
        // 组装验证内容
        $criteria = new Criteria();
        $criteria->addWhere('`nickname`=:nickname')
            ->addParam(':nickname', $fixer['param']);
        if (isset($fixer['uid']) && $fixer['uid']) {
            $criteria->addWhere('`uid`!=:uid')
                ->addParam(':uid', $fixer['uid']);
        }
        $count = Admin::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("昵称\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("昵称\"{$fixer['param']}\"可用");
        }
    }
}