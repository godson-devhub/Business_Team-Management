<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\SaleItem[] $sales
 */

$this->title = $branch->name . ' Sales History';

/* =========================
   SUMMARY CALCULATIONS
========================= */

$totalItems = count($sales);

$totalQty = 0;
$totalSalesValue = 0;
$totalProfit = 0;

$todayQty = 0;
$todaySalesValue = 0;
$todayProfit = 0;

$todayStart = strtotime('today');
$todayEnd   = strtotime('tomorrow');

foreach ($sales as $item) {

    $lineTotal = $item->subtotal ?? ($item->quantity * $item->selling_price);

    $totalQty += $item->quantity;
    $totalSalesValue += $lineTotal;
    $totalProfit += ($item->profit ?? 0);

    $createdAt = $item->sale->created_at ?? 0;

    if ($createdAt >= $todayStart && $createdAt < $todayEnd) {

        $todayQty += $item->quantity;
        $todaySalesValue += $lineTotal;
        $todayProfit += ($item->profit ?? 0);
    }
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

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:15px;
    margin-bottom:30px;
}

.page-title{
    font-size:34px;
    font-weight:800;
}

.page-subtitle{
    color:#94a3b8;
    margin-top:6px;
}

.back-btn{
    padding:12px 18px;
    border-radius:14px;
    text-decoration:none;
    color:white;
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.08);
    backdrop-filter:blur(20px);
    transition:.3s;
}

.back-btn:hover{
    transform:translateY(-4px);
    background:rgba(255,255,255,.15);
}

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

.summary-label{
    margin-top:8px;
    color:#94a3b8;
}

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

.table-wrap{
    overflow:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:rgba(255,255,255,.04);
}

th{
    padding:18px;
    text-align:left;
    color:#cbd5e1;
    font-size:13px;
    text-transform:uppercase;
}

td{
    padding:18px;
    border-top:1px solid rgba(255,255,255,.05);
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

.empty{
    text-align:center;
    padding:60px;
    color:#94a3b8;
}

</style>

<div class="page-wrapper">

    <!-- HEADER -->

    <div class="page-header">

        <div>

            <div class="page-title">
                💰 Sales History
            </div>

            <div class="page-subtitle">
                <?= Html::encode($branch->name) ?>
            </div>

        </div>

        <a href="<?= Url::to(['view','id'=>$branch->id]) ?>"
           class="back-btn">
            ← Back Dashboard
        </a>

    </div>

    <!-- SUMMARY -->

    <div class="summary-grid">

        <div class="summary-card">
            <div class="summary-value">
                <?= number_format($totalItems) ?>
            </div>
            <div class="summary-label">
                Total Sales Items
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-value">
                <?= number_format($totalQty) ?>
            </div>
            <div class="summary-label">
                Total Quantity Sold
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-value">
                TZS <?= number_format($totalSalesValue) ?>
            </div>
            <div class="summary-label">
                Total Sales Value
            </div>
        </div>

        <div class="summary-card">
            <div class="summary-value">
                TZS <?= number_format($totalProfit) ?>
            </div>
            <div class="summary-label">
                Total Profit
            </div>
        </div>

    </div>

    <!-- TABLE -->

    <div class="table-card">

        <div class="table-header">
            Sales Transactions
        </div>

        <?php if (!empty($sales)): ?>

            <div class="table-wrap">

                <table>

                    <thead>

                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Selling Price</th>
                            <th>Subtotal</th>
                            <th>Profit</th>
                            <th>Sale ID</th>
                            <th>Date</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach ($sales as $item): ?>

                        <?php
                            $subtotal = $item->subtotal ?? ($item->quantity * $item->selling_price);
                        ?>

                        <tr>

                            <td>
                                <?= Html::encode($item->product->name ?? 'N/A') ?>
                            </td>

                            <td>
                                <?= $item->quantity ?>
                            </td>

                            <td>
                                TZS <?= number_format($item->selling_price) ?>
                            </td>

                            <td>
                                TZS <?= number_format($subtotal) ?>
                            </td>

                            <td>
                                TZS <?= number_format($item->profit ?? 0) ?>
                            </td>

                            <td>
                                #<?= $item->sale_id ?>
                            </td>

                            <td>
                                <?= date(
                                    'd M Y H:i',
                                    $item->sale->created_at ?? time()
                                ) ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="empty">
                💰 No sales found
            </div>

        <?php endif; ?>

    </div>

</div>