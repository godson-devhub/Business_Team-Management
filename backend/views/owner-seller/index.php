<?php

/**
 * @var \common\models\User $model
 * @var array $branches
 * @var array $sellers
 */

 $this->title = 'Sellers'; ?>

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
}

.btn{
    padding:12px 18px;
    background:linear-gradient(135deg,#38bdf8,#6366f1);
    border-radius:12px;
    color:white;
    text-decoration:none;
}

.card{
    background:rgba(255,255,255,0.07);
    padding:20px;
    margin:10px 0;
    border-radius:15px;
    backdrop-filter:blur(10px);
}
</style>

<div class="container">

    <div class="title">👨‍💼 Sellers</div>

    <a href="/owner-seller/create" class="btn">➕ Add Seller</a>

    <?php foreach($sellers as $s): ?>

        <div class="card">

            <h3><?= $s->username ?></h3>

            <p>Email: <?= $s->email ?></p>

            <p>Branch: <?= $s->branch_id ?? 'Not assigned' ?></p>

            <a href="/owner-seller/update?id=<?= $s->id ?>">✏ Edit</a>
            <a href="/owner-seller/delete?id=<?= $s->id ?>" onclick="return confirm('Delete?')">🗑 Delete</a>

        </div>

    <?php endforeach; ?>

</div>