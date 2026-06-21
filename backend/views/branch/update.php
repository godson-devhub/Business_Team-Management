<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * @var \common\models\Branch $model
 * @var \common\models\Business[] $businesses
 */

$this->title = 'Update ' . Html::encode($model->name);
?>

<div class="branch-page">
    <!-- Ambient Background -->
    <div class="ambient-bg">
        <div class="ambient-orb orb-1"></div>
        <div class="ambient-orb orb-2"></div>
        <div class="ambient-orb orb-3"></div>
    </div>

    <div class="page-wrapper narrow">
        <!-- Breadcrumb -->
        <nav class="breadcrumb">
            <a href="<?= Url::to(['branch/index']) ?>">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"></polyline>
                </svg>
                Branches
            </a>
            <svg class="breadcrumb-separator" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <a href="<?= Url::to(['branch/view', 'id' => $model->id]) ?>">
                <?= Html::encode($model->name) ?>
            </a>
            <svg class="breadcrumb-separator" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="9 18 15 12 9 6"></polyline>
            </svg>
            <span class="breadcrumb-current">Edit</span>
        </nav>

        <!-- Form Card -->
        <div class="form-card update-card">
            <div class="form-card-accent update-accent"></div>
            <div class="form-header">
                <div class="form-icon update-icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                </div>
                <div class="form-header-text">
                    <h1 class="form-title">Update Branch</h1>
                    <p class="form-subtitle">Edit <?= Html::encode($model->name) ?> details</p>
                </div>
            </div>

            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'form-body'],
                'fieldConfig' => [
                    'template' => "{label}\n{input}\n{error}",
                    'inputOptions' => ['class' => 'form-control'],
                    'labelOptions' => ['class' => 'form-label'],
                    'errorOptions' => ['class' => 'form-error'],
                ],
            ]); ?>

                <div class="form-group">
                    <?= $form->field($model, 'business_id')
                        ->dropDownList(
                            ArrayHelper::map($businesses, 'id', 'name'),
                            ['prompt' => 'Select Business', 'class' => 'form-control form-select']
                        )
                    ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'name')->textInput([
                        'placeholder' => 'Branch name',
                        'autocomplete' => 'off',
                    ]) ?>
                </div>

                <div class="form-group">
                    <?= $form->field($model, 'location')->textInput([
                        'placeholder' => 'Branch location',
                        'autocomplete' => 'off',
                    ]) ?>
                </div>

                <div class="form-actions">
                    <a href="<?= Url::to(['branch/view', 'id' => $model->id]) ?>" class="btn btn-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="19" y1="12" x2="5" y2="12"></line>
                            <polyline points="12 19 5 12 12 5"></polyline>
                        </svg>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary update-btn">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                            <polyline points="17 21 17 13 7 13 7 21"></polyline>
                            <polyline points="7 3 7 8 15 8"></polyline>
                        </svg>
                        Save Changes
                    </button>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<style>
/* ============================================
   CSS VARIABLES - THEME SYSTEM
   ============================================ */
:root {
    --bg-primary: #ffffff;
    --bg-secondary: #f8fafc;
    --bg-tertiary: #f1f5f9;
    --bg-card: rgba(255, 255, 255, 0.85);
    --bg-card-solid: #ffffff;
    --bg-hover: rgba(241, 245, 249, 0.6);
    --bg-input: #ffffff;
    
    --text-primary: #0f172a;
    --text-secondary: #475569;
    --text-tertiary: #94a3b8;
    --text-muted: #64748b;
    --text-placeholder: #94a3b8;
    
    --border-subtle: rgba(226, 232, 240, 0.8);
    --border-card: rgba(226, 232, 240, 0.6);
    --border-input: rgba(203, 213, 225, 0.6);
    --border-divider: rgba(241, 245, 249, 0.8);
    
    --accent-blue: #3b82f6;
    --accent-blue-light: #dbeafe;
    --accent-purple: #8b5cf6;
    --accent-purple-light: #ede9fe;
    --accent-emerald: #10b981;
    --accent-emerald-light: #d1fae5;
    --accent-amber: #f59e0b;
    --accent-amber-light: #fef3c7;
    --accent-orange: #f97316;
    
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.05), 0 4px 6px -4px rgba(0, 0, 0, 0.05);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    
    --radius-sm: 8px;
    --radius-md: 12px;
    --radius-lg: 16px;
    --radius-xl: 20px;
    --radius-full: 9999px;
    
    --transition-fast: 150ms cubic-bezier(0.4, 0, 0.2, 1);
    --transition-base: 250ms cubic-bezier(0.4, 0, 0.2, 1);
}

body.dark,
[data-theme="dark"] {
    --bg-primary: #0f172a;
    --bg-secondary: #1e293b;
    --bg-tertiary: #334155;
    --bg-card: rgba(30, 41, 59, 0.7);
    --bg-card-solid: #1e293b;
    --bg-hover: rgba(51, 65, 85, 0.4);
    --bg-input: rgba(15, 23, 42, 0.6);
    
    --text-primary: #f8fafc;
    --text-secondary: #cbd5e1;
    --text-tertiary: #94a3b8;
    --text-muted: #64748b;
    --text-placeholder: #475569;
    
    --border-subtle: rgba(51, 65, 85, 0.6);
    --border-card: rgba(51, 65, 85, 0.5);
    --border-input: rgba(71, 85, 105, 0.6);
    --border-divider: rgba(51, 65, 85, 0.4);
    
    --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.2), 0 2px 4px -2px rgba(0, 0, 0, 0.2);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.2), 0 4px 6px -4px rgba(0, 0, 0, 0.2);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 8px 10px -6px rgba(0, 0, 0, 0.3);
}

/* ============================================
   BASE LAYOUT
   ============================================ */
.branch-page {
    position: relative;
    min-height: 100vh;
    padding: 24px;
    background: var(--bg-primary);
    color: var(--text-primary);
    transition: background-color var(--transition-base), color var(--transition-base);
}

@media (min-width: 768px) {
    .branch-page {
        padding: 32px;
    }
}

@media (min-width: 1024px) {
    .branch-page {
        padding: 40px;
    }
}

/* ============================================
   AMBIENT BACKGROUND
   ============================================ */
.ambient-bg {
    position: fixed;
    inset: 0;
    z-index: 0;
    overflow: hidden;
    pointer-events: none;
}

.ambient-orb {
    position: absolute;
    border-radius: 50%;
    filter: blur(120px);
    opacity: 0.1;
    animation: float 20s ease-in-out infinite;
}

body.dark .ambient-orb,
[data-theme="dark"] .ambient-orb {
    opacity: 0.05;
}

.orb-1 {
    width: 400px;
    height: 400px;
    background: var(--accent-amber);
    top: -150px;
    left: -100px;
    animation-delay: 0s;
}

.orb-2 {
    width: 350px;
    height: 350px;
    background: var(--accent-orange);
    top: 30%;
    right: -120px;
    animation-delay: -7s;
}

.orb-3 {
    width: 300px;
    height: 300px;
    background: var(--accent-purple);
    bottom: -100px;
    left: 20%;
    animation-delay: -14s;
}

@keyframes float {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -30px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}

/* ============================================
   PAGE WRAPPER
   ============================================ */
.page-wrapper {
    position: relative;
    z-index: 1;
    max-width: 560px;
    margin: 0 auto;
}

.page-wrapper.narrow {
    padding-top: 20px;
}

/* ============================================
   BREADCRUMB
   ============================================ */
.breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 13px;
    color: var(--text-tertiary);
    margin-bottom: 24px;
    flex-wrap: wrap;
}

.breadcrumb a {
    display: flex;
    align-items: center;
    gap: 6px;
    color: var(--text-muted);
    text-decoration: none;
    transition: color var(--transition-fast);
    max-width: 150px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.breadcrumb a:hover {
    color: var(--accent-amber);
}

.breadcrumb a svg {
    opacity: 0.7;
    flex-shrink: 0;
}

.breadcrumb-separator {
    color: var(--text-tertiary);
    opacity: 0.5;
    flex-shrink: 0;
}

.breadcrumb-current {
    color: var(--text-primary);
    font-weight: 500;
}

/* ============================================
   FORM CARD
   ============================================ */
.form-card {
    background: var(--bg-card);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid var(--border-card);
    border-radius: var(--radius-xl);
    padding: 32px;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    transition: all var(--transition-base);
}

.form-card:hover {
    box-shadow: var(--shadow-xl);
}

.form-card-accent {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--accent-blue), var(--accent-purple));
}

.update-accent {
    background: linear-gradient(90deg, var(--accent-amber), var(--accent-orange));
}

/* ============================================
   FORM HEADER
   ============================================ */
.form-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 28px;
}

.form-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius-md);
    background: linear-gradient(135deg, var(--accent-blue), var(--accent-purple));
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
    flex-shrink: 0;
}

.update-icon {
    background: linear-gradient(135deg, var(--accent-amber), var(--accent-orange));
    box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
}

.form-icon svg {
    width: 24px;
    height: 24px;
}

.form-header-text {
    min-width: 0;
}

.form-title {
    font-size: 22px;
    font-weight: 700;
    color: var(--text-primary);
    margin: 0 0 4px 0;
    letter-spacing: -0.01em;
}

.form-subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
}

/* ============================================
   FORM BODY
   ============================================ */
.form-body {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.form-label {
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 2px;
}

.form-label::after {
    content: ' *';
    color: #ef4444;
}

.form-control {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid var(--border-input);
    border-radius: var(--radius-md);
    background: var(--bg-input);
    color: var(--text-primary);
    font-size: 14px;
    font-family: inherit;
    transition: all var(--transition-fast);
    outline: none;
    box-sizing: border-box;
}

.form-control:focus {
    border-color: var(--accent-amber);
    box-shadow: 0 0 0 3px rgba(245, 158, 11, 0.1);
}

.form-control::placeholder {
    color: var(--text-placeholder);
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

/* Select styling */
.form-select {
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    padding-right: 36px;
    cursor: pointer;
}

body.dark .form-select,
[data-theme="dark"] .form-select {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
}

.form-error {
    font-size: 12px;
    color: #ef4444;
    margin-top: 4px;
    display: flex;
    align-items: center;
    gap: 4px;
}

.form-error::before {
    content: '⚠';
}

/* ============================================
   FORM ACTIONS
   ============================================ */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    padding-top: 16px;
    border-top: 1px solid var(--border-divider);
    margin-top: 8px;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 10px 20px;
    border-radius: var(--radius-md);
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    cursor: pointer;
    transition: all var(--transition-fast);
    border: none;
    font-family: inherit;
    white-space: nowrap;
}

.btn-primary {
    background: linear-gradient(135deg, var(--accent-blue), #6366f1);
    color: white;
    box-shadow: 0 4px 14px rgba(59, 130, 246, 0.35);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(59, 130, 246, 0.45);
}

.btn-primary:active {
    transform: translateY(0);
}

.update-btn {
    background: linear-gradient(135deg, var(--accent-amber), var(--accent-orange));
    box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);
}

.update-btn:hover {
    box-shadow: 0 6px 20px rgba(245, 158, 11, 0.45);
}

.btn-secondary {
    background: transparent;
    color: var(--text-secondary);
    border: 1px solid var(--border-subtle);
}

.btn-secondary:hover {
    background: var(--bg-hover);
    border-color: var(--text-tertiary);
    color: var(--text-primary);
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .form-card {
        padding: 24px;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .form-actions .btn {
        width: 100%;
    }
}

@media (max-width: 479px) {
    .form-header {
        flex-direction: column;
        text-align: center;
    }
    
    .form-icon {
        margin: 0 auto;
    }
    
    .breadcrumb a {
        max-width: 100px;
    }
}
</style>