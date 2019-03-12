<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类
use DbSupports\Builder\Criteria;
use Helper\HttpException;
use Program\Components\Controller;
use Program\Components\Log;
use Program\Components\Pub;
use Program\models\User;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-03
 * Version      :   1.0
 */
class MateController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_MATE;

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @param \Abstracts\Action $action
     * @return bool
     * @throws \Exception
     */
    protected function beforeAction($action)
    {
        if (Pub::getUser()->getIsSuper()) {
            return true;
        }
        $this->throwHttpException(403, '对不起，您无权操作该模块');
    }

    /**
     * 默认action
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $fixer = $this->getActionParams();
        $criteria = new Criteria();
        $criteria->addWhere('`uid`!=:uid');
        $criteria->addParam(':uid', Pub::getUser()->getUid());
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
        // 数据分页查询
        $pager = (new User())->pagination($criteria, true);
        // 设置页面标题
        $this->setPageTitle('程序员列表');
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'fixer' => $fixer,
            'pager' => $pager,
        ]);
    }

    /**
     * 添加程序员
     * @throws \Exception
     */
    public function actionAdd()
    {
        // 数据获取
        $model = new User();
        // 表单提交处理
        if (isset($_POST['User'])) {
            $this->logMessage = '添加程序员';
            if (!Pub::validMyPassword()) {
                $this->logData = '个人密码为空或不正确';
                $this->failure('个人密码为空或不正确');
            }
            $model->setAttributes($_POST['User']);
            $model->setAttribute('password', $model->generatePassword($model->password));
            $this->logKeyword = $model->username;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('添加程序员成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('添加程序员');
        // 渲染页面
        $this->render('add', [
            'model' => $model,
        ]);
    }

    /**
     * 编辑程序员
     * @throws \Exception
     */
    public function actionEdit()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['User'])) {
            $this->logMessage = '编辑程序员';
            if (!Pub::validMyPassword()) {
                $this->logData = '个人密码为空或不正确';
                $this->failure('个人密码为空或不正确');
            }
            $model->setAttributes($_POST['User']);
            $this->logKeyword = $model->username;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('编辑程序员成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('编辑程序员信息');
        // 渲染页面
        $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * 删除程序员
     * @throws \Exception
     */
    public function actionDelete()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['myPassword'])) {
            $this->logMessage = '删除程序员';
            if (!Pub::validMyPassword()) {
                $this->logData = '个人密码为空或不正确';
                $this->failure('个人密码为空或不正确');
            }
            $this->logKeyword = $model->username;
            if ($model->delete()) {
                $this->logData = $model->getAttributes();
                $this->success('删除程序员成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('删除程序员信息');
        // 渲染页面
        $this->render('confirm', [
            'model' => $model,
            'sureButton' => '确认删除',
        ]);
    }

    /**
     * 查看程序员信息
     * @throws \Exception
     */
    public function actionDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 设置页面标题
        $this->setPageTitle('查看程序员信息');
        // 渲染页面
        $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 程序员密码重置
     * @throws \Exception
     */
    public function actionResetPassword()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['User'])) {
            $this->logMessage = '程序员密码重置';
            if (!Pub::validMyPassword()) {
                $this->logData = '个人密码为空或不正确';
                $this->failure('个人密码为空或不正确');
            }
            $model->setAttributes($_POST['User']);
            $model->setAttribute('password', $model->generatePassword($model->password));
            $this->logKeyword = $model->username;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('程序员密码重置成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('程序员密码重置');
        // 渲染页面
        $this->render('reset_password', [
            'model' => $model,
        ]);
    }

    /**
     * 禁用程序员
     * @throws \Exception
     */
    public function actionForbid()
    {
        // 数据获取
        $model = $this->getModel();
        if ($model->is_enable == 0) {
            $this->throwHttpException(403, '用户已经为禁用状态');
        }
        // 表单提交处理
        if (isset($_POST['myPassword'])) {
            $this->logMessage = '禁用程序员';
            if (!Pub::validMyPassword()) {
                $this->logData = '个人密码为空或不正确';
                $this->failure('个人密码为空或不正确');
            }
            $this->logKeyword = $model->username;
            $model->is_enable = 0;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('禁用程序员成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('禁用程序员');
        // 渲染页面
        $this->render('confirm', [
            'model' => $model,
            'sureButton' => '确认禁用',
        ]);
    }

    /**
     * 启用程序员
     * @throws \Exception
     */
    public function actionEnable()
    {
        // 数据获取
        $model = $this->getModel();
        if ($model->is_enable == 1) {
            $this->throwHttpException(403, '用户已经为启用状态');
        }
        // 表单提交处理
        if (isset($_POST['myPassword'])) {
            $this->logMessage = '启用程序员';
            if (!Pub::validMyPassword()) {
                $this->logData = '个人密码为空或不正确';
                $this->failure('个人密码为空或不正确');
            }
            $this->logKeyword = $model->username;
            $model->is_enable = 1;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('启用程序员成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('启用程序员');
        // 渲染页面
        $this->render('confirm', [
            'model' => $model,
            'sureButton' => '确认启用',
        ]);
    }

    /**
     * 获取操作用户
     * @return User|null
     * @throws \Exception
     */
    protected function getModel()
    {
        $model = User::model()->findByPk($this->getActionParam('uid'));
        if (null === $model) {
            $this->throwHttpException(404, '用户不存在');
        }
        return $model;
    }
}