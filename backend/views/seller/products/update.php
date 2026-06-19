<?php

$this->title = 'Update Product';
?>

<div class="card shadow-sm">

    <div class="card-header bg-warning">
        <h3>✏️ Update Product</h3>
    </div>

    <div class="card-body">

        <?= $this->render('_form', [
            'model' => $model
        ]) ?>

    </div>
</div>