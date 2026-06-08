<?php
/**
 * @var float $totalSales
 * @var float $totalProfit
 * @var float $totalPurchases
 * @var int $totalProducts
 * @var int $lowStock
 * @var array $salesData
 * @var array $profitData
 * @var \common\models\Product[] $topProducts
 * @var \common\models\Product[] $lowStockProducts
 */


$this->title = 'Analytics Dashboard';

$salesLabels = [];
$salesValues = [];
$profitValues = [];

if (isset($salesData)) {
    foreach ($salesData as $row) {
        $salesLabels[] = $row['date'];
        $salesValues[] = $row['total'];
    }
}

if (isset($profitData)) {
    foreach ($profitData as $row) {
        $profitValues[] = $row['total'];
    }
}

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* ========== GLOBAL ========== */

body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#020617,#0f172a,#1e293b);
    color:white;
    overflow-x:hidden;
}

/* ========== SIDEBAR ========== */

.sidebar{
    position:fixed;
    top:0;
    left:0;
    width:240px;
    height:100vh;
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(20px);
    border-right:1px solid rgba(255,255,255,0.08);
    padding:20px;
}

.sidebar h2{
    font-size:20px;
    margin-bottom:30px;
    background:linear-gradient(to right,#38bdf8,#a78bfa);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.sidebar a{
    display:block;
    padding:12px;
    margin:8px 0;
    color:#cbd5e1;
    text-decoration:none;
    border-radius:10px;
    transition:0.3s;
}

.sidebar a:hover{
    background:rgba(255,255,255,0.08);
    transform:translateX(5px);
    color:white;
}

/* ========== MAIN ========== */

.main{
    margin-left:260px;
    padding:30px;
}

/* ========== BACKGROUND GLOW ========== */

.glow{
    position:fixed;
    width:100%;
    height:100%;
    z-index:-1;
}

.circle{
    position:absolute;
    width:350px;
    height:350px;
    border-radius:50%;
    filter:blur(120px);
    opacity:0.25;
    animation:move 10s infinite alternate;
}

.c1{background:#38bdf8; top:-120px; left:-120px;}
.c2{background:#8b5cf6; bottom:-120px; right:-120px;}

@keyframes move{
    0%{transform:translate(0,0);}
    100%{transform:translate(80px,50px);}
}

/* ========== TITLE ========== */

.title{
    font-size:38px;
    font-weight:bold;
    margin-bottom:20px;
    background:linear-gradient(to right,#38bdf8,#a78bfa,#c084fc);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

/* ========== CARDS ========== */

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-top:20px;
}

.card{
    background:rgba(255,255,255,0.07);
    border:1px solid rgba(255,255,255,0.1);
    backdrop-filter:blur(18px);
    border-radius:20px;
    padding:20px;
    transition:0.3s;
    position:relative;
    overflow:hidden;
}

.card:hover{
    transform:translateY(-10px) scale(1.02);
    box-shadow:0 20px 40px rgba(56,189,248,0.2);
}

.card::before{
    content:'';
    position:absolute;
    width:120px;
    height:120px;
    background:rgba(255,255,255,0.08);
    border-radius:50%;
    top:-40px;
    right:-40px;
}

/* ========== VALUES ========== */

.value{
    font-size:28px;
    font-weight:bold;
}

.label{
    color:#94a3b8;
}

/* ========== LIST ========== */

.list{
    margin-top:40px;
}

.product{
    padding:15px;
    margin:10px 0;
    background:rgba(255,255,255,0.05);
    border-radius:12px;
    display:flex;
    justify-content:space-between;
    transition:0.3s;
}

.product:hover{
    background:rgba(255,255,255,0.1);
    transform:scale(1.01);
}

/* ========== CHART BOX ========== */

.chart-box{
    margin-top:40px;
    background:rgba(255,255,255,0.05);
    padding:20px;
    border-radius:20px;
    backdrop-filter:blur(15px);
}

/* ========== FLOATING ICON ========== */

.cartoon{
    position:fixed;
    bottom:20px;
    right:20px;
    animation:float 3s infinite;
}

.cartoon img{
    width:110px;
}

@keyframes float{
    0%{transform:translateY(0);}
    50%{transform:translateY(-15px);}
    100%{transform:translateY(0);}
}

/* ========================= */
/* 🚨 STOCK ALERT (ADDED) */
/* ========================= */

.alert-box{
    margin-top:35px;
    padding:20px;
    border-radius:18px;
    background:rgba(255,255,255,0.06);
    backdrop-filter:blur(18px);
    border:1px solid rgba(255,255,255,0.1);
}

.alert-title{
    font-size:22px;
    margin-bottom:15px;
    color:#fbbf24;
}

.alert-item{
    padding:12px;
    margin:8px 0;
    border-radius:12px;
    display:flex;
    justify-content:space-between;
    background:rgba(255,255,255,0.04);
    transition:0.3s;
}

.alert-item:hover{
    transform:scale(1.02);
    background:rgba(255,255,255,0.08);
}

.low{
    border-left:4px solid #facc15;
}

.out{
    border-left:4px solid #ef4444;
}

</style>

<!-- GLOW BACKGROUND -->
<div class="glow">
    <div class="circle c1"></div>
    <div class="circle c2"></div>
</div>

<!-- SIDEBAR -->
<div class="sidebar">

    <h2>⚡ BM System</h2>

    <a href="/site/index">🏠 Dashboard</a>
    <a href="/product/index">📦 Products</a>
    <a href="/sale/index">💳 Sales</a>
    <a href="/purchase/index">🛒 Purchases</a>
    <a href="/analytics/index">📊 Analytics</a>

</div>

<!-- MAIN -->
<div class="main">

    <div class="title">📊 Analytics Dashboard</div>

    <!-- CARDS -->
    <div class="grid">

        <div class="card">
            <div class="label">Total Sales</div>
            <div class="value">TZS <?= number_format($totalSales ?? 0) ?></div>
        </div>

        <div class="card">
            <div class="label">Total Profit</div>
            <div class="value">TZS <?= number_format($totalProfit ?? 0) ?></div>
        </div>

        <div class="card">
            <div class="label">Purchases</div>
            <div class="value">TZS <?= number_format($totalPurchases ?? 0) ?></div>
        </div>

        <div class="card">
            <div class="label">Products</div>
            <div class="value"><?= $totalProducts ?></div>
        </div>

        <div class="card">
            <div class="label">Low Stock</div>
            <div class="value"><?= $lowStock ?></div>
        </div>

    </div>

    <!-- 🚨 STOCK ALERT SECTION (NEW) -->
    <div class="alert-box">

        <div class="alert-title">🚨 Stock Alerts</div>

        <?php if (!empty($lowStockProducts)): ?>
            <?php foreach ($lowStockProducts as $p): ?>
                <div class="alert-item low">
                    <span><?= $p->name ?></span>
                    <span>LOW: <?= $p->stock_quantity ?></span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="alert-item">
                <span>All stock levels are healthy ✅</span>
            </div>
        <?php endif; ?>

        <?php if (!empty($outStockProducts)): ?>
            <?php foreach ($outStockProducts as $p): ?>
                <div class="alert-item out">
                    <span><?= $p->name ?></span>
                    <span>OUT OF STOCK ❌</span>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

    </div>

    <!-- TOP PRODUCTS -->
    <div class="list">

        <h2>🔥 Top Products</h2>

        <?php foreach($topProducts as $p): ?>

            <div class="product">
                <span><?= $p->name ?></span>
                <span>Stock: <?= $p->stock_quantity ?></span>
            </div>

        <?php endforeach; ?>

    </div>

    <!-- CHART -->
    <div class="chart-box">

        <h2>📈 Sales vs Profit Trends</h2>

        <canvas id="chart"></canvas>

    </div>

</div>

<!-- FLOAT CARTOON -->
<div class="cartoon">
    <img src="https://cdn-icons-png.flaticon.com/512/4712/4712035.png">
</div>

<script>

new Chart(document.getElementById('chart'), {

    type:'line',

    data:{

        labels:<?= json_encode($salesLabels) ?>,

        datasets:[

            {
                label:'Sales',
                data:<?= json_encode($salesValues) ?>,
                borderColor:'#38bdf8',
                tension:0.4
            },

            {
                label:'Profit',
                data:<?= json_encode($profitValues) ?>,
                borderColor:'#a78bfa',
                tension:0.4
            }

        ]

    },

    options:{

        responsive:true,

        plugins:{
            legend:{
                labels:{color:'white'}
            }
        },

        scales:{
            x:{ticks:{color:'white'}},
            y:{ticks:{color:'white'}}
        }

    }

});

</script>