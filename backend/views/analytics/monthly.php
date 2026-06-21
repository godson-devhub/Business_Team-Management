<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Monthly Analytics Report';

$branchOptions = ArrayHelper::map($branches, 'id', 'name');
$ajaxUrl = Url::to(['analytics/monthly-ajax']);
?>

<div class="page-container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?= Url::to(['analytics/index']) ?>">
            <i data-lucide="chevron-left" class="icon-16"></i>
            Analytics
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Monthly Report</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Monthly Analytics</h1>
            <p class="page-subtitle">Analyze branch performance by month</p>
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
                <?= Html::dropDownList('branch_id', $branch_id ?? '', $branchOptions, [
                    'class' => 'form-control',
                    'id' => 'branchSelect'
                ]) ?>
            </div>
            <div class="filter-group">
                <label class="filter-label">
                    <i data-lucide="calendar-days" class="icon-14"></i>
                    Month
                </label>
                <input type="month" id="monthSelect" value="<?= Html::encode($month ?? date('Y-m')) ?>" class="form-control">
            </div>
            <div class="filter-group">
                <label class="filter-label">&nbsp;</label>
                <button type="button" class="btn btn-primary" id="loadBtn">
                    <i data-lucide="bar-chart-3" class="icon-16"></i>
                    Generate Report
                </button>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="stats-row">
        <div class="stat-card highlight-blue">
            <div class="stat-header">
                <span class="stat-title">Total Sales</span>
                <div class="stat-icon-sm" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                    <i data-lucide="banknote" class="icon-16"></i>
                </div>
            </div>
            <div class="stat-number" id="totalSales">TZS 0</div>
            <div class="stat-trend">Monthly revenue</div>
        </div>
        <div class="stat-card highlight-green">
            <div class="stat-header">
                <span class="stat-title">Total Profit</span>
                <div class="stat-icon-sm" style="background: rgba(34,197,94,0.15); color: #22c55e;">
                    <i data-lucide="trending-up" class="icon-16"></i>
                </div>
            </div>
            <div class="stat-number" id="totalProfit">TZS 0</div>
            <div class="stat-trend">Net earnings</div>
        </div>
        <div class="stat-card highlight-purple">
            <div class="stat-header">
                <span class="stat-title">Transactions</span>
                <div class="stat-icon-sm" style="background: rgba(139,92,246,0.15); color: #8b5cf6;">
                    <i data-lucide="receipt" class="icon-16"></i>
                </div>
            </div>
            <div class="stat-number" id="transactions">0</div>
            <div class="stat-trend">Completed sales</div>
        </div>
        <div class="stat-card highlight-orange">
            <div class="stat-header">
                <span class="stat-title">Avg Daily Sales</span>
                <div class="stat-icon-sm" style="background: rgba(245,158,11,0.15); color: #f59e0b;">
                    <i data-lucide="calculator" class="icon-16"></i>
                </div>
            </div>
            <div class="stat-number" id="avgSales">TZS 0</div>
            <div class="stat-trend">Per day average</div>
        </div>
    </div>

    <!-- Chart -->
    <div class="chart-card">
        <div class="chart-header">
            <h3 class="chart-title">
                <i data-lucide="bar-chart-3" class="icon-18"></i>
                Monthly Sales Trend
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
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>

    <!-- Data Table -->
    <div class="data-card">
        <div class="data-header">
            <h3 class="data-title">
                <i data-lucide="table" class="icon-18"></i>
                Daily Breakdown
            </h3>
        </div>
        <div class="table-responsive" id="tableContainer">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th class="text-right">Sales</th>
                        <th class="text-right">Profit</th>
                        <th class="text-center">Transactions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="4" class="empty-cell">
                            <div class="empty-inline">
                                <i data-lucide="bar-chart-3" class="icon-24"></i>
                                <span>Generate a report to see daily breakdown</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script>
let chart = null;
let loading = false;

function loadMonthlyReport() {
    if (loading) return;
    loading = true;

    $.ajax({
        url: "<?= $ajaxUrl ?>",
        type: "GET",
        data: {
            branch_id: $('#branchSelect').val(),
            month: $('#monthSelect').val()
        },
        dataType: "json",

        success: function(res) {
            if (!res) return;

            $('#totalSales').text('TZS ' + (res.monthlySales || 0));
            $('#totalProfit').text('TZS ' + (res.monthlyProfit || 0));
            $('#transactions').text(res.totalTransactions || 0);
            $('#avgSales').text('TZS ' + (res.avgDailySales || 0));

            if (chart) chart.destroy();

            chart = new Chart(document.getElementById('monthlyChart'), {
                type: 'bar',
                data: {
                    labels: res.chartLabels || [],
                    datasets: [
                        {
                            label: 'Sales',
                            data: res.chartSales || [],
                            backgroundColor: '#38bdf8',
                            borderRadius: 4
                        },
                        {
                            label: 'Profit',
                            data: res.chartProfit || [],
                            backgroundColor: '#22c55e',
                            borderRadius: 4
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

            let html = `<table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th class="text-right">Sales</th>
                        <th class="text-right">Profit</th>
                        <th class="text-center">Transactions</th>
                    </tr>
                </thead>
                <tbody>`;

            if (res.dailyData && res.dailyData.length > 0) {
                res.dailyData.forEach(row => {
                    html += `
                        <tr>
                            <td>${row.date}</td>
                            <td class="text-right mono">TZS ${row.sales}</td>
                            <td class="text-right mono">TZS ${row.profit}</td>
                            <td class="text-center">${row.transactions}</td>
                        </tr>
                    `;
                });
            } else {
                html += `<tr><td colspan="4" class="empty-cell"><div class="empty-inline"><i data-lucide="inbox" class="icon-24"></i><span>No data available</span></div></td></tr>`;
            }

            html += `</tbody></table>`;
            $('#tableContainer').html(html);
        },

        complete: function() {
            loading = false;
        },

        error: function() {
            loading = false;
        }
    });
}

$(document).ready(function() {
    loadMonthlyReport();
});

$('#loadBtn').on('click', function() {
    loadMonthlyReport();
});

if (typeof lucide !== 'undefined') lucide.createIcons();
</script>

<style>
/* Same filter, stats, chart, and table styles as daily.php and index.php */
</style>