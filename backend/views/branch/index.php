<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch[] $branches
 */

$this->title = 'Branches';
?>

<style>

/* =========================
GLOBAL THEME
========================= */

body{
    margin:0;
    padding:0;
    font-family:Segoe UI, sans-serif;

    background:linear-gradient(135deg,#020617,#0f172a,#1e293b);
    color:white;

    min-height:100vh;
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

    border-radius:14px;
    color:white;
    text-decoration:none;

    display:inline-block;
    margin-bottom:25px;

    transition:0.3s;
    font-weight:600;
}

.btn:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(56,189,248,0.25);
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
CARD (GLASSMORPHISM)
========================= */

.card{
    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);
    border-radius:20px;

    padding:22px;

    backdrop-filter:blur(18px);

    transition:0.35s ease;

    position:relative;
    overflow:hidden;

    cursor:pointer;
}

.card:hover{
    transform:translateY(-10px);
    background:rgba(255,255,255,0.10);
    box-shadow:0 20px 40px rgba(0,0,0,0.35);
}

/* =========================
TEXT INSIDE CARD
========================= */

.card h3{
    margin:0;
    font-size:20px;
    font-weight:700;
}

.card p{
    margin:8px 0;
    color:#cbd5e1;
    font-size:14px;
}

.card small{
    color:#94a3b8;
}

/* =========================
ACTIONS
========================= */

.actions{
    margin-top:15px;
    display:flex;
    gap:12px;
}

.actions a{
    color:#38bdf8;
    text-decoration:none;
    font-size:13px;
}

.actions a:hover{
    text-decoration:underline;
}

/* =========================
LINK WRAP CARD
========================= */

.card-link{
    text-decoration:none;
    color:inherit;
    display:block;
}

</style>

<div class="container">

    <div class="title">Branches</div>

    <!-- FIXED ROUTE (Yii2 SAFE URL) -->
    <a href="<?= Url::to(['branch/create']) ?>" class="btn">
        ➕ Create Branch
    </a>

    <div class="grid">

        <?php foreach ($branches as $b): ?>

            <!-- CLICKABLE CARD -->
            <a href="<?= Url::to(['branch/view', 'id' => $b->id]) ?>" class="card-link">

                <div class="card">

                    <h3><?= Html::encode($b->name) ?></h3>

                    <p>
                        📍 <?= Html::encode($b->location ?: 'No location') ?>
                    </p>

                    <small>
                        Business: <?= Html::encode($b->business->name ?? 'N/A') ?>
                    </small>

                    <!-- ACTIONS -->
                    <div class="actions">

                        <a href="<?= Url::to(['branch/update', 'id' => $b->id]) ?>"
                           onclick="event.stopPropagation();">
                            ✏ Edit
                        </a>

                        <a href="<?= Url::to(['branch/delete', 'id' => $b->id]) ?>"
                           onclick="event.stopPropagation(); return confirm('Delete this branch?')">
                            🗑 Delete
                        </a>

                    </div>

                </div>

            </a>

        <?php endforeach; ?>

    </div>

</div>