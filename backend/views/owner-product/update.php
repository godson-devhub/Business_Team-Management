<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Update Product';
?>

<div class="page-container narrow">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?= Url::to(['/owner-product/index']) ?>">
            <i data-lucide="chevron-left" class="icon-16"></i>
            Products
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
                <h1 class="form-title">Update Product</h1>
                <p class="form-subtitle">Edit product details and inventory settings</p>
            </div>
        </div>

        <!-- Product Info Card -->
        <div class="info-card">
            <div class="info-icon">
                <i data-lucide="box" class="icon-24"></i>
            </div>
            <div class="info-details">
                <div class="info-title"><?= Html::encode($model->name) ?></div>
                <div class="info-meta">
                    <span class="meta-item">
                        <i data-lucide="tag" class="icon-14"></i>
                        SKU: <?= Html::encode($model->sku ?: 'N/A') ?>
                    </span>
                    <span class="meta-item">
                        <i data-lucide="layers" class="icon-14"></i>
                        Stock: <?= $model->stock_quantity ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="form-wrapper">
            <?= $this->render('_form', [
                'model' => $model
            ]) ?>
        </div>
    </div>

</div>

<style>
/* ============================================
   NARROW CONTAINER
   ============================================ */
.page-container.narrow {
    max-width: 720px;
    margin: 0 auto;
    padding-top: 20px;
}

/* ============================================
   FORM CARD
   ============================================ */
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
    background: linear-gradient(90deg, #f59e0b, #ef4444);
}

.form-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 24px;
}

.form-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius);
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
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

/* ============================================
   INFO CARD
   ============================================ */
.info-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    margin-bottom: 28px;
    border-radius: var(--radius-lg);
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    transition: all 0.2s ease;
}

.info-card:hover {
    background: var(--surface-hover);
}

.info-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius);
    background: linear-gradient(135deg, var(--primary), #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.info-details {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.info-title {
    font-size: 16px;
    font-weight: 600;
    color: var(--text);
}

.info-meta {
    display: flex;
    gap: 16px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    color: var(--text-muted);
}

/* ============================================
   FORM WRAPPER
   ============================================ */
.form-wrapper {
    margin-top: 8px;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .form-card {
        padding: 20px;
    }
    .info-meta {
        flex-direction: column;
        gap: 4px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>