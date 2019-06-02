<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-05-13
 * Version      :   1.0
 */

namespace Program\Controllers;


use DbSupports\Builder\Criteria;
use Program\Components\Controller;
use Program\Components\Log;
use Program\Models\Nav;

class NavController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_NAV;
    /* @var int 导航模块 ParentID */
    protected $parentId;
    /* @var Nav 父导航 */
    protected $parent;

    /**
     * 在执行action之前调用，可以用该函数来终止向下运行
     * @param \Abstracts\Action $action
     * @return bool
     * @throws \Exception
     */
    protected function beforeAction($action)
    {
        $this->parentId = $this->getActionParam('parentId', 0);
        if (0 != $this->parentId) {
            $this->parent = Nav::model()->findByPk($this->parentId);
            if (null === $this->parent) {
                $this->throwHttpException(404, '不存在的父级导航');
            } else if (1 != $this->parent->is_category) {
                // 不是分类导航，不能添加操作子项
                $this->throwHttpException(403, '导航操作越权');
            }
        }
        return true;
    }

    /**
     * 导航列表
     * @throws \Exception
     */
    public function actionIndex()
    {
        // 获取数据
        $models = $this->findAll();
        // 设置页面标题

        $this->setPageTitle('导航管理' . ($this->parent ? "——{$this->parent->label}" : ''));
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'models' => $models,
            'parentId' => $this->parentId,
        ]);
    }

    /**
     * 添加导航
     * @throws \Exception
     */
    public function actionAdd()
    {
        // 数据获取
        $model = new Nav();
        // 表单提交处理
        if (isset($_POST['Nav'])) {
            $model->setAttributes($_POST['Nav']);
            $model->parent_id = $this->parentId;
            $this->logMessage = "添加导航-{$model->label}";
            if ($model->save()) {
                $this->logKeyword = $model->id;
                $this->logData = $model->getAttributes();
                $this->success('添加导航成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('添加导航');
        // 渲染页面
        $this->render('add', [
            'fixer' => $this->getActionParams(),
            'model' => $model,
        ]);
    }

    /**
     * 编辑导航
     * @throws \Exception
     */
    public function actionEdit()
    {
        // 数据获取
        $model = $this->getModel();
        $fixer = $this->getActionParams();
        unset($fixer['id'], $fixer['parentId']);
        $model->setAttributes($fixer);
        $this->logMessage = '修改导航明细-' . $model->label;
        $this->logKeyword = $model->id;
        if ($model->save()) {
            $this->logData = $this->getActionParams();
            $this->success('修改导航明细成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 编辑导航
     * @throws \Exception
     */
    public function actionEditDescription()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['Nav'])) {
            $model->setAttributes($_POST['Nav']);
            $this->logMessage = '编辑导航-' . $model->label;
            $this->logKeyword = $model->id;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('编辑导航成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('编辑导航——' . $model->label);
        // 渲染页面
        $this->render('edit', [
            'fixer' => $this->getActionParams(),
            'model' => $model,
        ]);
    }

    /**
     * 删除导航
     * @throws \Exception
     */
    public function actionDelete()
    {
        // 数据获取
        $model = $this->getModel();
        $this->logMessage = '删除导航-' . $model->label;
        $this->logKeyword = $model->id;
        if ($model->delete()) {
            $this->logData = $model->getAttributes();
            $this->success('删除导航成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 查看导航信息
     * @throws \Exception
     */
    public function actionDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 设置页面标题
        $this->setPageTitle("查看导航-{$model->label}");
        // 渲染页面
        $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 导航顺序调整
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
        $this->logMessage = '导航顺序调整 - ' . "{$current->id}:{$current->label}<->{$switch->id}:{$switch->label}";
        $this->logKeyword = $current->id;

        $this->logData = [
            'current' => $current->getAttributes(),
            'switch' => $switch->getAttributes(),
        ];
        if ($current->save() && $switch->save()) {
            $this->success('导航顺序调整成功');
        } else {
            $this->failure('导航顺序调整失败');
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
        $this->logMessage = '导航顺序刷新';
        $this->logKeyword = $this->parentId;
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
     * 获取操作导航
     * @return \Abstracts\DbModel|null|Nav
     * @throws \Exception
     */
    protected function getModel()
    {
        $model = Nav::model()->findByPk($this->getActionParam('id'));
        /* @var Nav $model */
        if (null === $model) {
            $this->throwHttpException(404, '导航不存在');
        }
        if ($model->parent_id != $this->parentId) {
            $this->throwHttpException(404, '传递参数不匹配');
        }
        return $model;
    }

    /**
     * 验证导航标记的唯一性
     * @throws \Exception
     */
    public function actionUniqueFlag()
    {
        // 获取参数
        $fixer = $this->getActionParams();
        // 组装验证内容
        $criteria = new Criteria();
        $criteria->addWhere('`flag`=:flag')
            ->addParam(':flag', $fixer['param']);
        if (isset($fixer['id']) && $fixer['id']) {
            $criteria->addWhere('`id`!=:id')
                ->addParam(':id', $fixer['id']);
        }
        $count = Nav::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("导航标记\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("导航标记\"{$fixer['param']}\"可用");
        }
    }

    /**
     * 验证导航别名的唯一性
     * @throws \Exception
     */
    public function actionUniqueLabel()
    {
        // 获取参数
        $fixer = $this->getActionParams();
        // 组装验证内容
        $criteria = new Criteria();
        $criteria->addWhere('`label`=:label')
            ->addParam(':label', $fixer['param']);
        if (isset($fixer['id']) && $fixer['id']) {
            $criteria->addWhere('`id`!=:id')
                ->addParam(':id', $fixer['id']);
        }
        $count = Nav::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("导航名称\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("导航名称\"{$fixer['param']}\"可用");
        }
    }

    /**
     * 获取所有导航
     * @return \Abstracts\DbModel[]|Nav[]|null
     * @throws \Exception
     */
    protected function findAll()
    {
        $criteria = new Criteria();
        $criteria->setWhere('`parent_id`=:parent_id')
            ->addParam(':parent_id', $this->parentId)
            ->setOrder('`sort_order` ASC');
        return Nav::model()->findAll($criteria);
    }
}