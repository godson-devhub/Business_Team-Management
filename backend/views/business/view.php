<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Business $business
 * @var \common\models\Branch[] $branches
 */

$this->title = $business->name;

/* =========================
TOTALS (GLOBAL BUSINESS STATS)
========================= */

$totalBranches = count($branches);

$totalSellers = 0;
$totalProducts = 0;
$totalSales = 0;
$totalProfit = 0;
$totalStockValue = 0;

foreach ($branches as $branch) {
    $totalSellers += $branch->sellerCount;
    $totalProducts += $branch->productCount;
    $totalSales += $branch->totalSales;
    $totalProfit += $branch->totalProfit;
    $totalStockValue += ($branch->stockValue ?? 0); // if you later add stockValue method
}

?>

<style>

/* =========================
GLOBAL
========================= */

.business-view{
    width:95%;
}

/* =========================
HERO
========================= */

.hero-card{
    position:relative;
    overflow:hidden;

    padding:32px;
    border-radius:28px;

    background:rgba(255,255,255,.06);
    backdrop-filter:blur(24px);

    border:1px solid rgba(255,255,255,.08);

    margin-bottom:28px;

    transition:.3s;
}

.hero-card:hover{
    transform:translateY(-3px);
}

.hero-card::before{
    content:'';
    position:absolute;
    width:320px;
    height:320px;

    top:-140px;
    right:-140px;

    border-radius:50%;

    background:rgba(56,189,248,.12);
}

.business-name{
    font-size:38px;
    font-weight:800;

    background:linear-gradient(135deg,#38bdf8,#818cf8);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.business-desc{
    color:#94a3b8;
    margin-top:6px;
}

/* =========================
STATS GRID
========================= */

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:14px;
    margin-top:22px;
}

.stat-card{
    padding:18px;
    border-radius:18px;

    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.08);

    transition:.3s;
}

.stat-card:hover{
    transform:translateY(-6px);
    background:rgba(255,255,255,.08);
}

.stat-value{
    font-size:24px;
    font-weight:800;
    color:#38bdf8;
}

.stat-label{
    font-size:12px;
    color:#94a3b8;
}

/* =========================
SECTION HEADER
========================= */

.section-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin:20px 0;
}

.section-title{
    font-size:26px;
    font-weight:700;
}

.create-btn{
    padding:10px 16px;
    border-radius:12px;

    text-decoration:none;
    color:white;

    background:linear-gradient(135deg,#2563eb,#7c3aed);

    transition:.3s;
}

.create-btn:hover{
    transform:translateY(-3px);
    color:white;
}

/* =========================
BRANCH GRID
========================= */

.branch-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(300px,1fr));
    gap:18px;
}

/* =========================
BRANCH CARD (CLICKABLE)
========================= */

.branch-card{
    display:block;
    text-decoration:none;
    color:white;

    padding:20px;
    border-radius:22px;

    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.08);

    backdrop-filter:blur(18px);

    transition:.3s;

    position:relative;
    overflow:hidden;
}

.branch-card:hover{
    transform:translateY(-8px);
    background:rgba(255,255,255,.08);
    box-shadow:0 18px 40px rgba(0,0,0,.3);
}

.branch-name{
    font-size:20px;
    font-weight:700;
}

.branch-location{
    font-size:13px;
    color:#94a3b8;
    margin:6px 0 14px;
}

/* =========================
MINI STATS
========================= */

.branch-stats{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:10px;
}

.mini-box{
    padding:12px;
    border-radius:14px;

    background:rgba(255,255,255,.04);
    text-align:center;
}

.mini-number{
    font-size:18px;
    font-weight:700;
    color:#38bdf8;
}

.mini-label{
    font-size:11px;
    color:#94a3b8;
}

/* =========================
ACTIONS
========================= */

.branch-actions{
    display:flex;
    gap:10px;
    margin-top:14px;
}

.action-btn{
    font-size:12px;
    padding:8px 12px;
    border-radius:10px;
    text-decoration:none;
}

.edit{
    background:rgba(59,130,246,.15);
    color:#60a5fa;
}

.delete{
    background:rgba(239,68,68,.15);
    color:#f87171;
}

/* prevent click blocking */
.action-btn:hover{
    opacity:.85;
}

</style>

<div class="business-view">

    <!-- ================= HERO ================= -->
    <div class="hero-card">

        <div class="business-name">
            <?= Html::encode($business->name) ?>
        </div>

        <div class="business-desc">
            <?= Html::encode($business->description) ?>
        </div>

        <!-- GLOBAL STATS -->
        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-value"><?= $totalBranches ?></div>
                <div class="stat-label">Branches</div>
            </div>

            <div class="stat-card">
                <div class="stat-value"><?= $totalSellers ?></div>
                <div class="stat-label">Sellers</div>
            </div>

            <div class="stat-card">
                <div class="stat-value"><?= $totalProducts ?></div>
                <div class="stat-label">Products</div>
            </div>

            <div class="stat-card">
                <div class="stat-value"><?= number_format($totalSales) ?></div>
                <div class="stat-label">Total Sales</div>
            </div>

            <div class="stat-card">
                <div class="stat-value"><?= number_format($totalProfit) ?></div>
                <div class="stat-label">Total Profit</div>
            </div>

            <div class="stat-card">
                <div class="stat-value"><?= number_format($totalStockValue) ?></div>
                <div class="stat-label">Stock Value</div>
            </div>

        </div>
    </div>

    <!-- ================= BRANCH HEADER ================= -->
    <div class="section-header">

        <div class="section-title">Branches</div>

        <a href="<?= Url::to(['/branch/create', 'business_id' => $business->id]) ?>"
           class="create-btn">
            + Create Branch
        </a>

    </div>

    <!-- ================= BRANCH LIST ================= -->
    <div class="branch-grid">

        <?php foreach ($branches as $branch): ?>

            <a href="<?= Url::to(['/branch/view', 'id' => $branch->id]) ?>"
               class="branch-card">

                <div class="branch-name">
                    <?= Html::encode($branch->name) ?>
                </div>

                <div class="branch-location">
                    📍 <?= Html::encode($branch->location ?: 'No location') ?>
                </div>

                <!-- MINI STATS -->
                <div class="branch-stats">

                    <div class="mini-box">
                        <div class="mini-number"><?= $branch->sellerCount ?></div>
                        <div class="mini-label">Sellers</div>
                    </div>

                    <div class="mini-box">
                        <div class="mini-number"><?= $branch->productCount ?></div>
                        <div class="mini-label">Products</div>
                    </div>

                    <div class="mini-box">
                        <div class="mini-number"><?= $branch->lowStockCount ?></div>
                        <div class="mini-label">Low Stock</div>
                    </div>

                </div>

                <!-- ACTIONS -->
                <div class="branch-actions">

                    <a class="action-btn edit"
                       href="<?= Url::to(['/branch/update', 'id' => $branch->id]) ?>"
                       onclick="event.stopPropagation();">
                        Edit
                    </a>

                    <a class="action-btn delete"
                       href="<?= Url::to(['/branch/delete', 'id' => $branch->id]) ?>"
                       onclick="event.stopPropagation(); return confirm('Delete branch?')">
                        Delete
                    </a>

                </div>

            </a>

        <?php endforeach; ?>

    </div>

</div>