<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Monthly Analytics Report';

$branchOptions = ArrayHelper::map($branches, 'id', 'name');
$ajaxUrl = Url::to(['analytics/monthly-ajax']);
?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="monthly-wrapper">

    <!-- HEADER -->
    <div class="header">

        <div>
            <h1>📆 Monthly Analytics</h1>
            <p>Analyze branch performance by month</p>
        </div>

        <a href="<?= Url::to(['analytics/index']) ?>" class="back-btn">
            ← Back
        </a>

    </div>

    <!-- FILTERS -->
    <div class="filter-card">

        <div class="grid">

            <div>
                <label>Branch</label>

                <?= Html::dropDownList(
                    'branch_id',
                    $branch_id ?? '',
                    $branchOptions,
                    [
                        'class' => 'input',
                        'id' => 'branchSelect'
                    ]
                ) ?>
            </div>

            <div>
                <label>Select Month</label>

                <input type="month"
                       id="monthSelect"
                       value="<?= Html::encode($month ?? date('Y-m')) ?>"
                       class="input">
            </div>

            <div>
                <label>&nbsp;</label>

                <button type="button" class="btn" id="loadBtn">
                    Generate Report
                </button>
            </div>

        </div>

    </div>

    <!-- KPI CARDS -->
    <div class="cards">

        <div class="card blue">
            <h3>Total Sales</h3>
            <p id="totalSales">TZS 0</p>
        </div>

        <div class="card green">
            <h3>Total Profit</h3>
            <p id="totalProfit">TZS 0</p>
        </div>

        <div class="card purple">
            <h3>Transactions</h3>
            <p id="transactions">0</p>
        </div>

        <div class="card orange">
            <h3>Avg Daily Sales</h3>
            <p id="avgSales">TZS 0</p>
        </div>

    </div>

    <!-- CHART -->
    <div class="chart-card">
        <h3>📊 Monthly Sales Trend</h3>
        <canvas id="monthlyChart"></canvas>
    </div>

    <!-- TABLE -->
    <div class="table-card">
        <h3>📋 Daily Breakdown</h3>
        <div id="tableContainer"></div>
    </div>

</div>

<style>

body{
    background:#0f172a;
    font-family:Segoe UI;
    color:white;
}

.monthly-wrapper{
    padding:30px;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.back-btn{
    background:#1e293b;
    padding:10px 15px;
    border-radius:10px;
    color:white;
    text-decoration:none;
}

/* FILTER */
.filter-card{
    background:#111827;
    padding:20px;
    border-radius:15px;
    margin-bottom:20px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:15px;
}

.input{
    width:100%;
    padding:10px;
    border-radius:10px;
    background:#1e293b;
    border:none;
    color:white;
}

.btn{
    width:100%;
    padding:10px;
    border:none;
    border-radius:10px;
    background:#8b5cf6;
    color:white;
    cursor:pointer;
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:15px;
    margin-bottom:20px;
}

.card{
    background:#111827;
    padding:20px;
    border-radius:15px;
    border-left:4px solid transparent;
}

.card h3{ color:#94a3b8; }
.card p{ font-size:22px; }

.blue{border-color:#38bdf8;}
.green{border-color:#22c55e;}
.purple{border-color:#8b5cf6;}
.orange{border-color:#f97316;}

/* TABLE */
.table-card{
    background:#111827;
    padding:20px;
    border-radius:15px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:10px;
    border-bottom:1px solid rgba(255,255,255,.05);
}

th{color:#94a3b8;}

.empty{
    text-align:center;
    color:#94a3b8;
}

</style>

<script>

let chart = null;
let loading = false;

// ===========================
// LOAD MONTHLY DATA (SAFE)
// ===========================
function loadMonthlyReport(){

    if(loading) return;
    loading = true;

    $.ajax({
        url: "<?= $ajaxUrl ?>",
        type: "GET",
        data: {
            branch_id: $('#branchSelect').val(),
            month: $('#monthSelect').val()
        },
        dataType: "json",

        success: function(res){

            if(!res) return;

            // ======================
            // KPI UPDATE
            // ======================
            $('#totalSales').text('TZS ' + (res.monthlySales || 0));
            $('#totalProfit').text('TZS ' + (res.monthlyProfit || 0));
            $('#transactions').text(res.totalTransactions || 0);
            $('#avgSales').text('TZS ' + (res.avgDailySales || 0));

            // ======================
            // CHART SAFE
            // ======================
            if(chart) chart.destroy();

            chart = new Chart(document.getElementById('monthlyChart'), {
                type: 'bar',
                data: {
                    labels: res.chartLabels || [],
                    datasets: [
                        {
                            label: 'Sales',
                            data: res.chartSales || [],
                            backgroundColor: '#38bdf8'
                        },
                        {
                            label: 'Profit',
                            data: res.chartProfit || [],
                            backgroundColor: '#22c55e'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { labels: { color: '#fff' } }
                    },
                    scales: {
                        x: { ticks: { color: '#94a3b8' } },
                        y: { ticks: { color: '#94a3b8' } }
                    }
                }
            });

            // ======================
            // TABLE UPDATE SAFE
            // ======================
            let html = `<table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Sales</th>
                        <th>Profit</th>
                        <th>Transactions</th>
                    </tr>
                </thead>
                <tbody>`;

            if(res.dailyData && res.dailyData.length > 0){

                res.dailyData.forEach(row => {
                    html += `
                        <tr>
                            <td>${row.date}</td>
                            <td>TZS ${row.sales}</td>
                            <td>TZS ${row.profit}</td>
                            <td>${row.transactions}</td>
                        </tr>
                    `;
                });

            } else {
                html += `<tr><td colspan="4" class="empty">No data available</td></tr>`;
            }

            html += `</tbody></table>`;

            $('#tableContainer').html(html);
        },

        complete: function(){
            loading = false;
        },

        error: function(){
            loading = false;
        }

    });
}

// ===========================
// INIT ONLY ONCE (NO LOOP BUG)
// ===========================
$(document).ready(function(){
    loadMonthlyReport();
});

// ===========================
// BUTTON ACTION
// ===========================
$('#loadBtn').on('click', function(){
    loadMonthlyReport();
});

</script>