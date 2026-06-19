<?php

declare(strict_types=1);

/** @var yii\web\View $this */

?>

<footer class="app-footer">

    <div class="footer-left">
        © <?= date('Y') ?> Business Team Management System
    </div>

    <div class="footer-right">
        Version 1.0.0
    </div>

</footer>

<style>

/* =========================
THEME VARIABLES
========================= */

:root{
    --footer-bg: rgba(255,255,255,.03);
    --border: rgba(255,255,255,.08);
    --text-muted: #94a3b8;
}

/* LIGHT MODE SUPPORT */
[data-bs-theme="light"]{
    --footer-bg: rgba(255,255,255,.9);
    --border: rgba(0,0,0,.08);
    --text-muted: #475569;
}

/* =========================
FOOTER BASE
========================= */

.app-footer{

    display:flex;
    justify-content:space-between;
    align-items:center;

    padding:14px 22px;

    background: var(--footer-bg);
    backdrop-filter: blur(14px);

    border-top: 1px solid var(--border);

    color: var(--text-muted);

    font-size:13px;

    width:100%;
}

/* LEFT */
.footer-left{
    font-weight:500;
}

/* RIGHT */
.footer-right{
    opacity:.85;
}

/* =========================
RESPONSIVE
========================= */

@media(max-width:768px){

    .app-footer{

        flex-direction:column;
        gap:6px;

        text-align:center;
    }
}

</style>