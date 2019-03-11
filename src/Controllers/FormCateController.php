<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类
use DbSupports\Builder\Criteria;
use Helper\HttpException;
use Program\Components\Controller;
use Program\Components\Log;
use Program\Components\Pub;
use Program\Models\FormCategory;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-07
 * Version      :   1.0
 */
class FormCateController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_FORM_SETTING;
    /* @var boolean 是否超管 */
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
     * 默认action : 表单配置类型列表
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $fixer = $this->getActionParams();
        $criteria = new Criteria();

        if (!$this->isSuper) {
            $criteria->addWhere('`is_open`=:is_open')
                ->addParam(':is_open', 1);
        } else if (isset($fixer['is_open']) && '' !== $fixer['is_open']) {
            $criteria->addWhere('`is_open`=:is_open')
                ->addParam(':is_open', $fixer['is_open']);
        }
        if (isset($fixer['is_enable']) && '' !== $fixer['is_enable']) {
            $criteria->addWhere('`is_enable`=:is_enable')
                ->addParam(':is_enable', $fixer['is_enable']);
        }
        if (isset($fixer['keyword']) && '' !== $fixer['keyword']) {
            $criteria->addWhereLike('name', $fixer['keyword']);
        }

        // 模型分页查询
        $pager = (new FormCategory())->pagination($criteria, true);
        // 设置页面标题
        $this->setPageTitle('表单配置类型');
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'isSuper' => $this->isSuper,
            'fixer' => $fixer,
            'pager' => $pager,
        ]);
    }

    /**
     * 添加表单配置类型
     * @throws \Exception
     */
    public function actionAdd()
    {
        // 数据获取
        $model = new FormCategory();
        // 表单提交处理
        if (isset($_POST['FormCategory'])) {
            $this->logMessage = '添加表单配置类型';
            $model->setAttributes($_POST['FormCategory']);
            if ($model->save()) {
                $this->logKeyword = $model->key;
                $this->logData = $model->getAttributes();
                $this->success('添加表单配置类型成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('添加表单配置类型');
        // 渲染页面
        $this->render('add', [
            'model' => $model,
            'isSuper' => $this->isSuper,
        ]);
    }

    /**
     * 编辑表单配置类型
     * @throws \Exception
     */
    public function actionEdit()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['FormCategory'])) {
            $this->logMessage = '编辑表单配置类型';
            $model->setAttributes($_POST['FormCategory']);
            $this->logKeyword = $model->key;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('编辑表单配置类型成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('编辑表单配置类型信息');
        // 渲染页面
        $this->render('edit', [
            'model' => $model,
            'isSuper' => $this->isSuper,
        ]);
    }

    /**
     * 删除表单配置类型
     * @throws \Exception
     */
    public function actionDelete()
    {
        // 数据获取
        $model = $this->getModel();
        $this->logMessage = '删除表单配置类型';
        $this->logKeyword = $model->key;
        if ($model->delete()) {
            $this->logData = $model->getAttributes();
            $this->success('删除表单配置类型成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 查看表单配置类型信息
     * @throws \Exception
     */
    public function actionDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 设置页面标题
        $this->setPageTitle('查看表单配置类型信息');
        // 渲染页面
        $this->render('detail', [
            'model' => $model,
            'isSuper' => $this->isSuper,
        ]);
    }

    /**
     * 获取操作表单配置类型
     * @return \Abstracts\DbModel|FormCategory|null
     * @throws \Exception
     */
    protected function getModel()
    {
        $model = FormCategory::model()->findByPk($this->getActionParam('key'));
        /* @var FormCategory $model */
        if (null === $model) {
            throw new HttpException('表头不存在', 404);
        }
        if (!$model->is_open && !$this->isSuper) {
            throw new HttpException('对不起，您无权操作该内容', 403);
        }
        return $model;
    }

    /**
     * 验证表头标识符的唯一性
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
        $count = FormCategory::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("表单配置标识符\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("表单配置标识符\"{$fixer['param']}\"可用");
        }
    }

    /**
     * 验证表头别名的唯一性
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
        $count = FormCategory::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("表单配置别名\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("表单配置别名\"{$fixer['param']}\"可用");
        }
    }
}