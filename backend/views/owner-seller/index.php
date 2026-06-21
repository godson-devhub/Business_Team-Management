<?php

use yii\helpers\Html;
use yii\helpers\Url;

/** @var array $sellers */

$this->title = 'Manage Sellers';
?>

<div class="page-container">

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Sellers</h1>
            <p class="page-subtitle">Manage your team members and branch assignments</p>
        </div>
        <a href="<?= Url::to(['/owner-seller/create']) ?>" class="btn btn-primary">
            <i data-lucide="plus" class="icon-16"></i>
            Add Seller
        </a>
    </div>

    <!-- Stats Overview -->
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(59,130,246,0.15); color: #3b82f6;">
                <i data-lucide="users" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value"><?= count($sellers) ?></div>
                <div class="stat-label">Total Sellers</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(34,197,94,0.15); color: #22c55e;">
                <i data-lucide="user-check" class="icon-20"></i>
            </div>
            <div class="stat-info">
                <div class="stat-value">Active</div>
                <div class="stat-label">Status</div>
            </div>
        </div>
    </div>

    <!-- Sellers Grid -->
    <div class="sellers-grid">

        <?php foreach ($sellers as $s): ?>

            <div class="seller-card">

                <div class="seller-header">
                    <div class="seller-avatar">
                        <?= strtoupper(substr($s->username, 0, 1)) ?>
                    </div>
                    <div class="card-actions">
                        <a href="<?= Url::to(['/owner-seller/update', 'id' => $s->id]) ?>" class="action-btn" title="Edit">
                            <i data-lucide="pencil" class="icon-16"></i>
                        </a>
                        <a href="<?= Url::to(['/owner-seller/delete', 'id' => $s->id]) ?>" 
                           class="action-btn danger" 
                           title="Delete"
                           onclick="return confirm('Delete this seller?')">
                            <i data-lucide="trash-2" class="icon-16"></i>
                        </a>
                    </div>
                </div>

                <div class="seller-body">
                    <h3 class="seller-name"><?= Html::encode($s->username) ?></h3>
                    <div class="seller-email">
                        <i data-lucide="mail" class="icon-14"></i>
                        <?= Html::encode($s->email) ?>
                    </div>
                    <div class="seller-branch">
                        <i data-lucide="git-branch" class="icon-14"></i>
                        <?= $s->branch->name ?? 'Not assigned' ?>
                    </div>
                </div>

                <div class="seller-footer">
                    <span class="status-badge active">
                        <span class="status-dot online"></span>
                        Active
                    </span>
                </div>

                <div class="card-glow"></div>

            </div>

        <?php endforeach; ?>

        <?php if (empty($sellers)): ?>
            <div class="empty-state" style="grid-column: 1 / -1;">
                <div class="empty-icon">
                    <i data-lucide="users" class="icon-48"></i>
                </div>
                <h3>No sellers yet</h3>
                <p>Add your first seller to start building your team</p>
                <a href="<?= Url::to(['/owner-seller/create']) ?>" class="btn btn-primary">
                    Add Seller
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
   SELLERS GRID
   ============================================ */
.sellers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 20px;
}

/* ============================================
   SELLER CARD
   ============================================ */
.seller-card {
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

.seller-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-lg);
    border-color: var(--border-strong);
}

.seller-card:hover .card-glow {
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

.seller-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    position: relative;
    z-index: 1;
}

.seller-avatar {
    width: 52px;
    height: 52px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    font-weight: 700;
    color: white;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    flex-shrink: 0;
    box-shadow: 0 4px 12px var(--primary-glow);
}

.card-actions {
    display: flex;
    gap: 6px;
    opacity: 0;
    transform: translateY(-4px);
    transition: all 0.2s ease;
}

.seller-card:hover .card-actions {
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

.seller-body {
    position: relative;
    z-index: 1;
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.seller-name {
    font-size: 18px;
    font-weight: 600;
    color: var(--text);
    margin: 0;
}

.seller-email,
.seller-branch {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: var(--text-muted);
}

.seller-footer {
    position: relative;
    z-index: 1;
    padding-top: 16px;
    border-top: 1px solid var(--border);
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-badge.active {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.2);
    color: var(--success);
}

.status-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: var(--success);
    position: relative;
}

.status-dot.online::after {
    content: '';
    position: absolute;
    inset: -2px;
    border-radius: 50%;
    border: 1px solid var(--success);
    animation: pulse-ring 2s infinite;
}

@keyframes pulse-ring {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(2); opacity: 0; }
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
    .sellers-grid {
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