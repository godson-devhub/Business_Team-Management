<?php

declare(strict_types=1);

use yii\web\YiiAsset;

YiiAsset::register($this);

?>

<?php $this->beginPage() ?>

<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" id="htmlRoot" data-theme="dark">

<head>
    <?= $this->render('_head') ?>
</head>

<body>

<?php $this->beginBody() ?>

<div class="app-layout">

    <?= $this->render('_sidebar') ?>

    <div class="app-main">

        <?= $this->render('_header') ?>

        <!-- THEME TOGGLE BUTTON GLOBAL -->
        <div class="theme-toggle-wrapper">
            <button class="theme-btn" onclick="toggleTheme()">
                🌓 
            </button>
        </div>

        <main class="app-content">

            <?= \common\widgets\Alert::widget() ?>

            <?= $content ?>

        </main>

        <?= $this->render('_footer') ?>

    </div>

</div>

<?php $this->endBody() ?>

<style>

/* ==========================================
ROOT DARK THEME (DEFAULT)
========================================== */

:root {

    --sidebar-width:260px;

    --bg:#0f172a;
    --bg-secondary:#1e293b;

    --surface:#111827;

    --card-bg:rgba(255,255,255,.06);

    --border:rgba(255,255,255,.08);

    --text:#f8fafc;
    --text-muted:#94a3b8;

    --primary:#3b82f6;
    --primary-hover:#2563eb;

    --shadow:0 10px 35px rgba(0,0,0,.25);
}

/* ==========================================
LIGHT THEME (PROFESSIONAL WHITE UI)
========================================== */

html[data-theme="light"] {

    --bg:#f8fafc;
    --bg-secondary:#ffffff;

    --surface:#ffffff;

    --card-bg:rgba(202, 213, 255, 0.95);

    --border:#e2e8f0;

    --text:#0f172a;

    --text-muted:#64748b;

    --primary:#2563eb;
    --primary-hover:#1d4ed8;

    --shadow:0 10px 30px rgba(15,23,42,.08);
}

/* ==========================================
GLOBAL STYLES
========================================== */

html, body {

    margin:0;
    padding:0;

    min-height:100%;

    background: linear-gradient(135deg, var(--bg), var(--bg-secondary));

    color:var(--text);

    font-family:Inter, Segoe UI, sans-serif;

    transition: all 0.3s ease;

    overflow-x:hidden;
}

/* ==========================================
LAYOUT
========================================== */

.app-layout {
    display:flex;
    min-height:100vh;
    width:100%;
}

.app-main {

    flex:1;

    margin-left:var(--sidebar-width);

    min-height:100vh;

    display:flex;
    flex-direction:column;

    transition:0.3s ease;
}

/* ==========================================
CONTENT
========================================== */

.app-content {

    flex:1;

    padding:24px;

    width:100%;
}

/* ==========================================
GLOBAL CARDS FIX
========================================== */

.card {

    background:var(--card-bg);

    border:1px solid var(--border);

    border-radius:16px;

    padding:16px;

    box-shadow:var(--shadow);

    transition:0.25s ease;
}

.card:hover {
    transform:translateY(-4px);
}

/* ==========================================
BUTTON THEME TOGGLE
========================================== */

.theme-toggle-wrapper {
    display:flex;
    justify-content:flex-end;
    padding:10px 20px;
}

.theme-btn {

    background:var(--surface);

    border:1px solid var(--border);

    color:var(--text);

    padding:10px 14px;

    border-radius:12px;

    cursor:pointer;

    transition:0.3s ease;
}

.theme-btn:hover {
    transform:translateY(-2px);
    background:var(--primary);
    color:white;
}

/* ==========================================
SCROLLBAR FIX
========================================== */

::-webkit-scrollbar {
    width:8px;
}

::-webkit-scrollbar-thumb {
    background:#475569;
    border-radius:20px;
}

</style>

<script>

/* ==========================================
GLOBAL THEME SYSTEM (FIXED)
========================================== */

function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('app_theme', theme);
}

function toggleTheme() {

    let current = document.documentElement.getAttribute('data-theme');

    let next = (current === 'dark') ? 'light' : 'dark';

    applyTheme(next);
}

/* INIT THEME ON LOAD (NO BUG / NO LOOP) */
document.addEventListener('DOMContentLoaded', function() {

    let saved = localStorage.getItem('app_theme');

    if (!saved) {
        saved = 'dark';
    }

    applyTheme(saved);

});

</script>

</body>
</html>

<?php $this->endPage() ?>