<?php
$this->title = 'Owner Dashboard';
$user        = Yii::$app->user->identity;
$username    = $user->username ?? 'Owner';

$totalBusinesses = isset($businesses) ? count($businesses) : 0;
$totalBranches   = isset($branches)   ? count($branches)   : 0;
$totalSellers    = $totalSellers      ?? 0;

/* greeting by hour */
$hour = (int) date('H');
$greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
?>

<!-- ╔══════════════════════════════════════════╗
     ║  OWNER DASHBOARD  —  BizFlow Pro Max    ║
     ╚══════════════════════════════════════════╝ -->

<div class="od-wrap" id="odWrap">

  <!-- ── HERO BANNER ── -->
  <div class="od-hero" id="odHero">

    <!-- animated mesh gradient -->
    <canvas id="heroCanvas" class="od-hero__canvas"></canvas>

    <!-- floating orbs -->
    <div class="od-orb od-orb--1"></div>
    <div class="od-orb od-orb--2"></div>
    <div class="od-orb od-orb--3"></div>

    <!-- grid overlay -->
    <div class="od-hero__grid"></div>

    <div class="od-hero__body">

      <div class="od-hero__left">

        <div class="od-hero__eyebrow">
          <span class="od-live-dot"></span>
          Live Dashboard
        </div>

        <h1 class="od-hero__title">
          <?= $greeting ?>,<br>
          <span class="od-grad"><?= htmlspecialchars($username) ?> 👋</span>
        </h1>

        <p class="od-hero__sub">
          Manage your businesses, branches &amp; sellers from one centralized command center.
        </p>

        <div class="od-hero__actions">
          <a href="analytics" class="od-btn od-btn--primary">
            <svg viewBox="0 0 20 20" fill="currentColor"><path d="M10 3a7 7 0 100 14A7 7 0 0010 3zm1 7.414l2.293 2.293-1.414 1.414L9.586 11H7V9h2.586l1.414-1.414z"/></svg>
            View Reports
          </a>
          <a href="#" class="od-btn od-btn--ghost">
            <svg viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a8 8 0 110 16A8 8 0 0110 2zm1 4H9v5h2V6zm0 6H9v2h2v-2z"/></svg>
            Quick Guide
          </a>
        </div>

      </div>

      <div class="od-hero__right">
        <!-- animated stat rings -->
        <div class="od-rings">
          <div class="od-ring od-ring--outer">
            <div class="od-ring__label">Businesses<br><strong><?= $totalBusinesses ?></strong></div>
          </div>
          <div class="od-ring od-ring--mid">
            <div class="od-ring__label">Branches<br><strong><?= $totalBranches ?></strong></div>
          </div>
          <div class="od-ring od-ring--inner">
            <div class="od-ring__label">Sellers<br><strong><?= $totalSellers ?></strong></div>
          </div>
        </div>
      </div>

    </div>

  </div><!-- /od-hero -->


  <!-- ── STAT CARDS ── -->
  <div class="od-stats" id="odStats">

    <div class="od-stat od-stat--blue od-reveal" style="--i:0">
      <div class="od-stat__glow"></div>
      <div class="od-stat__icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
          <path d="M3 21V7a2 2 0 012-2h5v16M10 21V3h9a2 2 0 012 2v16"/>
          <path d="M14 9h2M14 13h2M14 17h2M6 9h2M6 13h2M6 17h2"/>
        </svg>
      </div>
      <div class="od-stat__body">
        <div class="od-stat__value" data-target="<?= $totalBusinesses ?>">0</div>
        <div class="od-stat__label">Total Businesses</div>
      </div>
      <div class="od-stat__trend">
        <svg viewBox="0 0 20 20" fill="currentColor"><path d="M12 7l-5 5 1.41 1.41L12 9.83l4.59 4.58L18 13z"/></svg>
        Active
      </div>
    </div>

    <div class="od-stat od-stat--emerald od-reveal" style="--i:1">
      <div class="od-stat__glow"></div>
      <div class="od-stat__icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
          <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
      </div>
      <div class="od-stat__body">
        <div class="od-stat__value" data-target="<?= $totalBranches ?>">0</div>
        <div class="od-stat__label">Total Branches</div>
      </div>
      <div class="od-stat__trend">
        <svg viewBox="0 0 20 20" fill="currentColor"><path d="M12 7l-5 5 1.41 1.41L12 9.83l4.59 4.58L18 13z"/></svg>
        Running
      </div>
    </div>

    <div class="od-stat od-stat--violet od-reveal" style="--i:2">
      <div class="od-stat__glow"></div>
      <div class="od-stat__icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
          <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
        </svg>
      </div>
      <div class="od-stat__body">
        <div class="od-stat__value" data-target="<?= $totalSellers ?>">0</div>
        <div class="od-stat__label">Total Sellers</div>
      </div>
      <div class="od-stat__trend">
        <svg viewBox="0 0 20 20" fill="currentColor"><path d="M12 7l-5 5 1.41 1.41L12 9.83l4.59 4.58L18 13z"/></svg>
        Online
      </div>
    </div>

    <div class="od-stat od-stat--amber od-reveal" style="--i:3">
      <div class="od-stat__glow"></div>
      <div class="od-stat__icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
          <line x1="12" y1="1" x2="12" y2="23"/>
          <path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
        </svg>
      </div>
      <div class="od-stat__body">
        <div class="od-stat__value od-stat__value--tshs">0</div>
        <div class="od-stat__label">Plan the Cash across branches</div>
      </div>
      <div class="od-stat__trend">
        <svg viewBox="0 0 20 20" fill="currentColor"><path d="M12 7l-5 5 1.41 1.41L12 9.83l4.59 4.58L18 13z"/></svg>
        +12.4%
      </div>
    </div>

  </div><!-- /od-stats -->


  <!-- ── ACTIVITY CHART + RECENT BUSINESSES ── -->
  <div class="od-row od-row--chart">

    <!-- SPARKLINE CHART PANEL -->
    <div class="od-panel od-panel--chart od-reveal" style="--i:0">
      <div class="od-panel__head">
        <div>
          <h3 class="od-panel__title">Sales Activity</h3>
          <p class="od-panel__sub">Last 7 days performance</p>
        </div>
        <div class="od-tabs">
          <button class="od-tab od-tab--active" data-period="7">7D</button>
          <button class="od-tab" data-period="30">30D</button>
          <button class="od-tab" data-period="90">90D</button>
        </div>
      </div>
      <div class="od-chart-wrap">
        <canvas id="salesChart"></canvas>
      </div>
    </div>

    <!-- RECENT BUSINESSES -->
    <div class="od-panel od-reveal" style="--i:1">
      <div class="od-panel__head">
        <div>
          <h3 class="od-panel__title">Recent Businesses</h3>
          <p class="od-panel__sub"><?= $totalBusinesses ?> total registered</p>
        </div>
        <a href="#" class="od-link-btn">View all →</a>
      </div>

      <div class="od-list" id="bizList">
        <?php if (!empty($businesses)): ?>
          <?php foreach ($businesses as $idx => $biz): ?>
            <div class="od-list__item od-reveal" style="--i:<?= $idx ?>">
              <div class="od-list__avatar od-list__avatar--blue">
                <?= strtoupper(substr($biz->name, 0, 1)) ?>
              </div>
              <div class="od-list__body">
                <div class="od-list__name"><?= htmlspecialchars($biz->name) ?></div>
                <div class="od-list__meta">Business</div>
              </div>
              <span class="od-badge od-badge--green">Active</span>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="od-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
            <p>No businesses yet.<br><a href="#">Add your first →</a></p>
          </div>
        <?php endif; ?>
      </div>
    </div>

  </div><!-- /od-row--chart -->


  <!-- ── RECENT BRANCHES + QUICK ACTIONS ── -->
  <div class="od-row od-row--2col">

    <!-- RECENT BRANCHES -->
    <div class="od-panel od-reveal" style="--i:0">
      <div class="od-panel__head">
        <div>
          <h3 class="od-panel__title">Recent Branches</h3>
          <p class="od-panel__sub"><?= $totalBranches ?> total active</p>
        </div>
        <a href="#" class="od-link-btn">View all →</a>
      </div>

      <div class="od-list">
        <?php if (!empty($branches)): ?>
          <?php foreach ($branches as $idx => $branch): ?>
            <div class="od-list__item od-reveal" style="--i:<?= $idx ?>">
              <div class="od-list__avatar od-list__avatar--violet">
                <?= strtoupper(substr($branch->name, 0, 1)) ?>
              </div>
              <div class="od-list__body">
                <div class="od-list__name"><?= htmlspecialchars($branch->name) ?></div>
                <div class="od-list__meta">Branch</div>
              </div>
              <span class="od-badge od-badge--violet">Branch</span>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="od-empty">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
            <p>No branches yet.<br><a href="#">Add your first →</a></p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <!-- QUICK ACTIONS -->
    <div class="od-panel od-reveal" style="--i:1">
      <div class="od-panel__head">
        <div>
          <h3 class="od-panel__title">Quick Actions</h3>
          <p class="od-panel__sub">Jump to common tasks</p>
        </div>
      </div>

      <div class="od-actions-grid">

        <a href="business/index" class="od-action od-action--blue">
          <div class="od-action__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 5v14M5 12h14"/></svg>
          </div>
          <span>Add Business</span>
        </a>

        <a href="branch/index" class="od-action od-action--emerald">
          <div class="od-action__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
          </div>
          <span>Add Branch</span>
        </a>

        <a href="owner/sellers" class="od-action od-action--violet">
          <div class="od-action__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>
          </div>
          <span>Add Seller</span>
        </a>

        <a href="analytics" class="od-action od-action--amber">
          <div class="od-action__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
          </div>
          <span>Reports</span>
        </a>

        <a href="#" class="od-action od-action--rose">
          <div class="od-action__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
          </div>
          <span>Search</span>
        </a>

        <a href="#" class="od-action od-action--teal">
          <div class="od-action__icon">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 010 14.14M4.93 4.93a10 10 0 000 14.14"/></svg>
          </div>
          <span>Settings</span>
        </a>

      </div>
    </div>

  </div><!-- /od-row--2col -->

</div><!-- /od-wrap -->


<!-- ══════════════════════════════════════════════════
     STYLES
══════════════════════════════════════════════════ -->
<style>

/* ── TOKENS ── */
:root {
  --od-blue:    #3B82F6;
  --od-blue2:   #1D4ED8;
  --od-violet:  #7C3AED;
  --od-violet2: #5B21B6;
  --od-emerald: #10B981;
  --od-amber:   #F59E0B;
  --od-rose:    #F43F5E;
  --od-teal:    #14B8A6;
  --od-r:10s;
}

/* ── LAYOUT ── */
.od-wrap {
  padding: 24px 28px 40px;
  display: flex;
  flex-direction: column;
  gap: 24px;
}

/* ─────────────────────────────────────────
   HERO BANNER
───────────────────────────────────────── */
.od-hero {
  position: relative;
  border-radius: 24px;
  overflow: hidden;
  min-height: 260px;
  background: #060B18;
  border: 1px solid rgba(255,255,255,.07);
  display: flex;
  align-items: stretch;
}

.od-hero__canvas {
  position: absolute;
  inset: 0;
  width: 100%; height: 100%;
  pointer-events: none;
  z-index: 0;
}

.od-orb {
  position: absolute;
  border-radius: 50%;
  filter: blur(80px);
  pointer-events: none;
  z-index: 0;
  animation: odOrb var(--od-r) ease-in-out infinite alternate;
}
.od-orb--1 { width:380px;height:380px;background:rgba(59,130,246,.18); top:-120px;left:-80px; --od-r:9s; }
.od-orb--2 { width:300px;height:300px;background:rgba(124,58,237,.16); bottom:-80px;right:80px; --od-r:12s; }
.od-orb--3 { width:200px;height:200px;background:rgba(16,185,129,.1);  top:60px;right:300px;   --od-r:7s; }
@keyframes odOrb {
  from { transform: scale(1)   translateY(0); }
  to   { transform: scale(1.3) translateY(-20px); }
}

.od-hero__grid {
  position: absolute; inset: 0; z-index: 0;
  background-image:
    linear-gradient(rgba(255,255,255,.03) 1px, transparent 1px),
    linear-gradient(90deg, rgba(255,255,255,.03) 1px, transparent 1px);
  background-size: 48px 48px;
  mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black, transparent);
}

.od-hero__body {
  position: relative; z-index: 2;
  display: flex;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  padding: 40px 44px;
  gap: 32px;
}

.od-hero__eyebrow {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 5px 14px; border-radius: 999px;
  background: rgba(59,130,246,.12);
  border: 1px solid rgba(59,130,246,.25);
  font-size: 12px; font-weight: 600; color: #93C5FD;
  letter-spacing: .06em; text-transform: uppercase;
  margin-bottom: 18px;
  animation: fadeUp .6s ease both;
}

.od-live-dot {
  width: 7px; height: 7px; border-radius: 50%;
  background: #3B82F6;
  box-shadow: 0 0 8px #3B82F6;
  animation: livePulse 1.8s ease-in-out infinite;
}
@keyframes livePulse {
  0%,100%{transform:scale(1);opacity:1}
  50%{transform:scale(1.6);opacity:.5}
}

.od-hero__title {
  font-size: clamp(24px, 2.8vw, 40px);
  font-weight: 800;
  line-height: 1.15;
  color: #fff;
  margin: 0 0 14px;
  animation: fadeUp .7s ease both .1s;
}

.od-grad {
  background: linear-gradient(90deg, #60A5FA, #A78BFA, #34D399);
  -webkit-background-clip: text; -webkit-text-fill-color: transparent;
  background-clip: text;
}

.od-hero__sub {
  font-size: 15px; color: #94A3B8; line-height: 1.65;
  max-width: 460px; margin: 0 0 28px;
  animation: fadeUp .7s ease both .2s;
}

.od-hero__actions {
  display: flex; gap: 12px; flex-wrap: wrap;
  animation: fadeUp .7s ease both .3s;
}

@keyframes fadeUp {
  from { opacity:0; transform:translateY(18px); }
  to   { opacity:1; transform:translateY(0); }
}

/* BUTTONS */
.od-btn {
  display: inline-flex; align-items: center; gap: 8px;
  padding: 10px 22px; border-radius: 11px;
  font-size: 13px; font-weight: 600;
  text-decoration: none; cursor: pointer;
  transition: all .22s;
}
.od-btn svg { width:16px;height:16px }

.od-btn--primary {
  background: linear-gradient(135deg, #3B82F6, #7C3AED);
  color: #fff;
  box-shadow: 0 4px 20px rgba(124,58,237,.35);
}
.od-btn--primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(124,58,237,.5);
}

.od-btn--ghost {
  background: rgba(255,255,255,.07);
  border: 1px solid rgba(255,255,255,.14);
  color: #fff;
}
.od-btn--ghost:hover { background: rgba(255,255,255,.13); transform: translateY(-2px); }

/* RINGS (hero right) */
.od-hero__right {
  flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
}

.od-rings {
  position: relative;
  width: 200px; height: 200px;
  display: flex; align-items: center; justify-content: center;
}

.od-ring {
  position: absolute;
  border-radius: 50%;
  display: flex; align-items: center; justify-content: center;
  animation: spinRing linear infinite;
}

.od-ring--outer {
  width: 200px; height: 200px;
  border: 1.5px solid rgba(59,130,246,.35);
  animation-duration: 18s;
}
.od-ring--mid {
  width: 148px; height: 148px;
  border: 1.5px solid rgba(124,58,237,.35);
  animation-duration: 12s;
  animation-direction: reverse;
}
.od-ring--inner {
  width: 96px; height: 96px;
  border: 1.5px solid rgba(16,185,129,.35);
  animation-duration: 8s;
}

@keyframes spinRing {
  from { transform: rotate(0deg); }
  to   { transform: rotate(360deg); }
}

.od-ring__label {
  position: absolute;
  top: 50%; left: 50%;
  transform: translate(-50%, -50%) !important;
  font-size: 10px; color: #94A3B8; text-align: center; line-height: 1.4;
  animation: none; /* counter the spin */
  white-space: nowrap;
}

.od-ring--outer .od-ring__label { color: #93C5FD; font-size: 9px; top: 8px; left: 50%; transform: translate(-50%,0) !important; }
.od-ring--mid  .od-ring__label { color: #C4B5FD; font-size: 9px; top: 8px; left: 50%; transform: translate(-50%,0) !important; }
.od-ring--inner .od-ring__label {
  top: 50%; left: 50%;
  transform: translate(-50%,-50%) !important;
  color: #6EE7B7; font-size: 9px;
}

.od-ring strong { display: block; font-size: 18px; font-weight: 800; color: #fff; }


/* ─────────────────────────────────────────
   STAT CARDS
───────────────────────────────────────── */
.od-stats {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 16px;
}

.od-stat {
  position: relative; overflow: hidden;
  border-radius: 20px; padding: 24px;
  border: 1px solid rgba(255,255,255,.07);
  background: var(--card-bg, rgba(255,255,255,.04));
  backdrop-filter: blur(20px);
  display: flex; align-items: center; gap: 18px;
  cursor: pointer;
  transition: transform .3s, box-shadow .3s, border-color .3s;
}
.od-stat:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 50px rgba(0,0,0,.3);
}

.od-stat__glow {
  position: absolute; inset: 0; border-radius: 20px; pointer-events: none;
  opacity: 0; transition: opacity .4s;
}
.od-stat:hover .od-stat__glow { opacity: 1; }

.od-stat--blue   { border-color: rgba(59,130,246,.2);  }
.od-stat--blue   .od-stat__glow { background: radial-gradient(circle at 30% 40%, rgba(59,130,246,.12), transparent 65%); }
.od-stat--blue   .od-stat__icon { background: rgba(59,130,246,.15); color: #60A5FA; }
.od-stat--blue   .od-stat__value { color: #60A5FA; }
.od-stat--blue   .od-stat__trend { color: #60A5FA; background: rgba(59,130,246,.12); }

.od-stat--emerald { border-color: rgba(16,185,129,.2); }
.od-stat--emerald .od-stat__glow { background: radial-gradient(circle at 30% 40%, rgba(16,185,129,.12), transparent 65%); }
.od-stat--emerald .od-stat__icon { background: rgba(16,185,129,.15); color: #34D399; }
.od-stat--emerald .od-stat__value { color: #34D399; }
.od-stat--emerald .od-stat__trend { color: #34D399; background: rgba(16,185,129,.12); }

.od-stat--violet  { border-color: rgba(124,58,237,.2); }
.od-stat--violet  .od-stat__glow { background: radial-gradient(circle at 30% 40%, rgba(124,58,237,.12), transparent 65%); }
.od-stat--violet  .od-stat__icon { background: rgba(124,58,237,.15); color: #C4B5FD; }
.od-stat--violet  .od-stat__value { color: #C4B5FD; }
.od-stat--violet  .od-stat__trend { color: #C4B5FD; background: rgba(124,58,237,.12); }

.od-stat--amber   { border-color: rgba(245,158,11,.2); }
.od-stat--amber   .od-stat__glow { background: radial-gradient(circle at 30% 40%, rgba(245,158,11,.12), transparent 65%); }
.od-stat--amber   .od-stat__icon { background: rgba(245,158,11,.15); color: #FCD34D; }
.od-stat--amber   .od-stat__value { color: #FCD34D; }
.od-stat--amber   .od-stat__trend { color: #FCD34D; background: rgba(245,158,11,.12); }

.od-stat__icon {
  width: 52px; height: 52px; border-radius: 15px; flex-shrink: 0;
  display: flex; align-items: center; justify-content: center;
  transition: transform .3s;
}
.od-stat:hover .od-stat__icon { transform: scale(1.1) rotate(-6deg); }
.od-stat__icon svg { width: 24px; height: 24px; }

.od-stat__body { flex: 1 }
.od-stat__value {
  font-size: 34px; font-weight: 900; line-height: 1;
  font-variant-numeric: tabular-nums;
  margin-bottom: 4px;
}
.od-stat__label { font-size: 13px; color: var(--text-muted, #94A3B8); }

.od-stat__trend {
  display: flex; align-items: center; gap: 4px;
  padding: 5px 10px; border-radius: 8px;
  font-size: 12px; font-weight: 600; white-space: nowrap;
  align-self: flex-start;
}
.od-stat__trend svg { width: 14px; height: 14px; }


/* ─────────────────────────────────────────
   PANEL
───────────────────────────────────────── */
.od-panel {
  background: var(--card-bg, rgba(255,255,255,.04));
  border: 1px solid var(--border, rgba(255,255,255,.08));
  backdrop-filter: blur(20px);
  border-radius: 20px; padding: 24px;
  transition: border-color .3s;
}
.od-panel:hover { border-color: rgba(255,255,255,.14); }

.od-panel__head {
  display: flex; align-items: flex-start;
  justify-content: space-between; gap: 12px;
  margin-bottom: 20px;
}
.od-panel__title {
  font-size: 16px; font-weight: 700;
  color: var(--text, #fff); margin: 0 0 4px;
}
.od-panel__sub { font-size: 13px; color: var(--text-muted, #94A3B8); margin: 0; }
.od-link-btn {
  font-size: 13px; font-weight: 600;
  color: var(--od-blue); text-decoration: none;
  white-space: nowrap; padding: 6px 14px;
  border-radius: 8px; background: rgba(59,130,246,.1);
  transition: .2s;
}
.od-link-btn:hover { background: rgba(59,130,246,.2); }


/* ─────────────────────────────────────────
   CHART
───────────────────────────────────────── */
.od-panel--chart { flex: 1.6; }
.od-chart-wrap { position: relative; height: 210px; }
.od-chart-wrap canvas { width: 100% !important; height: 100% !important; }

.od-tabs { display: flex; gap: 4px; }
.od-tab {
  padding: 5px 12px; border-radius: 8px; border: none;
  background: rgba(255,255,255,.05);
  color: var(--text-muted, #94A3B8);
  font-size: 12px; font-weight: 600; cursor: pointer; transition: .2s;
}
.od-tab--active,
.od-tab:hover {
  background: rgba(59,130,246,.18); color: #60A5FA;
}


/* ─────────────────────────────────────────
   LISTS
───────────────────────────────────────── */
.od-list { display: flex; flex-direction: column; gap: 6px; }

.od-list__item {
  display: flex; align-items: center; gap: 14px;
  padding: 12px 14px; border-radius: 13px;
  border: 1px solid transparent;
  transition: all .25s; cursor: pointer;
}
.od-list__item:hover {
  background: rgba(255,255,255,.05);
  border-color: rgba(255,255,255,.08);
  transform: translateX(4px);
}

.od-list__avatar {
  width: 40px; height: 40px; border-radius: 12px;
  display: flex; align-items: center; justify-content: center;
  font-size: 15px; font-weight: 800; flex-shrink: 0;
}
.od-list__avatar--blue   { background: rgba(59,130,246,.18); color: #60A5FA; }
.od-list__avatar--violet { background: rgba(124,58,237,.18); color: #C4B5FD; }

.od-list__body { flex: 1; min-width: 0; }
.od-list__name { font-size: 14px; font-weight: 600; color: var(--text,#fff); white-space:nowrap;overflow:hidden;text-overflow:ellipsis; }
.od-list__meta { font-size: 12px; color: var(--text-muted,#94A3B8); margin-top: 1px; }

.od-badge {
  padding: 4px 10px; border-radius: 7px;
  font-size: 11px; font-weight: 700;
  flex-shrink: 0;
}
.od-badge--green  { background: rgba(16,185,129,.14); color: #34D399; }
.od-badge--violet { background: rgba(124,58,237,.14); color: #C4B5FD; }

.od-empty {
  display: flex; flex-direction: column; align-items: center;
  gap: 12px; padding: 36px 20px;
  color: var(--text-muted, #94A3B8); text-align: center;
  font-size: 14px;
}
.od-empty svg { width: 40px; height: 40px; opacity: .3; }
.od-empty a { color: var(--od-blue); text-decoration: none; }


/* ─────────────────────────────────────────
   QUICK ACTIONS GRID
───────────────────────────────────────── */
.od-actions-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 12px;
}

.od-action {
  display: flex; flex-direction: column;
  align-items: center; justify-content: center; gap: 10px;
  padding: 20px 12px; border-radius: 16px;
  border: 1px solid rgba(255,255,255,.07);
  text-decoration: none;
  font-size: 12px; font-weight: 600;
  color: var(--text, #fff);
  transition: all .3s;
  position: relative; overflow: hidden;
  background: rgba(255,255,255,.03);
}
.od-action::before {
  content: '';
  position: absolute; inset: 0; border-radius: 16px;
  opacity: 0; transition: opacity .3s;
}
.od-action:hover { transform: translateY(-4px); }
.od-action:hover::before { opacity: 1; }

.od-action__icon {
  width: 44px; height: 44px; border-radius: 13px;
  display: flex; align-items: center; justify-content: center;
  transition: transform .3s;
}
.od-action:hover .od-action__icon { transform: scale(1.12) rotate(-5deg); }
.od-action__icon svg { width: 20px; height: 20px; }

.od-action--blue    .od-action__icon { background:rgba(59,130,246,.18); color:#60A5FA; }
.od-action--blue::before            { background: radial-gradient(circle at 50% 0%, rgba(59,130,246,.1), transparent 70%); }
.od-action--blue:hover              { border-color: rgba(59,130,246,.3); }

.od-action--emerald .od-action__icon { background:rgba(16,185,129,.18); color:#34D399; }
.od-action--emerald::before          { background: radial-gradient(circle at 50% 0%, rgba(16,185,129,.1), transparent 70%); }
.od-action--emerald:hover            { border-color: rgba(16,185,129,.3); }

.od-action--violet  .od-action__icon { background:rgba(124,58,237,.18); color:#C4B5FD; }
.od-action--violet::before           { background: radial-gradient(circle at 50% 0%, rgba(124,58,237,.1), transparent 70%); }
.od-action--violet:hover             { border-color: rgba(124,58,237,.3); }

.od-action--amber   .od-action__icon { background:rgba(245,158,11,.18); color:#FCD34D; }
.od-action--amber::before            { background: radial-gradient(circle at 50% 0%, rgba(245,158,11,.1), transparent 70%); }
.od-action--amber:hover              { border-color: rgba(245,158,11,.3); }

.od-action--rose    .od-action__icon { background:rgba(244,63,94,.18); color:#FDA4AF; }
.od-action--rose::before             { background: radial-gradient(circle at 50% 0%, rgba(244,63,94,.1), transparent 70%); }
.od-action--rose:hover               { border-color: rgba(244,63,94,.3); }

.od-action--teal    .od-action__icon { background:rgba(20,184,166,.18); color:#5EEAD4; }
.od-action--teal::before             { background: radial-gradient(circle at 50% 0%, rgba(20,184,166,.1), transparent 70%); }
.od-action--teal:hover               { border-color: rgba(20,184,166,.3); }


/* ─────────────────────────────────────────
   LAYOUT ROWS
───────────────────────────────────────── */
.od-row { display: flex; gap: 20px; }
.od-row--2col > * { flex: 1; }
.od-row--chart > .od-panel--chart { flex: 1.6; }
.od-row--chart > .od-panel:last-child { flex: 1; }


/* ─────────────────────────────────────────
   SCROLL REVEAL
───────────────────────────────────────── */
.od-reveal {
  opacity: 0;
  transform: translateY(28px);
  transition:
    opacity .6s cubic-bezier(.22,1,.36,1),
    transform .6s cubic-bezier(.22,1,.36,1);
  transition-delay: calc(var(--i, 0) * 80ms);
}
.od-reveal.od-in { opacity: 1; transform: translateY(0); }


/* ─────────────────────────────────────────
   RESPONSIVE
───────────────────────────────────────── */
@media (max-width: 1000px) {
  .od-row { flex-direction: column; }
  .od-hero__right { display: none; }
}
@media (max-width: 640px) {
  .od-wrap { padding: 16px 16px 32px; }
  .od-hero__body { padding: 28px 24px; }
  .od-stats { grid-template-columns: 1fr 1fr; }
  .od-actions-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 420px) {
  .od-stats { grid-template-columns: 1fr; }
  .od-actions-grid { grid-template-columns: repeat(2, 1fr); }
}

@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after {
    animation-duration: .01ms !important;
    transition-duration: .01ms !important;
  }
}

</style>


<!-- ══════════════════════════════════════════════════
     SCRIPTS
══════════════════════════════════════════════════ -->
<script>
(function () {

/* ── 1. HERO CANVAS — flowing gradient ── */
const hc  = document.getElementById('heroCanvas');
const hgl = hc ? (hc.getContext('webgl') || hc.getContext('experimental-webgl')) : null;

if (hgl) {
  const resize = () => {
    const r = hc.parentElement.getBoundingClientRect();
    hc.width  = r.width;
    hc.height = r.height;
    hgl.viewport(0, 0, hc.width, hc.height);
  };
  resize();
  window.addEventListener('resize', resize, { passive: true });

  const vs = `attribute vec2 p; void main(){gl_Position=vec4(p,0,1);}`;
  const fs = `
    precision mediump float;
    uniform vec2  u_r; uniform float u_t;
    float n(vec2 p){
      vec2 i=floor(p),f=fract(p);
      f=f*f*(3.-2.*f);
      float a=fract(sin(dot(i,vec2(127.1,311.7)))*43758.5);
      float b=fract(sin(dot(i+vec2(1,0),vec2(127.1,311.7)))*43758.5);
      float c=fract(sin(dot(i+vec2(0,1),vec2(127.1,311.7)))*43758.5);
      float d=fract(sin(dot(i+vec2(1,1),vec2(127.1,311.7)))*43758.5);
      return mix(mix(a,b,f.x),mix(c,d,f.x),f.y);
    }
    float fbm(vec2 p){
      float v=0.;float a=.5;
      for(int i=0;i<4;i++){v+=a*n(p);p=p*2.1;a*=.5;}
      return v;
    }
    void main(){
      vec2 uv=(gl_FragCoord.xy/u_r);
      uv.x*=u_r.x/u_r.y;
      float t=u_t*.1;
      vec2 q=vec2(fbm(uv+vec2(.0,.0)+t),fbm(uv+vec2(5.2,1.3)+t*.8));
      float f=fbm(uv+3.*q+t*.5);
      vec3 col=mix(
        vec3(.02,.04,.12),
        mix(vec3(.05,.10,.28),vec3(.12,.05,.24),f),
        clamp(f*1.5,0.,1.)
      );
      float vig=1.-smoothstep(.3,1.2,length(uv-vec2(.5*u_r.x/u_r.y,.5)));
      col*=vig*.7+.3;
      gl_FragColor=vec4(col,.85);
    }
  `;
  const mkS = (t, s) => {
    const sh = hgl.createShader(t);
    hgl.shaderSource(sh, s); hgl.compileShader(sh); return sh;
  };
  const pr = hgl.createProgram();
  hgl.attachShader(pr, mkS(hgl.VERTEX_SHADER, vs));
  hgl.attachShader(pr, mkS(hgl.FRAGMENT_SHADER, fs));
  hgl.linkProgram(pr); hgl.useProgram(pr);
  const buf = hgl.createBuffer();
  hgl.bindBuffer(hgl.ARRAY_BUFFER, buf);
  hgl.bufferData(hgl.ARRAY_BUFFER, new Float32Array([-1,-1,3,-1,-1,3]), hgl.STATIC_DRAW);
  const ap = hgl.getAttribLocation(pr, 'p');
  hgl.enableVertexAttribArray(ap);
  hgl.vertexAttribPointer(ap, 2, hgl.FLOAT, false, 0, 0);
  const ur = hgl.getUniformLocation(pr, 'u_r');
  const ut = hgl.getUniformLocation(pr, 'u_t');
  const st = performance.now();
  const tick = (now) => {
    hgl.uniform2f(ur, hc.width, hc.height);
    hgl.uniform1f(ut, (now - st) * .001);
    hgl.drawArrays(hgl.TRIANGLES, 0, 3);
    requestAnimationFrame(tick);
  };
  requestAnimationFrame(tick);
}


/* ── 2. SCROLL REVEAL ── */
const io = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (e.isIntersecting) {
      e.target.classList.add('od-in');
      io.unobserve(e.target);
    }
  });
}, { threshold: 0.1 });
document.querySelectorAll('.od-reveal').forEach(el => io.observe(el));


/* ── 3. COUNT-UP ── */
const countUp = (el, target, duration = 1400) => {
  let start = null;
  const step = (ts) => {
    if (!start) start = ts;
    const p = Math.min((ts - start) / duration, 1);
    const ease = 1 - Math.pow(1 - p, 3);
    el.textContent = Math.round(target * ease).toLocaleString();
    if (p < 1) requestAnimationFrame(step);
  };
  requestAnimationFrame(step);
};

const statObs = new IntersectionObserver((entries) => {
  entries.forEach(e => {
    if (!e.isIntersecting) return;
    statObs.unobserve(e.target);
    const v = e.target.querySelector('.od-stat__value');
    const t = parseInt(v.dataset.target || '0', 10);
    countUp(v, t);
  });
}, { threshold: 0.5 });
document.querySelectorAll('.od-stat').forEach(el => statObs.observe(el));

/* revenue card special */
const rev = document.querySelector('.od-stat__value--tshs');
if (rev) {
  const revObs = new IntersectionObserver(([e]) => {
    if (!e.isIntersecting) return;
    revObs.disconnect();
    let start = null;
    const target = 1240000;
    const step = (ts) => {
      if (!start) start = ts;
      const p = Math.min((ts - start) / 1600, 1);
      const ease = 1 - Math.pow(1 - p, 3);
      const v = Math.round(target * ease);
      rev.textContent = 'Tshs ' + v.toLocaleString();
      if (p < 1) requestAnimationFrame(step);
    };
    requestAnimationFrame(step);
  }, { threshold: 0.5 });
  revObs.observe(rev.closest('.od-stat'));
}


/* ── 4. SALES CHART (pure canvas — no lib needed) ── */
const chartCanvas = document.getElementById('salesChart');
if (chartCanvas) {
  const datasets = {
    7:  [12, 19, 9, 26, 21, 34, 29],
    30: [8,12,7,22,18,30,14,9,25,31,20,17,28,11,16,23,19,35,27,13,22,18,30,25,10,20,15,28,24,32],
    90: Array.from({length:90}, (_,i) => Math.floor(10 + Math.random()*28 + Math.sin(i/5)*8)),
  };
  let currentPeriod = 7;
  let animFrame = null;

  const draw = (data, prog = 1) => {
    const dpr = window.devicePixelRatio || 1;
    const rect = chartCanvas.parentElement.getBoundingClientRect();
    chartCanvas.width  = rect.width  * dpr;
    chartCanvas.height = rect.height * dpr;
    const ctx = chartCanvas.getContext('2d');
    ctx.scale(dpr, dpr);
    const W = rect.width, H = rect.height;
    const pad = { top: 10, right: 16, bottom: 28, left: 36 };
    const iW = W - pad.left - pad.right;
    const iH = H - pad.top  - pad.bottom;
    const max = Math.max(...data) * 1.15 || 1;
    const pts = data.map((v, i) => ({
      x: pad.left + (i / (data.length - 1)) * iW,
      y: pad.top  + iH - (v / max) * iH * prog,
    }));

    ctx.clearRect(0, 0, W, H);

    /* grid lines */
    ctx.strokeStyle = 'rgba(255,255,255,.05)';
    ctx.lineWidth = 1;
    for (let k = 0; k <= 4; k++) {
      const y = pad.top + (iH / 4) * k;
      ctx.beginPath(); ctx.moveTo(pad.left, y); ctx.lineTo(W - pad.right, y); ctx.stroke();
      ctx.fillStyle = 'rgba(148,163,184,.4)';
      ctx.font = '10px Inter, sans-serif';
      ctx.textAlign = 'right';
      ctx.fillText(Math.round(max * (1 - k/4)), pad.left - 6, y + 3);
    }

    /* fill gradient */
    const grad = ctx.createLinearGradient(0, pad.top, 0, H - pad.bottom);
    grad.addColorStop(0, 'rgba(59,130,246,.35)');
    grad.addColorStop(1, 'rgba(124,58,237,.03)');

    ctx.beginPath();
    pts.forEach((p, i) => i === 0 ? ctx.moveTo(p.x, p.y) : ctx.bezierCurveTo(
      pts[i-1].x + (p.x - pts[i-1].x) / 2, pts[i-1].y,
      pts[i-1].x + (p.x - pts[i-1].x) / 2, p.y, p.x, p.y
    ));
    ctx.lineTo(pts[pts.length-1].x, H - pad.bottom);
    ctx.lineTo(pts[0].x, H - pad.bottom);
    ctx.closePath();
    ctx.fillStyle = grad; ctx.fill();

    /* line */
    const lineGrad = ctx.createLinearGradient(0, 0, W, 0);
    lineGrad.addColorStop(0, '#3B82F6');
    lineGrad.addColorStop(1, '#7C3AED');
    ctx.beginPath();
    pts.forEach((p, i) => i === 0 ? ctx.moveTo(p.x, p.y) : ctx.bezierCurveTo(
      pts[i-1].x + (p.x - pts[i-1].x) / 2, pts[i-1].y,
      pts[i-1].x + (p.x - pts[i-1].x) / 2, p.y, p.x, p.y
    ));
    ctx.strokeStyle = lineGrad; ctx.lineWidth = 2.5;
    ctx.lineJoin = 'round'; ctx.stroke();

    /* dots */
    pts.forEach((p, i) => {
      ctx.beginPath(); ctx.arc(p.x, p.y, 4, 0, Math.PI * 2);
      ctx.fillStyle = i === pts.length - 1 ? '#7C3AED' : '#3B82F6';
      ctx.fill();
      ctx.strokeStyle = '#fff'; ctx.lineWidth = 1.5; ctx.stroke();
    });

    /* x labels */
    if (data.length <= 7) {
      const labels = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
      ctx.fillStyle = 'rgba(148,163,184,.5)';
      ctx.font = '10px Inter, sans-serif';
      ctx.textAlign = 'center';
      pts.forEach((p, i) => ctx.fillText(labels[i] || '', p.x, H - pad.bottom + 14));
    }
  };

  const animate = (data) => {
    if (animFrame) cancelAnimationFrame(animFrame);
    const start = performance.now();
    const dur = 700;
    const step = (now) => {
      const p = Math.min((now - start) / dur, 1);
      const ease = 1 - Math.pow(1 - p, 3);
      draw(data, ease);
      if (p < 1) animFrame = requestAnimationFrame(step);
    };
    animFrame = requestAnimationFrame(step);
  };

  animate(datasets[7]);
  window.addEventListener('resize', () => draw(datasets[currentPeriod]), { passive: true });

  document.querySelectorAll('.od-tab').forEach(btn => {
    btn.addEventListener('click', () => {
      document.querySelectorAll('.od-tab').forEach(b => b.classList.remove('od-tab--active'));
      btn.classList.add('od-tab--active');
      currentPeriod = parseInt(btn.dataset.period, 10);
      animate(datasets[currentPeriod]);
    });
  });
}


/* ── 5. MAGNETIC BUTTONS ── */
document.querySelectorAll('.od-btn').forEach(btn => {
  btn.addEventListener('mousemove', e => {
    const r = btn.getBoundingClientRect();
    const x = (e.clientX - r.left - r.width  / 2) * .15;
    const y = (e.clientY - r.top  - r.height / 2) * .15;
    btn.style.transform = `translate(${x}px,${y}px)`;
  });
  btn.addEventListener('mouseleave', () => { btn.style.transform = ''; });
});


/* ── 6. CARD GLOW FOLLOW MOUSE ── */
document.querySelectorAll('.od-stat, .od-action').forEach(card => {
  card.addEventListener('mousemove', e => {
    const r = card.getBoundingClientRect();
    const x = e.clientX - r.left, y = e.clientY - r.top;
    card.style.setProperty('--mx', x + 'px');
    card.style.setProperty('--my', y + 'px');
  });
});

})();
</script>
