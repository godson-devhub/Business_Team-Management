<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Select Branch Analytics';
?>

<div class="page-container">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Select Branch</h1>
            <p class="page-subtitle">Choose a branch to view analytics, sales and performance reports</p>
        </div>
        <a href="<?= Url::to(['analytics/index']) ?>" class="btn btn-secondary">
            <i data-lucide="arrow-left" class="icon-16"></i>
            Back to Dashboard
        </a>
    </div>

    <!-- Branch Grid -->
    <div class="branch-grid">

        <?php foreach ($branches as $branch): ?>

            <div class="branch-card" data-id="<?= $branch->id ?>">

                <div class="branch-header">
                    <div class="branch-icon">
                        <i data-lucide="store" class="icon-20"></i>
                    </div>
                    <div class="branch-status">
                        <span class="status-badge active">
                            <span class="status-dot online"></span>
                            Active
                        </span>
                    </div>
                </div>

                <div class="branch-body">
                    <h3 class="branch-name"><?= Html::encode($branch->name) ?></h3>
                    <div class="branch-location">
                        <i data-lucide="map-pin" class="icon-14"></i>
                        <?= Html::encode($branch->location ?? 'No location') ?>
                    </div>
                </div>

                <!-- Stats -->
                <div class="branch-stats">
                    <div class="stat-item">
                        <span class="stat-label">Sales</span>
                        <span class="stat-value sales">TZS <?= number_format($branch->getTotalSales() ?? 0) ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Profit</span>
                        <span class="stat-value profit">TZS <?= number_format($branch->getTotalProfit() ?? 0) ?></span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Products</span>
                        <span class="stat-value products"><?= $branch->getProductCount() ?? 0 ?></span>
                    </div>
                </div>

                <!-- Actions -->
                <div class="branch-actions">
                    <a href="<?= Url::to(['analytics/daily', 'branch_id' => $branch->id]) ?>" class="action-link">
                        <i data-lucide="calendar" class="icon-14"></i>
                        Daily
                    </a>
                    <a href="<?= Url::to(['analytics/monthly', 'branch_id' => $branch->id]) ?>" class="action-link">
                        <i data-lucide="calendar-days" class="icon-14"></i>
                        Monthly
                    </a>
                    <a href="<?= Url::to(['analytics/weekly', 'branch_id' => $branch->id]) ?>" class="action-link">
                        <i data-lucide="bar-chart-3" class="icon-14"></i>
                        Charts
                    </a>
                </div>

            </div>

        <?php endforeach; ?>

        <?php if (empty($branches)): ?>
            <div class="empty-state" style="grid-column: 1 / -1;">
                <div class="empty-icon">
                    <i data-lucide="store" class="icon-48"></i>
                </div>
                <h3>No branches available</h3>
                <p>Create a branch first to view analytics</p>
            </div>
        <?php endif; ?>

    </div>

</div>

<!-- Loading Indicator -->
<div id="loading" class="loading-toast">
    <i data-lucide="loader-2" class="icon-16 spin"></i>
    Loading analytics...
</div>

<style>
/* ============================================
   BRANCH GRID
   ============================================ */
.branch-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

/* ============================================
   BRANCH CARD
   ============================================ */
.branch-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.branch-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--border-strong);
}

.branch-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
}

.branch-icon {
    width: 44px;
    height: 44px;
    border-radius: var(--radius);
    background: linear-gradient(135deg, var(--primary), #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 12px var(--primary-glow);
}

.branch-name {
    font-size: 18px;
    font-weight: 600;
    color: var(--text);
    margin: 0 0 6px 0;
}

.branch-location {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: var(--text-muted);
}

/* ============================================
   BRANCH STATS
   ============================================ */
.branch-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 12px;
    padding: 16px;
    background: var(--bg-elevated);
    border-radius: var(--radius);
    border: 1px solid var(--border);
}

.stat-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
    text-align: center;
}

.stat-item .stat-label {
    font-size: 11px;
    color: var(--text-muted);
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.stat-item .stat-value {
    font-size: 14px;
    font-weight: 700;
    color: var(--text);
    font-family: 'JetBrains Mono', monospace;
}

.stat-item .stat-value.sales {
    color: #3b82f6;
}

.stat-item .stat-value.profit {
    color: #22c55e;
}

.stat-item .stat-value.products {
    color: #f59e0b;
}

/* ============================================
   BRANCH ACTIONS
   ============================================ */
.branch-actions {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 8px;
}

.action-link {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px;
    border-radius: var(--radius);
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    color: var(--text-secondary);
    font-size: 12px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.action-link:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
}

.action-link i {
    transition: transform 0.2s ease;
}

.action-link:hover i {
    transform: scale(1.1);
}

/* ============================================
   LOADING TOAST
   ============================================ */
.loading-toast {
    display: none;
    position: fixed;
    top: 20px;
    right: 20px;
    align-items: center;
    gap: 8px;
    padding: 12px 20px;
    border-radius: var(--radius-lg);
    background: var(--surface);
    border: 1px solid var(--border);
    color: var(--text);
    font-size: 13px;
    font-weight: 600;
    box-shadow: var(--shadow-lg);
    z-index: 9999;
}

.spin {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .branch-grid {
        grid-template-columns: 1fr;
    }
    .branch-stats {
        grid-template-columns: 1fr;
    }
    .branch-actions {
        grid-template-columns: 1fr;
    }
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let interval = null;
let isLoading = false;

function loadBranchAnalytics() {
    if (isLoading) return;
    isLoading = true;

    $('#loading').fadeIn(100).css('display', 'flex');

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

$(document).ready(function () {
    loadBranchAnalytics();
    interval = setInterval(function () {
        loadBranchAnalytics();
    }, 30000);
});

$(window).on('beforeunload', function () {
    if (interval) clearInterval(interval);
});

// Init Lucide icons
if (typeof lucide !== 'undefined') lucide.createIcons();
</script>