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

        // =========================
        // REQUEST
        // =========================
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],

        // =========================
        // USER AUTH
        // =========================
        'user' => [
            'identityClass' => \common\models\User::class,
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-backend',
                'httpOnly' => true,
            ],
            'loginUrl' => ['site/login'],
        ],

        // =========================
        // SESSION
        // =========================
        'session' => [
            'name' => 'advanced-backend',
        ],

        // =========================
        // LOGGING
        // =========================
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        // =========================
        // ERROR HANDLER
        // =========================
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        // =========================
        // URL MANAGER (IMPORTANT 🔥)
        // =========================
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [

                // DASHBOARDS
                'owner' => 'owner-dashboard/index',
                'seller' => 'seller/index',
                'analytics' => 'analytics/index',

                // CORE MODULES
                'products' => 'product/index',
                'sales' => 'sale/index',
                'purchases' => 'purchase/index',
                'branches' => 'branch/index',
                'businesses' => 'business/index',
            ],
        ],
    ],

    'params' => $params,
];