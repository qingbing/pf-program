<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-02-28
 * Version      :   1.0
 */

namespace Program\Controllers;


use Program\Components\Controller;
use Program\Components\Pub;

class DefaultController extends Controller
{
    /**
     * @throws \Exception
     */
    public function actionIndex()
    {
        $this->redirect(['/Contact/index']);
    }

    /**
     * @throws \Exception
     */
    public function actionError()
    {
        $this->layout = '/layouts/html';
        if (APP_DEBUG) {
            var_dump(Pub::getApp()->getErrorHandler()->getError());
        } else if ($error = Pub::getApp()->getErrorHandler()->getError()) {
            if (Pub::getApp()->getRequest()->getIsAjaxRequest()) {
                echo $error['message'];
            } else {
                $this->render('error', [
                    'error' => $error,
                ]);
            }
        }
    }
}