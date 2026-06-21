<?php

use yii\web\YiiAsset;
use yii\helpers\Html;
use yii\helpers\Url;

YiiAsset::register($this);

$this->title = 'Owner Product Manager';

$productCount = count($products);
$totalStock = 0;
$totalValue = 0;

foreach ($products as $product) {
    $totalStock += $product->stock_quantity;
    $totalValue += ($product->stock_quantity * $product->selling_price);
}
?>

<div class="page-container">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Product Management</h1>
            <p class="page-subtitle">Manage inventory across all branches</p>
        </div>
    </div>

    <!-- Branch Selector -->
    <div class="selector-card">
        <form method="get" class="branch-form">
            <div class="select-wrapper">
                <i data-lucide="git-branch" class="select-icon"></i>
                <select name="branch_id" class="form-control branch-select">
                    <option value="">Select Branch</option>
                    <?php foreach ($branches as $branch): ?>
                        <option value="<?= $branch->id ?>" <?= $activeBranch == $branch->id ? 'selected' : '' ?>>
                            <?= Html::encode($branch->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i data-lucide="refresh-cw" class="icon-16"></i>
                Load Branch
            </button>
        </form>
    </div>

    <?php if ($activeBranch): ?>

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                    <i data-lucide="package" class="icon-20"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value"><?= number_format($productCount) ?></div>
                    <div class="stat-label">Products</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(34,197,94,0.15); color: #22c55e;">
                    <i data-lucide="layers" class="icon-20"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value"><?= number_format($totalStock) ?></div>
                    <div class="stat-label">Stock Quantity</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: rgba(245,158,11,0.15); color: #f59e0b;">
                    <i data-lucide="wallet" class="icon-20"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-value">TZS <?= number_format($totalValue) ?></div>
                    <div class="stat-label">Inventory Value</div>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="data-card">
            <div class="data-header">
                <h3 class="data-title">
                    <i data-lucide="list" class="icon-18"></i>
                    Branch Products
                </h3>
                <a href="<?= Url::to(['/owner-product/create']) ?>" class="btn btn-primary">
                    <i data-lucide="plus" class="icon-16"></i>
                    Add Product
                </a>
            </div>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>SKU</th>
                            <th class="text-right">Buy Price</th>
                            <th class="text-right">Sell Price</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-icon">
                                            <i data-lucide="box" class="icon-16"></i>
                                        </div>
                                        <span class="product-name"><?= Html::encode($product->name) ?></span>
                                    </div>
                                </td>
                                <td class="mono text-muted"><?= Html::encode($product->sku) ?></td>
                                <td class="text-right mono">TZS <?= number_format($product->buying_price, 2) ?></td>
                                <td class="text-right mono">TZS <?= number_format($product->selling_price, 2) ?></td>
                                <td class="text-center">
                                    <?php if ($product->stock_quantity <= $product->min_stock_alert): ?>
                                        <span class="badge badge-danger"><?= $product->stock_quantity ?></span>
                                    <?php else: ?>
                                        <span class="badge badge-success"><?= $product->stock_quantity ?></span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <?php if ($product->status): ?>
                                        <span class="status-badge active">Active</span>
                                    <?php else: ?>
                                        <span class="status-badge inactive">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <div class="action-group">
                                        <a href="<?= Url::to(['/owner-product/update', 'id' => $product->id]) ?>" class="action-btn" title="Edit">
                                            <i data-lucide="pencil" class="icon-16"></i>
                                        </a>
                                        <?= Html::beginForm(['delete', 'id' => $product->id], 'post', ['class' => 'inline']) ?>
                                            <button type="submit" class="action-btn danger" title="Delete" onclick="return confirm('Delete this product?')">
                                                <i data-lucide="trash-2" class="icon-16"></i>
                                            </button>
                                        <?= Html::endForm() ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (empty($products)): ?>
                            <tr>
                                <td colspan="7" class="empty-cell">
                                    <div class="empty-inline">
                                        <i data-lucide="package" class="icon-24"></i>
                                        <span>No products found in this branch</span>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>

    <?php else: ?>

        <!-- Empty State -->
        <div class="empty-state">
            <div class="empty-icon">
                <i data-lucide="git-branch" class="icon-48"></i>
            </div>
            <h3>Select a branch</h3>
            <p>Choose a branch from the dropdown above to view and manage products</p>
        </div>

    <?php endif; ?>

</div>

<style>
/* ============================================
   SELECTOR CARD
   ============================================ */
.selector-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 20px;
    margin-bottom: 24px;
}

.branch-form {
    display: flex;
    gap: 12px;
    align-items: center;
    flex-wrap: wrap;
}

.select-wrapper {
    position: relative;
    flex: 1;
    min-width: 200px;
}

.select-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    width: 18px;
    height: 18px;
    pointer-events: none;
}

.branch-select {
    padding-left: 40px !important;
    width: 100%;
}

/* ============================================
   DATA TABLE SPECIFIC
   ============================================ */
.data-table .product-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.data-table .product-icon {
    width: 32px;
    height: 32px;
    border-radius: var(--radius-sm);
    background: var(--bg-elevated);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    flex-shrink: 0;
}

.data-table .product-name {
    font-weight: 500;
    color: var(--text);
}

.action-group {
    display: flex;
    gap: 6px;
    justify-content: flex-end;
}

.action-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-sm);
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    color: var(--text-secondary);
    transition: all 0.15s ease;
    cursor: pointer;
}

.action-btn:hover {
    background: var(--surface-hover);
    color: var(--text);
}

.action-btn.danger:hover {
    background: rgba(239, 68, 68, 0.15);
    color: var(--danger);
    border-color: rgba(239, 68, 68, 0.3);
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.status-badge.active {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: #22c55e;
}

.status-badge.inactive {
    background: rgba(100, 116, 139, 0.1);
    border: 1px solid rgba(100, 116, 139, 0.2);
    color: #94a3b8;
}

.empty-cell {
    padding: 40px !important;
    text-align: center;
}

.empty-inline {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    color: var(--text-muted);
}

/* ============================================
   EMPTY STATE (NO BRANCH SELECTED)
   ============================================ */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 80px 20px;
    text-align: center;
    background: var(--card-bg);
    border: 1px dashed var(--border);
    border-radius: var(--radius-lg);
}

.empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: var(--bg-elevated);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 18px;
    font-weight: 600;
    color: var(--text);
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 14px;
    color: var(--text-muted);
    margin: 0;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .branch-form {
        flex-direction: column;
    }
    .branch-form .btn {
        width: 100%;
        justify-content: center;
    }
    .data-table th,
    .data-table td {
        padding: 12px 14px;
    }
    .action-group {
        flex-direction: column;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>