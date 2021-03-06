<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableSession' => 'false',
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'doctor',
                    'except' => ['view', 'create', 'update', 'delete'],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'user',
                    'except' => ['index', 'view', 'update', 'delete'],
                    'extraPatterns' => [
                        'POST authorize' => 'authorize',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'time-slot',
                    'only' => ['create', 'delete', 'list'],
                    'extraPatterns' => [
                        'GET' => 'list',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'record',
                    'only' => ['create', 'index'],
                ]
            ],
        ],
    ],
    'params' => $params,
];
