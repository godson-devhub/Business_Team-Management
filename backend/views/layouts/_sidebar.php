<?php

declare(strict_types=1);

use yii\helpers\Html;
use yii\helpers\Url;

$user        = Yii::$app->user->identity;
$isGuest     = Yii::$app->user->isGuest;
$role        = $user->role ?? null;
$username    = $user->username ?? null;
$currentRoute = Yii::$app->controller->route;

function isActive($route, $currentRoute): string
{
    return strpos($currentRoute, $route) === 0 ? 'active' : '';
}

function menuItem($icon, $label, $url, $route, $currentRoute, $badge = null): string
{
    $active = isActive($route, $currentRoute);
    $badgeHtml = $badge ? '<span class="menu-badge">' . $badge . '</span>' : '';
    
    return Html::a(
        '<span class="menu-icon"><i data-lucide="' . $icon . '" class="icon-18"></i></span>' .
        '<span class="menu-label">' . $label . '</span>' .
        $badgeHtml,
        $url,
        ['class' => 'menu-link ' . $active]
    );
}

?>

<aside class="app-sidebar" id="app-sidebar">

    <!-- Logo -->
    <div class="sidebar-logo">
        <div class="logo-icon">
            <img src="<?= Yii::getAlias('@web') ?>/uploads/icon2.png" alt="Logo">
        </div>
        <div class="logo-text">
            <div class="logo-title">Business Team</div>
            <div class="logo-subtitle">Management System</div>
        </div>
    </div>

    <!-- User (Compact) -->
    <?php if (!$isGuest): ?>
        <div class="sidebar-user">
            <div class="user-avatar">
                <?= strtoupper(substr($username, 0, 1)) ?>
            </div>
            <div class="user-info">
                <div class="user-name"><?= Html::encode($username) ?></div>
                <div class="user-role"><?= strtoupper($role) ?></div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Navigation -->
    <nav class="sidebar-nav">

        <?php if ($role === 'owner'): ?>

            <div class="nav-section">
                <span class="nav-title">Overview</span>
                <?= menuItem('layout-dashboard', 'Dashboard', ['/owner-dashboard/index'], 'owner-dashboard', $currentRoute) ?>
            </div>

            <div class="nav-section">
                <span class="nav-title">Business</span>
                <?= menuItem('building-2', 'Businesses', ['/business/index'], 'business', $currentRoute) ?>
                <?= menuItem('git-branch', 'Branches', ['/branch/index'], 'branch', $currentRoute) ?>
            </div>

            <div class="nav-section">
                <span class="nav-title">Users</span>
                <?= menuItem('users', 'Sellers', ['/owner-seller/index'], 'owner-seller', $currentRoute) ?>
            </div>

            <div class="nav-section">
                <span class="nav-title">Inventory</span>
                <?= menuItem('package', 'Products', ['/owner-product/index'], 'owner-product', $currentRoute) ?>
            </div>

            <div class="nav-section">
                <span class="nav-title">Analytics</span>
                <?= menuItem('bar-chart-3', 'Reports', ['/analytics/index'], 'analytics', $currentRoute) ?>
            </div>

        <?php endif; ?>

        <?php if ($role === 'seller'): ?>

            <div class="nav-section">
                <span class="nav-title">Seller Panel</span>
                <?= menuItem('layout-dashboard', 'Dashboard', ['/seller/index'], 'seller/index', $currentRoute) ?>
                <?= menuItem('package', 'Products', ['/products'], 'products', $currentRoute) ?>
                <?= menuItem('circle-dollar-sign', 'Sales', ['/sale/index'], 'sale', $currentRoute) ?>
                <?= menuItem('shopping-cart', 'Purchases', ['/purchase/index'], 'purchase', $currentRoute) ?>
            </div>

        <?php endif; ?>

    </nav>

    <!-- Footer -->
    <?php if (!$isGuest): ?>
        <div class="sidebar-footer">
            <form action="<?= Url::to(['/site/logout']) ?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                <button type="submit" class="logout-btn">
                    <span class="menu-icon"><i data-lucide="log-out" class="icon-18"></i></span>
                    <span class="menu-label">Log out</span>
                </button>
            </form>
        </div>
    <?php endif; ?>

</aside>

<style>
/* ============================================
   SIDEBAR
   ============================================ */
.app-sidebar {
    position: fixed;
    top: 0;
    left: 0;
    z-index: 90;
    
    width: var(--sidebar-width);
    height: 100vh;
    
    display: flex;
    flex-direction: column;
    
    background: var(--bg-secondary);
    border-right: 1px solid var(--border);
    
    padding: 16px 12px;
    
    transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    overflow: hidden;
}

/* Collapsed State */
.app-sidebar.collapsed {
    width: var(--sidebar-collapsed);
}

/* Logo */
.sidebar-logo {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 8px;
    margin-bottom: 24px;
    flex-shrink: 0;
}

.logo-icon {
    width: 36px;
    height: 36px;
    border-radius: var(--radius);
    overflow: hidden;
    background: var(--bg-elevated);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.logo-icon img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.logo-text {
    display: flex;
    flex-direction: column;
    transition: opacity 0.2s ease;
}

.app-sidebar.collapsed .logo-text {
    opacity: 0;
    pointer-events: none;
}

.logo-title {
    font-size: 14px;
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.2px;
}

.logo-subtitle {
    font-size: 11px;
    color: var(--text-muted);
    font-weight: 500;
}

/* User */
.sidebar-user {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    margin-bottom: 20px;
    border-radius: var(--radius-lg);
    background: var(--card-bg);
    border: 1px solid var(--border);
    flex-shrink: 0;
    transition: all 0.3s ease;
}

.app-sidebar.collapsed .sidebar-user {
    justify-content: center;
    padding: 8px;
}

.app-sidebar.collapsed .user-info {
    display: none;
}

.user-avatar {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    color: white;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    flex-shrink: 0;
}

.user-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    line-height: 1.3;
}

.user-role {
    font-size: 11px;
    color: var(--text-muted);
    font-weight: 500;
}

/* Navigation */
.sidebar-nav {
    flex: 1;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 0 4px;
}

.nav-section {
    margin-bottom: 20px;
}

.nav-title {
    display: block;
    padding: 0 8px;
    margin-bottom: 6px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    color: var(--text-muted);
    transition: opacity 0.2s ease;
}

.app-sidebar.collapsed .nav-title {
    opacity: 0;
    pointer-events: none;
    height: 0;
    margin: 0;
    overflow: hidden;
}

/* Menu Link */
.menu-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px;
    margin-bottom: 2px;
    border-radius: var(--radius);
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 500;
    transition: all 0.15s ease;
    position: relative;
    text-decoration: none;
}

.menu-link:hover {
    background: var(--surface-hover);
    color: var(--text);
    transform: translateX(2px);
}

.menu-link.active {
    background: var(--primary-glow);
    color: var(--primary);
    font-weight: 600;
}

.menu-link.active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 20px;
    background: var(--primary);
    border-radius: 0 4px 4px 0;
}

.menu-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 20px;
    height: 20px;
    flex-shrink: 0;
}

.icon-18 {
    width: 18px;
    height: 18px;
}

.menu-label {
    white-space: nowrap;
    transition: opacity 0.2s ease;
}

.app-sidebar.collapsed .menu-label {
    opacity: 0;
    pointer-events: none;
}

.menu-badge {
    margin-left: auto;
    padding: 2px 8px;
    border-radius: 20px;
    background: var(--primary);
    color: white;
    font-size: 10px;
    font-weight: 700;
    flex-shrink: 0;
}

.app-sidebar.collapsed .menu-badge {
    display: none;
}

/* Footer */
.sidebar-footer {
    margin-top: auto;
    padding-top: 12px;
    border-top: 1px solid var(--border);
    flex-shrink: 0;
}

.logout-btn {
    display: flex;
    align-items: center;
    gap: 12px;
    width: 100%;
    padding: 10px 12px;
    border: none;
    border-radius: var(--radius);
    background: transparent;
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 500;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.15s ease;
}

.logout-btn:hover {
    background: rgba(239, 68, 68, 0.1);
    color: var(--danger);
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 992px) {
    .app-sidebar {
        transform: translateX(-100%);
        z-index: 110;
    }
    .app-sidebar.open {
        transform: translateX(0);
    }
    .app-sidebar.collapsed {
        width: var(--sidebar-width);
        transform: translateX(-100%);
    }
    /* Overlay for mobile */
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 105;
    }
    .sidebar-overlay.active {
        display: block;
    }
}

/* Tooltip for collapsed state */
.app-sidebar.collapsed .menu-link {
    justify-content: center;
}
.app-sidebar.collapsed .menu-link:hover::after {
    content: attr(data-label);
    position: absolute;
    left: calc(100% + 12px);
    top: 50%;
    transform: translateY(-50%);
    padding: 6px 12px;
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    color: var(--text);
    font-size: 12px;
    white-space: nowrap;
    z-index: 300;
    box-shadow: var(--shadow-lg);
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Mobile sidebar overlay
    const sidebar = document.getElementById('app-sidebar');
    if (sidebar && window.innerWidth <= 992) {
        let overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        overlay.onclick = function() {
            sidebar.classList.remove('open');
            this.classList.remove('active');
        };
        document.body.appendChild(overlay);
        
        const toggle = document.getElementById('sidebar-toggle');
        if (toggle) {
            toggle.addEventListener('click', function() {
                sidebar.classList.toggle('open');
                overlay.classList.toggle('active');
            });
        }
    }
});
</script>