<?php

$this->title = 'Seller Dashboard';

$username = Yii::$app->user->identity->username;

?>

<style>

/* =========================
GLOBAL
========================= */

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:'Segoe UI',sans-serif;

    background:
    linear-gradient(
    135deg,
    #020617,
    #0f172a,
    #1e293b,
    #111827
    );

    background-size:400% 400%;

    animation:bgFlow 12s ease infinite;

    color:white;

    overflow-x:hidden;
}

@keyframes bgFlow{

    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}

/* =========================
GLOW BACKGROUND
========================= */

.glow-bg{

    position:fixed;

    width:100%;
    height:100%;

    z-index:-1;
}

.glow{

    position:absolute;

    width:320px;
    height:320px;

    border-radius:50%;

    filter:blur(120px);

    opacity:0.25;

    animation:floatGlow 9s infinite alternate;
}

.g1{
    background:#38bdf8;
    top:-100px;
    left:-100px;
}

.g2{
    background:#8b5cf6;
    bottom:-100px;
    right:-100px;
}

.g3{
    background:#22c55e;
    top:40%;
    left:45%;
}

@keyframes floatGlow{

    0%{transform:translate(0,0);}
    100%{transform:translate(80px,50px);}
}

/* =========================
CONTAINER
========================= */

.container{

    padding:40px;
}

/* =========================
HEADER
========================= */

.header{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:40px;
}

.title{

    font-size:42px;

    font-weight:bold;

    background:linear-gradient(
    to right,
    #38bdf8,
    #818cf8,
    #c084fc
    );

    -webkit-background-clip:text;

    -webkit-text-fill-color:transparent;
}

.subtitle{

    color:#94a3b8;

    margin-top:6px;
}

/* LIVE BADGE */

.live{

    padding:10px 18px;

    border-radius:50px;

    background:rgba(34,197,94,0.15);

    border:1px solid rgba(34,197,94,0.3);

    color:#86efac;

    animation:pulse 1.6s infinite;
}

@keyframes pulse{

    0%{transform:scale(1);}
    50%{transform:scale(1.05);}
    100%{transform:scale(1);}
}

/* =========================
GRID
========================= */

.grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(250px,1fr));

    gap:22px;
}

/* =========================
CARDS
========================= */

.card{

    position:relative;

    overflow:hidden;

    background:rgba(255,255,255,0.07);

    backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,0.1);

    border-radius:26px;

    padding:28px;

    transition:0.35s ease;

    box-shadow:0 10px 35px rgba(0,0,0,0.3);
}

.card:hover{

    transform:translateY(-10px) scale(1.03);

    box-shadow:0 25px 50px rgba(56,189,248,0.25);
}

.card::before{

    content:'';

    position:absolute;

    top:-60px;
    right:-60px;

    width:160px;
    height:160px;

    background:rgba(255,255,255,0.06);

    border-radius:50%;
}

.label{

    color:#cbd5e1;

    margin-bottom:12px;

    font-size:15px;
}

.value{

    font-size:34px;

    font-weight:bold;
}

/* =========================
COLORS
========================= */

.blue{border-left:5px solid #38bdf8;}
.green{border-left:5px solid #22c55e;}
.purple{border-left:5px solid #8b5cf6;}
.red{border-left:5px solid #ef4444;}

/* =========================
ACTIONS
========================= */

.actions{

    margin-top:40px;

    display:flex;

    flex-wrap:wrap;

    gap:18px;
}

.btn{

    padding:14px 26px;

    border-radius:16px;

    text-decoration:none;

    color:white;

    font-weight:bold;

    background:linear-gradient(
    135deg,
    #38bdf8,
    #6366f1
    );

    transition:0.3s ease;
}

.btn:hover{

    transform:translateY(-5px);

    box-shadow:0 15px 30px rgba(56,189,248,0.3);
}

/* =========================
RECENT PANEL
========================= */

.panel{

    margin-top:50px;
}

.item{

    padding:16px;

    margin-bottom:12px;

    border-radius:16px;

    background:rgba(255,255,255,0.05);

    border:1px solid rgba(255,255,255,0.08);

    display:flex;

    justify-content:space-between;

    transition:0.3s;
}

.item:hover{

    transform:translateX(8px);

    background:rgba(255,255,255,0.09);
}

/* =========================
FLOATING BOT
========================= */

.bot{

    position:fixed;

    right:20px;

    bottom:20px;

    animation:floatBot 3s infinite;
}

.bot img{

    width:120px;

    filter:drop-shadow(0 10px 20px rgba(0,0,0,0.4));
}

@keyframes floatBot{

    0%{transform:translateY(0);}
    50%{transform:translateY(-15px);}
    100%{transform:translateY(0);}
}

</style>

<!-- GLOW -->
<div class="glow-bg">

    <div class="glow g1"></div>

    <div class="glow g2"></div>

    <div class="glow g3"></div>

</div>

<div class="container">

    <!-- HEADER -->
    <div class="header">

        <div>

            <div class="title">
                🚀 Welcome <?= $username ?>
            </div>

            <div class="subtitle">
                Manage your branch operations in real time
            </div>

        </div>

        <div class="live">
            ● LIVE SYSTEM
        </div>

    </div>

    <!-- STATS -->
    <div class="grid">

        <div class="card blue">

            <div class="label">Today's Sales</div>

            <div class="value">
                TZS <?= number_format($todaySales ?? 0) ?>
            </div>

        </div>

        <div class="card green">

            <div class="label">Net Profit</div>

            <div class="value">
                TZS <?= number_format($todayProfit ?? 0) ?>
            </div>

        </div>

        <div class="card purple">

            <div class="label">Total Products</div>

            <div class="value">
                <?= $totalProducts ?>
            </div>

        </div>

        <div class="card red">

            <div class="label">Low Stock Alerts</div>

            <div class="value">
                <?= $lowStock ?>
            </div>

        </div>

    </div>

    <!-- ACTIONS -->
    <div class="actions">

        <a class="btn" href="/product/index">📦 Products</a>

        <a class="btn" href="/sale/create">💳 New Sale</a>

        <a class="btn" href="/purchase/create">🛒 Purchase</a>

        <a class="btn" href="/analytics/index">📊 Analytics</a>

    </div>

    <!-- RECENT -->
    <div class="panel">

        <h2 style="margin-bottom:15px;">🔥 Recent Products</h2>

        <?php foreach($recentProducts as $p): ?>

            <div class="item">

                <span><?= $p->name ?></span>

                <span>Stock: <?= $p->stock_quantity ?></span>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<!-- FLOATING BOT -->
<div class="bot">

    <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png">

</div>