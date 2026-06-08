<h1>Sales History</h1>

<a href="create">
    Create Sale
</a>

<hr>

<?php foreach($sales as $sale): ?>

    <div style="
        border:1px solid #ccc;
        margin:10px;
        padding:10px;
    ">

        <h3>
            Sale #<?= $sale->id ?>
        </h3>

        <p>
            Amount:
            <?= $sale->total_amount ?>
        </p>

        <p>
            Profit:
            <?= $sale->total_profit ?>
        </p>

    </div>

<?php endforeach; ?>