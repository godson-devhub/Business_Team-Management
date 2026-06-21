<?php

use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var \common\models\Business[] $businesses
 */

$this->title = 'My Businesses';
?>

<div class="page-container">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">My Businesses</h1>
            <p class="page-subtitle">Manage and oversee all your business operations</p>
        </div>
        <a href="<?= Url::to(['business/create']) ?>" class="btn btn-primary">
            <i data-lucide="plus" class="icon-16"></i>
            Create Business
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                <i data-lucide="building-2" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= count($businesses) ?></div>
                <div class="stat-label">Total Businesses</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34,197,94,0.15); color: #22c55e;">
                <i data-lucide="trending-up" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">Active</div>
                <div class="stat-label">Status</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245,158,11,0.15); color: #f59e0b;">
                <i data-lucide="git-branch" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">—</div>
                <div class="stat-label">Total Branches</div>
            </div>
        </div>
    </div>

    <!-- Business Grid -->
    <div class="business-grid">

        <?php foreach ($businesses as $b): ?>

            <div class="business-card">

                <!-- Card Header -->
                <div class="card-header-area">
                    <div class="business-icon">
                        <i data-lucide="building" class="icon-24"></i>
                    </div>
                    <div class="card-actions">
                        <a href="<?= Url::to(['business/update', 'id' => $b->id]) ?>" 
                           class="action-btn" title="Edit">
                            <i data-lucide="pencil" class="icon-16"></i>
                        </a>
                        <a href="<?= Url::to(['business/delete', 'id' => $b->id]) ?>" 
                           class="action-btn danger" 
                           title="Delete"
                           onclick="return confirm('Delete this business?')">
                            <i data-lucide="trash-2" class="icon-16"></i>
                        </a>
                    </div>
                </div>

                <!-- Card Content -->
                <div class="card-content">
                    <h3 class="business-name"><?= Html::encode($b->name) ?></h3>
                    <p class="business-desc"><?= Html::encode($b->description) ?></p>
                </div>

                <!-- Card Footer -->
                <div class="card-footer">
                    <a href="<?= Url::to(['business/view', 'id' => $b->id]) ?>" class="view-link">
                        View Details
                        <i data-lucide="arrow-right" class="icon-16"></i>
                    </a>
                </div>

                <!-- Hover Glow Effect -->
                <div class="card-glow"></div>

            </div>

        <?php endforeach; ?>

        <?php if (empty($businesses)): ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i data-lucide="building-2" class="icon-48"></i>
                </div>
                <h3>No businesses yet</h3>
                <p>Create your first business to get started</p>
                <a href="<?= Url::to(['business/create']) ?>" class="btn btn-primary">
                    Create Business
                </a>
            </div>
        <?php endif; ?>

    </div>

</div>

<style>
/* ============================================
   PAGE CONTAINER
   ============================================ */
.page-container {
    max-width: 1200px;
    margin: 0 auto;
}

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
    grid-template-columns: repeat(3, 1fr);
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
   BUSINESS GRID
   ============================================ */
.business-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 20px;
}

/* ============================================
   BUSINESS CARD
   ============================================ */
.business-card {
    position: relative;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 24px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.business-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--border-strong);
}

.business-card:hover .card-glow {
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

/* Card Header */
.card-header-area {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}

.business-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius);
    background: linear-gradient(135deg, var(--primary), #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 12px var(--primary-glow);
}

.card-actions {
    display: flex;
    gap: 6px;
    opacity: 0;
    transform: translateY(-4px);
    transition: all 0.2s ease;
}

.business-card:hover .card-actions {
    opacity: 1;
    transform: translateY(0);
}

.action-btn {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-sm);
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    color: var(--text-secondary);
    transition: all 0.15s ease;
}

.action-btn:hover {
    background: var(--surface-hover);
    color: var(--text);
    transform: scale(1.05);
}

.action-btn.danger:hover {
    background: rgba(239, 68, 68, 0.15);
    color: var(--danger);
    border-color: rgba(239, 68, 68, 0.3);
}

/* Card Content */
.card-content {
    position: relative;
    z-index: 1;
    flex: 1;
}

.business-name {
    font-size: 18px;
    font-weight: 600;
    color: var(--text);
    margin: 0 0 8px 0;
    line-height: 1.3;
}

.business-desc {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
    line-height: 1.5;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Card Footer */
.card-footer {
    position: relative;
    z-index: 1;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}

.view-link {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--primary);
    transition: all 0.2s ease;
}

.view-link:hover {
    gap: 10px;
    color: var(--primary-hover);
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
    .business-grid {
        grid-template-columns: 1fr;
    }
    .page-header {
        flex-direction: column;
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