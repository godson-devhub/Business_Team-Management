<?php

declare(strict_types=1);

use yii\web\YiiAsset;

YiiAsset::register($this);

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" data-theme="dark">

<head>
    <?= $this->render('_head') ?>
    <?php $this->head() ?>
</head>

<body>

<?php $this->beginBody() ?>

<div class="app-layout">

    <?= $this->render('_sidebar') ?>

    <div class="app-main" id="app-main">

        <?= $this->render('_header') ?>

        <main class="app-content">
            <?= \common\widgets\Alert::widget() ?>
            <?= $content ?>
        </main>

        <?= $this->render('_footer') ?>

    </div>

</div>

<?php $this->endBody() ?>

<style>
/* ============================================
   LAYOUT
   ============================================ */
.app-layout {
    display: flex;
    min-height: 100vh;
    width: 100%;
}

.app-main {
    flex: 1;
    display: flex;
    flex-direction: column;
    
    margin-left: var(--sidebar-width);
    min-height: 100vh;
    
    transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.app-main.sidebar-collapsed {
    margin-left: var(--sidebar-collapsed);
}

/* ============================================
   CONTENT AREA
   ============================================ */
.app-content {
    flex: 1;
    padding: 24px;
    width: 100%;
    max-width: 1440px;
    margin: 0 auto;
}

/* ============================================
   GLOBAL CARD STYLES
   ============================================ */
.card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-lg);
    padding: 20px;
    box-shadow: var(--shadow-sm);
    transition: all 0.25s ease;
}

.card:hover {
    box-shadow: var(--shadow);
    transform: translateY(-2px);
}

.card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.card-title {
    font-size: 16px;
    font-weight: 600;
    color: var(--text);
}

.card-subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin-top: 2px;
}

/* ============================================
   BUTTONS
   ============================================ */
.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 8px 16px;
    border-radius: var(--radius);
    font-size: 13px;
    font-weight: 600;
    font-family: inherit;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-primary {
    background: var(--primary);
    color: white;
}
.btn-primary:hover {
    background: var(--primary-hover);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px var(--primary-glow);
}

.btn-secondary {
    background: var(--bg-elevated);
    color: var(--text-secondary);
    border: 1px solid var(--border);
}
.btn-secondary:hover {
    background: var(--surface-hover);
    color: var(--text);
}

.btn-danger {
    background: var(--danger);
    color: white;
}
.btn-danger:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

/* ============================================
   TABLES
   ============================================ */
.table-container {
    overflow-x: auto;
    border-radius: var(--radius-lg);
    border: 1px solid var(--border);
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 13px;
}

.data-table th {
    padding: 12px 16px;
    text-align: left;
    font-weight: 600;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: var(--text-muted);
    background: var(--bg-elevated);
    border-bottom: 1px solid var(--border);
}

.data-table td {
    padding: 14px 16px;
    border-bottom: 1px solid var(--border);
    color: var(--text-secondary);
    transition: background 0.15s ease;
}

.data-table tbody tr:hover td {
    background: var(--surface-hover);
    color: var(--text);
}

.data-table tbody tr:last-child td {
    border-bottom: none;
}

/* ============================================
   BADGES
   ============================================ */
.badge {
    display: inline-flex;
    align-items: center;
    padding: 3px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.badge-success {
    background: rgba(34, 197, 94, 0.15);
    color: var(--success);
}

.badge-warning {
    background: rgba(245, 158, 11, 0.15);
    color: var(--warning);
}

.badge-danger {
    background: rgba(239, 68, 68, 0.15);
    color: var(--danger);
}

.badge-info {
    background: rgba(59, 130, 246, 0.15);
    color: var(--primary);
}

/* ============================================
   FORM ELEMENTS
   ============================================ */
.form-input {
    width: 100%;
    height: 40px;
    padding: 0 14px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    background: var(--surface);
    color: var(--text);
    font-size: 13px;
    font-family: inherit;
    transition: all 0.2s ease;
    outline: none;
}

.form-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px var(--primary-glow);
}

.form-input::placeholder {
    color: var(--text-muted);
}

.form-label {
    display: block;
    margin-bottom: 6px;
    font-size: 13px;
    font-weight: 500;
    color: var(--text-secondary);
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 992px) {
    .app-main {
        margin-left: 0;
    }
    .app-main.sidebar-collapsed {
        margin-left: 0;
    }
    .app-content {
        padding: 16px;
    }
}

@media (max-width: 768px) {
    .app-content {
        padding: 12px;
    }
}
</style>

<script>
/* ============================================
   GLOBAL THEME SYSTEM
   ============================================ */
function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('app_theme', theme);
}

function toggleTheme() {
    const current = document.documentElement.getAttribute('data-theme') || 'dark';
    applyTheme(current === 'dark' ? 'light' : 'dark');
}

// Init on load
document.addEventListener('DOMContentLoaded', function() {
    const saved = localStorage.getItem('app_theme') || 'dark';
    applyTheme(saved);
    
    // Init Lucide icons globally
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Re-init icons after AJAX/pjax if needed
    if (typeof jQuery !== 'undefined') {
        jQuery(document).on('pjax:end', function() {
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }
        });
    }
});

// Keyboard shortcut for search
document.addEventListener('keydown', function(e) {
    if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        const searchInput = document.querySelector('.search-input');
        if (searchInput) searchInput.focus();
    }
});
</script>

</body>
</html>
<?php $this->endPage() ?>