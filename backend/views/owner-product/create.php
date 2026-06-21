<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Create Product';
?>

<div class="page-container narrow">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?= Url::to(['/owner-product/index']) ?>">
            <i data-lucide="chevron-left" class="icon-16"></i>
            Products
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Create</span>
    </nav>

    <!-- Form Card -->
    <div class="form-card">
        <div class="form-header">
            <div class="form-icon">
                <i data-lucide="package-plus" class="icon-24"></i>
            </div>
            <div>
                <h1 class="form-title">Create Product</h1>
                <p class="form-subtitle">Add new inventory to your branch</p>
            </div>
        </div>

        <!-- Feature Highlights -->
        <div class="feature-row">
            <div class="feature-pill">
                <i data-lucide="bar-chart-3" class="icon-14"></i>
                Inventory Tracking
            </div>
            <div class="feature-pill">
                <i data-lucide="trending-up" class="icon-14"></i>
                Profit Monitoring
            </div>
            <div class="feature-pill">
                <i data-lucide="zap" class="icon-14"></i>
                Fast Management
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
    background: linear-gradient(90deg, var(--primary), #8b5cf6);
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

/* ============================================
   FEATURE ROW
   ============================================ */
.feature-row {
    display: flex;
    gap: 10px;
    margin-bottom: 28px;
    flex-wrap: wrap;
}

.feature-pill {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    font-size: 12px;
    font-weight: 500;
    color: var(--text-secondary);
}

.feature-pill i {
    color: var(--primary);
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
    .feature-row {
        flex-direction: column;
    }
    .feature-pill {
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>