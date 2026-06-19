<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use frontend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

/*
|--------------------------------------------------------------------------
| BASIC META TAGS
|--------------------------------------------------------------------------
*/

$this->registerCsrfMetaTags();

$this->registerMetaTag([
    'charset' => Yii::$app->charset,
], 'charset');

$this->registerMetaTag([
    'name' => 'viewport',
    'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no',
]);

/*
|--------------------------------------------------------------------------
| SEO
|--------------------------------------------------------------------------
*/

$this->registerMetaTag([
    'name' => 'description',
    'content' => $this->params['meta_description']
        ?? 'Professional Business Management System for Owners, Branch Managers and Sellers. Manage inventory, sales, branches, reports and analytics in one place.',
]);

$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->params['meta_keywords']
        ?? 'business management system,pos system,inventory management,sales analytics,branch management,yii2,tanzania',
]);

$this->registerMetaTag([
    'name' => 'author',
    'content' => 'ITC Melody',
]);

$this->registerMetaTag([
    'name' => 'robots',
    'content' => 'index, follow',
]);

/*
|--------------------------------------------------------------------------
| OPEN GRAPH (FACEBOOK / WHATSAPP)
|--------------------------------------------------------------------------
|
| CHANGE THE IMAGE BELOW
| Put your logo/banner here:
| frontend/web/images/og-image.jpg
|
*/

$siteName = Yii::$app->name;
$pageTitle = Html::encode($this->title ?: $siteName);

$ogImage = Yii::$app->request->hostInfo . '/images/og-image.jpg';

$this->registerMetaTag([
    'property' => 'og:type',
    'content' => 'website',
]);

$this->registerMetaTag([
    'property' => 'og:title',
    'content' => $pageTitle,
]);

$this->registerMetaTag([
    'property' => 'og:site_name',
    'content' => $siteName,
]);

$this->registerMetaTag([
    'property' => 'og:description',
    'content' => $this->params['meta_description']
        ?? 'Modern Business Management System',
]);

$this->registerMetaTag([
    'property' => 'og:image',
    'content' => $ogImage,
]);

$this->registerMetaTag([
    'property' => 'og:url',
    'content' => Yii::$app->request->absoluteUrl,
]);

/*
|--------------------------------------------------------------------------
| TWITTER CARD
|--------------------------------------------------------------------------
*/

$this->registerMetaTag([
    'name' => 'twitter:card',
    'content' => 'summary_large_image',
]);

$this->registerMetaTag([
    'name' => 'twitter:title',
    'content' => $pageTitle,
]);

$this->registerMetaTag([
    'name' => 'twitter:description',
    'content' => $this->params['meta_description']
        ?? 'Professional Business Management System',
]);

$this->registerMetaTag([
    'name' => 'twitter:image',
    'content' => $ogImage,
]);

/*
|--------------------------------------------------------------------------
| FAVICON
|--------------------------------------------------------------------------
|
| Put these files here:
| frontend/web/favicon.ico
| frontend/web/images/logo.png
|
*/

$this->registerLinkTag([
    'rel' => 'icon',
    'type' => 'image/x-icon',
    'href' => Yii::getAlias('@web/favicon.ico'),
]);

$this->registerLinkTag([
    'rel' => 'apple-touch-icon',
    'href' => Yii::getAlias('@web/images/logo.png'),
]);

/*
|--------------------------------------------------------------------------
| GOOGLE FONTS
|--------------------------------------------------------------------------
*/

$this->registerLinkTag([
    'rel' => 'preconnect',
    'href' => 'https://fonts.googleapis.com',
]);

$this->registerLinkTag([
    'rel' => 'preconnect',
    'href' => 'https://fonts.gstatic.com',
    'crossorigin' => '',
]);

$this->registerCssFile(
    'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap'
);

/*
|--------------------------------------------------------------------------
| GLOBAL FRONTEND THEME
|--------------------------------------------------------------------------
*/

$this->registerCss("
:root{
    --primary:#2563eb;
    --primary-hover:#1d4ed8;

    --dark:#0f172a;
    --dark-2:#111827;
    --dark-3:#1e293b;

    --light:#ffffff;
    --light-bg:#f8fafc;

    --text-dark:#0f172a;
    --text-light:#f8fafc;

    --border:#e2e8f0;

    --shadow:
        0 10px 30px rgba(15,23,42,.08);
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:'Inter',sans-serif;
    overflow-x:hidden;
}

.glass{
    backdrop-filter:blur(16px);
    -webkit-backdrop-filter:blur(16px);
}

.section-padding{
    padding:100px 0;
}

.text-gradient{
    background:linear-gradient(
        135deg,
        #2563eb,
        #7c3aed
    );

    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.shadow-soft{
    box-shadow:var(--shadow);
}

.rounded-4{
    border-radius:1.25rem!important;
}
");

/*
|--------------------------------------------------------------------------
| DARK / LIGHT MODE SCRIPT
|--------------------------------------------------------------------------
*/

$this->registerJs("
(function(){

    const theme = localStorage.getItem('theme');

    if(theme === 'dark'){
        document.documentElement.setAttribute('data-bs-theme','dark');
    }else{
        document.documentElement.setAttribute('data-bs-theme','light');
    }

})();
", \yii\web\View::POS_HEAD);
?>