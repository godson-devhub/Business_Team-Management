<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use backend\assets\AppAsset;

AppAsset::register($this);

/*
|--------------------------------------------------------------------------
| CSRF
|--------------------------------------------------------------------------
*/
$this->registerCsrfMetaTags();

/*
|--------------------------------------------------------------------------
| CHARSET
|--------------------------------------------------------------------------
*/
$this->registerMetaTag([
    'charset' => Yii::$app->charset,
], 'charset');

/*
|--------------------------------------------------------------------------
| RESPONSIVE
|--------------------------------------------------------------------------
*/
$this->registerMetaTag([
    'name' => 'viewport',
    'content' => 'width=device-width, initial-scale=1',
]);

/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/
$this->registerMetaTag([
    'name' => 'description',
    'content' =>
        $this->params['meta_description']
        ?? 'Business Management System for sales, inventory, purchases and analytics.',
]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content' =>
        $this->params['meta_keywords']
        ?? 'ERP, POS, Inventory, Sales, Purchase, Analytics, Business Management System',
]);

/*
|--------------------------------------------------------------------------
| THEME COLOR
|--------------------------------------------------------------------------
*/
$this->registerMetaTag([
    'name' => 'theme-color',
    'content' => '#0f172a',
]);

/*
|--------------------------------------------------------------------------
| FAVICON
|--------------------------------------------------------------------------
*/
$this->registerLinkTag([
    'rel'  => 'icon',
    'type' => 'image/x-icon',
    'href' => Yii::getAlias('@web/favicon.ico'),
]);

/*
|--------------------------------------------------------------------------
| GOOGLE FONT
|--------------------------------------------------------------------------
*/
$this->registerCssFile(
    'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap'
);

/*
|--------------------------------------------------------------------------
| GLOBAL CSS
|--------------------------------------------------------------------------
*/
$this->registerCss("
html,
body{
    font-family:'Inter',sans-serif;
    scroll-behavior:smooth;
}

*{
    box-sizing:border-box;
}

a{
    text-decoration:none;
}

img{
    max-width:100%;
}

::-webkit-scrollbar{
    width:8px;
}

::-webkit-scrollbar-track{
    background:#0f172a;
}

::-webkit-scrollbar-thumb{
    background:#475569;
    border-radius:10px;
}

::-webkit-scrollbar-thumb:hover{
    background:#64748b;
}
");
?>