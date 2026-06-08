<?php
/**
 * @var \common\models\Product $model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Update Product';

?>

<h2>✏️ Update Product</h2>

<div class="product-form">

    <?php $form = ActiveForm::begin(); ?>

    <!-- NAME -->
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <!-- SKU -->
    <?= $form->field($model, 'sku')->textInput(['maxlength' => true]) ?>

    <!-- BUYING PRICE -->
    <?= $form->field($model, 'buying_price')->input('number', [
        'step' => '0.01'
    ]) ?>

    <!-- SELLING PRICE -->
    <?= $form->field($model, 'selling_price')->input('number', [
        'step' => '0.01'
    ]) ?>

    <!-- STOCK -->
    <?= $form->field($model, 'stock_quantity')->input('number') ?>

    <!-- MIN STOCK ALERT -->
    <?= $form->field($model, 'min_stock_alert')->input('number') ?>

    <div class="form-group mt-3">

        <?= Html::submitButton('💾 Update Product', [
            'class' => 'btn btn-primary'
        ]) ?>

        <?= Html::a('⬅ Back', ['/seller/products'], [
            'class' => 'btn btn-secondary'
        ]) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>