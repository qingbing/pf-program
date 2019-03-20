<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类
use DbSupports\Builder\Criteria;
use Program\Components\Controller;
use Program\Components\Log;
use Program\Components\Pub;
use Program\Models\FormCategory;
use Program\Models\FormOption;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-07
 * Version      :   1.0
 */
class FormOptionController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_FORM_SETTING;
    /* @var FormCategory 表单类型模型 */
    protected $category;
    /* @var boolean 是否超管 */
    protected $isSuper;

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @throws \Exception
     */
    protected function beforeAction($action)
    {
        $this->isSuper = Pub::getUser()->getIsSuper();
        $category = FormCategory::model()->findByPk($this->getActionParam('key'));
        /* @var FormCategory $category */
        if (null === $category) {
            $this->throwHttpException(404, '表头不存在');
        }
        if (!$category->is_open && !$this->isSuper) {
            $this->throwHttpException(403, '对不起，您无权操作该内容');
        }
        $this->category = $category;
        return true;
    }

    /**
     * 默认action : 表单配置选项列表
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $models = $this->findAll();
        // 设置页面标题
        $this->setPageTitle("表单子项列表({$this->category->key}:{$this->category->name})");
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'models' => $models,
            'category' => $this->category,
        ]);
    }

    /**
     * 添加表单配置选项
     * @throws \Exception
     */
    public function actionAdd()
    {
        // 数据获取
        $model = new FormOption();
        // 表单提交处理
        if (isset($_POST['FormOption'])) {
            $this->logMessage = '添加表单配置选项';
            $model->setAttributes($_POST['FormOption']);
            $model->key = $this->category->key;
            if ($model->save()) {
                $this->logKeyword = "{$model->key}:{$model->code}";
                $this->logData = $model->getAttributes();
                $this->success('添加表单配置选项成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle("添加表单子项列表({$this->category->key}:{$this->category->name})");
        // 渲染页面
        $this->render('add', [
            'category' => $this->category,
            'model' => $model,
        ]);
    }

    /**
     * 编辑表单选项
     * @throws \Exception
     */
    public function actionEditDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['FormOption'])) {
            $this->logMessage = '编辑表单选项详情';
            $model->setAttributes($_POST['FormOption']);
            $this->logKeyword = "{$model->key}:{$model->code}";
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('编辑表单选项详情成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('编辑表单选项详情信息');
        // 渲染页面
        $this->render('edit_detail', [
            'category' => $this->category,
            'model' => $model,
        ]);
    }

    /**
     * 编辑表单配置选项，表格编辑
     * @throws \Exception
     */
    public function actionEdit()
    {
        // 数据获取
        $model = $this->getModel();
        $fixer = $this->getActionParams();
        unset($fixer['key']);
        unset($fixer['id']);
        $model->setAttributes($fixer);
        $this->logMessage = '修改表单配置选项';
        $this->logKeyword = "{$model->key}:{$model->code}";
        if ($model->save()) {
            $this->logData = $this->getActionParams();
            $this->success('编辑表单配置选项成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 表单配置选项顺序调整
     * @throws \Exception
     */
    public function actionUpDown()
    {
        // 参数获取
        $fixer = $this->getActionParams();
        $res = $this->findAll();
        $models = [];
        foreach ($res as $re) {
            array_push($models, $re);
        }
        $current = $switch = null;
        while (true) {
            $model = current($models);
            if (!$model) {
                break;
            }
            if ($model->id == $fixer['id']) {
                $current = $model;
                if ('up' === $fixer['sort_order']) {
                    $switch = prev($models);
                } else {
                    $switch = next($models);
                }
                break;
            }
            next($models);
        }
        reset($models);
        if (!$switch) {
            $this->failure('没有可以交换顺序的数据');
        }
        $current_sort_order = $current->sort_order;
        $current->sort_order = $switch->sort_order;
        $switch->sort_order = $current_sort_order;
        // 日志记录
        $this->logMessage = '表单配置选项顺序调整';
        $this->logKeyword = "{$current->key}:{$current->code}";
        $this->logData = [
            'current' => $current->getAttributes(),
            'switch' => $switch->getAttributes(),
        ];
        if ($current->save() && $switch->save()) {
            $this->success('表单配置选项顺序调整成功');
        } else {
            $this->failure('表单配置选项顺序调整失败');
        }
    }

    /**
     * 刷新排序
     * @throws \Exception
     */
    public function actionRefreshSortOrder()
    {
        // 获取数据
        $models = $this->findAll();
        $i = 0;
        $this->logMessage = '表单配置选项顺序刷新';
        $this->logKeyword = "{$this->category->key}";
        $transaction = \PF::app()->getDb()->beginTransaction();
        foreach ($models as $model) {
            $model->sort_order = ++$i;
            if (!$model->save()) {
                $transaction->rollback();
                $this->failure('', $model->getErrors());
            }
        }
        $transaction->commit();
        $this->success('表单配置选项顺序刷新成功');
    }

    /**
     * 删除表单配置选项
     * @throws \Exception
     */
    public function actionDelete()
    {
        // 数据获取
        $model = $this->getModel();
        $this->logMessage = '删除表单配置选项';
        $this->logKeyword = "{$model->key}:{$model->code}";
        if ($model->delete()) {
            $this->logData = $model->getAttributes();
            $this->success('删除表单配置选项成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 获取操作表单配置选项
     * @return \Abstracts\DbModel|FormOption|null
     * @throws \Exception
     */
    protected function getModel()
    {
        $model = FormOption::model()->findByPk($this->getActionParam('id'));
        /* @var FormOption $model */
        if (null === $model) {
            $this->throwHttpException(404, '表单配置选项不存在');
        }
        if ($model->key != $this->category->key) {
            $this->throwHttpException(400, '对不起，您操作的内容参数不匹配');
        }
        return $model;
    }

    /**
     * 获取表头下所有的选项
     * @return \Abstracts\DbModel[]|FormOption[]|null
     * @throws \Exception
     */
    protected function findAll()
    {
        // 获取数据
        $criteria = new Criteria();
        $criteria->addWhere('`key`=:key')
            ->addParam(':key', $this->category->key)
            ->setOrder('`sort_order` ASC');
        return FormOption::model()->findAll($criteria);
    }

    /**
     * 验证表单配置选项标识符的唯一性
     * @throws \Exception
     */
    public function actionUniqueCode()
    {
        // 获取参数
        $fixer = $this->getActionParams();
        // 组装验证内容
        $criteria = new Criteria();
        $criteria->addWhere('`key`=:key AND `code`=:code')
            ->addParam(':key', $this->category->key)
            ->addParam(':code', $fixer['param']);
        if (isset($fixer['id']) && $fixer['id']) {
            $criteria->addWhere('`id`!=:id')
                ->addParam(':id', $fixer['id']);
        }
        $count = FormOption::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("{$this->category->name}中标识符\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("{$this->category->name}中标识符\"{$fixer['param']}\"可用");
        }
    }

    /**
     * 验证表头别名的唯一性
     * @throws \Exception
     */
    public function actionUniqueLabel()
    {
        // 获取参数
        $fixer = $this->getActionParams();
        // 组装验证内容
        $criteria = new Criteria();
        $criteria->addWhere('`key`=:key AND `label`=:label')
            ->addParam(':key', $this->category->key)
            ->addParam(':label', $fixer['param']);
        if (isset($fixer['id']) && $fixer['id']) {
            $criteria->addWhere('`id`!=:id')
                ->addParam(':id', $fixer['id']);
        }
        $count = FormOption::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("{$this->category->name}中别名\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("{$this->category->name}中别名\"{$fixer['param']}\"可用");
        }
    }
}