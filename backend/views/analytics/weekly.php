<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Weekly Analytics Report';

$branchOptions = ArrayHelper::map($branches, 'id', 'name');
?>

<div class="page-container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?= Url::to(['analytics/index']) ?>">
            <i data-lucide="chevron-left" class="icon-16"></i>
            Analytics
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Weekly Report</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Weekly Analytics</h1>
            <p class="page-subtitle">Track business performance across the week</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <div class="filter-grid">
            <div class="filter-group">
                <label class="filter-label">
                    <i data-lucide="git-branch" class="icon-14"></i>
                    Branch
                </label>
                <?= Html::dropDownList('branch_id', $branch_id ?? null, $branchOptions, [
                    'class' => 'form-control',
                    'id' => 'branchSelect'
                ]) ?>
            </div>
            <div class="filter-group">
                <label class="filter-label">&nbsp;</label>
                <button type="button" class="btn btn-primary" onclick="loadWeeklyData()">
                    <i data-lucide="refresh-cw" class="icon-16"></i>
                    Load Weekly Data
                </button>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="stats-row">
        <div class="stat-card highlight-blue">
            <div class="stat-header">
                <span class="stat-title">Weekly Sales</span>
                <div class="stat-icon-sm" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                    <i data-lucide="banknote" class="icon-16"></i>
                </div>
            </div>
            <div class="stat-number" id="weeklySales">TZS <?= number_format($weeklySales ?? 0) ?></div>
            <div class="stat-trend">This week</div>
        </div>
        <div class="stat-card highlight-green">
            <div class="stat-header">
                <span class="stat-title">Weekly Profit</span>
                <div class="stat-icon-sm" style="background: rgba(34,197,94,0.15); color: #22c55e;">
                    <i data-lucide="trending-up" class="icon-16"></i>
                </div>
            </div>
            <div class="stat-number" id="weeklyProfit">TZS <?= number_format($weeklyProfit ?? 0) ?></div>
            <div class="stat-trend">Net earnings</div>
        </div>
        <div class="stat-card highlight-purple">
            <div class="stat-header">
                <span class="stat-title">Total Transactions</span>
                <div class="stat-icon-sm" style="background: rgba(139,92,246,0.15); color: #8b5cf6;">
                    <i data-lucide="receipt" class="icon-16"></i>
                </div>
            </div>
            <div class="stat-number" id="totalTransactions"><?= $totalTransactions ?? 0 ?></div>
            <div class="stat-trend">Completed sales</div>
        </div>
    </div>

    <!-- Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">
                <i data-lucide="line-chart" class="icon-18"></i>
                Weekly Performance Trend
            </h3>
            <div class="chart-legend">
                <span class="legend-item">
                    <span class="legend-dot" style="background: #38bdf8;"></span>
                    Sales
                </span>
                <span class="legend-item">
                    <span class="legend-dot" style="background: #22c55e;"></span>
                    Profit
                </span>
            </div>
        </div>
        <div class="chart-body">
            <canvas id="weeklyChart"></canvas>
        </div>
    </div>

    <!-- Insights -->
    <div class="insights-card">
        <h3 class="insights-title">
            <i data-lucide="lightbulb" class="icon-18"></i>
            Insights
        </h3>
        <ul class="insights-list" id="insightList">
            <li class="insight-item">
                <i data-lucide="trending-up" class="icon-16" style="color: #22c55e;"></i>
                <span class="insight-label">Best Day:</span>
                <span class="insight-value"><?= $bestDay ?? 'N/A' ?></span>
            </li>
            <li class="insight-item">
                <i data-lucide="trending-down" class="icon-16" style="color: #ef4444;"></i>
                <span class="insight-label">Lowest Day:</span>
                <span class="insight-value"><?= $worstDay ?? 'N/A' ?></span>
            </li>
            <li class="insight-item">
                <i data-lucide="percent" class="icon-16" style="color: #f59e0b;"></i>
                <span class="insight-label">Growth:</span>
                <span class="insight-value"><?= $growth ?? '0%' ?></span>
            </li>
        </ul>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
let weeklyChart = null;

function loadWeeklyData() {
    let branchId = $('#branchSelect').val();

    $.ajax({
        url: "<?= Url::to(['analytics/weekly']) ?>",
        type: "GET",
        data: { branch_id: branchId, ajax: 1 },
        dataType: "json",
        success: function(res) {
            $('#weeklySales').text('TZS ' + res.weeklySales);
            $('#weeklyProfit').text('TZS ' + res.weeklyProfit);
            $('#totalTransactions').text(res.totalTransactions);

            if (weeklyChart) {
                weeklyChart.destroy();
            }

            weeklyChart = new Chart(document.getElementById('weeklyChart'), {
                type: 'line',
                data: {
                    labels: res.weekLabels,
                    datasets: [
                        {
                            label: 'Sales',
                            data: res.weekSales,
                            borderColor: '#38bdf8',
                            backgroundColor: 'rgba(56,189,248,0.15)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        },
                        {
                            label: 'Profit',
                            data: res.weekProfit,
                            borderColor: '#22c55e',
                            backgroundColor: 'rgba(34,197,94,0.15)',
                            tension: 0.4,
                            fill: true,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }
                    ]
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

            $('#insightList').html(`
                <li class="insight-item">
                    <i data-lucide="trending-up" class="icon-16" style="color: #22c55e;"></i>
                    <span class="insight-label">Best Day:</span>
                    <span class="insight-value">${res.bestDay}</span>
                </li>
                <li class="insight-item">
                    <i data-lucide="trending-down" class="icon-16" style="color: #ef4444;"></i>
                    <span class="insight-label">Lowest Day:</span>
                    <span class="insight-value">${res.worstDay}</span>
                </li>
                <li class="insight-item">
                    <i data-lucide="percent" class="icon-16" style="color: #f59e0b;"></i>
                    <span class="insight-label">Growth:</span>
                    <span class="insight-value">${res.growth}</span>
                </li>
            `);
        }
    });
}

$(document).ready(function() {
    loadWeeklyData();
});

if (typeof lucide !== 'undefined') lucide.createIcons();
</script>

<style>
/* ============================================
   INSIGHTS CARD
   ============================================ */
.insights-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-top: 24px;
}

.insights-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 600;
    color: var(--text);
    margin: 0 0 20px 0;
}

.insights-title i {
    color: #f59e0b;
}

.insights-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.insight-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border-radius: var(--radius);
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    transition: all 0.2s ease;
}

.insight-item:hover {
    background: var(--surface-hover);
    transform: translateX(4px);
}

.insight-label {
    font-size: 13px;
    color: var(--text-muted);
    font-weight: 500;
}

.insight-value {
    margin-left: auto;
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
    font-family: 'JetBrains Mono', monospace;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .insights-list {
        gap: 8px;
    }
    .insight-item {
        flex-wrap: wrap;
    }
    .insight-value {
        margin-left: 32px;
        width: 100%;
    }
}
</style>