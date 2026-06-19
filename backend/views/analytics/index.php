<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Analytics Dashboard';

$branchOptions = ArrayHelper::map($branches, 'id', 'name');
?>

<div class="analytics-wrapper">

    <!-- HEADER -->
    <div class="header">

        <div>
            <h1>📊 Analytics Dashboard</h1>
            <p>Business performance overview by branch, date & trends</p>
        </div>

        <div class="nav-links">
            <a href="<?= Url::to(['analytics/daily']) ?>">Daily</a>
            <a href="<?= Url::to(['analytics/monthly']) ?>">Monthly</a>
            <a href="<?= Url::to(['analytics/weekly']) ?>">Weekly</a>
        </div>

    </div>

    <!-- FILTER -->
    <div class="filter-card">

        <div class="grid">

            <!-- BRANCH SELECT (FIX MULTI BRANCH SUPPORT) -->
            <div>
                <label>Branch</label>

                <?= Html::dropDownList(
                    'branch_id',
                    $branchId ?? null,
                    $branchOptions,
                    [
                        'class' => 'input',
                        'id' => 'branchSelect'
                    ]
                ) ?>
            </div>

            <div>
                <label>Select Date</label>
                <input type="date"
                       id="dateInput"
                       value="<?= Html::encode($selectedDate ?? date('Y-m-d')) ?>"
                       class="input">
            </div>

            <div>
                <label>Select Month</label>
                <input type="month"
                       id="monthInput"
                       value="<?= Html::encode($selectedMonth ?? date('Y-m')) ?>"
                       class="input">
            </div>

            <div>
                <label>&nbsp;</label>
                <button type="button" class="btn" id="applyBtn">
                    Apply Filters
                </button>
            </div>

        </div>

    </div>

    <!-- KPI CARDS -->
    <div class="cards">

        <div class="card blue">
            <h3>Daily Sales</h3>
            <p id="dailySales">TZS <?= number_format($dailySales ?? 0) ?></p>
        </div>

        <div class="card green">
            <h3>Daily Profit</h3>
            <p id="dailyProfit">TZS <?= number_format($dailyProfit ?? 0) ?></p>
        </div>

        <div class="card purple">
            <h3>Monthly Sales</h3>
            <p id="monthlySales">TZS <?= number_format($monthlySales ?? 0) ?></p>
        </div>

        <div class="card orange">
            <h3>Monthly Profit</h3>
            <p id="monthlyProfit">TZS <?= number_format($monthlyProfit ?? 0) ?></p>
        </div>

        <div class="card gold">
            <h3>Total Products</h3>
            <p id="totalProducts"><?= number_format($totalProducts ?? 0) ?></p>
        </div>

        <div class="card red">
            <h3>Stock Value</h3>
            <p id="stockValue">TZS <?= number_format($stockValue ?? 0) ?></p>
        </div>

    </div>

    <!-- CHART -->
    <div class="chart-box">
        <h3>📊 Quick Sales Trend</h3>
        <canvas id="chart"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

let chart = null;
let isLoading = false;
let interval = null;

/**
 * SAFE AJAX LOADER (NO LOOP / NO SPAM)
 */
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

            // UPDATE KPI SAFELY
            $('#dailySales').text('TZS ' + (res.dailySales ?? 0));
            $('#dailyProfit').text('TZS ' + (res.dailyProfit ?? 0));
            $('#monthlySales').text('TZS ' + (res.monthlySales ?? 0));
            $('#monthlyProfit').text('TZS ' + (res.monthlyProfit ?? 0));
            $('#totalProducts').text(res.totalProducts ?? 0);
            $('#stockValue').text('TZS ' + (res.stockValue ?? 0));

            // DESTROY OLD CHART (FIX MEMORY LEAK)
            if (chart !== null) {
                chart.destroy();
                chart = null;
            }

            // CREATE NEW CHART
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
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
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

/**
 * INIT ONLY ONCE (FIX LOOP ISSUE)
 */
$(document).ready(function() {

    loadAnalytics();

    // SAFE INTERVAL (NO STACKING)
    if (interval) clearInterval(interval);

    interval = setInterval(function() {
        loadAnalytics();
    }, 30000); // 30 seconds safe

});

/**
 * FILTER CHANGE (NO LOOP TRIGGER)
 */
$('#branchSelect, #dateInput, #monthInput').on('change', function() {
    loadAnalytics();
});

$('#applyBtn').on('click', function() {
    loadAnalytics();
});

/**
 * CLEANUP MEMORY
 */
$(window).on('beforeunload', function() {
    if (interval) clearInterval(interval);
});

</script>

<style>

/* GLOBAL FIX */
body{
    background:#0f172a;
    font-family:Segoe UI;
    color:white;
    margin:0;
    overflow-x:hidden; /* FIX PAGE STRETCH */
}

/* CENTER CONTENT */
.analytics-wrapper{
    padding:30px;
    max-width:1200px;
    margin:0 auto;
    box-sizing:border-box;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    margin-bottom:20px;
}

.header p{ color:#94a3b8; }

.nav-links a{
    margin-left:10px;
    color:#38bdf8;
    text-decoration:none;
}

/* FILTER GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:15px;
}

/* INPUT */
.input{
    width:100%;
    padding:10px;
    border-radius:10px;
    border:none;
    background:#1e293b;
    color:white;
}

/* BUTTON */
.btn{
    width:100%;
    padding:10px;
    border:none;
    border-radius:10px;
    background:#38bdf8;
    color:white;
    cursor:pointer;
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:15px;
}

.card{
    background:#111827;
    padding:20px;
    border-radius:15px;
}

/* CHART FIX */
.chart-box{
    background:#111827;
    padding:20px;
    border-radius:15px;
    height:350px;
    overflow:hidden;
}

canvas{
    width:100% !important;
    max-height:300px;
}

</style>