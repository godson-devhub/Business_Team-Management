<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var common\models\Sale[] $sales */

$this->title = 'Sales';

$totalSales = count($sales);
$totalRevenue = 0;
$totalProfit = 0;

foreach ($sales as $sale) {
    $totalRevenue += (float)$sale->total_amount;
    $totalProfit += (float)$sale->total_profit;
}
?>

<div class="background-blobs">
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
</div>

<div class="page-wrapper">

    <div class="header">

        <div>
            <h1 class="title">💰 Sales Management</h1>
            <p class="subtitle">
                Monitor all completed sales transactions
            </p>
        </div>

        <a href="<?= Url::to(['create']) ?>" class="btn-primary">
            ➕ Create Sale
        </a>

    </div>

    <!-- STATS -->

    <div class="stats-grid">

        <div class="stat-card">

            <div class="stat-icon">🧾</div>

            <div class="stat-content">
                <span>Total Sales</span>
                <h2><?= $totalSales ?></h2>
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-icon">💵</div>

            <div class="stat-content">
                <span>Revenue</span>
                <h2>TZS <?= number_format($totalRevenue) ?></h2>
            </div>

        </div>

        <div class="stat-card">

            <div class="stat-icon">📈</div>

            <div class="stat-content">
                <span>Profit</span>
                <h2>TZS <?= number_format($totalProfit) ?></h2>
            </div>

        </div>

    </div>

    <!-- SALES -->

    <div class="grid">

        <?php if ($sales): ?>

            <?php foreach ($sales as $sale): ?>

                <div class="card">

                    <div class="card-top">

                        <div>

                            <div class="sale-id">
                                Sale #<?= $sale->id ?>
                            </div>

                            <div class="sale-date">
                                <?= date('d M Y H:i', $sale->created_at) ?>
                            </div>

                        </div>

                        <div class="status">
                            Completed
                        </div>

                    </div>

                    <div class="products">

                        <?php foreach ($sale->items as $item): ?>

                            <div class="product-row">

                                <div>

                                    <div class="product-name">
                                        <?= Html::encode(
                                            $item->product->name ?? 'Deleted Product'
                                        ) ?>
                                    </div>

                                    <div class="product-qty">
                                        Qty:
                                        <?= $item->quantity ?>
                                    </div>

                                </div>

                                <div class="subtotal">

                                    TZS
                                    <?= number_format($item->subtotal) ?>

                                </div>

                            </div>

                        <?php endforeach; ?>

                    </div>

                    <div class="footer">

                        <div>

                            <span>Total</span>

                            <h3>
                                TZS
                                <?= number_format($sale->total_amount) ?>
                            </h3>

                        </div>

                        <div>

                            <span>Profit</span>

                            <h3 class="profit">
                                TZS
                                <?= number_format($sale->total_profit) ?>
                            </h3>

                        </div>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="empty">

                <div class="empty-icon">
                    📦
                </div>

                <h2>No Sales Yet</h2>

                <p>
                    Create your first sale transaction
                </p>

            </div>

        <?php endif; ?>

    </div>

</div>

<style>

body{
    background:linear-gradient(
        135deg,
        #020617,
        #0f172a,
        #1e293b
    );
    color:white;
}

.page-wrapper{
    padding:40px;
}

.background-blobs{
    position:fixed;
    inset:0;
    z-index:-1;
}

.blob{
    position:absolute;
    border-radius:50%;
    filter:blur(120px);
    opacity:.25;
}

.blob1{
    width:350px;
    height:350px;
    background:#38bdf8;
    top:-100px;
    left:-100px;
}

.blob2{
    width:300px;
    height:300px;
    background:#8b5cf6;
    right:-100px;
    bottom:-100px;
}

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:15px;
}

.title{
    font-size:34px;
    font-weight:800;
}

.subtitle{
    color:#94a3b8;
}

.btn-primary{
    background:linear-gradient(
        135deg,
        #38bdf8,
        #2563eb
    );
    color:white;
    text-decoration:none;
    padding:14px 22px;
    border-radius:14px;
    font-weight:700;
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.stat-card{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.08);
    border-radius:22px;
    padding:20px;
    display:flex;
    gap:15px;
    align-items:center;
    backdrop-filter:blur(18px);
}

.stat-icon{
    font-size:35px;
}

.stat-content span{
    color:#94a3b8;
    font-size:13px;
}

.stat-content h2{
    margin:5px 0 0;
}

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(360px,1fr));
    gap:20px;
}

.card{
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.08);
    border-radius:24px;
    padding:20px;
    backdrop-filter:blur(20px);
    transition:.3s;
}

.card:hover{
    transform:translateY(-6px);
}

.card-top{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:15px;
}

.sale-id{
    font-size:18px;
    font-weight:700;
}

.sale-date{
    font-size:12px;
    color:#94a3b8;
}

.status{
    background:rgba(34,197,94,.15);
    color:#86efac;
    border:1px solid rgba(34,197,94,.2);
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
}

.products{
    margin-top:10px;
}

.product-row{
    display:flex;
    justify-content:space-between;
    margin-bottom:12px;
}

.product-name{
    font-weight:600;
}

.product-qty{
    color:#94a3b8;
    font-size:12px;
}

.subtotal{
    color:#38bdf8;
    font-weight:700;
}

.footer{
    margin-top:20px;
    padding-top:15px;
    border-top:1px solid rgba(255,255,255,.08);
    display:flex;
    justify-content:space-between;
}

.footer span{
    color:#94a3b8;
    font-size:12px;
}

.footer h3{
    margin-top:5px;
}

.profit{
    color:#22c55e;
}

.empty{
    text-align:center;
    padding:80px;
    grid-column:1/-1;
}

.empty-icon{
    font-size:50px;
}

</style>