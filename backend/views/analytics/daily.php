<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Daily Analytics Report';

$branchOptions = ArrayHelper::map($branches, 'id', 'name');
$ajaxUrl = Url::to(['analytics/daily-ajax']);
?>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<div class="daily-wrapper">

    <!-- HEADER -->
    <div class="header">

        <div>
            <h1>📅 Daily Analytics (Realtime)</h1>
            <p>Branch + Date based live reporting system</p>
        </div>

        <a href="<?= Url::to(['analytics/index']) ?>" class="back-btn">
            ← Back
        </a>

    </div>

    <!-- FILTERS -->
    <div class="filter-card">

        <div class="grid">

            <div>
                <label>Branch</label>

                <?= Html::dropDownList(
                    'branch_id',
                    $branch_id ?? '',
                    $branchOptions,
                    [
                        'class' => 'input',
                        'id' => 'branch_id'
                    ]
                ) ?>
            </div>

            <div>
                <label>Select Date</label>

                <input type="date"
                       id="date"
                       value="<?= Html::encode($date ?? date('Y-m-d')) ?>"
                       class="input">
            </div>

            <div>
                <label>Action</label>

                <button class="btn" id="refreshBtn">
                    🔄 Load Realtime
                </button>
            </div>

        </div>

    </div>

    <!-- KPI CARDS -->
    <div class="cards">

        <div class="card blue">
            <h3>Total Sales</h3>
            <p id="sales">TZS 0</p>
        </div>

        <div class="card green">
            <h3>Total Profit</h3>
            <p id="profit">TZS 0</p>
        </div>

        <div class="card purple">
            <h3>Transactions</h3>
            <p id="transactions">0</p>
        </div>

        <div class="card orange">
            <h3>Avg Sale</h3>
            <p id="avg">TZS 0</p>
        </div>

    </div>

    <!-- SUMMARY -->
    <div class="summary-card">

        <h3>📊 Live Summary</h3>

        <div class="summary-row">
            <span>Best Product</span>
            <b id="best">-</b>
        </div>

        <div class="summary-row">
            <span>Worst Product</span>
            <b id="worst">-</b>
        </div>

        <div class="summary-row">
            <span>Stock Impact</span>
            <b id="stock">-</b>
        </div>

    </div>

</div>

<style>

body{
    background:#0f172a;
    font-family:Segoe UI;
    color:white;
}

.daily-wrapper{
    padding:30px;
}

/* HEADER */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
}

.header p{ color:#94a3b8; }

.back-btn{
    background:#1e293b;
    padding:10px 15px;
    border-radius:10px;
    color:white;
    text-decoration:none;
}

/* FILTER */
.filter-card{
    background:#111827;
    padding:20px;
    border-radius:15px;
    margin-bottom:20px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:15px;
}

.input{
    width:100%;
    padding:10px;
    border-radius:10px;
    background:#1e293b;
    border:none;
    color:white;
}

/* BUTTON */
.btn{
    width:100%;
    padding:10px;
    border:none;
    border-radius:10px;
    background:#38bdf8;
    color:white;
    cursor:pointer;
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
    gap:15px;
    margin-bottom:20px;
}

.card{
    background:#111827;
    padding:20px;
    border-radius:15px;
    border-left:4px solid transparent;
}

.card h3{ margin:0; color:#94a3b8; }
.card p{ font-size:22px; margin-top:10px; }

.blue{border-color:#38bdf8;}
.green{border-color:#22c55e;}
.purple{border-color:#8b5cf6;}
.orange{border-color:#f97316;}

/* SUMMARY */
.summary-card{
    background:#111827;
    padding:20px;
    border-radius:15px;
}

.summary-row{
    display:flex;
    justify-content:space-between;
    padding:10px;
    border-bottom:1px solid rgba(255,255,255,.05);
}

.summary-row span{ color:#94a3b8; }

</style>

<script>

let isLoading = false;
let interval = null;

// ===========================
// SAFE AJAX LOADER
// ===========================
function loadData(){

    if(isLoading) return; // 🔥 prevent infinite overlapping requests

    isLoading = true;

    let branch = $('#branch_id').val();
    let date   = $('#date').val();

    $.ajax({

        url: '<?= $ajaxUrl ?>',

        type: 'GET',

        data: {
            branch_id: branch,
            date: date
        },

        success: function(res){

            if(!res) return;

            $('#sales').text('TZS ' + (res.sales || 0));
            $('#profit').text('TZS ' + (res.profit || 0));
            $('#transactions').text(res.transactions || 0);
            $('#avg').text('TZS ' + (res.avg || 0));

            $('#best').text(res.best_product || '-');
            $('#worst').text(res.worst_product || '-');
            $('#stock').text(res.stock_impact || '-');
        },

        complete: function(){
            isLoading = false; // unlock request
        },

        error: function(){
            isLoading = false;
        }

    });
}

// ===========================
// INITIAL LOAD (ONLY ONCE)
// ===========================
$(document).ready(function(){

    loadData();

    // safe interval (no stacking)
    interval = setInterval(function(){
        loadData();
    }, 15000);

});

// ===========================
// FILTER CHANGE
// ===========================
$('#branch_id, #date').on('change', function(){
    loadData();
});

// ===========================
// BUTTON REFRESH
// ===========================
$('#refreshBtn').on('click', function(e){
    e.preventDefault();
    loadData();
});

// ===========================
// CLEANUP
// ===========================
$(window).on('beforeunload', function(){
    if(interval){
        clearInterval(interval);
    }
});

</script>