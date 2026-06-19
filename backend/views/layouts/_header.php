<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;

$user = Yii::$app->user->identity;

$isGuest = Yii::$app->user->isGuest;

?>

<header class="app-header">

    <!-- LEFT SIDE -->
    <div class="header-left">

        <div class="brand">

            <img src="<?= Yii::getAlias('@web') ?>/uploads/icon2.png"
                 class="brand-icon">

            <span class="brand-text">
                Business Workflow
            </span>

        </div>

    </div>

    <!-- CENTER SEARCH -->
    <div class="header-center">

        <input type="text"
               placeholder="Search anything..."
               class="search-box">

    </div>

    <!-- RIGHT SIDE -->
    <div class="header-right">

        <!-- THEME TOGGLE -->
        <button id="theme-toggle" class="theme-btn" type="button">
            🌙
        </button>

        <?php if (!$isGuest): ?>

            <div class="user-info">

                <div class="user-avatar">
                    <?= strtoupper(substr($user->username, 0, 1)) ?>
                </div>

                <div class="user-meta">

                    <div class="user-name">
                        <?= Html::encode($user->username) ?>
                    </div>

                    <div class="user-role">
                        <?= strtoupper($user->role ?? '') ?>
                    </div>

                </div>

            </div>


        <?php endif; ?>

    </div>

</header>

<style>

/* =========================
THEME VARIABLES
========================= */

:root{

    --header-bg: rgba(15,23,42,.75);
    --border: rgba(255,255,255,.08);
    --text: #ffffff;
    --muted: #94a3b8;
}

/* LIGHT MODE */
[data-bs-theme="light"]{

    --header-bg: rgba(255,255,255,.85);
    --border: rgba(0,0,0,.08);
    --text: #0f172a;
    --muted: #475569;
}

/* =========================
HEADER BASE
========================= */

.app-header{

    position: sticky;
    top: 0;
    z-index: 999;

    height: 70px;

    display: flex;
    align-items: center;
    justify-content: space-between;

    padding: 0 20px;

    background: var(--header-bg);
    backdrop-filter: blur(18px);

    border-bottom: 1px solid var(--border);
}

/* =========================
LEFT
========================= */

.header-left{
    display:flex;
    align-items:center;
}

.brand{
    display:flex;
    align-items:center;
    gap:10px;
}

.brand-icon{
    width:36px;
    height:36px;
    border-radius:10px;
}

.brand-text{
    font-size:16px;
    font-weight:700;
    color:var(--text);
}

/* =========================
CENTER
========================= */

.header-center{
    flex:1;
    max-width:500px;
    margin:0 30px;
}

.search-box{

    width:100%;
    height:40px;

    border:none;
    outline:none;

    border-radius:12px;

    padding:0 14px;

    background: rgba(255,255,255,.08);
    color: var(--text);
}

.search-box::placeholder{
    color: var(--muted);
}

/* =========================
RIGHT
========================= */

.header-right{

    display:flex;
    align-items:center;
    gap:14px;
}

/* THEME BUTTON */
.theme-btn{

    width:40px;
    height:40px;

    border:none;
    border-radius:10px;

    cursor:pointer;

    background: rgba(255,255,255,.08);
    color: var(--text);
}

/* USER INFO */
.user-info{

    display:flex;
    align-items:center;
    gap:10px;
}

.user-avatar{

    width:40px;
    height:40px;

    border-radius:50%;

    display:flex;
    align-items:center;
    justify-content:center;

    font-weight:700;

    color:white;

    background: linear-gradient(135deg,#3b82f6,#8b5cf6);
}

.user-meta{
    line-height:1.2;
}

.user-name{
    font-size:14px;
    font-weight:600;
    color:var(--text);
}

.user-role{
    font-size:11px;
    color:var(--muted);
}

/* LOGOUT */
.logout-btn{

    padding:9px 14px;
    border-radius:10px;

    text-decoration:none;

    font-size:13px;
    font-weight:600;

    background:#ef4444;
    color:white;
}

.logout-btn:hover{
    opacity:.9;
    color:white;
}

/* =========================
RESPONSIVE
========================= */

@media(max-width:992px){

    .header-center{
        display:none;
    }

    .user-meta{
        display:none;
    }

    .brand-text{
        display:none;
    }
}

</style>

<script>

document.addEventListener('DOMContentLoaded', function () {

    const btn = document.getElementById('theme-toggle');

    if (!btn) return;

    btn.addEventListener('click', function () {

        const html = document.documentElement;

        const theme = html.getAttribute('data-bs-theme');

        if (theme === 'dark') {

            html.setAttribute('data-bs-theme', 'light');
            btn.innerHTML = '🌙';

        } else {

            html.setAttribute('data-bs-theme', 'dark');
            btn.innerHTML = '☀️';
        }
    });

});

</script>