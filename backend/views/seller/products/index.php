<?php

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'My Products';
?>

<div class="card shadow-sm">

    <div class="card-header d-flex justify-content-between align-items-center">

        <h3>📦 My Branch Products</h3>

        <!-- IMPORTANT: correct route -->
        <a href="<?= Url::to(['/seller/create-product']) ?>" class="btn btn-success">
            ➕ Add Product
        </a>

    </div>

    <div class="card-body">

        <table class="table table-hover table-bordered">

            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Buy</th>
                    <th>Sell</th>
                    <th>Stock</th>
                    <th>Value</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($products as $p): ?>

                <tr>
                    <td><?= $p->id ?></td>
                    <td><?= Html::encode($p->name) ?></td>
                    <td><?= number_format($p->buying_price) ?></td>
                    <td><?= number_format($p->selling_price) ?></td>

                    <td>
                        <span class="badge bg-primary">
                            <?= $p->stock_quantity ?>
                        </span>
                    </td>

                    <td>
                        <?= number_format($p->getStockValue(), 2) ?>
                    </td>

                    <td>

                        <a href="<?= Url::to(['/seller/update-product', 'id' => $p->id]) ?>"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="<?= Url::to(['/seller/delete-product', 'id' => $p->id]) ?>"
                           class="btn btn-danger btn-sm"
                           data-method="post"
                           data-confirm="Delete this product?">
                            Delete
                        </a>

                    </td>
                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    </div>
</div>