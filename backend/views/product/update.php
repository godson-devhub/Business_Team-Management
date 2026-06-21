<?php

/** @var $model common\models\Product */

$this->title = 'Update ' . htmlspecialchars((string)$model->name);
?>

<div class="page-container narrow">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="/product/index">
            <i data-lucide="chevron-left" class="icon-16"></i>
            Products
        </a>
        <span class="breadcrumb-separator">/</span>
        <a href="/product/view?id=<?= (int)$model->id ?>">
            <?= htmlspecialchars((string)$model->name) ?>
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
                <p class="form-subtitle">Edit <?= htmlspecialchars((string)$model->name) ?> details</p>
            </div>
        </div>

        <!-- Product Info Card -->
        <div class="info-card">
            <div class="info-icon">
                <i data-lucide="box" class="icon-24"></i>
            </div>
            <div class="info-details">
                <div class="info-title"><?= htmlspecialchars((string)$model->name) ?></div>
                <div class="info-meta">
                    <span class="meta-item">
                        <i data-lucide="tag" class="icon-14"></i>
                        SKU: <?= htmlspecialchars((string)($model->sku ?? 'N/A')) ?>
                    </span>
                    <span class="meta-item">
                        <i data-lucide="layers" class="icon-14"></i>
                        Stock: <?= (int)$model->stock_quantity ?>
                    </span>
                    <span class="meta-item">
                        <i data-lucide="circle-dollar-sign" class="icon-14"></i>
                        Sell: TZS <?= number_format((float)$model->selling_price, 2) ?>
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
/* Reuses create.php styles + update-specific overrides */
.form-card::before {
    background: linear-gradient(90deg, #f59e0b, #ef4444);
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