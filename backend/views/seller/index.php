<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Seller Dashboard';

$user = Yii::$app->user->identity;
$username = $user->username ?? 'Seller';

// SAFE DEFAULTS (prevent undefined errors)
$todaySales = $todaySales ?? 0;
$todayProfit = $todayProfit ?? 0;
$totalProducts = $totalProducts ?? 0;
$lowStock = $lowStock ?? 0;
$totalStockQuantity = $totalStockQuantity ?? 0;
$totalStockValue = $totalStockValue ?? 0;

?>

<div class="seller-dashboard">

    <!-- HEADER -->
    <div class="dashboard-header">

        <div>
            <h1 class="title">
                🚀 Welcome, <?= Html::encode($username) ?>
            </h1>

            <p class="subtitle">
                Inventory • Sales • Stock Monitoring
            </p>
        </div>

        <div class="status-badge">
            ● Seller Active
        </div>

    </div>

    <!-- STATS -->
    <div class="stats-grid">

        <div class="stat-card blue">
            <div class="stat-icon">💰</div>
            <div class="stat-label">Today's Sales</div>
            <div class="stat-value">
                TZS <?= number_format((float)$todaySales) ?>
            </div>
        </div>

        <div class="stat-card green">
            <div class="stat-icon">📈</div>
            <div class="stat-label">Today's Profit</div>
            <div class="stat-value">
                TZS <?= number_format((float)$todayProfit) ?>
            </div>
        </div>

        <div class="stat-card purple">
            <div class="stat-icon">📦</div>
            <div class="stat-label">Products</div>
            <div class="stat-value">
                <?= number_format((int)$totalProducts) ?>
            </div>
        </div>

        <div class="stat-card red">
            <div class="stat-icon">⚠️</div>
            <div class="stat-label">Low Stock</div>
            <div class="stat-value">
                <?= number_format((int)$lowStock) ?>
            </div>
        </div>

        <div class="stat-card orange">
            <div class="stat-icon">🛒</div>
            <div class="stat-label">Stock Quantity</div>
            <div class="stat-value">
                <?= number_format((int)$totalStockQuantity) ?>
            </div>
        </div>

        <div class="stat-card gold">
            <div class="stat-icon">🏦</div>
            <div class="stat-label">Stock Value</div>
            <div class="stat-value">
                TZS <?= number_format((float)$totalStockValue) ?>
            </div>
        </div>

    </div>

    <!-- QUICK ACTIONS -->
    <div class="action-section">

        <h2>⚡ Quick Actions</h2>

        <div class="actions-grid">

            <a href="<?= Url::to(['/product/index']) ?>" class="action-card">
                <span>📦</span>
                <strong>Products</strong>
            </a>

            <a href="<?= Url::to(['/product/create']) ?>" class="action-card">
                <span>➕</span>
                <strong>Add Product</strong>
            </a>

            <a href="<?= Url::to(['/sale/create']) ?>" class="action-card">
                <span>💳</span>
                <strong>New Sale</strong>
            </a>

            <a href="<?= Url::to(['/sale/index']) ?>" class="action-card">
                <span>📊</span>
                <strong>Sales History</strong>
            </a>

            <a href="<?= Url::to(['/purchase/create']) ?>" class="action-card">
                <span>🛒</span>
                <strong>Purchase</strong>
            </a>

            <a href="<?= Url::to(['/purchase/index']) ?>" class="action-card">
                <span>📋</span>
                <strong>Purchases</strong>
            </a>

        </div>

    </div>

    <!-- RECENT PRODUCTS -->
    <div class="table-card">

        <div class="table-header">
            <h2>🔥 Recent Products</h2>
        </div>

        <?php if (!empty($recentProducts)): ?>

            <table class="custom-table">

                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Buying Price</th>
                        <th>Selling Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($recentProducts as $product): ?>

                    <tr>

                        <td>
                            <?= Html::encode($product->name ?? '') ?>
                        </td>

                        <td>
                            <?= number_format((float)($product->buying_price ?? 0)) ?>
                        </td>

                        <td>
                            <?= number_format((float)($product->selling_price ?? 0)) ?>
                        </td>

                        <td>
                            <?= (int)($product->stock_quantity ?? 0) ?>
                        </td>

                        <td>

                            <?php
                                $minStock = $product->min_stock_alert ?? 5;
                            ?>

                            <?php if (($product->stock_quantity ?? 0) <= $minStock): ?>

                                <span class="badge-danger">
                                    Low Stock
                                </span>

                            <?php else: ?>

                                <span class="badge-success">
                                    In Stock
                                </span>

                            <?php endif; ?>

                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        <?php else: ?>

            <div class="empty">
                No products found
            </div>

        <?php endif; ?>

    </div>

</div>

<style>

body{
    background:#0f172a;
}

.seller-dashboard{
    padding:30px;
}

.dashboard-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.title{
    font-size:34px;
    font-weight:700;
    color:white;
}

.subtitle{
    color:#94a3b8;
    margin-top:5px;
}

.status-badge{
    padding:10px 18px;
    border-radius:30px;
    background:rgba(34,197,94,.15);
    color:#86efac;
    border:1px solid rgba(34,197,94,.3);
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(240px,1fr));
    gap:20px;
    margin-bottom:35px;
}

.stat-card{
    padding:24px;
    border-radius:20px;
    background:#111827;
    border:1px solid rgba(255,255,255,.06);
    transition:.3s;
}

.stat-card:hover{
    transform:translateY(-6px);
}

.stat-icon{
    font-size:24px;
    margin-bottom:10px;
}

.stat-label{
    color:#94a3b8;
    font-size:13px;
}

.stat-value{
    margin-top:10px;
    font-size:28px;
    font-weight:700;
    color:white;
}

.blue{border-left:4px solid #38bdf8;}
.green{border-left:4px solid #22c55e;}
.purple{border-left:4px solid #a78bfa;}
.red{border-left:4px solid #ef4444;}
.orange{border-left:4px solid #f97316;}
.gold{border-left:4px solid #eab308;}

.action-section{
    margin-bottom:35px;
}

.action-section h2{
    color:white;
    margin-bottom:15px;
}

.actions-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(180px,1fr));
    gap:15px;
}

.action-card{
    background:#111827;
    border:1px solid rgba(255,255,255,.06);
    border-radius:18px;
    padding:20px;
    text-decoration:none;
    color:white;
    display:flex;
    flex-direction:column;
    gap:10px;
    transition:.3s;
}

.action-card:hover{
    transform:translateY(-5px);
    border-color:#38bdf8;
}

.action-card span{
    font-size:26px;
}

.table-card{
    background:#111827;
    border-radius:20px;
    border:1px solid rgba(255,255,255,.06);
    overflow:hidden;
}

.table-header{
    padding:20px;
    border-bottom:1px solid rgba(255,255,255,.05);
}

.table-header h2{
    color:white;
    margin:0;
}

.custom-table{
    width:100%;
    border-collapse:collapse;
}

.custom-table th{
    text-align:left;
    padding:15px;
    color:#94a3b8;
}

.custom-table td{
    padding:15px;
    border-top:1px solid rgba(255,255,255,.05);
    color:#e2e8f0;
}

.badge-success{
    padding:6px 12px;
    border-radius:20px;
    background:rgba(34,197,94,.15);
    color:#86efac;
}

.badge-danger{
    padding:6px 12px;
    border-radius:20px;
    background:rgba(239,68,68,.15);
    color:#fca5a5;
}

.empty{
    padding:30px;
    text-align:center;
    color:#94a3b8;
}

</style>