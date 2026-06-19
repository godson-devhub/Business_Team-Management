<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Weekly Analytics Report';

$branchOptions = ArrayHelper::map($branches, 'id', 'name');
?>

<div class="weekly-wrapper">

    <!-- HEADER -->
    <div class="header">

        <div>
            <h1>📈 Weekly Analytics</h1>
            <p>Track business performance across the week</p>
        </div>

        <a href="<?= Url::to(['analytics/index']) ?>" class="back-btn">
            ← Back
        </a>

    </div>

    <!-- FILTER -->
    <div class="filter-card">

        <div class="grid">

            <div>
                <label>Branch</label>

                <?= Html::dropDownList(
                    'branch_id',
                    $branch_id ?? null,
                    $branchOptions,
                    [
                        'class' => 'input',
                        'id' => 'branchSelect'
                    ]
                ) ?>

            </div>

            <div>
                <label>&nbsp;</label>

                <button type="button" class="btn" onclick="loadWeeklyData()">
                    Load Weekly Data
                </button>
            </div>

        </div>

    </div>

    <!-- KPI CARDS -->
    <div class="cards">

        <div class="card blue">
            <h3>Weekly Sales</h3>
            <p id="weeklySales">TZS <?= number_format($weeklySales ?? 0) ?></p>
        </div>

        <div class="card green">
            <h3>Weekly Profit</h3>
            <p id="weeklyProfit">TZS <?= number_format($weeklyProfit ?? 0) ?></p>
        </div>

        <div class="card purple">
            <h3>Total Transactions</h3>
            <p id="totalTransactions"><?= $totalTransactions ?? 0 ?></p>
        </div>

    </div>

    <!-- CHART -->
    <div class="chart-card">

        <h3>📊 Weekly Performance Trend</h3>

        <canvas id="weeklyChart"></canvas>

    </div>

    <!-- INSIGHTS -->
    <div class="insight-card">

        <h3>💡 Insights</h3>

        <ul id="insightList">

            <li>📌 Best Day: <?= $bestDay ?? 'N/A' ?></li>

            <li>📌 Lowest Day: <?= $worstDay ?? 'N/A' ?></li>

            <li>📌 Growth: <?= $growth ?? '0%' ?></li>

        </ul>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

let weeklyChart;

// ==========================
// LOAD AJAX WEEKLY DATA
// ==========================
function loadWeeklyData() {

    let branchId = $('#branchSelect').val();

    $.ajax({
        url: "<?= Url::to(['analytics/weekly']) ?>",
        type: "GET",
        data: {
            branch_id: branchId,
            ajax: 1
        },
        dataType: "json",
        success: function(res) {

            // =========================
            // UPDATE KPI
            // =========================
            $('#weeklySales').text('TZS ' + res.weeklySales);
            $('#weeklyProfit').text('TZS ' + res.weeklyProfit);
            $('#totalTransactions').text(res.totalTransactions);

            // =========================
            // UPDATE CHART
            // =========================
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
                            fill: true
                        },

                        {
                            label: 'Profit',
                            data: res.weekProfit,
                            borderColor: '#22c55e',
                            backgroundColor: 'rgba(34,197,94,0.15)',
                            tension: 0.4,
                            fill: true
                        }

                    ]

                },

                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            labels: { color: '#fff' }
                        }
                    },
                    scales: {
                        x: { ticks: { color: '#94a3b8' } },
                        y: { ticks: { color: '#94a3b8' } }
                    }
                }

            });

            // =========================
            // UPDATE INSIGHTS
            // =========================
            $('#insightList').html(`
                <li>📌 Best Day: ${res.bestDay}</li>
                <li>📌 Lowest Day: ${res.worstDay}</li>
                <li>📌 Growth: ${res.growth}</li>
            `);

        }
    });
}

// AUTO LOAD ON PAGE START
$(document).ready(function(){
    loadWeeklyData();
});

</script>

<style>

body{
    background:#0f172a;
    font-family:Segoe UI;
    color:white;
}

.weekly-wrapper{
    padding:30px;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.header p{ color:#94a3b8; }

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
    grid-template-columns:repeat(2,1fr);
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
    background:#38bdf8;
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

/* CHART */
.chart-card{
    background:#111827;
    padding:20px;
    border-radius:15px;
    margin-bottom:20px;
}

/* INSIGHTS */
.insight-card{
    background:#111827;
    padding:20px;
    border-radius:15px;
}

.insight-card ul{
    list-style:none;
    padding:0;
}

.insight-card li{
    padding:10px;
    border-bottom:1px solid rgba(255,255,255,.05);
    color:#94a3b8;
}

</style>