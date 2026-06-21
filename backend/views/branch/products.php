<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\Product[] $products
 */

$this->title = $branch->name . ' Products';

$totalProducts = count($products);
$totalStockQty = 0;
$totalInventoryValue = 0;
$lowStockCount = 0;

foreach ($products as $product) {
    $totalStockQty += (int)$product->stock_quantity;
    $totalInventoryValue += ((int)$product->stock_quantity * (float)$product->selling_price);
    if ($product->stock_quantity <= $product->min_stock_alert) {
        $lowStockCount++;
    }
}
?>

<div class="page-container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?= Url::to(['branch/view', 'id' => $branch->id]) ?>">
            <i data-lucide="chevron-left" class="icon-16"></i>
            <?= Html::encode($branch->name) ?>
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Products</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Products</h1>
            <p class="page-subtitle">Manage branch inventory & stock levels</p>
        </div>
    </div>

    <!-- Summary Cards -->
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
                <div class="stat-value"><?= number_format($totalStockQty) ?></div>
                <div class="stat-label">Total Stock Qty</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245,158,11,0.15); color: #f59e0b;">
                <i data-lucide="wallet" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">TZS <?= number_format($totalInventoryValue, 2) ?></div>
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
                            <th class="text-right">Buy Price</th>
                            <th class="text-right">Sell Price</th>
                            <th class="text-center">Stock</th>
                            <th class="text-right">Profit</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $index => $product): ?>
                            <?php
                                $profit = $product->selling_price - $product->buying_price;
                                $isLow = $product->stock_quantity <= $product->min_stock_alert;
                            ?>
                            <tr>
                                <td class="mono text-muted"><?= $index + 1 ?></td>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-icon">
                                            <i data-lucide="box" class="icon-16"></i>
                                        </div>
                                        <span class="product-name"><?= Html::encode($product->name) ?></span>
                                    </div>
                                </td>
                                <td class="text-right mono">TZS <?= number_format($product->buying_price, 2) ?></td>
                                <td class="text-right mono">TZS <?= number_format($product->selling_price, 2) ?></td>
                                <td class="text-center">
                                    <span class="badge <?= $isLow ? 'badge-danger' : 'badge-success' ?>">
                                        <?= (int)$product->stock_quantity ?>
                                    </span>
                                </td>
                                <td class="text-right mono">TZS <?= number_format($profit, 2) ?></td>
                                <td class="text-center">
                                    <?php if ($isLow): ?>
                                        <span class="badge badge-danger">Low Stock</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">In Stock</span>
                                    <?php endif; ?>
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
                <h3>No products found</h3>
                <p>This branch doesn't have any products in inventory yet</p>
            </div>

        <?php endif; ?>

    </div>

</div>

<style>
/* Same styles as low-stock.php + success badge */
.badge-success {
    background: rgba(34, 197, 94, 0.15);
    color: #22c55e;
    font-weight: 600;
}

.stat-card.critical {
    border-color: rgba(239, 68, 68, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(239, 68, 68, 0.05));
}

/* Same table and responsive styles */
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>