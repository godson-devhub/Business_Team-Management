<?php

$this->title = 'Delete Product';
?>

<div class="page-container narrow">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="/product/index">
            <i data-lucide="chevron-left" class="icon-16"></i>
            Products
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Delete</span>
    </nav>

    <!-- Delete Card -->
    <div class="form-card">
        <div class="form-header">
            <div class="form-icon" style="background: linear-gradient(135deg, #ef4444, #f97316);">
                <i data-lucide="alert-triangle" class="icon-24"></i>
            </div>
            <div>
                <h1 class="form-title">Delete Product</h1>
                <p class="form-subtitle">This action cannot be undone</p>
            </div>
        </div>

        <div class="delete-warning">
            <div class="warning-icon">
                <i data-lucide="trash-2" class="icon-32"></i>
            </div>
            <div class="warning-content">
                <h3>Are you sure?</h3>
                <p>You are about to delete <strong><?= htmlspecialchars((string)($model->name ?? '')) ?></strong> from your inventory. This will permanently remove the product and all associated data.</p>
                
                <div class="warning-details">
                    <div class="detail-item">
                        <span class="detail-label">Stock Quantity</span>
                        <span class="detail-value"><?= (int)($model->stock_quantity ?? 0) ?> units</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Selling Price</span>
                        <span class="detail-value">TZS <?= number_format((float)($model->selling_price ?? 0), 2) ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Stock Value</span>
                        <span class="detail-value">TZS <?= number_format((int)($model->stock_quantity ?? 0) * (float)($model->selling_price ?? 0), 2) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <form method="post" class="delete-actions">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
            
            <a href="/product/index" class="btn btn-secondary">
                <i data-lucide="x" class="icon-16"></i>
                Cancel
            </a>
            <button type="submit" class="btn btn-danger">
                <i data-lucide="trash-2" class="icon-16"></i>
                Yes, Delete Product
            </button>
        </form>
    </div>

</div>

<style>
/* ============================================
   DELETE WARNING
   ============================================ */
.delete-warning {
    display: flex;
    gap: 20px;
    padding: 28px;
    margin-bottom: 24px;
    border-radius: var(--radius-lg);
    background: rgba(239, 68, 68, 0.05);
    border: 1px solid rgba(239, 68, 68, 0.2);
}

.warning-icon {
    width: 56px;
    height: 56px;
    border-radius: var(--radius);
    background: rgba(239, 68, 68, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ef4444;
    flex-shrink: 0;
}

.warning-content {
    flex: 1;
}

.warning-content h3 {
    font-size: 18px;
    font-weight: 700;
    color: #fca5a5;
    margin: 0 0 8px 0;
}

.warning-content p {
    font-size: 14px;
    color: var(--text-secondary);
    line-height: 1.6;
    margin: 0 0 16px 0;
}

.warning-content strong {
    color: var(--text);
}

.warning-details {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
}

.detail-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
    padding: 12px;
    border-radius: var(--radius);
    background: var(--bg-elevated);
    border: 1px solid var(--border);
}

.detail-label {
    font-size: 11px;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 600;
}

.detail-value {
    font-size: 14px;
    font-weight: 700;
    color: var(--text);
    font-family: 'JetBrains Mono', monospace;
}

/* ============================================
   DELETE ACTIONS
   ============================================ */
.delete-actions {
    display: flex;
    gap: 12px;
    justify-content: flex-end;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}

.btn-danger {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    box-shadow: 0 4px 16px rgba(239, 68, 68, 0.35);
}

.btn-danger:hover {
    box-shadow: 0 6px 24px rgba(239, 68, 68, 0.5);
    transform: translateY(-2px);
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .delete-warning {
        flex-direction: column;
        align-items: center;
        text-align: center;
    }
    .warning-details {
        grid-template-columns: 1fr;
    }
    .delete-actions {
        flex-direction: column;
    }
    .delete-actions .btn {
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