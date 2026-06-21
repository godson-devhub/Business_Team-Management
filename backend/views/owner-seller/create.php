<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var \common\models\User $model */
/** @var array $branches */

$this->title = 'Create Seller';
?>

<div class="page-container narrow">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?= Url::to(['/owner-seller/index']) ?>">
            <i data-lucide="chevron-left" class="icon-16"></i>
            Sellers
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Create</span>
    </nav>

    <!-- Form Card -->
    <div class="form-card">
        <div class="form-header">
            <div class="form-icon">
                <i data-lucide="user-plus" class="icon-24"></i>
            </div>
            <div>
                <h1 class="form-title">Create Seller</h1>
                <p class="form-subtitle">Add a new team member to your branch</p>
            </div>
        </div>

        <?php $form = ActiveForm::begin([
            'options' => ['class' => 'form-body'],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'inputOptions' => ['class' => 'form-control'],
                'labelOptions' => ['class' => 'form-label'],
                'errorOptions' => ['class' => 'form-error'],
            ],
        ]); ?>

            <div class="form-group">
                <?= $form->field($model, 'username')
                    ->textInput(['placeholder' => 'Enter username', 'autocomplete' => 'off'])
                ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'email')
                    ->textInput(['placeholder' => 'Enter email address', 'autocomplete' => 'off', 'type' => 'email'])
                ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'password')
                    ->passwordInput(['placeholder' => 'Create a secure password', 'autocomplete' => 'off'])
                ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'branch_id')
                    ->dropDownList(
                        ArrayHelper::map($branches, 'id', 'name'),
                        ['prompt' => 'Select Branch', 'class' => 'form-control']
                    )
                ?>
            </div>

            <div class="form-actions">
                <a href="<?= Url::to(['/owner-seller/index']) ?>" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i data-lucide="check" class="icon-16"></i>
                    Create Seller
                </button>
            </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>

<style>
/* Reuses shared form styles from business/create.php */
.page-container.narrow {
    max-width: 560px;
    margin: 0 auto;
    padding-top: 20px;
}

.form-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    padding: 32px;
    margin-top: 24px;
    position: relative;
    overflow: hidden;
}

.form-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary), #8b5cf6);
}

.form-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 28px;
}

.form-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius);
    background: linear-gradient(135deg, var(--primary), #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 12px var(--primary-glow);
    flex-shrink: 0;
}

.form-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 4px 0;
}

.form-subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
}

.form-body {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 2px;
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
    padding-top: 8px;
    border-top: 1px solid var(--border);
    margin-top: 8px;
}

@media (max-width: 768px) {
    .form-card {
        padding: 20px;
    }
    .form-actions {
        flex-direction: column;
    }
    .form-actions .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>