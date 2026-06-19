<?php

use yii\helpers\Html;

/** @var $model common\models\User */

$this->title = $model->username;

?>

<div class="user-view">

    <h2>👤 Seller Details</h2>

    <table class="table table-bordered">

        <tr>
            <th>ID</th>
            <td><?= $model->id ?></td>
        </tr>

        <tr>
            <th>Username</th>
            <td><?= $model->username ?></td>
        </tr>

        <tr>
            <th>Email</th>
            <td><?= $model->email ?></td>
        </tr>

        <tr>
            <th>Role</th>
            <td><?= $model->role ?></td>
        </tr>

        <tr>
            <th>Branch</th>
            <td><?= $model->branch->name ?? 'Not Assigned' ?></td>
        </tr>

        <tr>
            <th>Status</th>
            <td><?= $model->status == 10 ? 'Active' : 'Inactive' ?></td>
        </tr>

    </table>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-warning']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure?',
                'method' => 'post'
            ]
        ]) ?>
    </p>

</div>