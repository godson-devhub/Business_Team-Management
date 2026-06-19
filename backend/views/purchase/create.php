<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/** @var array $products */
/** @var yii\widgets\ActiveForm $form */

$this->title = 'Create Purchase';
?>

<div class="background-blobs">
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
</div>

<div class="page-wrapper">

    <div class="glass-card">

        <!-- HEADER -->
        <div class="header">

            <div class="badge">
                🛒 PURCHASE MODULE
            </div>

            <h1 class="title">
                Create New Purchase
            </h1>

            <p class="subtitle">
                Record stock purchase and automatically update inventory
            </p>

        </div>

        <!-- FORM -->
        <form method="post">
            <input type="hidden"
                   name="<?= Yii::$app->request->csrfParam ?>"
                   value="<?= Yii::$app->request->getCsrfToken() ?>">

            <!-- SUPPLIER -->
            <div class="form-group">

                <label>Supplier Name</label>

                <input type="text"
                       name="supplier_name"
                       class="input"
                       placeholder="e.g. ABC Suppliers Ltd"
                       required>

            </div>

            <!-- PRODUCT -->
            <div class="form-group">

                <label>Select Product</label>

                <select name="product_id" class="input" required>

                    <option value="">-- Choose Product --</option>

                    <?php foreach ($products as $product): ?>

                        <option value="<?= $product->id ?>">
                            <?= Html::encode($product->name) ?>
                        </option>

                    <?php endforeach; ?>

                </select>

            </div>

            <!-- QUANTITY -->
            <div class="form-group">

                <label>Quantity</label>

                <input type="number"
                       name="quantity"
                       class="input"
                       placeholder="Enter quantity"
                       min="1"
                       required>

            </div>

            <!-- INFO BOX -->
            <div class="info-box">

                ⚠️ Stock will automatically increase after purchase is saved.

            </div>

            <!-- BUTTONS -->
            <div class="actions">

                <button type="submit" class="btn-primary">
                    💾 Save Purchase
                </button>

                <a href="<?= Url::to(['index']) ?>" class="btn-secondary">
                    ← Back
                </a>

            </div>

        </form>

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
    filter:blur(90px);
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
    width:300px;
    height:300px;
    background:#a855f7;
    bottom:-120px;
    right:-120px;
}

/* =========================
WRAPPER
========================= */
.page-wrapper{
    display:flex;
    justify-content:center;
    padding:40px;
}

/* =========================
GLASS CARD
========================= */
.glass-card{
    width:100%;
    max-width:650px;
    background:rgba(255,255,255,.06);
    border:1px solid rgba(255,255,255,.1);
    border-radius:26px;
    padding:30px;
    backdrop-filter:blur(18px);
    box-shadow:0 20px 60px rgba(0,0,0,.35);
    transition:.3s;
}

.glass-card:hover{
    transform:translateY(-4px);
}

/* =========================
HEADER
========================= */
.badge{
    display:inline-block;
    padding:6px 12px;
    font-size:12px;
    border-radius:999px;
    background:rgba(56,189,248,.15);
    border:1px solid rgba(56,189,248,.25);
    color:#38bdf8;
    margin-bottom:15px;
}

.title{
    font-size:30px;
    font-weight:800;
}

.subtitle{
    color:#94a3b8;
    margin-top:8px;
    margin-bottom:25px;
}

/* =========================
FORM
========================= */
.form-group{
    margin-bottom:18px;
}

label{
    display:block;
    margin-bottom:6px;
    color:#cbd5e1;
    font-size:14px;
}

.input{
    width:100%;
    padding:12px 14px;
    border-radius:12px;
    border:1px solid rgba(255,255,255,.1);
    background:rgba(255,255,255,.05);
    color:white;
    outline:none;
    transition:.3s;
}

.input:focus{
    border-color:#38bdf8;
    background:rgba(255,255,255,.08);
}

/* =========================
INFO BOX
========================= */
.info-box{
    padding:12px 14px;
    background:rgba(245,158,11,.1);
    border:1px solid rgba(245,158,11,.25);
    border-radius:12px;
    color:#fbbf24;
    font-size:13px;
    margin-top:10px;
}

/* =========================
ACTIONS
========================= */
.actions{
    display:flex;
    gap:12px;
    margin-top:25px;
}

.btn-primary{
    background:#38bdf8;
    border:none;
    padding:12px 18px;
    border-radius:12px;
    color:#000;
    font-weight:700;
    cursor:pointer;
    transition:.3s;
}

.btn-primary:hover{
    transform:translateY(-3px);
    background:#0ea5e9;
}

.btn-secondary{
    background:rgba(255,255,255,.08);
    padding:12px 18px;
    border-radius:12px;
    color:white;
    text-decoration:none;
    border:1px solid rgba(255,255,255,.1);
    transition:.3s;
}

.btn-secondary:hover{
    background:rgba(255,255,255,.15);
}

</style>