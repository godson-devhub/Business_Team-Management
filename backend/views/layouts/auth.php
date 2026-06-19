<?php

/** @var yii\web\View $this */
/** @var string $content */

use backend\assets\AppAsset;

AppAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">

<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= \yii\helpers\Html::encode($this->title) ?></title>

    <?php $this->head() ?>

    <style>

    html, body {
        height: 100%;
        height:100%;
        margin: 0;
        padding: 0;
    }

    /* 🔥 IMPORTANT WRAPPER FIX */
    .auth-wrapper {

        min-height: 100vh;
        width: 100%;

        display: flex;
        align-items: center;
        justify-content: center;

        /* 👉 BACKGROUND IMAGE HERE */
        background:
            linear-gradient(rgba(0,0,0,.65), rgba(0,0,0,.65)),
            url('/backend/web/uploads/login-bg.jpg');

        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }

    </style>

</head>

<body>

<?php $this->beginBody() ?>

<!-- 🔥 THIS IS THE KEY FIX -->
<div class="auth-wrapper">

    <?= $content ?>

</div>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>