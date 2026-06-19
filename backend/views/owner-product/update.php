<?php

use yii\helpers\Html;

$this->title = 'Update Product';

?>

<div class="background-blobs">

```
<div class="blob blob1"></div>

<div class="blob blob2"></div>

<div class="blob blob3"></div>
```

</div>

<div class="page-wrapper">

```
<div class="glass-card">

    <div class="header-section">

        <div class="live-badge warning">
            ● EDIT MODE
        </div>

        <h1 class="page-title">
            ✏️ Update Product
        </h1>

        <p class="page-subtitle">

            Modify product information, pricing and inventory settings.

        </p>

    </div>

    <!-- PRODUCT INFO CARD -->

    <div class="info-card">

        <div class="info-icon">
            📦
        </div>

        <div>

            <div class="info-title">

                <?= Html::encode($model->name) ?>

            </div>

            <div class="info-text">

                SKU:
                <?= Html::encode($model->sku ?: 'N/A') ?>

            </div>

        </div>

    </div>

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>

</div>
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

/* =========================
BACKGROUND BLOBS
========================= */

.background-blobs{
    position:fixed;
    inset:0;
    z-index:-1;
    overflow:hidden;
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
    bottom:-100px;
    right:-100px;
}

.blob3{
    width:220px;
    height:220px;
    background:#f59e0b;
    top:35%;
    left:55%;
}

/* =========================
LAYOUT
========================= */

.page-wrapper{

    padding:40px;

    display:flex;

    justify-content:center;
}

.glass-card{

    width:100%;

    max-width:950px;

    background:
    rgba(255,255,255,.06);

    backdrop-filter:
    blur(20px);

    border:
    1px solid rgba(255,255,255,.10);

    border-radius:28px;

    padding:35px;

    box-shadow:
    0 12px 40px rgba(0,0,0,.35);

    transition:.35s;
}

.glass-card:hover{

    transform:
    translateY(-3px);
}

/* =========================
HEADER
========================= */

.live-badge{

    display:inline-block;

    padding:8px 14px;

    border-radius:999px;

    margin-bottom:18px;

    font-size:13px;

    font-weight:700;
}

.warning{

    background:
    rgba(245,158,11,.15);

    border:
    1px solid rgba(245,158,11,.25);

    color:#fbbf24;
}

.page-title{

    font-size:38px;

    font-weight:800;

    background:
    linear-gradient(
        90deg,
        #38bdf8,
        #818cf8,
        #c084fc
    );

    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.page-subtitle{

    margin-top:10px;

    color:#94a3b8;

    font-size:15px;
}

/* =========================
INFO CARD
========================= */

.info-card{

    margin-top:25px;

    margin-bottom:30px;

    display:flex;

    align-items:center;

    gap:18px;

    padding:20px;

    border-radius:18px;

    background:
    rgba(255,255,255,.04);

    border:
    1px solid rgba(255,255,255,.08);
}

.info-card:hover{

    background:
    rgba(255,255,255,.07);
}

.info-icon{

    width:60px;

    height:60px;

    border-radius:18px;

    display:flex;

    justify-content:center;

    align-items:center;

    font-size:28px;

    background:
    linear-gradient(
        135deg,
        #3b82f6,
        #8b5cf6
    );
}

.info-title{

    font-size:18px;

    font-weight:700;

    color:white;
}

.info-text{

    color:#94a3b8;

    margin-top:5px;
}

</style>
