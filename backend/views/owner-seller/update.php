<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var \common\models\User $model */
/** @var array $branches */

$this->title = 'Update ' . $model->username;
?>

<div class="page-container narrow">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?= Url::to(['/owner-seller/index']) ?>">
            <i data-lucide="chevron-left" class="icon-16"></i>
            Sellers
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Edit</span>
    </nav>

    <!-- Form Card -->
    <div class="form-card">
        <div class="form-header">
            <div class="form-icon" style="background: linear-gradient(135deg, #f59e0b, #ef4444);">
                <i data-lucide="pencil" class="icon-24"></i>
            </div>
            <div>
                <h1 class="form-title">Update Seller</h1>
                <p class="form-subtitle">Edit <?= Html::encode($model->username) ?>'s details</p>
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
                    ->textInput(['placeholder' => 'Username', 'autocomplete' => 'off'])
                ?>
            </div>

            <div class="form-group">
                <?= $form->field($model, 'email')
                    ->textInput(['placeholder' => 'Email address', 'autocomplete' => 'off', 'type' => 'email'])
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
                <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #f59e0b, #ef4444);">
                    <i data-lucide="save" class="icon-16"></i>
                    Save Changes
                </button>
            </div>

        <?php ActiveForm::end(); ?>
    </div>

</div>

<style>
/* Reuses create.php styles + update-specific overrides */
.form-card::before {
    background: linear-gradient(90deg, #f59e0b, #ef4444);
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