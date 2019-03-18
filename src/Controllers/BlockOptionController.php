<?php
// 申明命名空间
namespace Program\Controllers;
// 引用类
use DbSupports\Builder\Criteria;
use Program\Components\Controller;
use Program\Components\Log;
use Program\Models\BlockCategory;
use Program\Models\BlockOption;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-15
 * Version      :   1.0
 */
class BlockOptionController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_BLOCK;
    /* @var BlockCategory */
    protected $category;

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @param \Abstracts\Action $action
     * @return bool
     * @throws \Exception
     */
    protected function beforeAction($action)
    {
        $category = BlockCategory::model()->findByPk($this->getActionParam('key'));
        if (null === $category) {
            $this->throwHttpException(404, '区块类型不存在');
        }
        $this->category = $category;
        return true;
    }

    /**
     * 默认action : 区块子项列表
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $models = $this->findAll();
        // 设置页面标题
        $this->setPageTitle("区块子项列表({$this->category->key}:{$this->category->name})");
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'models' => $models,
            'category' => $this->category,
        ]);
    }

    /**
     * 添加区块子项
     * @throws \Exception
     */
    public function actionAdd()
    {
        // 数据获取
        $model = new BlockOption();
        // 表单提交处理
        if (isset($_POST['BlockOption'])) {
            $this->logMessage = '添加区块子项';
            $model->setAttributes($_POST['BlockOption']);
            $model->key = $this->category->key;
            if ($model->save()) {
                $this->logKeyword = "{$model->key}:{$model->id}";
                $this->logData = $model->getAttributes();
                $this->success('添加区块子项成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle("添加区块子项({$this->category->key}:{$this->category->name})");
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
        if (isset($_POST['BlockOption'])) {
            $this->logMessage = '编辑表单选项详情';
            $model->setAttributes($_POST['BlockOption']);
            $this->logKeyword = "{$model->key}:{$model->id}";
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
     * 编辑区块子项
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
        $this->logMessage = '修改区块子项';
        $this->logKeyword = "{$model->key}:{$model->id}";
        if ($model->save()) {
            $this->logData = $this->getActionParams();
            $this->success('编辑区块子项成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 查看区块子项信息
     * @throws \Exception
     */
    public function actionDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 设置页面标题
        $this->setPageTitle('查看区块子项信息');
        // 渲染页面
        $this->render('detail', [
            'category' => $this->category,
            'model' => $model,
        ]);
    }

    /**
     * 区块子项顺序调整
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
        $this->logMessage = '区块子项顺序调整';
        $this->logKeyword = "{$current->key}:{$current->id}";
        $this->logData = [
            'current' => $current->getAttributes(),
            'switch' => $switch->getAttributes(),
        ];
        if ($current->save() && $switch->save()) {
            $this->success('区块子项顺序调整成功');
        } else {
            $this->failure('区块子项顺序调整失败');
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
        $this->logMessage = '区块子项顺序刷新';
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
        $this->success('区块子项顺序刷新成功');
    }

    /**
     * 删除区块子项
     * @throws \Exception
     */
    public function actionDelete()
    {
        // 数据获取
        $model = $this->getModel();
        $this->logMessage = '删除区块子项';
        $this->logKeyword = "{$model->key}:{$model->id}";
        if ($model->delete()) {
            $this->logData = $model->getAttributes();
            $this->success('删除区块子项成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 获取操作区块子项
     * @return \Abstracts\DbModel|BlockOption|null
     * @throws \Exception
     */
    protected function getModel()
    {
        $model = BlockOption::model()->findByPk($this->getActionParam('id'));
        if (null === $model) {
            $this->throwHttpException(404, '区块子项不存在');
        }
        if ($model->key != $this->category->key) {
            $this->throwHttpException(403, '对不起，您操作的内容参数不匹配');
        }
        return $model;
    }

    /**
     * 获取表头下所有的选项
     * @return \Abstracts\DbModel[]|BlockOption[]|null
     * @throws \Exception
     */
    protected function findAll()
    {
        // 获取数据
        $criteria = new Criteria();
        $criteria->addWhere('`key`=:key')
            ->addParam(':key', $this->category->key)
            ->setOrder('`sort_order` ASC');
        return BlockOption::model()->findAll($criteria);
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
        $count = BlockOption::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("{$this->category->name}中名称\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("{$this->category->name}中名称\"{$fixer['param']}\"可用");
        }
    }
}