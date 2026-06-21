<?php

declare(strict_types=1);

/** @var yii\web\View $this */
/** @var string $content */

use common\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\helpers\Html;

?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" data-theme="dark">

<head>

    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?= Html::csrfMetaTags() ?>

    <title><?= Html::encode($this->title) ?></title>

    <?php $this->head() ?>

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <style>

        :root{
            --primary:#3b82f6;
            --primary-hover:#2563eb;
            --success:#22c55e;

            --bg:#07111f;
            --bg-secondary:#0f172a;

            --glass-bg:rgba(255,255,255,.08);
            --glass-border:rgba(255,255,255,.12);

            --text:#ffffff;
            --text-muted:#94a3b8;

            --shadow:0 20px 50px rgba(0,0,0,.25);
        }

        html[data-theme="light"]{

            --bg:#f8fafc;
            --bg-secondary:#ffffff;

            --glass-bg:rgba(255,255,255,.85);
            --glass-border:#e2e8f0;

            --text:#0f172a;
            --text-muted:#64748b;

            --shadow:0 12px 40px rgba(15,23,42,.08);
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{

            font-family:'Inter',sans-serif;

            background:
                linear-gradient(
                    135deg,
                    var(--bg),
                    var(--bg-secondary)
                );

            color:var(--text);

            min-height:100vh;

            transition:.3s ease;

            overflow-x:hidden;
        }

        a{
            text-decoration:none;
        }

        /* ==========================
           NAVBAR
        ========================== */

        .navbar-custom{

            position:fixed;
            top:0;
            left:0;
            right:0;

            z-index:9999;

            backdrop-filter:blur(20px);

            background:var(--glass-bg);

            border-bottom:1px solid var(--glass-border);

            height:80px;
        }

        .navbar-inner{

            max-width:1400px;
            margin:auto;

            height:100%;

            display:flex;
            justify-content:space-between;
            align-items:center;

            padding:0 25px;
        }

        .brand{

            font-size:24px;
            font-weight:800;
            color:var(--text);
        }

        .nav-right{

            display:flex;
            align-items:center;
            gap:12px;
        }

        .btn-login{

            background:transparent;

            border:1px solid var(--glass-border);

            color:var(--text);

            padding:10px 22px;

            border-radius:12px;

            transition:.3s;
        }

        .btn-login:hover{

            transform:translateY(-3px);

            background:rgba(255,255,255,.08);
        }

        .btn-signup{

            background:var(--primary);

            color:white;

            padding:10px 22px;

            border-radius:12px;

            transition:.3s;
        }

        .btn-signup:hover{

            background:var(--primary-hover);

            transform:translateY(-3px);
        }

        .theme-btn{

            border:none;

            background:rgba(255,255,255,.08);

            color:var(--text);

            width:42px;
            height:42px;

            border-radius:50%;

            cursor:pointer;

            transition:.3s;
        }

        .theme-btn:hover{

            transform:rotate(180deg);
        }

        /* ==========================
           MAIN
        ========================== */

        .main-wrapper{

            padding-top:90px;
            min-height:100vh;
        }

        .content-container{

            max-width:1400px;
            margin:auto;
            padding:20px;
        }

        /* ==========================
           BREADCRUMBS
        ========================== */

        .breadcrumb{

            background:var(--glass-bg);
            padding:12px 20px;
            border-radius:12px;
            backdrop-filter:blur(15px);
        }

        /* ==========================
           FOOTER
        ========================== */

        footer{

            margin-top:50px;

            border-top:1px solid var(--glass-border);

            padding:35px 20px;

            text-align:center;

            color:var(--text-muted);

            backdrop-filter:blur(15px);
        }

        .footer-social{

            margin-top:12px;
            line-height:2;
        }

        @media(max-width:768px){

            .navbar-inner{
                flex-direction:column;
                justify-content:center;
                gap:10px;
                padding:10px;
                height:auto;
            }

            .navbar-custom{
                height:auto;
            }

            .main-wrapper{
                padding-top:130px;
            }

            .nav-right{
                flex-wrap:wrap;
                justify-content:center;
            }
        }

    </style>

</head>

<body>

<?php $this->beginBody() ?>

<!-- ==========================
     NAVBAR
========================== -->


<!-- ==========================
     CONTENT
========================== -->

<main class="main-wrapper">

    <div class="content-container">

        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs']
            ]) ?>
        <?php endif; ?>

        <?= Alert::widget() ?>

        <?= $content ?>

    </div>

</main>

<!-- ==========================
     FOOTER
========================== -->


<script>

function toggleTheme(){

    const html=document.documentElement;

    const current=html.getAttribute('data-theme');

    const next=current==='dark'
        ? 'light'
        : 'dark';

    html.setAttribute('data-theme',next);

    localStorage.setItem('theme',next);
}

const savedTheme=localStorage.getItem('theme');

if(savedTheme){

    document.documentElement
        .setAttribute('data-theme',savedTheme);
}

</script>

<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>