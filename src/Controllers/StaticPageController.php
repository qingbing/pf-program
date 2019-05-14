<?php
// 申明命名空间
namespace Program\Controllers;

// 引用类
use DbSupports\Builder\Criteria;
use Program\Components\Controller;
use Program\Components\Log;
use Program\Models\StaticContent;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-05-14
 * Version      :   1.0
 */
class StaticPageController extends Controller
{

    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_STATIC_CONTENT;

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @param \Abstracts\Action $action
     * @return bool
     */
    protected function beforeAction($action)
    {
        return true;
    }

    /**
     * 默认action : 静态内容列表
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $fixer = $this->getActionParams();
        $criteria = new Criteria();
        $criteria->setOrder('`sort_order` ASC');

        if (isset($fixer['code']) && '' !== $fixer['code']) {
            $criteria->addWhere('`code`=:code')
                ->addParam(':code', $fixer['code']);
        }
        if (isset($fixer['keyword']) && '' !== $fixer['keyword']) {
            $criteria->addWhereLike('subject', $fixer['keyword']);
        }

        // 模型分页查询
        $pager = (new StaticContent())->pagination($criteria, true);
        // 设置页面标题
        $this->setPageTitle('静态内容管理');
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'fixer' => $fixer,
            'pager' => $pager,
        ]);
    }

    /**
     * 添加静态内容
     */
    public function actionAdd()
    {
        // 数据获取
        $model = new StaticContent();
        // 表单提交处理
        if (isset($_POST['StaticContent'])) {
            $model->setAttributes($_POST['StaticContent']);
            $this->logMessage = '添加静态内容';
            $this->logKeyword = $model->subject;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('添加静态内容成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('添加静态内容');
        // 渲染页面
        $this->render('add', [
            'model' => $model,
        ]);
    }

    /**
     * 编辑静态内容
     */
    public function actionEdit()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['StaticContent'])) {
            $model->setAttributes($_POST['StaticContent']);
            $this->logMessage = '编辑静态内容';
            $this->logKeyword = $model->subject;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('编辑静态内容成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('编辑静态内容信息');
        // 渲染页面
        $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * 查看静态内容信息
     */
    public function actionDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 设置页面标题
        $this->setPageTitle('查看静态内容信息');
        // 渲染页面
        $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 删除静态内容
     */
    public function actionDelete()
    {
        // 数据获取
        $model = $this->getModel();
        $this->logMessage = '删除静态内容';
        $this->logKeyword = $model->subject;
        if ($model->delete()) {
            $this->logData = $model->getAttributes();
            $this->success('删除静态内容成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * @return null|\pf\db\ActiveRecord|StaticContent
     * @throws HttpException
     */
    protected function getModel()
    {
        $id = \PF::app()->getRequest()->getParam('id');
        $model = StaticContent::model()->findByPk($id);
        /* @var StaticContent $model */
        if (null === $model) {
            throw new HttpException('静态内容不存在', 404);
        }
        return $model;
    }
}