<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

/**
 * @var \common\models\Branch $model
 * @var \common\models\Business[] $businesses
 */

$this->title = 'Create Branch';
?>

<style>

/* =========================
GLOBAL BACKGROUND
========================= */

body{
    margin:0;
    padding:0;
    font-family:Segoe UI, sans-serif;

    background:linear-gradient(135deg,#020617,#0f172a,#1e293b);
    color:white;

    min-height:100vh;
}

/* =========================
WRAPPER
========================= */

.create-wrapper{
    padding:50px;
    display:flex;
    justify-content:center;
}

/* =========================
CARD
========================= */

.form-card{
    width:100%;
    max-width:600px;

    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);

    border-radius:24px;
    padding:30px;

    backdrop-filter:blur(20px);

    transition:0.3s;
}

.form-card:hover{
    transform:translateY(-5px);
    box-shadow:0 20px 40px rgba(0,0,0,0.35);
}

/* =========================
TITLE
========================= */

.title{
    font-size:28px;
    font-weight:800;

    margin-bottom:20px;

    background:linear-gradient(to right,#38bdf8,#a78bfa);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

/* =========================
INPUTS (Yii override)
========================= */

.form-group{
    margin-bottom:18px;
}

label{
    display:block;
    margin-bottom:6px;
    font-size:13px;
    color:#cbd5e1;
}

input, select{
    width:100%;
    padding:12px 14px;

    border-radius:12px;

    border:1px solid rgba(255,255,255,0.1);
    background:rgba(255,255,255,0.05);

    color:white;

    outline:none;

    transition:0.3s;
}

input:focus, select:focus{
    border-color:#38bdf8;
    background:rgba(255,255,255,0.08);
}

/* =========================
BUTTON
========================= */

.btn{
    width:100%;
    padding:12px;

    border:none;
    border-radius:14px;

    background:linear-gradient(135deg,#38bdf8,#6366f1);

    color:white;
    font-weight:700;

    cursor:pointer;

    transition:0.3s;
}

.btn:hover{
    transform:translateY(-3px);
    box-shadow:0 12px 25px rgba(56,189,248,0.25);
}

/* =========================
HELP TEXT FIX
========================= */

.help-block{
    color:#94a3b8;
    font-size:12px;
}

</style>

<div class="create-wrapper">

    <div class="form-card">

        <div class="title">➕ Create Branch</div>

        <?php $form = ActiveForm::begin(); ?>

        <!-- BUSINESS SELECT -->
        <?= $form->field($model, 'business_id')
            ->dropDownList(
                ArrayHelper::map($businesses, 'id', 'name'),
                ['prompt' => 'Select Business']
            )
        ?>

        <!-- BRANCH NAME -->
        <?= $form->field($model, 'name')
            ->textInput(['placeholder' => 'Enter branch name'])
        ?>

        <!-- LOCATION ONLY -->
        <?= $form->field($model, 'location')
            ->textInput(['placeholder' => 'Enter branch location'])
        ?>

        <!-- SUBMIT -->
        <?= Html::submitButton('Save Branch', [
            'class' => 'btn'
        ]) ?>

        <?php ActiveForm::end(); ?>

    </div>

</div>