<?php

/**
 * @var float $totalSales
 * @var float $totalProfit
 * @var float $totalPurchases
 * @var int $totalProducts
 * @var int $totalBusinesses
 * @var int $totalBranches
 * @var int $totalSellers
 * @var int $lowStock
 * @var array $branches
 * @var array $businesses
 * @var \common\models\Product[] $recentProducts
 */


$this->title = 'Owner Dashboard';

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

    font-family:'Segoe UI';

    background:
    linear-gradient(
    135deg,
    #020617,
    #0f172a,
    #111827,
    #1e293b
    );

    background-size:400% 400%;

    animation:bgMove 15s ease infinite;

    color:white;

    overflow-x:hidden;
}

@keyframes bgMove{

    0%{
        background-position:0% 50%;
    }

    50%{
        background-position:100% 50%;
    }

    100%{
        background-position:0% 50%;
    }
}

/* =========================
GLOWING BACKGROUND
========================= */

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

    animation:floatGlow 10s infinite alternate;
}

.c1{
    background:#38bdf8;
    top:-100px;
    left:-100px;
}

.c2{
    background:#8b5cf6;
    bottom:-100px;
    right:-100px;
}

.c3{
    background:#06b6d4;
    top:40%;
    left:40%;
}

@keyframes floatGlow{

    0%{
        transform:translate(0,0);
    }

    100%{
        transform:translate(80px,60px);
    }
}

/* =========================
SIDEBAR
========================= */

.sidebar{

    position:fixed;

    top:0;
    left:0;

    width:270px;
    height:100vh;

    background:rgba(255,255,255,0.06);

    backdrop-filter:blur(20px);

    border-right:1px solid rgba(255,255,255,0.1);

    padding:25px;

    z-index:999;
}

.logo{

    font-size:30px;

    font-weight:bold;

    margin-bottom:40px;

    background:linear-gradient(to right,#38bdf8,#c084fc);

    -webkit-background-clip:text;

    -webkit-text-fill-color:transparent;
}

.sidebar a{

    display:flex;

    align-items:center;

    gap:12px;

    text-decoration:none;

    color:#cbd5e1;

    padding:15px;

    border-radius:16px;

    margin-bottom:12px;

    transition:0.3s ease;
}

.sidebar a:hover{

    background:rgba(255,255,255,0.1);

    transform:translateX(8px);

    color:white;

    box-shadow:0 10px 25px rgba(56,189,248,0.15);
}

/* =========================
MAIN
========================= */

.main{

    margin-left:290px;

    padding:35px;
}

/* =========================
TOPBAR
========================= */

.topbar{

    display:flex;

    justify-content:space-between;

    align-items:center;

    margin-bottom:35px;
}

.title{

    font-size:42px;

    font-weight:bold;

    background:linear-gradient(
    to right,
    #38bdf8,
    #a78bfa,
    #c084fc
    );

    -webkit-background-clip:text;

    -webkit-text-fill-color:transparent;
}

.subtitle{

    color:#94a3b8;

    margin-top:8px;
}

/* =========================
PROFILE
========================= */

.profile{

    display:flex;

    align-items:center;

    gap:15px;

    background:rgba(255,255,255,0.08);

    padding:12px 18px;

    border-radius:18px;

    backdrop-filter:blur(15px);
}

.profile img{

    width:50px;
    height:50px;

    border-radius:50%;
}

/* =========================
GRID
========================= */

.grid{

    display:grid;

    grid-template-columns:
    repeat(auto-fit,minmax(240px,1fr));

    gap:22px;
}

/* =========================
CARDS
========================= */

.card{

    position:relative;

    overflow:hidden;

    background:rgba(255,255,255,0.08);

    backdrop-filter:blur(18px);

    border:1px solid rgba(255,255,255,0.1);

    border-radius:28px;

    padding:28px;

    transition:0.35s ease;
}

.card:hover{

    transform:translateY(-12px) scale(1.03);

    box-shadow:
    0 20px 40px rgba(56,189,248,0.2);
}

.card::before{

    content:'';

    position:absolute;

    width:180px;
    height:180px;

    background:rgba(255,255,255,0.08);

    border-radius:50%;

    top:-60px;
    right:-60px;
}

/* =========================
VALUES
========================= */

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
SECTIONS
========================= */

.section{

    margin-top:45px;
}

.section h2{

    margin-bottom:20px;

    font-size:28px;
}

/* =========================
LIST ITEMS
========================= */

.item{

    background:rgba(255,255,255,0.06);

    border:1px solid rgba(255,255,255,0.08);

    padding:18px;

    border-radius:18px;

    margin-bottom:14px;

    display:flex;

    justify-content:space-between;

    align-items:center;

    transition:0.3s;
}

.item:hover{

    transform:translateX(8px);

    background:rgba(255,255,255,0.09);
}

/* =========================
BADGES
========================= */

.badge{

    padding:8px 14px;

    border-radius:30px;

    background:linear-gradient(
    135deg,
    #38bdf8,
    #8b5cf6
    );

    font-size:13px;
}

/* =========================
FLOATING CARTOON
========================= */

.assistant{

    position:fixed;

    right:20px;

    bottom:20px;

    animation:floatAssistant 3s infinite;
}

.assistant img{

    width:120px;

    filter:drop-shadow(
    0 15px 30px rgba(0,0,0,0.4)
    );
}

@keyframes floatAssistant{

    0%{
        transform:translateY(0);
    }

    50%{
        transform:translateY(-18px);
    }

    100%{
        transform:translateY(0);
    }
}

/* =========================
RESPONSIVE
========================= */

@media(max-width:900px){

    .sidebar{

        width:90px;
    }

    .sidebar a span{

        display:none;
    }

    .logo{

        font-size:18px;
    }

    .main{

        margin-left:100px;
    }
}

</style>

<!-- GLOW -->
<div class="glow">

    <div class="circle c1"></div>

    <div class="circle c2"></div>

    <div class="circle c3"></div>

</div>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="logo">
        👑 ERP Owner
    </div>

    <a href="/owner-dashboard/index">
        🏠 <span>Dashboard</span>
    </a>

    <a href="/business/index">
        🏢 <span>Businesses</span>
    </a>

    <a href="/branch/index">
        🏬 <span>Branches</span>
    </a>

    <a href="/owner-seller/index">
        👨‍💼 <span>Manage Sellers</span>

    </a>    

    <a href="/seller/index">
        👨‍💼 <span>Sellers</span>
    </a>

    <a href="/product/index">
        📦 <span>Products</span>
    </a>

    <a href="/sale/index">
        💳 <span>Sales</span>
    </a>

    <a href="/analytics/index">
        📊 <span>Analytics</span>
    </a>

</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">

        <div>

            <div class="title">
                👑 Welcome <?= $username ?>
            </div>

            <div class="subtitle">
                Manage your businesses, branches and sellers
            </div>

        </div>

        <div class="profile">

            <img src="https://i.pravatar.cc/100">

            <div>

                <strong><?= $username ?></strong>

                <div style="font-size:13px;color:#94a3b8;">
                    System Owner
                </div>

            </div>

        </div>

    </div>

    <!-- STATS -->
    <div class="grid">

        <div class="card">

            <div class="label">
                💰 Total Sales
            </div>

            <div class="value">
                TZS <?= number_format($totalSales ?? 0) ?>
            </div>

        </div>

        <div class="card">

            <div class="label">
                📈 Total Profit
            </div>

            <div class="value">
                TZS <?= number_format($totalProfit ?? 0) ?>
            </div>

        </div>

        <div class="card">

            <div class="label">
                🏢 Businesses
            </div>

            <div class="value">
                <?= count($businesses) ?>
            </div>

        </div>

        <div class="card">

            <div class="label">
                🏬 Branches
            </div>

            <div class="value">
                <?= count($branches) ?>
            </div>

        </div>

        <div class="card">

            <div class="label">
                👨‍💼 Sellers
            </div>

            <div class="value">
                <?= $totalSellers ?>
            </div>

        </div>

        <div class="card">

            <div class="label">
                ⚠ Low Stock
            </div>

            <div class="value">
                <?= $lowStock ?>
            </div>

        </div>

    </div>

    <!-- BUSINESSES -->
    <div class="section">

        <h2>🏢 Your Businesses</h2>

        <?php foreach($businesses as $b): ?>

            <div class="item">

                <span>
                    <?= $b->name ?>
                </span>

                <div class="badge">
                    Active
                </div>

            </div>

        <?php endforeach; ?>

    </div>

    <!-- BRANCHES -->
    <div class="section">

        <h2>🏬 Branch Overview</h2>

        <?php foreach($branches as $br): ?>

            <div class="item">

                <span>
                    <?= $br->name ?>
                </span>

                <div class="badge">
                    Branch
                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<!-- FLOATING ASSISTANT -->
<div class="assistant">

    <img src="https://cdn-icons-png.flaticon.com/512/4712/4712035.png">

</div>