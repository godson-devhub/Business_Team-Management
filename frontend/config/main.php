<?php

declare(strict_types=1);

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php',
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',

    'components' => [

        /*
        |--------------------------------------------------------------------------
        | REQUEST
        |--------------------------------------------------------------------------
        */
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'cookieValidationKey' => 'CHANGE-THIS-TO-A-LONG-RANDOM-STRING-123456789',
        ],

        /*
        |--------------------------------------------------------------------------
        | USER AUTH
        |--------------------------------------------------------------------------
        */
        'user' => [
            'identityClass' => \common\models\User::class,
            'enableAutoLogin' => true,
            'identityCookie' => [
                'name' => '_identity-frontend',
                'httpOnly' => true,
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | SESSION
        |--------------------------------------------------------------------------
        */
        'session' => [
            'name' => 'advanced-frontend',
        ],

        /*
        |--------------------------------------------------------------------------
        | LOGGING
        |--------------------------------------------------------------------------
        */
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],

        /*
        |--------------------------------------------------------------------------
        | ERROR HANDLER
        |--------------------------------------------------------------------------
        */
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        /*
        |--------------------------------------------------------------------------
        | URL MANAGER (IMPORTANT FIX)
        |--------------------------------------------------------------------------
        */
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [

                // Landing page
                '' => 'site/index',

                // Auth pages
                'login' => 'site/login',
                'signup' => 'site/signup',
                'logout' => 'site/logout',

                // Pages
                'about' => 'site/about',
                'contact' => 'site/contact',

                // Analytics (backend style routes if shared)
                'analytics' => 'analytics/index',
                'analytics/daily' => 'analytics/daily',
                'analytics/monthly' => 'analytics/monthly',
                'analytics/weekly' => 'analytics/weekly',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | PARAMETERS
    |--------------------------------------------------------------------------
    */
    'params' => $params,
];