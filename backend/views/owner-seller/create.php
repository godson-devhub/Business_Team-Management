<?php
/**
 * @var \common\models\User $model
 * @var array $branches
 */
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Create Seller';
?>

<div style="padding:40px; color:white;">

<h1>➕ Create Seller</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'email') ?>
<?= $form->field($model, 'password')->passwordInput() ?>

<?= $form->field($model, 'branch_id')
    ->dropDownList(
        ArrayHelper::map($branches, 'id', 'name'),
        ['prompt' => 'Assign Branch']
    )
?>

<?= Html::submitButton('Save Seller', ['class' => 'btn btn-success']) ?>

<?php ActiveForm::end(); ?>

</div>