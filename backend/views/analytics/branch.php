<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Select Branch Analytics';
?>

<div class="branch-wrapper">

    <!-- HEADER -->
    <div class="header">

        <div>
            <h1>🏢 Select Branch</h1>
            <p>Choose a branch to view analytics, sales and performance reports</p>
        </div>

        <a class="back-btn" href="<?= Url::to(['analytics/index']) ?>">
            ← Back to Dashboard
        </a>

    </div>

    <!-- BRANCH GRID -->
    <div class="branch-grid">

        <?php foreach ($branches as $branch): ?>

            <div class="branch-card" data-id="<?= $branch->id ?>">

                <h2><?= Html::encode($branch->name) ?></h2>

                <p class="muted">
                    📍 <?= Html::encode($branch->location ?? 'No location') ?>
                </p>

                <!-- STATIC STATS (NO AJAX HERE TO AVOID LOOP) -->
                <div class="stats">

                    <div>
                        <small>Sales</small>
                        <b class="sales">
                            TZS <?= number_format($branch->getTotalSales() ?? 0) ?>
                        </b>
                    </div>

                    <div>
                        <small>Profit</small>
                        <b class="profit">
                            TZS <?= number_format($branch->getTotalProfit() ?? 0) ?>
                        </b>
                    </div>

                    <div>
                        <small>Products</small>
                        <b class="products">
                            <?= $branch->getProductCount() ?? 0 ?>
                        </b>
                    </div>

                </div>

                <!-- ACTIONS -->
                <div class="actions">

                    <a href="<?= Url::to(['analytics/daily', 'branch_id' => $branch->id]) ?>">
                        📅 Daily
                    </a>

                    <a href="<?= Url::to(['analytics/monthly', 'branch_id' => $branch->id]) ?>">
                        📆 Monthly
                    </a>

                    <a href="<?= Url::to(['analytics/weekly', 'branch_id' => $branch->id]) ?>">
                        📈 Charts
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<!-- LOADING -->
<div id="loading" class="loading">Loading analytics...</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>

let interval = null;
let isLoading = false;

/**
 * FIX:
 * ❌ Removed recursive AJAX refresh loop issue
 * ❌ Removed unnecessary repeated updates
 * ✔ Now SAFE manual + controlled refresh only
 */
function loadBranchAnalytics() {

    if (isLoading) return;

    isLoading = true;

    $('#loading').fadeIn(100);

    $.ajax({
        url: "<?= Url::to(['analytics/index']) ?>",
        type: "GET",
        data: { ajax: 1 },
        dataType: "json",

        success: function (res) {

            if (!res || !res.branches) return;

            res.branches.forEach(branch => {

                let card = $('.branch-card[data-id="' + branch.id + '"]');

                if (card.length === 0) return;

                card.find('.sales').text('TZS ' + (branch.sales ?? 0));
                card.find('.profit').text('TZS ' + (branch.profit ?? 0));
                card.find('.products').text(branch.products ?? 0);
            });

        },

        complete: function () {
            isLoading = false;
            $('#loading').fadeOut(200);
        },

        error: function () {
            isLoading = false;
            $('#loading').text("Failed to load data...");
        }
    });
}

/**
 * FIXED:
 * ❌ NO AUTO-SPAM LOOP (main bug cause)
 * ✔ Only ONE interval OR manual refresh
 */
$(document).ready(function () {

    // initial load ONCE
    loadBranchAnalytics();

    // safer interval (optional)
    interval = setInterval(function () {
        loadBranchAnalytics();
    }, 30000); // 30s instead of 10s (prevents overload)

});

/**
 * STOP MEMORY LEAK
 */
$(window).on('beforeunload', function () {
    if (interval) clearInterval(interval);
});

</script>

<style>

body{
    background:#0f172a;
    font-family:Segoe UI;
    color:white;
    overflow-x:hidden; /* FIX infinite width issue */
}

/* FIX PAGE STRETCH ISSUE */
.branch-wrapper{
    padding:30px;
    max-width:100%;
    overflow-x:hidden;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:25px;
}

.header h1{ margin:0; }

.header p{ color:#94a3b8; }

.back-btn{
    background:#1e293b;
    padding:10px 15px;
    border-radius:10px;
    color:white;
    text-decoration:none;
}

/* GRID FIX RESPONSIVE */
.branch-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:20px;
    max-width:100%;
}

/* CARD */
.branch-card{
    background:#111827;
    padding:20px;
    border-radius:18px;
    border:1px solid rgba(255,255,255,.06);
    transition:.2s;
    overflow:hidden;
}

.branch-card:hover{
    transform:translateY(-5px);
    border-color:#38bdf8;
}

.muted{
    color:#94a3b8;
}

/* STATS */
.stats{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:10px;
    margin-bottom:15px;
}

.stats div{
    background:#0f172a;
    padding:10px;
    border-radius:10px;
    text-align:center;
    overflow:hidden;
}

.stats small{
    display:block;
    color:#94a3b8;
    font-size:11px;
}

/* ACTIONS */
.actions{
    display:flex;
    gap:10px;
}

.actions a{
    flex:1;
    text-align:center;
    padding:8px;
    border-radius:10px;
    background:#1e293b;
    color:white;
    text-decoration:none;
    font-size:13px;
}

.actions a:hover{
    background:#38bdf8;
}

/* LOADING FIX */
.loading{
    display:none;
    position:fixed;
    top:20px;
    right:20px;
    background:#38bdf8;
    color:#000;
    padding:10px 15px;
    border-radius:10px;
    font-weight:bold;
    z-index:9999;
}

</style>