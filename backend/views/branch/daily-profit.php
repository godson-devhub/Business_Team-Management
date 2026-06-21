<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\SaleItem[] $sales
 * @var float $totalProfit
 */

$this->title = $branch->name . ' Daily Profit';

$totalItems = count($sales);
$totalRevenue = 0;

foreach ($sales as $item) {
    $totalRevenue += ($item->quantity * $item->selling_price);
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
        <span class="breadcrumb-current">Daily Profit</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Daily Profit</h1>
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
            <div class="stat-icon" style="background: rgba(139,92,246,0.15); color: #8b5cf6;">
                <i data-lucide="package" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= number_format($totalItems) ?></div>
                <div class="stat-label">Items Sold</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                <i data-lucide="banknote" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">TZS <?= number_format($totalRevenue) ?></div>
                <div class="stat-label">Revenue</div>
            </div>
        </div>
        <div class="stat-card highlight">
            <div class="stat-icon" style="background: rgba(168,85,247,0.15); color: #a855f7;">
                <i data-lucide="trending-up" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value" style="color: #a855f7;">TZS <?= number_format($totalProfit) ?></div>
                <div class="stat-label">Total Profit</div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-card">
        <div class="data-header">
            <h3 class="data-title">
                <i data-lucide="pie-chart" class="icon-18"></i>
                Profit Breakdown
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
                            <th class="text-right">Revenue</th>
                            <th class="text-right">Profit</th>
                            <th class="text-right">Unit Profit</th>
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
                                <td class="text-right mono">TZS <?= number_format($item->quantity * $item->selling_price) ?></td>
                                <td class="text-right">
                                    <span class="badge badge-profit">TZS <?= number_format($item->profit) ?></span>
                                </td>
                                <td class="text-right mono">
                                    TZS <?= number_format($item->selling_price - ($item->product->buying_price ?? 0)) ?>
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
                    <i data-lucide="trending-down" class="icon-48"></i>
                </div>
                <h3>No profit data today</h3>
                <p>No sales have been recorded for this branch today</p>
            </div>

        <?php endif; ?>

    </div>

</div>

<style>
/* ============================================
   DATE BADGE
   ============================================ */
.date-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: var(--radius-lg);
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
}

/* ============================================
   HIGHLIGHT STAT CARD
   ============================================ */
.stat-card.highlight {
    border-color: rgba(168, 85, 247, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(168, 85, 247, 0.05));
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

.data-count {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
    padding: 4px 12px;
    border-radius: 20px;
    background: var(--bg-elevated);
}

/* ============================================
   TABLE STYLES
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
    padding: 14px 20px;
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
    padding: 14px 20px;
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
.badge-profit {
    background: rgba(168, 85, 247, 0.15);
    color: #a855f7;
    font-weight: 600;
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
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: var(--bg-elevated);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    margin-bottom: 16px;
}

.empty-state h3 {
    font-size: 16px;
    font-weight: 600;
    color: var(--text);
    margin: 0 0 6px 0;
}

.empty-state p {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
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
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>