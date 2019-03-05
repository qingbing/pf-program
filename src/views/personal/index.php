<?php
/**
 * @var \Program\Components\Controller $this
 * @var \Program\Models\User $model
 */
$this->widget('\Widgets\FormGenerator', [
    'model' => $model,
    'options' => [
        'uid',
        'username',
        'real_name',
        'nickname',
        'sex' => [
            'callable' => ['\Tools\Labels', 'sex'],
            'type' => 'view',
        ],
        'birthday',
        'avatar' => [
            'function' => [$model, 'showAvatar'],
            'type' => 'view',
        ],
        'mobile',
        'phone',
        'qq',
        'address',
        'zip_code',
        'refer_uid',
        'zip_code',
        'register_ip',
        'register_time',
        'login_times',
        'last_login_ip',
        'last_login_time',
        'is_super' => [
            'callable' => ['\Tools\Labels', 'YesNo'],
            'type' => 'view',
        ],
        'is_enable' => [
            'callable' => ['\Tools\Labels', 'enable'],
            'type' => 'view',
        ],
    ],
]);