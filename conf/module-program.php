<?php
/**
 * Link         :   http://www.phpcorner.net
 * User         :   qingbing<780042175@qq.com>
 * Date         :   2019-02-24
 * Version      :   1.0
 */
return [
    'class' => '\Program\Module',
    'layout' => '/layouts/main',
    'preLoad' => ['session'],
    'components' => [
        'user' => [
            'class' => '\Program\Components\WebUser',
            'cookieKey' => 'program.user.username',
            'rememberTime' => 864000,
            'namespace' => 'program.user',
            'expire' => 600,
            'prefix' => 'program.user_',
            'loginUrl' => ['program/login/index'],
            'returnUrl' => ['program/default/index'],
        ],
    ],
];