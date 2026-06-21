<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use common\models\StockMovement;
use common\models\Product;

$this->title = 'Analytics Dashboard';

$branchOptions = ArrayHelper::map($branches, 'id', 'name');

// === HESABU STOCK VALUE KUTOKA STOCK MOVEMENT (sawa na branch/stock-value) ===
$stockValue = 0;

if ($branchId) {
    // Kama branch imeshachaguliwa, chukua products za branch hiyo
    $branchProducts = Product::find()
        ->where(['branch_id' => $branchId])
        ->all();
    
    foreach ($branchProducts as $product) {
        $in = (int) StockMovement::find()
            ->where(['product_id' => $product->id, 'type' => 'IN'])
            ->sum('quantity') ?? 0;

        $out = (int) StockMovement::find()
            ->where(['product_id' => $product->id, 'type' => 'OUT'])
            ->sum('quantity') ?? 0;

        $currentStock = $in - $out;
        $stockValue += ($currentStock * $product->selling_price);
    }
} else {
    // Kama hakuna branch iliyochaguliwa, jumlisha zote
    foreach ($branches as $branch) {
        $branchProducts = Product::find()
            ->where(['branch_id' => $branch->id])
            ->all();
        
        foreach ($branchProducts as $product) {
            $in = (int) StockMovement::find()
                ->where(['product_id' => $product->id, 'type' => 'IN'])
                ->sum('quantity') ?? 0;

            $out = (int) StockMovement::find()
                ->where(['product_id' => $product->id, 'type' => 'OUT'])
                ->sum('quantity') ?? 0;

            $currentStock = $in - $out;
            $stockValue += ($currentStock * $product->selling_price);
        }
    }
}
?>

<div class="analytics-page">
    <!-- Ambient Background -->
    <div class="ambient-bg">
        <div class="ambient-orb orb-1"></div>
        <div class="ambient-orb orb-2"></div>
        <div class="ambient-orb orb-3"></div>
    </div>

    <div class="page-wrapper">

        <!-- Page Header -->
        <div class="page-header">
            <div>
                <h1 class="page-title">Analytics Dashboard</h1>
                <p class="page-subtitle">Business performance overview by branch, date & trends</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="filter-card">
            <div class="filter-grid">
                <div class="filter-group">
                    <label class="filter-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="6" y1="3" x2="6" y2="15"></line>
                            <circle cx="18" cy="6" r="3"></circle>
                            <circle cx="6" cy="18" r="3"></circle>
                            <path d="M18 9a9 9 0 0 1-9 9"></path>
                        </svg>
                        Branch
                    </label>
                    <?= Html::dropDownList('branch_id', $branchId ?? null, $branchOptions, [
                        'class' => 'form-control form-select',
                        'id' => 'branchSelect',
                        'prompt' => 'All Branches'
                    ]) ?>
                </div>
                <div class="filter-group">
                    <label class="filter-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        Date
                    </label>
                    <input type="date" id="dateInput" value="<?= Html::encode($selectedDate ?? date('Y-m-d')) ?>" class="form-control">
                </div>
                <div class="filter-group">
                    <label class="filter-label">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                            <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"></path>
                        </svg>
                        Month
                    </label>
                    <input type="month" id="monthInput" value="<?= Html::encode($selectedMonth ?? date('Y-m')) ?>" class="form-control">
                </div>
                <div class="filter-group">
                    <label class="filter-label">&nbsp;</label>
                    <button type="button" class="btn btn-primary" id="applyBtn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon>
                        </svg>
                        Apply Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- KPI Cards -->
        <div class="stats-row">
            <div class="stat-card highlight-blue">
                <div class="stat-header">
                    <span class="stat-title">Daily Sales</span>
                    <div class="stat-icon-sm blue">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="6" width="20" height="12" rx="2"></rect>
                            <circle cx="12" cy="12" r="2"></circle>
                            <path d="M6 12h.01M18 12h.01"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number" id="dailySales">TZS <?= number_format($dailySales ?? 0) ?></div>
                <div class="stat-trend">Today's revenue</div>
            </div>

            <div class="stat-card highlight-green">
                <div class="stat-header">
                    <span class="stat-title">Daily Profit</span>
                    <div class="stat-icon-sm emerald">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline>
                            <polyline points="17 6 23 6 23 12"></polyline>
                        </svg>
                    </div>
                </div>
                <div class="stat-number" id="dailyProfit">TZS <?= number_format($dailyProfit ?? 0) ?></div>
                <div class="stat-trend">Net earnings today</div>
            </div>

            <div class="stat-card highlight-purple">
                <div class="stat-header">
                    <span class="stat-title">Monthly Sales</span>
                    <div class="stat-icon-sm purple">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                            <path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01M16 18h.01"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number" id="monthlySales">TZS <?= number_format($monthlySales ?? 0) ?></div>
                <div class="stat-trend">This month</div>
            </div>

            <div class="stat-card highlight-orange">
                <div class="stat-header">
                    <span class="stat-title">Monthly Profit</span>
                    <div class="stat-icon-sm amber">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="12" y1="1" x2="12" y2="23"></line>
                            <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                        </svg>
                    </div>
                </div>
                <div class="stat-number" id="monthlyProfit">TZS <?= number_format($monthlyProfit ?? 0) ?></div>
                <div class="stat-trend">Net this month</div>
            </div>

       
            <!-- Stock Value — REALTIME kutoka Stock Movement -->
      
        </div>

        <!-- Chart -->
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg>
                    Sales Trend
                </h3>
                <div class="chart-legend">
                    <span class="legend-item">
                        <span class="legend-dot" style="background: #38bdf8;"></span>
                        Sales
                    </span>
                </div>
            </div>
            <div class="chart-body">
                <canvas id="chart"></canvas>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let chart = null;
let isLoading = false;
let interval = null;

function loadAnalytics() {
    if (isLoading) return;
    isLoading = true;

    $.ajax({
        url: "<?= Url::to(['analytics/index']) ?>",
        type: "GET",
        data: {
            ajax: 1,
            branch_id: $('#branchSelect').val(),
            date: $('#dateInput').val(),
            month: $('#monthInput').val()
        },
        dataType: "json",

        success: function(res) {
            res = res || {};

            $('#dailySales').text('TZS ' + (res.dailySales ?? 0));
            $('#dailyProfit').text('TZS ' + (res.dailyProfit ?? 0));
            $('#monthlySales').text('TZS ' + (res.monthlySales ?? 0));
            $('#monthlyProfit').text('TZS ' + (res.monthlyProfit ?? 0));
            $('#totalProducts').text(res.totalProducts ?? 0);
            $('#stockValue').text('TZS ' + (res.stockValue ?? 0));

            if (chart !== null) {
                chart.destroy();
                chart = null;
            }

            chart = new Chart(document.getElementById('chart'), {
                type: 'line',
                data: {
                    labels: res.labels ?? [],
                    datasets: [{
                        label: 'Sales Trend',
                        data: res.values ?? [],
                        borderColor: '#38bdf8',
                        backgroundColor: 'rgba(56,189,248,0.15)',
                        fill: true,
                        tension: 0.4,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointBackgroundColor: '#38bdf8',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        x: {
                            grid: { color: 'rgba(255,255,255,0.05)' },
                            ticks: { color: '#94a3b8' }
                        },
                        y: {
                            grid: { color: 'rgba(255,255,255,0.05)' },
                            ticks: { color: '#94a3b8' }
                        }
                    }
                }
            });
        },

        complete: function() {
            isLoading = false;
        },

        error: function() {
            isLoading = false;
            console.log("Analytics load failed");
        }
    });
}

$(document).ready(function() {
    loadAnalytics();
    if (interval) clearInterval(interval);
    interval = setInterval(function() {
        loadAnalytics();
    }, 30000);
});

$('#branchSelect, #dateInput, #monthInput').on('change', function() {
    loadAnalytics();
});

$('#applyBtn').on('click', function() {
    loadAnalytics();
});

$(window).on('beforeunload', function() {
    if (interval) clearInterval(interval);
});
</script>

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
.analytics-page {
    position: relative;
    min-height: 100vh;
    padding: 24px;
    background: var(--bg-primary);
    color: var(--text-primary);
    transition: background-color var(--transition-base), color var(--transition-base);
}

@media (min-width: 768px) {
    .analytics-page {
        padding: 32px;
    }
}

@media (min-width: 1024px) {
    .analytics-page {
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
   PAGE HEADER
   ============================================ */
.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 28px;
    gap: 16px;
    flex-wrap: wrap;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: var(--text-primary);
    letter-spacing: -0.5px;
    margin: 0 0 6px 0;
}

.page-subtitle {
    font-size: 14px;
    color: var(--text-muted);
    margin: 0;
}

/* ============================================
   FILTER CARD
   ============================================ */
.filter-card {
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: var(--shadow-sm);
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    align-items: flex-end;
}

@media (max-width: 992px) {
    .filter-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 576px) {
    .filter-grid {
        grid-template-columns: 1fr;
    }
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.filter-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
}

.filter-label svg {
    color: var(--text-tertiary);
}

.form-control {
    width: 100%;
    padding: 10px 14px;
    border: 1px solid var(--border-subtle);
    border-radius: var(--radius-md);
    background: var(--bg-card-solid);
    color: var(--text-primary);
    font-size: 14px;
    font-family: inherit;
    transition: all var(--transition-fast);
    outline: none;
    box-sizing: border-box;
}

.form-control:focus {
    border-color: var(--accent-blue);
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.form-select {
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 36px;
    cursor: pointer;
}

body.dark .form-select,
[data-theme="dark"] .form-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
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

.btn-primary:active {
    transform: translateY(0);
}

/* ============================================
   STATS ROW
   ============================================ */
.stats-row {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 24px;
}

@media (max-width: 1200px) {
    .stats-row {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .stats-row {
        grid-template-columns: 1fr;
    }
}

.stat-card {
    padding: 20px;
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-lg);
    transition: all var(--transition-base);
    box-shadow: var(--shadow-sm);
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
    border-color: var(--border-strong);
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

.stat-icon-sm.purple {
    background: var(--accent-purple-light);
    color: var(--accent-purple);
}

body.dark .stat-icon-sm.purple,
[data-theme="dark"] .stat-icon-sm.purple {
    background: rgba(139, 92, 246, 0.15);
}

.stat-icon-sm.amber {
    background: var(--accent-amber-light);
    color: var(--accent-amber);
}

body.dark .stat-icon-sm.amber,
[data-theme="dark"] .stat-icon-sm.amber {
    background: rgba(245, 158, 11, 0.15);
}

.stat-icon-sm.gold {
    background: var(--accent-gold-light);
    color: var(--accent-gold);
}

body.dark .stat-icon-sm.gold,
[data-theme="dark"] .stat-icon-sm.gold {
    background: rgba(234, 179, 8, 0.15);
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
    font-size: 22px;
    font-weight: 700;
    color: var(--text-primary);
    margin-bottom: 4px;
    letter-spacing: -0.02em;
}

.stat-trend {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
}

/* Highlight variants */
.stat-card.highlight-blue {
    border-color: rgba(59, 130, 246, 0.3);
    background: linear-gradient(135deg, var(--bg-card), rgba(59, 130, 246, 0.05));
}

.stat-card.highlight-green {
    border-color: rgba(16, 185, 129, 0.3);
    background: linear-gradient(135deg, var(--bg-card), rgba(16, 185, 129, 0.05));
}

.stat-card.highlight-purple {
    border-color: rgba(139, 92, 246, 0.3);
    background: linear-gradient(135deg, var(--bg-card), rgba(139, 92, 246, 0.05));
}

.stat-card.highlight-orange {
    border-color: rgba(245, 158, 11, 0.3);
    background: linear-gradient(135deg, var(--bg-card), rgba(245, 158, 11, 0.05));
}

.stat-card.highlight-gold {
    border-color: rgba(234, 179, 8, 0.3);
    background: linear-gradient(135deg, var(--bg-card), rgba(234, 179, 8, 0.05));
}

.stat-card.highlight-rose {
    border-color: rgba(244, 63, 94, 0.3);
    background: linear-gradient(135deg, var(--bg-card), rgba(244, 63, 94, 0.05));
}

/* ============================================
   CHART CARD
   ============================================ */
.chart-card {
    background: var(--bg-card);
    backdrop-filter: blur(20px);
    -webkit-backdrop-filter: blur(20px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-top: 24px;
    box-shadow: var(--shadow-sm);
}

.chart-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}

.chart-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.chart-title svg {
    color: var(--accent-blue);
}

.chart-legend {
    display: flex;
    gap: 16px;
}

.legend-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--text-muted);
}

.legend-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
}

.chart-body {
    height: 300px;
    position: relative;
}

@media (max-width: 768px) {
    .chart-body {
        height: 250px;
    }
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .page-header {
        flex-direction: column;
    }
    .filter-grid {
        grid-template-columns: 1fr;
    }
    .stats-row {
        grid-template-columns: 1fr;
    }
}
</style>