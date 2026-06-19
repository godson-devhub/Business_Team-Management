<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model common\models\Product */

$this->title = 'Create Product';
?>

<!-- =========================
BACKGROUND (MATCH DASHBOARD)
========================= -->
<div class="background-blobs">
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
</div>

<!-- =========================
PAGE WRAPPER
========================= -->
<div class="page-wrapper">

    <div class="glass-card">

        <div class="title">📦 Create Product</div>
        <div class="subtitle">Add new stock to your branch inventory</div>

        <?php $form = ActiveForm::begin([
            'id' => 'product-form',
            'options' => ['autocomplete' => 'off']
        ]); ?>

        <!-- PRODUCT NAME -->
        <div class="form-group">
            <?= $form->field($model, 'name')
                ->textInput([
                    'class' => 'input',
                    'placeholder' => 'Enter product name'
                ])
                ->label('Product Name') ?>
        </div>

        <!-- BUYING PRICE -->
        <div class="form-group">
            <?= $form->field($model, 'buying_price')
                ->textInput([
                    'type' => 'number',
                    'step' => '0.01',
                    'class' => 'input',
                    'placeholder' => 'Buying price'
                ])
                ->label('Buying Price') ?>
        </div>

        <!-- SELLING PRICE -->
        <div class="form-group">
            <?= $form->field($model, 'selling_price')
                ->textInput([
                    'type' => 'number',
                    'step' => '0.01',
                    'class' => 'input',
                    'placeholder' => 'Selling price'
                ])
                ->label('Selling Price') ?>
        </div>

        <!-- STOCK QUANTITY -->
        <div class="form-group">
            <?= $form->field($model, 'stock_quantity')
                ->textInput([
                    'type' => 'number',
                    'min' => 0,
                    'class' => 'input',
                    'placeholder' => 'Stock quantity'
                ])
                ->label('Stock Quantity') ?>
        </div>

        <!-- MIN STOCK ALERT -->
        <div class="form-group">
            <?= $form->field($model, 'min_stock_alert')
                ->textInput([
                    'type' => 'number',
                    'min' => 0,
                    'class' => 'input',
                    'placeholder' => 'Low stock alert level'
                ])
                ->label('Low Stock Alert') ?>
        </div>

        <!-- SKU (OPTIONAL BUT IMPORTANT) -->
        <div class="form-group">
            <?= $form->field($model, 'sku')
                ->textInput([
                    'class' => 'input',
                    'placeholder' => 'Auto or manual SKU'
                ])
                ->label('SKU') ?>
        </div>

        <!-- STATUS -->
        <div class="form-group">
            <?= $form->field($model, 'status')
                ->dropDownList([
                    1 => 'Active',
                    0 => 'Inactive'
                ], [
                    'class' => 'input'
                ])
                ->label('Status') ?>
        </div>

        <!-- BUTTON -->
        <div class="form-group">
            <?= Html::submitButton('🚀 Save Product', [
                'class' => 'btn'
            ]) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<!-- =========================
STYLE (MATCH DASHBOARD UI)
========================= -->
<style>

body{
    margin:0;
    padding:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#020617,#0f172a,#1e293b);
    color:white;
}

/* BLOBS */
.background-blobs{
    position:fixed;
    width:100%;
    height:100%;
    z-index:-1;
    overflow:hidden;
}

.blob{
    position:absolute;
    border-radius:50%;
    filter:blur(90px);
    opacity:0.35;
}

.blob1{
    width:320px;
    height:320px;
    background:#38bdf8;
    top:-60px;
    left:-60px;
}

.blob2{
    width:280px;
    height:280px;
    background:#8b5cf6;
    bottom:-60px;
    right:-60px;
}

/* WRAPPER */
.page-wrapper{
    display:flex;
    justify-content:center;
    padding:40px;
}

/* GLASS CARD */
.glass-card{
    width:100%;
    max-width:600px;
    background:rgba(255,255,255,0.07);
    border:1px solid rgba(255,255,255,0.15);
    backdrop-filter:blur(18px);
    border-radius:25px;
    padding:35px;
    box-shadow:0 10px 40px rgba(0,0,0,0.4);
}

/* TITLE */
.title{
    font-size:30px;
    font-weight:bold;
    background:linear-gradient(90deg,#38bdf8,#818cf8,#c084fc);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.subtitle{
    color:#94a3b8;
    margin-bottom:25px;
    font-size:14px;
}

/* FORM */
.form-group{
    margin-bottom:18px;
}

/* INPUT FIX (IMPORTANT FOR UX) */
.input,
input,
select{
    width:100%;
    padding:14px;
    border-radius:14px;
    border:none;
    outline:none;
    background:rgba(255,255,255,0.08);
    color:white;
    font-size:14px;
    transition:0.3s;
}

.input:focus,
input:focus,
select:focus{
    background:rgba(255,255,255,0.15);
    transform:scale(1.02);
    box-shadow:0 0 15px rgba(56,189,248,0.3);
}

/* LABEL FIX */
label{
    color:#cbd5e1;
    font-size:13px;
    margin-bottom:6px;
    display:block;
}

/* BUTTON */
.btn{
    width:100%;
    padding:15px;
    border:none;
    border-radius:14px;
    background:linear-gradient(135deg,#38bdf8,#6366f1,#8b5cf6);
    color:white;
    font-size:15px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    transform:translateY(-4px);
    box-shadow:0 12px 30px rgba(99,102,241,0.4);
}

</style>