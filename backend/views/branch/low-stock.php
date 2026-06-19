<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\Product[] $products
 */

$this->title = $branch->name . ' Low Stock Products';

/* =========================
STATS
========================= */
$totalLowStock = count($products);
$criticalCount = 0;
$warningCount = 0;

foreach ($products as $product) {

    // USE DB THRESHOLD (IMPORTANT FIX)
    $threshold = (int)$product->min_stock_alert;

    if ($product->stock_quantity <= 2) {
        $criticalCount++;
    } else {
        $warningCount++;
    }
}
?>

<!-- =========================
BACKGROUND (MATCH SELLER DASHBOARD)
========================= -->
<div class="background-blobs">
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
</div>

<div class="page-wrapper">

    <!-- HEADER -->
    <div class="page-header">

        <div>
            <h1 class="page-title">⚠️ Low Stock Products</h1>
            <p class="page-subtitle"><?= Html::encode($branch->name) ?></p>
        </div>

        <a href="<?= Url::to(['/branch/view', 'id' => $branch->id]) ?>" class="back-btn">
            ← Back Dashboard
        </a>

    </div>

    <!-- SUMMARY -->
    <div class="summary-grid">

        <div class="summary-card">
            <div class="summary-value" style="color:#38bdf8;">
                <?= $totalLowStock ?>
            </div>
            <div class="summary-label">Low Stock Products</div>
        </div>

        <div class="summary-card">
            <div class="summary-value" style="color:#ef4444;">
                <?= $criticalCount ?>
            </div>
            <div class="summary-label">Critical (0–2)</div>
        </div>

        <div class="summary-card">
            <div class="summary-value" style="color:#f59e0b;">
                <?= $warningCount ?>
            </div>
            <div class="summary-label">Warning (3–Threshold)</div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="table-card">

        <div class="table-header">
            📦 Products Requiring Restock
        </div>

        <?php if (!empty($products)): ?>

            <div class="table-wrap">

                <table>

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Stock</th>
                            <th>Threshold</th>
                            <th>Buy Price</th>
                            <th>Sell Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($products as $index => $product): ?>

                        <?php
                            $threshold = (int)$product->min_stock_alert;
                            $isCritical = $product->stock_quantity <= 2;
                        ?>

                        <tr>

                            <td><?= $index + 1 ?></td>

                            <td><?= Html::encode($product->name) ?></td>

                            <td>
                                <span class="badge">
                                    <?= (int)$product->stock_quantity ?>
                                </span>
                            </td>

                            <td>
                                <?= $threshold ?>
                            </td>

                            <td>
                                TZS <?= number_format($product->buying_price, 2) ?>
                            </td>

                            <td>
                                TZS <?= number_format($product->selling_price, 2) ?>
                            </td>

                            <td>

                                <?php if ($isCritical): ?>
                                    <span class="badge badge-critical">Critical</span>
                                <?php else: ?>
                                    <span class="badge badge-warning">Warning</span>
                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="empty">
                🎉 No low stock products found
            </div>

        <?php endif; ?>

    </div>

</div>

<!-- =========================
STYLE (MATCH SELLER DASHBOARD EXACTLY)
========================= -->
<style>

/* BODY */
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#020617,#0f172a,#1e293b);
    color:white;
}

/* BACKGROUND BLOBS */
.background-blobs{
    position:fixed;
    width:100%;
    height:100%;
    z-index:-1;
}

.blob{
    position:absolute;
    border-radius:50%;
    filter:blur(90px);
    opacity:0.35;
    animation:move 12s infinite alternate ease-in-out;
}

.blob1{
    width:300px;height:300px;
    background:#38bdf8;
    top:-50px;left:-50px;
}

.blob2{
    width:250px;height:250px;
    background:#8b5cf6;
    bottom:-50px;right:-50px;
}

@keyframes move{
    from{transform:translateY(0);}
    to{transform:translateY(50px);}
}

/* PAGE */
.page-wrapper{
    padding:40px;
}

/* HEADER */
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:10px;
}

.page-title{
    font-size:32px;
    font-weight:800;
}

.page-subtitle{
    color:#94a3b8;
    margin-top:5px;
}

/* BACK BUTTON */
.back-btn{
    padding:12px 18px;
    border-radius:14px;
    text-decoration:none;
    color:white;
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.1);
    transition:0.3s;
}

.back-btn:hover{
    transform:translateY(-3px);
}

/* SUMMARY */
.summary-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.summary-card{
    padding:22px;
    border-radius:22px;
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);
    backdrop-filter:blur(18px);
}

/* TABLE CARD */
.table-card{
    background:rgba(255,255,255,0.05);
    border-radius:22px;
    overflow:hidden;
    border:1px solid rgba(255,255,255,0.08);
    backdrop-filter:blur(18px);
}

.table-header{
    padding:18px;
    font-weight:700;
    border-bottom:1px solid rgba(255,255,255,0.08);
}

/* TABLE */
.table-wrap{overflow:auto;}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:14px;
    border-bottom:1px solid rgba(255,255,255,0.06);
}

thead{
    background:rgba(255,255,255,0.04);
}

/* BADGES */
.badge{
    padding:6px 10px;
    border-radius:999px;
    background:#38bdf8;
    font-size:12px;
}

.badge-critical{
    background:#ef4444;
}

.badge-warning{
    background:#f59e0b;
}

/* EMPTY */
.empty{
    padding:60px;
    text-align:center;
    color:#94a3b8;
}

</style>