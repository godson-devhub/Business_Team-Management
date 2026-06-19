<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model common\models\Product */

?>

<style>

.form-group{
    margin-bottom:18px;
}

label{
    display:block;
    margin-bottom:8px;
    color:#cbd5e1;
    font-size:13px;
}

input, select{
    width:100%;
    padding:14px;
    border-radius:14px;
    border:1px solid rgba(255,255,255,.08);
    background:rgba(255,255,255,.05);
    color:white;
    outline:none;
    transition:.3s;
}

input:focus{
    border-color:#38bdf8;
    box-shadow:0 0 15px rgba(56,189,248,.3);
    transform:scale(1.01);
}

.btn-submit{
    width:100%;
    padding:15px;
    border:none;
    border-radius:16px;
    background:linear-gradient(135deg,#38bdf8,#6366f1,#8b5cf6);
    color:white;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
}

.btn-submit:hover{
    transform:translateY(-4px);
    box-shadow:0 15px 30px rgba(99,102,241,.4);
}

.sku-hint{
    font-size:12px;
    color:#94a3b8;
    margin-top:5px;
}

</style>

<div class="product-form">

<?php $form = ActiveForm::begin(); ?>

    <!-- PRODUCT NAME -->
    <div class="form-group">

        <?= $form->field($model, 'name')
            ->textInput([
                'placeholder' => 'Enter product name'
            ])
            ->label('Product Name') ?>

    </div>

    <!-- SKU -->
    <div class="form-group">

        <?= $form->field($model, 'sku')
            ->textInput([
                'placeholder' => 'e.g RICE-001'
            ])
            ->label('SKU (Stock Keeping Unit)') ?>

        <div class="sku-hint">
            Unique product code (optional but recommended)
        </div>

    </div>

    <!-- BUYING PRICE -->
    <div class="form-group">

        <?= $form->field($model, 'buying_price')
            ->input('number', [
                'step' => '0.01',
                'placeholder' => 'Buying price'
            ])
            ->label('Buying Price') ?>

    </div>

    <!-- SELLING PRICE -->
    <div class="form-group">

        <?= $form->field($model, 'selling_price')
            ->input('number', [
                'step' => '0.01',
                'placeholder' => 'Selling price'
            ])
            ->label('Selling Price') ?>

    </div>

    <!-- STOCK -->
    <div class="form-group">

        <?= $form->field($model, 'stock_quantity')
            ->input('number', [
                'placeholder' => 'Stock quantity'
            ])
            ->label('Stock Quantity') ?>

    </div>

    <!-- MIN STOCK ALERT -->
    <div class="form-group">

        <?= $form->field($model, 'min_stock_alert')
            ->input('number', [
                'placeholder' => 'Low stock alert level'
            ])
            ->label('Minimum Stock Alert') ?>

    </div>

    <!-- STATUS -->
    <div class="form-group">

        <?= $form->field($model, 'status')
            ->dropDownList([
                1 => 'Active',
                0 => 'Inactive'
            ])
            ->label('Status') ?>

    </div>

    <!-- SUBMIT -->
    <button class="btn-submit" type="submit">

        💾 Save Product

    </button>

<?php ActiveForm::end(); ?>

</div>