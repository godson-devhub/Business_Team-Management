<?php

declare(strict_types=1);

/** @var yii\web\View $this */

use backend\assets\AppAsset;

AppAsset::register($this);

// CSRF
$this->registerCsrfMetaTags();

// Charset
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');

// Viewport
$this->registerMetaTag([
    'name'    => 'viewport',
    'content' => 'width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no',
]);

// SEO
$this->registerMetaTag([
    'name'    => 'description',
    'content' => $this->params['meta_description'] ?? 'Business Management System — Sales, Inventory, Purchases & Analytics.',
]);
$this->registerMetaTag([
    'name'    => 'keywords',
    'content' => $this->params['meta_keywords'] ?? 'ERP, POS, Inventory, Sales, Purchase, Analytics, Business Management',
]);

// Theme Color (adapts to dark/light)
$this->registerMetaTag(['name' => 'theme-color', 'content' => '#0f172a', 'media' => '(prefers-color-scheme: dark)']);
$this->registerMetaTag(['name' => 'theme-color', 'content' => '#ffffff', 'media' => '(prefers-color-scheme: light)']);

// Favicon
$this->registerLinkTag([
    'rel'  => 'icon',
    'type' => 'image/x-icon',
    'href' => Yii::getAlias('@web/favicon.ico'),
]);

// Google Fonts — Inter + JetBrains Mono for data
$this->registerCssFile(
    'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap'
);

// Lucide Icons (modern, lightweight)
$this->registerJsFile('https://unpkg.com/lucide@latest', ['position' => \yii\web\View::POS_HEAD]);

// Global Styles
$this->registerCss("
/* ============================================
   CSS RESET & BASE
   ============================================ */
*, *::before, *::after {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

html {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    font-size: 14px;
    line-height: 1.5;
    scroll-behavior: smooth;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
}

body {
    min-height: 100vh;
    overflow-x: hidden;
    background: var(--bg);
    color: var(--text);
    transition: background-color 0.3s ease, color 0.3s ease;
}

/* ============================================
   THEME VARIABLES
   ============================================ */
:root {
    /* Sidebar */
    --sidebar-width: 260px;
    --sidebar-collapsed: 72px;
    
    /* Colors — Dark (default) */
    --bg: #0b0f19;
    --bg-secondary: #111827;
    --bg-elevated: #1a1f2e;
    --surface: #151b2b;
    --surface-hover: #1e2538;
    
    --card-bg: rgba(255,255,255,0.03);
    --card-bg-hover: rgba(255,255,255,0.05);
    
    --border: rgba(255,255,255,0.06);
    --border-strong: rgba(255,255,255,0.1);
    
    --text: #f1f5f9;
    --text-secondary: #94a3b8;
    --text-muted: #64748b;
    
    --primary: #3b82f6;
    --primary-hover: #2563eb;
    --primary-glow: rgba(59,130,246,0.3);
    
    --success: #22c55e;
    --warning: #f59e0b;
    --danger: #ef4444;
    
    --shadow-sm: 0 1px 2px rgba(0,0,0,0.3);
    --shadow: 0 4px 6px -1px rgba(0,0,0,0.2), 0 2px 4px -2px rgba(0,0,0,0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.3), 0 4px 6px -4px rgba(0,0,0,0.2);
    
    --radius-sm: 6px;
    --radius: 10px;
    --radius-lg: 14px;
    --radius-xl: 20px;
}

/* Light Theme */
html[data-theme='light'] {
    --bg: #f8fafc;
    --bg-secondary: #ffffff;
    --bg-elevated: #f1f5f9;
    --surface: #ffffff;
    --surface-hover: #f8fafc;
    
    --card-bg: #ffffff;
    --card-bg-hover: #f8fafc;
    
    --border: #e2e8f0;
    --border-strong: #cbd5e1;
    
    --text: #0f172a;
    --text-secondary: #475569;
    --text-muted: #94a3b8;
    
    --primary: #2563eb;
    --primary-hover: #1d4ed8;
    --primary-glow: rgba(37,99,235,0.2);
    
    --shadow-sm: 0 1px 2px rgba(15,23,42,0.05);
    --shadow: 0 4px 6px -1px rgba(15,23,42,0.08), 0 2px 4px -2px rgba(15,23,42,0.04);
    --shadow-lg: 0 10px 15px -3px rgba(15,23,42,0.08), 0 4px 6px -4px rgba(15,23,42,0.04);
}

/* ============================================
   SCROLLBAR
   ============================================ */
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}
::-webkit-scrollbar-track {
    background: transparent;
}
::-webkit-scrollbar-thumb {
    background: var(--text-muted);
    border-radius: 20px;
    opacity: 0.5;
}
::-webkit-scrollbar-thumb:hover {
    background: var(--text-secondary);
}

/* ============================================
   UTILITIES
   ============================================ */
a {
    text-decoration: none;
    color: inherit;
}
img {
    max-width: 100%;
    display: block;
}
button {
    font-family: inherit;
    cursor: pointer;
}
");
?>