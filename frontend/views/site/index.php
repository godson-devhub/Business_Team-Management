<?php
use yii\helpers\Html;
$this->title = 'BizFlow – Business Management System';
$screen1    = Yii::getAlias('@web/images/screenshota.png');
$screen2    = Yii::getAlias('@web/images/screenshotb.png');
$screen3    = Yii::getAlias('@web/images/screenshotc.png');
$aboutImage = Yii::getAlias('@web/images/about-system.jpg');
$logo       = Yii::getAlias('@web/images/logo.png');
$loginUrl   = 'http://localhost/business-system/backend/web/login';
$signupUrl  = 'http://localhost/business-system/backend/web/signup';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= Html::encode($this->title) ?></title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
/* ═══════════════════════════════════════════════════════
   BIZFLOW — CINEMATIC PRO MAX LANDING
   Inspired by: 21st.dev · Linear · Vercel · Stripe
═══════════════════════════════════════════════════════ */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --ink:#020817;
  --ink2:#0A1628;
  --blue:#3B82F6;
  --violet:#7C3AED;
  --teal:#06B6D4;
  --green:#10B981;
  --amber:#F59E0B;
  --rose:#F43F5E;
  --tx:#F8FAFC;
  --txm:#64748B;
  --txm2:#94A3B8;
  --txm3:#CBD5E1;
  --bdr:rgba(255,255,255,.07);
  --bdr2:rgba(255,255,255,.14);
  --sur:rgba(255,255,255,.03);
  --sur2:rgba(255,255,255,.06);
}
html{scroll-behavior:smooth}
body{
  background:var(--ink);color:var(--tx);
  font-family:'Inter',system-ui,sans-serif;
  line-height:1.6;overflow-x:hidden;
  -webkit-font-smoothing:antialiased;
}
img{display:block;max-width:100%}
a{text-decoration:none}

/* ── FIXED LAYERS ── */
#gl-canvas{position:fixed;inset:0;z-index:0;pointer-events:none}
#pt-canvas{position:fixed;inset:0;z-index:1;pointer-events:none}
.site-wrap{position:relative;z-index:2}

/* ────────────────────────────────────────
   NAV — floating pill, 21st.dev style
──────────────────────────────────────── */
.nav{
  position:fixed;top:18px;left:50%;transform:translateX(-50%);
  z-index:999;
  display:flex;align-items:center;gap:0;
  background:rgba(2,8,23,.72);
  backdrop-filter:blur(28px) saturate(180%);
  border:1px solid var(--bdr2);
  border-radius:999px;
  padding:6px 8px 6px 16px;
  gap:4px;
  transition:all .3s;
  white-space:nowrap;
}
.nav.docked{
  top:0;border-radius:0;left:0;right:0;
  transform:none;width:100%;
  padding:0 5%;height:64px;
}
.nav-brand{
  display:flex;align-items:center;gap:9px;
  font-family:'Syne',sans-serif;
  font-weight:800;font-size:17px;color:#fff;
  margin-right:12px;
}
.nav-mark{
  width:30px;height:30px;border-radius:8px;flex-shrink:0;
  background:linear-gradient(135deg,#3B82F6,#7C3AED);
  display:flex;align-items:center;justify-content:center;
  font-weight:900;font-size:13px;color:#fff;
  animation:markGlow 3s ease-in-out infinite;
}
@keyframes markGlow{
  0%,100%{box-shadow:0 0 12px rgba(124,58,237,.5)}
  50%{box-shadow:0 0 24px rgba(124,58,237,.9),0 0 48px rgba(59,130,246,.3)}
}
.nav-links{display:flex;gap:2px}
.nav-links a{
  padding:7px 14px;border-radius:999px;
  font-size:13px;font-weight:500;color:var(--txm2);
  transition:.2s;
}
.nav-links a:hover{color:#fff;background:rgba(255,255,255,.08)}
.nav-cta{display:flex;gap:8px;margin-left:12px}
.btn{
  display:inline-flex;align-items:center;gap:7px;
  padding:9px 20px;border-radius:999px;
  font-size:13px;font-weight:600;
  transition:all .22s;cursor:pointer;border:none;
}
.btn-ghost{
  background:rgba(255,255,255,.07);
  border:1px solid var(--bdr2);color:#fff;
}
.btn-ghost:hover{background:rgba(255,255,255,.13)}
.btn-primary{
  background:linear-gradient(135deg,#3B82F6,#7C3AED);
  color:#fff;
  box-shadow:0 0 20px rgba(124,58,237,.4);
}
.btn-primary:hover{
  box-shadow:0 0 32px rgba(124,58,237,.7),0 0 60px rgba(59,130,246,.3);
  transform:translateY(-1px);
}
.btn-lg{padding:14px 32px;border-radius:14px;font-size:15px}
.btn-outline{
  background:transparent;
  border:1px solid rgba(255,255,255,.18);color:#fff;border-radius:14px;
}
.btn-outline:hover{background:rgba(255,255,255,.07)}

/* ────────────────────────────────────────
   HERO — cinematic, full-screen
──────────────────────────────────────── */
.hero{
  min-height:100vh;
  display:flex;flex-direction:column;
  align-items:center;justify-content:center;
  text-align:center;
  padding:140px 5% 80px;
  position:relative;
  overflow:hidden;
}

/* horizontal scan-line */
.hero::before{
  content:'';position:absolute;
  left:0;right:0;height:1px;top:50%;
  background:linear-gradient(90deg,transparent,rgba(124,58,237,.4),rgba(59,130,246,.4),transparent);
  animation:scanLine 8s ease-in-out infinite;
  pointer-events:none;
}
@keyframes scanLine{
  0%,100%{top:20%;opacity:0}
  10%{opacity:1}
  90%{opacity:1}
  50%{top:80%}
}

/* eye-brow */
.eyebrow{
  display:inline-flex;align-items:center;gap:8px;
  padding:6px 16px;border-radius:999px;
  border:1px solid rgba(124,58,237,.3);
  background:rgba(124,58,237,.1);
  font-size:12px;font-weight:600;
  color:#A78BFA;letter-spacing:.06em;text-transform:uppercase;
  margin-bottom:36px;
  animation:fadeSlideUp .8s ease both .2s;
}
.live-dot{
  width:6px;height:6px;border-radius:50%;background:#7C3AED;
  box-shadow:0 0 6px rgba(124,58,237,.9);
  animation:ldp 1.6s ease-in-out infinite;
}
@keyframes ldp{0%,100%{transform:scale(1);opacity:1}50%{transform:scale(1.8);opacity:.4}}

/* main headline — Syne, cinematic */
.hero-h{
  font-family:'Syne',sans-serif;
  font-size:clamp(48px,8.5vw,110px);
  font-weight:800;line-height:.96;
  letter-spacing:-.04em;
  color:#fff;margin-bottom:32px;
  animation:fadeSlideUp .9s ease both .4s;
}
.hero-h .word{display:inline-block}
.hero-h .grad{
  background:linear-gradient(135deg,#60A5FA 0%,#A78BFA 35%,#F472B6 65%,#FB923C 100%);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;
  background-clip:text;
  background-size:200% 200%;
  animation:gradFlow 5s ease-in-out infinite;
}
@keyframes gradFlow{
  0%{background-position:0% 50%}
  50%{background-position:100% 50%}
  100%{background-position:0% 50%}
}

/* sub */
.hero-sub{
  font-size:clamp(16px,1.8vw,20px);
  color:var(--txm2);max-width:620px;line-height:1.8;
  margin-bottom:48px;
  animation:fadeSlideUp .9s ease both .6s;
}

/* CTA row */
.hero-cta{
  display:flex;gap:12px;flex-wrap:wrap;justify-content:center;
  margin-bottom:72px;
  animation:fadeSlideUp .9s ease both .75s;
}

@keyframes fadeSlideUp{
  from{opacity:0;transform:translateY(24px)}
  to{opacity:1;transform:translateY(0)}
}

/* Floating dashboard preview */
.hero-preview{
  position:relative;
  width:min(900px,90vw);
  animation:previewIn 1.2s ease both 1s;
}
@keyframes previewIn{
  from{opacity:0;transform:translateY(48px) scale(.96) rotateX(6deg)}
  to{opacity:1;transform:translateY(0) scale(1) rotateX(0deg)}
}
.hero-preview::before{
  content:'';position:absolute;
  inset:-1px;border-radius:21px;
  background:linear-gradient(135deg,rgba(59,130,246,.4),rgba(124,58,237,.4),rgba(6,182,212,.2));
  z-index:-1;filter:blur(1px);
}
.preview-frame{
  border-radius:20px;overflow:hidden;
  background:#0D1526;
  border:1px solid rgba(255,255,255,.1);
  box-shadow:
    0 0 0 1px rgba(255,255,255,.06),
    0 40px 80px rgba(0,0,0,.6),
    0 0 120px rgba(124,58,237,.15);
}
.preview-bar{
  background:#0A1121;
  padding:12px 16px;
  display:flex;align-items:center;gap:8px;
  border-bottom:1px solid rgba(255,255,255,.06);
}
.preview-dots{display:flex;gap:6px}
.preview-dots span{
  width:10px;height:10px;border-radius:50%;
}
.pd-r{background:#F43F5E}
.pd-y{background:#F59E0B}
.pd-g{background:#10B981}
.preview-url{
  flex:1;margin:0 12px;
  background:rgba(255,255,255,.04);
  border:1px solid rgba(255,255,255,.08);
  border-radius:6px;padding:5px 12px;
  font-size:11px;color:var(--txm);
}
.preview-img{
  width:100%;aspect-ratio:16/9;object-fit:cover;
  display:block;
  transition:.5s;
}
.hero-preview:hover .preview-img{transform:scale(1.02)}

/* stats strip */
.stats-strip{
  display:flex;justify-content:center;gap:0;
  margin-top:60px;
  background:rgba(255,255,255,.03);
  border:1px solid var(--bdr2);
  border-radius:18px;
  overflow:hidden;
  backdrop-filter:blur(16px);
  animation:fadeSlideUp .9s ease both 1.4s;
}
.stat-c{
  padding:22px 40px;text-align:center;
  border-right:1px solid var(--bdr);
  position:relative;cursor:default;
  transition:.3s;
}
.stat-c:last-child{border-right:none}
.stat-c:hover{background:rgba(255,255,255,.04)}
.stat-c::after{
  content:'';position:absolute;bottom:0;left:10%;right:10%;height:1.5px;
  background:linear-gradient(90deg,transparent,rgba(124,58,237,.6),transparent);
  transform:scaleX(0);transition:.4s;
}
.stat-c:hover::after{transform:scaleX(1)}
.stat-n{
  font-family:'Syne',sans-serif;
  font-size:30px;font-weight:800;
  background:linear-gradient(135deg,#fff,#A78BFA);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.stat-l{font-size:11px;color:var(--txm2);margin-top:3px;font-weight:500}

/* ────────────────────────────────────────
   SECTION BASE
──────────────────────────────────────── */
.section{padding:110px 5%}
.s-eye{
  font-size:11px;font-weight:700;letter-spacing:.12em;
  text-transform:uppercase;color:#7C3AED;margin-bottom:12px;
}
.s-h{
  font-family:'Syne',sans-serif;
  font-size:clamp(28px,4vw,56px);font-weight:800;
  line-height:1.08;letter-spacing:-.03em;color:#fff;
  margin-bottom:16px;
}
.s-sub{font-size:17px;color:var(--txm2);max-width:560px;line-height:1.75}

/* reveal util */
.rv{
  opacity:0;transform:translateY(28px);
  transition:opacity .7s cubic-bezier(.22,1,.36,1),transform .7s cubic-bezier(.22,1,.36,1);
  transition-delay:calc(var(--d,0) * 90ms);
}
.rv.in{opacity:1;transform:none}

/* ────────────────────────────────────────
   BENTO GRID  (21st.dev inspired)
──────────────────────────────────────── */
.bento{
  display:grid;
  grid-template-columns:repeat(12,1fr);
  gap:12px;margin-top:64px;
}
.bc{
  border-radius:20px;padding:28px;
  background:var(--sur);
  border:1px solid var(--bdr);
  position:relative;overflow:hidden;
  transition:border-color .35s,transform .35s,box-shadow .35s;
  opacity:0;transform:translateY(28px);
  cursor:default;
}
.bc.in{animation:bcIn .55s cubic-bezier(.22,1,.36,1) forwards}
@keyframes bcIn{to{opacity:1;transform:none}}

/* glass shimmer sweep on hover */
.bc::before{
  content:'';position:absolute;inset:0;
  background:linear-gradient(120deg,transparent 30%,rgba(255,255,255,.04) 50%,transparent 70%);
  transform:translateX(-100%);transition:.6s;pointer-events:none;
}
.bc:hover::before{transform:translateX(100%)}

/* accent top border */
.bc::after{
  content:'';position:absolute;top:0;left:0;right:0;height:1px;
  background:linear-gradient(90deg,transparent,var(--ac,rgba(124,58,237,.5)),transparent);
  opacity:0;transition:.4s;
}
.bc:hover::after{opacity:1}
.bc:hover{transform:translateY(-4px);box-shadow:0 20px 50px rgba(0,0,0,.35)}

.s3{grid-column:span 3}.s4{grid-column:span 4}
.s5{grid-column:span 5}.s6{grid-column:span 6}
.s7{grid-column:span 7}.s8{grid-column:span 8}

.bc-blue  {border-color:rgba(59,130,246,.18); --ac:rgba(59,130,246,.6)}
.bc-violet{border-color:rgba(124,58,237,.18); --ac:rgba(124,58,237,.6)}
.bc-teal  {border-color:rgba(6,182,212,.18);  --ac:rgba(6,182,212,.6)}
.bc-green {border-color:rgba(16,185,129,.18); --ac:rgba(16,185,129,.6)}
.bc-amber {border-color:rgba(245,158,11,.18); --ac:rgba(245,158,11,.6)}
.bc-rose  {border-color:rgba(244,63,94,.18);  --ac:rgba(244,63,94,.6)}

/* card icon */
.c-ico{
  width:48px;height:48px;border-radius:14px;
  display:flex;align-items:center;justify-content:center;
  margin-bottom:18px;transition:transform .3s;
}
.bc:hover .c-ico{transform:scale(1.1) rotate(-6deg)}
.ci-b{background:rgba(59,130,246,.14)}
.ci-v{background:rgba(124,58,237,.14)}
.ci-t{background:rgba(6,182,212,.14)}
.ci-g{background:rgba(16,185,129,.14)}
.ci-a{background:rgba(245,158,11,.14)}
.ci-r{background:rgba(244,63,94,.14)}
.c-ico svg{width:22px;height:22px}

.bc h3{
  font-family:'Syne',sans-serif;
  font-size:18px;font-weight:700;color:#fff;margin-bottom:9px;
}
.bc p{font-size:13.5px;color:var(--txm2);line-height:1.7}

/* big counter */
.big-n{
  font-family:'Syne',sans-serif;
  font-size:64px;font-weight:800;line-height:1;margin-top:18px;
}
.gn-b{background:linear-gradient(135deg,#60A5FA,#3B82F6);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.gn-v{background:linear-gradient(135deg,#C4B5FD,#7C3AED);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}
.gn-t{background:linear-gradient(135deg,#67E8F9,#06B6D4);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text}

/* mini sparkline */
.spark{
  display:flex;align-items:flex-end;gap:4px;
  height:50px;margin-top:16px;
}
.sp-b{
  flex:1;border-radius:4px 4px 0 0;min-width:6px;
  background:rgba(59,130,246,.18);
  transition:height .4s cubic-bezier(.22,1,.36,1),background .3s;
}
.sp-b.lit{background:linear-gradient(to top,#3B82F6,#7C3AED)}
.bc:hover .sp-b{background:rgba(59,130,246,.35)}
.bc:hover .sp-b.lit{background:linear-gradient(to top,#60A5FA,#A78BFA)}

/* role pills */
.pills{display:flex;gap:6px;flex-wrap:wrap;margin-top:16px}
.pill{
  padding:4px 11px;border-radius:6px;font-size:11.5px;font-weight:600;
  border:1px solid transparent;transition:.25s;cursor:default;
}
.pill:hover{transform:translateY(-2px) scale(1.04)}
.pl-b{background:rgba(59,130,246,.1);border-color:rgba(59,130,246,.22);color:#93C5FD}
.pl-v{background:rgba(124,58,237,.1);border-color:rgba(124,58,237,.22);color:#C4B5FD}
.pl-t{background:rgba(6,182,212,.1);border-color:rgba(6,182,212,.22);color:#67E8F9}
.pl-a{background:rgba(245,158,11,.1);border-color:rgba(245,158,11,.22);color:#FCD34D}
.pl-r{background:rgba(244,63,94,.1);border-color:rgba(244,63,94,.22);color:#FDA4AF}

/* ────────────────────────────────────────
   HOW IT WORKS — timeline
──────────────────────────────────────── */
.timeline{
  display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
  gap:0;margin-top:64px;position:relative;
}
.timeline::before{
  content:'';position:absolute;
  top:34px;left:10%;right:10%;height:1px;
  background:linear-gradient(90deg,transparent,rgba(124,58,237,.4),rgba(59,130,246,.4),transparent);
}
.tl-step{
  padding:28px 24px;text-align:center;
  opacity:0;transform:translateY(22px);
  transition:.6s cubic-bezier(.22,1,.36,1);
}
.tl-step.in{opacity:1;transform:none}
.tl-num{
  width:44px;height:44px;border-radius:14px;
  background:linear-gradient(135deg,#3B82F6,#7C3AED);
  display:flex;align-items:center;justify-content:center;
  font-family:'Syne',sans-serif;font-weight:800;font-size:16px;color:#fff;
  margin:0 auto 20px;
  box-shadow:0 6px 20px rgba(124,58,237,.35);
  transition:transform .3s;
}
.tl-step:hover .tl-num{transform:rotate(-8deg) scale(1.1)}
.tl-step h3{
  font-family:'Syne',sans-serif;
  font-weight:700;font-size:16px;color:#fff;margin-bottom:8px;
}
.tl-step p{font-size:13.5px;color:var(--txm2);line-height:1.7}

/* ────────────────────────────────────────
   SCREENSHOTS — with glassmorphism overlay
──────────────────────────────────────── */
.screens{
  display:grid;grid-template-columns:1.6fr 1fr;
  grid-template-rows:auto auto;
  gap:12px;margin-top:64px;
}
.sc-wrap{
  border-radius:18px;overflow:hidden;
  border:1px solid var(--bdr);
  position:relative;background:#0D1526;
  opacity:0;transform:scale(.97);
  transition:.55s cubic-bezier(.22,1,.36,1);
}
.sc-wrap.in{opacity:1;transform:none}
.sc-wrap.sc-tall{grid-row:span 2}
.sc-wrap img{
  width:100%;height:100%;object-fit:cover;
  display:block;transition:.5s;
}
.sc-wrap:hover img{transform:scale(1.04)}

/* glassmorphism label */
.sc-glass{
  position:absolute;bottom:14px;left:14px;
  background:rgba(2,8,23,.7);
  backdrop-filter:blur(16px) saturate(180%);
  border:1px solid rgba(255,255,255,.12);
  border-radius:12px;padding:10px 16px;
  display:flex;align-items:center;gap:10px;
  transition:.35s;
}
.sc-wrap:hover .sc-glass{background:rgba(2,8,23,.85)}
.sc-dot{
  width:7px;height:7px;border-radius:50%;
  background:#10B981;box-shadow:0 0 8px #10B981;
  animation:ldp 2s ease-in-out infinite;
}
.sc-lbl{font-size:12px;font-weight:600;color:#fff}
.sc-sub{font-size:11px;color:var(--txm2);margin-top:1px}

/* hover glow border */
.sc-wrap::after{
  content:'';position:absolute;inset:0;
  border-radius:18px;
  background:linear-gradient(135deg,rgba(124,58,237,.07),rgba(59,130,246,.05));
  opacity:0;transition:.4s;pointer-events:none;
}
.sc-wrap:hover::after{opacity:1}
.sc-wrap:hover{box-shadow:0 24px 60px rgba(0,0,0,.5)}

/* ────────────────────────────────────────
   ABOUT  — split with floating card
──────────────────────────────────────── */
.about-wrap{
  display:grid;grid-template-columns:1fr 1fr;
  gap:72px;align-items:center;
  margin-top:64px;
}
.about-media{position:relative}
.about-img{
  border-radius:24px;overflow:hidden;
  border:1px solid var(--bdr);
  position:relative;
}
.about-img img{width:100%;display:block;transition:.5s}
.about-img:hover img{transform:scale(1.04)}

/* glass shimmer on about image */
.about-img::before{
  content:'';position:absolute;inset:0;z-index:1;pointer-events:none;
  background:linear-gradient(135deg,rgba(124,58,237,.1),rgba(59,130,246,.06));
  opacity:0;transition:.4s;
}
.about-img:hover::before{opacity:1}

/* floating metric card */
.float-card{
  position:absolute;
  background:rgba(2,8,23,.88);
  backdrop-filter:blur(20px) saturate(180%);
  border:1px solid var(--bdr2);
  border-radius:16px;padding:16px 20px;
  animation:floatCard 6s ease-in-out infinite;
  z-index:2;
}
@keyframes floatCard{
  0%,100%{transform:translateY(0)}
  50%{transform:translateY(-8px)}
}
.fc-live{bottom:20px;left:20px}
.fc-stat{top:20px;right:-20px}
.fc-head{display:flex;align-items:center;gap:8px;margin-bottom:4px}
.fc-dot{width:7px;height:7px;border-radius:50%;background:#10B981;box-shadow:0 0 8px #10B981;animation:ldp 2s infinite}
.fc-title{font-size:12px;font-weight:600;color:#fff}
.fc-body{font-size:11px;color:var(--txm2)}
.fc-num{
  font-family:'Syne',sans-serif;font-size:28px;font-weight:800;
  background:linear-gradient(135deg,#60A5FA,#A78BFA);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}

/* about features */
.about-feats{display:flex;flex-direction:column;gap:20px;margin-top:32px}
.afeat{
  display:flex;gap:14px;padding:16px;
  border-radius:14px;border:1px solid transparent;
  transition:.3s;
}
.afeat:hover{
  background:rgba(255,255,255,.03);
  border-color:var(--bdr);
  transform:translateX(4px);
}
.afeat-ico{
  width:38px;height:38px;border-radius:11px;flex-shrink:0;
  background:rgba(124,58,237,.12);border:1px solid rgba(124,58,237,.2);
  display:flex;align-items:center;justify-content:center;
  font-size:16px;transition:.3s;
}
.afeat:hover .afeat-ico{background:rgba(124,58,237,.22);transform:scale(1.1)}
.afeat-t h4{
  font-family:'Syne',sans-serif;
  font-weight:700;font-size:15px;color:#fff;margin-bottom:2px;
}
.afeat-t p{font-size:13px;color:var(--txm2)}

/* ────────────────────────────────────────
   CTA BANNER
──────────────────────────────────────── */
.cta-wrap{padding:60px 5%}
.cta-box{
  position:relative;overflow:hidden;
  border-radius:28px;padding:80px 60px;text-align:center;
  background:linear-gradient(135deg,rgba(124,58,237,.1),rgba(59,130,246,.08),rgba(6,182,212,.05));
  border:1px solid rgba(124,58,237,.22);
}
/* animated mesh inside CTA */
.cta-mesh{
  position:absolute;inset:0;pointer-events:none;
  background:
    radial-gradient(ellipse 60% 40% at 20% 50%,rgba(124,58,237,.12),transparent),
    radial-gradient(ellipse 50% 40% at 80% 50%,rgba(59,130,246,.1),transparent),
    radial-gradient(ellipse 40% 80% at 50% 0%,rgba(6,182,212,.08),transparent);
  animation:meshPulse 7s ease-in-out infinite;
}
@keyframes meshPulse{
  0%,100%{opacity:.7}
  50%{opacity:1}
}
.cta-box h2{
  font-family:'Syne',sans-serif;
  font-size:clamp(28px,4.5vw,54px);font-weight:800;
  color:#fff;margin-bottom:16px;position:relative;
  letter-spacing:-.03em;line-height:1.1;
}
.cta-box p{
  font-size:18px;color:var(--txm2);margin-bottom:40px;position:relative;
}
.cta-btns{
  display:flex;gap:12px;justify-content:center;flex-wrap:wrap;position:relative;
}

/* ────────────────────────────────────────
   CONTACT
──────────────────────────────────────── */
.contact-cards{
  display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
  gap:12px;margin-top:64px;
}
.cc{
  background:var(--sur);border:1px solid var(--bdr);
  border-radius:20px;padding:28px 22px;text-align:center;
  display:block;
  opacity:0;transform:translateY(20px);
  transition:all .35s;
}
.cc.in{animation:bcIn .55s cubic-bezier(.22,1,.36,1) forwards}
.cc:hover{
  transform:translateY(-6px);background:var(--sur2);
  border-color:var(--bdr2);
  box-shadow:0 20px 50px rgba(0,0,0,.3);
}
.cc-ico{
  width:54px;height:54px;border-radius:16px;
  margin:0 auto 16px;
  display:flex;align-items:center;justify-content:center;
  font-size:24px;transition:.35s;
}
.cc:hover .cc-ico{transform:scale(1.12) rotate(-5deg)}
.cc h4{
  font-family:'Syne',sans-serif;
  font-weight:700;font-size:15px;color:#fff;margin-bottom:5px;
}
.cc p{font-size:12.5px;color:var(--txm2)}
.cc-link{
  display:inline-block;margin-top:12px;
  font-size:12.5px;font-weight:600;color:#60A5FA;transition:.2s;
}
.cc:hover .cc-link{color:#A78BFA}

/* ────────────────────────────────────────
   FOOTER
──────────────────────────────────────── */
.footer{
  padding:32px 5%;
  border-top:1px solid var(--bdr);
  display:flex;align-items:center;justify-content:space-between;
  flex-wrap:wrap;gap:16px;
}
.footer-brand{
  display:flex;align-items:center;gap:9px;
  font-family:'Syne',sans-serif;font-weight:800;font-size:16px;color:#fff;
}
.footer p{font-size:12.5px;color:var(--txm)}
.footer-links{display:flex;gap:22px}
.footer-links a{font-size:12.5px;color:var(--txm);transition:.2s}
.footer-links a:hover{color:#fff}

/* ────────────────────────────────────────
   RESPONSIVE
──────────────────────────────────────── */
@media(max-width:1100px){
  .s3,.s4,.s5{grid-column:span 6}
  .s7,.s8{grid-column:span 12}
  .about-wrap{grid-template-columns:1fr;gap:48px}
  .screens{grid-template-columns:1fr 1fr}
  .sc-wrap.sc-tall{grid-row:auto}
}
@media(max-width:768px){
  .nav{
    top:0;border-radius:0;left:0;right:0;transform:none;
    width:100%;padding:0 18px;height:60px;
  }
  .nav-links{display:none}
  .bento{grid-template-columns:1fr 1fr}
  .s3,.s4,.s5,.s6,.s7,.s8{grid-column:span 2}
  .screens{grid-template-columns:1fr}
  .stats-strip{flex-wrap:wrap}
  .stat-c{border-right:none;border-bottom:1px solid var(--bdr);width:50%}
  .timeline::before{display:none}
  .cta-box{padding:48px 24px}
  .fc-stat{display:none}
}
@media(max-width:480px){
  .bento{grid-template-columns:1fr}
  .s3,.s4,.s5,.s6,.s7,.s8{grid-column:span 1}
  .stat-c{width:100%}
  .contact-cards{grid-template-columns:1fr 1fr}
}
@media(prefers-reduced-motion:reduce){
  *,*::before,*::after{animation:none!important;transition:none!important}
}
</style>
</head>
<body>

<canvas id="gl-canvas"></canvas>
<canvas id="pt-canvas"></canvas>

<div class="site-wrap">

<!-- ════ NAV ════ -->
<nav class="nav" id="siteNav">
  <div class="nav-brand">
    <div class="nav-mark">B</div>
    BizFlow
  </div>
  <div class="nav-links">
    <a href="#features">Features</a>
    <a href="#how">How it works</a>
    <a href="#screenshots">Screenshots</a>
    <a href="#about">About</a>
    <a href="#contact">Contact</a>
  </div>
  <div class="nav-cta">
    <a href="<?= $loginUrl ?>" class="btn btn-ghost">Sign in</a>
    <a href="<?= $signupUrl ?>" class="btn btn-primary">Get started →</a>
  </div>
</nav>


<!-- ════ HERO ════ -->
<section class="hero">

  <div class="eyebrow">
    <span class="live-dot"></span>
    Built for Tanzania's multi-branch business owners
  </div>

  <h1 class="hero-h">
    <span class="word">One platform.</span><br>
    <span class="word grad">Every branch.</span><br>
    <span class="word">Total control.</span>
  </h1>

  <p class="hero-sub">
    Manage multiple businesses, branches, and seller teams from one powerful dashboard.
    Real-time sales, inventory, and performance — all in one place.
  </p>

  <div class="hero-cta">
    <a href="<?= $signupUrl ?>" class="btn btn-primary btn-lg">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M13 2L3 14h9l-1 8 10-12h-9l1-8z"/></svg>
      Start for free
    </a>
    <a href="<?= $loginUrl ?>" class="btn btn-outline btn-lg">Sign in →</a>
  </div>

  <!-- browser preview -->
  <div class="hero-preview">
    <div class="preview-frame">
      <div class="preview-bar">
        <div class="preview-dots">
          <span class="pd-r"></span>
          <span class="pd-y"></span>
          <span class="pd-g"></span>
        </div>
        <div class="preview-url">localhost/business-system/backend/web/dashboard</div>
      </div>
      <img src="<?= $screen1 ?>" alt="BizFlow Dashboard" class="preview-img" id="previewImg">
    </div>
  </div>

  <!-- stats -->
  <div class="stats-strip">
    <div class="stat-c"><div class="stat-n">∞</div><div class="stat-l">Businesses</div></div>
    <div class="stat-c"><div class="stat-n">∞</div><div class="stat-l">Branches</div></div>
    <div class="stat-c"><div class="stat-n">Live</div><div class="stat-l">Sales data</div></div>
    <div class="stat-c"><div class="stat-n">100%</div><div class="stat-l">Web-based</div></div>
  </div>

</section>


<!-- ════ FEATURES BENTO ════ -->
<section class="section" id="features">
  <div class="rv">
    <div class="s-eye">Features</div>
    <h2 class="s-h">Everything to run<br>your business</h2>
    <p class="s-sub">From a single seller to a nationwide network — BizFlow scales with you.</p>
  </div>

  <div class="bento">

    <div class="bc s7 bc-blue rv" style="--d:1">
      <div class="c-ico ci-b">
        <svg viewBox="0 0 24 24" fill="none" stroke="#60A5FA" stroke-width="1.8">
          <path d="M3 21V7a2 2 0 012-2h5v16M10 21V3h9a2 2 0 012 2v16"/>
          <path d="M14 9h2M14 13h2M6 9h2M6 13h2"/>
        </svg>
      </div>
      <h3>Multi-Business Management</h3>
      <p>Own multiple brands? Manage them all from one login. Switch contexts instantly and compare performance side by side.</p>
      <div class="big-n gn-b">∞</div>
      <p style="margin-top:6px;font-size:12.5px;color:var(--txm2)">Businesses per account</p>
    </div>

    <div class="bc s5 bc-violet rv" style="--d:2">
      <div class="c-ico ci-v">
        <svg viewBox="0 0 24 24" fill="none" stroke="#A78BFA" stroke-width="1.8">
          <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
      </div>
      <h3>Branch Control</h3>
      <p>Monitor every branch. Track each location independently or as a group in real-time.</p>
      <div class="spark">
        <div class="sp-b" style="height:40%"></div>
        <div class="sp-b lit" style="height:65%"></div>
        <div class="sp-b" style="height:48%"></div>
        <div class="sp-b lit" style="height:88%"></div>
        <div class="sp-b" style="height:55%"></div>
        <div class="sp-b lit" style="height:100%"></div>
        <div class="sp-b" style="height:70%"></div>
      </div>
    </div>

    <div class="bc s4 bc-teal rv" style="--d:3">
      <div class="c-ico ci-t">
        <svg viewBox="0 0 24 24" fill="none" stroke="#67E8F9" stroke-width="1.8">
          <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
        </svg>
      </div>
      <h3>Seller Management</h3>
      <p>Assign sellers to branches, define roles, and monitor their activity in real-time.</p>
    </div>

    <div class="bc s4 bc-green rv" style="--d:4">
      <div class="c-ico ci-g">
        <svg viewBox="0 0 24 24" fill="none" stroke="#6EE7B7" stroke-width="1.8">
          <path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/>
          <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
        </svg>
      </div>
      <h3>Inventory Tracking</h3>
      <p>Live stock levels, low-stock alerts, and movement history across every branch.</p>
    </div>

    <div class="bc s4 bc-amber rv" style="--d:5">
      <div class="c-ico ci-a">
        <svg viewBox="0 0 24 24" fill="none" stroke="#FCD34D" stroke-width="1.8">
          <line x1="12" y1="1" x2="12" y2="23"/>
          <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
        </svg>
      </div>
      <h3>Sales Monitoring</h3>
      <p>Daily, weekly, and monthly sales figures. Spot your top-performing branches instantly.</p>
    </div>

    <div class="bc s5 bc-rose rv" style="--d:6">
      <div class="c-ico ci-r">
        <svg viewBox="0 0 24 24" fill="none" stroke="#FDA4AF" stroke-width="1.8">
          <path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
        </svg>
      </div>
      <h3>Reports & Analytics</h3>
      <p>Revenue trends, team KPIs, and export-ready reports for smarter decisions.</p>
      <div class="big-n gn-v" style="font-size:46px;margin-top:18px">360°</div>
    </div>

    <div class="bc s7 bc-violet rv" style="--d:7">
      <div class="c-ico ci-v">
        <svg viewBox="0 0 24 24" fill="none" stroke="#A78BFA" stroke-width="1.8">
          <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
          <path d="M7 11V7a5 5 0 0110 0v4"/>
        </svg>
      </div>
      <h3>Role-Based Permissions</h3>
      <p>Fine-grained access control — each seller, manager, or admin sees exactly what they need, nothing more.</p>
      <div class="pills">
        <span class="pill pl-b">Owner</span>
        <span class="pill pl-v">Manager</span>
        <span class="pill pl-t">Seller</span>
        <span class="pill pl-a">Auditor</span>
        <span class="pill pl-r">Viewer</span>
      </div>
    </div>

  </div>
</section>


<!-- ════ HOW IT WORKS ════ -->
<section class="section" id="how">
  <div class="rv">
    <div class="s-eye">How it works</div>
    <h2 class="s-h">Up and running<br>in minutes</h2>
    <p class="s-sub">No complex setup. Sign up, add your businesses, invite your team.</p>
  </div>

  <div class="timeline">
    <div class="tl-step rv" style="--d:1">
      <div class="tl-num">01</div>
      <h3>Create your account</h3>
      <p>Sign up in seconds. One login, no matter how many businesses you own.</p>
    </div>
    <div class="tl-step rv" style="--d:2">
      <div class="tl-num">02</div>
      <h3>Add your businesses</h3>
      <p>Register each business. Customize names, locations, and settings per entity.</p>
    </div>
    <div class="tl-step rv" style="--d:3">
      <div class="tl-num">03</div>
      <h3>Set up branches</h3>
      <p>Add branches under each business. Assign managers and configure inventory.</p>
    </div>
    <div class="tl-step rv" style="--d:4">
      <div class="tl-num">04</div>
      <h3>Monitor everything</h3>
      <p>Live sales, stock levels, and team performance — always up to date.</p>
    </div>
  </div>
</section>


<!-- ════ SCREENSHOTS ════ -->
<section class="section" id="screenshots">
  <div class="rv">
    <div class="s-eye">Screenshots</div>
    <h2 class="s-h">See it in action</h2>
    <p class="s-sub">A clean modern interface built for daily business use.</p>
  </div>

  <div class="screens">
    <div class="sc-wrap sc-tall rv" style="--d:1">
      <img src="<?= $screen1 ?>" alt="Dashboard overview">
      <div class="sc-glass">
        <div class="sc-dot"></div>
        <div>
          <div class="sc-lbl">Main Dashboard</div>
          <div class="sc-sub">Live overview of all operations</div>
        </div>
      </div>
    </div>
    <div class="sc-wrap rv" style="--d:2">
      <img src="<?= $screen2 ?>" alt="Branch management">
      <div class="sc-glass">
        <div class="sc-dot"></div>
        <div>
          <div class="sc-lbl">Branch View</div>
          <div class="sc-sub">Manage each location</div>
        </div>
      </div>
    </div>
    <div class="sc-wrap rv" style="--d:3">
      <img src="<?= $screen3 ?>" alt="Reports">
      <div class="sc-glass">
        <div class="sc-dot"></div>
        <div>
          <div class="sc-lbl">Reports</div>
          <div class="sc-sub">Analytics & insights</div>
        </div>
      </div>
    </div>
  </div>
</section>


<!-- ════ ABOUT ════ -->
<section class="section" id="about">
  <div class="about-wrap">

    <div class="about-media rv">
      <div class="about-img">
        <img src="<?= $aboutImage ?>" alt="About BizFlow">
      </div>
      <div class="float-card fc-live">
        <div class="fc-head">
          <div class="fc-dot"></div>
          <div class="fc-title">System Status</div>
        </div>
        <div class="fc-body">Live &amp; operational</div>
      </div>
      <div class="float-card fc-stat">
        <div class="fc-num">24/7</div>
        <div class="fc-body">Real-time data sync</div>
      </div>
    </div>

    <div class="rv" style="--d:1">
      <div class="s-eye">About</div>
      <h2 class="s-h" style="font-size:clamp(26px,3.5vw,44px)">
        Built for the modern<br>Tanzanian business owner
      </h2>
      <p class="s-sub" style="margin-bottom:0">
        BizFlow was designed for owners who run multiple businesses across multiple locations — giving you the clarity to make faster, smarter decisions every day.
      </p>
      <div class="about-feats">
        <div class="afeat">
          <div class="afeat-ico">✅</div>
          <div class="afeat-t">
            <h4>No more branch confusion</h4>
            <p>Every branch reports to you, not to chaos. One view, all locations.</p>
          </div>
        </div>
        <div class="afeat">
          <div class="afeat-ico">📱</div>
          <div class="afeat-t">
            <h4>Access anywhere, any device</h4>
            <p>Fully web-based. Phone, tablet, or desktop — no app install needed.</p>
          </div>
        </div>
        <div class="afeat">
          <div class="afeat-ico">🔒</div>
          <div class="afeat-t">
            <h4>Your data stays yours</h4>
            <p>Secure, role-based access. Sellers see only what they need.</p>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>


<!-- ════ CTA ════ -->
<div class="cta-wrap">
  <div class="cta-box rv">
    <div class="cta-mesh"></div>
    <h2>Ready to take control<br>of your business?</h2>
    <p>Join business owners across Tanzania using BizFlow every day.</p>
    <div class="cta-btns">
      <a href="<?= $signupUrl ?>" class="btn btn-primary btn-lg">Create free account →</a>
      <a href="<?= $loginUrl ?>"  class="btn btn-ghost btn-lg">Sign in</a>
    </div>
  </div>
</div>


<!-- ════ CONTACT ════ -->
<section class="section" id="contact" style="padding-top:40px">
  <div class="rv">
    <div class="s-eye">Contact</div>
    <h2 class="s-h">Get in touch</h2>
    <p class="s-sub">Have questions? Reach out on any platform — we respond fast.</p>
  </div>
  <div class="contact-cards">
    <a href="https://wa.me/255620871857?text=Habari%20nimeona%20service%20yako" target="_blank" class="cc rv" style="--d:1">
      <div class="cc-ico" style="background:rgba(37,211,102,.1);border:1px solid rgba(37,211,102,.2)">📞</div>
      <h4>WhatsApp</h4>
      <p>Live support & quick questions</p>
      <span class="cc-link">Chat now →</span>
    </a>
    <a href="https://www.instagram.com/itc_melody_99/" target="_blank" class="cc rv" style="--d:2">
      <div class="cc-ico" style="background:rgba(225,48,108,.1);border:1px solid rgba(225,48,108,.2)">📸</div>
      <h4>Instagram</h4>
      <p>Follow for updates & demos</p>
      <span class="cc-link">@itc_melody_99 →</span>
    </a>
    <a href="https://www.tiktok.com/@melodiz009" target="_blank" class="cc rv" style="--d:3">
      <div class="cc-ico" style="background:rgba(255,0,80,.08);border:1px solid rgba(255,0,80,.18)">🎵</div>
      <h4>TikTok</h4>
      <p>Tutorials & feature previews</p>
      <span class="cc-link">@melodiz009 →</span>
    </a>
    <a href="https://www.youtube.com/@melody-k1z-c2l" target="_blank" class="cc rv" style="--d:4">
      <div class="cc-ico" style="background:rgba(255,0,0,.08);border:1px solid rgba(255,0,0,.18)">▶</div>
      <h4>YouTube</h4>
      <p>Full walkthrough videos</p>
      <span class="cc-link">Watch →</span>
    </a>
  </div>
</section>


<!-- ════ FOOTER ════ -->
<footer class="footer">
  <div class="footer-brand">
    <div class="nav-mark" style="width:28px;height:28px;font-size:12px;border-radius:8px">B</div>
    BizFlow
  </div>
  <p>© <?= date('Y') ?> BizFlow · Business Workflow & Team Management</p>
  <div class="footer-links">
    <a href="<?= $loginUrl ?>">Sign in</a>
    <a href="<?= $signupUrl ?>">Sign up</a>
    <a href="#contact">Contact</a>
  </div>
</footer>

</div><!-- /site-wrap -->

<script>
(function(){
'use strict';

/* ══════════════════════════════════════════
   1. WEBGL SHADER — cinematic fluid noise
   Mouse-reactive, dual color palette (dark)
══════════════════════════════════════════ */
(function(){
  const cv = document.getElementById('gl-canvas');
  if(!cv) return;
  const gl = cv.getContext('webgl') || cv.getContext('experimental-webgl');
  if(!gl) return;

  const resize = () => {
    cv.width  = window.innerWidth;
    cv.height = window.innerHeight;
    gl.viewport(0,0,cv.width,cv.height);
  };
  resize();
  window.addEventListener('resize', resize, {passive:true});

  const vs = `attribute vec2 p;void main(){gl_Position=vec4(p,0,1);}`;
  const fs = `
    precision highp float;
    uniform vec2 u_r,u_m;
    uniform float u_t;

    float h(vec2 p){
      vec2 k=vec2(127.1,311.7);
      p=fract(p*k+vec2(23.4,67.1));
      p+=dot(p,p+34.23);
      return fract(p.x*p.y);
    }
    float n(vec2 p){
      vec2 i=floor(p),f=fract(p);
      f=f*f*(3.-2.*f);
      return mix(
        mix(h(i),h(i+vec2(1,0)),f.x),
        mix(h(i+vec2(0,1)),h(i+vec2(1,1)),f.x),f.y);
    }
    float fbm(vec2 p){
      float v=0.,a=.5;
      for(int i=0;i<6;i++){v+=a*n(p);p=p*2.1+vec2(1.7,9.2);a*=.5;}
      return v;
    }

    vec3 pal(float t){
      /* deep midnight: indigo → violet → blue */
      vec3 a=vec3(.03,.05,.12);
      vec3 b=vec3(.04,.04,.10);
      vec3 c=vec3(.20,.14,.38);
      vec3 d=vec3(.00,.22,.55);
      return a+b*cos(6.2832*(c*t+d));
    }

    void main(){
      vec2 uv=gl_FragCoord.xy/u_r;
      uv.x*=u_r.x/u_r.y;

      vec2 mouse=u_m/u_r;
      mouse.x*=u_r.x/u_r.y;

      float t=u_t*.12;

      /* domain warping — 3 layers */
      vec2 q=vec2(fbm(uv+t*.8),fbm(uv+vec2(5.2,1.3)+t*.6));
      vec2 r=vec2(fbm(uv+4.*q+vec2(1.7,9.2)+t*.4),
                  fbm(uv+4.*q+vec2(8.3,2.8)+t*.3));
      vec2 s=vec2(fbm(uv+4.*r+vec2(3.1,4.7)+t*.2),
                  fbm(uv+4.*r+vec2(7.2,1.1)+t*.18));

      float f=fbm(uv+3.*s);

      /* mouse ripple */
      float md=length(uv-mouse);
      f+=.18*exp(-md*3.)*sin(u_t*2.+md*8.);

      /* aurora ring */
      float ring=sin(length(uv-.5)*12.-u_t*1.4)*.5+.5;
      f=mix(f,ring,.05);

      f=clamp(f,0.,1.);
      vec3 col=pal(f+t*.3);

      /* vignette */
      vec2 vc=uv-vec2(.5*u_r.x/u_r.y,.5);
      float vig=1.-smoothstep(.4,1.4,length(vc));
      col*=vig*.85+.15;

      /* center glow */
      col+=vec3(.02,.03,.08)*exp(-length(vc)*2.5);

      gl_FragColor=vec4(col,1.);
    }
  `;

  const mkS = (t,s) => {
    const sh=gl.createShader(t);
    gl.shaderSource(sh,s);gl.compileShader(sh);return sh;
  };
  const pr=gl.createProgram();
  gl.attachShader(pr,mkS(gl.VERTEX_SHADER,vs));
  gl.attachShader(pr,mkS(gl.FRAGMENT_SHADER,fs));
  gl.linkProgram(pr);gl.useProgram(pr);

  const buf=gl.createBuffer();
  gl.bindBuffer(gl.ARRAY_BUFFER,buf);
  gl.bufferData(gl.ARRAY_BUFFER,new Float32Array([-1,-1,3,-1,-1,3]),gl.STATIC_DRAW);
  const ap=gl.getAttribLocation(pr,'p');
  gl.enableVertexAttribArray(ap);
  gl.vertexAttribPointer(ap,2,gl.FLOAT,false,0,0);

  const ur=gl.getUniformLocation(pr,'u_r');
  const ut=gl.getUniformLocation(pr,'u_t');
  const um=gl.getUniformLocation(pr,'u_m');

  let mx=window.innerWidth*.5, my=window.innerHeight*.5;
  let tx=mx,ty=my;
  document.addEventListener('mousemove',e=>{tx=e.clientX;ty=e.clientY},{passive:true});

  const t0=performance.now();
  const tick=now=>{
    mx+=(tx-mx)*.05; my+=(ty-my)*.05;
    gl.uniform2f(ur,cv.width,cv.height);
    gl.uniform1f(ut,(now-t0)*.001);
    gl.uniform2f(um,mx,cv.height-my);
    gl.drawArrays(gl.TRIANGLES,0,3);
    requestAnimationFrame(tick);
  };
  requestAnimationFrame(tick);
})();


/* ══════════════════════════════════════════
   2. PARTICLE SYSTEM — 120 nodes, neural net
══════════════════════════════════════════ */
(function(){
  const cv=document.getElementById('pt-canvas');
  if(!cv) return;
  const ctx=cv.getContext('2d');
  const N=120;
  let W=window.innerWidth, H=window.innerHeight;
  let mx=W*.5, my=H*.5;

  const resize=()=>{
    cv.width=W=window.innerWidth;
    cv.height=H=window.innerHeight;
  };
  resize();
  window.addEventListener('resize',resize,{passive:true});
  document.addEventListener('mousemove',e=>{mx=e.clientX;my=e.clientY},{passive:true});

  const pts=Array.from({length:N},()=>({
    x:Math.random()*W, y:Math.random()*H,
    vx:(Math.random()-.5)*.3, vy:(Math.random()-.5)*.3,
    r:Math.random()*1.6+.3,
    a:Math.random()*.5+.08,
    hue:Math.random()*60+210,
    ph:Math.random()*Math.PI*2,
  }));

  const draw=()=>{
    ctx.clearRect(0,0,W,H);
    const t=performance.now()*.001;

    pts.forEach(p=>{
      p.ph+=.012;
      p.x+=p.vx+Math.sin(p.ph)*.12;
      p.y+=p.vy+Math.cos(p.ph*.7)*.1;
      if(p.x<-10)p.x=W+10;
      if(p.x>W+10)p.x=-10;
      if(p.y<-10)p.y=H+10;
      if(p.y>H+10)p.y=-10;

      const dx=mx-p.x, dy=my-p.y;
      const d=Math.sqrt(dx*dx+dy*dy);
      const glow=d<180?(1-d/180)*1.8:0;
      const alpha=Math.min(p.a*(0.6+.4*Math.sin(p.ph))+glow*.35,1);

      ctx.beginPath();
      ctx.arc(p.x,p.y,p.r*(1+glow*.4),0,Math.PI*2);
      ctx.fillStyle=`hsla(${p.hue+glow*25},75%,72%,${alpha})`;
      ctx.fill();
    });

    /* connection lines — neural net style */
    for(let i=0;i<pts.length;i++){
      for(let j=i+1;j<pts.length;j++){
        const a=pts[i],b=pts[j];
        const dx=a.x-b.x, dy=a.y-b.y;
        const d=Math.sqrt(dx*dx+dy*dy);
        if(d<120){
          const alpha=(1-d/120)*.1;
          ctx.beginPath();
          ctx.moveTo(a.x,a.y);
          ctx.lineTo(b.x,b.y);
          ctx.strokeStyle=`rgba(124,58,237,${alpha})`;
          ctx.lineWidth=.5;
          ctx.stroke();
        }
      }
    }
    requestAnimationFrame(draw);
  };
  draw();
})();


/* ══════════════════════════════════════════
   3. CINEMATIC INTRO — staggered word reveal
══════════════════════════════════════════ */
(function(){
  const words = document.querySelectorAll('.hero-h .word');
  words.forEach((w,i)=>{
    w.style.opacity='0';
    w.style.transform='translateY(40px)';
    w.style.transition=`opacity .8s cubic-bezier(.22,1,.36,1) ${.5+i*.15}s, transform .8s cubic-bezier(.22,1,.36,1) ${.5+i*.15}s`;
    requestAnimationFrame(()=>{
      w.style.opacity='1';
      w.style.transform='none';
    });
  });
})();


/* ══════════════════════════════════════════
   4. SCROLL REVEAL  with IntersectionObserver
══════════════════════════════════════════ */
(function(){
  const io=new IntersectionObserver((entries)=>{
    entries.forEach(e=>{
      if(!e.isIntersecting)return;
      const el=e.target;
      const delay=parseFloat(el.style.getPropertyValue('--d')||'0')*90;
      setTimeout(()=>el.classList.add('in'),delay);
      io.unobserve(el);
    });
  },{threshold:.1});

  document.querySelectorAll('.rv,.bc,.tl-step,.sc-wrap,.cc').forEach(el=>io.observe(el));
})();


/* ══════════════════════════════════════════
   5. NAV — pill → full bar on scroll
══════════════════════════════════════════ */
(function(){
  const nav=document.getElementById('siteNav');
  let last=0;
  window.addEventListener('scroll',()=>{
    const y=window.scrollY;
    nav.classList.toggle('docked',y>80);
    last=y;
  },{passive:true});
})();


/* ══════════════════════════════════════════
   6. MAGNETIC BUTTONS
══════════════════════════════════════════ */
document.querySelectorAll('.btn-primary,.btn-ghost,.btn-outline').forEach(btn=>{
  btn.addEventListener('mousemove',e=>{
    const r=btn.getBoundingClientRect();
    const x=(e.clientX-r.left-r.width/2)*.14;
    const y=(e.clientY-r.top-r.height/2)*.14;
    btn.style.transform=`translate(${x}px,${y}px)`;
  });
  btn.addEventListener('mouseleave',()=>{btn.style.transform='';});
});


/* ══════════════════════════════════════════
   7. BENTO CARD — cursor spotlight
══════════════════════════════════════════ */
document.querySelectorAll('.bc').forEach(card=>{
  card.addEventListener('mousemove',e=>{
    const r=card.getBoundingClientRect();
    const x=e.clientX-r.left, y=e.clientY-r.top;
    card.style.background=`radial-gradient(220px circle at ${x}px ${y}px, rgba(124,58,237,.08), rgba(255,255,255,.03) 60%)`;
  });
  card.addEventListener('mouseleave',()=>{card.style.background='';});
});


/* ══════════════════════════════════════════
   8. SCREENSHOT CAROUSEL — auto-cycle preview
══════════════════════════════════════════ */
(function(){
  const imgs=[
    '<?= $screen1 ?>',
    '<?= $screen2 ?>',
    '<?= $screen3 ?>',
  ];
  const el=document.getElementById('previewImg');
  if(!el||imgs.length<2) return;
  let idx=0;
  setInterval(()=>{
    el.style.opacity='0';
    el.style.transform='scale(1.03)';
    setTimeout(()=>{
      idx=(idx+1)%imgs.length;
      el.src=imgs[idx];
      el.style.opacity='1';
      el.style.transform='scale(1)';
    },400);
  },3500);
  el.style.transition='opacity .4s ease, transform .4s ease';
})();


/* ══════════════════════════════════════════
   9. SCREENSHOT click to cycle images
══════════════════════════════════════════ */
(function(){
  const maps={
    0:['<?= $screen1 ?>','<?= $screen2 ?>','<?= $screen3 ?>'],
    1:['<?= $screen2 ?>','<?= $screen3 ?>','<?= $screen1 ?>'],
    2:['<?= $screen3 ?>','<?= $screen1 ?>','<?= $screen2 ?>'],
  };
  document.querySelectorAll('.sc-wrap').forEach((wrap,i)=>{
    const img=wrap.querySelector('img');
    if(!img)return;
    let idx=0;
    wrap.style.cursor='pointer';
    wrap.addEventListener('click',()=>{
      idx=(idx+1)%3;
      img.style.opacity='0';
      setTimeout(()=>{
        img.src=maps[i][idx];
        img.style.opacity='1';
      },250);
      if(!img.style.transition) img.style.transition='opacity .25s';
    });

    /* tooltip hint */
    const tip=document.createElement('div');
    tip.textContent='Click to cycle ↻';
    Object.assign(tip.style,{
      position:'absolute',top:'12px',right:'12px',
      background:'rgba(2,8,23,.8)',backdropFilter:'blur(12px)',
      border:'1px solid rgba(255,255,255,.1)',
      borderRadius:'8px',padding:'4px 10px',
      fontSize:'11px',fontWeight:'600',color:'rgba(255,255,255,.7)',
      opacity:'0',transition:'opacity .3s',pointerEvents:'none',zIndex:'3',
    });
    wrap.appendChild(tip);
    wrap.addEventListener('mouseenter',()=>tip.style.opacity='1');
    wrap.addEventListener('mouseleave',()=>tip.style.opacity='0');
  });
})();

})();
</script>
</body>
</html>