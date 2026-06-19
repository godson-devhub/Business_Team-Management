<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var common\models\Purchase[] $purchases */

$this->title = 'Purchases';
?>

<div class="background-blobs">
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
</div>

<div class="page-wrapper">

    <!-- HEADER -->
    <div class="header">

        <div>
            <h1 class="title">🛒 Purchases</h1>
            <p class="subtitle">Track all stock purchases </p>
        </div>

        <a href="<?= Url::to(['create']) ?>" class="btn-primary">
            ➕ New Purchase
        </a>

    </div>

    <!-- LIST -->
    <div class="grid">

        <?php if (!empty($purchases)): ?>

            <?php foreach ($purchases as $purchase): ?>

                <?php
                    $calculatedTotal = 0;
                ?>

                <div class="card">

                    <!-- TOP -->
                    <div class="card-top">

                        <div class="purchase-id">
                            Purchase #<?= $purchase->id ?>
                        </div>

                        <div class="status">
                            ✔ Completed
                        </div>

                    </div>

                    <!-- BODY -->
                    <div class="card-body">

                        <!-- SUPPLIER -->
                        <div class="row">
                            <span>Supplier</span>
                            <strong><?= Html::encode($purchase->supplier_name) ?></strong>
                        </div>

                        <!-- DATE -->
                        <div class="row">
                            <span>Date</span>
                            <strong>
                                <?= date('d M Y', $purchase->created_at) ?>
                            </strong>
                        </div>

                        <hr style="border-color:rgba(255,255,255,.08); margin:10px 0;">

                        <!-- ITEMS SECTION -->
                        <div style="font-size:13px; color:#94a3b8; margin-bottom:10px;">
                            📦 Items Purchased
                        </div>

                        <?php if (!empty($purchase->items)): ?>

                            <?php foreach ($purchase->items as $item): ?>

                                <?php
                                    $productName = $item->product->name ?? 'Deleted Product';
                                    $qty = (int) $item->quantity;
                                    $price = (float) $item->buying_price;
                                    $subtotal = $qty * $price;

                                    $calculatedTotal += $subtotal;
                                ?>

                                <div style="
                                    display:flex;
                                    justify-content:space-between;
                                    font-size:13px;
                                    margin-bottom:6px;
                                    color:#cbd5e1;
                                ">

                                    <div>
                                        <?= Html::encode($productName) ?>
                                        <br>
                                        <small style="color:#64748b;">
                                            <?= $qty ?> × <?= number_format($price) ?>
                                        </small>
                                    </div>

                                    <div style="color:#38bdf8;">
                                        <?= number_format($subtotal) ?>
                                    </div>

                                </div>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <div style="color:#64748b; font-size:13px;">
                                No items available
                            </div>

                        <?php endif; ?>

                        <hr style="border-color:rgba(255,255,255,.08); margin:10px 0;">

                        <!-- TOTAL -->
                        <div class="row">
                            <span>Total Amount</span>
                            <strong class="amount">
                                TZS <?= number_format($calculatedTotal) ?>
                            </strong>
                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty">
                😴 No purchases found
            </div>

        <?php endif; ?>

    </div>

</div>

<style>

/* =========================
BACKGROUND
========================= */
body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:linear-gradient(135deg,#020617,#0f172a,#1e293b);
    color:white;
}

.background-blobs{
    position:fixed;
    inset:0;
    z-index:-1;
}

.blob{
    position:absolute;
    border-radius:50%;
    filter:blur(100px);
    opacity:.25;
}

.blob1{
    width:350px;
    height:350px;
    background:#38bdf8;
    top:-120px;
    left:-120px;
}

.blob2{
    width:320px;
    height:320px;
    background:#a855f7;
    bottom:-120px;
    right:-120px;
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
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:15px;
}

.title{
    font-size:32px;
    font-weight:800;
}

.subtitle{
    color:#94a3b8;
    margin-top:6px;
}

/* =========================
BUTTON
========================= */
.btn-primary{
    background:#38bdf8;
    color:#000;
    padding:12px 18px;
    border-radius:12px;
    text-decoration:none;
    font-weight:700;
    transition:.3s;
    display:inline-block;
}

.btn-primary:hover{
    transform:translateY(-3px);
    background:#0ea5e9;
}

/* =========================
GRID
========================= */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:20px;
}

/* =========================
CARD
========================= */
.card{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.1);
    border-radius:20px;
    padding:18px;
    backdrop-filter:blur(18px);
    transition:.3s;
}

.card:hover{
    transform:translateY(-6px);
    background:rgba(255,255,255,.10);
}

/* =========================
CARD TOP
========================= */
.card-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.purchase-id{
    font-weight:700;
}

.status{
    font-size:12px;
    padding:4px 10px;
    border-radius:999px;
    background:rgba(34,197,94,.15);
    border:1px solid rgba(34,197,94,.25);
    color:#86efac;
}

/* =========================
BODY
========================= */
.card-body .row{
    display:flex;
    justify-content:space-between;
    margin-bottom:10px;
    font-size:14px;
    color:#cbd5e1;
}

.amount{
    color:#38bdf8;
}

/* =========================
EMPTY
========================= */
.empty{
    padding:60px;
    text-align:center;
    color:#94a3b8;
}

</style>