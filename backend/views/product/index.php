<?php

/** @var $products common\models\Product[] */

$this->title = 'My Products';

$totalProducts = count($products);
$totalStock = 0;
$totalValue = 0;
$lowStockCount = 0;

foreach ($products as $p) {
    $totalStock += (int)$p->stock_quantity;
    $totalValue += ((int)$p->stock_quantity * (float)$p->selling_price);
    if ($p->stock_quantity <= ($p->min_stock_alert ?? 5)) {
        $lowStockCount++;
    }
}
?>

<div class="page-container">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Products</h1>
            <p class="page-subtitle">Manage your branch inventory & stock levels</p>
        </div>
        <a href="/business-system/backend/web/product/create" class="btn btn-primary">
            <i data-lucide="plus" class="icon-16"></i>
            Add Product
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                <i data-lucide="package" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format($totalProducts) ?></div>
                <div class="stat-label">Total Products</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34,197,94,0.15); color: #22c55e;">
                <i data-lucide="layers" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format($totalStock) ?></div>
                <div class="stat-label">Total Stock Qty</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245,158,11,0.15); color: #f59e0b;">
                <i data-lucide="wallet" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">TZS <?= number_format($totalValue, 2) ?></div>
                <div class="stat-label">Inventory Value</div>
            </div>
        </div>
        <div class="stat-card <?= $lowStockCount > 0 ? 'critical' : '' ?>">
            <div class="stat-icon" style="background: rgba(239,68,68,0.15); color: #ef4444;">
                <i data-lucide="alert-triangle" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" style="color: <?= $lowStockCount > 0 ? '#ef4444' : 'var(--text)' ?>;">
                    <?= number_format($lowStockCount) ?>
                </div>
                <div class="stat-label">Low Stock Alerts</div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-card">
        <div class="data-header">
            <h3 class="data-title">
                <i data-lucide="list" class="icon-18"></i>
                Product Inventory
            </h3>
        </div>

        <?php if (!empty($products)): ?>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>SKU</th>
                            <th class="text-right">Buy Price</th>
                            <th class="text-right">Sell Price</th>
                            <th class="text-center">Stock</th>
                            <th class="text-right">Value</th>
                            <th class="text-center">Status</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $index => $product): ?>
                            <?php
                                $name = htmlspecialchars((string)($product->name ?? ''));
                                $sku = htmlspecialchars((string)($product->sku ?? ''));
                                $buyPrice = (float)($product->buying_price ?? 0);
                                $sellPrice = (float)($product->selling_price ?? 0);
                                $stock = (int)($product->stock_quantity ?? 0);
                                $minStock = (int)($product->min_stock_alert ?? 5);
                                $isLow = $stock <= $minStock;
                                $isActive = (int)($product->status ?? 0) === 1;
                                $productValue = $stock * $sellPrice;
                            ?>
                            <tr>
                                <td class="mono text-muted"><?= $index + 1 ?></td>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-icon">
                                            <i data-lucide="box" class="icon-16"></i>
                                        </div>
                                        <span class="product-name"><?= $name ?></span>
                                    </div>
                                </td>
                                <td class="mono text-muted"><?= $sku ?></td>
                                <td class="text-right mono">TZS <?= number_format($buyPrice, 2) ?></td>
                                <td class="text-right mono">TZS <?= number_format($sellPrice, 2) ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $isLow ? 'badge-danger' : 'badge-success' ?>">
                                        <?= $stock ?>
                                    </span>
                                </td>
                                <td class="text-right mono">TZS <?= number_format($productValue, 2) ?></td>
                                <td class="text-center">
                                    <?php if ($isActive): ?>
                                        <span class="status-pill status--success">Active</span>
                                    <?php else: ?>
                                        <span class="status-pill status--inactive">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-right">
                                    <div class="action-group">
                                        <a href="/business-system/backend/web/product/update?id=<?= (int)$product->id ?>" class="action-btn" title="Edit">
                                            <i data-lucide="pencil" class="icon-16"></i>
                                        </a>
                                        <form action="/business-system/backend/web/product/delete?id=<?= (int)$product->id ?>" method="post" class="inline" onsubmit="return confirm('Delete this product?')">
                                            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                                            <button type="submit" class="action-btn danger" title="Delete">
                                                <i data-lucide="trash-2" class="icon-16"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>

            <div class="empty-state">
                <div class="empty-icon">
                    <i data-lucide="package" class="icon-48"></i>
                </div>
                <h3>No products yet</h3>
                <p>Create your first product to start tracking inventory</p>
                <a href="/product/create" class="btn btn-primary">
                    <i data-lucide="plus" class="icon-16"></i>
                    Add Product
                </a>
            </div>

        <?php endif; ?>

    </div>

</div>

<style>
/* ============================================
   PAGE HEADER
   ============================================ */
.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 28px;
    gap: 16px;
    flex-wrap: wrap;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.5px;
    margin: 0 0 6px 0;
}

.page-subtitle {
    font-size: 14px;
    color: var(--text-muted);
    margin: 0;
}

/* ============================================
   STATS ROW
   ============================================ */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 16px;
    margin-bottom: 28px;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 20px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    transition: all 0.25s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
    border-color: var(--border-strong);
}

.stat-card.critical {
    border-color: rgba(239, 68, 68, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(239, 68, 68, 0.05));
}

.stat-icon {
    width: 44px;
    height: 44px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.stat-value {
    font-size: 20px;
    font-weight: 700;
    color: var(--text);
    line-height: 1.2;
    font-family: 'JetBrains Mono', monospace;
}

.stat-label {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
}

/* ============================================
   DATA CARD
   ============================================ */
.data-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
}

.data-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px 24px;
    border-bottom: 1px solid var(--border);
    flex-wrap: wrap;
    gap: 10px;
}

.data-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 600;
    color: var(--text);
    margin: 0;
}

.data-title i {
    color: var(--primary);
}

/* ============================================
   TABLE
   ============================================ */
.table-responsive {
    overflow-x: auto;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.data-table th {
    padding: 14px 16px;
    text-align: left;
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    background: var(--bg-elevated);
    border-bottom: 1px solid var(--border);
    white-space: nowrap;
}

.data-table td {
    padding: 14px 16px;
    border-bottom: 1px solid var(--border);
    color: var(--text-secondary);
    vertical-align: middle;
}

.data-table tbody tr {
    transition: background 0.15s ease;
}

.data-table tbody tr:hover {
    background: var(--surface-hover);
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

.text-center { text-align: center; }
.text-right { text-align: right; }
.text-muted { color: var(--text-muted); }
.mono { font-family: 'JetBrains Mono', monospace; }

/* Product Cell */
.product-cell {
    display: flex;
    align-items: center;
    gap: 10px;
}

.product-icon {
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

.product-name {
    font-weight: 500;
    color: var(--text);
}

/* Badges */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.badge-success {
    background: rgba(34, 197, 94, 0.15);
    color: #22c55e;
}

.badge-danger {
    background: rgba(239, 68, 68, 0.15);
    color: #ef4444;
}

.status-pill {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.status--success {
    background: rgba(34, 197, 94, 0.1);
    color: #22c55e;
    border: 1px solid rgba(34, 197, 94, 0.2);
}

.status--inactive {
    background: rgba(100, 116, 139, 0.1);
    color: #94a3b8;
    border: 1px solid rgba(100, 116, 139, 0.2);
}

/* Action Group */
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

.inline {
    display: inline;
    margin: 0;
}

/* ============================================
   EMPTY STATE
   ============================================ */
.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px 20px;
    text-align: center;
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
    margin: 0 0 20px 0;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .stats-row {
        grid-template-columns: 1fr;
    }
    .data-table th,
    .data-table td {
        padding: 12px 14px;
    }
    .product-icon {
        display: none;
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