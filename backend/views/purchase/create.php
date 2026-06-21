<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var array $products */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Create Purchase';
?>

<div class="purchases-page">
    <!-- Ambient Background -->
    <div class="ambient-bg">
        <div class="ambient-orb orb-1"></div>
        <div class="ambient-orb orb-2"></div>
        <div class="ambient-orb orb-3"></div>
    </div>

    <div class="page-wrapper">
        <!-- Breadcrumb & Header -->
        <div class="page-header">
            <div class="breadcrumb">
                <a href="<?= Url::to(['/purchase/index']) ?>">Purchases</a>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
                <span class="active">Create</span>
            </div>
            <h1 class="page-title">Create New Purchase</h1>
            <p class="page-subtitle">Record stock purchase and automatically update inventory</p>
        </div>

        <!-- Form Card -->
        <div class="form-card">
            <form method="post" class="purchase-form">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->getCsrfToken() ?>">

                <!-- Supplier -->
                <div class="form-group">
                    <label class="form-label" for="supplier_name">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 7h-9"></path>
                            <path d="M14 17H5"></path>
                            <circle cx="17" cy="17" r="3"></circle>
                            <circle cx="7" cy="7" r="3"></circle>
                        </svg>
                        Supplier Name
                    </label>
                    <input type="text" id="supplier_name" name="supplier_name" class="form-input" placeholder="e.g. ABC Suppliers Ltd" required>
                </div>

                <!-- Product -->
                <div class="form-group">
                    <label class="form-label" for="product_id">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        Select Product
                    </label>
                    <div class="select-wrapper">
                        <select id="product_id" name="product_id" class="form-input form-select" required>
                            <option value="">-- Choose Product --</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= $product->id ?>">
                                    <?= Html::encode($product->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <svg class="select-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </div>
                </div>

                <!-- Quantity -->
                <div class="form-group">
                    <label class="form-label" for="quantity">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="5" x2="12" y2="19"></line>
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                        </svg>
                        Quantity
                    </label>
                    <input type="number" id="quantity" name="quantity" class="form-input" placeholder="Enter quantity" min="1" required>
                </div>

                <!-- Alert Box -->
                <div class="alert-box">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                        <line x1="12" y1="9" x2="12" y2="13"></line>
                        <line x1="12" y1="17" x2="12.01" y2="17"></line>
                    </svg>
                    <span>Stock will automatically increase after purchase is saved.</span>
                </div>

                <!-- Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        Save Purchase
                    </button>
                    <a href="<?= Url::to(['index']) ?>" class="btn-secondary">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Back to Purchases
                    </a>
                </div>
            </form>
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
    --bg-input: #ffffff;
    
    --text-primary: #0f172a;
    --text-secondary: #475569;
    --text-tertiary: #94a3b8;
    --text-muted: #64748b;
    --text-placeholder: #94a3b8;
    
    --border-subtle: rgba(226, 232, 240, 0.8);
    --border-card: rgba(226, 232, 240, 0.6);
    --border-input: rgba(203, 213, 225, 0.6);
    --border-divider: rgba(241, 245, 249, 0.8);
    
    --accent-blue: #3b82f6;
    --accent-blue-light: #dbeafe;
    --accent-blue-hover: #2563eb;
    --accent-purple: #8b5cf6;
    --accent-purple-light: #ede9fe;
    --accent-emerald: #10b981;
    --accent-emerald-light: #d1fae5;
    --accent-amber: #f59e0b;
    --accent-amber-light: #fef3c7;
    
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
    --bg-input: rgba(15, 23, 42, 0.6);
    
    --text-primary: #f8fafc;
    --text-secondary: #cbd5e1;
    --text-tertiary: #94a3b8;
    --text-muted: #64748b;
    --text-placeholder: #475569;
    
    --border-subtle: rgba(51, 65, 85, 0.6);
    --border-card: rgba(51, 65, 85, 0.5);
    --border-input: rgba(71, 85, 105, 0.6);
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
    max-width: 650px;
    margin-left: auto;
    margin-right: auto;
}

.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-tertiary);
    margin-bottom: 12px;
}

.breadcrumb a {
    color: var(--text-muted);
    text-decoration: none;
    transition: color var(--transition-fast);
}

.breadcrumb a:hover {
    color: var(--accent-blue);
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
   FORM CARD
   ============================================ */
.page-wrapper {
    position: relative;
    z-index: 1;
    max-width: 650px;
    margin: 0 auto;
}

.form-card {
    background: var(--bg-card);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-xl);
    padding: 32px;
    box-shadow: var(--shadow-lg);
    transition: all var(--transition-base);
}

@media (max-width: 479px) {
    .form-card {
        padding: 24px;
    }
}

/* ============================================
   FORM ELEMENTS
   ============================================ */
.purchase-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    font-weight: 600;
    color: var(--text-secondary);
}

.form-label svg {
    color: var(--text-tertiary);
}

.form-input {
    width: 100%;
    padding: 12px 16px;
    border-radius: var(--radius-md);
    border: 1px solid var(--border-input);
    background: var(--bg-input);
    color: var(--text-primary);
    font-size: 14px;
    font-family: inherit;
    outline: none;
    transition: all var(--transition-fast);
    box-sizing: border-box;
}

.form-input::placeholder {
    color: var(--text-placeholder);
}

.form-input:focus {
    border-color: var(--accent-blue);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Select styling */
.select-wrapper {
    position: relative;
}

.form-select {
    appearance: none;
    -webkit-appearance: none;
    padding-right: 40px;
    cursor: pointer;
}

.select-arrow {
    position: absolute;
    right: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-tertiary);
    pointer-events: none;
}

/* ============================================
   ALERT BOX
   ============================================ */
.alert-box {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    background: var(--accent-amber-light);
    border: 1px solid rgba(245, 158, 11, 0.2);
    border-radius: var(--radius-md);
    color: #92400e;
    font-size: 13px;
    font-weight: 500;
}

body.dark .alert-box,
[data-theme="dark"] .alert-box {
    background: rgba(245, 158, 11, 0.1);
    color: #fbbf24;
    border-color: rgba(245, 158, 11, 0.15);
}

.alert-box svg {
    flex-shrink: 0;
    color: currentColor;
}

/* ============================================
   BUTTONS
   ============================================ */
.form-actions {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 8px;
}

@media (min-width: 480px) {
    .form-actions {
        flex-direction: row;
        align-items: center;
    }
}

.btn-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
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
    font-family: inherit;
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.45);
}

.btn-primary:active {
    transform: translateY(0);
}

.btn-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px 24px;
    background: transparent;
    color: var(--text-secondary);
    text-decoration: none;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 14px;
    border: 1px solid var(--border-subtle);
    cursor: pointer;
    transition: all var(--transition-fast);
    white-space: nowrap;
}

.btn-secondary:hover {
    background: var(--bg-hover);
    border-color: var(--text-tertiary);
    color: var(--text-primary);
}
</style>