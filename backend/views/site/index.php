<?php

use yii\helpers\Html;

$this->title = 'Dashboard';

$username = Yii::$app->user->identity?->username;

// optional safe fallback values
$totalSales = $totalSales ?? 0;
$totalProfit = $totalProfit ?? 0;
$totalBranches = $totalBranches ?? 0;
$lowStock = $lowStock ?? 0;

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* =========================
GLOBAL
========================= */
body{
    margin:0;
    font-family: Inter, sans-serif;
    background: #0f172a;
    color:white;
}

/* =========================
SIDEBAR
========================= */
.sidebar{
    position:fixed;
    left:0;
    top:0;
    width:230px;
    height:100vh;

    background:#111827;
    border-right:1px solid #1f2937;

    padding:20px;
}

.sidebar h2{
    font-size:18px;
    margin-bottom:25px;
    color:#60a5fa;
}

.sidebar a{
    display:block;
    padding:10px;
    margin:6px 0;

    color:#cbd5e1;
    text-decoration:none;
    border-radius:8px;

    transition:0.2s;
}

.sidebar a:hover{
    background:#1f2937;
    color:white;
}

/* =========================
MAIN
========================= */
.main{
    margin-left:250px;
    padding:25px;
}

/* =========================
HEADER
========================= */
.title{
    font-size:28px;
    font-weight:700;
}

.subtitle{
    color:#94a3b8;
    margin-bottom:25px;
}

/* =========================
GRID
========================= */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:15px;
}

/* =========================
CARDS (clean SaaS)
========================= */
.card{
    background:#111827;
    border:1px solid #1f2937;
    border-radius:12px;

    padding:18px;

    transition:0.2s;
}

.card:hover{
    transform:translateY(-3px);
    border-color:#3b82f6;
}

.label{
    color:#9ca3af;
    font-size:13px;
}

.value{
    font-size:22px;
    font-weight:700;
    margin-top:8px;
}

/* =========================
BUTTONS
========================= */
.actions{
    margin-top:25px;
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.btn{
    padding:10px 14px;
    border-radius:8px;
    text-decoration:none;

    background:#2563eb;
    color:white;

    font-weight:600;

    transition:0.2s;
}

.btn:hover{
    background:#1d4ed8;
}

/* =========================
CHART
========================= */
.chart-box{
    margin-top:30px;
    background:#111827;
    padding:18px;
    border-radius:12px;
    border:1px solid #1f2937;
}

/* =========================
RESPONSIVE
========================= */
@media(max-width:768px){
    .sidebar{
        display:none;
    }

    .main{
        margin-left:0;
    }
}

</style>

<!-- SIDEBAR -->
<div class="sidebar">

    <h2>⚡ Business System</h2>

    <a href="/site/index">🏠 Dashboard</a>
    <a href="/product/index">📦 Products</a>
    <a href="/sale/index">💳 Sales</a>
    <a href="/purchase/index">🛒 Purchases</a>
    <a href="/analytics/index">📊 Analytics</a>

</div>

<!-- MAIN -->
<div class="main">

    <div class="title">
        👋 Welcome, <?= Html::encode($username) ?>
    </div>

    <div class="subtitle">
        Manage your business operations in one place
    </div>

    <!-- STATS -->
    <div class="grid">

        <div class="card">
            <div class="label">Total Sales</div>
            <div class="value">TZS <?= number_format($totalSales) ?></div>
        </div>

        <div class="card">
            <div class="label">Total Profit</div>
            <div class="value">TZS <?= number_format($totalProfit) ?></div>
        </div>

        <div class="card">
            <div class="label">Branches</div>
            <div class="value"><?= $totalBranches ?></div>
        </div>

        <div class="card">
            <div class="label">Low Stock</div>
            <div class="value"><?= $lowStock ?></div>
        </div>

    </div>

    <!-- ACTIONS -->
    <div class="actions">

        <a class="btn" href="/product/create">➕ Add Product</a>

        <a class="btn" href="/sale/create">💳 New Sale</a>

        <a class="btn" href="/analytics/index">📊 Analytics</a>

    </div>

    <!-- CHART -->
    <div class="chart-box">

        <h3>📈 Sales Overview</h3>

        <canvas id="chart"></canvas>

    </div>

</div>

<script>

new Chart(document.getElementById('chart'), {

    type: 'line',

    data: {
        labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
        datasets: [{
            label: 'Sales',
            data: [10,20,15,30,40,35,50],
            borderColor: '#3b82f6',
            tension: 0.4
        }]
    },

    options: {
        plugins: {
            legend: {
                labels: { color: 'white' }
            }
        },
        scales: {
            x: { ticks: { color: 'white' } },
            y: { ticks: { color: 'white' } }
        }
    }

});

</script>