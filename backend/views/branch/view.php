<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\User[] $sellers
 * @var \common\models\Product[] $products
 * @var \common\models\Sale[] $sales
 * @var \common\models\Purchase[] $purchases
 * @var float $dailySales
 * @var float $dailyProfit
 */

$this->title = $branch->name;

$sellerCount = count($sellers ?? []);
$productCount = count($products ?? []);
$purchaseCount = count($purchases ?? []);
$salesCount = count($sales ?? []);

$totalStockValue = 0;
$lowStockCount = 0;

foreach ($products ?? [] as $p) {
    $totalStockValue += ($p->stock_quantity * $p->selling_price);
    if ($p->stock_quantity <= 5) {
        $lowStockCount++;
    }
}
?>

<div class="page-container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?= Url::to(['business/view', 'id' => $branch->business_id]) ?>">
            <i data-lucide="chevron-left" class="icon-16"></i>
            <?= Html::encode($branch->business->name ?? 'Business') ?>
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current"><?= Html::encode($branch->name) ?></span>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-content">
            <div class="hero-badge">
                <span class="status-dot online"></span>
                Active Branch
            </div>
            <h1 class="hero-title"><?= Html::encode($branch->name) ?></h1>
            <div class="hero-location">
                <i data-lucide="map-pin" class="icon-14"></i>
                <?= Html::encode($branch->location ?: 'No location set') ?>
            </div>
        </div>
        <div class="hero-actions">
            <a href="<?= Url::to(['branch/update', 'id' => $branch->id]) ?>" class="btn btn-secondary">
                <i data-lucide="pencil" class="icon-16"></i>
                Edit
            </a>
        </div>
    </div>

    <!-- Stats Dashboard -->
    <div class="dashboard-grid">

        <a href="<?= Url::to(['/branch/sellers', 'id' => $branch->id]) ?>" class="dash-card">
            <div class="dash-icon" style="background: linear-gradient(135deg, #3b82f6, #8b5cf6);">
                <i data-lucide="users" class="icon-20"></i>
            </div>
            <div class="dash-info">
                <div class="dash-value"><?= $sellerCount ?></div>
                <div class="dash-label">Sellers</div>
            </div>
            <i data-lucide="arrow-right" class="dash-arrow"></i>
        </a>

        <a href="<?= Url::to(['/branch/products', 'id' => $branch->id]) ?>" class="dash-card">
            <div class="dash-icon" style="background: linear-gradient(135deg, #22c55e, #10b981);">
                <i data-lucide="package" class="icon-20"></i>
            </div>
            <div class="dash-info">
                <div class="dash-value"><?= $productCount ?></div>
                <div class="dash-label">Products</div>
            </div>
            <i data-lucide="arrow-right" class="dash-arrow"></i>
        </a>

        <a href="<?= Url::to(['/branch/low-stock', 'id' => $branch->id]) ?>" class="dash-card">
            <div class="dash-icon" style="background: linear-gradient(135deg, #ef4444, #f97316);">
                <i data-lucide="alert-triangle" class="icon-20"></i>
            </div>
            <div class="dash-info">
                <div class="dash-value"><?= $lowStockCount ?></div>
                <div class="dash-label">Low Stock</div>
            </div>
            <i data-lucide="arrow-right" class="dash-arrow"></i>
        </a>

        <a href="<?= Url::to(['/branch/stock-value', 'id' => $branch->id]) ?>" class="dash-card">
            <div class="dash-icon" style="background: linear-gradient(135deg, #f59e0b, #eab308);">
                <i data-lucide="warehouse" class="icon-20"></i>
            </div>
            <div class="dash-info">
                <div class="dash-value">TZS <?= number_format($totalStockValue) ?></div>
                <div class="dash-label">Stock Value</div>
            </div>
            <i data-lucide="arrow-right" class="dash-arrow"></i>
        </a>

        <a href="<?= Url::to(['/branch/daily-sales', 'id' => $branch->id]) ?>" class="dash-card">
            <div class="dash-icon" style="background: linear-gradient(135deg, #06b6d4, #3b82f6);">
                <i data-lucide="circle-dollar-sign" class="icon-20"></i>
            </div>
            <div class="dash-info">
                <div class="dash-value">TZS <?= number_format($dailySales ?? 0) ?></div>
                <div class="dash-label">Daily Sales</div>
            </div>
            <i data-lucide="arrow-right" class="dash-arrow"></i>
        </a>

        <a href="<?= Url::to(['/branch/daily-profit', 'id' => $branch->id]) ?>" class="dash-card">
            <div class="dash-icon" style="background: linear-gradient(135deg, #a855f7, #ec4899);">
                <i data-lucide="trending-up" class="icon-20"></i>
            </div>
            <div class="dash-info">
                <div class="dash-value">TZS <?= number_format($dailyProfit ?? 0) ?></div>
                <div class="dash-label">Daily Profit</div>
            </div>
            <i data-lucide="arrow-right" class="dash-arrow"></i>
        </a>

        <a href="<?= Url::to(['/branch/purchases', 'id' => $branch->id]) ?>" class="dash-card">
            <div class="dash-icon" style="background: linear-gradient(135deg, #6366f1, #8b5cf6);">
                <i data-lucide="shopping-cart" class="icon-20"></i>
            </div>
            <div class="dash-info">
                <div class="dash-value"><?= $purchaseCount ?></div>
                <div class="dash-label">Purchases</div>
            </div>
            <i data-lucide="arrow-right" class="dash-arrow"></i>
        </a>

        <a href="<?= Url::to(['/branch/sales', 'id' => $branch->id]) ?>" class="dash-card">
            <div class="dash-icon" style="background: linear-gradient(135deg, #14b8a6, #22c55e);">
                <i data-lucide="receipt" class="icon-20"></i>
            </div>
            <div class="dash-info">
                <div class="dash-value"><?= $salesCount ?></div>
                <div class="dash-label">Sales History</div>
            </div>
            <i data-lucide="arrow-right" class="dash-arrow"></i>
        </a>

    </div>

    <!-- Bottom Section: Sellers & Products Preview -->
    <div class="preview-grid">

        <!-- Sellers Preview -->
        <div class="preview-card">
            <div class="preview-header">
                <h3 class="preview-title">
                    <i data-lucide="users" class="icon-18"></i>
                    Sellers
                </h3>
                <a href="<?= Url::to(['/branch/sellers', 'id' => $branch->id]) ?>" class="preview-link">
                    View all
                    <i data-lucide="arrow-right" class="icon-14"></i>
                </a>
            </div>
            <div class="preview-list">
                <?php foreach (array_slice($sellers ?? [], 0, 5) as $s): ?>
                    <div class="preview-item">
                        <div class="preview-avatar">
                            <?= strtoupper(substr($s->username, 0, 1)) ?>
                        </div>
                        <div class="preview-info">
                            <div class="preview-name"><?= Html::encode($s->username) ?></div>
                            <div class="preview-role">Seller</div>
                        </div>
                        <span class="badge badge-info">Active</span>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($sellers)): ?>
                    <div class="preview-empty">No sellers assigned</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Products Preview -->
        <div class="preview-card">
            <div class="preview-header">
                <h3 class="preview-title">
                    <i data-lucide="package" class="icon-18"></i>
                    Products
                </h3>
                <a href="<?= Url::to(['/branch/products', 'id' => $branch->id]) ?>" class="preview-link">
                    View all
                    <i data-lucide="arrow-right" class="icon-14"></i>
                </a>
            </div>
            <div class="preview-list">
                <?php foreach (array_slice($products ?? [], 0, 5) as $p): ?>
                    <?php $isLow = $p->stock_quantity <= 5; ?>
                    <div class="preview-item">
                        <div class="preview-product-icon">
                            <i data-lucide="box" class="icon-16"></i>
                        </div>
                        <div class="preview-info">
                            <div class="preview-name"><?= Html::encode($p->name) ?></div>
                            <div class="preview-stock">Stock: <?= $p->stock_quantity ?></div>
                        </div>
                        <span class="badge <?= $isLow ? 'badge-danger' : 'badge-success' ?>">
                            <?= $isLow ? 'Low' : 'OK' ?>
                        </span>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($products)): ?>
                    <div class="preview-empty">No products in inventory</div>
                <?php endif; ?>
            </div>
        </div>

    </div>

</div>

<style>
/* ============================================
   HERO SECTION
   ============================================ */
.hero-section {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 24px;
    margin-bottom: 28px;
    padding: 32px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    position: relative;
    overflow: hidden;
    flex-wrap: wrap;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%);
    opacity: 0.6;
    pointer-events: none;
}

.hero-content {
    position: relative;
    z-index: 1;
    flex: 1;
}

.hero-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 20px;
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: var(--success);
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 16px;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--success);
    position: relative;
}

.status-dot.online::after {
    content: '';
    position: absolute;
    inset: -2px;
    border-radius: 50%;
    border: 1px solid var(--success);
    animation: pulse-ring 2s infinite;
}

@keyframes pulse-ring {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(2); opacity: 0; }
}

.hero-title {
    font-size: 32px;
    font-weight: 700;
    color: var(--text);
    margin: 0 0 10px 0;
    letter-spacing: -0.5px;
}

.hero-location {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 14px;
    color: var(--text-muted);
    font-weight: 500;
}

.hero-actions {
    display: flex;
    gap: 10px;
    position: relative;
    z-index: 1;
    flex-shrink: 0;
}

/* ============================================
   DASHBOARD GRID
   ============================================ */
.dashboard-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 16px;
    margin-bottom: 32px;
}

.dash-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 20px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    text-decoration: none;
    color: inherit;
}

.dash-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--border-strong);
}

.dash-card:hover .dash-arrow {
    opacity: 1;
    transform: translateX(0);
}

.dash-icon {
    width: 44px;
    height: 44px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.dash-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.dash-value {
    font-size: 18px;
    font-weight: 700;
    color: var(--text);
    font-family: 'JetBrains Mono', monospace;
}

.dash-label {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
}

.dash-arrow {
    color: var(--text-muted);
    opacity: 0;
    transform: translateX(-4px);
    transition: all 0.2s ease;
}

/* ============================================
   PREVIEW SECTION
   ============================================ */
.preview-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}

.preview-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    overflow: hidden;
}

.preview-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border);
}

.preview-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
    margin: 0;
}

.preview-link {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 12px;
    font-weight: 600;
    color: var(--primary);
    transition: gap 0.2s ease;
}

.preview-link:hover {
    gap: 8px;
}

.preview-list {
    padding: 8px;
}

.preview-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: var(--radius);
    transition: all 0.15s ease;
}

.preview-item:hover {
    background: var(--surface-hover);
}

.preview-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    color: white;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    flex-shrink: 0;
}

.preview-product-icon {
    width: 36px;
    height: 36px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--bg-elevated);
    color: var(--text-muted);
    flex-shrink: 0;
}

.preview-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.preview-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
}

.preview-role,
.preview-stock {
    font-size: 12px;
    color: var(--text-muted);
}

.preview-empty {
    padding: 32px;
    text-align: center;
    color: var(--text-muted);
    font-size: 13px;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 992px) {
    .preview-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 768px) {
    .hero-section {
        padding: 20px;
    }
    .hero-title {
        font-size: 24px;
    }
    .dashboard-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .dash-arrow {
        display: none;
    }
}

@media (max-width: 480px) {
    .dashboard-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>