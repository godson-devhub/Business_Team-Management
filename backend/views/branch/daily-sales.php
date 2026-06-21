<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\SaleItem[] $sales
 */

$this->title = $branch->name . ' Daily Sales';

$totalRevenue = 0;
$totalProfit = 0;
$totalItems = count($sales);

foreach ($sales as $item) {
    $totalRevenue += ($item->quantity * $item->selling_price);
    $totalProfit += (float)$item->profit;
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
        <span class="breadcrumb-current">Daily Sales</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Daily Sales</h1>
            <p class="page-subtitle"><?= Html::encode($branch->name) ?> — <?= date('F d, Y') ?></p>
        </div>
        <div class="date-badge">
            <i data-lucide="calendar" class="icon-14"></i>
            Today
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
                <div class="stat-label">Items Sold</div>
            </div>
        </div>
        <div class="stat-card highlight-blue">
            <div class="stat-icon" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                <i data-lucide="banknote" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" style="color: #3b82f6;">TZS <?= number_format($totalRevenue) ?></div>
                <div class="stat-label">Total Revenue</div>
            </div>
        </div>
        <div class="stat-card highlight-green">
            <div class="stat-icon" style="background: rgba(34,197,94,0.15); color: #22c55e;">
                <i data-lucide="trending-up" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" style="color: #22c55e;">TZS <?= number_format($totalProfit) ?></div>
                <div class="stat-label">Total Profit</div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-card">
        <div class="data-header">
            <h3 class="data-title">
                <i data-lucide="receipt" class="icon-18"></i>
                Sales Breakdown
            </h3>
            <span class="data-count"><?= $totalItems ?> transactions</span>
        </div>

        <?php if (!empty($sales)): ?>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Price</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">Profit</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sales as $item): ?>
                            <tr>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-icon">
                                            <i data-lucide="box" class="icon-16"></i>
                                        </div>
                                        <span class="product-name"><?= Html::encode($item->product->name ?? 'N/A') ?></span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-info"><?= $item->quantity ?></span>
                                </td>
                                <td class="text-right mono">TZS <?= number_format($item->selling_price) ?></td>
                                <td class="text-right mono">TZS <?= number_format($item->quantity * $item->selling_price) ?></td>
                                <td class="text-right">
                                    <span class="badge badge-success">TZS <?= number_format($item->profit) ?></span>
                                </td>
                                <td class="text-muted">
                                    <?= date('d M Y H:i', $item->sale->created_at ?? time()) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>

            <div class="empty-state">
                <div class="empty-icon">
                    <i data-lucide="receipt" class="icon-48"></i>
                </div>
                <h3>No sales today</h3>
                <p>No sales have been recorded for this branch today</p>
            </div>

        <?php endif; ?>

    </div>

</div>

<style>
/* Reuses daily-profit styles + specific overrides */
.stat-card.highlight-blue {
    border-color: rgba(59, 130, 246, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(59, 130, 246, 0.05));
}

.stat-card.highlight-green {
    border-color: rgba(34, 197, 94, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(34, 197, 94, 0.05));
}

.badge-success {
    background: rgba(34, 197, 94, 0.15);
    color: #22c55e;
    font-weight: 600;
}

/* Same responsive and table styles as daily-profit */
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>