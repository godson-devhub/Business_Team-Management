<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Seller Dashboard';

$user = Yii::$app->user->identity;
$username = $user->username ?? 'Seller';

// Get seller's branch
$branch = $user->branch ?? null;

// === HESABU STOCK VALUE KUTOKA KWENYE PRODUCTS (sawa na product/index) ===
$products = $branch ? ($branch->products ?? []) : [];
$totalProducts = count($products);
$totalStockQuantity = 0;
$totalStockValue = 0;  // This will match product/index inventory value
$lowStock = 0;

foreach ($products as $p) {
    $qty = (int)($p->stock_quantity ?? 0);
    $sellPrice = (float)($p->selling_price ?? 0);
    
    $totalStockQuantity += $qty;
    $totalStockValue += ($qty * $sellPrice);  // Same calculation as product/index
    
    if ($qty <= ($p->min_stock_alert ?? 5)) {
        $lowStock++;
    }
}

// SAFE DEFAULTS for other variables
$todaySales = $todaySales ?? 0;
$todayProfit = $todayProfit ?? 0;

$hour = (int) date('H');
$greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
?>

<div class="seller-page">
    <!-- Ambient Background -->
    <div class="ambient-bg">
        <div class="ambient-orb orb-1"></div>
        <div class="ambient-orb orb-2"></div>
        <div class="ambient-orb orb-3"></div>
    </div>

    <div class="page-wrapper">

        <!-- ═══════════════════════════════════════
             HERO WELCOME
        ═══════════════════════════════════════ -->
        <section class="seller-hero" data-reveal>
            <div class="seller-hero__content">
                <div class="seller-hero__left">
                    <div class="seller-hero__badge">
                        <span class="pulse-dot"></span>
                        Seller Panel
                    </div>
                    <h1 class="seller-hero__title">
                        <?= $greeting ?>,
                        <span class="gradient-text"><?= Html::encode($username) ?></span>
                    </h1>
                    <p class="seller-hero__subtitle">
                        Manage inventory, track sales, and monitor stock levels in real-time.
                    </p>
                    <?php if ($branch): ?>
                    <div class="branch-info">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                        <?= Html::encode($branch->name) ?> — <?= Html::encode($branch->location ?? 'No location') ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="seller-hero__right">
                    <div class="seller-hero__status">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <span>Active Account</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════
             BENTO STATS GRID
        ═══════════════════════════════════════ -->
        <section class="bento-grid">
            <!-- Today's Sales -->
            <div class="bento-card bento-card--blue" data-reveal>
                <div class="bento-card__glow"></div>
                <div class="bento-card__top">
                    <div class="bento-icon blue">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                            <circle cx="12" cy="12" r="2"></circle>
                            <path d="M6 12h.01M18 12h.01"></path>
                        </svg>
                    </div>
                    <div class="bento-trend blue">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline>
                        </svg>
                        Today
                    </div>
                </div>
                <div class="bento-card__body">
                    <div class="bento-value" data-target="<?= (int)$todaySales ?>" data-prefix="TZS ">0</div>
                    <div class="bento-label">Today's Sales</div>
                </div>
                <div class="bento-sparkline">
                    <svg viewBox="0 0 120 40" preserveAspectRatio="none">
                        <path d="M0,35 Q20,30 40,25 T80,20 T120,15" fill="none" stroke="currentColor" stroke-width="2" opacity="0.4"/>
                        <path d="M0,35 Q20,30 40,25 T80,20 T120,15 L120,40 L0,40 Z" fill="currentColor" opacity="0.08"/>
                    </svg>
                </div>
            </div>

            <!-- Today's Profit -->
            <div class="bento-card bento-card--emerald" data-reveal>
                <div class="bento-card__glow"></div>
                <div class="bento-card__top">
                    <div class="bento-icon emerald">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline>
                        </svg>
                    </div>
                    <div class="bento-trend emerald">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 14 20 9 15 4"></polyline>
                            <path d="M4 20v-7a4 4 0 0 1 4-4h12"></path>
                        </svg>
                        +8.2%
                    </div>
                </div>
                <div class="bento-card__body">
                    <div class="bento-value" data-target="<?= (int)$todayProfit ?>" data-prefix="TZS ">0</div>
                    <div class="bento-label">Today's Profit</div>
                </div>
                <div class="bento-sparkline">
                    <svg viewBox="0 0 120 40" preserveAspectRatio="none">
                        <path d="M0,30 Q30,28 60,22 T120,12" fill="none" stroke="currentColor" stroke-width="2" opacity="0.4"/>
                        <path d="M0,30 Q30,28 60,22 T120,12 L120,40 L0,40 Z" fill="currentColor" opacity="0.08"/>
                    </svg>
                </div>
            </div>

            <!-- Total Products -->
            <div class="bento-card bento-card--violet" data-reveal>
                <div class="bento-card__glow"></div>
                <div class="bento-card__top">
                    <div class="bento-icon violet">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <div class="bento-trend violet">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
                            <polyline points="2 17 12 22 22 17"></polyline>
                            <polyline points="2 12 12 17 22 12"></polyline>
                        </svg>
                        Stock
                    </div>
                </div>
                <div class="bento-card__body">
                    <div class="bento-value" data-target="<?= (int)$totalProducts ?>">0</div>
                    <div class="bento-label">Total Products</div>
                </div>
                <div class="bento-sparkline">
                    <svg viewBox="0 0 120 40" preserveAspectRatio="none">
                        <path d="M0,32 Q40,28 80,24 T120,20" fill="none" stroke="currentColor" stroke-width="2" opacity="0.4"/>
                        <path d="M0,32 Q40,28 80,24 T120,20 L120,40 L0,40 Z" fill="currentColor" opacity="0.08"/>
                    </svg>
                </div>
            </div>

            <!-- Low Stock -->
            <div class="bento-card bento-card--red" data-reveal>
                <div class="bento-card__glow"></div>
                <div class="bento-card__top">
                    <div class="bento-icon red">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                            <line x1="12" y1="9" x2="12" y2="13"></line>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                    </div>
                    <div class="bento-trend red">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="12"></line>
                            <line x1="12" y1="16" x2="12.01" y2="16"></line>
                        </svg>
                        Alert
                    </div>
                </div>
                <div class="bento-card__body">
                    <div class="bento-value" data-target="<?= (int)$lowStock ?>">0</div>
                    <div class="bento-label">Low Stock Items</div>
                </div>
                <div class="bento-sparkline">
                    <svg viewBox="0 0 120 40" preserveAspectRatio="none">
                        <path d="M0,20 Q30,15 60,18 T120,25" fill="none" stroke="currentColor" stroke-width="2" opacity="0.4"/>
                        <path d="M0,20 Q30,15 60,18 T120,25 L120,40 L0,40 Z" fill="currentColor" opacity="0.08"/>
                    </svg>
                </div>
            </div>

            <!-- Stock Quantity -->
            <div class="bento-card bento-card--amber" data-reveal>
                <div class="bento-card__glow"></div>
                <div class="bento-card__top">
                    <div class="bento-icon amber">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                            <polyline points="9 22 9 12 15 12 15 22"></polyline>
                        </svg>
                    </div>
                    <div class="bento-trend amber">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        Qty
                    </div>
                </div>
                <div class="bento-card__body">
                    <div class="bento-value" data-target="<?= (int)$totalStockQuantity ?>">0</div>
                    <div class="bento-label">Stock Quantity</div>
                </div>
                <div class="bento-sparkline">
                    <svg viewBox="0 0 120 40" preserveAspectRatio="none">
                        <path d="M0,28 Q20,26 40,24 T80,20 T120,16" fill="none" stroke="currentColor" stroke-width="2" opacity="0.4"/>
                        <path d="M0,28 Q20,26 40,24 T80,20 T120,16 L120,40 L0,40 Z" fill="currentColor" opacity="0.08"/>
                    </svg>
                </div>
            </div>

            <!-- Stock Value — SAME AS product/index Inventory Value -->
            <div class="bento-card bento-card--gold" data-reveal>
                <div class="bento-card__glow"></div>
                <div class="bento-card__top">
                    <div class="bento-icon gold">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                    <div class="bento-trend gold">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                            <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
                        </svg>
                        Value
                    </div>
                </div>
                <div class="bento-card__body">
                    <div class="bento-value" data-target="<?= (int)$totalStockValue ?>" data-prefix="TZS ">0</div>
                    <div class="bento-label">Inventory Value</div>
                </div>
                <div class="bento-sparkline">
                    <svg viewBox="0 0 120 40" preserveAspectRatio="none">
                        <path d="M0,30 Q25,28 50,22 T100,18 T120,14" fill="none" stroke="currentColor" stroke-width="2" opacity="0.4"/>
                        <path d="M0,30 Q25,28 50,22 T100,18 T120,14 L120,40 L0,40 Z" fill="currentColor" opacity="0.08"/>
                    </svg>
                </div>
            </div>
        </section>

        <!-- ═══════════════════════════════════════
             QUICK ACTIONS
        ═══════════════════════════════════════ -->
        <section class="glass-panel panel--wide" data-reveal>
            <div class="panel__header">
                <div>
                    <h3 class="panel__title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                        </svg>
                        Quick Actions
                    </h3>
                    <p class="panel__subtitle">Fast access to daily operations</p>
                </div>
            </div>
            <div class="action-bento">
                <a href="<?= Url::to(['/product/index']) ?>" class="action-tile action-tile--blue">
                    <div class="action-tile__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <span class="action-tile__label">Products</span>
                    <span class="action-tile__desc">View inventory</span>
                </a>
                <a href="<?= Url::to(['/product/create']) ?>" class="action-tile action-tile--emerald">
                    <div class="action-tile__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                    </div>
                    <span class="action-tile__label">Add Product</span>
                    <span class="action-tile__desc">New item</span>
                </a>
                <a href="<?= Url::to(['/sale/create']) ?>" class="action-tile action-tile--violet">
                    <div class="action-tile__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                            <circle cx="12" cy="12" r="2"></circle>
                            <path d="M6 12h.01M18 12h.01"></path>
                        </svg>
                    </div>
                    <span class="action-tile__label">New Sale</span>
                    <span class="action-tile__desc">Record sale</span>
                </a>
                <a href="<?= Url::to(['/sale/index']) ?>" class="action-tile action-tile--amber">
                    <div class="action-tile__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                    </div>
                    <span class="action-tile__label">Sales History</span>
                    <span class="action-tile__desc">View records</span>
                </a>
                <a href="<?= Url::to(['/purchase/create']) ?>" class="action-tile action-tile--teal">
                    <div class="action-tile__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                    </div>
                    <span class="action-tile__label">Purchase</span>
                    <span class="action-tile__desc">Buy stock</span>
                </a>
                <a href="<?= Url::to(['/purchase/index']) ?>" class="action-tile action-tile--rose">
                    <div class="action-tile__icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 11l3 3L22 4"></path>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                    </div>
                    <span class="action-tile__label">Purchases</span>
                    <span class="action-tile__desc">History</span>
                </a>
            </div>
        </section>

        <!-- ═══════════════════════════════════════
             RECENT PRODUCTS TABLE
        ═══════════════════════════════════════ -->
        <section class="glass-panel panel--wide" data-reveal>
            <div class="panel__header">
                <div>
                    <h3 class="panel__title">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8.5 14.5A2.5 2.5 0 0 0 11 12c0-1.38-.5-2-1-3-1.072-2.143-.224-5.413 2.56-7.91 1.526-1.384 3.736-2.24 5.94-2.24 2.208 0 4.414.856 5.94 2.24 2.784 2.497 3.632 5.767 2.56 7.91-.5 1-1 1.62-1 3a2.5 2.5 0 0 0 2.5 2.5"></path>
                            <path d="M12 15.5V22"></path>
                            <path d="M7 18h10"></path>
                        </svg>
                        Recent Products
                    </h3>
                    <p class="panel__subtitle">Latest inventory updates</p>
                </div>
                <a href="<?= Url::to(['/product/index']) ?>" class="panel__link">
                    View all
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 14 20 9 15 4"></polyline>
                        <path d="M4 20v-7a4 4 0 0 1 4-4h12"></path>
                    </svg>
                </a>
            </div>

            <?php if (!empty($recentProducts)): ?>
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th class="text-right">Buy Price</th>
                                <th class="text-right">Sell Price</th>
                                <th class="text-center">Stock</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recentProducts as $product): ?>
                                <?php
                                    $name = Html::encode($product->name ?? '');
                                    $buyPrice = (float)($product->buying_price ?? 0);
                                    $sellPrice = (float)($product->selling_price ?? 0);
                                    $stock = (int)($product->stock_quantity ?? 0);
                                    $minStock = (int)($product->min_stock_alert ?? 5);
                                    $isLow = $stock <= $minStock;
                                ?>
                                <tr>
                                    <td>
                                        <div class="product-cell">
                                            <div class="product-icon">
                                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                                                </svg>
                                            </div>
                                            <span class="product-name"><?= $name ?></span>
                                        </div>
                                    </td>
                                    <td class="text-right mono">TZS <?= number_format($buyPrice) ?></td>
                                    <td class="text-right mono">TZS <?= number_format($sellPrice) ?></td>
                                    <td class="text-center">
                                        <span class="badge <?= $isLow ? 'badge-danger' : 'badge-success' ?>">
                                            <?= $stock ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($isLow): ?>
                                            <span class="status-pill status--danger">Low Stock</span>
                                        <?php else: ?>
                                            <span class="status-pill status--success">In Stock</span>
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
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                    </div>
                    <h3>No products yet</h3>
                    <p>Start by adding your first product to inventory</p>
                    <a href="<?= Url::to(['/product/create']) ?>" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Add Product
                    </a>
                </div>
            <?php endif; ?>
        </section>

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
    --accent-emerald: #10b981;
    --accent-emerald-light: #d1fae5;
    --accent-purple: #8b5cf6;
    --accent-purple-light: #ede9fe;
    --accent-amber: #f59e0b;
    --accent-amber-light: #fef3c7;
    --accent-rose: #f43f5e;
    --accent-rose-light: #ffe4e6;
    --accent-teal: #14b8a6;
    --accent-teal-light: #ccfbf1;
    --accent-gold: #eab308;
    --accent-gold-light: #fef9c3;
    
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
.seller-page {
    position: relative;
    min-height: 100vh;
    padding: 24px;
    background: var(--bg-primary);
    color: var(--text-primary);
    transition: background-color var(--transition-base), color var(--transition-base);
}

@media (min-width: 768px) {
    .seller-page {
        padding: 32px;
    }
}

@media (min-width: 1024px) {
    .seller-page {
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
    opacity: 0.08;
    animation: float 20s ease-in-out infinite;
}

body.dark .ambient-orb,
[data-theme="dark"] .ambient-orb {
    opacity: 0.04;
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
   SELLER HERO
   ============================================ */
.seller-hero {
    position: relative;
    border-radius: var(--radius-xl);
    overflow: hidden;
    min-height: 180px;
    background: linear-gradient(135deg, #060b18 0%, #0f172a 50%, #1a1033 100%);
    border: 1px solid var(--border-card);
    margin-bottom: 24px;
    box-shadow: var(--shadow-lg);
}

.seller-hero__content {
    position: relative;
    z-index: 2;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 32px 40px;
    gap: 24px;
}

@media (max-width: 768px) {
    .seller-hero__content {
        flex-direction: column;
        padding: 24px;
    }
}

.seller-hero__left { flex: 1; }

.seller-hero__badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 5px 14px;
    border-radius: 999px;
    background: rgba(34,197,94,0.12);
    border: 1px solid rgba(34,197,94,0.25);
    font-size: 12px;
    font-weight: 700;
    color: #86efac;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin-bottom: 16px;
}

.pulse-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #22c55e;
    position: relative;
}

.pulse-dot::after {
    content: '';
    position: absolute;
    inset: -2px;
    border-radius: 50%;
    border: 1px solid #22c55e;
    animation: pulse-ring 2s infinite;
}

.seller-hero__title {
    font-size: clamp(24px, 2.5vw, 36px);
    font-weight: 800;
    line-height: 1.15;
    color: #fff;
    margin: 0 0 10px;
    letter-spacing: -0.02em;
}

.gradient-text {
    background: linear-gradient(135deg, #60a5fa, #c4b5fd);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.seller-hero__subtitle {
    font-size: 14px;
    color: var(--text-muted);
    line-height: 1.6;
    max-width: 400px;
    margin: 0 0 12px 0;
}

.branch-info {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-tertiary);
    font-weight: 500;
}

.branch-info svg {
    color: var(--accent-blue);
}

.seller-hero__right {
    flex-shrink: 0;
}

.seller-hero__status {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 18px;
    border-radius: 12px;
    background: rgba(34,197,94,0.1);
    border: 1px solid rgba(34,197,94,0.2);
    color: #34d399;
    font-size: 13px;
    font-weight: 600;
}

.seller-hero__status svg {
    color: #22c55e;
}

/* ============================================
   BENTO GRID
   ============================================ */
.bento-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

@media (max-width: 1200px) {
    .bento-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .bento-grid {
        grid-template-columns: 1fr;
    }
}

.bento-card {
    position: relative;
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-lg);
    padding: 24px;
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
    box-shadow: var(--shadow-sm);
}

.bento-card:hover {
    transform: translateY(-4px);
    border-color: var(--border-strong);
    box-shadow: var(--shadow-lg);
}

.bento-card__glow {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.4s;
    pointer-events: none;
}

.bento-card:hover .bento-card__glow {
    opacity: 1;
}

/* Bento card color variants */
.bento-card--blue { border-color: rgba(59,130,246,0.2); }
.bento-card--blue .bento-card__glow { background: radial-gradient(circle at 80% 20%, rgba(59,130,246,0.1), transparent 60%); }
.bento-card--blue .bento-value { color: #60a5fa; }
.bento-card--blue .bento-trend { background: rgba(59,130,246,0.12); color: #60a5fa; }

.bento-card--emerald { border-color: rgba(16,185,129,0.2); }
.bento-card--emerald .bento-card__glow { background: radial-gradient(circle at 80% 20%, rgba(16,185,129,0.1), transparent 60%); }
.bento-card--emerald .bento-value { color: #34d399; }
.bento-card--emerald .bento-trend { background: rgba(16,185,129,0.12); color: #34d399; }

.bento-card--violet { border-color: rgba(139,92,246,0.2); }
.bento-card--violet .bento-card__glow { background: radial-gradient(circle at 80% 20%, rgba(139,92,246,0.1), transparent 60%); }
.bento-card--violet .bento-value { color: #c4b5fd; }
.bento-card--violet .bento-trend { background: rgba(139,92,246,0.12); color: #c4b5fd; }

.bento-card--red { border-color: rgba(239,68,68,0.2); }
.bento-card--red .bento-card__glow { background: radial-gradient(circle at 80% 20%, rgba(239,68,68,0.1), transparent 60%); }
.bento-card--red .bento-value { color: #fca5a5; }
.bento-card--red .bento-trend { background: rgba(239,68,68,0.12); color: #fca5a5; }

.bento-card--amber { border-color: rgba(245,158,11,0.2); }
.bento-card--amber .bento-card__glow { background: radial-gradient(circle at 80% 20%, rgba(245,158,11,0.1), transparent 60%); }
.bento-card--amber .bento-value { color: #fcd34d; }
.bento-card--amber .bento-trend { background: rgba(245,158,11,0.12); color: #fcd34d; }

.bento-card--gold { border-color: rgba(234,179,8,0.2); }
.bento-card--gold .bento-card__glow { background: radial-gradient(circle at 80% 20%, rgba(234,179,8,0.1), transparent 60%); }
.bento-card--gold .bento-value { color: #fde047; }
.bento-card--gold .bento-trend { background: rgba(234,179,8,0.12); color: #fde047; }

.bento-card__top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.bento-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s;
}

.bento-icon.blue { background: rgba(59,130,246,0.15); color: #60a5fa; }
.bento-icon.emerald { background: rgba(16,185,129,0.15); color: #34d399; }
.bento-icon.violet { background: rgba(139,92,246,0.15); color: #c4b5fd; }
.bento-icon.red { background: rgba(239,68,68,0.15); color: #fca5a5; }
.bento-icon.amber { background: rgba(245,158,11,0.15); color: #fcd34d; }
.bento-icon.gold { background: rgba(234,179,8,0.15); color: #fde047; }

.bento-card:hover .bento-icon {
    transform: scale(1.1) rotate(-4deg);
}

.bento-trend {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.bento-card__body {
    position: relative;
    z-index: 1;
}

.bento-value {
    font-size: 28px;
    font-weight: 900;
    line-height: 1;
    font-variant-numeric: tabular-nums;
    margin-bottom: 6px;
    font-family: 'JetBrains Mono', monospace;
}

.bento-label {
    font-size: 13px;
    color: var(--text-muted);
    font-weight: 500;
}

.bento-sparkline {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 45px;
    opacity: 0.6;
    pointer-events: none;
}

.bento-sparkline svg {
    width: 100%;
    height: 100%;
}

/* ============================================
   GLASS PANEL
   ============================================ */
.glass-panel {
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-lg);
    padding: 24px;
    transition: border-color 0.3s;
    margin-bottom: 20px;
    box-shadow: var(--shadow-sm);
}

.glass-panel:hover {
    border-color: var(--border-strong);
}

.panel--wide {
    width: 100%;
}

.panel__header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
    margin-bottom: 20px;
    flex-wrap: wrap;
}

.panel__title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 4px;
}

.panel__title svg {
    color: var(--accent-blue);
}

.panel__subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
}

.panel__link {
    display: flex;
    align-items: center;
    gap: 4px;
    font-size: 13px;
    font-weight: 600;
    color: var(--accent-blue);
    text-decoration: none;
    padding: 6px 14px;
    border-radius: 8px;
    background: rgba(59,130,246,0.1);
    transition: all var(--transition-fast);
    white-space: nowrap;
}

.panel__link:hover {
    background: rgba(59,130,246,0.2);
    gap: 8px;
}

.panel__link svg {
    transition: transform var(--transition-fast);
}

.panel__link:hover svg {
    transform: translateX(2px);
}

/* ============================================
   ACTION BENTO
   ============================================ */
.action-bento {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 12px;
}

@media (max-width: 1200px) {
    .action-bento {
        grid-template-columns: repeat(3, 1fr);
    }
}

@media (max-width: 768px) {
    .action-bento {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 480px) {
    .action-bento {
        grid-template-columns: 1fr;
    }
}

.action-tile {
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    gap: 10px;
    padding: 24px 16px;
    border-radius: 16px;
    border: 1px solid var(--border-subtle);
    background: var(--bg-elevated);
    text-decoration: none;
    color: var(--text-primary);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.action-tile::before {
    content: '';
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.3s;
}

.action-tile:hover {
    transform: translateY(-4px);
    border-color: var(--border-strong);
}

.action-tile:hover::before {
    opacity: 1;
}

.action-tile__icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s;
}

.action-tile:hover .action-tile__icon {
    transform: scale(1.1) rotate(-4deg);
}

.action-tile__label {
    font-size: 13px;
    font-weight: 700;
    color: var(--text-primary);
}

.action-tile__desc {
    font-size: 11px;
    color: var(--text-muted);
    font-weight: 500;
}

/* Action tile colors */
.action-tile--blue .action-tile__icon { background: rgba(59,130,246,0.15); color: #60a5fa; }
.action-tile--blue::before { background: radial-gradient(circle at 50% 0%, rgba(59,130,246,0.08), transparent 70%); }
.action-tile--blue:hover { border-color: rgba(59,130,246,0.3); }

.action-tile--emerald .action-tile__icon { background: rgba(16,185,129,0.15); color: #34d399; }
.action-tile--emerald::before { background: radial-gradient(circle at 50% 0%, rgba(16,185,129,0.08), transparent 70%); }
.action-tile--emerald:hover { border-color: rgba(16,185,129,0.3); }

.action-tile--violet .action-tile__icon { background: rgba(139,92,246,0.15); color: #c4b5fd; }
.action-tile--violet::before { background: radial-gradient(circle at 50% 0%, rgba(139,92,246,0.08), transparent 70%); }
.action-tile--violet:hover { border-color: rgba(139,92,246,0.3); }

.action-tile--amber .action-tile__icon { background: rgba(245,158,11,0.15); color: #fcd34d; }
.action-tile--amber::before { background: radial-gradient(circle at 50% 0%, rgba(245,158,11,0.08), transparent 70%); }
.action-tile--amber:hover { border-color: rgba(245,158,11,0.3); }

.action-tile--teal .action-tile__icon { background: rgba(20,184,166,0.15); color: #5eead4; }
.action-tile--teal::before { background: radial-gradient(circle at 50% 0%, rgba(20,184,166,0.08), transparent 70%); }
.action-tile--teal:hover { border-color: rgba(20,184,166,0.3); }

.action-tile--rose .action-tile__icon { background: rgba(244,63,94,0.15); color: #fda4af; }
.action-tile--rose::before { background: radial-gradient(circle at 50% 0%, rgba(244,63,94,0.08), transparent 70%); }
.action-tile--rose:hover { border-color: rgba(244,63,94,0.3); }

/* ============================================
   DATA TABLE
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
    border-bottom: 1px solid var(--border-subtle);
    white-space: nowrap;
}

.data-table td {
    padding: 14px 16px;
    border-bottom: 1px solid var(--border-subtle);
    color: var(--text-secondary);
    vertical-align: middle;
}

.data-table tbody tr {
    transition: background var(--transition-fast);
}

.data-table tbody tr:hover {
    background: var(--bg-hover);
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

.text-center { text-align: center; }
.text-right { text-align: right; }
.mono { font-family: 'JetBrains Mono', monospace; }

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
    color: var(--text-primary);
}

.badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.badge-success {
    background: rgba(34,197,94,0.15);
    color: #22c55e;
}

.badge-danger {
    background: rgba(239,68,68,0.15);
    color: #ef4444;
}

.status-pill {
    display: inline-flex;
    align-items: center;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

.status--success {
    background: rgba(34,197,94,0.1);
    color: #22c55e;
    border: 1px solid rgba(34,197,94,0.2);
}

.status--danger {
    background: rgba(239,68,68,0.1);
    color: #ef4444;
    border: 1px solid rgba(239,68,68,0.2);
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
    color: var(--text-primary);
    margin: 0 0 8px;
}

.empty-state p {
    font-size: 14px;
    color: var(--text-muted);
    margin: 0 0 20px;
}

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

/* ============================================
   REVEAL ANIMATION
   ============================================ */
[data-reveal] {
    opacity: 0;
    transform: translateY(24px);
    transition: opacity 0.6s cubic-bezier(0.22, 1, 0.36, 1),
                transform 0.6s cubic-bezier(0.22, 1, 0.36, 1);
}

[data-reveal].revealed {
    opacity: 1;
    transform: translateY(0);
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .seller-hero__content {
        flex-direction: column;
    }
    .seller-hero__right {
        width: 100%;
    }
    .seller-hero__status {
        justify-content: center;
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
(function() {
    'use strict';

    /* ── 1. SCROLL REVEAL ── */
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('revealed');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

    document.querySelectorAll('[data-reveal]').forEach(el => revealObserver.observe(el));

    /* ── 2. COUNT-UP ── */
    const countUp = (el, target, prefix = '', duration = 1500) => {
        const startTime = performance.now();
        const step = (now) => {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 4);
            const value = Math.round(target * eased);
            el.textContent = prefix + value.toLocaleString();
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    };

    const statObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            statObserver.unobserve(entry.target);
            const valueEl = entry.target.querySelector('.bento-value');
            const target = parseInt(valueEl.dataset.target || '0', 10);
            const prefix = valueEl.dataset.prefix || '';
            countUp(valueEl, target, prefix);
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.bento-card').forEach(card => statObserver.observe(card));

})();
</script>