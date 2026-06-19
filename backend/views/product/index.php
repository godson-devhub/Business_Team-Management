<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var $products common\models\Product[] */

$this->title = 'My Products';
?>

<!-- =========================
BACKGROUND EFFECTS (MATCH DASHBOARD STYLE)
========================= -->
<div class="background-blobs">
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
</div>

<!-- =========================
PAGE WRAPPER
========================= -->
<div class="page-wrapper">

    <div class="glass-table">

        <!-- HEADER -->
        <div class="header">

            <div>
                <h1 class="title">📦 My Products</h1>
                <p class="subtitle">Manage your branch inventory easily</p>
            </div>

            <a href="<?= Url::to(['/product/create']) ?>" class="add-btn">
                ➕ Add Product
            </a>

        </div>

        <!-- TABLE -->
        <div class="table-wrapper">

            <table>

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Buy</th>
                        <th>Sell</th>
                        <th>Stock</th>
                        <th>Value</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                <?php if (!empty($products)): ?>

                    <?php foreach ($products as $p): ?>

                        <tr>

                            <td><?= $p->id ?></td>

                            <td class="name"><?= Html::encode($p->name) ?></td>

                            <td><?= Html::encode($p->sku) ?></td>

                            <td><?= number_format($p->buying_price) ?></td>

                            <td><?= number_format($p->selling_price) ?></td>

                            <td>
                                <span class="badge"><?= $p->stock_quantity ?></span>
                            </td>

                            <td>
                                <?= number_format($p->stockValue, 2) ?>
                            </td>

                            <td>
                                <?php if ($p->status == 1): ?>
                                    <span class="active">Active</span>
                                <?php else: ?>
                                    <span class="inactive">Inactive</span>
                                <?php endif; ?>
                            </td>

                            <td class="actions">

                                <a href="<?= Url::to(['/product/update', 'id' => $p->id]) ?>"
                                   class="btn edit">
                                    ✏️ Edit
                                </a>

                                <?= Html::beginForm(['/product/delete', 'id' => $p->id], 'post') ?>
                                    <?= Html::submitButton('🗑 Delete', [
                                        'class' => 'btn delete',
                                        'data-confirm' => 'Delete this product?'
                                    ]) ?>
                                <?= Html::endForm() ?>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>
                        <td colspan="9" class="empty">
                            No products found. Start by adding one 🚀
                        </td>
                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

<!-- =========================
STYLE (MATCH SELLER DASHBOARD DESIGN)
========================= -->
<style>

body{
    margin:0;
    padding:0;
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
    overflow:hidden;
}

.blob{
    position:absolute;
    border-radius:50%;
    filter:blur(90px);
    opacity:0.35;
    animation:move 10s infinite alternate ease-in-out;
}

.blob1{
    width:320px;
    height:320px;
    background:#38bdf8;
    top:-60px;
    left:-60px;
}

.blob2{
    width:280px;
    height:280px;
    background:#8b5cf6;
    bottom:-60px;
    right:-60px;
}

@keyframes move{
    from{transform:translateY(0);}
    to{transform:translateY(50px);}
}

/* WRAPPER */
.page-wrapper{
    padding:40px;
}

/* GLASS CARD */
.glass-table{
    background:rgba(255,255,255,0.07);
    border:1px solid rgba(255,255,255,0.15);
    backdrop-filter:blur(18px);
    border-radius:25px;
    padding:30px;
    box-shadow:0 10px 40px rgba(0,0,0,0.4);
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.title{
    font-size:30px;
    font-weight:bold;
    background:linear-gradient(90deg,#38bdf8,#818cf8,#c084fc);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.subtitle{
    color:#94a3b8;
    font-size:14px;
}

/* BUTTON */
.add-btn{
    padding:12px 18px;
    border-radius:14px;
    background:linear-gradient(135deg,#38bdf8,#6366f1);
    color:white;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}

.add-btn:hover{
    transform:translateY(-3px);
}

/* TABLE */
.table-wrapper{
    overflow-x:auto;
}

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:rgba(255,255,255,0.08);
}

th, td{
    padding:14px;
    text-align:left;
    border-bottom:1px solid rgba(255,255,255,0.08);
    font-size:14px;
}

tr:hover{
    background:rgba(255,255,255,0.05);
}

/* BADGE */
.badge{
    padding:6px 10px;
    background:#38bdf8;
    border-radius:20px;
    font-size:12px;
}

/* STATUS */
.active{
    color:#22c55e;
    font-weight:bold;
}

.inactive{
    color:#ef4444;
    font-weight:bold;
}

/* ACTION BUTTONS */
.actions{
    display:flex;
    gap:8px;
}

.btn{
    padding:6px 10px;
    border-radius:10px;
    text-decoration:none;
    font-size:12px;
    font-weight:600;
}

.edit{
    background:#facc15;
    color:black;
}

.delete{
    background:#ef4444;
    color:white;
}

/* EMPTY */
.empty{
    text-align:center;
    padding:30px;
    color:#94a3b8;
}

</style>