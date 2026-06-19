<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;
use yii\helpers\Html;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>

<html lang="<?= Yii::$app->language ?>" data-bs-theme="dark">

<head>

    <meta charset="<?= Yii::$app->charset ?>">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <?php $this->registerCsrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>

    <style>

        body{

            margin:0;

            min-height:100vh;

            display:flex;

            align-items:center;

            justify-content:center;

            background:
            linear-gradient(
                135deg,
                #0f172a,
                #111827,
                #1e293b
            );

            font-family:
            Inter,
            Segoe UI,
            sans-serif;
        }

        .auth-wrapper{

            width:100%;

            max-width:520px;

            padding:30px;
        }

    </style>

</head>

<body>

<?php $this->beginBody() ?>

<div class="auth-wrapper">

    <?= $content ?>

</div>

<?php $this->endBody() ?>

</body>

</html>

<?php $this->endPage() ?>