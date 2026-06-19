<?php

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [

    // =========================
    // APP ID
    // =========================
    'id' => 'app-backend',

    // =========================
    // BASE PATH
    // =========================
    'basePath' => dirname(__DIR__),

    // =========================
    // CONTROLLER NAMESPACE
    // =========================
    'controllerNamespace' => 'backend\controllers',

    // =========================
    // BOOTSTRAP (SAFE MODE)
    // =========================
    'bootstrap' => [
        'log',
        // Safe bootstrap only (remove if file doesn't exist)
        'common\bootstrap\MailerBootstrap',
    ],

    // =========================
    // MODULES
    // =========================
    'modules' => [],

    // =========================
    // COMPONENTS
    // =========================
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
        // RBAC
        // =========================
        'authManager' => [
            'class' => \yii\rbac\DbManager::class,
        ],

        // =========================
        // SESSION
        // =========================
        'session' => [
            'name' => 'advanced-backend-session',
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
        // URL MANAGER (CLEAN ROUTES)
        // =========================
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,

            'rules' => [

                // =====================
                // AUTH ROUTES
                // =====================
                '' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'signup' => 'site/signup',

                // =====================
                // DASHBOARDS
                // =====================
                'owner-dashboard' => 'owner-dashboard/index',
                'seller-dashboard' => 'seller/index',

                // =====================
                // OWNER MANAGEMENT
                // =====================
                'owner/sellers' => 'owner-seller/index',
                'owner/sellers/create' => 'owner-seller/create',
                'owner/sellers/update/<id:\d+>' => 'owner-seller/update',
                'owner/sellers/delete/<id:\d+>' => 'owner-seller/delete',

                // =====================
                // CORE ERP MODULES
                // =====================
                'products' => 'product/index',
                'sales' => 'sale/index',

                // =====================
                // ANALYTICS MODULE
                // =====================
                'analytics' => 'analytics/index',
                'analytics/daily' => 'analytics/daily',
                'analytics/monthly' => 'analytics/monthly',
                'analytics/weekly' => 'analytics/weekly',
                'analytics/charts' => 'analytics/charts',

                // =====================
                // AJAX ANALYTICS
                // =====================
                'analytics/ajax/daily' => 'analytics/daily-ajax',
                'analytics/ajax/monthly' => 'analytics/monthly-ajax',
                'analytics/ajax/weekly' => 'analytics/weekly-ajax',
            ],
        ],
    ],

    // =========================
    // PARAMETERS
    // =========================
    'params' => $params,
];