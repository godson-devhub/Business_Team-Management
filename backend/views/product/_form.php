<?php

use yii\widgets\ActiveForm;

/** @var $model common\models\Product */
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
            <?= $form->field($model, 'name')->textInput([
                'placeholder' => 'Enter product name',
                'autocomplete' => 'off',
                'maxlength' => true
            ]) ?>
        </div>
        <div class="form-col">
            <?= $form->field($model, 'sku')->textInput([
                'placeholder' => 'SKU code',
                'autocomplete' => 'off',
                'maxlength' => true
            ]) ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-col">
            <?= $form->field($model, 'buying_price')->textInput([
                'type' => 'number',
                'step' => '0.01',
                'placeholder' => '0.00'
            ]) ?>
        </div>
        <div class="form-col">
            <?= $form->field($model, 'selling_price')->textInput([
                'type' => 'number',
                'step' => '0.01',
                'placeholder' => '0.00'
            ]) ?>
        </div>
    </div>

   <div class="form-row">
       
        <div class="form-col">
            <?= $form->field($model, 'min_stock_alert')->textInput([
                'type' => 'number',
                'min' => 0,
                'placeholder' => 'Alert threshold'
            ]) ?>
        </div>
    </div>

    <div class="form-row">
        <div class="form-col">
            <?= $form->field($model, 'status')->dropDownList([
                1 => 'Active',
                0 => 'Inactive'
            ], ['class' => 'form-control']) ?>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">
            <i data-lucide="check" class="icon-16"></i>
            Save Product
        </button>
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

select.form-control {
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 36px;
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

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 16px;
    border-top: 1px solid var(--border);
    margin-top: 8px;
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