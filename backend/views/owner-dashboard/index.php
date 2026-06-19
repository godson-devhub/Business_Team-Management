<?php

$this->title = 'Owner Dashboard';

$user = Yii::$app->user->identity;
$username = $user->username ?? 'Owner';

$totalBusinesses = isset($businesses) ? count($businesses) : 0;
$totalBranches   = isset($branches) ? count($branches) : 0;
$totalSellers    = $totalSellers ?? 0;

?>

<div class="owner-dashboard">

    <div class="dashboard-header">

        <div>
            <h1>
                Welcome Back,
                <?= $username ?>
                
            </h1>

            <p>
                Manage your businesses, branches and sellers
                from one centralized dashboard.
            </p>
        </div>

       

    </div>

   

    <div class="stats-grid">

        <div class="stat-card blue">

            <div class="icon">🏢</div>

            <div class="value">
                <?= $totalBusinesses ?>
            </div>

            <div class="label">
                Businesses
            </div>

        </div>

        <div class="stat-card green">

            <div class="icon">🏬</div>

            <div class="value">
                <?= $totalBranches ?>
            </div>

            <div class="label">
                Branches
            </div>

        </div>

        <div class="stat-card purple">

            <div class="icon">👨‍💼</div>

            <div class="value">
                <?= $totalSellers ?>
            </div>

            <div class="label">
                Sellers
            </div>

        </div>

    </div>

    <div class="content-grid">

        <div class="glass-panel">

            <h3>
                🏢 Recent Businesses
            </h3>

            <?php if(!empty($businesses)): ?>

                <?php foreach($businesses as $business): ?>

                    <div class="item">

                        <span>
                            <?= $business->name ?>
                        </span>

                        <span class="badge">
                            Active
                        </span>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty">
                    No businesses available.
                </div>

            <?php endif; ?>

        </div>

        <div class="glass-panel">

            <h3>
                🏬 Recent Branches
            </h3>

            <?php if(!empty($branches)): ?>

                <?php foreach($branches as $branch): ?>

                    <div class="item">

                        <span>
                            <?= $branch->name ?>
                        </span>

                        <span class="badge">
                            Branch
                        </span>

                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty">
                    No branches available.
                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<style>

:root{
    --bg:#0f172a;
    --card:rgba(255,255,255,.08);
    --card-hover:rgba(255,255,255,.15);
    --border:rgba(255,255,255,.1);
    --text:#fff;
    --muted:#cbd5e1;
}

body.light{
    --bg:#f5f7fb;
    --card:rgba(255,255,255,.8);
    --card-hover:#fff;
    --border:#dbeafe;
    --text:#0f172a;
    --muted:#475569;
}

body{
    background:var(--bg);
    color:var(--text);
    transition:.4s;
}

.owner-dashboard{
    padding:0 30px 30px 30px;
    
}

.dashboard-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    margin-bottom:25px;
    margin-top:-20px;
}

.dashboard-header h1{
    font-size:32px;
    font-weight:600;
    
    
}

.dashboard-header p{
    color:var(--muted);
}

.theme-btn{
    border:none;
    background:var(--card);
    backdrop-filter:blur(20px);
    padding:12px 18px;
    border-radius:14px;
    cursor:pointer;
    color:var(--text);
}

.hero-banner{
    height:250px;
    border-radius:25px;
    overflow:hidden;
    position:relative;
    background:
        linear-gradient(
            135deg,
            #2563eb,
            #7c3aed
        );
    margin-bottom:30px;
}

.hero-overlay{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,.2);
}

.hero-content{
    position:absolute;
    inset:0;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    color:white;
}

.hero-content h2{
    font-size:38px;
    font-weight:800;
}

.hero-content p{
    margin-top:10px;
}

.stats-grid{
    display:grid;
    grid-template-columns:
        repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.stat-card{
    backdrop-filter:blur(25px);
    border-radius:20px;
    padding:25px;
    text-align:center;
    transition:.4s;
    cursor:pointer;
    border:1px solid rgba(255,255,255,.15);
}

.stat-card:hover{
    transform:
        translateY(-8px)
        scale(1.03);
}

.blue{
    background:linear-gradient(
        135deg,
        #2563eb,
        #1e40af
    );
}

.green{
    background:linear-gradient(
        135deg,
        #10b981,
        #047857
    );
}

.purple{
    background:linear-gradient(
        135deg,
        #8b5cf6,
        #6d28d9
    );
}

.icon{
    font-size:40px;
    margin-bottom:10px;
}

.value{
    font-size:36px;
    font-weight:800;
}

.label{
    opacity:.9;
}

.content-grid{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
}

.glass-panel{
    background:var(--card);
    border:1px solid var(--border);
    backdrop-filter:blur(25px);
    border-radius:20px;
    padding:25px;
}

.glass-panel h3{
    margin-bottom:20px;
}

.item{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:15px;
    border-radius:12px;
    margin-bottom:10px;
    transition:.3s;
}

.item:hover{
    background:var(--card-hover);
    transform:translateX(5px);
}

.badge{
    background:#3b82f6;
    color:white;
    padding:5px 12px;
    border-radius:999px;
    font-size:12px;
}

.empty{
    color:var(--muted);
}

@media(max-width:900px){

    .content-grid{
        grid-template-columns:1fr;
    }

    .dashboard-header{
        flex-direction:column;
        gap:15px;
        align-items:flex-start;
    }

    .hero-content h2{
        font-size:26px;
    }

}

</style>

<script>

function toggleTheme(){
    document.body.classList.toggle('light');

    localStorage.setItem(
        'owner-theme',
        document.body.classList.contains('light')
        ? 'light'
        : 'dark'
    );
}

if(localStorage.getItem('owner-theme')==='light'){
    document.body.classList.add('light');
}

</script>