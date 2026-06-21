<?php

/**
 * @var \common\models\Product[] $products
 */

$this->title = 'POS System';
?>

<div class="page-container narrow">

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <a href="/sale/index">
            <i data-lucide="chevron-left" class="icon-16"></i>
            Sales
        </a>
        <span class="breadcrumb-separator">/</span>
        <span class="breadcrumb-current">New Sale</span>
    </nav>

    <!-- POS Card -->
    <div class="pos-card" data-reveal>
        <div class="pos-header">
            <div class="pos-icon">
                <i data-lucide="credit-card" class="icon-32"></i>
            </div>
            <div>
                <h1 class="pos-title">Smart POS</h1>
                <p class="pos-subtitle">Quick checkout for your customers</p>
            </div>
        </div>

        <form method="post" class="pos-form">
            <!-- CSRF -->
            <input type="hidden" name="_csrf-backend" value="<?= Yii::$app->request->csrfToken ?>">

            <!-- Product Select -->
            <div class="form-group">
                <label class="form-label">
                    <i data-lucide="package" class="icon-14"></i>
                    Select Product
                </label>
                <div class="select-wrapper">
                    <i data-lucide="search" class="select-icon"></i>
                    <select name="product_id" class="form-control" required>
                        <option value="">Choose a product...</option>
                        <?php foreach($products as $product): ?>
                            <?php
                                $name = htmlspecialchars((string)$product->name);
                                $stock = (int)$product->stock_quantity;
                                $isLow = $stock <= 5;
                            ?>
                            <option value="<?= (int)$product->id ?>">
                                <?= $name ?> — Stock: <?= $stock ?> <?= $isLow ? '(Low)' : '' ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Quantity -->
            <div class="form-group">
                <label class="form-label">
                    <i data-lucide="hash" class="icon-14"></i>
                    Quantity
                </label>
                <div class="quantity-input">
                    <button type="button" class="qty-btn qty-minus" onclick="adjustQty(-1)">
                        <i data-lucide="minus" class="icon-16"></i>
                    </button>
                    <input
                        type="number"
                        name="quantity"
                        class="form-control qty-field"
                        value="1"
                        min="1"
                        required
                    >
                    <button type="button" class="qty-btn qty-plus" onclick="adjustQty(1)">
                        <i data-lucide="plus" class="icon-16"></i>
                    </button>
                </div>
            </div>

            <!-- Quick Amount Buttons -->
            <div class="quick-qty">
                <span class="quick-label">Quick:</span>
                <button type="button" class="quick-btn" onclick="setQty(1)">1</button>
                <button type="button" class="quick-btn" onclick="setQty(2)">2</button>
                <button type="button" class="quick-btn" onclick="setQty(5)">5</button>
                <button type="button" class="quick-btn" onclick="setQty(10)">10</button>
                <button type="button" class="quick-btn" onclick="setQty(20)">20</button>
            </div>

            <!-- Submit -->
            <button type="submit" class="btn btn-primary btn-glow pos-submit">
                <i data-lucide="check-circle" class="icon-20"></i>
                Complete Sale
            </button>
        </form>
    </div>

</div>

<style>
/* ============================================
   POS CARD
   ============================================ */
.pos-card {
    background: var(--card-bg);
    border: 1px solid var(--border);
    border-radius: var(--radius-xl);
    padding: 32px;
    margin-top: 24px;
    position: relative;
    overflow: hidden;
}

.pos-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #38bdf8, #8b5cf6);
}

.pos-header {
    display: flex;
    align-items: center;
    gap: 16px;
    margin-bottom: 28px;
}

.pos-icon {
    width: 56px;
    height: 56px;
    border-radius: var(--radius);
    background: linear-gradient(135deg, #38bdf8, #8b5cf6);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    box-shadow: 0 4px 16px rgba(139, 92, 246, 0.3);
    animation: posFloat 3s ease-in-out infinite;
}

@keyframes posFloat {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.pos-title {
    font-size: 24px;
    font-weight: 800;
    color: var(--text);
    margin: 0 0 4px;
}

.pos-subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin: 0;
}

/* ============================================
   POS FORM
   ============================================ */
.pos-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text-secondary);
    margin-bottom: 8px;
}

.form-label i {
    color: var(--primary);
}

.select-wrapper {
    position: relative;
}

.select-icon {
    position: absolute;
    left: 14px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--text-muted);
    width: 18px;
    height: 18px;
    pointer-events: none;
}

select.form-control {
    padding-left: 44px;
    appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748b' stroke-width='2'%3E%3Cpath d='m6 9 6 6 6-6'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 14px center;
    padding-right: 40px;
}

/* Quantity Input */
.quantity-input {
    display: flex;
    align-items: center;
    gap: 8px;
}

.qty-btn {
    width: 44px;
    height: 44px;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    background: var(--bg-elevated);
    color: var(--text);
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    flex-shrink: 0;
}

.qty-btn:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: scale(1.05);
}

.qty-field {
    text-align: center;
    font-weight: 700;
    font-size: 16px;
    -moz-appearance: textfield;
}

.qty-field::-webkit-outer-spin-button,
.qty-field::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Quick Qty */
.quick-qty {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.quick-label {
    font-size: 12px;
    color: var(--text-muted);
    font-weight: 500;
    margin-right: 4px;
}

.quick-btn {
    padding: 8px 16px;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    background: var(--bg-elevated);
    color: var(--text-secondary);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
}

.quick-btn:hover {
    background: var(--primary);
    color: white;
    border-color: var(--primary);
    transform: translateY(-2px);
}

/* POS Submit */
.pos-submit {
    margin-top: 8px;
    padding: 16px;
    font-size: 15px;
    gap: 10px;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .pos-card {
        padding: 20px;
    }
    .pos-header {
        flex-direction: column;
        text-align: center;
    }
    .quantity-input {
        justify-content: center;
    }
}
</style>

<script>
function adjustQty(delta) {
    const field = document.querySelector('.qty-field');
    let val = parseInt(field.value) || 1;
    val = Math.max(1, val + delta);
    field.value = val;
}

function setQty(val) {
    document.querySelector('.qty-field').value = val;
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') lucide.createIcons();
});
</script>