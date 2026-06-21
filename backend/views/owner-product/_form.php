<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="product-form">

    <?php $form = ActiveForm::begin([
        'fieldConfig' => [
            'template' => "{label}\n{input}\n{error}",
            'inputOptions' => ['class' => 'form-control'],
            'labelOptions' => ['class' => 'form-label'],
            'errorOptions' => ['class' => 'form-error'],
        ],
    ]); ?>

    <div class="form-row">

        <div class="form-col">
            <?= $form->field($model, 'name')
                ->textInput([
                    'placeholder' => 'Product name',
                    'autocomplete' => 'off'
                ]) ?>
        </div>

        <div class="form-col">
            <?= $form->field($model, 'sku')
                ->textInput([
                    'placeholder' => 'SKU code',
                    'autocomplete' => 'off'
                ]) ?>
        </div>

    </div>

    <div class="form-row">

        <div class="form-col">
            <?= $form->field($model, 'buying_price')
                ->textInput([
                    'type' => 'number',
                    'step' => '0.01',
                    'placeholder' => '0.00'
                ]) ?>
        </div>

        <div class="form-col">
            <?= $form->field($model, 'selling_price')
                ->textInput([
                    'type' => 'number',
                    'step' => '0.01',
                    'placeholder' => '0.00'
                ]) ?>
        </div>

    </div>

    <div class="form-row">

        <div class="form-col">
            <?= $form->field($model, 'stock_quantity')
                ->textInput([
                    'type' => 'number',
                    'placeholder' => '0'
                ]) ?>
        </div>

        <div class="form-col">
            <?= $form->field($model, 'min_stock_alert')
                ->textInput([
                    'type' => 'number',
                    'placeholder' => 'Alert threshold'
                ]) ?>
        </div>

    </div>

    <div class="form-group mt-4">

        <?= Html::submitButton(
            $model->isNewRecord
                ? 'Create Product'
                : 'Update Product',
            [
                'class' => 'btn btn-primary save-btn'
            ]
        ) ?>

    </div>

    <?php ActiveForm::end(); ?>

</div>

<style>
/* ============================================
   FORM GRID
   ============================================ */
.form-row {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
    margin-bottom: 4px;
}

.form-col {
    display: flex;
    flex-direction: column;
}

/* ============================================
   FORM CONTROLS
   ============================================ */
.form-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 6px;
}

.form-label::after {
    content: ' *';
    color: var(--danger);
}

.form-control {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    background: var(--surface);
    color: var(--text);
    font-size: 14px;
    font-family: inherit;
    transition: all 0.2s ease;
    outline: none;
}

.form-control:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-glow);
}

.form-control::placeholder {
    color: var(--text-muted);
}

.form-error {
    font-size: 12px;
    color: var(--danger);
    margin-top: 4px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.form-error::before {
    content: '⚠';
}

/* ============================================
   SAVE BUTTON
   ============================================ */
.save-btn {
    width: 100%;
    padding: 14px;
    border-radius: var(--radius);
    border: none;
    font-weight: 700;
    font-size: 14px;
    color: white;
    background: linear-gradient(135deg, var(--primary), #8b5cf6);
    transition: all 0.3s ease;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.save-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(99, 102, 241, 0.35);
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
}
</style>