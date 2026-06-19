<?php

use yii\helpers\Html;

$this->title = 'Add Product';
?>

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0">➕ Create New Product</h3>
    </div>

    <div class="card-body">
        <?= $this->render('_form', [
            'model' => $model
        ]) ?>
    </div>
</div>