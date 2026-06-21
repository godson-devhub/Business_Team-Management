<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\StockMovement;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\Product[] $products
 */

$this->title = $branch->name . ' Stock Value';

$totalStockValue = 0;
$totalItems = count($products);
$stockSummary = [];

foreach ($products as $product) {
    $in = (int) StockMovement::find()
        ->where(['product_id' => $product->id, 'type' => 'IN'])
        ->sum('quantity');

    $out = (int) StockMovement::find()
        ->where(['product_id' => $product->id, 'type' => 'OUT'])
        ->sum('quantity');

    $currentStock = $in - $out;
    $productValue = $currentStock * $product->selling_price;
    $totalStockValue += $productValue;

    $stockSummary[] = [
        'name' => $product->name,
        'in' => $in,
        'out' => $out,
        'stock' => $currentStock,
        'price' => $product->selling_price,
        'value' => $productValue
    ];
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
        <span class="breadcrumb-current">Stock Value</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Realtime Stock Value</h1>
            <p class="page-subtitle">Live inventory valuation based on stock movements</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                <i data-lucide="package" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format($totalItems) ?></div>
                <div class="stat-label">Total Products</div>
            </div>
        </div>
        <div class="stat-card highlight">
            <div class="stat-icon" style="background: rgba(245,158,11,0.15); color: #f59e0b;">
                <i data-lucide="wallet" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" style="color: #f59e0b;">TZS <?= number_format($totalStockValue) ?></div>
                <div class="stat-label">Total Stock Value</div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-card">
        <div class="data-header">
            <h3 class="data-title">
                <i data-lucide="bar-chart-3" class="icon-18"></i>
                Stock Breakdown (IN / OUT / BALANCE)
            </h3>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="text-center">IN</th>
                        <th class="text-center">OUT</th>
                        <th class="text-center">Stock</th>
                        <th class="text-right">Price</th>
                        <th class="text-right">Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stockSummary as $row): ?>
                        <tr>
                            <td>
                                <div class="product-cell">
                                    <div class="product-icon">
                                        <i data-lucide="box" class="icon-16"></i>
                                    </div>
                                    <span class="product-name"><?= Html::encode($row['name']) ?></span>
                                </div>
                            </td>
                            <td class="text-center mono text-success"><?= number_format($row['in']) ?></td>
                            <td class="text-center mono text-danger"><?= number_format($row['out']) ?></td>
                            <td class="text-center">
                                <span class="badge badge-info"><?= number_format($row['stock']) ?></span>
                            </td>
                            <td class="text-right mono">TZS <?= number_format($row['price']) ?></td>
                            <td class="text-right mono" style="font-weight: 600; color: var(--text);">
                                TZS <?= number_format($row['value']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php if (empty($stockSummary)): ?>
                        <tr>
                            <td colspan="6" class="text-center" style="padding: 40px; color: var(--text-muted);">
                                No stock data available
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>

</div>

<style>
/* ============================================
   TEXT COLORS
   ============================================ */
.text-success { color: #22c55e; }
.text-danger { color: #ef4444; }

/* Same table and card styles */
.stat-card.highlight {
    border-color: rgba(245, 158, 11, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(245, 158, 11, 0.05));
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>