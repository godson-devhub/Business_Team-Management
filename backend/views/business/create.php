<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var \common\models\Business $model
 */

$this->title = 'Create Business';
?>

<style>

/* =========================
GLOBAL
========================= */
body{
    margin:0;
    padding:0;
    font-family:Segoe UI, sans-serif;
    background: radial-gradient(circle at top, #0f172a, #020617);
    color:white;
}

/* =========================
WRAPPER
========================= */
.create-wrapper{
    max-width:600px;
    margin:60px auto;
    padding:30px;

    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);
    backdrop-filter:blur(20px);

    border-radius:24px;

    transition:0.3s;
}

.create-wrapper:hover{
    transform:translateY(-5px);
}

/* =========================
TITLE
========================= */
.title{
    font-size:28px;
    font-weight:800;
    margin-bottom:20px;

    background:linear-gradient(135deg,#38bdf8,#818cf8);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

/* =========================
INPUTS
========================= */
.form-group label{
    color:#cbd5e1;
    font-size:13px;
    margin-bottom:6px;
    display:block;
}

.form-control{
    width:100%;
    padding:12px 14px;

    border-radius:12px;
    border:1px solid rgba(255,255,255,0.08);

    background:rgba(255,255,255,0.05);
    color:white;

    outline:none;

    transition:0.3s;
}

.form-control:focus{
    border-color:#38bdf8;
    background:rgba(255,255,255,0.08);
}

/* =========================
BUTTON
========================= */
.btn-submit{
    margin-top:20px;
    width:100%;

    padding:12px;
    border-radius:14px;

    border:none;
    cursor:pointer;

    font-weight:700;
    color:white;

    background:linear-gradient(135deg,#38bdf8,#6366f1);

    transition:0.3s;
}

.btn-submit:hover{
    transform:translateY(-3px);
    box-shadow:0 15px 30px rgba(56,189,248,0.25);
}

</style>

<div class="create-wrapper">

    <div class="title">➕ Create Business</div>

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'name')->textInput([
            'placeholder' => 'Enter business name'
        ]) ?>

        <?= $form->field($model, 'description')->textarea([
            'rows' => 5,
            'placeholder' => 'Describe your business...'
        ]) ?>

        <button type="submit" class="btn-submit">
            Save Business
        </button>

    <?php ActiveForm::end(); ?>

</div>