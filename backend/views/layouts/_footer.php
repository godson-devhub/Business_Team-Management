<?php

declare(strict_types=1);

/** @var yii\web\View $this */

?>

<footer class="app-footer">

    <div class="footer-left">
        <span class="footer-copyright">© <?= date('Y') ?> Business Team</span>
        <span class="footer-separator">·</span>
        <span class="footer-system">Management System</span>
    </div>

    <div class="footer-right">
        <span class="footer-version">v1.0.0</span>
        <span class="footer-dot"></span>
        <span class="footer-status">
            <span class="status-indicator online"></span>
            All systems operational
        </span>
    </div>

</footer>

<style>
/* ============================================
   FOOTER
   ============================================ */
.app-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    
    height: 48px;
    padding: 0 24px;
    
    background: var(--surface);
    border-top: 1px solid var(--border);
    
    font-size: 12px;
    color: var(--text-muted);
    
    flex-shrink: 0;
}

.footer-left,
.footer-right {
    display: flex;
    align-items: center;
    gap: 8px;
}

.footer-copyright {
    font-weight: 500;
    color: var(--text-secondary);
}

.footer-separator {
    opacity: 0.5;
}

.footer-system {
    font-weight: 400;
}

.footer-version {
    font-family: 'JetBrains Mono', monospace;
    font-size: 11px;
    padding: 2px 8px;
    border-radius: var(--radius-sm);
    background: var(--bg-elevated);
    border: 1px solid var(--border);
}

.footer-dot {
    width: 3px;
    height: 3px;
    border-radius: 50%;
    background: var(--text-muted);
    opacity: 0.5;
}

.footer-status {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 500;
}

.status-indicator {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    position: relative;
}

.status-indicator.online {
    background: var(--success);
}

.status-indicator.online::after {
    content: '';
    position: absolute;
    inset: -2px;
    border-radius: 50%;
    border: 1px solid var(--success);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    100% { transform: scale(2); opacity: 0; }
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .app-footer {
        flex-direction: column;
        height: auto;
        padding: 12px;
        gap: 6px;
        text-align: center;
    }
    .footer-right {
        flex-wrap: wrap;
        justify-content: center;
    }
    .footer-dot {
        display: none;
    }
}
</style>