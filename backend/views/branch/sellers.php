<?php

use yii\helpers\Html;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\User[] $sellers
 */

$this->title = $branch->name . ' - Sellers';

$totalSellers = count($sellers);
?>

<style>

body{
    background:
        radial-gradient(circle at top,#0f172a,#020617);
    color:white;
    font-family:'Segoe UI',sans-serif;
}

/* =========================
PAGE
========================= */

.page-wrapper{
    padding:40px;
}

/* =========================
HEADER
========================= */

.page-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
    flex-wrap:wrap;
    gap:15px;
}

.page-title{
    font-size:32px;
    font-weight:800;
}

.page-subtitle{
    color:#94a3b8;
    margin-top:6px;
}

.back-btn{
    text-decoration:none;
    color:white;
    padding:12px 18px;
    border-radius:14px;

    background:rgba(255,255,255,0.08);
    border:1px solid rgba(255,255,255,0.1);

    backdrop-filter:blur(15px);

    transition:.3s;
}

.back-btn:hover{
    color:white;
    transform:translateY(-3px);
    background:rgba(255,255,255,0.15);
}

/* =========================
SUMMARY CARD
========================= */

.summary-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.summary-card{
    padding:24px;
    border-radius:24px;

    background:rgba(255,255,255,0.06);
    border:1px solid rgba(255,255,255,0.08);

    backdrop-filter:blur(18px);

    transition:.3s;
}

.summary-card:hover{
    transform:translateY(-6px);
    background:rgba(255,255,255,0.09);
}

.summary-value{
    font-size:34px;
    font-weight:800;
    color:#38bdf8;
}

.summary-label{
    color:#94a3b8;
    margin-top:8px;
}

/* =========================
TABLE CARD
========================= */

.table-card{
    background:rgba(255,255,255,0.05);
    border:1px solid rgba(255,255,255,0.08);

    backdrop-filter:blur(18px);

    border-radius:24px;
    overflow:hidden;
}

.table-header{
    padding:20px 25px;
    border-bottom:1px solid rgba(255,255,255,0.08);

    font-size:20px;
    font-weight:700;
}

/* =========================
TABLE
========================= */

table{
    width:100%;
    border-collapse:collapse;
}

thead{
    background:rgba(255,255,255,0.04);
}

th{
    text-align:left;
    padding:18px;
    color:#cbd5e1;
    font-size:13px;
    text-transform:uppercase;
    letter-spacing:1px;
}

td{
    padding:18px;
    border-top:1px solid rgba(255,255,255,0.05);
}

tbody tr{
    transition:.3s;
}

tbody tr:hover{
    background:rgba(255,255,255,0.06);
}

/* =========================
BADGES
========================= */

.badge{
    padding:6px 12px;
    border-radius:999px;
    font-size:12px;
    font-weight:600;
}

.badge-success{
    background:#22c55e;
    color:white;
}

/* =========================
EMPTY
========================= */

.empty{
    text-align:center;
    padding:50px;
    color:#94a3b8;
}

/* =========================
RESPONSIVE
========================= */

@media(max-width:768px){

    .page-wrapper{
        padding:20px;
    }

    table{
        display:block;
        overflow-x:auto;
    }

    .page-title{
        font-size:26px;
    }
}

</style>

<div class="page-wrapper">

    <!-- HEADER -->
    <div class="page-header">

        <div>

            <div class="page-title">
                👥 Branch Sellers
            </div>

            <div class="page-subtitle">
                <?= Html::encode($branch->name) ?>
            </div>

        </div>

        <a href="<?= \yii\helpers\Url::to(['view','id'=>$branch->id]) ?>"
           class="back-btn">
            ← Back Dashboard
        </a>

    </div>

    <!-- SUMMARY -->
    <div class="summary-grid">

        <div class="summary-card">

            <div class="summary-value">
                <?= $totalSellers ?>
            </div>

            <div class="summary-label">
                Total Sellers
            </div>

        </div>

    </div>

    <!-- TABLE -->
    <div class="table-card">

        <div class="table-header">
            Seller List
        </div>

        <?php if (!empty($sellers)): ?>

            <table>

                <thead>

                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Status</th>
                    </tr>

                </thead>

                <tbody>

                <?php foreach ($sellers as $index => $seller): ?>

                    <tr>

                        <td>
                            <?= $index + 1 ?>
                        </td>

                        <td>
                            <?= Html::encode($seller->username) ?>
                        </td>

                        <td>
                            <span class="badge badge-success">
                                Active
                            </span>
                        </td>

                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        <?php else: ?>

            <div class="empty">
                No sellers found in this branch.
            </div>

        <?php endif; ?>

    </div>

</div>