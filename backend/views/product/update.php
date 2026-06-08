<?php
/**
 * @var \common\models\Product $model
 * @var array $branches
 */

use yii\helpers\Html;

$this->title = 'Update Product';

?>

<style>

    body{

        margin:0;
        padding:0;

        background:
        linear-gradient(
        135deg,
        #020617,
        #0f172a,
        #1e1b4b
        );

        font-family:'Segoe UI',sans-serif;

        overflow-x:hidden;

        color:white;
    }

    /* ANIMATED BACKGROUND */

    .bg-wrapper{

        position:fixed;

        width:100%;
        height:100%;

        overflow:hidden;

        z-index:-1;
    }

    .glow{

        position:absolute;

        border-radius:50%;

        filter:blur(100px);

        opacity:0.35;

        animation:moveGlow 10s infinite alternate ease-in-out;
    }

    .glow1{

        width:350px;
        height:350px;

        background:#38bdf8;

        top:-120px;
        left:-100px;
    }

    .glow2{

        width:300px;
        height:300px;

        background:#8b5cf6;

        bottom:-80px;
        right:-80px;
    }

    @keyframes moveGlow{

        0%{
            transform:translate(0,0);
        }

        100%{
            transform:translate(50px,30px);
        }
    }

    /* PAGE */

    .page-container{

        min-height:100vh;

        display:flex;

        justify-content:center;

        align-items:center;

        padding:40px;
    }

    /* GLASS CARD */

    .glass-card{

        width:100%;
        max-width:720px;

        background:rgba(255,255,255,0.08);

        backdrop-filter:blur(18px);

        border:1px solid rgba(255,255,255,0.12);

        border-radius:32px;

        padding:45px;

        position:relative;

        overflow:hidden;

        box-shadow:
        0 15px 40px rgba(0,0,0,0.4);

        animation:fadeUp 1s ease;
    }

    @keyframes fadeUp{

        from{
            opacity:0;
            transform:translateY(50px);
        }

        to{
            opacity:1;
            transform:translateY(0);
        }
    }

    .glass-card::before{

        content:'';

        position:absolute;

        top:-90px;
        right:-90px;

        width:240px;
        height:240px;

        border-radius:50%;

        background:
        rgba(56,189,248,0.15);
    }

    /* HEADER */

    .status-badge{

        display:inline-block;

        padding:8px 18px;

        border-radius:50px;

        background:
        rgba(34,197,94,0.15);

        border:1px solid rgba(34,197,94,0.35);

        color:#86efac;

        font-size:13px;

        margin-bottom:20px;

        animation:pulse 1.5s infinite;
    }

    @keyframes pulse{

        0%{
            transform:scale(1);
        }

        50%{
            transform:scale(1.05);
        }

        100%{
            transform:scale(1);
        }
    }

    .title{

        font-size:38px;

        font-weight:bold;

        margin-bottom:10px;

        background:
        linear-gradient(
        to right,
        #38bdf8,
        #818cf8,
        #c084fc
        );

        -webkit-background-clip:text;

        -webkit-text-fill-color:transparent;
    }

    .subtitle{

        color:#cbd5e1;

        margin-bottom:35px;

        font-size:15px;
    }

    /* FORM */

    .form-group{
        margin-bottom:25px;
    }

    .form-label{

        display:block;

        margin-bottom:10px;

        color:#e2e8f0;

        font-size:14px;
    }

    .form-input{

        width:100%;

        padding:18px;

        border:none;

        border-radius:18px;

        background:
        rgba(255,255,255,0.07);

        color:white;

        font-size:15px;

        outline:none;

        transition:0.35s ease;

        box-sizing:border-box;
    }

    .form-input::placeholder{
        color:#94a3b8;
    }

    .form-input:focus{

        transform:scale(1.02);

        background:
        rgba(255,255,255,0.12);

        box-shadow:
        0 0 20px rgba(56,189,248,0.35);
    }

    /* BUTTON */

    .update-btn{

        width:100%;

        padding:18px;

        border:none;

        border-radius:18px;

        background:
        linear-gradient(
        135deg,
        #38bdf8,
        #6366f1,
        #8b5cf6
        );

        color:white;

        font-size:16px;

        font-weight:bold;

        cursor:pointer;

        transition:0.35s ease;
    }

    .update-btn:hover{

        transform:
        translateY(-5px)
        scale(1.02);

        box-shadow:
        0 15px 35px rgba(99,102,241,0.45);
    }

    /* CARTOON */

    .cartoon{

        position:absolute;

        bottom:-5px;
        right:15px;

        animation:floaty 3s ease-in-out infinite;
    }

    .cartoon img{
        width:130px;
    }

    @keyframes floaty{

        0%{
            transform:translateY(0px);
        }

        50%{
            transform:translateY(-14px);
        }

        100%{
            transform:translateY(0px);
        }
    }

</style>

<div class="bg-wrapper">

    <div class="glow glow1"></div>

    <div class="glow glow2"></div>

</div>

<div class="page-container">

    <div class="glass-card">

        <div class="status-badge">
            ● LIVE PRODUCT EDITOR
        </div>

        <div class="title">
            ✨ Update Product
        </div>

        <div class="subtitle">
            Edit your products beautifully with interactive modern UI/UX.
        </div>

        <form method="post">

            <div class="form-group">

                <label class="form-label">
                    Product Name
                </label>

                <input
                    type="text"
                    name="Product[name]"
                    class="form-input"
                    value="<?= Html::encode($model->name) ?>"
                    placeholder="Enter product name..."
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Buying Price
                </label>

                <input
                    type="number"
                    step="0.01"
                    name="Product[buying_price]"
                    class="form-input"
                    value="<?= $model->buying_price ?>"
                    placeholder="Buying price..."
                >

            </div>

            <div class="form-group">

                <label class="form-label">
                    Selling Price
                </label>

                <input
                    type="number"
                    step="0.01"
                    name="Product[selling_price]"
                    class="form-input"
                    value="<?= $model->selling_price ?>"
                    placeholder="Selling price..."
                >

            </div>

            <button type="submit" class="update-btn">

                🚀 Update Product

            </button>

        </form>

        <div class="cartoon">

            <img
            src="https://cdn-icons-png.flaticon.com/512/679/679922.png"
            >

        </div>

    </div>

</div>