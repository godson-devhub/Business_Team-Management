<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\SaleItem[] $sales
 * @var float $totalProfit
 */

$this->title = $branch->name . ' Daily Profit';

/* =========================
 * BASIC CALCULATIONS
 * ========================= */

$totalItems = count($sales);

$totalRevenue = 0;

foreach ($sales as $item) {
    $totalRevenue += ($item->quantity * $item->selling_price);
}

?>

<style>

/* =========================
GLOBAL THEME
========================= */

body{
    background: radial-gradient(circle at top,#0f172a,#020617);
    color:white;
    font-family:'Segoe UI',sans-serif;
}

/* =========================
PAGE
========================= */

.page-wrapper{
    padding:40px;
}

/* =========================
HEADER
========================= */

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

/* =========================
SUMMARY CARDS
========================= */

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
    font-size:30px;
    font-weight:800;
    color:#a855f7;
}

.summary-label{
    margin-top:8px;
    color:#94a3b8;
}

/* =========================
TABLE
========================= */

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

/* =========================
BADGES
========================= */

.badge{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.badge-profit{
    background:#a855f7;
}

.badge-green{
    background:#22c55e;
}

.badge-blue{
    background:#3b82f6;
}

/* =========================
EMPTY
========================= */

.empty{
    padding:70px;
    text-align:center;
    color:#94a3b8;
}

</style>

<div class="page-wrapper">

    <!-- HEADER -->
    <div class="page-header">

        <div>
            <div class="page-title">
                📈 Daily Profit
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
            <div class="summary-label">Items Sold</div>
        </div>

        <div class="summary-card">
            <div class="summary-value">
                TZS <?= number_format($totalRevenue) ?>
            </div>
            <div class="summary-label">Revenue</div>
        </div>

        <div class="summary-card">
            <div class="summary-value">
                TZS <?= number_format($totalProfit) ?>
            </div>
            <div class="summary-label">Total Profit</div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="table-card">

        <div class="table-header">
            Profit Breakdown (Product Level)
        </div>

        <?php if (!empty($sales)): ?>

            <div class="table-wrap">

                <table>

                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Revenue</th>
                            <th>Profit</th>
                            <th>Unit Profit</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php foreach ($sales as $item): ?>

                        <tr>

                            <td>
                                <?= Html::encode($item->product->name ?? 'N/A') ?>
                            </td>

                            <td>
                                <span class="badge badge-blue">
                                    <?= $item->quantity ?>
                                </span>
                            </td>

                            <td>
                                TZS <?= number_format($item->quantity * $item->selling_price) ?>
                            </td>

                            <td>
                                <span class="badge badge-profit">
                                    TZS <?= number_format($item->profit) ?>
                                </span>
                            </td>

                            <td>
                                TZS <?= number_format($item->selling_price - ($item->product->buying_price ?? 0)) ?>
                            </td>

                            <td>
                                <?= date('d M Y H:i', $item->sale->created_at ?? time()) ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        <?php else: ?>

            <div class="empty">
                📉 No profit data found today
            </div>

        <?php endif; ?>

    </div>

</div>