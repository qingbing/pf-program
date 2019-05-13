<?php
// 申明命名空间
namespace Program\Controllers;

// 引用类
use DbSupports\Builder\Criteria;
use Program\Components\Controller;
use Program\Components\Log;
use Program\Models\BlockCategory;

/**
 * Created by generate tool of phpcorner.
 * Link         :   http://www.phpcorner.net/
 * User         :   qingbing
 * Date         :   2019-03-15
 * Version      :   1.0
 */
class BlockCateController extends Controller
{
    /* @var mixed 控制器的layout */
    public $layout = '/layouts/modal';
    /* @var boolean 是否开启操作日志，默认关闭 */
    protected $openLog = true;
    /* @var string 日志类型 */
    protected $logType = Log::OPERATE_TYPE_BLOCK;

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

        if (isset($fixer['is_open']) && '' !== $fixer['is_open']) {
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
        $pager = (new BlockCategory())->pagination($criteria, true);
        // 设置页面标题
        $this->setPageTitle('区块类型');
        // 渲染页面
        $this->layout = '/layouts/main';
        $this->render('index', [
            'fixer' => $fixer,
            'pager' => $pager,
        ]);
    }

    /**
     * 添加区块类型
     * @throws \Exception
     */
    public function actionAdd()
    {
        // 数据获取
        $model = new BlockCategory();
        // 表单提交处理
        if (isset($_POST['BlockCategory'])) {
            $this->logMessage = '添加区块类型';
            $model->setAttributes($_POST['BlockCategory']);
            if ($model->save()) {
                $this->logKeyword = $model->key;
                $this->logData = $model->getAttributes();
                $this->success('添加区块类型成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('添加区块类型');
        // 渲染页面
        $this->render('add', [
            'model' => $model,
        ]);
    }

    /**
     * 编辑区块类型
     * @throws \Exception
     */
    public function actionEdit()
    {
        // 数据获取
        $model = $this->getModel();
        // 表单提交处理
        if (isset($_POST['BlockCategory'])) {
            $this->logMessage = '编辑区块类型';
            $model->setAttributes($_POST['BlockCategory']);
            $this->logKeyword = $model->key;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('编辑区块类型成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('编辑区块类型信息');
        // 渲染页面
        $this->render('edit', [
            'model' => $model,
        ]);
    }

    /**
     * 删除区块类型
     * @throws \Exception
     */
    public function actionDelete()
    {
        // 数据获取
        $model = $this->getModel();
        $this->logMessage = '删除区块类型';
        $this->logKeyword = $model->key;
        if ($model->delete()) {
            $this->logData = $model->getAttributes();
            $this->success('删除区块类型成功');
        } else {
            $this->failure('', $model->getErrors());
        }
    }

    /**
     * 修改内容区块的内容信息
     * @throws \Exception
     */
    public function actionContent()
    {
        // 数据获取
        $model = $this->getModel();
        if (BlockCategory::TYPE_CONTENT !== $model->type) {
            $this->throwHttpException(404, '错误的区块操作');
        }
        // 表单提交处理
        if (isset($_POST['BlockCategory'])) {
            $this->logMessage = '编辑区块内容';
            $model->setAttributes($_POST['BlockCategory']);
            $this->logKeyword = $model->key;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('编辑区块内容成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('编辑区块内容');
        // 渲染页面
        $this->render('content', [
            'model' => $model,
        ]);
    }

    /**
     * 修改图片区块的图片信息
     * @throws \Exception
     */
    public function actionImage()
    {
        // 数据获取
        $model = $this->getModel();
        if (BlockCategory::TYPE_IMAGE_LINK !== $model->type) {
            $this->throwHttpException(404, '错误的区块操作');
        }
        // 表单提交处理
        if (isset($_POST['BlockCategory'])) {
            $this->logMessage = '修改区块图片信息';
            if (isset($_POST['BlockCategory']['src'])) {
                // 图片上传会使用 $_FILES
                unset($_POST['BlockCategory']['src']);
            }
            $model->setAttributes($_POST['BlockCategory']);
            $this->logKeyword = $model->key;
            if ($model->save()) {
                $this->logData = $model->getAttributes();
                $this->success('修改区块图片信息成功');
            } else {
                $this->failure('', $model->getErrors());
            }
        }
        // 设置页面标题
        $this->setPageTitle('上传图片信息');
        // 渲染页面
        $this->render('image', [
            'model' => $model,
        ]);
    }

    /**
     * 查看区块类型信息
     * @throws \Exception
     */
    public function actionDetail()
    {
        // 数据获取
        $model = $this->getModel();
        // 设置页面标题
        $this->setPageTitle('查看区块类型信息');
        // 渲染页面
        $this->render('detail', [
            'model' => $model,
        ]);
    }

    /**
     * 获取操作区块类型
     * @return \Abstracts\DbModel|BlockCategory|null
     * @throws \Exception
     */
    protected function getModel()
    {
        $model = BlockCategory::model()->findByPk($this->getActionParam('key'));
        if (null === $model) {
            $this->throwHttpException(404, '区块不存在');
        }
        return $model;
    }

    /**
     * 验证区块标识符的唯一性
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
        $count = BlockCategory::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("区块标识符\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("区块标识符\"{$fixer['param']}\"可用");
        }
    }

    /**
     * 验证区块别名的唯一性
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
        $count = BlockCategory::model()->count($criteria);
        // 返回验证结果
        $this->openLog = false;
        if ($count > 0) {
            $this->failure("区块名称\"{$fixer['param']}\"已经存在");
        } else {
            $this->success("区块名称\"{$fixer['param']}\"可用");
        }
    }
}