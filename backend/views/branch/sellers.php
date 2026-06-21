<?php

use yii\helpers\Html;
use yii\helpers\Url;

/**
 * @var \common\models\Branch $branch
 * @var \common\models\User[] $sellers
 */

$this->title = $branch->name . ' Sellers';

$totalSellers = count($sellers);
?>

<div class="page-container">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?= Url::to(['branch/view', 'id' => $branch->id]) ?>">
            <i data-lucide="chevron-left" class="icon-16"></i>
            <?= Html::encode($branch->name) ?>
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">Sellers</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div>
            <h1 class="page-title">Sellers</h1>
            <p class="page-subtitle">Team members assigned to this branch</p>
        </div>
        <div class="stat-pill">
            <i data-lucide="users" class="icon-14"></i>
            <?= $totalSellers ?> member<?= $totalSellers !== 1 ? 's' : '' ?>
        </div>
    </div>

    <!-- Sellers Grid -->
    <div class="sellers-grid">

        <?php foreach ($sellers as $seller): ?>

            <div class="seller-card">
                <div class="seller-avatar">
                    <?= strtoupper(substr($seller->username, 0, 1)) ?>
                </div>
                <div class="seller-info">
                    <h3 class="seller-name"><?= Html::encode($seller->username) ?></h3>
                    <div class="seller-role">
                        <span class="role-badge">Seller</span>
                    </div>
                    <?php if ($seller->email): ?>
                        <div class="seller-email">
                            <i data-lucide="mail" class="icon-14"></i>
                            <?= Html::encode($seller->email) ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="seller-status">
                    <span class="status-badge active">
                        <span class="status-dot online"></span>
                        Active
                    </span>
                </div>
            </div>

        <?php endforeach; ?>

        <?php if (empty($sellers)): ?>

            <div class="empty-state" style="grid-column: 1 / -1;">
                <div class="empty-icon">
                    <i data-lucide="users" class="icon-48"></i>
                </div>
                <h3>No sellers assigned</h3>
                <p>This branch doesn't have any sellers yet</p>
            </div>

        <?php endif; ?>

    </div>

</div>

<style>
/* ============================================
   STAT PILL
   ============================================ */
.stat-pill {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    border-radius: var(--radius-lg);
    background: var(--bg-elevated);
    border: 1px solid var(--border);
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
}

/* ============================================
   SELLERS GRID
   ============================================ */
.sellers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px;
}

/* ============================================
   SELLER CARD
   ============================================ */
.seller-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    transition: all 0.25s ease;
}

.seller-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
    border-color: var(--border-strong);
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

.seller-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.seller-name {
    font-size: 15px;
    font-weight: 600;
    color: var(--text);
    margin: 0;
}

.seller-role {
    display: flex;
    align-items: center;
}

.role-badge {
    padding: 2px 10px;
    border-radius: 20px;
    background: var(--primary-glow);
    color: var(--primary);
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.seller-email {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: var(--text-muted);
}

.seller-status {
    flex-shrink: 0;
}

.status-badge {
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
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
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .sellers-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>