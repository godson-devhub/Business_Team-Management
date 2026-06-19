<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\Product[] $products
 */

$this->title = $branch->name . ' Products';

/* =========================
STATS CALCULATION
========================= */
$totalProducts = count($products);
$totalStockQty = 0;
$totalInventoryValue = 0;
$lowStockCount = 0;

foreach ($products as $product) {

    $totalStockQty += (int)$product->stock_quantity;

    $totalInventoryValue += (
        (int)$product->stock_quantity * (float)$product->selling_price
    );

    if ($product->stock_quantity <= $product->min_stock_alert) {
        $lowStockCount++;
    }
}
?>

<!-- =========================
BACKGROUND (SAME AS SELLER DASHBOARD)
========================= -->
<div class="background-blobs">
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
</div>

<div class="page-wrapper">

    <!-- HEADER -->
    <div class="page-header">

        <div>
            <h1 class="page-title">📦 <?= Html::encode($branch->name) ?> Products</h1>
            <p class="page-subtitle">Manage branch inventory & stock levels</p>
        </div>

        <a href="<?= Url::to(['/branch/view', 'id' => $branch->id]) ?>" class="back-btn">
            ← Back Dashboard
        </a>

    </div>

    <!-- SUMMARY CARDS -->
    <div class="summary-grid">

        <div class="summary-card">
            <div class="summary-value"><?= number_format($totalProducts) ?></div>
            <div class="summary-label">Total Products</div>
        </div>

        <div class="summary-card">
            <div class="summary-value"><?= number_format($totalStockQty) ?></div>
            <div class="summary-label">Total Stock Quantity</div>
        </div>

        <div class="summary-card">
            <div class="summary-value">
                TZS <?= number_format($totalInventoryValue, 2) ?>
            </div>
            <div class="summary-label">Inventory Value</div>
        </div>

        <div class="summary-card">
            <div class="summary-value"><?= number_format($lowStockCount) ?></div>
            <div class="summary-label">Low Stock Alerts</div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="table-card">

        <div class="table-header">
            📊 Product Inventory List
        </div>

        <?php if (!empty($products)): ?>

            <div class="table-wrap">

                <table>

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Product</th>
                            <th>Buy</th>
                            <th>Sell</th>
                            <th>Stock</th>
                            <th>Profit</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($products as $index => $product): ?>

                        <?php
                            $profit = $product->selling_price - $product->buying_price;
                            $isLow = $product->stock_quantity <= $product->min_stock_alert;
                        ?>

                        <tr>

                            <td><?= $index + 1 ?></td>

                            <td>
                                <?= Html::encode($product->name) ?>
                            </td>

                            <td>
                                TZS <?= number_format($product->buying_price, 2) ?>
                            </td>

                            <td>
                                TZS <?= number_format($product->selling_price, 2) ?>
                            </td>

                            <td>
                                <span class="badge">
                                    <?= (int)$product->stock_quantity ?>
                                </span>
                            </td>

                            <td>
                                TZS <?= number_format($profit, 2) ?>
                            </td>

                            <td>

                                <?php if ($isLow): ?>
                                    <span class="badge badge-danger">Low Stock</span>
                                <?php else: ?>
                                    <span class="badge badge-success">OK</span>
                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="empty">
                No products found in this branch yet.
            </div>

        <?php endif; ?>

    </div>

</div>

<!-- =========================
UI STYLE (MATCH SELLER DASHBOARD EXACTLY)
========================= -->
<style>

/* BODY */
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#020617,#0f172a,#1e293b);
    color:white;
}

/* BLOBS */
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
    animation:move 12s infinite alternate;
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
    from{transform:translateY(0px);}
    to{transform:translateY(50px);}
}

/* WRAPPER */
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
    margin-top:6px;
}

/* BACK BUTTON */
.back-btn{
    padding:12px 18px;
    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.1);
    border-radius:14px;
    text-decoration:none;
    color:white;
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

.summary-value{
    font-size:28px;
    font-weight:800;
    color:#38bdf8;
}

.summary-label{
    color:#94a3b8;
    margin-top:6px;
}

/* TABLE CARD */
.table-card{
    background:rgba(255,255,255,0.05);
    border-radius:22px;
    border:1px solid rgba(255,255,255,0.08);
    overflow:hidden;
    backdrop-filter:blur(18px);
}

/* HEADER */
.table-header{
    padding:18px;
    font-size:18px;
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

tbody tr:hover{
    background:rgba(255,255,255,0.04);
}

/* BADGES */
.badge{
    padding:6px 10px;
    border-radius:999px;
    background:#38bdf8;
    font-size:12px;
}

.badge-success{
    background:#22c55e;
}

.badge-danger{
    background:#ef4444;
}

/* EMPTY */
.empty{
    padding:60px;
    text-align:center;
    color:#94a3b8;
}

</style>