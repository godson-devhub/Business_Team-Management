<?php

$this->title = 'Owner Dashboard';

$user = Yii::$app->user->identity;
$username = $user->username ?? 'Owner';

$totalBusinesses = isset($businesses) ? count($businesses) : 0;
$totalBranches = isset($branches) ? count($branches) : 0;

?>

<style>

/* =========================
ROOT THEME
========================= */
:root {
    --bg: #0b1220;
    --card: rgba(255,255,255,0.06);
    --card-hover: rgba(255,255,255,0.10);
    --text: #e5e7eb;
    --muted: #94a3b8;
    --primary: #3b82f6;
    --border: rgba(255,255,255,0.10);
}

/* LIGHT MODE */
body.light {
    --bg: #eef2f7;
    --card: rgba(255,255,255,0.85);
    --card-hover: rgba(255,255,255,1);
    --text: #0f172a;
    --muted: #475569;
    --primary: #2563eb;
    --border: rgba(15,23,42,0.12);
}

/* =========================
GLOBAL FIX
========================= */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Segoe UI, sans-serif;
}

body{
    background: radial-gradient(circle at top, #111827, #0b1220);
    color:var(--text);
    overflow-x:hidden;
}

/* =========================
WRAPPER (FIX WIDTH ISSUE)
========================= */
.main{
    max-width:1200px;
    margin:0 auto;
    padding:40px;
}

/* =========================
HEADER
========================= */
.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:30px;
}

.title{
    font-size:28px;
    font-weight:800;
}

.subtitle{
    color:var(--muted);
    font-size:13px;
}

.theme-btn{
    background:var(--card);
    border:1px solid var(--border);
    padding:10px 14px;
    border-radius:12px;
    color:var(--text);
    cursor:pointer;
}

/* =========================
CARDS GRID
========================= */
.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:16px;
    margin-bottom:30px;
}

.card{
    background:var(--card);
    border:1px solid var(--border);
    border-radius:16px;
    padding:20px;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
    background:var(--card-hover);
}

.card-title{
    color:var(--muted);
    font-size:12px;
    margin-bottom:8px;
}

.card-value{
    font-size:22px;
    font-weight:800;
}

/* =========================
LIST SECTION
========================= */
.section{
    margin-top:25px;
}

.section h3{
    margin-bottom:12px;
    font-size:16px;
    color:var(--muted);
}

.list-item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:14px;
    margin-bottom:10px;
    background:var(--card);
    border:1px solid var(--border);
    border-radius:12px;
}

.list-item:hover{
    background:var(--card-hover);
}

.badge{
    background:var(--primary);
    padding:4px 10px;
    border-radius:999px;
    font-size:11px;
    color:white;
}

/* =========================
RESPONSIVE FIX
========================= */
@media(max-width:768px){
    .main{
        padding:20px;
    }

    .title{
        font-size:22px;
    }

    .header{
        flex-direction:column;
        align-items:flex-start;
        gap:10px;
    }
}

</style>

<div class="main">

    <!-- HEADER -->
    <div class="header">

        <div>
            <div class="title">Welcome, <?= $username ?></div>
            <div class="subtitle">Clean Business Overview Dashboard</div>
        </div>

        

    </div>

    <!-- CORE STATS (ONLY WHAT YOU WANTED) -->
    <div class="grid">

        <div class="card">
            <div class="card-title">Businesses</div>
            <div class="card-value"><?= $totalBusinesses ?></div>
        </div>

        <div class="card">
            <div class="card-title">Branches</div>
            <div class="card-value"><?= $totalBranches ?></div>
        </div>

        <div class="card">
            <div class="card-title">Sellers</div>
            <div class="card-value"><?= $totalSellers ?? 0 ?></div>
        </div>

    </div>

    <!-- BUSINESSES LIST -->
    <div class="section">
        <h3>Your Businesses</h3>

        <?php if (!empty($businesses)): ?>
            <?php foreach ($businesses as $b): ?>
                <div class="list-item">
                    <span><?= $b->name ?></span>
                    <span class="badge">active</span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="list-item">
                <span>No businesses found</span>
            </div>
        <?php endif; ?>

    </div>

    <!-- BRANCHES LIST -->
    <div class="section">
        <h3>Your Branches</h3>

        <?php if (!empty($branches)): ?>
            <?php foreach ($branches as $br): ?>
                <div class="list-item">
                    <span><?= $br->name ?></span>
                    <span class="badge">branch</span>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="list-item">
                <span>No branches found</span>
            </div>
        <?php endif; ?>

    </div>

</div>

<script>

/* =========================
THEME TOGGLE SAFE
========================= */
function toggleTheme(){
    document.body.classList.toggle('light');
    localStorage.setItem(
        'theme',
        document.body.classList.contains('light') ? 'light' : 'dark'
    );
}

/* LOAD SAVED THEME */
if(localStorage.getItem('theme') === 'light'){
    document.body.classList.add('light');
}

</script>