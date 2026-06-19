<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

// BADILISHA URL HIZI KULINGANA NA DOMAIN YAKO
$backendUrl = 'http://localhost/business_system/backend/web';

?>

<header class="landing-header">

    <div class="container-fluid">

        <nav class="navbar navbar-expand-lg">

            <!-- LOGO -->
            <a class="navbar-brand" href="<?= Url::to(['/site/index']) ?>">
                <span class="logo-icon">📊</span>
                <span class="logo-text">
                    BusinessFlow
                </span>
            </a>

            <!-- MOBILE TOGGLE -->
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#mainNavbar">

                <span class="navbar-toggler-icon"></span>

            </button>

            <!-- MENU -->
            <div class="collapse navbar-collapse"
                 id="mainNavbar">

                <ul class="navbar-nav mx-auto">

                    <li class="nav-item">
                        <a class="nav-link"
                           href="<?= Url::to(['/site/index']) ?>">
                            Home
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="#features">
                            Features
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="#screenshots">
                            Screenshots
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="#pricing">
                            Pricing
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link"
                           href="#contact">
                            Contact
                        </a>
                    </li>

                </ul>

                <!-- RIGHT SIDE -->
                <div class="header-actions">

                    <!-- THEME TOGGLE -->
                    <button id="themeToggle"
                            class="theme-toggle-btn"
                            title="Switch Theme">

                        🌙

                    </button>

                    <a href="<?= Yii::$app->params['backendUrl'] ?>/login"
                        class="btn btn-outline-light">
                        Login
                    </a>

                    <a href="<?= Yii::$app->params['backendUrl'] ?>/signup"
                        class="btn btn-primary">
                        Sign Up
                    </a>

                </div>

            </div>

        </nav>

    </div>

</header>

<style>

/* =====================================
HEADER
===================================== */

.landing-header{

    position:fixed;
    top:0;
    left:0;
    right:0;

    z-index:9999;

    background:rgba(15,23,42,.72);

    backdrop-filter:blur(18px);
    -webkit-backdrop-filter:blur(18px);

    border-bottom:1px solid rgba(255,255,255,.08);

    transition:.3s ease;
}

[data-theme="light"] .landing-header{

    background:rgba(255,255,255,.92);

    border-bottom:1px solid #e2e8f0;
}

.navbar{

    min-height:80px;
}

/* =====================================
LOGO
===================================== */

.navbar-brand{

    display:flex;
    align-items:center;
    gap:10px;

    text-decoration:none;

    font-weight:800;
    font-size:22px;

    color:#fff !important;
}

[data-theme="light"] .navbar-brand{

    color:#0f172a !important;
}

.logo-icon{

    font-size:30px;
}

/* =====================================
MENU
===================================== */

.nav-link{

    color:#cbd5e1 !important;

    font-weight:600;

    margin:0 8px;

    transition:.3s;
}

.nav-link:hover{

    color:#3b82f6 !important;
}

[data-theme="light"] .nav-link{

    color:#334155 !important;
}

/* =====================================
ACTIONS
===================================== */

.header-actions{

    display:flex;
    align-items:center;
    gap:12px;
}

/* =====================================
THEME BUTTON
===================================== */

.theme-toggle-btn{

    width:45px;
    height:45px;

    border:none;

    border-radius:12px;

    cursor:pointer;

    background:rgba(255,255,255,.08);

    color:white;

    font-size:18px;

    transition:.3s;
}

.theme-toggle-btn:hover{

    transform:translateY(-2px);
}

[data-theme="light"] .theme-toggle-btn{

    background:#f1f5f9;
    color:#0f172a;
}

/* =====================================
LOGIN BUTTON
===================================== */

.btn-login{

    text-decoration:none;

    color:white;

    padding:10px 18px;

    border-radius:12px;

    border:1px solid rgba(255,255,255,.15);

    transition:.3s;
}

.btn-login:hover{

    background:rgba(255,255,255,.08);
}

[data-theme="light"] .btn-login{

    color:#0f172a;

    border-color:#cbd5e1;
}

/* =====================================
SIGNUP BUTTON
===================================== */

.btn-signup{

    text-decoration:none;

    color:white;

    background:#3b82f6;

    padding:10px 18px;

    border-radius:12px;

    font-weight:700;

    transition:.3s;
}

.btn-signup:hover{

    background:#2563eb;

    transform:translateY(-2px);
}

/* =====================================
MOBILE
===================================== */

@media(max-width:991px){

    .header-actions{

        margin-top:15px;
    }

    .navbar-collapse{

        padding:20px 0;
    }

}

</style>

<script>

document.addEventListener('DOMContentLoaded', function(){

    const html = document.documentElement;
    const btn = document.getElementById('themeToggle');

    const savedTheme = localStorage.getItem('theme');

    if(savedTheme){

        html.setAttribute('data-theme', savedTheme);

        btn.innerHTML =
            savedTheme === 'dark'
            ? '☀️'
            : '🌙';
    }

    btn.addEventListener('click', function(){

        const current =
            html.getAttribute('data-theme') || 'dark';

        const next =
            current === 'dark'
            ? 'light'
            : 'dark';

        html.setAttribute('data-theme', next);

        localStorage.setItem('theme', next);

        btn.innerHTML =
            next === 'dark'
            ? '☀️'
            : '🌙';
    });

});

</script>