<?php

use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \common\models\Business[] $businesses
 */

$this->title = 'My Businesses';
?>

<style>

/* =========================
GLOBAL
========================= */

body{
    margin:0;
    padding:0;
    font-family:Segoe UI, sans-serif;

    background:linear-gradient(135deg,#020617,#0f172a,#1e293b);
    color:white;

    min-height:100vh;
    overflow-y:auto;
}

/* =========================
CONTAINER
========================= */

.container{
    padding:40px;
}

/* =========================
TITLE
========================= */

.title{
    font-size:42px;
    font-weight:800;
    margin-bottom:25px;

    background:linear-gradient(to right,#38bdf8,#a78bfa);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

/* =========================
BUTTON
========================= */

.btn{
    padding:12px 18px;
    background:linear-gradient(135deg,#38bdf8,#6366f1);

    border-radius:12px;
    color:white;
    text-decoration:none;

    display:inline-block;
    margin-bottom:25px;

    transition:0.3s;
    font-weight:600;
}

.btn:hover{
    transform:translateY(-3px);
    box-shadow:0 10px 25px rgba(56,189,248,0.3);
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
CARD WRAPPER (IMPORTANT FIX)
========================= */

.card{
    position:relative;

    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);

    padding:22px;
    border-radius:18px;

    backdrop-filter:blur(18px);

    transition:0.3s;

    cursor:pointer;

    overflow:hidden;
}

.card:hover{
    transform:translateY(-10px);
    background:rgba(255, 255, 255, 0.1);
    box-shadow:0 15px 40px rgba(0,0,0,0.3);
}

/* =========================
MAKE ENTIRE CARD CLICKABLE
========================= */

.card-link{
    position:absolute;
    inset:0;
    z-index:1;
}

/* =========================
CONTENT INSIDE CARD
========================= */

.card-content{
    position:relative;
    z-index:2;
}

.card h3{
    margin:0 0 8px 0;
    font-size:20px;
    font-weight:700;
}

.card p{
    margin:0;
    font-size:14px;
    color:#cbd5e1;
}

/* =========================
ACTIONS (TOP RIGHT CLEAN STYLE)
========================= */

.actions{
    position:absolute;
    top:12px;
    right:12px;

    display:flex;
    gap:10px;

    z-index:3;
}

.actions a{
    font-size:12px;
    padding:6px 10px;
    border-radius:8px;

    text-decoration:none;
    color:white;

    background:rgba(255,255,255,0.08);
    backdrop-filter:blur(10px);

    transition:0.2s;
}

.actions a:hover{
    background:rgba(255,255,255,0.18);
}

/* delete highlight */
.actions .delete{
    background:rgba(239,68,68,0.3);
}

.actions .delete:hover{
    background:rgba(239,68,68,0.5);
}

</style>

<div class="container">

    <div class="title">My Businesses</div>

    <a href="<?= Url::to(['business/create']) ?>" class="btn">
        ➕ Create Business
    </a>

    <div class="grid">

        <?php foreach ($businesses as $b): ?>

            <div class="card">

                <!-- 🔥 CLICKABLE OVERLAY (ENTIRE CARD) -->
                <a class="card-link"
                   href="<?= Url::to(['business/view', 'id' => $b->id]) ?>"></a>

                <!-- ACTIONS -->
                <div class="actions">

                    <a href="<?= Url::to(['business/update', 'id' => $b->id]) ?>">
                        ✏ Edit
                    </a>

                    <a class="delete"
                       href="<?= Url::to(['business/delete', 'id' => $b->id]) ?>"
                       onclick="return confirm('Delete this business?')">
                        🗑
                    </a>

                </div>

                <!-- CONTENT -->
                <div class="card-content">

                    <h3><?= Html::encode($b->name) ?></h3>

                    <p><?= Html::encode($b->description) ?></p>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>