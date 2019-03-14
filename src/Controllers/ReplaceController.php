<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类
use DbSupports\Builder\Criteria;
use Program\Components\Controller;
use Program\Components\Log;
use Program\Models\ReplaceSetting;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-13
 * Version      :   1.0
 */
class ReplaceController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_REPLACE_SETTING;

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
     * 默认action
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $fixer = $this->getActionParams();
        $criteria = new Criteria();
        $criteria->setOrder('`sort_order` ASC');
        if (isset($fixer['is_enable']) && '' !== $fixer['is_enable']) {
            $criteria->addWhere('`is_enable`=:is_enable')
                ->addParam(':is_enable', $fixer['is_enable']);
        }
        if (isset($fixer['keyword']) && '' !== $fixer['keyword']) {
            $criteria->addWhereLike('name', $fixer['keyword']);
        }

        // 模型分页查询
        $pager = (new ReplaceSetting())->pagination($criteria, true);
        // 设置页面标题
        $this->setPageTitle('替换模板管理');
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'fixer' => $fixer,
            'pager' => $pager,
        ]);
    }

    /**
     * 添加替换模板
     * @throws \Exception
     */
    public function actionAdd()
    {
        // 数据获取
        $model = new ReplaceSetting();
        // 表单提交处理
        if (isset($_POST['ReplaceSetting'])) {
            if (!isset($_POST['ReplaceSetting']['replace_type'])) {
                $_POST['ReplaceSetting']['replace_type'] = [];
            }
            $model->setAttributes($_POST['ReplaceSetting']);
            $this->logMessage = '添加替换模板';
            if ($model->save()) {
                $this->logKeyword = "{$model->key}";
                $this->logData = $model->getAttributes();
                $this->success('添加替换模板成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('添加替换模板');
        // 渲染页面
        $this->render('add', [
            'model' => $model,
        ]);
    }

    /**
     * 编辑替换模板
     * @throws \Exception
     */
    public function actionEdit()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['ReplaceSetting'])) {
            if (!isset($_POST['ReplaceSetting']['replace_type'])) {
                $_POST['ReplaceSetting']['replace_type'] = [];
            }
            $model->setAttributes($_POST['ReplaceSetting']);
            $this->logMessage = '编辑替换模板';
            $this->logKeyword = "{$model->key}";
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('编辑替换模板成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('编辑替换模板');
        // 渲染页面
        $this->render('edit', [
            'fixer' => $this->getActionParams(),
            'model' => $model,
        ]);
    }

    /**
     * 删除替换模板
     * @throws \Exception
     */
    public function actionDelete()
    {
        // 数据获取
        $model = $this->getModel();
        $this->logMessage = '删除替换模板';
        $this->logKeyword = "{$model->key}";
        if ($model->delete()) {
            $this->logData = $model->getAttributes();
            $this->success('删除替换模板成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 获取操作替换模板
     * @return \Abstracts\DbModel|ReplaceSetting|null
     * @throws \Exception
     */
    protected function getModel()
    {
        $model = ReplaceSetting::model()->findByPk($this->getActionParam('key'));
        /* @var ReplaceSetting $model */
        if (null === $model) {
            $this->throwHttpException(404, '替换模板不存在');
        }
        return $model;
    }

    /**
     * 验证替换模板标识符的唯一性
     * @throws \Exception
     */
    public function actionUniqueKey()
    {
        // 获取参数
        $fixer = $this->getActionParams();
        // 组装验证内容
        $criteria = new Criteria();
        $criteria->addWhere('`key`=:key')
            ->addParam(':key', $fixer['param']);
        $count = ReplaceSetting::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("标志\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("标志\"{$fixer['param']}\"可用");
        }
    }

    /**
     * 验证替换模板名称的唯一性
     * @throws \Exception
     */
    public function actionUniqueName()
    {
        // 获取参数
        $fixer = $this->getActionParams();
        // 组装验证内容
        $criteria = new Criteria();
        $criteria->addWhere('`name`=:name')
            ->addParam(':name', $fixer['param']);
        if (isset($fixer['key']) && $fixer['key']) {
            $criteria->addWhere('`key`!=:key')
                ->addParam(':key', $fixer['key']);
        }
        $count = ReplaceSetting::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("名称\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("名称\"{$fixer['param']}\"可用");
        }
    }
}