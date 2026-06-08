<?php

use yii\helpers\Html;

$this->title = 'Dashboard';

$username = Yii::$app->user->identity?->username;

?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

/* ================= GLOBAL ================= */

body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#020617,#0f172a,#1e293b);
    color:white;
    overflow-x:hidden;
}

/* ================= SIDEBAR ================= */

.sidebar{
    position:fixed;
    top:0;
    left:0;
    width:240px;
    height:100vh;
    background:rgba(255,255,255,0.05);
    backdrop-filter:blur(20px);
    border-right:1px solid rgba(255,255,255,0.1);
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
    background:rgba(255,255,255,0.1);
    transform:translateX(5px);
    color:white;
}

/* ================= MAIN ================= */

.main{
    margin-left:260px;
    padding:30px;
}

/* ================= BACKGROUND ================= */

.glow{
    position:fixed;
    width:100%;
    height:100%;
    z-index:-1;
}

.circle{
    position:absolute;
    width:300px;
    height:300px;
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

/* ================= HEADER ================= */

.title{
    font-size:38px;
    font-weight:bold;
    margin-bottom:10px;
    background:linear-gradient(to right,#38bdf8,#a78bfa,#c084fc);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.subtitle{
    color:#94a3b8;
    margin-bottom:30px;
}

/* ================= CARDS ================= */

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
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

/* ================= VALUE ================= */

.value{
    font-size:28px;
    font-weight:bold;
}

.label{
    color:#94a3b8;
}

/* ================= QUICK ACTIONS ================= */

.actions{
    margin-top:30px;
    display:flex;
    gap:15px;
    flex-wrap:wrap;
}

.btn{
    padding:12px 18px;
    border-radius:14px;
    text-decoration:none;
    color:white;
    background:linear-gradient(135deg,#38bdf8,#6366f1);
    transition:0.3s;
    font-weight:bold;
}

.btn:hover{
    transform:translateY(-5px);
    box-shadow:0 15px 30px rgba(56,189,248,0.3);
}

/* ================= CHART ================= */

.chart-box{
    margin-top:40px;
    background:rgba(255,255,255,0.05);
    padding:20px;
    border-radius:20px;
    backdrop-filter:blur(15px);
}

/* ================= FLOATING CARTOON ================= */

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

</style>

<!-- BACKGROUND GLOW -->
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

    <div class="title">
        👋 Welcome, <?= Html::encode($username) ?>
    </div>

    <div class="subtitle">
        Your Business Workflow & Management System Dashboard
    </div>

    <!-- STATS -->
    <div class="grid">

        <div class="card">
            <div class="label">Total Sales</div>
            <div class="value">TZS 0</div>
        </div>

        <div class="card">
            <div class="label">Total Profit</div>
            <div class="value">TZS 0</div>
        </div>

        <div class="card">
            <div class="label">Branches</div>
            <div class="value">0</div>
        </div>

        <div class="card">
            <div class="label">Low Stock Alerts</div>
            <div class="value">0</div>
        </div>

    </div>

    <!-- QUICK ACTIONS -->
    <div class="actions">

        <a class="btn" href="/product/create">➕ Add Product</a>

        <a class="btn" href="/sale/create">💳 New Sale</a>

        <a class="btn" href="/analytics/index">📊 View Analytics</a>

    </div>

    <!-- CHART -->
    <div class="chart-box">

        <h3>📈 Sales Overview</h3>

        <canvas id="chart"></canvas>

    </div>

</div>

<!-- FLOATING CARTOON -->
<div class="cartoon">

    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png">

</div>

<script>

new Chart(document.getElementById('chart'), {

    type:'line',

    data:{

        labels:['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],

        datasets:[{

            label:'Sales',

            data:[10,20,15,30,40,35,50],

            borderColor:'#38bdf8',

            tension:0.4

        }]

    },

    options:{

        plugins:{legend:{labels:{color:'white'}}},

        scales:{
            x:{ticks:{color:'white'}},
            y:{ticks:{color:'white'}}
        }

    }

});

</script>