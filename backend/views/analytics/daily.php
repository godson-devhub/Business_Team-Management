<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$this->title = 'Daily Analytics Report';

$branchOptions = ArrayHelper::map($branches, 'id', 'name');
$ajaxUrl = Url::to(['analytics/daily-ajax']);
?>

<div class="page-container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?= Url::to(['analytics/index']) ?>">
            <i data-lucide="chevron-left" class="icon-16"></i>
            Analytics
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Daily Report</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Daily Analytics</h1>
            <p class="page-subtitle">Realtime branch performance by date</p>
        </div>
        <div class="live-badge">
            <span class="status-dot online"></span>
            Live
        </div>
    </div>

    <!-- Filters -->
    <div class="filter-card">
        <div class="filter-grid">
            <div class="filter-group">
                <label class="filter-label">
                    <i data-lucide="git-branch" class="icon-14"></i>
                    Branch
                </label>
                <?= Html::dropDownList('branch_id', $branch_id ?? '', $branchOptions, [
                    'class' => 'form-control',
                    'id' => 'branch_id'
                ]) ?>
            </div>
            <div class="filter-group">
                <label class="filter-label">
                    <i data-lucide="calendar" class="icon-14"></i>
                    Date
                </label>
                <input type="date" id="date" value="<?= Html::encode($date ?? date('Y-m-d')) ?>" class="form-control">
            </div>
            <div class="filter-group">
                <label class="filter-label">&nbsp;</label>
                <button class="btn btn-primary" id="refreshBtn">
                    <i data-lucide="refresh-cw" class="icon-16"></i>
                    Load Realtime
                </button>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="stats-row">
        <div class="stat-card highlight-blue">
            <div class="stat-header">
                <span class="stat-title">Total Sales</span>
                <div class="stat-icon-sm" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                    <i data-lucide="banknote" class="icon-16"></i>
                </div>
            </div>
            <div class="stat-number" id="sales">TZS 0</div>
            <div class="stat-trend">Revenue today</div>
        </div>
        <div class="stat-card highlight-green">
            <div class="stat-header">
                <span class="stat-title">Total Profit</span>
                <div class="stat-icon-sm" style="background: rgba(34,197,94,0.15); color: #22c55e;">
                    <i data-lucide="trending-up" class="icon-16"></i>
                </div>
            </div>
            <div class="stat-number" id="profit">TZS 0</div>
            <div class="stat-trend">Net earnings</div>
        </div>
        <div class="stat-card highlight-purple">
            <div class="stat-header">
                <span class="stat-title">Transactions</span>
                <div class="stat-icon-sm" style="background: rgba(139,92,246,0.15); color: #8b5cf6;">
                    <i data-lucide="receipt" class="icon-16"></i>
                </div>
            </div>
            <div class="stat-number" id="transactions">0</div>
            <div class="stat-trend">Completed sales</div>
        </div>
        <div class="stat-card highlight-orange">
            <div class="stat-header">
                <span class="stat-title">Avg Sale</span>
                <div class="stat-icon-sm" style="background: rgba(245,158,11,0.15); color: #f59e0b;">
                    <i data-lucide="calculator" class="icon-16"></i>
                </div>
            </div>
            <div class="stat-number" id="avg">TZS 0</div>
            <div class="stat-trend">Per transaction</div>
        </div>
    </div>

    <!-- Summary Card -->
    <div class="summary-card">
        <h3 class="summary-title">
            <i data-lucide="activity" class="icon-18"></i>
            Live Summary
        </h3>
        <div class="summary-grid">
            <div class="summary-item">
                <span class="summary-label">Best Product</span>
                <span class="summary-value" id="best">-</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Worst Product</span>
                <span class="summary-value" id="worst">-</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Stock Impact</span>
                <span class="summary-value" id="stock">-</span>
            </div>
        </div>
    </div>

</div>

<style>
/* ============================================
   LIVE BADGE
   ============================================ */
.live-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 14px;
    border-radius: 20px;
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: var(--success);
    font-size: 12px;
    font-weight: 600;
}

/* ============================================
   FILTER CARD
   ============================================ */
.filter-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 20px;
    margin-bottom: 24px;
}

.filter-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.filter-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.filter-label i {
    color: var(--primary);
}

/* ============================================
   HIGHLIGHT STAT CARDS
   ============================================ */
.stat-card.highlight-blue {
    border-color: rgba(59, 130, 246, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(59, 130, 246, 0.05));
}

.stat-card.highlight-green {
    border-color: rgba(34, 197, 94, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(34, 197, 94, 0.05));
}

.stat-card.highlight-purple {
    border-color: rgba(139, 92, 246, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(139, 92, 246, 0.05));
}

.stat-card.highlight-orange {
    border-color: rgba(245, 158, 11, 0.3);
    background: linear-gradient(135deg, var(--card-bg), rgba(245, 158, 11, 0.05));
}

/* ============================================
   SUMMARY CARD
   ============================================ */
.summary-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-top: 24px;
}

.summary-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 15px;
    font-weight: 600;
    color: var(--text);
    margin: 0 0 20px 0;
}

.summary-title i {
    color: var(--primary);
}

.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 16px;
}

.summary-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
    padding: 16px;
    background: var(--bg-elevated);
    border-radius: var(--radius);
    border: 1px solid var(--border);
}

.summary-label {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.summary-value {
    font-size: 16px;
    font-weight: 600;
    color: var(--text);
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .filter-grid {
        grid-template-columns: 1fr;
    }
    .filter-group:last-child {
        margin-top: 8px;
    }
    .summary-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
let isLoading = false;
let interval = null;

function loadData() {
    if (isLoading) return;
    isLoading = true;

    let branch = $('#branch_id').val();
    let date = $('#date').val();

    $.ajax({
        url: '<?= $ajaxUrl ?>',
        type: 'GET',
        data: { branch_id: branch, date: date },
        success: function(res) {
            if (!res) return;

            $('#sales').text('TZS ' + (res.sales || 0));
            $('#profit').text('TZS ' + (res.profit || 0));
            $('#transactions').text(res.transactions || 0);
            $('#avg').text('TZS ' + (res.avg || 0));
            $('#best').text(res.best_product || '-');
            $('#worst').text(res.worst_product || '-');
            $('#stock').text(res.stock_impact || '-');
        },
        complete: function() {
            isLoading = false;
        },
        error: function() {
            isLoading = false;
        }
    });
}

$(document).ready(function() {
    loadData();
    interval = setInterval(function() {
        loadData();
    }, 15000);
});

$('#branch_id, #date').on('change', function() {
    loadData();
});

$('#refreshBtn').on('click', function(e) {
    e.preventDefault();
    loadData();
});

$(window).on('beforeunload', function() {
    if (interval) clearInterval(interval);
});

if (typeof lucide !== 'undefined') lucide.createIcons();
</script>