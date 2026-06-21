<?php
use yii\helpers\Html;
$this->title = 'BizFlow – Business Management System';
$heroImage   = Yii::getAlias('@web/images/bg-hero.jpg');
$screen1     = Yii::getAlias('@web/images/screenshot1.png');
$screen2     = Yii::getAlias('@web/images/screenshot2.png');
$screen3     = Yii::getAlias('@web/images/screenshot3.png');
$aboutImage  = Yii::getAlias('@web/images/about-system.jpg');
$logo        = Yii::getAlias('@web/images/logo.png');
$loginUrl    = 'http://localhost/business-system/backend/web/login';
$signupUrl   = 'http://localhost/business-system/backend/web/signup';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= Html::encode($this->title) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --blue:#3B82F6;--blue2:#1D4ED8;--violet:#7C3AED;--violet2:#5B21B6;
  --teal:#0D9488;--green:#059669;--amber:#D97706;--rose:#E11D48;
  --muted:#64748B;--muted2:#94A3B8;--muted3:#CBD5E1;
  --border:rgba(148,163,184,.12);--border2:rgba(148,163,184,.22);
  --surface:rgba(255,255,255,.03);--surface2:rgba(255,255,255,.06);
  --page:#060B18;
}
html{scroll-behavior:smooth;font-size:16px}
body{background:var(--page);color:#E2E8F0;font-family:'Inter',sans-serif;line-height:1.6;overflow-x:hidden}

/* ── WEBGL CANVAS ── */
#shader-bg{
  position:fixed;top:0;left:0;width:100%;height:100%;
  z-index:0;pointer-events:none;
}

/* ── PARTICLE CANVAS ── */
#particle-canvas{
  position:fixed;top:0;left:0;width:100%;height:100%;
  z-index:1;pointer-events:none;
}

/* ── ALL CONTENT ABOVE CANVAS ── */
#page-content{position:relative;z-index:2}

/* ── NAV ── */
.nav{
  position:fixed;top:0;left:0;right:0;z-index:1000;
  padding:0 5%;height:70px;
  display:flex;align-items:center;justify-content:space-between;
  background:rgba(6,11,24,.75);
  backdrop-filter:blur(24px) saturate(180%);
  border-bottom:1px solid var(--border);
  transition:background .3s;
}
.nav.scrolled{background:rgba(6,11,24,.92)}
.nav-logo{
  display:flex;align-items:center;gap:10px;
  font-family:'Plus Jakarta Sans',sans-serif;
  font-weight:800;font-size:20px;color:#fff;text-decoration:none;
}
.logo-mark{
  width:38px;height:38px;border-radius:11px;
  background:linear-gradient(135deg,#3B82F6,#7C3AED);
  display:flex;align-items:center;justify-content:center;
  font-size:17px;font-weight:900;color:#fff;
  box-shadow:0 0 24px rgba(124,58,237,.5),0 0 60px rgba(59,130,246,.2);
  animation:logoPulse 3s ease-in-out infinite;
}
@keyframes logoPulse{
  0%,100%{box-shadow:0 0 24px rgba(124,58,237,.5),0 0 60px rgba(59,130,246,.2)}
  50%{box-shadow:0 0 36px rgba(124,58,237,.8),0 0 80px rgba(59,130,246,.35)}
}
.nav-links{display:flex;gap:32px;list-style:none}
.nav-links a{
  color:var(--muted2);text-decoration:none;font-size:14px;font-weight:500;
  transition:.25s;position:relative;padding-bottom:2px;
}
.nav-links a::after{
  content:'';position:absolute;bottom:0;left:0;width:0;height:1.5px;
  background:linear-gradient(90deg,#3B82F6,#7C3AED);
  transition:.3s ease;
}
.nav-links a:hover{color:#fff}
.nav-links a:hover::after{width:100%}
.nav-cta{display:flex;gap:10px}

/* ── BUTTONS ── */
.btn{
  display:inline-flex;align-items:center;justify-content:center;gap:8px;
  padding:10px 22px;border-radius:11px;
  font-weight:600;font-size:14px;font-family:'Inter',sans-serif;
  text-decoration:none;cursor:pointer;transition:all .25s;border:none;
}
.btn-ghost{
  background:rgba(255,255,255,.07);
  border:1px solid var(--border2);color:#fff;
}
.btn-ghost:hover{background:rgba(255,255,255,.13);transform:translateY(-1px)}
.btn-primary{
  background:linear-gradient(135deg,#3B82F6,#7C3AED);
  color:#fff;position:relative;overflow:hidden;
  box-shadow:0 4px 20px rgba(124,58,237,.4),0 0 40px rgba(59,130,246,.15);
}
.btn-primary::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(255,255,255,.15),transparent);
  opacity:0;transition:.25s;
}
.btn-primary:hover{
  transform:translateY(-2px);
  box-shadow:0 8px 32px rgba(124,58,237,.6),0 0 60px rgba(59,130,246,.25);
}
.btn-primary:hover::before{opacity:1}
.btn-lg{padding:15px 36px;font-size:16px;border-radius:13px}
.btn-outline{
  background:transparent;border:1px solid rgba(255,255,255,.2);color:#fff;
}
.btn-outline:hover{background:rgba(255,255,255,.08);transform:translateY(-1px)}

/* ── HERO ── */
.hero{
  min-height:100vh;display:flex;flex-direction:column;
  align-items:center;justify-content:center;text-align:center;
  padding:120px 5% 80px;position:relative;
}

.hero-eyebrow{
  display:inline-flex;align-items:center;gap:8px;
  padding:7px 18px;border-radius:999px;
  background:rgba(124,58,237,.12);
  border:1px solid rgba(124,58,237,.28);
  font-size:13px;font-weight:600;color:#A78BFA;
  margin-bottom:32px;letter-spacing:.04em;
  animation:eyebrowIn 1s ease both .3s;
}
@keyframes eyebrowIn{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}

.live-dot{
  width:7px;height:7px;border-radius:50%;background:#7C3AED;
  box-shadow:0 0 8px rgba(124,58,237,.8);
  animation:livePulse 1.8s ease-in-out infinite;
}
@keyframes livePulse{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.5);opacity:.6}}

.hero h1{
  font-family:'Plus Jakarta Sans',sans-serif;
  font-size:clamp(44px,7vw,90px);font-weight:900;
  line-height:1.04;letter-spacing:-.04em;color:#fff;
  margin-bottom:28px;
  animation:heroTitleIn 1.1s ease both .5s;
}
@keyframes heroTitleIn{from{opacity:0;transform:translateY(28px)}to{opacity:1;transform:translateY(0)}}

.hero h1 .grad{
  background:linear-gradient(135deg,#60A5FA 0%,#A78BFA 40%,#F472B6 80%);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
  background-clip:text;
  animation:gradShift 6s ease-in-out infinite;
}
@keyframes gradShift{
  0%{filter:hue-rotate(0deg)}
  50%{filter:hue-rotate(30deg)}
  100%{filter:hue-rotate(0deg)}
}

.hero-sub{
  font-size:clamp(16px,2vw,21px);color:var(--muted2);
  max-width:660px;line-height:1.8;margin-bottom:48px;
  animation:heroSubIn 1.1s ease both .7s;
}
@keyframes heroSubIn{from{opacity:0;transform:translateY(20px)}to{opacity:1;transform:translateY(0)}}

.hero-btns{
  display:flex;gap:14px;flex-wrap:wrap;justify-content:center;
  margin-bottom:80px;
  animation:heroBtnsIn 1.1s ease both .9s;
}
@keyframes heroBtnsIn{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}

/* FLOATING STATS CARD */
.stats-band{
  display:flex;gap:0;
  background:rgba(255,255,255,.04);
  border:1px solid var(--border2);
  border-radius:20px;
  backdrop-filter:blur(20px);
  overflow:hidden;
  animation:statsIn 1.2s ease both 1.1s;
}
@keyframes statsIn{from{opacity:0;transform:translateY(24px) scale(.97)}to{opacity:1;transform:translateY(0) scale(1)}}

.stat-cell{
  padding:24px 36px;text-align:center;
  border-right:1px solid var(--border);
  position:relative;
}
.stat-cell:last-child{border-right:none}
.stat-cell::before{
  content:'';position:absolute;top:0;left:0;right:0;height:1.5px;
  background:linear-gradient(90deg,transparent,rgba(124,58,237,.5),transparent);
  opacity:0;transition:.4s;
}
.stat-cell:hover::before{opacity:1}
.stat-num{
  font-family:'Plus Jakarta Sans',sans-serif;
  font-size:32px;font-weight:900;color:#fff;
  background:linear-gradient(135deg,#fff,#A78BFA);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
  background-clip:text;
}
.stat-label{font-size:12px;color:var(--muted2);margin-top:2px;font-weight:500}

/* ── SECTION BASE ── */
section{padding:110px 5%;position:relative}
.s-label{
  font-size:11px;font-weight:700;letter-spacing:.12em;
  color:#7C3AED;text-transform:uppercase;margin-bottom:14px;
}
.s-title{
  font-family:'Plus Jakarta Sans',sans-serif;
  font-size:clamp(30px,4vw,54px);font-weight:900;
  line-height:1.1;letter-spacing:-.03em;color:#fff;margin-bottom:18px;
}
.s-sub{font-size:18px;color:var(--muted2);max-width:580px;line-height:1.75}

/* ── BENTO GRID ── */
.bento{
  display:grid;grid-template-columns:repeat(12,1fr);
  gap:14px;margin-top:64px;
}
.bc{
  border-radius:22px;padding:30px;
  background:rgba(255,255,255,.03);
  border:1px solid var(--border);
  position:relative;overflow:hidden;
  transition:border-color .35s,transform .35s,box-shadow .35s;
  opacity:0;transform:translateY(30px);
}
.bc.visible{
  animation:cardReveal .6s ease forwards;
}
@keyframes cardReveal{to{opacity:1;transform:translateY(0)}}

.bc::before{
  content:'';position:absolute;inset:0;border-radius:22px;
  background:linear-gradient(135deg,rgba(255,255,255,.04),transparent 60%);
  pointer-events:none;
}
.bc::after{
  content:'';position:absolute;
  width:200px;height:200px;border-radius:50%;
  background:radial-gradient(circle,var(--glow-color,rgba(124,58,237,.15)),transparent 70%);
  top:-60px;right:-60px;pointer-events:none;
  transition:opacity .4s;
  opacity:.6;
}
.bc:hover{transform:translateY(-5px);box-shadow:0 24px 60px rgba(0,0,0,.35)}
.bc:hover::after{opacity:1}

.s3{grid-column:span 3}
.s4{grid-column:span 4}
.s5{grid-column:span 5}
.s6{grid-column:span 6}
.s7{grid-column:span 7}
.s8{grid-column:span 8}

.bc-blue{border-color:rgba(59,130,246,.2);--glow-color:rgba(59,130,246,.12)}
.bc-violet{border-color:rgba(124,58,237,.2);--glow-color:rgba(124,58,237,.12)}
.bc-teal{border-color:rgba(13,148,136,.2);--glow-color:rgba(13,148,136,.12)}
.bc-green{border-color:rgba(5,150,105,.2);--glow-color:rgba(5,150,105,.12)}
.bc-amber{border-color:rgba(217,119,6,.2);--glow-color:rgba(217,119,6,.12)}
.bc-rose{border-color:rgba(225,29,72,.2);--glow-color:rgba(225,29,72,.12)}

.c-icon{
  width:50px;height:50px;border-radius:15px;
  display:flex;align-items:center;justify-content:center;
  font-size:22px;margin-bottom:20px;
  transition:transform .3s;
}
.bc:hover .c-icon{transform:scale(1.1) rotate(-5deg)}
.ci-blue{background:rgba(59,130,246,.15)}
.ci-violet{background:rgba(124,58,237,.15)}
.ci-teal{background:rgba(13,148,136,.15)}
.ci-green{background:rgba(5,150,105,.15)}
.ci-amber{background:rgba(217,119,6,.15)}
.ci-rose{background:rgba(225,29,72,.15)}

.bc h3{
  font-family:'Plus Jakarta Sans',sans-serif;
  font-size:19px;font-weight:700;color:#fff;margin-bottom:10px;
}
.bc p{font-size:14px;color:var(--muted2);line-height:1.7}

.big-num{
  font-family:'Plus Jakarta Sans',sans-serif;
  font-size:60px;font-weight:900;line-height:1;
  margin-top:20px;
}
.gn-blue{background:linear-gradient(135deg,#60A5FA,#3B82F6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.gn-violet{background:linear-gradient(135deg,#C4B5FD,#7C3AED);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.gn-teal{background:linear-gradient(135deg,#5EEAD4,#0D9488);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}

/* ANIMATED MINI CHART */
.mini-bars{display:flex;align-items:flex-end;gap:5px;height:52px;margin-top:18px}
.bar-item{flex:1;border-radius:5px 5px 0 0;background:rgba(59,130,246,.2);transition:.4s ease;min-width:8px}
.bar-item.lit{background:linear-gradient(to top,#3B82F6,#7C3AED)}
.bc:hover .bar-item{transform:scaleY(1.15);transform-origin:bottom}

/* ROLE BADGES */
.role-pills{display:flex;gap:7px;flex-wrap:wrap;margin-top:18px}
.pill{
  padding:5px 12px;border-radius:7px;font-size:12px;font-weight:600;
  border:1px solid transparent;transition:.3s;
}
.pill:hover{transform:translateY(-2px)}
.p-blue{background:rgba(59,130,246,.12);border-color:rgba(59,130,246,.25);color:#93C5FD}
.p-violet{background:rgba(124,58,237,.12);border-color:rgba(124,58,237,.25);color:#C4B5FD}
.p-teal{background:rgba(13,148,136,.12);border-color:rgba(13,148,136,.25);color:#5EEAD4}
.p-amber{background:rgba(217,119,6,.12);border-color:rgba(217,119,6,.25);color:#FCD34D}
.p-rose{background:rgba(225,29,72,.12);border-color:rgba(225,29,72,.25);color:#FDA4AF}

/* ── STEPS ── */
.steps-grid{
  display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));
  gap:20px;margin-top:64px;
}
.step-card{
  background:rgba(255,255,255,.03);
  border:1px solid var(--border);
  border-radius:22px;padding:34px;
  position:relative;
  opacity:0;transform:translateY(24px);
  transition:border-color .3s,transform .35s,box-shadow .35s;
}
.step-card.visible{animation:cardReveal .6s ease forwards}
.step-card:hover{
  transform:translateY(-4px);
  border-color:rgba(124,58,237,.3);
  box-shadow:0 20px 50px rgba(0,0,0,.3);
}
.step-num{
  width:44px;height:44px;border-radius:13px;
  background:linear-gradient(135deg,#3B82F6,#7C3AED);
  display:flex;align-items:center;justify-content:center;
  font-family:'Plus Jakarta Sans',sans-serif;font-weight:900;font-size:17px;color:#fff;
  margin-bottom:22px;
  box-shadow:0 6px 20px rgba(124,58,237,.35);
  transition:transform .3s;
}
.step-card:hover .step-num{transform:rotate(-6deg) scale(1.08)}
.step-card h3{
  font-family:'Plus Jakarta Sans',sans-serif;
  font-weight:700;font-size:17px;color:#fff;margin-bottom:10px;
}
.step-card p{font-size:14px;color:var(--muted2);line-height:1.7}

/* ── SCREENSHOTS ── */
.screens-grid{
  display:grid;grid-template-columns:repeat(3,1fr);
  gap:16px;margin-top:64px;
}
.screen-wrap{
  border-radius:18px;overflow:hidden;
  border:1px solid var(--border);
  position:relative;background:#0F1629;
  aspect-ratio:16/10;
  transition:transform .4s,box-shadow .4s,border-color .4s;
  opacity:0;transform:scale(.96);
}
.screen-wrap.visible{animation:scaleIn .6s ease forwards}
@keyframes scaleIn{to{opacity:1;transform:scale(1)}}
.screen-wrap:hover{
  transform:scale(1.03) translateY(-4px);
  box-shadow:0 30px 70px rgba(0,0,0,.45);
  border-color:rgba(124,58,237,.3);
}
.screen-wrap img{width:100%;height:100%;object-fit:cover;transition:.5s}
.screen-lbl{
  position:absolute;bottom:12px;left:50%;transform:translateX(-50%);
  background:rgba(6,11,24,.88);backdrop-filter:blur(10px);
  border:1px solid var(--border2);border-radius:999px;
  padding:5px 16px;font-size:12px;font-weight:600;color:var(--muted2);white-space:nowrap;
}
/* glow overlay on hover */
.screen-wrap::after{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(124,58,237,.08),rgba(59,130,246,.06));
  opacity:0;transition:.4s;pointer-events:none;
}
.screen-wrap:hover::after{opacity:1}

/* ── ABOUT ── */
.about-layout{
  display:grid;grid-template-columns:1fr 1fr;
  gap:80px;align-items:center;margin-top:64px;
}
.about-img-box{
  position:relative;border-radius:26px;overflow:hidden;
  border:1px solid var(--border);
}
.about-img-box img{width:100%;display:block;transition:.5s}
.about-img-box:hover img{transform:scale(1.03)}
.about-img-box::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(135deg,rgba(124,58,237,.12),rgba(59,130,246,.08));
  opacity:0;transition:.4s;z-index:1;pointer-events:none;
}
.about-img-box:hover::before{opacity:1}
.live-badge{
  position:absolute;bottom:20px;left:20px;z-index:2;
  background:rgba(6,11,24,.88);backdrop-filter:blur(14px);
  border:1px solid rgba(16,185,129,.25);border-radius:14px;
  padding:12px 16px;display:flex;align-items:center;gap:10px;
}
.live-dot2{
  width:8px;height:8px;border-radius:50%;background:#10B981;
  box-shadow:0 0 12px #10B981;animation:livePulse 2s infinite;
}
.live-text{font-size:13px;font-weight:600;color:#fff}
.about-feats{display:flex;flex-direction:column;gap:22px;margin-top:36px}
.afeat{display:flex;gap:14px}
.afeat-icon{
  width:38px;height:38px;border-radius:11px;
  background:rgba(124,58,237,.13);border:1px solid rgba(124,58,237,.2);
  display:flex;align-items:center;justify-content:center;
  font-size:16px;flex-shrink:0;transition:.3s;
}
.afeat:hover .afeat-icon{transform:scale(1.1);background:rgba(124,58,237,.22)}
.afeat h4{
  font-family:'Plus Jakarta Sans',sans-serif;
  font-weight:700;font-size:15px;color:#fff;margin-bottom:3px;
}
.afeat p{font-size:13px;color:var(--muted2)}

/* ── CTA BANNER ── */
.cta-wrap{padding:60px 5%}
.cta-box{
  border-radius:30px;padding:80px 60px;text-align:center;
  position:relative;overflow:hidden;
  background:linear-gradient(135deg,rgba(124,58,237,.12) 0%,rgba(59,130,246,.08) 50%,rgba(13,148,136,.06) 100%);
  border:1px solid rgba(124,58,237,.2);
}
.cta-box::before{
  content:'';position:absolute;
  width:600px;height:600px;border-radius:50%;
  background:radial-gradient(circle,rgba(124,58,237,.18),transparent 70%);
  top:-300px;left:50%;transform:translateX(-50%);
  pointer-events:none;
  animation:ctaOrb 8s ease-in-out infinite;
}
@keyframes ctaOrb{
  0%,100%{transform:translateX(-50%) scale(1)}
  50%{transform:translateX(-50%) scale(1.15)}
}
.cta-box h2{
  font-family:'Plus Jakarta Sans',sans-serif;
  font-size:clamp(28px,4.5vw,52px);font-weight:900;color:#fff;
  margin-bottom:18px;position:relative;
}
.cta-box p{font-size:19px;color:var(--muted2);margin-bottom:40px;position:relative}
.cta-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap;position:relative}

/* ── CONTACT ── */
.contact-cards{
  display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));
  gap:16px;margin-top:64px;
}
.cc{
  background:rgba(255,255,255,.03);
  border:1px solid var(--border);
  border-radius:22px;padding:30px 24px;
  text-align:center;text-decoration:none;display:block;
  transition:all .35s;
  opacity:0;transform:translateY(20px);
}
.cc.visible{animation:cardReveal .6s ease forwards}
.cc:hover{
  transform:translateY(-6px);
  background:rgba(255,255,255,.06);
  border-color:rgba(124,58,237,.3);
  box-shadow:0 20px 50px rgba(0,0,0,.3);
}
.cc-icon{
  width:56px;height:56px;border-radius:18px;
  margin:0 auto 18px;display:flex;align-items:center;justify-content:center;
  font-size:26px;transition:.35s;
}
.cc:hover .cc-icon{transform:scale(1.12) rotate(-5deg)}
.cc h4{
  font-family:'Plus Jakarta Sans',sans-serif;
  font-weight:700;font-size:16px;color:#fff;margin-bottom:6px;
}
.cc p{font-size:13px;color:var(--muted2)}
.cc-link{display:inline-block;margin-top:14px;font-size:13px;font-weight:600;color:#60A5FA;transition:.25s}
.cc:hover .cc-link{color:#A78BFA}

/* ── FOOTER ── */
.footer{
  padding:36px 5%;border-top:1px solid var(--border);
  display:flex;align-items:center;justify-content:space-between;
  flex-wrap:wrap;gap:16px;position:relative;
}
.footer p{font-size:13px;color:var(--muted)}
.footer a{color:var(--muted);font-size:13px;text-decoration:none;transition:.2s}
.footer a:hover{color:#fff}

/* ── SCROLL REVEAL BASE ── */
.reveal{opacity:0;transform:translateY(32px);transition:opacity .7s ease,transform .7s ease}
.reveal.in-view{opacity:1;transform:translateY(0)}

/* ── RESPONSIVE ── */
@media(max-width:1100px){
  .s3,.s4,.s5{grid-column:span 6}
  .s7,.s8{grid-column:span 12}
  .about-layout{grid-template-columns:1fr;gap:40px}
  .screens-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:768px){
  .nav .nav-links{display:none}
  .bento{grid-template-columns:1fr 1fr}
  .s3,.s4,.s5,.s6,.s7,.s8{grid-column:span 2}
  .screens-grid{grid-template-columns:1fr}
  .stats-band{flex-wrap:wrap}
  .stat-cell{border-right:none;border-bottom:1px solid var(--border);width:50%}
  .cta-box{padding:48px 24px}
}
@media(max-width:480px){
  .bento{grid-template-columns:1fr}
  .s3,.s4,.s5,.s6,.s7,.s8{grid-column:span 1}
  .stat-cell{width:100%}
}
@media(prefers-reduced-motion:reduce){
  *{animation:none!important;transition:none!important}
}
</style>
</head>
<body>

<!-- WEBGL SHADER BACKGROUND -->
<canvas id="shader-bg"></canvas>

<!-- PARTICLE SYSTEM -->
<canvas id="particle-canvas"></canvas>

<div id="page-content">

<!-- NAV -->
<nav class="nav" id="nav">
  <a href="#" class="nav-logo">
    <div class="logo-mark">B</div>
    BizFlow
  </a>
  <ul class="nav-links">
    <li><a href="#features">Features</a></li>
    <li><a href="#how">How it works</a></li>
    <li><a href="#screenshots">Screenshots</a></li>
    <li><a href="#about">About</a></li>
    <li><a href="#contact">Contact</a></li>
  </ul>
  <div class="nav-cta">
    <a href="<?= $loginUrl ?>" class="btn btn-ghost">Sign in</a>
    <a href="<?= $signupUrl ?>" class="btn btn-primary">Get started →</a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-eyebrow">
    <span class="live-dot"></span>
    Built for multi-branch business owners in Tanzania
  </div>
  <h1>
    One platform.<br>
    <span class="grad">Every branch.</span><br>
    Total control.
  </h1>
  <p class="hero-sub">
    Manage multiple businesses, branches, and seller teams from a single powerful dashboard. Real-time visibility across all operations — sales, inventory, and team performance.
  </p>
  <div class="hero-btns">
    <a href="<?= $signupUrl ?>" class="btn btn-primary btn-lg">Start for free →</a>
    <a href="<?= $loginUrl ?>" class="btn btn-outline btn-lg">Sign in</a>
  </div>

  <div class="stats-band">
    <div class="stat-cell">
      <div class="stat-num">∞</div>
      <div class="stat-label">Businesses</div>
    </div>
    <div class="stat-cell">
      <div class="stat-num">∞</div>
      <div class="stat-label">Branches</div>
    </div>
    <div class="stat-cell">
      <div class="stat-num">Live</div>
      <div class="stat-label">Sales data</div>
    </div>
    <div class="stat-cell">
      <div class="stat-num">100%</div>
      <div class="stat-label">Web-based</div>
    </div>
  </div>
</section>

<!-- FEATURES -->
<section id="features">
  <div class="reveal">
    <div class="s-label">Features</div>
    <h2 class="s-title">Everything to run<br>your business</h2>
    <p class="s-sub">From a single seller to a nationwide branch network — BizFlow scales with you.</p>
  </div>

  <div class="bento">
    <div class="bc s7 bc-blue" style="animation-delay:.05s">
      <div class="c-icon ci-blue">🏢</div>
      <h3>Multi-Business Management</h3>
      <p>Own multiple brands or companies? Manage them all from one login. Switch contexts instantly, compare performance side-by-side.</p>
      <div class="big-num gn-blue">∞</div>
      <p style="margin-top:6px;font-size:13px">Businesses per account</p>
    </div>

    <div class="bc s5 bc-violet" style="animation-delay:.1s">
      <div class="c-icon ci-violet">🏬</div>
      <h3>Branch Control</h3>
      <p>Add, configure, and monitor every branch. Track each independently or as a group.</p>
      <div class="mini-bars">
        <div class="bar-item" style="height:42%"></div>
        <div class="bar-item" style="height:62%"></div>
        <div class="bar-item lit" style="height:85%"></div>
        <div class="bar-item" style="height:55%"></div>
        <div class="bar-item lit" style="height:98%"></div>
        <div class="bar-item" style="height:72%"></div>
        <div class="bar-item lit" style="height:100%"></div>
      </div>
    </div>

    <div class="bc s4 bc-teal" style="animation-delay:.15s">
      <div class="c-icon ci-teal">👨‍💼</div>
      <h3>Seller Management</h3>
      <p>Assign sellers to branches, define roles, and monitor activity in real time.</p>
    </div>

    <div class="bc s4 bc-green" style="animation-delay:.2s">
      <div class="c-icon ci-green">📦</div>
      <h3>Inventory Tracking</h3>
      <p>Live stock levels, low-stock alerts, and movement history across every branch.</p>
    </div>

    <div class="bc s4 bc-amber" style="animation-delay:.25s">
      <div class="c-icon ci-amber">💰</div>
      <h3>Sales Monitoring</h3>
      <p>Daily, weekly, and monthly sales figures. Spot your top-performing branches instantly.</p>
    </div>

    <div class="bc s5 bc-rose" style="animation-delay:.3s">
      <div class="c-icon ci-rose">📊</div>
      <h3>Reports & Analytics</h3>
      <p>Detailed business intelligence: revenue trends, team KPIs, and export-ready reports.</p>
      <div class="big-num gn-violet" style="font-size:44px;margin-top:20px">360°</div>
      <p style="margin-top:6px;font-size:13px">Business visibility</p>
    </div>

    <div class="bc s7 bc-violet" style="animation-delay:.35s">
      <div class="c-icon ci-violet">🔐</div>
      <h3>Role-Based Permissions</h3>
      <p>Fine-grained access control — each seller, manager, or admin sees exactly what they need.</p>
      <div class="role-pills">
        <span class="pill p-blue">Owner</span>
        <span class="pill p-violet">Manager</span>
        <span class="pill p-teal">Seller</span>
        <span class="pill p-amber">Auditor</span>
        <span class="pill p-rose">Viewer</span>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section id="how">
  <div class="reveal">
    <div class="s-label">How it works</div>
    <h2 class="s-title">Up and running<br>in minutes</h2>
    <p class="s-sub">No complex setup. Create your account, add your businesses, then invite your team.</p>
  </div>

  <div class="steps-grid">
    <div class="step-card" style="animation-delay:.05s">
      <div class="step-num">01</div>
      <h3>Create your account</h3>
      <p>Sign up in seconds. One login, no matter how many businesses you own.</p>
    </div>
    <div class="step-card" style="animation-delay:.12s">
      <div class="step-num">02</div>
      <h3>Add your businesses</h3>
      <p>Register each business you operate. Customize names, locations, and settings.</p>
    </div>
    <div class="step-card" style="animation-delay:.19s">
      <div class="step-num">03</div>
      <h3>Set up branches</h3>
      <p>Add branches under each business. Assign managers and configure inventory per branch.</p>
    </div>
    <div class="step-card" style="animation-delay:.26s">
      <div class="step-num">04</div>
      <h3>Monitor everything</h3>
      <p>Your dashboard shows live sales, stock levels, and team performance — always up to date.</p>
    </div>
  </div>
</section>

<!-- SCREENSHOTS -->
<section id="screenshots">
  <div class="reveal">
    <div class="s-label">Screenshots</div>
    <h2 class="s-title">See it in action</h2>
    <p class="s-sub">A clean modern interface built for daily use, not just demos.</p>
  </div>
  <div class="screens-grid">
    <div class="screen-wrap" style="animation-delay:.05s">
      <img src="<?= $screen1 ?>" alt="Dashboard overview" loading="lazy">
      <div class="screen-lbl">Dashboard</div>
    </div>
    <div class="screen-wrap" style="animation-delay:.12s">
      <img src="<?= $screen2 ?>" alt="Branch management" loading="lazy">
      <div class="screen-lbl">Branch view</div>
    </div>
    <div class="screen-wrap" style="animation-delay:.19s">
      <img src="<?= $screen3 ?>" alt="Sales reports" loading="lazy">
      <div class="screen-lbl">Reports</div>
    </div>
  </div>
</section>

<!-- ABOUT -->
<section id="about">
  <div class="about-layout">
    <div class="about-img-box reveal">
      <img src="<?= $aboutImage ?>" alt="About BizFlow" loading="lazy">
      <div class="live-badge">
        <div class="live-dot2"></div>
        <div class="live-text">System live & operational</div>
      </div>
    </div>
    <div class="reveal">
      <div class="s-label">About</div>
      <h2 class="s-title" style="font-size:clamp(26px,3.5vw,44px)">
        Built for the modern Tanzanian business owner
      </h2>
      <p class="s-sub" style="margin-bottom:0">
        BizFlow was designed for owners who run multiple businesses across multiple locations — giving you the clarity to make faster, smarter decisions every day.
      </p>
      <div class="about-feats">
        <div class="afeat">
          <div class="afeat-icon">✅</div>
          <div>
            <h4>No more branch confusion</h4>
            <p>Every branch reports to you, not to chaos. One view, all locations.</p>
          </div>
        </div>
        <div class="afeat">
          <div class="afeat-icon">📱</div>
          <div>
            <h4>Access anywhere, any device</h4>
            <p>Fully web-based. Works on phone, tablet, or desktop — no app install needed.</p>
          </div>
        </div>
        <div class="afeat">
          <div class="afeat-icon">🔒</div>
          <div>
            <h4>Your data stays yours</h4>
            <p>Secure, role-based access. Sellers see only what they need to see.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA BANNER -->
<div class="cta-wrap">
  <div class="cta-box reveal">
    <h2>Ready to take control<br>of your business?</h2>
    <p>Join business owners across Tanzania using BizFlow to manage their operations.</p>
    <div class="cta-btns">
      <a href="<?= $signupUrl ?>" class="btn btn-primary btn-lg">Create free account →</a>
      <a href="<?= $loginUrl ?>" class="btn btn-ghost btn-lg">Sign in</a>
    </div>
  </div>
</div>

<!-- CONTACT -->
<section id="contact" style="padding-top:60px">
  <div class="reveal">
    <div class="s-label">Contact</div>
    <h2 class="s-title">Get in touch</h2>
    <p class="s-sub">Have questions? Reach out on any platform — we respond fast.</p>
  </div>
  <div class="contact-cards">
    <a href="https://wa.me/255620871857?text=Habari%20nimeona%20service%20yako" target="_blank" class="cc" style="animation-delay:.05s">
      <div class="cc-icon" style="background:rgba(37,211,102,.12);border:1px solid rgba(37,211,102,.2)">📞</div>
      <h4>WhatsApp</h4>
      <p>Quick questions & live support</p>
      <span class="cc-link">Chat now →</span>
    </a>
    <a href="https://www.instagram.com/itc_melody_99/" target="_blank" class="cc" style="animation-delay:.1s">
      <div class="cc-icon" style="background:rgba(225,48,108,.12);border:1px solid rgba(225,48,108,.2)">📸</div>
      <h4>Instagram</h4>
      <p>Follow for updates & demos</p>
      <span class="cc-link">@itc_melody_99 →</span>
    </a>
    <a href="https://www.tiktok.com/@melodiz009" target="_blank" class="cc" style="animation-delay:.15s">
      <div class="cc-icon" style="background:rgba(255,0,80,.1);border:1px solid rgba(255,0,80,.2)">🎵</div>
      <h4>TikTok</h4>
      <p>Short tutorials & previews</p>
      <span class="cc-link">@melodiz009 →</span>
    </a>
    <a href="https://www.youtube.com/@melody-k1z-c2l" target="_blank" class="cc" style="animation-delay:.2s">
      <div class="cc-icon" style="background:rgba(255,0,0,.1);border:1px solid rgba(255,0,0,.2)">▶</div>
      <h4>YouTube</h4>
      <p>Full walkthrough videos</p>
      <span class="cc-link">Watch →</span>
    </a>
  </div>
</section>

<!-- FOOTER -->
<footer class="footer">
  <div style="display:flex;align-items:center;gap:10px">
    <div class="logo-mark" style="width:30px;height:30px;font-size:13px;border-radius:9px">B</div>
    <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;color:#fff">BizFlow</span>
  </div>
  <p>© 2025 BizFlow · Business Workflow & Team Management System</p>
  <div style="display:flex;gap:24px">
    <a href="<?= $loginUrl ?>">Sign in</a>
    <a href="<?= $signupUrl ?>">Sign up</a>
  </div>
</footer>

</div><!-- end #page-content -->

<script>
(function(){

/* ═══════════════════════════════════════════
   1. WEBGL SHADER BACKGROUND
═══════════════════════════════════════════ */
const canvas = document.getElementById('shader-bg');
const gl = canvas.getContext('webgl') || canvas.getContext('experimental-webgl');

if(gl){
  const resize = () => {
    canvas.width  = window.innerWidth;
    canvas.height = window.innerHeight;
    gl.viewport(0, 0, canvas.width, canvas.height);
  };
  resize();
  window.addEventListener('resize', resize);

  const vsSrc = `
    attribute vec2 a_pos;
    void main(){gl_Position=vec4(a_pos,0,1);}
  `;

  const fsSrc = `
    precision mediump float;
    uniform vec2  u_res;
    uniform float u_time;
    uniform vec2  u_mouse;

    vec3 palette(float t){
      vec3 a=vec3(0.06,0.06,0.12);
      vec3 b=vec3(0.05,0.04,0.10);
      vec3 c=vec3(0.20,0.15,0.40);
      vec3 d=vec3(0.00,0.25,0.60);
      return a+b*cos(6.2832*(c*t+d));
    }

    float hash(vec2 p){
      p=fract(p*vec2(234.34,435.345));
      p+=dot(p,p+34.23);
      return fract(p.x*p.y);
    }

    float noise(vec2 p){
      vec2 i=floor(p),f=fract(p);
      f=f*f*(3.-2.*f);
      float a=hash(i),b=hash(i+vec2(1,0));
      float c2=hash(i+vec2(0,1)),d=hash(i+vec2(1,1));
      return mix(mix(a,b,f.x),mix(c2,d,f.x),f.y);
    }

    float fbm(vec2 p){
      float v=0.;float a=0.5;
      for(int i=0;i<5;i++){v+=a*noise(p);p=p*2.1+vec2(1.7,9.2);a*=0.5;}
      return v;
    }

    void main(){
      vec2 uv=(gl_FragCoord.xy/u_res)*2.-1.;
      uv.x*=u_res.x/u_res.y;

      vec2 mouse=(u_mouse/u_res)*2.-1.;
      mouse.x*=u_res.x/u_res.y;

      float t=u_time*0.18;
      vec2 q=vec2(fbm(uv+vec2(0.0,0.0)),fbm(uv+vec2(5.2,1.3)));
      vec2 r=vec2(fbm(uv+4.*q+vec2(1.7,9.2)+t*0.15),
                  fbm(uv+4.*q+vec2(8.3,2.8)+t*0.12));

      float f=fbm(uv+4.*r);

      /* mouse influence */
      float md=length(uv-mouse);
      f+=0.15*exp(-md*2.5)*sin(u_time*1.5);

      /* rotating energy rings */
      float ring=sin(length(uv)*8.-u_time*1.2)*0.5+0.5;
      f=mix(f,ring,0.06);

      /* spiral */
      float angle=atan(uv.y,uv.x)+u_time*0.25;
      float spiral=sin(angle*3.+length(uv)*5.)*0.5+0.5;
      f=mix(f,spiral,0.04);

      f=clamp(f,0.,1.);
      vec3 col=palette(f+t*0.25);

      /* subtle vignette */
      float vig=1.-smoothstep(0.5,1.5,length(uv));
      col*=vig*0.85+0.15;

      /* brightness boost at center */
      float center=exp(-length(uv)*1.8)*0.18;
      col+=vec3(0.05,0.04,0.15)*center;

      gl_FragColor=vec4(col,1.0);
    }
  `;

  const mkShader = (type, src) => {
    const s = gl.createShader(type);
    gl.shaderSource(s, src);
    gl.compileShader(s);
    return s;
  };

  const prog = gl.createProgram();
  gl.attachShader(prog, mkShader(gl.VERTEX_SHADER, vsSrc));
  gl.attachShader(prog, mkShader(gl.FRAGMENT_SHADER, fsSrc));
  gl.linkProgram(prog);
  gl.useProgram(prog);

  const buf = gl.createBuffer();
  gl.bindBuffer(gl.ARRAY_BUFFER, buf);
  gl.bufferData(gl.ARRAY_BUFFER, new Float32Array([-1,-1,3,-1,-1,3]), gl.STATIC_DRAW);

  const aPos = gl.getAttribLocation(prog, 'a_pos');
  gl.enableVertexAttribArray(aPos);
  gl.vertexAttribPointer(aPos, 2, gl.FLOAT, false, 0, 0);

  const uRes   = gl.getUniformLocation(prog, 'u_res');
  const uTime  = gl.getUniformLocation(prog, 'u_time');
  const uMouse = gl.getUniformLocation(prog, 'u_mouse');

  let mx = window.innerWidth/2, my = window.innerHeight/2;
  let tmx = mx, tmy = my;
  document.addEventListener('mousemove', e => { tmx=e.clientX; tmy=e.clientY; });

  const start = performance.now();
  const tick = (now) => {
    const t = (now - start) * 0.001;
    mx += (tmx-mx)*0.04;
    my += (tmy-my)*0.04;
    gl.uniform2f(uRes, canvas.width, canvas.height);
    gl.uniform1f(uTime, t);
    gl.uniform2f(uMouse, mx, canvas.height - my);
    gl.drawArrays(gl.TRIANGLES, 0, 3);
    requestAnimationFrame(tick);
  };
  requestAnimationFrame(tick);
}

/* ═══════════════════════════════════════════
   2. PARTICLE SYSTEM
═══════════════════════════════════════════ */
const pc = document.getElementById('particle-canvas');
const ctx = pc.getContext('2d');
pc.width  = window.innerWidth;
pc.height = window.innerHeight;
window.addEventListener('resize', () => {
  pc.width  = window.innerWidth;
  pc.height = window.innerHeight;
});

const PARTICLES = 90;
const particles = Array.from({length:PARTICLES}, () => ({
  x: Math.random() * window.innerWidth,
  y: Math.random() * window.innerHeight,
  vx: (Math.random()-.5)*.35,
  vy: (Math.random()-.5)*.35,
  r: Math.random()*1.8+.4,
  alpha: Math.random()*.55+.1,
  hue: Math.random()*60+220,
  pulse: Math.random()*Math.PI*2,
}));

let pmx=0, pmy=0;
document.addEventListener('mousemove', e => { pmx=e.clientX; pmy=e.clientY; });

const drawParticles = () => {
  ctx.clearRect(0, 0, pc.width, pc.height);
  const t = performance.now() * 0.001;

  particles.forEach(p => {
    p.pulse += .015;
    p.x += p.vx + Math.sin(p.pulse)*.15;
    p.y += p.vy + Math.cos(p.pulse*.8)*.12;

    if(p.x<-10) p.x=pc.width+10;
    if(p.x>pc.width+10) p.x=-10;
    if(p.y<-10) p.y=pc.height+10;
    if(p.y>pc.height+10) p.y=-10;

    const dx=pmx-p.x, dy=pmy-p.y;
    const dist=Math.sqrt(dx*dx+dy*dy);
    const glow = dist<200 ? (1-dist/200)*1.5 : 0;
    const alpha = p.alpha*(0.7+0.3*Math.sin(p.pulse))+glow*0.4;

    ctx.beginPath();
    ctx.arc(p.x, p.y, p.r*(1+glow*.5), 0, Math.PI*2);
    ctx.fillStyle = `hsla(${p.hue+glow*30},80%,75%,${Math.min(alpha,1)})`;
    ctx.fill();
  });

  /* connection lines */
  for(let i=0;i<particles.length;i++){
    for(let j=i+1;j<particles.length;j++){
      const a=particles[i], b=particles[j];
      const dx=a.x-b.x, dy=a.y-b.y;
      const d=Math.sqrt(dx*dx+dy*dy);
      if(d<130){
        ctx.beginPath();
        ctx.moveTo(a.x,a.y);
        ctx.lineTo(b.x,b.y);
        const alpha=(1-d/130)*0.12;
        ctx.strokeStyle=`rgba(139,92,246,${alpha})`;
        ctx.lineWidth=.6;
        ctx.stroke();
      }
    }
  }
  requestAnimationFrame(drawParticles);
};
drawParticles();

/* ═══════════════════════════════════════════
   3. SCROLL REVEAL — .reveal and .bc / .step-card / .screen-wrap / .cc
═══════════════════════════════════════════ */
const io = new IntersectionObserver((entries) => {
  entries.forEach((entry, i) => {
    if(entry.isIntersecting){
      const el = entry.target;
      const delay = parseFloat(el.style.animationDelay || '0') * 1000;
      setTimeout(() => el.classList.add('visible', 'in-view'), delay);
      io.unobserve(el);
    }
  });
}, {threshold:.12});

document.querySelectorAll('.bc,.step-card,.screen-wrap,.cc,.reveal').forEach(el => io.observe(el));

/* ═══════════════════════════════════════════
   4. NAV SCROLL STATE
═══════════════════════════════════════════ */
const nav = document.getElementById('nav');
window.addEventListener('scroll', () => {
  nav.classList.toggle('scrolled', window.scrollY > 60);
}, {passive:true});

/* ═══════════════════════════════════════════
   5. CURSOR MAGNETIC EFFECT ON BUTTONS
═══════════════════════════════════════════ */
document.querySelectorAll('.btn-primary,.btn-ghost,.btn-outline').forEach(btn => {
  btn.addEventListener('mousemove', e => {
    const r = btn.getBoundingClientRect();
    const x = e.clientX - r.left - r.width/2;
    const y = e.clientY - r.top - r.height/2;
    btn.style.transform = `translate(${x*.12}px,${y*.12}px) translateY(-2px)`;
  });
  btn.addEventListener('mouseleave', () => {
    btn.style.transform = '';
  });
});

/* ═══════════════════════════════════════════
   6. BENTO CARD MOUSE-TRACKING GLOW
═══════════════════════════════════════════ */
document.querySelectorAll('.bc').forEach(card => {
  card.addEventListener('mousemove', e => {
    const r = card.getBoundingClientRect();
    const x = e.clientX - r.left;
    const y = e.clientY - r.top;
    card.style.setProperty('--mx', x+'px');
    card.style.setProperty('--my', y+'px');
    card.style.background = `radial-gradient(circle at ${x}px ${y}px, rgba(124,58,237,.09), rgba(255,255,255,.03) 50%)`;
  });
  card.addEventListener('mouseleave', () => {
    card.style.background = '';
  });
});

/* ═══════════════════════════════════════════
   7. TYPING COUNTER ANIMATION FOR STATS
═══════════════════════════════════════════ */
const animateNum = (el, target, suffix='') => {
  let start=0, dur=1800, startTime=null;
  const step = (ts) => {
    if(!startTime) startTime=ts;
    const p=Math.min((ts-startTime)/dur,1);
    const ease=1-Math.pow(1-p,3);
    el.textContent = Math.round(start+(target-start)*ease)+suffix;
    if(p<1) requestAnimationFrame(step);
  };
  requestAnimationFrame(step);
};

const statsObs = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if(e.isIntersecting){
      statsObs.unobserve(e.target);
    }
  });
},{threshold:.5});

document.querySelectorAll('.stat-cell').forEach(c => statsObs.observe(c));

})();
</script>
</body>
</html>