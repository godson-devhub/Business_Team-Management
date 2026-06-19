<?php

use yii\bootstrap5\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var common\models\SignupForm $model */

$this->title = 'Create Account';
?>

<style>

.signup-page {
    position: fixed;
    inset:0;
    width: 100%;
    height:100%;
    
    display: flex;
    align-items: center;
    justify-content: center;

    background:
        linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.75)),
        url('<?= Yii::getAlias("@web") ?>/uploads/login-bg.jpg');

    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
}

.signup-card {
    width: 100%;
    max-width: 420px;

    padding: 35px;

    border-radius: 20px;

    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(25px);

    border: 1px solid rgba(255,255,255,0.15);

    color: white;

    box-shadow: 0 25px 70px rgba(0,0,0,0.5);
}

.title {
    text-align: center;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 20px;
}

.form-control {
    height: 50px;
    border-radius: 12px !important;

    background: rgba(255,255,255,0.08) !important;
    border: 1px solid rgba(255,255,255,0.15) !important;

    color: white !important;
}

.form-control::placeholder {
    color: rgba(255,255,255,0.6);
}

.btn-signup {
    width: 100%;
    height: 52px;

    border: none;
    border-radius: 12px;

    background: linear-gradient(135deg,#22c55e,#16a34a);

    color: white;
    font-weight: 700;

    margin-top: 10px;
}

</style>

<div class="signup-page">

    <div class="signup-card">

        <div class="title">Create Account</div>

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username')->textInput(['placeholder'=>'Username'])->label(false) ?>

        <?= $form->field($model, 'email')->textInput(['placeholder'=>'Email'])->label(false) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password'])->label(false) ?>

        <button class="btn-signup" type="submit">
            Register
        </button>

        <?php ActiveForm::end(); ?>

    </div>

</div>