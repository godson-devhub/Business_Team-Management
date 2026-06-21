<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var common\models\Purchase[] $purchases */

$this->title = 'Purchases';

$totalPurchases = count($purchases);
$totalAmount = 0;
$totalItems = 0;

foreach ($purchases as $purchase) {
    if (!empty($purchase->items)) {
        foreach ($purchase->items as $item) {
            $totalAmount += (float)$item->quantity * (float)$item->buying_price;
            $totalItems += (int)$item->quantity;
        }
    }
}

// Mock percentage changes
$purchasesChange = '+8.4%';
$amountChange = '+15.2%';
$itemsChange = '+22.1%';
?>

<div class="purchases-page">
    <!-- Ambient Background -->
    <div class="ambient-bg">
        <div class="ambient-orb orb-1"></div>
        <div class="ambient-orb orb-2"></div>
        <div class="ambient-orb orb-3"></div>
    </div>

    <!-- Header Section -->
    <div class="page-header">
        <div class="header-content">
            <div class="header-meta">
                <div class="breadcrumb">
                    <span>Dashboard</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                    <span class="active">Purchases</span>
                </div>
                <h1 class="page-title">Purchases</h1>
                <p class="page-subtitle">Track all stock purchases and supplier transactions</p>
            </div>
            <div class="header-actions">
                <a href="<?= Url::to(['create']) ?>" class="btn-primary">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    New Purchase
                </a>
            </div>
        </div>
    </div>

    <!-- KPI Stats Cards -->
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-visual">
                <div class="stat-icon-bg blue">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                        <polyline points="14 2 14 8 20 8"></polyline>
                        <line x1="16" y1="13" x2="8" y2="13"></line>
                        <line x1="16" y1="17" x2="8" y2="17"></line>
                        <polyline points="10 9 9 9 8 9"></polyline>
                    </svg>
                </div>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Purchases</span>
                <div class="stat-value-row">
                    <h2 class="stat-value"><?= number_format($totalPurchases) ?></h2>
                    <span class="stat-badge positive"><?= $purchasesChange ?></span>
                </div>
                <span class="stat-desc">Transactions this period</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-visual">
                <div class="stat-icon-bg purple">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="1" x2="12" y2="23"></line>
                        <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                    </svg>
                </div>
            </div>
            <div class="stat-info">
                <span class="stat-label">Total Amount</span>
                <div class="stat-value-row">
                    <h2 class="stat-value">TZS <?= number_format($totalAmount) ?></h2>
                    <span class="stat-badge positive"><?= $amountChange ?></span>
                </div>
                <span class="stat-desc">Across all purchases</span>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-visual">
                <div class="stat-icon-bg emerald">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </div>
            </div>
            <div class="stat-info">
                <span class="stat-label">Items Acquired</span>
                <div class="stat-value-row">
                    <h2 class="stat-value"><?= number_format($totalItems) ?></h2>
                    <span class="stat-badge positive"><?= $itemsChange ?></span>
                </div>
                <span class="stat-desc">Total units purchased</span>
            </div>
        </div>
    </div>

    <!-- Purchases Grid -->
    <div class="purchases-grid">
        <?php if (!empty($purchases)): ?>
            <?php foreach ($purchases as $purchase): ?>
                <?php
                    $calculatedTotal = 0;
                    $itemCount = count($purchase->items);
                ?>

                <div class="purchase-card">
                    <!-- Card Header -->
                    <div class="purchase-card-header">
                        <div class="purchase-meta">
                            <div class="purchase-id">
                                <span class="purchase-hash">#</span><?= $purchase->id ?>
                            </div>
                            <div class="purchase-date">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                                <?= date('d M Y', $purchase->created_at) ?>
                            </div>
                        </div>
                        <span class="status-badge">
                            <span class="status-dot"></span>
                            Completed
                        </span>
                    </div>

                    <!-- Supplier Info -->
                    <div class="supplier-info">
                        <div class="supplier-icon">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 7h-9"></path>
                                <path d="M14 17H5"></path>
                                <circle cx="17" cy="17" r="3"></circle>
                                <circle cx="7" cy="7" r="3"></circle>
                            </svg>
                        </div>
                        <div class="supplier-details">
                            <span class="supplier-label">Supplier</span>
                            <span class="supplier-name"><?= Html::encode($purchase->supplier_name) ?></span>
                        </div>
                    </div>

                    <!-- Items Section -->
                    <div class="items-section">
                        <div class="items-header">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                                <line x1="12" y1="22.08" x2="12" y2="12"></line>
                            </svg>
                            <span>Items Purchased (<?= $itemCount ?>)</span>
                        </div>

                        <?php if (!empty($purchase->items)): ?>
                            <div class="items-list">
                                <?php foreach ($purchase->items as $index => $item): ?>
                                    <?php
                                        $productName = $item->product->name ?? 'Deleted Product';
                                        $qty = (int)$item->quantity;
                                        $price = (float)$item->buying_price;
                                        $subtotal = $qty * $price;
                                        $calculatedTotal += $subtotal;
                                    ?>

                                    <div class="item-row <?= $index === $itemCount - 1 ? 'last' : '' ?>">
                                        <div class="item-details">
                                            <div class="item-icon">
                                                <?= strtoupper(substr($productName, 0, 1)) ?>
                                            </div>
                                            <div class="item-text">
                                                <div class="item-name"><?= Html::encode($productName) ?></div>
                                                <div class="item-calc">
                                                    <?= $qty ?> × TZS <?= number_format($price) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item-subtotal">
                                            TZS <?= number_format($subtotal) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="no-items">No items available</div>
                        <?php endif; ?>
                    </div>

                    <!-- Card Footer -->
                    <div class="purchase-card-footer">
                        <div class="footer-block">
                            <span class="footer-label">Total Amount</span>
                            <span class="footer-value">TZS <?= number_format($calculatedTotal) ?></span>
                        </div>
                        <div class="footer-divider"></div>
                        <div class="footer-block">
                            <span class="footer-label">Items</span>
                            <span class="footer-value"><?= $itemCount ?></span>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-illustration">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                </div>
                <h3>No Purchases Found</h3>
                <p>Your purchase transactions will appear here once you record your first stock purchase.</p>
                <a href="<?= Url::to(['create']) ?>" class="btn-outline">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    Record First Purchase
                </a>
            </div>
        <?php endif; ?>
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
    
    --text-primary: #0f172a;
    --text-secondary: #475569;
    --text-tertiary: #94a3b8;
    --text-muted: #64748b;
    
    --border-subtle: rgba(226, 232, 240, 0.8);
    --border-card: rgba(226, 232, 240, 0.6);
    --border-divider: rgba(241, 245, 249, 0.8);
    
    --accent-blue: #3b82f6;
    --accent-blue-light: #dbeafe;
    --accent-purple: #8b5cf6;
    --accent-purple-light: #ede9fe;
    --accent-emerald: #10b981;
    --accent-emerald-light: #d1fae5;
    --accent-amber: #f59e0b;
    
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
    --radius-full: 9999px;
    
    --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
    --transition-base: 250ms cubic-bezier(0.4, 0, 0.2, 1);
    --transition-slow: 350ms cubic-bezier(0.4, 0, 0.2, 1);
}

body.dark,
[data-theme="dark"] {
    --bg-primary: #0f172a;
    --bg-secondary: #1e293b;
    --bg-tertiary: #334155;
    --bg-card: rgba(30, 41, 59, 0.7);
    --bg-card-solid: #1e293b;
    --bg-hover: rgba(51, 65, 85, 0.4);
    
    --text-primary: #f8fafc;
    --text-secondary: #cbd5e1;
    --text-tertiary: #94a3b8;
    --text-muted: #64748b;
    
    --border-subtle: rgba(51, 65, 85, 0.6);
    --border-card: rgba(51, 65, 85, 0.5);
    --border-divider: rgba(51, 65, 85, 0.4);
    
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -2px rgba(0, 0, 0, 0.2);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -4px rgba(0, 0, 0, 0.2);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3);
}

/* ============================================
   BASE LAYOUT
   ============================================ */
.purchases-page {
    position: relative;
    min-height: 100vh;
    padding: 24px;
    background: var(--bg-primary);
    color: var(--text-primary);
    transition: background-color var(--transition-base), color var(--transition-base);
}

@media (min-width: 768px) {
    .purchases-page {
        padding: 32px;
    }
}

@media (min-width: 1024px) {
    .purchases-page {
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
    opacity: 0.12;
    animation: float 20s ease-in-out infinite;
}

body.dark .ambient-orb,
[data-theme="dark"] .ambient-orb {
    opacity: 0.06;
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
   PAGE HEADER
   ============================================ */
.page-header {
    position: relative;
    z-index: 1;
    margin-bottom: 32px;
}

.header-content {
    display: flex;
    flex-direction: column;
    gap: 20px;
    align-items: flex-start;
}

@media (min-width: 640px) {
    .header-content {
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
    }
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-tertiary);
    margin-bottom: 8px;
}

.breadcrumb svg {
    opacity: 0.5;
}

.breadcrumb .active {
    color: var(--text-primary);
    font-weight: 500;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    letter-spacing: -0.02em;
    color: var(--text-primary);
    margin: 0 0 6px 0;
    line-height: 1.2;
}

@media (min-width: 640px) {
    .page-title {
        font-size: 32px;
    }
}

.page-subtitle {
    font-size: 14px;
    color: var(--text-secondary);
    margin: 0;
    line-height: 1.5;
}

/* ============================================
   BUTTONS
   ============================================ */
.btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, var(--accent-blue), #6366f1);
    color: white;
    text-decoration: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 14px;
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 14px rgba(59, 130, 246, 0.35);
    transition: all var(--transition-fast);
    white-space: nowrap;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.45);
}

.btn-primary:active {
    transform: translateY(0);
}

.btn-outline {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: transparent;
    color: var(--text-primary);
    text-decoration: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 14px;
    border: 1px solid var(--border-subtle);
    cursor: pointer;
    transition: all var(--transition-fast);
}

.btn-outline:hover {
    background: var(--bg-hover);
    border-color: var(--text-tertiary);
}

/* ============================================
   STATS CARDS
   ============================================ */
.stats-container {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
    margin-bottom: 32px;
}

@media (min-width: 640px) {
    .stats-container {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1024px) {
    .stats-container {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
}

.stat-card {
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-lg);
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all var(--transition-base);
    box-shadow: var(--shadow-sm);
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    border-color: var(--border-subtle);
}

.stat-icon-bg {
    width: 48px;
    height: 48px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-icon-bg.blue {
    background: var(--accent-blue-light);
    color: var(--accent-blue);
}

body.dark .stat-icon-bg.blue,
[data-theme="dark"] .stat-icon-bg.blue {
    background: rgba(59, 130, 246, 0.15);
}

.stat-icon-bg.purple {
    background: var(--accent-purple-light);
    color: var(--accent-purple);
}

body.dark .stat-icon-bg.purple,
[data-theme="dark"] .stat-icon-bg.purple {
    background: rgba(139, 92, 246, 0.15);
}

.stat-icon-bg.emerald {
    background: var(--accent-emerald-light);
    color: var(--accent-emerald);
}

body.dark .stat-icon-bg.emerald,
[data-theme="dark"] .stat-icon-bg.emerald {
    background: rgba(16, 185, 129, 0.15);
}

.stat-info {
    flex: 1;
    min-width: 0;
}

.stat-label {
    display: block;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-tertiary);
    margin-bottom: 4px;
}

.stat-value-row {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.stat-value {
    font-size: 24px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0;
    letter-spacing: -0.02em;
    line-height: 1.2;
}

.stat-badge {
    display: inline-flex;
    align-items: center;
    padding: 2px 8px;
    border-radius: var(--radius-full);
    font-size: 12px;
    font-weight: 600;
}

.stat-badge.positive {
    background: var(--accent-emerald-light);
    color: #059669;
}

body.dark .stat-badge.positive,
[data-theme="dark"] .stat-badge.positive {
    background: rgba(16, 185, 129, 0.15);
    color: #34d399;
}

.stat-desc {
    display: block;
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 4px;
}

/* ============================================
   PURCHASES GRID
   ============================================ */
.purchases-grid {
    position: relative;
    z-index: 1;
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
}

@media (min-width: 768px) {
    .purchases-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (min-width: 1280px) {
    .purchases-grid {
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
}

/* ============================================
   PURCHASE CARD
   ============================================ */
.purchase-card {
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-xl);
    overflow: hidden;
    transition: all var(--transition-base);
    box-shadow: var(--shadow-sm);
    display: flex;
    flex-direction: column;
}

.purchase-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-xl);
    border-color: var(--border-subtle);
}

/* Card Header */
.purchase-card-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    padding: 20px 20px 12px;
    border-bottom: 1px solid var(--border-divider);
}

.purchase-meta {
    min-width: 0;
}

.purchase-id {
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
    display: flex;
    align-items: center;
    gap: 2px;
    margin-bottom: 6px;
}

.purchase-hash {
    color: var(--text-tertiary);
    font-weight: 500;
}

.purchase-date {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--text-muted);
    flex-wrap: wrap;
}

.purchase-date svg {
    opacity: 0.6;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: var(--accent-emerald-light);
    color: #059669;
    border-radius: var(--radius-full);
    font-size: 12px;
    font-weight: 600;
    flex-shrink: 0;
    white-space: nowrap;
}

body.dark .status-badge,
[data-theme="dark"] .status-badge {
    background: rgba(16, 185, 129, 0.15);
    color: #34d399;
}

.status-dot {
    width: 6px;
    height: 6px;
    background: currentColor;
    border-radius: 50%;
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

/* Supplier Info */
.supplier-info {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    background: var(--bg-hover);
    border-bottom: 1px solid var(--border-divider);
}

.supplier-icon {
    width: 36px;
    height: 36px;
    border-radius: var(--radius-sm);
    background: var(--accent-purple-light);
    color: var(--accent-purple);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

body.dark .supplier-icon,
[data-theme="dark"] .supplier-icon {
    background: rgba(139, 92, 246, 0.15);
}

.supplier-details {
    display: flex;
    flex-direction: column;
    gap: 2px;
    min-width: 0;
}

.supplier-label {
    font-size: 11px;
    font-weight: 500;
    color: var(--text-tertiary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.supplier-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-primary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Items Section */
.items-section {
    padding: 16px 20px;
    flex: 1;
}

.items-header {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12px;
    font-weight: 600;
    color: var(--text-tertiary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 12px;
}

.items-header svg {
    opacity: 0.7;
}

.items-list {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.item-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 12px;
    background: var(--bg-hover);
    border-radius: var(--radius-sm);
    border: 1px solid var(--border-divider);
}

.item-row.last {
    margin-bottom: 0;
}

.item-details {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    flex: 1;
}

.item-icon {
    width: 32px;
    height: 32px;
    border-radius: var(--radius-sm);
    background: var(--bg-tertiary);
    color: var(--text-secondary);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: 700;
    flex-shrink: 0;
}

.item-text {
    min-width: 0;
}

.item-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-primary);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

.item-calc {
    font-size: 11px;
    color: var(--text-muted);
    margin-top: 2px;
}

.item-subtotal {
    font-size: 13px;
    font-weight: 700;
    color: var(--accent-blue);
    flex-shrink: 0;
    margin-left: 10px;
}

.no-items {
    padding: 20px;
    text-align: center;
    color: var(--text-muted);
    font-size: 13px;
    background: var(--bg-hover);
    border-radius: var(--radius-sm);
}

/* Card Footer */
.purchase-card-footer {
    display: flex;
    align-items: center;
    padding: 16px 20px;
    background: var(--bg-hover);
    border-top: 1px solid var(--border-divider);
    gap: 16px;
}

.footer-block {
    flex: 1;
    min-width: 0;
}

.footer-label {
    display: block;
    font-size: 11px;
    font-weight: 500;
    color: var(--text-tertiary);
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 4px;
}

.footer-value {
    display: block;
    font-size: 16px;
    font-weight: 700;
    color: var(--text-primary);
}

.footer-divider {
    width: 1px;
    height: 32px;
    background: var(--border-divider);
    flex-shrink: 0;
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
    padding: 80px 24px;
    text-align: center;
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-sm);
}

.empty-illustration {
    width: 100px;
    height: 100px;
    border-radius: var(--radius-full);
    background: var(--bg-tertiary);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
    color: var(--text-tertiary);
}

.empty-state h3 {
    font-size: 20px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 14px;
    color: var(--text-secondary);
    margin: 0 0 24px 0;
    max-width: 400px;
}

/* ============================================
   RESPONSIVE TWEAKS
   ============================================ */
@media (max-width: 479px) {
    .stat-value {
        font-size: 20px;
    }
    
    .purchase-card-header {
        flex-direction: column;
        gap: 10px;
    }
    
    .status-badge {
        align-self: flex-start;
    }
    
    .purchase-card-footer {
        flex-direction: column;
        align-items: stretch;
        gap: 12px;
    }
    
    .footer-divider {
        width: 100%;
        height: 1px;
    }
}
</style>