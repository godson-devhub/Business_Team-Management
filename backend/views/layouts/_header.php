<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;

$user     = Yii::$app->user->identity;
$isGuest  = Yii::$app->user->isGuest;
$username = $user->username ?? null;
$role     = strtoupper($user->role ?? '');
$initial  = $username ? strtoupper(substr($username, 0, 1)) : '?';

?>

<header class="app-header">

    <!-- Left: Toggle + Brand -->
    <div class="header-left">
        <button type="button" class="sidebar-toggle" id="sidebar-toggle" aria-label="Toggle sidebar">
            <i data-lucide="panel-left" class="icon-20"></i>
        </button>

        <a href="<?= Yii::$app->homeUrl ?>" class="header-brand">
            <div class="brand-icon">
                <img src="<?= Yii::getAlias('@web') ?>/uploads/icon2.png" alt="Logo">
            </div>
            <span class="brand-text">Business Workflow</span>
        </a>
    </div>

    <!-- Center: Search -->
    <div class="header-center">
        <div class="search-wrapper">
            <i data-lucide="search" class="search-icon"></i>
            <input type="text" 
                   class="search-input" 
                   placeholder="Search anything..." 
                   autocomplete="off">
            <kbd class="search-shortcut">⌘K</kbd>
        </div>
    </div>

    <!-- Right: Actions -->
    <div class="header-right">

        <!-- Theme Toggle -->
        <button type="button" class="header-btn" id="theme-toggle" aria-label="Toggle theme">
            <i data-lucide="moon" class="icon-20 theme-icon-dark"></i>
            <i data-lucide="sun" class="icon-20 theme-icon-light" style="display:none"></i>
        </button>

        <!-- Notifications -->
        <button type="button" class="header-btn has-badge" aria-label="Notifications">
            <i data-lucide="bell" class="icon-20"></i>
            <span class="badge">3</span>
        </button>

        <?php if (!$isGuest): ?>

            <!-- User Dropdown -->
            <div class="user-dropdown" id="user-dropdown">
                <button type="button" class="user-trigger" aria-label="User menu">
                    <div class="user-avatar">
                        <?= $initial ?>
                    </div>
                    <div class="user-details">
                        <span class="user-name"><?= Html::encode($username) ?></span>
                        <span class="user-role"><?= $role ?></span>
                    </div>
                    <i data-lucide="chevron-down" class="icon-16 dropdown-chevron"></i>
                </button>

                <div class="dropdown-menu">
                    <div class="dropdown-header">
                        <div class="user-avatar lg"><?= $initial ?></div>
                        <div>
                            <div class="dropdown-name"><?= Html::encode($username) ?></div>
                            <div class="dropdown-email"><?= Html::encode($user->email ?? '') ?></div>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i data-lucide="user" class="icon-16"></i>
                        Profile
                    </a>
                    <a href="#" class="dropdown-item">
                        <i data-lucide="settings" class="icon-16"></i>
                        Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <form action="<?= \yii\helpers\Url::to(['/site/logout']) ?>" method="post" class="dropdown-form">
                        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>">
                        <button type="submit" class="dropdown-item danger">
                            <i data-lucide="log-out" class="icon-16"></i>
                            Log out
                        </button>
                    </form>
                </div>
            </div>

        <?php else: ?>

            <a href="<?= \yii\helpers\Url::to(['/site/login']) ?>" class="btn-primary">
                Sign In
            </a>

        <?php endif; ?>

    </div>

</header>

<style>
/* ============================================
   HEADER
   ============================================ */
.app-header {
    position: sticky;
    top: 0;
    z-index: 100;
    
    height: 64px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    
    padding: 0 20px;
    
    background: var(--surface);
    border-bottom: 1px solid var(--border);
    
    transition: all 0.3s ease;
}

/* Left */
.header-left {
    display: flex;
    align-items: center;
    gap: 16px;
}

.sidebar-toggle {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    border: none;
    border-radius: var(--radius);
    background: transparent;
    color: var(--text-secondary);
    transition: all 0.2s ease;
}
.sidebar-toggle:hover {
    background: var(--surface-hover);
    color: var(--text);
}

.header-brand {
    display: flex;
    align-items: center;
    gap: 12px;
}

.brand-icon {
    width: 32px;
    height: 32px;
    border-radius: var(--radius-sm);
    overflow: hidden;
    background: var(--bg-elevated);
    display: flex;
    align-items: center;
    justify-content: center;
}
.brand-icon img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.brand-text {
    font-size: 15px;
    font-weight: 700;
    color: var(--text);
    letter-spacing: -0.3px;
}

/* Center */
.header-center {
    flex: 1;
    max-width: 480px;
    margin: 0 40px;
}

.search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.search-icon {
    position: absolute;
    left: 12px;
    color: var(--text-muted);
    width: 16px;
    height: 16px;
}

.search-input {
    width: 100%;
    height: 40px;
    padding: 0 44px 0 36px;
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    background: var(--bg-elevated);
    color: var(--text);
    font-size: 13px;
    font-family: inherit;
    transition: all 0.2s ease;
    outline: none;
}
.search-input::placeholder {
    color: var(--text-muted);
}
.search-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-glow);
    background: var(--surface);
}

.search-shortcut {
    position: absolute;
    right: 10px;
    padding: 2px 6px;
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    background: var(--surface);
    color: var(--text-muted);
    font-size: 11px;
    font-family: 'JetBrains Mono', monospace;
}

/* Right */
.header-right {
    display: flex;
    align-items: center;
    gap: 8px;
}

.header-btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border: none;
    border-radius: var(--radius);
    background: transparent;
    color: var(--text-secondary);
    transition: all 0.2s ease;
}
.header-btn:hover {
    background: var(--surface-hover);
    color: var(--text);
}

.has-badge .badge {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: var(--danger);
    color: white;
    font-size: 10px;
    font-weight: 700;
    border: 2px solid var(--surface);
}

/* User Dropdown */
.user-dropdown {
    position: relative;
}

.user-trigger {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 6px 10px 6px 6px;
    border: none;
    border-radius: var(--radius-lg);
    background: transparent;
    color: var(--text);
    transition: all 0.2s ease;
}
.user-trigger:hover {
    background: var(--surface-hover);
}

.user-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 13px;
    color: white;
    background: linear-gradient(135deg, #3b82f6, #8b5cf6);
    flex-shrink: 0;
}
.user-avatar.lg {
    width: 40px;
    height: 40px;
    font-size: 15px;
}

.user-details {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    line-height: 1.2;
}

.user-name {
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
}

.user-role {
    font-size: 11px;
    color: var(--text-muted);
    font-weight: 500;
}

.dropdown-chevron {
    color: var(--text-muted);
    transition: transform 0.2s ease;
}
.user-dropdown.open .dropdown-chevron {
    transform: rotate(180deg);
}

/* Dropdown Menu */
.dropdown-menu {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    width: 260px;
    padding: 8px;
    border-radius: var(--radius-lg);
    background: var(--surface);
    border: 1px solid var(--border);
    box-shadow: var(--shadow-lg);
    opacity: 0;
    visibility: hidden;
    transform: translateY(-8px);
    transition: all 0.2s ease;
    z-index: 200;
}

.user-dropdown.open .dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
}

.dropdown-name {
    font-size: 14px;
    font-weight: 600;
    color: var(--text);
}

.dropdown-email {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 2px;
}

.dropdown-divider {
    height: 1px;
    background: var(--border);
    margin: 8px 0;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: var(--radius);
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 500;
    transition: all 0.15s ease;
    cursor: pointer;
    width: 100%;
    border: none;
    background: none;
    font-family: inherit;
    text-align: left;
}
.dropdown-item:hover {
    background: var(--surface-hover);
    color: var(--text);
}
.dropdown-item.danger {
    color: var(--danger);
}
.dropdown-item.danger:hover {
    background: rgba(239,68,68,0.1);
}

.dropdown-form {
    margin: 0;
}

/* Primary Button */
.btn-primary {
    padding: 8px 16px;
    border-radius: var(--radius);
    background: var(--primary);
    color: white;
    font-size: 13px;
    font-weight: 600;
    transition: all 0.2s ease;
}
.btn-primary:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
}

/* Icon sizes */
.icon-16 { width: 16px; height: 16px; }
.icon-20 { width: 20px; height: 20px; }

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 992px) {
    .header-center {
        display: none;
    }
    .user-details {
        display: none;
    }
    .brand-text {
        display: none;
    }
}

@media (max-width: 768px) {
    .app-header {
        padding: 0 12px;
    }
    .header-left {
        gap: 10px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }

    // User dropdown toggle
    const userDropdown = document.getElementById('user-dropdown');
    if (userDropdown) {
        const trigger = userDropdown.querySelector('.user-trigger');
        trigger.addEventListener('click', function(e) {
            e.stopPropagation();
            userDropdown.classList.toggle('open');
        });
        document.addEventListener('click', function() {
            userDropdown.classList.remove('open');
        });
    }

    // Sidebar toggle
    const sidebarToggle = document.getElementById('sidebar-toggle');
    const sidebar = document.querySelector('.app-sidebar');
    const main = document.querySelector('.app-main');
    
    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('collapsed');
            if (main) main.classList.toggle('sidebar-collapsed');
            // Save state
            localStorage.setItem('sidebar_collapsed', sidebar.classList.contains('collapsed'));
        });
        
        // Restore state
        if (localStorage.getItem('sidebar_collapsed') === 'true') {
            sidebar.classList.add('collapsed');
            if (main) main.classList.add('sidebar-collapsed');
        }
    }

    // Theme toggle sync with main.php
    const themeToggle = document.getElementById('theme-toggle');
    const iconDark = themeToggle?.querySelector('.theme-icon-dark');
    const iconLight = themeToggle?.querySelector('.theme-icon-light');
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const html = document.documentElement;
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            
            html.setAttribute('data-theme', next);
            localStorage.setItem('app_theme', next);
            
            if (iconDark && iconLight) {
                iconDark.style.display = next === 'dark' ? 'none' : 'block';
                iconLight.style.display = next === 'dark' ? 'block' : 'none';
            }
            
            // Re-init icons
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
        
        // Set initial icon state
        const saved = localStorage.getItem('app_theme') || 'dark';
        if (iconDark && iconLight) {
            iconDark.style.display = saved === 'dark' ? 'block' : 'none';
            iconLight.style.display = saved === 'dark' ? 'none' : 'block';
        }
    }
});
</script>