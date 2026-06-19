<?php

use yii\helpers\Html;

$this->title = 'Delete Product';
?>

<div class="card shadow-sm border-danger">

    <div class="card-header bg-danger text-white">
        <h3>⚠️ Delete Product</h3>
    </div>

    <div class="card-body">

        <p class="text-danger">
            Are you sure you want to delete this product?
        </p>

        <div class="alert alert-warning">
            <strong><?= Html::encode($model->name) ?></strong><br>
            Stock: <?= (int)$model->stock_quantity ?><br>
            Selling Price: <?= number_format($model->selling_price) ?>
        </div>

        <form method="post">

            <!-- CSRF PROTECTION -->
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                   value="<?= Yii::$app->request->csrfToken ?>">

            <button type="submit" class="btn btn-danger">
                🗑 Yes, Delete
            </button>

            <a href="<?= \yii\helpers\Url::to(['index']) ?>" class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>

</div>