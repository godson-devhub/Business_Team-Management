<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\User[] $sellers
 * @var \common\models\Product[] $products
 * @var \common\models\Sale[] $sales
 * @var \common\models\Purchase[] $purchases
 * @var float $dailySales
 * @var float $dailyProfit
 */

$this->title = $branch->name;

// COUNTS
$sellerCount = count($sellers ?? []);
$productCount = count($products ?? []);
$purchaseCount = count($purchases ?? []);

// STOCK CALC
$totalStockValue = 0;
$lowStockCount = 0;

foreach ($products ?? [] as $p) {
    $totalStockValue += ($p->stock_quantity * $p->selling_price);

    if ($p->stock_quantity <= 5) {
        $lowStockCount++;
    }
}
?>

<style>

body{
    background: radial-gradient(circle at top, #0f172a, #020617);
    color:white;
    font-family:Segoe UI;
}

.branch-view{
    padding:40px;
}

/* HERO */
.hero{
    padding:30px;
    border-radius:24px;
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);
    backdrop-filter: blur(20px);
    margin-bottom:25px;
    transition:0.3s;
}

.hero:hover{
    transform:translateY(-3px);
}

.branch-title{
    font-size:32px;
    font-weight:800;
}

.branch-sub{
    color:#94a3b8;
    margin-top:5px;
}

/* GRID */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:15px;
    margin-top:20px;
}

/* CARD */
.card-link{
    text-decoration:none;
    color:inherit;
}

.card{
    padding:18px;
    border-radius:18px;
    background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.08);
    backdrop-filter: blur(18px);
    transition:0.3s;
    cursor:pointer;
}

.card:hover{
    transform:translateY(-6px);
    background:rgba(255,255,255,0.10);
    box-shadow:0 15px 30px rgba(0,0,0,0.3);
}

.card-value{
    font-size:24px;
    font-weight:800;
    color:#38bdf8;
}

.card-label{
    font-size:12px;
    color:#94a3b8;
}

/* GRID 2 */
.grid-2{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

@media(max-width:900px){
    .grid-2{ grid-template-columns:1fr; }
}

/* LIST */
.section{ margin-top:30px; }

.section h3{
    margin-bottom:15px;
}

.list{
    display:grid;
    gap:10px;
}

.item{
    padding:14px;
    border-radius:14px;
    background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.08);
    display:flex;
    justify-content:space-between;
    align-items:center;
    transition:0.3s;
}

.item:hover{
    transform:translateX(5px);
    background:rgba(255,255,255,0.10);
}

/* BADGES */
.badge{
    padding:4px 10px;
    border-radius:999px;
    font-size:11px;
    background:#2563eb;
    color:white;
}

.badge-red{ background:#ef4444; }
.badge-green{ background:#22c55e; }
.badge-yellow{ background:#f59e0b; }

</style>

<div class="branch-view">

    <!-- HERO -->
    <div class="hero">

        <div class="branch-title">
            🏬 <?= Html::encode($branch->name) ?>
        </div>

        <div class="branch-sub">
            📍 <?= Html::encode($branch->location ?: 'No location set') ?>
        </div>

        <!-- STATS -->
        <div class="grid">

            <a href="<?= Url::to(['/branch/sellers', 'id' => $branch->id]) ?>" class="card-link">
                <div class="card">
                    <div class="card-value"><?= $sellerCount ?></div>
                    <div class="card-label">Sellers</div>
                </div>
            </a>

            <a href="<?= Url::to(['/branch/products', 'id' => $branch->id]) ?>" class="card-link">
                <div class="card">
                    <div class="card-value"><?= $productCount ?></div>
                    <div class="card-label">Products</div>
                </div>
            </a>

            <a href="<?= Url::to(['/branch/low-stock', 'id' => $branch->id]) ?>" class="card-link">
                <div class="card">
                    <div class="card-value"><?= $lowStockCount ?></div>
                    <div class="card-label">Low Stock</div>
                </div>
            </a>

            <a href="<?= Url::to(['/branch/stock-value', 'id' => $branch->id]) ?>" class="card-link">
                <div class="card">
                    <div class="card-value">
                        TZS <?= number_format($totalStockValue) ?>
                    </div>
                    <div class="card-label">Stock Value</div>
                </div>
            </a>

            <a href="<?= Url::to(['/branch/daily-sales', 'id' => $branch->id]) ?>" class="card-link">
                <div class="card">
                    <div class="card-value">
                        TZS <?= number_format($dailySales ?? 0) ?>
                    </div>
                    <div class="card-label">Daily Sales</div>
                </div>
            </a>

            <a href="<?= Url::to(['/branch/daily-profit', 'id' => $branch->id]) ?>" class="card-link">
                <div class="card">
                    <div class="card-value">
                        TZS <?= number_format($dailyProfit ?? 0) ?>
                    </div>
                    <div class="card-label">Daily Profit</div>
                </div>
            </a>

            <!-- ✅ PURCHASES ADDED -->
            <a href="<?= Url::to(['/branch/purchases', 'id' => $branch->id]) ?>" class="card-link">
                <div class="card">
                    <div class="card-value"><?= $purchaseCount ?></div>
                    <div class="card-label">Purchases</div>
                </div>
            </a>

        </div>

    </div>

    <!-- GRID -->
    <div class="grid-2">

        <!-- SELLERS -->
        <div class="section">

            <h3>👤 Sellers</h3>

            <div class="list">
                <?php foreach ($sellers ?? [] as $s): ?>
                    <div class="item">
                        <span><?= Html::encode($s->username) ?></span>
                        <span class="badge">seller</span>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

        <!-- PRODUCTS -->
        <div class="section">

            <h3>📦 Products</h3>

            <div class="list">
                <?php foreach ($products ?? [] as $p): ?>
                    <?php $isLow = $p->stock_quantity <= 5; ?>

                    <div class="item">
                        <span><?= Html::encode($p->name) ?></span>
                        <span class="badge <?= $isLow ? 'badge-red' : 'badge-green' ?>">
                            <?= $p->stock_quantity ?> pcs
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>

    </div>

</div>