<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $name */
/** @var string $message */
/** @var \Exception $exception */

use yii\helpers\Html;
use yii\web\HttpException;

$this->title = $name;

$statusCode = $exception instanceof HttpException
    ? $exception->statusCode
    : 500;

?>

<style>

body{
    margin:0;
    font-family: Inter, sans-serif;
    background:#0f172a;
    color:white;
}

/* =========================
ERROR WRAPPER
========================= */
.error-wrapper{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}

/* =========================
BOX
========================= */
.error-box{
    text-align:center;
    max-width:500px;
}

/* =========================
CODE
========================= */
.code{
    font-size:120px;
    font-weight:800;
    margin:0;
    color:#3b82f6;
    letter-spacing:2px;
}

/* =========================
TITLE
========================= */
.title{
    font-size:28px;
    font-weight:700;
    margin-top:10px;
}

/* =========================
MESSAGE
========================= */
.message{
    margin-top:10px;
    color:#94a3b8;
    line-height:1.6;
}

/* =========================
BUTTON
========================= */
.btn{
    display:inline-block;
    margin-top:25px;
    padding:12px 18px;

    background:#2563eb;
    color:white;

    border-radius:10px;
    text-decoration:none;

    font-weight:600;

    transition:0.2s;
}

.btn:hover{
    background:#1d4ed8;
    transform:translateY(-2px);
}

</style>

<div class="error-wrapper">

    <div class="error-box">

        <div class="code">
            <?= Html::encode($statusCode) ?>
        </div>

        <div class="title">
            <?= Html::encode($message) ?>
        </div>

        <div class="message">
            The system encountered an error while processing your request.
            Please try again or contact system administrator if the issue persists.
        </div>

        <a class="btn" href="<?= Yii::$app->homeUrl ?>">
            ⬅ Back to Dashboard
        </a>

    </div>

</div>