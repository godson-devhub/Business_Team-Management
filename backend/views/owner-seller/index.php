<?php

use yii\helpers\Html;

/** @var array $sellers */

$this->title = 'Manage Sellers';
?>

<style>

/* ================= GLOBAL ================= */
.page {
    padding: 30px;
    color: #fff;
    font-family: 'Segoe UI', sans-serif;
}

/* ================= HEADER ================= */
.header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.title {
    font-size: 38px;
    font-weight: bold;
    background: linear-gradient(to right, #38bdf8, #a78bfa, #c084fc);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.subtitle {
    color: #94a3b8;
    margin-top: 5px;
}

/* ================= BUTTON ================= */
.btn {
    display: inline-block;
    padding: 12px 18px;
    border-radius: 14px;
    text-decoration: none;
    color: white;
    font-weight: 600;
    background: linear-gradient(135deg, #38bdf8, #6366f1);
    transition: 0.3s ease;
}

.btn:hover {
    transform: translateY(-4px);
    box-shadow: 0 15px 30px rgba(56, 189, 248, 0.25);
}

/* ================= GRID ================= */
.grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

/* ================= CARD ================= */
.card {
    background: rgba(255, 255, 255, 0.06);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 20px;
    padding: 20px;
    transition: 0.3s ease;
}

.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
}

/* ================= TEXT ================= */
.name {
    font-size: 20px;
    font-weight: 600;
    margin-bottom: 10px;
}

.meta {
    color: #94a3b8;
    font-size: 14px;
    margin-bottom: 15px;
}

/* ================= ACTIONS ================= */
.actions {
    display: flex;
    gap: 10px;
}

.link {
    font-size: 14px;
    color: #38bdf8;
    text-decoration: none;
}

.link:hover {
    text-decoration: underline;
}

/* ================= EMPTY STATE ================= */
.empty {
    margin-top: 40px;
    text-align: center;
    color: #94a3b8;
}

</style>

<div class="page">

    <!-- HEADER -->
    <div class="header">

        <div>
            <div class="title">👨‍💼 Sellers</div>
            <div class="subtitle">Manage your team members and branch sellers</div>
        </div>

        <a href="<?= \yii\helpers\Url::to(['/owner-seller/create']) ?>" class="btn">
            ➕ Add Seller
        </a>

    </div>

    <!-- GRID -->
    <?php if (!empty($sellers)): ?>

        <div class="grid">

            <?php foreach ($sellers as $s): ?>

                <div class="card">

                    <div class="name">
                        <?= Html::encode($s->username) ?>
                    </div>

                    <div class="meta">
                        📧 <?= Html::encode($s->email) ?><br>
                        🏬 Branch: <?= $s->branch_id ?? 'Not assigned' ?>
                    </div>

                    <div class="actions">

                        <a class="link"
                           href="<?= \yii\helpers\Url::to(['/owner-seller/update', 'id' => $s->id]) ?>">
                            ✏ Edit
                        </a>

                        <a class="link"
                           style="color:#ef4444;"
                           onclick="return confirm('Are you sure?')"
                           href="<?= \yii\helpers\Url::to(['/owner-seller/delete', 'id' => $s->id]) ?>">
                            🗑 Delete
                        </a>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>

    <?php else: ?>

        <div class="empty">
            No sellers found. Click “Add Seller” to start building your team.
        </div>

    <?php endif; ?>

</div>