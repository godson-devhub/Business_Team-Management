<?php

use yii\helpers\Html;

/** @var $sellers common\models\User[] */

$this->title = 'Sellers Management';

?>

<div class="user-index">

    <h2>👥 Sellers List</h2>

    <p>
        <?= Html::a('➕ Create Seller', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <table class="table table-bordered table-hover">

        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Branch</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>

        <?php foreach ($sellers as $seller): ?>

            <tr>
                <td>#<?= $seller->id ?></td>

                <td><?= $seller->username ?></td>

                <td><?= $seller->email ?></td>

                <td>
                    <?= $seller->branch->name ?? 'Not Assigned' ?>
                </td>

                <td>
                    <?= $seller->status == 10 ? 'Active' : 'Inactive' ?>
                </td>

                <td>
                    <?= Html::a('View', ['view', 'id' => $seller->id], ['class' => 'btn btn-primary btn-sm']) ?>
                    <?= Html::a('Update', ['update', 'id' => $seller->id], ['class' => 'btn btn-warning btn-sm']) ?>
                    <?= Html::a('Delete', ['delete', 'id' => $seller->id], [
                        'class' => 'btn btn-danger btn-sm',
                        'data' => [
                            'confirm' => 'Are you sure?',
                            'method' => 'post'
                        ]
                    ]) ?>
                </td>
            </tr>

        <?php endforeach; ?>

        </tbody>

    </table>

</div>