<?php

use yii\web\YiiAsset;
use yii\helpers\Html;
use yii\helpers\Url;

YiiAsset::register($this);

$this->title = 'Owner Product Manager';

$productCount = count($products);

$totalStock = 0;
$totalValue = 0;

foreach ($products as $product) {

    $totalStock += $product->stock_quantity;

    $totalValue += (
        $product->stock_quantity *
        $product->selling_price
    );
}

?>

<div class="background-blobs">
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
    <div class="blob blob3"></div>
</div>

<div class="page-wrapper">

```
<div class="page-header">

    <div>

        <h1 class="page-title">
            📦 Product Management
        </h1>

        <p class="page-subtitle">
            Manage inventory across all branches
        </p>

    </div>

</div>

<!-- BRANCH SELECTOR -->

<div class="glass-card selector-card">

    <form method="get" class="branch-form">

        <select
            name="branch_id"
            class="glass-input"
        >

            <option value="">
                Select Branch
            </option>

            <?php foreach ($branches as $branch): ?>

                <option
                    value="<?= $branch->id ?>"
                    <?= $activeBranch == $branch->id ? 'selected' : '' ?>
                >

                    <?= Html::encode($branch->name) ?>

                </option>

            <?php endforeach; ?>

        </select>

        <button type="submit" class="glass-btn">
            Load Branch
        </button>

    </form>

</div>

<?php if ($activeBranch): ?>

<!-- STATS -->

<div class="stats-grid">

    <div class="stat-card">

        <div class="stat-icon">
            📦
        </div>

        <div class="stat-value">
            <?= number_format($productCount) ?>
        </div>

        <div class="stat-label">
            Products
        </div>

    </div>

    <div class="stat-card">

        <div class="stat-icon">
            📊
        </div>

        <div class="stat-value">
            <?= number_format($totalStock) ?>
        </div>

        <div class="stat-label">
            Stock Quantity
        </div>

    </div>

    <div class="stat-card">

        <div class="stat-icon">
            💰
        </div>

        <div class="stat-value">
            <?= number_format($totalValue) ?>
        </div>

        <div class="stat-label">
            Inventory Value
        </div>

    </div>

</div>

<!-- TABLE -->

<div class="glass-card">

    <div class="table-header">

        <h3>
            Branch Products
        </h3>

        <a
            href="<?= Url::to(['/owner-product/create']) ?>"
            class="add-btn"
        >
            ➕ Add Product
        </a>

    </div>

    <div class="table-responsive">

        <table class="modern-table">

            <thead>

                <tr>

                    <th>Name</th>
                    <th>SKU</th>
                    <th>Buy Price</th>
                    <th>Sell Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

            <?php foreach ($products as $product): ?>

                <tr>

                    <td>
                        <?= Html::encode($product->name) ?>
                    </td>

                    <td>
                        <?= Html::encode($product->sku) ?>
                    </td>

                    <td>
                        <?= number_format($product->buying_price,2) ?>
                    </td>

                    <td>
                        <?= number_format($product->selling_price,2) ?>
                    </td>

                    <td>

                        <?php if(
                            $product->stock_quantity
                            <=
                            $product->min_stock_alert
                        ): ?>

                            <span class="badge badge-danger">

                                <?= $product->stock_quantity ?>

                            </span>

                        <?php else: ?>

                            <span class="badge badge-success">

                                <?= $product->stock_quantity ?>

                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

                        <?php if($product->status): ?>

                            <span class="status-active">
                                Active
                            </span>

                        <?php else: ?>

                            <span class="status-inactive">
                                Inactive
                            </span>

                        <?php endif; ?>

                    </td>

                    <td>

                        <a
                            href="<?= Url::to([
                                '/owner-product/update',
                                'id'=>$product->id
                            ]) ?>"
                            class="action-btn edit"
                        >
                            Edit
                        </a>

                        <?= Html::beginForm(
                            ['delete', 'id' => $product->id],
                            'post'
                        ) ?>

                        <button type="submit"
                                class="action-btn delete"
                                onclick="return confirm('Delete product?')">
                            🗑 Delete
                        </button>

                        <?= Html::endForm() ?>
                       

                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>

<?php endif; ?>
```

</div>

<style>

body{
    background:
    linear-gradient(
        135deg,
        #020617,
        #0f172a,
        #1e293b
    );
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

.blob3{
    width:250px;
    height:250px;
    background:#22c55e;
    top:40%;
    left:50%;
}

.page-wrapper{
    padding:35px;
}

.page-title{
    font-size:38px;
    font-weight:800;
}

.page-subtitle{
    color:#94a3b8;
}

.glass-card{

    background:rgba(255,255,255,.06);

    backdrop-filter:blur(20px);

    border:1px solid rgba(255,255,255,.1);

    border-radius:24px;

    padding:25px;

    margin-bottom:25px;

    transition:.35s;
}

.glass-card:hover{
    transform:translateY(-4px);
}

.branch-form{
    display:flex;
    gap:15px;
}

.glass-input{
    flex:1;
    background:rgba(255,255,255,.05);
    border:1px solid rgba(255,255,255,.1);
    color:white;
    border-radius:14px;
    padding:14px;
}

.glass-btn,
.add-btn{

    background:
    linear-gradient(
        135deg,
        #3b82f6,
        #8b5cf6
    );

    border:none;

    color:white;

    padding:14px 22px;

    border-radius:14px;

    text-decoration:none;

    transition:.3s;
}

.glass-btn:hover,
.add-btn:hover{
    transform:translateY(-3px);
}

.stats-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:25px;
}

.stat-card{

    background:rgba(255,255,255,.06);

    backdrop-filter:blur(18px);

    border-radius:24px;

    padding:25px;

    border:1px solid rgba(255,255,255,.08);

    transition:.3s;
}

.stat-card:hover{
    transform:translateY(-8px);
}

.stat-icon{
    font-size:28px;
}

.stat-value{
    font-size:32px;
    font-weight:800;
    margin-top:10px;
}

.stat-label{
    color:#94a3b8;
}

.table-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.modern-table{
    width:100%;
    border-collapse:collapse;
}

.modern-table th{
    color:#94a3b8;
    padding:15px;
    text-align:left;
}

.modern-table td{
    padding:15px;
    border-top:1px solid rgba(255,255,255,.06);
}

.modern-table tbody tr{
    transition:.3s;
}

.modern-table tbody tr:hover{
    background:rgba(255,255,255,.04);
}

.badge{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:700;
}

.badge-success{
    background:#22c55e;
}

.badge-danger{
    background:#ef4444;
}

.status-active{
    color:#22c55e;
    font-weight:700;
}

.status-inactive{
    color:#ef4444;
    font-weight:700;
}

.action-btn{
    padding:8px 14px;
    border-radius:10px;
    text-decoration:none;
    margin-right:5px;
}

.edit{
    background:#f59e0b;
    color:white;
}

.delete{
    background:#ef4444;
    color:white;
}

</style>
