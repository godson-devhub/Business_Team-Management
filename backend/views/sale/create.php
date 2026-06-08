<?php
/**
 * @var \common\models\Product $model
 *  @var \common\models\Product[] $products
 */

$this->title = 'POS System';

?>

<style>

body{

    background:
    linear-gradient(
    135deg,
    #020617,
    #0f172a,
    #1e293b
    );

    color:white;

    font-family:'Segoe UI';

    padding:40px;
}

.glass{

    max-width:700px;

    margin:auto;

    background:
    rgba(255,255,255,0.08);

    border:
    1px solid rgba(255,255,255,0.1);

    backdrop-filter:blur(16px);

    border-radius:30px;

    padding:35px;

    box-shadow:
    0 10px 40px rgba(0,0,0,0.3);
}

.title{

    font-size:35px;

    margin-bottom:25px;

    font-weight:bold;

    background:
    linear-gradient(
    to right,
    #38bdf8,
    #818cf8
    );

    -webkit-background-clip:text;

    -webkit-text-fill-color:transparent;
}

.input{

    width:100%;

    padding:16px;

    margin-bottom:20px;

    border:none;

    border-radius:15px;

    background:
    rgba(255,255,255,0.08);

    color:white;

    font-size:15px;
}

.input:focus{

    outline:none;

    transform:scale(1.02);

    transition:0.3s;
}

.btn{

    width:100%;

    padding:18px;

    border:none;

    border-radius:18px;

    background:
    linear-gradient(
    135deg,
    #38bdf8,
    #6366f1
    );

    color:white;

    font-size:16px;

    cursor:pointer;

    transition:0.3s;
}

.btn:hover{

    transform:
    translateY(-4px);

    box-shadow:
    0 10px 30px rgba(56,189,248,0.4);
}

.cartoon{

    width:100px;

    animation:floaty 3s infinite;
}

@keyframes floaty{

    0%{
        transform:translateY(0px);
    }

    50%{
        transform:translateY(-12px);
    }

    100%{
        transform:translateY(0px);
    }
}

</style>

<div class="glass">

    <img
    src="https://cdn-icons-png.flaticon.com/512/3514/3514491.png"
    class="cartoon"
    >

    <div class="title">
        💳 Smart POS System
    </div>

    <form method="post">

        <select
        name="product_id"
        class="input"
        >

            <?php foreach($products as $product): ?>

                <option
                value="<?= $product->id ?>"
                >

                    <?= $product->name ?>

                    |
                    Stock:
                    <?= $product->stock_quantity ?>

                </option>

            <?php endforeach; ?>

        </select>

        <input
        type="number"
        name="quantity"
        class="input"
        placeholder="Enter quantity"
        >

        <button
        type="submit"
        class="btn"
        >

            🚀 Complete Sale

        </button>

    </form>

</div>