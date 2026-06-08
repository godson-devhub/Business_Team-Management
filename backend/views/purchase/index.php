<h1>Purchases</h1>

<a href="create">
    Create Purchase
</a>

<hr>

<?php foreach($purchases as $purchase): ?>

    <div style="
        border:1px solid #ccc;
        padding:10px;
        margin:10px;
    ">

        <h3>
            Purchase #<?= $purchase->id ?>
        </h3>

        <p>
            Supplier:
            <?= $purchase->supplier_name ?>
        </p>

        <p>
            Amount:
            <?= $purchase->total_amount ?>
        </p>

    </div>

<?php endforeach; ?>