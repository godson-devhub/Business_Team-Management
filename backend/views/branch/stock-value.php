<?php

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\StockMovement;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\Product[] $products
 */

$this->title = $branch->name . ' Stock Value (Realtime)';

/* =========================
 * TOTAL CALCULATION
 * ========================= */
$totalStockValue = 0;
$totalItems = count($products);

$stockSummary = [];

foreach ($products as $product) {

    /**
     * Realtime STOCK BALANCE using movements
     */
    $in = (int) StockMovement::find()
        ->where([
            'product_id' => $product->id,
            'type' => 'IN'
        ])
        ->sum('quantity');

    $out = (int) StockMovement::find()
        ->where([
            'product_id' => $product->id,
            'type' => 'OUT'
        ])
        ->sum('quantity');

    $currentStock = $in - $out;

    $productValue = $currentStock * $product->selling_price;

    $totalStockValue += $productValue;

    $stockSummary[] = [
        'name' => $product->name,
        'in' => $in,
        'out' => $out,
        'stock' => $currentStock,
        'price' => $product->selling_price,
        'value' => $productValue
    ];
}

?>

<style>

body{
    background: radial-gradient(circle at top,#0f172a,#020617);
    color:white;
    font-family:'Segoe UI',sans-serif;
}

.page-wrapper{
    padding:40px;
}

/* HEADER */
.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.page-title{
    font-size:34px;
    font-weight:800;
}

.page-subtitle{
    color:#94a3b8;
}

/* SUMMARY */
.summary-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.summary-card{
    padding:24px;
    border-radius:24px;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.08);
    backdrop-filter:blur(18px);
    transition:.3s;
}

.summary-card:hover{
    transform:translateY(-6px);
    background:rgba(255,255,255,.10);
}

.summary-value{
    font-size:28px;
    font-weight:800;
    color:#38bdf8;
}

/* TABLE */
.table-card{
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.08);
    border-radius:24px;
    overflow:hidden;
    backdrop-filter:blur(20px);
}

.table-header{
    padding:20px;
    font-size:20px;
    font-weight:700;
    border-bottom:1px solid rgba(255,255,255,.08);
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:16px;
    border-top:1px solid rgba(255,255,255,.05);
}

th{
    color:#cbd5e1;
    text-transform:uppercase;
    font-size:12px;
}

tbody tr:hover{
    background:rgba(255,255,255,.05);
}

.badge{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    background:#22c55e;
}

.back-btn{
    padding:12px 18px;
    border-radius:14px;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.08);
    color:white;
    text-decoration:none;
    transition:.3s;
}

.back-btn:hover{
    transform:translateY(-3px);
    background:rgba(255,255,255,.15);
}

</style>

<div class="page-wrapper">

    <!-- HEADER -->
    <div class="page-header">

        <div>
            <div class="page-title">
                📦 Realtime Stock Value
            </div>

            <div class="page-subtitle">
                <?= Html::encode($branch->name) ?>
            </div>
        </div>

        <a class="back-btn"
           href="<?= Url::to(['view','id'=>$branch->id]) ?>">
            ← Back Dashboard
        </a>

    </div>

    <!-- SUMMARY -->
    <div class="summary-grid">

        <div class="summary-card">
            <div class="summary-value">
                <?= number_format($totalItems) ?>
            </div>
            <div>Total Products</div>
        </div>

        <div class="summary-card">
            <div class="summary-value">
                TZS <?= number_format($totalStockValue) ?>
            </div>
            <div>Total Stock Value</div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="table-card">

        <div class="table-header">
            Stock Breakdown (IN / OUT / BALANCE)
        </div>

        <table>

            <thead>
                <tr>
                    <th>Product</th>
                    <th>IN</th>
                    <th>OUT</th>
                    <th>Stock</th>
                    <th>Price</th>
                    <th>Value</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($stockSummary as $row): ?>

                <tr>

                    <td><?= Html::encode($row['name']) ?></td>

                    <td><?= number_format($row['in']) ?></td>

                    <td><?= number_format($row['out']) ?></td>

                    <td>
                        <span class="badge">
                            <?= number_format($row['stock']) ?>
                        </span>
                    </td>

                    <td>
                        TZS <?= number_format($row['price']) ?>
                    </td>

                    <td>
                        TZS <?= number_format($row['value']) ?>
                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>