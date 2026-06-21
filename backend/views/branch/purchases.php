<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\PurchaseItem[] $purchases
 */

$this->title = $branch->name . ' Purchases';

$totalItems = count($purchases);
$totalQty = 0;
$totalValue = 0;
$todayQty = 0;
$todayValue = 0;

$todayStart = strtotime('today');
$todayEnd = strtotime('tomorrow');

foreach ($purchases as $item) {
    $lineTotal = $item->quantity * $item->buying_price;
    $totalQty += $item->quantity;
    $totalValue += $lineTotal;

    $createdAt = $item->purchase->created_at ?? 0;
    if ($createdAt >= $todayStart && $createdAt < $todayEnd) {
        $todayQty += $item->quantity;
        $todayValue += $lineTotal;
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
        <span class="breadcrumb-current">Purchases</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Purchase History</h1>
            <p class="page-subtitle">All purchase transactions for this branch</p>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(99,102,241,0.15); color: #6366f1;">
                <i data-lucide="shopping-cart" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format($totalItems) ?></div>
                <div class="stat-label">Total Items</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                <i data-lucide="layers" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format($totalQty) ?></div>
                <div class="stat-label">Total Quantity</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(139,92,246,0.15); color: #8b5cf6;">
                <i data-lucide="banknote" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">TZS <?= number_format($totalValue) ?></div>
                <div class="stat-label">Total Value</div>
            </div>
        </div>
        <div class="stat-card highlight">
            <div class="stat-icon" style="background: rgba(6,182,212,0.15); color: #06b6d4;">
                <i data-lucide="calendar" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" style="color: #06b6d4;">TZS <?= number_format($todayValue) ?></div>
                <div class="stat-label">Today's Value</div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-card">
        <div class="data-header">
            <h3 class="data-title">
                <i data-lucide="shopping-bag" class="icon-18"></i>
                Purchase Items
            </h3>
            <span class="data-count"><?= $totalItems ?> records</span>
        </div>

        <?php if (!empty($purchases)): ?>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th class="text-center">Qty</th>
                            <th class="text-right">Buy Price</th>
                            <th class="text-right">Total</th>
                            <th class="text-center">Purchase ID</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($purchases as $item): ?>
                            <?php $total = $item->quantity * $item->buying_price; ?>
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
                                <td class="text-right mono">TZS <?= number_format($item->buying_price) ?></td>
                                <td class="text-right mono">TZS <?= number_format($total) ?></td>
                                <td class="text-center">
                                    <span class="mono text-muted">#<?= $item->purchase_id ?></span>
                                </td>
                                <td class="text-muted">
                                    <?= date('d M Y H:i', $item->purchase->created_at ?? time()) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>

            <div class="empty-state">
                <div class="empty-icon">
                    <i data-lucide="shopping-cart" class="icon-48"></i>
                </div>
                <h3>No purchases found</h3>
                <p>No purchase records exist for this branch</p>
            </div>

        <?php endif; ?>

    </div>

</div>

<style>
/* Same table and card styles as daily-profit */
.stat-card.highlight {
    border-color: rgba(6, 182, 212, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(6, 182, 212, 0.05));
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>