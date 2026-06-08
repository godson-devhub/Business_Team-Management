<?php
/**
 * @var \common\models\Business[] $businesses
 */

$this->title = 'My Businesses';
?>

<style>
body{
    background:linear-gradient(135deg,#020617,#0f172a,#1e293b);
    color:white;
    font-family:Segoe UI;
}

.container{
    padding:40px;
}

.title{
    font-size:40px;
    font-weight:bold;
    background:linear-gradient(to right,#38bdf8,#a78bfa);
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.btn{
    padding:12px 18px;
    background:linear-gradient(135deg,#38bdf8,#6366f1);
    border-radius:12px;
    color:white;
    text-decoration:none;
    display:inline-block;
    margin-bottom:20px;
}

.grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
}

.card{
    background:rgba(255,255,255,0.07);
    padding:20px;
    border-radius:18px;
    backdrop-filter:blur(16px);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-8px);
}

.actions a{
    margin-right:10px;
    color:#38bdf8;
    text-decoration:none;
}
</style>

<div class="container">

    <div class="title">🏢 My Businesses</div>

    <a href="/business/create" class="btn">➕ Create Business</a>

    <div class="grid">

        <?php foreach ($businesses as $b): ?>

            <div class="card">

                <h3><?= $b->name ?></h3>

                <p><?= $b->description ?></p>

                <div class="actions">

                    <a href="/business/update?id=<?= $b->id ?>">✏ Edit</a>

                    <a href="/business/delete?id=<?= $b->id ?>"
                       onclick="return confirm('Delete this business?')">
                       🗑 Delete
                    </a>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>