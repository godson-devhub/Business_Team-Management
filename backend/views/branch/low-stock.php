<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\Product[] $products
 */

$this->title = $branch->name . ' Low Stock';

$totalLowStock = count($products);
$criticalCount = 0;
$warningCount = 0;

foreach ($products as $product) {
    $threshold = (int)$product->min_stock_alert;
    if ($product->stock_quantity <= 2) {
        $criticalCount++;
    } else {
        $warningCount++;
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
        <span class="breadcrumb-current">Low Stock</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Low Stock Alert</h1>
            <p class="page-subtitle">Products requiring immediate restock</p>
        </div>
        <div class="alert-badge">
            <i data-lucide="alert-triangle" class="icon-14"></i>
            <?= $totalLowStock ?> items need attention
        </div>
    </div>

    <!-- Alert Stats -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                <i data-lucide="package" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= $totalLowStock ?></div>
                <div class="stat-label">Total Low Stock</div>
            </div>
        </div>
        <div class="stat-card critical">
            <div class="stat-icon" style="background: rgba(239,68,68,0.15); color: #ef4444;">
                <i data-lucide="alert-octagon" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" style="color: #ef4444;"><?= $criticalCount ?></div>
                <div class="stat-label">Critical (0–2)</div>
            </div>
        </div>
        <div class="stat-card warning">
            <div class="stat-icon" style="background: rgba(245,158,11,0.15); color: #f59e0b;">
                <i data-lucide="alert-circle" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" style="color: #f59e0b;"><?= $warningCount ?></div>
                <div class="stat-label">Warning (3+)</div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-card">
        <div class="data-header">
            <h3 class="data-title">
                <i data-lucide="package-x" class="icon-18"></i>
                Products Requiring Restock
            </h3>
        </div>

        <?php if (!empty($products)): ?>

            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Threshold</th>
                            <th class="text-right">Buy Price</th>
                            <th class="text-right">Sell Price</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $index => $product): ?>
                            <?php
                                $threshold = (int)$product->min_stock_alert;
                                $isCritical = $product->stock_quantity <= 2;
                            ?>
                            <tr class="<?= $isCritical ? 'critical-row' : '' ?>">
                                <td class="mono text-muted"><?= $index + 1 ?></td>
                                <td>
                                    <div class="product-cell">
                                        <div class="product-icon" style="background: <?= $isCritical ? 'rgba(239,68,68,0.15)' : 'rgba(245,158,11,0.15)' ?>; color: <?= $isCritical ? '#ef4444' : '#f59e0b' ?>;">
                                            <i data-lucide="box" class="icon-16"></i>
                                        </div>
                                        <span class="product-name"><?= Html::encode($product->name) ?></span>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="badge <?= $isCritical ? 'badge-danger' : 'badge-warning' ?>">
                                        <?= (int)$product->stock_quantity ?>
                                    </span>
                                </td>
                                <td class="text-center text-muted"><?= $threshold ?></td>
                                <td class="text-right mono">TZS <?= number_format($product->buying_price, 2) ?></td>
                                <td class="text-right mono">TZS <?= number_format($product->selling_price, 2) ?></td>
                                <td class="text-center">
                                    <?php if ($isCritical): ?>
                                        <span class="badge badge-danger">Critical</span>
                                    <?php else: ?>
                                        <span class="badge badge-warning">Warning</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        <?php else: ?>

            <div class="empty-state">
                <div class="empty-icon" style="background: rgba(34,197,94,0.15); color: #22c55e;">
                    <i data-lucide="check-circle" class="icon-48"></i>
                </div>
                <h3>All stocked up!</h3>
                <p>No products are running low on inventory</p>
            </div>

        <?php endif; ?>

    </div>

</div>

<style>
/* ============================================
   ALERT BADGE
   ============================================ */
.alert-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: var(--radius-lg);
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.2);
    font-size: 13px;
    font-weight: 600;
    color: var(--danger);
}

/* ============================================
   CRITICAL / WARNING CARDS
   ============================================ */
.stat-card.critical {
    border-color: rgba(239, 68, 68, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(239, 68, 68, 0.05));
}

.stat-card.warning {
    border-color: rgba(245, 158, 11, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(245, 158, 11, 0.05));
}

/* ============================================
   TABLE ROW HIGHLIGHTING
   ============================================ */
.critical-row {
    background: rgba(239, 68, 68, 0.03);
}

.critical-row:hover {
    background: rgba(239, 68, 68, 0.06) !important;
}

.badge-danger {
    background: rgba(239, 68, 68, 0.15);
    color: #ef4444;
    font-weight: 600;
}

.badge-warning {
    background: rgba(245, 158, 11, 0.15);
    color: #f59e0b;
    font-weight: 600;
}

/* Same table and responsive styles as daily-profit */
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>