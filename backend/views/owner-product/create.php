<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Create Product';

?>

<div class="background-blobs">

    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
    <div class="blob blob3"></div>

</div>

<div class="page-wrapper">

    <div class="create-container">

        <div class="glass-card">

            <div class="header-top">

                <a
                    href="<?= Url::to(['/owner-product/index']) ?>"
                    class="back-btn"
                >
                    ← Back Products
                </a>

            </div>

            <div class="hero-section">

                <div class="badge-live">

                    OWNER PRODUCT MANAGER

                </div>

                <h1 class="title">

                    📦 Create New Product

                </h1>

                <p class="subtitle">

                    Add inventory to the selected branch
                    and manage stock professionally.

                </p>

            </div>

            <div class="feature-grid">

                <div class="feature-card">

                    <div class="icon">
                        📊
                    </div>

                    <h4>
                        Inventory Tracking
                    </h4>

                </div>

                <div class="feature-card">

                    <div class="icon">
                        💰
                    </div>

                    <h4>
                        Profit Monitoring
                    </h4>

                </div>

                <div class="feature-card">

                    <div class="icon">
                        ⚡
                    </div>

                    <h4>
                        Fast Management
                    </h4>

                </div>

            </div>

            <div class="form-wrapper">

                <?= $this->render('_form', [
                    'model' => $model
                ]) ?>

            </div>

        </div>

    </div>

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
}

/* BLOBS */

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
    left:-100px;
    top:-100px;
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

/* PAGE */

.page-wrapper{
    padding:40px;
}

.create-container{
    max-width:1100px;
    margin:auto;
}

/* CARD */

.glass-card{

    background:
    rgba(255,255,255,.06);

    backdrop-filter:
    blur(20px);

    border:
    1px solid rgba(255,255,255,.1);

    border-radius:30px;

    padding:35px;

    box-shadow:
    0 20px 60px rgba(0,0,0,.35);
}

/* BACK */

.back-btn{

    display:inline-block;

    color:white;

    text-decoration:none;

    padding:10px 18px;

    border-radius:12px;

    background:
    rgba(255,255,255,.08);

    transition:.3s;
}

.back-btn:hover{

    transform:
    translateY(-3px);

    color:white;
}

/* HERO */

.hero-section{
    text-align:center;
    margin-top:25px;
}

.badge-live{

    display:inline-block;

    padding:8px 16px;

    border-radius:999px;

    background:
    rgba(34,197,94,.15);

    border:
    1px solid rgba(34,197,94,.25);

    color:#86efac;

    margin-bottom:20px;
}

.title{

    font-size:42px;

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

.subtitle{

    color:#94a3b8;

    max-width:700px;

    margin:auto;

    margin-top:10px;
}

/* FEATURES */

.feature-grid{

    display:grid;

    grid-template-columns:
    repeat(3,1fr);

    gap:20px;

    margin-top:35px;
}

.feature-card{

    background:
    rgba(255,255,255,.05);

    border:
    1px solid rgba(255,255,255,.08);

    border-radius:20px;

    padding:20px;

    text-align:center;

    transition:.3s;
}

.feature-card:hover{

    transform:
    translateY(-6px);

    background:
    rgba(255,255,255,.08);
}

.icon{
    font-size:32px;
    margin-bottom:10px;
}

/* FORM */

.form-wrapper{
    margin-top:35px;
}

@media(max-width:768px){

    .feature-grid{
        grid-template-columns:1fr;
    }

    .title{
        font-size:32px;
    }

}

</style>