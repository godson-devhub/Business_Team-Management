<?php

use yii\helpers\Html;

$this->title = 'Business Team Management System';

$heroImage = Yii::getAlias('@web/images/bg-hero.jpg');
$screen1   = Yii::getAlias('@web/images/screenshot1.png');
$screen2   = Yii::getAlias('@web/images/screenshot2.png');
$screen3   = Yii::getAlias('@web/images/screenshot3.png');
$aboutImage = Yii::getAlias('@web/images/about-system.jpg');
$logo      = Yii::getAlias('@web/images/logo.png');

$loginUrl  = 'http://localhost/business-system/backend/web/login';
$signupUrl = 'http://localhost/business-system/backend/web/signup';

?>

<div class="landing-page">

    <!-- HERO SECTION -->
    <section class="hero" style="background-image:url('<?= $heroImage ?>')">

        <div class="overlay"></div>

        <div class="hero-content">

            <img src="<?= $logo ?>" class="hero-logo" alt="Logo">

            <h1>Business Workflow & Team Management System</h1>

            <p>
                Manage multiple businesses, branches and sellers
                from one powerful platform. Monitor operations,
                sales, inventory, reports and employee performance
                across all branches in real-time.
            </p>

            <div class="hero-buttons">

                <a href="<?= $loginUrl ?>"
                   class="btn btn-primary btn-lg">
                    Login
                </a>

                <a href="<?= $signupUrl ?>"
                   class="btn btn-success btn-lg">
                    Sign Up
                </a>

                <a href="<?= $loginUrl ?>"
                   class="btn btn-outline-light btn-lg">
                    Get Started
                </a>

            </div>

        </div>

    </section>

    <!-- FEATURES -->
    <section class="features">

        <h2>Why Choose Our System?</h2>

        <div class="feature-grid">

            <div class="glass-card">
                <h3>🏢 Multi Business</h3>
                <p>Manage unlimited businesses from one dashboard.</p>
            </div>

            <div class="glass-card">
                <h3>🏬 Branch Management</h3>
                <p>Control all branches from a central system.</p>
            </div>

            <div class="glass-card">
                <h3>👨‍💼 Seller Management</h3>
                <p>Manage sellers, permissions and activities.</p>
            </div>

            <div class="glass-card">
                <h3>📦 Inventory Tracking</h3>
                <p>Track stock movement and availability.</p>
            </div>

            <div class="glass-card">
                <h3>💰 Sales Monitoring</h3>
                <p>Monitor sales performance across branches.</p>
            </div>

            <div class="glass-card">
                <h3>📊 Reports & Analytics</h3>
                <p>Generate detailed reports and business insights.</p>
            </div>

        </div>

    </section>

    <!-- SCREENSHOTS -->
    <section class="screenshots">

        <h2>System Screenshots</h2>

        <div class="gallery">

            <img src="<?= $screen1 ?>" alt="Screenshot 1">
            <img src="<?= $screen2 ?>" alt="Screenshot 2">
            <img src="<?= $screen3 ?>" alt="Screenshot 3">

        </div>

    </section>

    <!-- ABOUT -->
    <section class="about">

        <div class="about-image">
            <img src="<?= $aboutImage ?>" alt="About System">
        </div>

        <div class="about-content">

            <h2>About The System</h2>

            <p>
                The Business Management System helps business owners
                manage multiple businesses and branches from one place.
            </p>

            <p>
                It simplifies branch supervision, seller monitoring,
                inventory management, reporting and decision-making.
            </p>

        </div>

    </section>

    <!-- CONTACT -->
    <section class="contact">

        <h2>Contact Us</h2>

        <div class="contact-grid">

            <div class="contact-card">
                📞 Call & WhatsApp<br>
                0620871857
            </div>

            <div class="contact-card">
                📸 Instagram<br>
                @itc_melody_99
            </div>

            <div class="contact-card">
                🎵 TikTok<br>
                @itc_melody
            </div>

            <div class="contact-card">
                ▶ YouTube<br>
                ITC Melody
            </div>

        </div>

    </section>

</div>

<style>

:root{
    --primary:#3b82f6;
    --secondary:#8b5cf6;
    --success:#10b981;
    --dark:#0f172a;
    --dark2:#111827;
    --light:#f8fafc;
}

html{
    scroll-behavior:smooth;
}

body{
    margin:0;
    font-family:'Segoe UI',sans-serif;
    background:#020617;
    color:white;
    overflow-x:hidden;
}

/* ==========================
BACKGROUND EFFECTS
========================== */

body::before{
    content:'';
    position:fixed;
    width:600px;
    height:600px;
    background:#3b82f620;
    border-radius:50%;
    top:-200px;
    left:-200px;
    filter:blur(120px);
    z-index:-2;
}

body::after{
    content:'';
    position:fixed;
    width:600px;
    height:600px;
    background:#8b5cf620;
    border-radius:50%;
    bottom:-200px;
    right:-200px;
    filter:blur(120px);
    z-index:-2;
}

/* ==========================
SECTION
========================== */

section{
    position:relative;
    overflow:hidden;
}

/* ==========================
HERO
========================== */

.hero{
    min-height:100vh;
    background-size:cover;
    background-position:center;
    display:flex;
    align-items:center;
    justify-content:center;
    text-align:center;
    position:relative;
}

.overlay{
    position:absolute;
    inset:0;
    background:rgba(0,0,0,.72);
    backdrop-filter:blur(4px);
}

.hero-content{
    position:relative;
    z-index:2;
    max-width:1000px;
    padding:40px;
    animation:fadeUp 1s ease;
}

.hero-logo{
    width:120px;
    margin-bottom:25px;
    animation:float 5s infinite ease-in-out;
}

.hero h1{
    font-size:70px;
    font-weight:800;
    line-height:1.1;
    margin-bottom:25px;
    background:linear-gradient(
        90deg,
        #ffffff,
        #3b82f6,
        #8b5cf6
    );
    -webkit-background-clip:text;
    -webkit-text-fill-color:transparent;
}

.hero p{
    font-size:22px;
    color:#cbd5e1;
    line-height:1.9;
    max-width:850px;
    margin:auto;
}

/* ==========================
BUTTONS
========================== */

.hero-buttons{
    margin-top:40px;
    display:flex;
    gap:15px;
    justify-content:center;
    flex-wrap:wrap;
}

.hero-buttons a{
    text-decoration:none;
}

.btn{
    padding:15px 35px;
    border-radius:14px;
    font-weight:700;
    transition:.4s;
    border:none;
}

.btn-primary{
    background:linear-gradient(
        135deg,
        #3b82f6,
        #2563eb
    );
    color:white;
}

.btn-success{
    background:linear-gradient(
        135deg,
        #10b981,
        #059669
    );
    color:white;
}

.btn-outline-light{
    border:1px solid rgba(255,255,255,.3);
    backdrop-filter:blur(15px);
    background:rgba(255,255,255,.08);
    color:white;
}

.btn:hover{
    transform:translateY(-6px);
    box-shadow:0 20px 40px rgba(0,0,0,.3);
}

/* ==========================
SECTIONS
========================== */

.features,
.screenshots,
.about,
.contact{
    padding:120px 8%;
}

.features h2,
.screenshots h2,
.about h2,
.contact h2{
    text-align:center;
    font-size:48px;
    font-weight:800;
    margin-bottom:60px;
}

/* ==========================
GLASSMORPHISM CARDS
========================== */

.feature-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(280px,1fr));
    gap:30px;
}

.glass-card{
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.15);
    backdrop-filter:blur(20px);
    border-radius:24px;
    padding:35px;
    transition:.4s;
    position:relative;
    overflow:hidden;
}

.glass-card::before{
    content:'';
    position:absolute;
    width:150px;
    height:150px;
    background:rgba(255,255,255,.08);
    border-radius:50%;
    top:-50px;
    right:-50px;
}

.glass-card:hover{
    transform:translateY(-12px);
    box-shadow:
    0 20px 40px rgba(0,0,0,.3);
}

.glass-card h3{
    margin-bottom:15px;
    font-size:24px;
}

.glass-card p{
    color:#cbd5e1;
    line-height:1.8;
}

/* ==========================
SCREENSHOTS
========================== */

.gallery{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(350px,1fr));
    gap:30px;
}

.gallery img{
    width:100%;
    border-radius:25px;
    transition:.5s;
    border:1px solid rgba(255,255,255,.1);
}

.gallery img:hover{
    transform:scale(1.05);
    box-shadow:
    0 30px 60px rgba(0,0,0,.4);
}

/* ==========================
ABOUT
========================== */

.about{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:70px;
    align-items:center;
}

.about img{
    width:100%;
    border-radius:25px;
    transition:.5s;
}

.about img:hover{
    transform:scale(1.03);
}

.about-content p{
    color:#cbd5e1;
    line-height:2;
    font-size:18px;
}

/* ==========================
CONTACT
========================== */

.contact-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:30px;
}

.contact-card{
    background:rgba(255,255,255,.08);
    border:1px solid rgba(255,255,255,.1);
    backdrop-filter:blur(20px);
    padding:40px;
    text-align:center;
    border-radius:24px;
    transition:.4s;
    font-size:18px;
}

.contact-card:hover{
    transform:translateY(-10px);
    box-shadow:
    0 20px 40px rgba(0,0,0,.3);
}

/* ==========================
ANIMATIONS
========================== */

@keyframes float{
    0%{transform:translateY(0);}
    50%{transform:translateY(-12px);}
    100%{transform:translateY(0);}
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

/* ==========================
RESPONSIVE
========================== */

@media(max-width:992px){

    .hero h1{
        font-size:50px;
    }

    .about{
        grid-template-columns:1fr;
    }

}

@media(max-width:768px){

    .hero h1{
        font-size:38px;
    }

    .hero p{
        font-size:18px;
    }

    .features h2,
    .screenshots h2,
    .about h2,
    .contact h2{
        font-size:34px;
    }

}

</style>