<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model common\models\Product */
?>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'buying_price')->textInput(['type' => 'number', 'step' => '0.01']) ?>

    <?= $form->field($model, 'selling_price')->textInput(['type' => 'number', 'step' => '0.01']) ?>

    <?= $form->field($model, 'stock_quantity')->textInput(['type' => 'number', 'min' => 0]) ?>

    <?= $form->field($model, 'min_stock_alert')->textInput(['type' => 'number', 'min' => 0]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        1 => 'Active',
        0 => 'Inactive'
    ]) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('💾 Save Product', [
            'class' => 'btn btn-success'
        ]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>