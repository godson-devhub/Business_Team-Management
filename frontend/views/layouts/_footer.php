<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<footer class="footer-section">

    <div class="container">

        <div class="row g-5">

            <!-- BRAND -->
            <div class="col-lg-4">

                <div class="footer-brand">

                    <!-- LOGO -->
                    <!-- WEKA LOGO HAPA -->
                    <!-- frontend/web/images/logo.png -->

                    <img src="<?= Yii::getAlias('@web/images/logo.png') ?>"
                         alt="Logo"
                         class="footer-logo">

                    <h4 class="footer-title">
                        BusinessFlow ERP
                    </h4>

                    <p class="footer-text">

                        Modern Business Management System for managing
                        businesses, branches, inventory, sales,
                        analytics and reporting from one platform.

                    </p>

                </div>

            </div>

            <!-- QUICK LINKS -->
            <div class="col-lg-2">

                <h5 class="footer-heading">
                    Quick Links
                </h5>

                <ul class="footer-links">

                    <li>
                        <a href="<?= Url::to(['/site/index']) ?>">
                            Home
                        </a>
                    </li>

                    <li>
                        <a href="#features">
                            Features
                        </a>
                    </li>

                    <li>
                        <a href="#screenshots">
                            Screenshots
                        </a>
                    </li>

                    <li>
                        <a href="#pricing">
                            Pricing
                        </a>
                    </li>

                    <li>
                        <a href="#contact">
                            Contact
                        </a>
                    </li>

                </ul>

            </div>

            <!-- SYSTEM -->
            <div class="col-lg-3">

                <h5 class="footer-heading">
                    System Modules
                </h5>

                <ul class="footer-links">

                    <li>Inventory Management</li>

                    <li>Sales & POS</li>

                    <li>Branch Management</li>

                    <li>Analytics Dashboard</li>

                    <li>Business Reports</li>

                    <li>Seller Management</li>

                </ul>

            </div>

            <!-- CONTACT -->
            <div class="col-lg-3">

                <h5 class="footer-heading">
                    Contact Us
                </h5>

                <div class="contact-list">

                    <div class="contact-item">

                        <span>📞</span>

                        <a href="tel:0620871857">
                            0620871857
                        </a>

                    </div>

                    <div class="contact-item">

                        <span>💬</span>

                        <a href="https://wa.me/255620871857"
                           target="_blank">

                            WhatsApp

                        </a>

                    </div>

                    <div class="contact-item">

                        <span>📸</span>

                        <a href="https://instagram.com/itc_melody_99"
                           target="_blank">

                            @itc_melody_99

                        </a>

                    </div>

                    <div class="contact-item">

                        <span>🎵</span>

                        <a href="https://tiktok.com/@itc_melody"
                           target="_blank">

                            @itc_melody

                        </a>

                    </div>

                    <div class="contact-item">

                        <span>▶️</span>

                        <a href="https://youtube.com/@itc_melody"
                           target="_blank">

                            ITC Melody

                        </a>

                    </div>

                </div>

            </div>

        </div>

        <!-- BOTTOM -->

        <div class="footer-bottom">

            <div>

                © <?= date('Y') ?>

                <strong>
                    BusinessFlow ERP
                </strong>

                All Rights Reserved.

            </div>

            <div>

                Developed By

                <strong>
                    ITC Melody
                </strong>

            </div>

        </div>

    </div>

</footer>

<style>

/* ======================================
FOOTER
====================================== */

.footer-section{

    position:relative;

    margin-top:100px;

    padding:80px 0 30px;

    background:
        linear-gradient(
            135deg,
            rgba(15,23,42,.98),
            rgba(30,41,59,.98)
        );

    border-top:
        1px solid rgba(255,255,255,.08);
}

/* LIGHT MODE */

[data-bs-theme="light"] .footer-section{

    background:
        linear-gradient(
            135deg,
            #ffffff,
            #f8fafc
        );

    border-top:
        1px solid #e2e8f0;
}

/* ======================================
LOGO
====================================== */

.footer-logo{

    width:70px;
    height:70px;

    object-fit:contain;

    margin-bottom:15px;
}

.footer-title{

    color:#ffffff;

    font-weight:800;

    margin-bottom:15px;
}

[data-bs-theme="light"] .footer-title{

    color:#0f172a;
}

.footer-text{

    color:#94a3b8;

    line-height:1.8;
}

/* ======================================
HEADINGS
====================================== */

.footer-heading{

    color:white;

    font-weight:700;

    margin-bottom:20px;
}

[data-bs-theme="light"] .footer-heading{

    color:#0f172a;
}

/* ======================================
LINKS
====================================== */

.footer-links{

    list-style:none;

    padding:0;
    margin:0;
}

.footer-links li{

    margin-bottom:12px;

    color:#94a3b8;
}

.footer-links a{

    text-decoration:none;

    color:#94a3b8;

    transition:.3s;
}

.footer-links a:hover{

    color:#3b82f6;

    padding-left:6px;
}

/* ======================================
CONTACT
====================================== */

.contact-list{

    display:flex;
    flex-direction:column;
    gap:14px;
}

.contact-item{

    display:flex;
    align-items:center;
    gap:12px;
}

.contact-item a{

    text-decoration:none;

    color:#94a3b8;

    transition:.3s;
}

.contact-item a:hover{

    color:#3b82f6;
}

/* ======================================
BOTTOM
====================================== */

.footer-bottom{

    margin-top:50px;

    padding-top:25px;

    border-top:
        1px solid rgba(255,255,255,.08);

    display:flex;

    justify-content:space-between;

    flex-wrap:wrap;

    gap:10px;

    color:#94a3b8;
}

[data-bs-theme="light"] .footer-bottom{

    border-top:
        1px solid #e2e8f0;
}

/* ======================================
RESPONSIVE
====================================== */

@media(max-width:768px){

    .footer-bottom{

        flex-direction:column;
        text-align:center;
    }

}

</style>