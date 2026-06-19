<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \common\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

$this->title = 'Login';
?>

<style>

/* =========================
FULL RESET (IMPORTANT FIX)
========================= */

html,
body {
    height: 100%;
    width: 100%;
    margin: 0;
    padding: 0;
}

/* Yii wrapper fix */
body {
    overflow: hidden;
}

/* =========================
LOGIN PAGE BACKGROUND
========================= */

.login-page {
    position: fixed;
    inset: 0;

    display: flex;
    align-items: center;
    justify-content: center;

    padding: 20px;

    /* FULL BACKGROUND FIX */
    background:
        linear-gradient(
            rgba(19, 18, 18, 0.55),
            rgba(0,0,0,0.65)
        ),
        url('<?= Yii::getAlias("@web") ?>/uploads/login-bg.jpg');

    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

/* =========================
DARK OVERLAY (FULL SCREEN FIX)
========================= */

.login-page::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(43, 42, 42, 0.35);
    z-index: 0;
}

/* =========================
GLASS CARD
========================= */

.login-card {
    position: relative;
    z-index: 2;

    width: 100%;
    max-width: 420px;

    padding: 35px;

    border-radius: 22px;

    /* GLASS EFFECT FIX */
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(25px);
    -webkit-backdrop-filter: blur(25px);

    border: 1px solid rgba(255,255,255,0.15);

    box-shadow: 0 25px 70px rgba(0,0,0,0.5);

    color: white;

    animation: floatCard 6s ease-in-out infinite;
}

/* FLOAT EFFECT */
@keyframes floatCard {
    0%   { transform: translateY(0); }
    50%  { transform: translateY(-10px); }
    100% { transform: translateY(0); }
}

/* =========================
LOGO
========================= */

.logo {
    width: 70px;
    height: 70px;

    margin: 0 auto 20px;

    border-radius: 18px;

    display: flex;
    align-items: center;
    justify-content: center;

    font-size: 30px;

    background: linear-gradient(135deg, #2563eb, #7c3aed);
}

/* =========================
TEXT
========================= */

.login-title {
    text-align: center;
    font-size: 26px;
    font-weight: 800;
    margin-bottom: 6px;
}

.login-subtitle {
    text-align: center;
    color: #cbd5e1;
    margin-bottom: 25px;
    font-size: 13px;
}

/* =========================
FORM FIX
========================= */

.form-control {
    width: 100%;
    height: 50px;

    border-radius: 12px !important;

    background: rgba(255,255,255,0.08) !important;
    border: 1px solid rgba(255,255,255,0.15) !important;

    color: white !important;

    margin-bottom: 12px;
}

.form-control::placeholder {
    color: rgba(255,255,255,0.6);
}

.form-control:focus {
    border-color: #60a5fa !important;
    background: rgba(255,255,255,0.12) !important;
    outline: none;
}

/* LABEL */
.form-label {
    color: white;
}

/* CHECKBOX */
.form-check-label {
    color: #e2e8f0;
}

/* =========================
BUTTON
========================= */

.btn-login {
    width: 100%;
    height: 52px;

    border: none;
    border-radius: 12px;

    background: linear-gradient(135deg, #2563eb, #4f46e5);
    color: white;

    font-weight: 700;

    cursor: pointer;

    transition: 0.3s;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 30px rgba(37,99,235,0.4);
}

/* =========================
LINK
========================= */

.signup-link {
    text-align: center;
    margin-top: 18px;
}

.signup-link a {
    color: #93c5fd;
    text-decoration: none;
}

.signup-link a:hover {
    text-decoration: underline;
}

/* =========================
RESPONSIVE
========================= */

@media(max-width: 480px) {
    .login-card {
        width: 92%;
        padding: 25px;
    }
}

</style>

<!-- LOGIN PAGE -->
<div class="login-page">

    <div class="login-card">

        <div style="text-align:center;margin-bottom:20px;">
            <img src="<?= Yii::getAlias('@web') ?>/uploads/icon2.png"
                style="width:70px;height:70px;border-radius:15px;">
        </div>


      

        <div class="login-title">
            Business Workflow & Team Management System
        </div>

        <div class="login-subtitle">
            Sign in to continue
        </div>

        <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

        <?= $form->field($model,'username')
            ->textInput(['placeholder'=>'Username'])
            ->label(false) ?>

        <?= $form->field($model,'password')
            ->passwordInput(['placeholder'=>'Password'])
            ->label(false) ?>

        <?= $form->field($model,'rememberMe')->checkbox() ?>

        <button type="submit" class="btn-login">
            Login
        </button>

        <?php ActiveForm::end(); ?>

        <div class="signup-link">
            <?= Html::a('Create Account', ['/site/signup']) ?>
        </div>

    </div>

</div>