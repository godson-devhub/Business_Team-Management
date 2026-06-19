<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/** @var \common\models\User $model */
/** @var array $branches */

$this->title = 'Create Seller';
?>

<style>

/* ================= GLOBAL PAGE ================= */
.page {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px;
    font-family: 'Segoe UI', sans-serif;
    color: #fff;
    background: linear-gradient(135deg, #020617, #0f172a, #1e293b);
}

/* ================= CARD ================= */
.card {
    width: 100%;
    max-width: 520px;
    background: rgba(255, 255, 255, 0.06);
    backdrop-filter: blur(18px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 22px;
    padding: 30px;
    box-shadow: 0 20px 50px rgba(0,0,0,0.4);
    transition: 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

/* ================= TITLE ================= */
.title {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
    background: linear-gradient(to right, #38bdf8, #a78bfa, #c084fc);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* ================= FORM ================= */
.form-control {
    width: 100%;
    padding: 12px 14px;
    margin-bottom: 15px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.15);
    background: rgba(255,255,255,0.05);
    color: white;
    outline: none;
    transition: 0.3s;
}

.form-control:focus {
    border-color: #38bdf8;
    box-shadow: 0 0 10px rgba(56,189,248,0.3);
}

/* ================= LABEL ================= */
label {
    display: block;
    margin-bottom: 6px;
    color: #cbd5e1;
    font-size: 14px;
}

/* ================= BUTTON ================= */
.btn {
    width: 100%;
    padding: 14px;
    border-radius: 14px;
    border: none;
    cursor: pointer;
    font-weight: bold;
    color: white;
    background: linear-gradient(135deg, #38bdf8, #6366f1);
    transition: 0.3s ease;
}

.btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(56,189,248,0.3);
}

/* ================= BACK LINK ================= */
.back {
    display: inline-block;
    margin-top: 15px;
    color: #94a3b8;
    text-decoration: none;
    font-size: 14px;
}

.back:hover {
    color: #38bdf8;
}

</style>

<div class="page">

    <div class="card">

        <div class="title">➕ Create Seller</div>

        <?php $form = ActiveForm::begin(); ?>

        <!-- Username -->
        <?= $form->field($model, 'username')
            ->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter username'
            ])
        ?>

        <!-- Email -->
        <?= $form->field($model, 'email')
            ->textInput([
                'class' => 'form-control',
                'placeholder' => 'Enter email'
            ])
        ?>

        <!-- Password -->
        <?= $form->field($model, 'password')
            ->passwordInput([
                'class' => 'form-control',
                'placeholder' => 'Enter password'
            ])
        ?>

        <!-- Branch -->
        <?= $form->field($model, 'branch_id')
            ->dropDownList(
                ArrayHelper::map($branches, 'id', 'name'),
                [
                    'prompt' => 'Select Branch',
                    'class' => 'form-control'
                ]
            )
        ?>

        <!-- SUBMIT -->
        <?= Html::submitButton('Save Seller', [
            'class' => 'btn'
        ]) ?>

        <?php ActiveForm::end(); ?>

        <!-- BACK -->
        <a href="<?= Url::to(['/owner-seller/index']) ?>" class="back">
            ← Back to Sellers
        </a>

    </div>

</div>