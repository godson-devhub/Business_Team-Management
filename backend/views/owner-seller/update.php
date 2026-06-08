<?php
/**
 * @var \common\models\Product $model
 * @var array $branches
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;

$this->title = 'Update Seller';
?>

<div style="padding:40px; color:white;">

<h1>✏ Update Seller</h1>

<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'username') ?>
<?= $form->field($model, 'email') ?>

<?= $form->field($model, 'branch_id')
    ->dropDownList(
        ArrayHelper::map($branches, 'id', 'name'),
        ['prompt' => 'Assign Branch']
    )
?>

<?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>

<?php ActiveForm::end(); ?>

</div>