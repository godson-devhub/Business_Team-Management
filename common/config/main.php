<?php

declare(strict_types=1);

return [

    /*
    |-----------------------------
    | BOOTSTRAP
    |-----------------------------
    | ONLY put classes that:
    | - exist physically
    | - are safe at app startup
    */
    'bootstrap' => [
        // ⚠️ COMMENT THIS IF IT CAUSES ERROR
        \common\bootstrap\MailerBootstrap::class,
    ],

    /*
    |-----------------------------
    | ALIASES
    |-----------------------------
    */
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],

    /*
    |-----------------------------
    | VENDOR PATH
    |-----------------------------
    */
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',

    /*
    |-----------------------------
    | COMPONENTS (CORE SHARED)
    |-----------------------------
    */
    'components' => [

        // CACHE
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],

        // DB (IMPORTANT)
       // 'db' => require __DIR__ . '/main-local.php',

        // MAILER (SAFE DEFAULT)
        'mailer' => [
            'class' => \yii\symfonymailer\Mailer::class,
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],
    ],
];