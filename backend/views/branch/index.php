<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch[] $branches
 */

$this->title = 'Branches';
?>

<div class="page-container">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Branches</h1>
            <p class="page-subtitle">Manage all your business locations</p>
        </div>
        <a href="<?= Url::to(['branch/create']) ?>" class="btn btn-primary">
            <i data-lucide="plus" class="icon-16"></i>
            Create Branch
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                <i data-lucide="git-branch" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= count($branches) ?></div>
                <div class="stat-label">Total Branches</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34,197,94,0.15); color: #22c55e;">
                <i data-lucide="map-pin" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">Active</div>
                <div class="stat-label">Status</div>
            </div>
        </div>
    </div>

    <!-- Branch Grid -->
    <div class="branch-grid">

        <?php foreach ($branches as $b): ?>

            <div class="branch-card">

                <div class="branch-header">
                    <div class="branch-icon">
                        <i data-lucide="store" class="icon-20"></i>
                    </div>
                    <div class="card-actions">
                        <a href="<?= Url::to(['branch/update', 'id' => $b->id]) ?>" class="action-btn" title="Edit">
                            <i data-lucide="pencil" class="icon-16"></i>
                        </a>
                        <a href="<?= Url::to(['branch/delete', 'id' => $b->id]) ?>" 
                           class="action-btn danger" 
                           title="Delete"
                           onclick="return confirm('Delete this branch?')">
                            <i data-lucide="trash-2" class="icon-16"></i>
                        </a>
                    </div>
                </div>

                <div class="card-content">
                    <h3 class="branch-name"><?= Html::encode($b->name) ?></h3>
                    <div class="branch-location">
                        <i data-lucide="map-pin" class="icon-14"></i>
                        <?= Html::encode($b->location ?: 'No location set') ?>
                    </div>
                    <div class="branch-business">
                        <i data-lucide="building" class="icon-14"></i>
                        <?= Html::encode($b->business->name ?? 'No business') ?>
                    </div>
                </div>

                <a href="<?= Url::to(['branch/view', 'id' => $b->id]) ?>" class="view-link">
                    View Dashboard
                    <i data-lucide="arrow-right" class="icon-16"></i>
                </a>

                <div class="card-glow"></div>

            </div>

        <?php endforeach; ?>

        <?php if (empty($branches)): ?>
            <div class="empty-state" style="grid-column: 1 / -1;">
                <div class="empty-icon">
                    <i data-lucide="git-branch" class="icon-48"></i>
                </div>
                <h3>No branches yet</h3>
                <p>Create your first branch to manage locations</p>
                <a href="<?= Url::to(['branch/create']) ?>" class="btn btn-primary">
                    Create Branch
                </a>
            </div>
        <?php endif; ?>

    </div>

</div>

<style>
/* ============================================
   PAGE HEADER
   ============================================ */
.page-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 28px;
    gap: 16px;
    flex-wrap: wrap;
}

.page-title {
    font-size: 28px;
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.5px;
    margin: 0 0 6px 0;
}

.page-subtitle {
    font-size: 14px;
    color: var(--text-muted);
    margin: 0;
}

/* ============================================
   STATS ROW
   ============================================ */
.stats-row {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 16px;
    margin-bottom: 28px;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 20px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    transition: all 0.25s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
    border-color: var(--border-strong);
}

.stat-icon {
    width: 44px;
    height: 44px;
    border-radius: var(--radius);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.stat-info {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.stat-value {
    font-size: 20px;
    font-weight: 700;
    color: var(--text);
    line-height: 1.2;
}

.stat-label {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
}

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
    position: relative;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 24px;
    display: flex;
    flex-direction: column;
    gap: 16px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

.branch-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--border-strong);
}

.branch-card:hover .card-glow {
    opacity: 1;
}

.card-glow {
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, var(--primary-glow) 0%, transparent 70%);
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none;
    z-index: 0;
}

.branch-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}

.branch-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius);
    background: linear-gradient(135deg, #f59e0b, #ef4444);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.card-actions {
    display: flex;
    gap: 6px;
    opacity: 0;
    transform: translateY(-4px);
    transition: all 0.2s ease;
}

.branch-card:hover .card-actions {
    opacity: 1;
    transform: translateY(0);
}

.card-content {
    position: relative;
    z-index: 1;
    flex: 1;
}

.branch-name {
    font-size: 18px;
    font-weight: 600;
    color: var(--text);
    margin: 0 0 10px 0;
}

.branch-location,
.branch-business {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: var(--text-muted);
    margin-bottom: 6px;
}

.branch-business {
    margin-bottom: 0;
}

.view-link {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 10px;
    border-radius: var(--radius);
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
}

.view-link:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    gap: 10px;
}

/* ============================================
   EMPTY STATE
   ============================================ */
.empty-state {
    grid-column: 1 / -1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 80px 20px;
    text-align: center;
    background: var(--card-bg);
    border: 1px dashed var(--border);
    border-radius: var(--radius-lg);
}

.empty-icon {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    background: var(--bg-elevated);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    margin-bottom: 20px;
}

.empty-state h3 {
    font-size: 18px;
    font-weight: 600;
    color: var(--text);
    margin: 0 0 8px 0;
}

.empty-state p {
    font-size: 14px;
    color: var(--text-muted);
    margin: 0 0 20px 0;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .stats-row {
        grid-template-columns: 1fr;
    }
    .branch-grid {
        grid-template-columns: 1fr;
    }
    .card-actions {
        opacity: 1;
        transform: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>