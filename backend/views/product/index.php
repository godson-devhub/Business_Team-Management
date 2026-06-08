<?php
/**
 * @var \common\models\Product[] $products
 */

use yii\helpers\Html;

$this->title = 'Create Product';

?>

<style>

    body{
        margin:0;
        padding:0;
        background:
        linear-gradient(135deg,#020617,#0f172a,#1e293b);
        font-family:'Segoe UI',sans-serif;
        overflow-x:hidden;
        color:white;
    }

    .background-blobs{

        position:fixed;
        width:100%;
        height:100%;
        z-index:-1;
        overflow:hidden;
    }

    .blob{

        position:absolute;
        border-radius:50%;
        filter:blur(80px);
        opacity:0.4;
        animation:moveBlob 12s infinite alternate ease-in-out;
    }

    .blob1{
        width:300px;
        height:300px;
        background:#38bdf8;
        top:-50px;
        left:-50px;
    }

    .blob2{
        width:250px;
        height:250px;
        background:#8b5cf6;
        bottom:-50px;
        right:-50px;
    }

    @keyframes moveBlob{

        0%{
            transform:translateY(0px) translateX(0px);
        }

        100%{
            transform:translateY(40px) translateX(30px);
        }
    }

    .page-wrapper{
        min-height:100vh;
        display:flex;
        justify-content:center;
        align-items:center;
        padding:40px;
    }

    .glass-card{

        width:100%;
        max-width:650px;

        background:rgba(255,255,255,0.08);

        border:1px solid rgba(255,255,255,0.15);

        backdrop-filter:blur(18px);

        border-radius:30px;

        padding:40px;

        box-shadow:
        0 10px 40px rgba(0,0,0,0.35);

        position:relative;

        overflow:hidden;

        animation:fadeUp 1s ease;
    }

    @keyframes fadeUp{

        from{
            opacity:0;
            transform:translateY(40px);
        }

        to{
            opacity:1;
            transform:translateY(0);
        }
    }

    .glass-card::before{

        content:'';

        position:absolute;

        top:-100px;
        right:-100px;

        width:220px;
        height:220px;

        background:rgba(56,189,248,0.15);

        border-radius:50%;
    }

    .title{

        font-size:36px;

        font-weight:bold;

        margin-bottom:10px;

        background:linear-gradient(
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

    .form-group{
        margin-bottom:25px;
    }

    .form-label{

        display:block;

        margin-bottom:10px;

        font-size:14px;

        color:#e2e8f0;
    }

    .form-input{

        width:100%;

        padding:16px 18px;

        border:none;

        border-radius:18px;

        background:rgba(255,255,255,0.07);

        color:white;

        font-size:15px;

        transition:0.35s ease;

        outline:none;

        backdrop-filter:blur(8px);

        box-sizing:border-box;
    }

    .form-input:focus{

        transform:scale(1.02);

        background:rgba(255,255,255,0.12);

        box-shadow:
        0 0 20px rgba(56,189,248,0.35);
    }

    .form-input::placeholder{
        color:#94a3b8;
    }

    .save-btn{

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

    .save-btn:hover{

        transform:
        translateY(-5px)
        scale(1.02);

        box-shadow:
        0 15px 35px rgba(99,102,241,0.45);
    }

    .cartoon-box{

        position:absolute;

        bottom:-5px;
        right:10px;

        animation:floaty 3s infinite ease-in-out;
    }

    .cartoon-box img{
        width:120px;
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

    .live-badge{

        display:inline-block;

        padding:8px 14px;

        background:rgba(34,197,94,0.15);

        border:1px solid rgba(34,197,94,0.35);

        color:#86efac;

        border-radius:50px;

        font-size:13px;

        margin-bottom:20px;

        animation:pulse 1.6s infinite;
    }

    @keyframes pulse{

        0%{
            transform:scale(1);
        }

        50%{
            transform:scale(1.04);
        }

        100%{
            transform:scale(1);
        }
    }

</style>

<div class="background-blobs">

    <div class="blob blob1"></div>

    <div class="blob blob2"></div>

</div>

<div class="page-wrapper">

    <div class="glass-card">

        <div class="live-badge">
            ● LIVE PRODUCT CREATION
        </div>

        <div class="title">
            📦 Create New Product
        </div>

        <div class="subtitle">
            Add products beautifully with modern animated UI/UX.
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
                    placeholder="Enter buying price..."
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
                    placeholder="Enter selling price..."
                >

            </div>

            <button type="submit" class="save-btn">

                🚀 Save Product

            </button>

        </form>

        <div class="cartoon-box">

            <img
            src="https://cdn-icons-png.flaticon.com/512/3081/3081559.png"
            >

        </div>

    </div>

</div>