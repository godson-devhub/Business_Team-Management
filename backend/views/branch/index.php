<?php
/**
 * @var \common\models\Branch[] $branches
 */
$this->title = 'Branches';
?>

<style>
body{
    background:linear-gradient(135deg,#020617,#0f172a,#1e293b);
    color:white;
    font-family:Segoe UI;
}

.container{ padding:40px; }

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
    border-radius:18px;
    padding:20px;
    backdrop-filter:blur(16px);
    transition:0.3s;
}

.card:hover{
    transform:translateY(-10px);
}

.actions a{
    color:#38bdf8;
    margin-right:10px;
    text-decoration:none;
}
</style>

<div class="container">

    <div class="title">🏬 Branches</div>

    <a href="/branch/create" class="btn">➕ Create Branch</a>

    <div class="grid">

        <?php foreach($branches as $b): ?>

        <div class="card">

            <h3><?= $b->name ?></h3>

            <p><?= $b->address ?></p>

            <small>
                Business: <?= $b->business->name ?? 'N/A' ?>
            </small>

            <div class="actions">
                <a href="/branch/update?id=<?= $b->id ?>">✏ Edit</a>
                <a href="/branch/delete?id=<?= $b->id ?>"
                   onclick="return confirm('Delete branch?')">🗑 Delete</a>
            </div>

        </div>

        <?php endforeach; ?>

    </div>

</div>