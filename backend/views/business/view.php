<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\StockMovement;
use common\models\Product;
use common\models\Sale;

/**
 * @var \common\models\Business $business
 * @var \common\models\Branch[] $branches
 */

$this->title = $business->name;

$totalBranches = count($branches);

// === HESABU STOCK VALUE KUTOKA STOCK MOVEMENT (sawa na branch/stock-value) ===
$totalStockValue = 0;
$totalStockItems = 0;

// === HESABU SALES & PROFIT KUTOKA SALE TABLE ===
$totalSales = 0;
$totalProfit = 0;
$totalSalesCount = 0;

// === HESABU SELLERS & PRODUCTS ===
$totalSellers = 0;
$totalProducts = 0;
$totalLowStock = 0;

// Branch-level stats
$branchStats = [];

foreach ($branches as $branch) {
    $branchId = $branch->id;
    
    // --- SELLERS ---
    $sellers = $branch->sellers ?? [];
    $sellerCount = count($sellers);
    $totalSellers += $sellerCount;
    
    // --- PRODUCTS ---
    $products = $branch->products ?? [];
    $productCount = count($products);
    $totalProducts += $productCount;
    
    // --- STOCK VALUE (kutoka Stock Movement - REALTIME) ---
    $branchStockValue = 0;
    $branchStockItems = 0;
    $lowStockCount = 0;
    
    foreach ($products as $product) {
        $in = (int) StockMovement::find()
            ->where(['product_id' => $product->id, 'type' => 'IN'])
            ->sum('quantity') ?? 0;

        $out = (int) StockMovement::find()
            ->where(['product_id' => $product->id, 'type' => 'OUT'])
            ->sum('quantity') ?? 0;

        $currentStock = $in - $out;
        $productValue = $currentStock * $product->selling_price;
        $branchStockValue += $productValue;
        $branchStockItems += $currentStock;
        
        // Low stock check
        if ($currentStock <= ($product->min_stock_alert ?? 5)) {
            $lowStockCount++;
        }
    }
    
    $totalStockValue += $branchStockValue;
    $totalStockItems += $branchStockItems;
    $totalLowStock += $lowStockCount;
    
    // --- SALES & PROFIT (kutoka Sale table) ---
    $branchSales = (float) Sale::find()
        ->where(['branch_id' => $branchId])
        ->andWhere(['status' => 'completed'])
        ->sum(new \yii\db\Expression('COALESCE(total_amount, 0)')) ?? 0;
    
    $branchProfit = (float) Sale::find()
        ->where(['branch_id' => $branchId])
        ->andWhere(['status' => 'completed'])
        ->sum(new \yii\db\Expression('COALESCE(total_profit, 0)')) ?? 0;
    
    $branchSalesCount = (int) Sale::find()
        ->where(['branch_id' => $branchId])
        ->andWhere(['status' => 'completed'])
        ->count();
    
    $totalSales += $branchSales;
    $totalProfit += $branchProfit;
    $totalSalesCount += $branchSalesCount;
    
    // Hifadhi stats za branch
    $branchStats[$branchId] = [
        'sellers' => $sellerCount,
        'products' => $productCount,
        'stockValue' => $branchStockValue,
        'stockItems' => $branchStockItems,
        'lowStock' => $lowStockCount,
        'sales' => $branchSales,
        'profit' => $branchProfit,
        'salesCount' => $branchSalesCount,
    ];
}
?>

<div class="business-view-page">
    <!-- Ambient Background -->
    <div class="ambient-bg">
        <div class="ambient-orb orb-1"></div>
        <div class="ambient-orb orb-2"></div>
        <div class="ambient-orb orb-3"></div>
    </div>

    <div class="page-wrapper">

        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="<?= Url::to(['business/index']) ?>">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                Businesses
            </a>
            <svg class="breadcrumb-separator" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <span class="breadcrumb-current"><?= Html::encode($business->name) ?></span>
        </nav>

        <!-- Hero Section -->
        <div class="hero-section">
            <div class="hero-content">
                <div class="hero-badge">
                    <span class="status-dot online"></span>
                    Active Business
                </div>
                <h1 class="hero-title"><?= Html::encode($business->name) ?></h1>
                <p class="hero-desc"><?= Html::encode($business->description) ?></p>
                <div class="hero-meta">
                    <span class="meta-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Created <?= date('M d, Y', strtotime($business->created_at ?? 'now')) ?>
                    </span>
                    <span class="meta-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        <?= $totalBranches ?> Branch<?= $totalBranches !== 1 ? 'es' : '' ?>
                    </span>
                    <span class="meta-item">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <?= number_format($totalStockItems) ?> Items in Stock
                    </span>
                </div>
            </div>
            <div class="hero-actions">
                <a href="<?= Url::to(['business/update', 'id' => $business->id]) ?>" class="btn btn-secondary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Edit
                </a>
                <a href="<?= Url::to(['/branch/create', 'business_id' => $business->id]) ?>" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Add Branch
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <!-- Branches -->
            <div class="stat-card-lg">
                <div class="stat-header">
                    <span class="stat-title">Branches</span>
                    <div class="stat-icon-sm blue">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="6" y1="3" x2="6" y2="15"></line>
                            <circle cx="18" cy="6" r="3"></circle>
                            <circle cx="6" cy="18" r="3"></circle>
                            <path d="M18 9a9 9 0 0 1-9 9"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number"><?= number_format($totalBranches) ?></div>
                <div class="stat-trend">Active locations</div>
            </div>

            <!-- Sellers -->
            <div class="stat-card-lg">
                <div class="stat-header">
                    <span class="stat-title">Sellers</span>
                    <div class="stat-icon-sm emerald">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number"><?= number_format($totalSellers) ?></div>
                <div class="stat-trend">Team members</div>
            </div>

            <!-- Products -->
            <div class="stat-card-lg">
                <div class="stat-header">
                    <span class="stat-title">Products</span>
                    <div class="stat-icon-sm amber">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                </div>
                <div class="stat-number"><?= number_format($totalProducts) ?></div>
                <div class="stat-trend">In inventory</div>
            </div>

            <!-- Sales -->
            <div class="stat-card-lg">
                <div class="stat-header">
                    <span class="stat-title">Sales</span>
                    <div class="stat-icon-sm purple">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number">TZS <?= number_format($totalSales) ?></div>
                <div class="stat-trend">Total revenue</div>
            </div>

            <!-- Profit -->
            <div class="stat-card-lg">
                <div class="stat-header">
                    <span class="stat-title">Profit</span>
                    <div class="stat-icon-sm emerald">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline>
                        </svg>
                    </div>
                </div>
                <div class="stat-number">TZS <?= number_format($totalProfit) ?></div>
                <div class="stat-trend">Net earnings</div>
            </div>

            <!-- Stock Value (REALTIME kutoka Stock Movement) -->
            <div class="stat-card-lg highlight-stock">
                <div class="stat-header">
                    <span class="stat-title">Stock Value</span>
                    <div class="stat-icon-sm rose">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </div>
                </div>
                <div class="stat-number">TZS <?= number_format($totalStockValue) ?></div>
                <div class="stat-trend"><?= number_format($totalStockItems) ?> items in stock</div>
            </div>
        </div>

        <!-- Branches Section -->
        <div class="section-block">
            <div class="section-header">
                <div>
                    <h2 class="section-title">Branches</h2>
                    <p class="section-subtitle">Manage your business locations</p>
                </div>
                <a href="<?= Url::to(['/branch/create', 'business_id' => $business->id]) ?>" class="btn btn-primary">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    New Branch
                </a>
            </div>

            <div class="branches-grid">

                <?php foreach ($branches as $branch): ?>
                    <?php $stats = $branchStats[$branch->id] ?? []; ?>

                    <div class="branch-card">
                        <div class="branch-header">
                            <div class="branch-icon">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                            </div>
                            <div class="branch-menu">
                                <a href="<?= Url::to(['/branch/update', 'id' => $branch->id]) ?>" class="menu-btn" title="Edit">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                    </svg>
                                </a>
                                <a href="<?= Url::to(['/branch/delete', 'id' => $branch->id]) ?>" 
                                   class="menu-btn danger" 
                                   title="Delete"
                                   onclick="return confirm('Delete this branch?')">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="branch-body">
                            <h3 class="branch-name"><?= Html::encode($branch->name) ?></h3>
                            <div class="branch-location">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                    <circle cx="12" cy="10" r="3"></circle>
                                </svg>
                                <?= Html::encode($branch->location ?: 'No location set') ?>
                            </div>
                        </div>

                        <!-- Branch Stock & Sales Mini Stats -->
                        <div class="branch-mini-stats">
                            <div class="mini-stat">
                                <span class="mini-stat-label">Stock Value</span>
                                <span class="mini-stat-value">TZS <?= number_format($stats['stockValue'] ?? 0) ?></span>
                            </div>
                            <div class="mini-stat">
                                <span class="mini-stat-label">Stock Items</span>
                                <span class="mini-stat-value"><?= number_format($stats['stockItems'] ?? 0) ?></span>
                            </div>
                        </div>

                        <div class="branch-metrics">
                            <div class="metric">
                                <span class="metric-value"><?= $stats['sellers'] ?? 0 ?></span>
                                <span class="metric-label">Sellers</span>
                            </div>
                            <div class="metric">
                                <span class="metric-value"><?= $stats['products'] ?? 0 ?></span>
                                <span class="metric-label">Products</span>
                            </div>
                            <div class="metric">
                                <span class="metric-value" style="color: #ef4444;"><?= $stats['lowStock'] ?? 0 ?></span>
                                <span class="metric-label">Low Stock</span>
                            </div>
                        </div>

                        <!-- Branch Sales Summary -->
                        <div class="branch-sales-summary">
                            <div class="sales-row">
                                <span class="sales-label">Sales</span>
                                <span class="sales-value">TZS <?= number_format($stats['sales'] ?? 0) ?></span>
                            </div>
                            <div class="sales-row">
                                <span class="sales-label">Profit</span>
                                <span class="sales-value profit">TZS <?= number_format($stats['profit'] ?? 0) ?></span>
                            </div>
                        </div>

                        <a href="<?= Url::to(['/branch/view', 'id' => $branch->id]) ?>" class="branch-link">
                            View Branch
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 14 20 9 15 4"></polyline>
                                <path d="M4 20v-7a4 4 0 0 1 4-4h12"></path>
                            </svg>
                        </a>
                    </div>

                <?php endforeach; ?>

                <?php if (empty($branches)): ?>
                    <div class="empty-state">
                        <div class="empty-illustration">
                            <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                        <h3>No branches yet</h3>
                        <p>Add your first branch to this business</p>
                        <a href="<?= Url::to(['/branch/create', 'business_id' => $business->id]) ?>" class="btn btn-primary">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            Add Branch
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>

<style>
/* ============================================
   CSS VARIABLES - THEME SYSTEM
   ============================================ */
:root {
    --bg-primary: #ffffff;
    --bg-secondary: #f8fafc;
    --bg-tertiary: #f1f5f9;
    --bg-card: rgba(255, 255, 255, 0.85);
    --bg-card-solid: #ffffff;
    --bg-hover: rgba(241, 245, 249, 0.6);
    --bg-elevated: #f8fafc;
    
    --text-primary: #0f172a;
    --text-secondary: #475569;
    --text-tertiary: #94a3b8;
    --text-muted: #64748b;
    
    --border-subtle: rgba(226, 232, 240, 0.8);
    --border-card: rgba(226, 232, 240, 0.6);
    --border-divider: rgba(241, 245, 249, 0.8);
    --border-strong: rgba(203, 213, 225, 0.8);
    
    --accent-blue: #3b82f6;
    --accent-blue-light: #dbeafe;
    --accent-purple: #8b5cf6;
    --accent-purple-light: #ede9fe;
    --accent-emerald: #10b981;
    --accent-emerald-light: #d1fae5;
    --accent-amber: #f59e0b;
    --accent-amber-light: #fef3c7;
    --accent-rose: #f43f5e;
    --accent-rose-light: #ffe4e6;
    --accent-success: #22c55e;
    
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    
    --radius-sm: 6px;
    --radius: 10px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
    --radius-full: 9999px;
    
    --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
    --transition-base: 250ms cubic-bezier(0.4, 0, 0.2, 1);
}

body.dark,
[data-theme="dark"] {
    --bg-primary: #0f172a;
    --bg-secondary: #1e293b;
    --bg-tertiary: #334155;
    --bg-card: rgba(30, 41, 59, 0.7);
    --bg-card-solid: #1e293b;
    --bg-hover: rgba(51, 65, 85, 0.4);
    --bg-elevated: rgba(30, 41, 59, 0.9);
    
    --text-primary: #f8fafc;
    --text-secondary: #cbd5e1;
    --text-tertiary: #94a3b8;
    --text-muted: #64748b;
    
    --border-subtle: rgba(51, 65, 85, 0.6);
    --border-card: rgba(51, 65, 85, 0.5);
    --border-divider: rgba(51, 65, 85, 0.4);
    --border-strong: rgba(71, 85, 105, 0.8);
    
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -2px rgba(0, 0, 0, 0.2);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -4px rgba(0, 0, 0, 0.2);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3);
}

/* ============================================
   BASE LAYOUT
   ============================================ */
.business-view-page {
    position: relative;
    min-height: 100vh;
    padding: 24px;
    background: var(--bg-primary);
    color: var(--text-primary);
    transition: background-color var(--transition-base), color var(--transition-base);
}

@media (min-width: 768px) {
    .business-view-page {
        padding: 32px;
    }
}

@media (min-width: 1024px) {
    .business-view-page {
        padding: 40px;
    }
}

/* ============================================
   AMBIENT BACKGROUND
   ============================================ */
.ambient-bg {
    position: fixed;
    inset: 0;
    z-index: 0;
    overflow: hidden;
    pointer-events: none;
}

.ambient-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(120px);
    opacity: 0.1;
    animation: float 20s ease-in-out infinite;
}

body.dark .ambient-orb,
[data-theme="dark"] .ambient-orb {
    opacity: 0.05;
}

.orb-1 {
    width: 400px;
    height: 400px;
    background: var(--accent-blue);
    top: -150px;
    left: -100px;
    animation-delay: 0s;
}

.orb-2 {
    width: 350px;
    height: 350px;
    background: var(--accent-purple);
    top: 30%;
    right: -120px;
    animation-delay: -7s;
}

.orb-3 {
    width: 300px;
    height: 300px;
    background: var(--accent-emerald);
    bottom: -100px;
    left: 20%;
    animation-delay: -14s;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -30px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}

/* ============================================
   PAGE WRAPPER
   ============================================ */
.page-wrapper {
    position: relative;
    z-index: 1;
    max-width: 1200px;
    margin: 0 auto;
}

/* ============================================
   BREADCRUMB
   ============================================ */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-tertiary);
    margin-bottom: 24px;
}

.breadcrumb a {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--text-muted);
    text-decoration: none;
    transition: color var(--transition-fast);
}

.breadcrumb a:hover {
    color: var(--accent-blue);
}

.breadcrumb a svg {
    opacity: 0.7;
}

.breadcrumb-separator {
    color: var(--text-tertiary);
    opacity: 0.5;
}

.breadcrumb-current {
    color: var(--text-primary);
    font-weight: 500;
}

/* ============================================
   BUTTONS
   ============================================ */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    cursor: pointer;
    transition: all var(--transition-fast);
    border: none;
    font-family: inherit;
    white-space: nowrap;
}

.btn-primary {
    background: linear-gradient(135deg, var(--accent-blue), #6366f1);
    color: white;
    box-shadow: 0 4px 14px rgba(59, 130, 246, 0.35);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.45);
}

.btn-secondary {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border-subtle);
}

.btn-secondary:hover {
    background: var(--bg-hover);
    border-color: var(--text-tertiary);
    color: var(--text-primary);
}

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
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-xl);
    position: relative;
    overflow: hidden;
    flex-wrap: wrap;
    box-shadow: var(--shadow-lg);
}

.hero-section::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.15) 0%, transparent 70%);
    opacity: 0.6;
    pointer-events: none;
}

body.dark .hero-section::before,
[data-theme="dark"] .hero-section::before {
    background: radial-gradient(circle, rgba(59, 130, 246, 0.08) 0%, transparent 70%);
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
    border-radius: var(--radius-full);
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: var(--accent-success);
    font-size: 12px;
    font-weight: 600;
    margin-bottom: 16px;
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--accent-success);
    position: relative;
}

.status-dot.online::after {
    content: '';
    position: absolute;
    inset: -2px;
    border-radius: 50%;
    border: 1px solid var(--accent-success);
    animation: pulse-ring 2s infinite;
}

@keyframes pulse-ring {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(2); opacity: 0; }
}

.hero-title {
    font-size: 32px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 10px 0;
    letter-spacing: -0.5px;
}

.hero-desc {
    font-size: 15px;
    color: var(--text-muted);
    margin: 0 0 16px 0;
    line-height: 1.6;
    max-width: 600px;
}

.hero-meta {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: var(--text-secondary);
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
   STATS GRID
   ============================================ */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
    margin-bottom: 32px;
}

@media (min-width: 640px) {
    .stats-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (min-width: 1024px) {
    .stats-grid {
        grid-template-columns: repeat(6, 1fr);
    }
}

.stat-card-lg {
    padding: 20px;
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-lg);
    transition: all var(--transition-base);
    box-shadow: var(--shadow-sm);
}

.stat-card-lg:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    border-color: var(--border-strong);
}

.stat-card-lg.highlight-stock {
    border-color: rgba(244, 63, 94, 0.3);
    background: linear-gradient(135deg, var(--bg-card), rgba(244, 63, 94, 0.05));
}

.stat-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 12px;
}

.stat-title {
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-icon-sm {
    width: 32px;
    height: 32px;
    border-radius: var(--radius-sm);
    display: flex;
    align-items: center;
    justify-content: center;
}

.stat-icon-sm.blue {
    background: var(--accent-blue-light);
    color: var(--accent-blue);
}

body.dark .stat-icon-sm.blue,
[data-theme="dark"] .stat-icon-sm.blue {
    background: rgba(59, 130, 246, 0.15);
}

.stat-icon-sm.emerald {
    background: var(--accent-emerald-light);
    color: var(--accent-emerald);
}

body.dark .stat-icon-sm.emerald,
[data-theme="dark"] .stat-icon-sm.emerald {
    background: rgba(16, 185, 129, 0.15);
}

.stat-icon-sm.amber {
    background: var(--accent-amber-light);
    color: var(--accent-amber);
}

body.dark .stat-icon-sm.amber,
[data-theme="dark"] .stat-icon-sm.amber {
    background: rgba(245, 158, 11, 0.15);
}

.stat-icon-sm.purple {
    background: var(--accent-purple-light);
    color: var(--accent-purple);
}

body.dark .stat-icon-sm.purple,
[data-theme="dark"] .stat-icon-sm.purple {
    background: rgba(139, 92, 246, 0.15);
}

.stat-icon-sm.rose {
    background: var(--accent-rose-light);
    color: var(--accent-rose);
}

body.dark .stat-icon-sm.rose,
[data-theme="dark"] .stat-icon-sm.rose {
    background: rgba(244, 63, 94, 0.15);
}

.stat-number {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
    letter-spacing: -0.02em;
}

@media (min-width: 768px) {
    .stat-number {
        font-size: 20px;
    }
}

.stat-trend {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
}

/* ============================================
   SECTION BLOCK
   ============================================ */
.section-block {
    margin-top: 32px;
}

.section-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 24px;
    gap: 16px;
    flex-wrap: wrap;
}

.section-title {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 4px 0;
}

.section-subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
}

/* ============================================
   BRANCHES GRID
   ============================================ */
.branches-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 20px;
}

@media (min-width: 640px) {
    .branches-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .branches-grid {
        grid-template-columns: repeat(3, 1fr);
    }
}

/* ============================================
   BRANCH CARD
   ============================================ */
.branch-card {
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-lg);
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    transition: all var(--transition-base);
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-sm);
}

.branch-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
    border-color: var(--border-strong);
}

.branch-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}

.branch-icon {
    width: 44px;
    height: 44px;
    border-radius: var(--radius-md);
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.branch-menu {
    display: flex;
    gap: 6px;
    opacity: 0;
    transform: translateY(-4px);
    transition: all var(--transition-fast);
}

.branch-card:hover .branch-menu {
    opacity: 1;
    transform: translateY(0);
}

.menu-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-sm);
    background: var(--bg-elevated);
    border: 1px solid var(--border-subtle);
    color: var(--text-secondary);
    transition: all var(--transition-fast);
}

.menu-btn:hover {
    background: var(--bg-hover);
    color: var(--text-primary);
}

.menu-btn.danger:hover {
    background: rgba(239, 68, 68, 0.15);
    color: #ef4444;
    border-color: rgba(239, 68, 68, 0.3);
}

.branch-body {
    flex: 1;
}

.branch-name {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0 0 8px 0;
}

.branch-location {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: var(--text-muted);
}

.branch-location svg {
    opacity: 0.7;
}

/* Branch Mini Stats */
.branch-mini-stats {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
    padding: 12px;
    background: var(--bg-elevated);
    border-radius: var(--radius-sm);
    border: 1px solid var(--border-subtle);
}

.mini-stat {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.mini-stat-label {
    font-size: 10px;
    font-weight: 600;
    color: var(--text-tertiary);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.mini-stat-value {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary);
}

/* Branch Metrics */
.branch-metrics {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    padding: 16px;
    background: var(--bg-elevated);
    border-radius: var(--radius-md);
    border: 1px solid var(--border-subtle);
}

.metric {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
    text-align: center;
}

.metric-value {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.02em;
}

.metric-label {
    font-size: 11px;
    color: var(--text-muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

/* Branch Sales Summary */
.branch-sales-summary {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 12px;
    background: var(--bg-elevated);
    border-radius: var(--radius-sm);
    border: 1px solid var(--border-subtle);
}

.sales-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.sales-label {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
}

.sales-value {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-primary);
}

.sales-value.profit {
    color: var(--accent-emerald);
}

/* Branch Link */
.branch-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px;
    border-radius: var(--radius-md);
    background: var(--bg-elevated);
    border: 1px solid var(--border-subtle);
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: all var(--transition-fast);
}

.branch-link:hover {
    background: var(--accent-blue);
    color: white;
    border-color: var(--accent-blue);
    gap: 10px;
}

.branch-link svg {
    transition: transform var(--transition-fast);
}

.branch-link:hover svg {
    transform: translate(2px, -2px);
}

/* ============================================
   EMPTY STATE
   ============================================ */
.empty-state {
    grid-column: 1 / -1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 60px 24px;
    text-align: center;
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-lg);
    box-shadow: var(--shadow-sm);
}

.empty-illustration {
    width: 80px;
    height: 80px;
    border-radius: var(--radius-full);
    background: var(--bg-tertiary);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    color: var(--text-tertiary);
}

.empty-state h3 {
    font-size: 18px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 14px;
    color: var(--text-secondary);
    margin: 0 0 20px 0;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .hero-section {
        padding: 24px;
    }
    .hero-title {
        font-size: 24px;
    }
    .hero-actions {
        width: 100%;
    }
    .branch-menu {
        opacity: 1;
        transform: none;
    }
    .branch-mini-stats {
        grid-template-columns: 1fr;
    }
}
</style>