<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">

        <div class="col-md-6">

            <?= $form->field($model, 'name')
                ->textInput([
                    'class' => 'glass-input'
                ]) ?>

        </div>

        <div class="col-md-6">

            <?= $form->field($model, 'sku')
                ->textInput([
                    'class' => 'glass-input'
                ]) ?>

        </div>

    </div>

    <div class="row">

        <div class="col-md-6">

            <?= $form->field($model, 'buying_price')
                ->textInput([
                    'type' => 'number',
                    'step' => '0.01',
                    'class' => 'glass-input'
                ]) ?>

        </div>

        <div class="col-md-6">

            <?= $form->field($model, 'selling_price')
                ->textInput([
                    'type' => 'number',
                    'step' => '0.01',
                    'class' => 'glass-input'
                ]) ?>

        </div>

    </div>

    <div class="row">

        <div class="col-md-6">

            <?= $form->field($model, 'stock_quantity')
                ->textInput([
                    'type' => 'number',
                    'class' => 'glass-input'
                ]) ?>

        </div>

        <div class="col-md-6">

            <?= $form->field($model, 'min_stock_alert')
                ->textInput([
                    'type' => 'number',
                    'class' => 'glass-input'
                ]) ?>

        </div>

    </div>

    <div class="form-group mt-4">

        <?= Html::submitButton(
            $model->isNewRecord
                ? '🚀 Create Product'
                : '💾 Update Product',
            [
                'class' => 'save-btn'
            ]
        ) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>

label{
    color:white !important;
    font-weight:600;
}

.glass-input{

    background:
    rgba(255,255,255,.06) !important;

    border:
    1px solid rgba(255,255,255,.10);

    color:white !important;

    border-radius:14px;

    padding:14px;

    transition:.3s;
}

.glass-input:focus{

    border-color:#38bdf8;

    box-shadow:
    0 0 20px rgba(56,189,248,.25);

    transform:translateY(-2px);
}

.save-btn{

    width:100%;

    border:none;

    padding:16px;

    border-radius:16px;

    color:white;

    font-weight:700;

    background:
    linear-gradient(
        135deg,
        #3b82f6,
        #8b5cf6
    );

    transition:.3s;
}

.save-btn:hover{

    transform:
    translateY(-3px);

    box-shadow:
    0 10px 25px rgba(99,102,241,.35);
}

</style>