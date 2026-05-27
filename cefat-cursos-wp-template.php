<?php
/*
 * Template Name: CEFAT Cursos 2026
 * Template Post Type: page
 */
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cursos CEFAT 2026 — Conducción, Actuación y Jóvenes · Azteca Estudios</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Outfit:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&family=DM+Serif+Display:ital@1&display=swap" rel="stylesheet">

  <style>
    /* ═══════════════════════════════════════
       DESIGN TOKENS
    ═══════════════════════════════════════ */
    :root {
      --ink:       #050508;
      --ink-2:     #0b0b14;
      --ink-3:     #111120;
      --ink-4:     #1a1a2e;
      --surface:   #f6f6f9;
      --white:     #ffffff;
      --red:       #e03050;
      --red-glow:  rgba(224,48,80,0.15);
      --gold:      #e8a020;
      --green:     #18c87a;
      --text:      #0c0c18;
      --muted:     #5a6070;
      --hairline:  rgba(255,255,255,0.08);
      --hairline-l:rgba(0,0,0,0.07);
      --font:      'Outfit', system-ui, sans-serif;
      --serif:     'DM Serif Display', Georgia, serif;
    }

    * { box-sizing: border-box; margin: 0; padding: 0; }
    html { scroll-behavior: smooth; }
    body {
      font-family: var(--font);
      background: var(--surface);
      color: var(--text);
      line-height: 1.6;
      -webkit-font-smoothing: antialiased;
      overflow-x: hidden;
    }
    img { max-width: 100%; display: block; }
    a { text-decoration: none; }

    /* ─── FILM GRAIN (fixed, GPU-safe, pointer-events-none) ─── */
    body::before {
      content: '';
      position: fixed;
      inset: -200%;
      z-index: 9999;
      pointer-events: none;
      width: 400%; height: 400%;
      opacity: 0.032;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 512 512' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
      animation: grain 0.9s steps(1) infinite;
      will-change: transform;
    }
    @keyframes grain {
      0%  { transform: translate(0, 0); }
      11% { transform: translate(-5%, -10%); }
      22% { transform: translate(-20%, 5%); }
      33% { transform: translate(3%, -15%); }
      44% { transform: translate(-15%, 10%); }
      55% { transform: translate(12%, 9%); }
      66% { transform: translate(9%, 4%); }
      77% { transform: translate(-3%, 11%); }
      88% { transform: translate(-1%, 7%); }
      100% { transform: translate(0, 0); }
    }

    /* ─── SCROLL REVEAL ENGINE ─── */
    .reveal {
      opacity: 0;
      transform: translateY(36px);
      transition: opacity 0.9s cubic-bezier(0.32,0.72,0,1),
                  transform 0.9s cubic-bezier(0.32,0.72,0,1);
    }
    .reveal.in { opacity: 1; transform: translateY(0); }
    .delay-1 { transition-delay: 0.08s; }
    .delay-2 { transition-delay: 0.16s; }
    .delay-3 { transition-delay: 0.24s; }
    .delay-4 { transition-delay: 0.32s; }

    /* ═══════════════════════════════════════
       NAV — Floating glass pill
    ═══════════════════════════════════════ */
    .nav {
      position: fixed;
      top: 20px; left: 50%;
      transform: translateX(-50%);
      z-index: 200;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 32px;
      padding: 10px 14px 10px 20px;
      background: rgba(5,5,8,0.75);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid var(--hairline);
      border-radius: 50px;
      width: min(92vw, 720px);
      box-shadow: 0 8px 32px rgba(0,0,0,0.4),
                  inset 0 1px 0 rgba(255,255,255,0.06);
    }

    .nav-logo img { height: 30px; width: auto; }

    .nav-right { display: flex; align-items: center; gap: 10px; }

    .nav-link {
      font-size: 12px;
      font-weight: 600;
      color: rgba(255,255,255,0.45);
      letter-spacing: 0.5px;
      transition: color 0.2s;
      white-space: nowrap;
    }
    .nav-link:hover { color: rgba(255,255,255,0.85); }

    .nav-cta {
      display: flex;
      align-items: center;
      gap: 8px;
      background: #25D366;
      color: #fff;
      font-size: 12px;
      font-weight: 700;
      padding: 8px 16px;
      border-radius: 50px;
      transition: background 0.18s, transform 0.12s, box-shadow 0.18s;
      white-space: nowrap;
    }
    .nav-cta:hover {
      background: #1fbc5c;
      transform: translateY(-1px);
      box-shadow: 0 4px 16px rgba(37,211,102,0.3);
    }
    .nav-cta svg { width: 14px; height: 14px; flex-shrink: 0; }

    @media (max-width: 600px) {
      .nav { width: calc(100vw - 24px); }
      .nav-link { display: none; }
    }

    /* ═══════════════════════════════════════
       HERO — Cinematic full-screen
    ═══════════════════════════════════════ */
    .hero {
      background: var(--ink);
      color: var(--white);
      min-height: 100dvh;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 140px 24px 120px;
      position: relative;
      overflow: hidden;
    }

    /* Top center glow — red spotlight */
    .hero-glow-top {
      position: absolute;
      top: -180px; left: 50%;
      transform: translateX(-50%);
      width: 1000px; height: 700px;
      background: radial-gradient(ellipse at 50% 30%,
        rgba(224,48,80,0.2) 0%,
        rgba(224,48,80,0.06) 40%,
        transparent 70%);
      pointer-events: none;
    }

    /* Bottom vignette */
    .hero-vignette {
      position: absolute;
      bottom: 0; left: 0; right: 0;
      height: 200px;
      background: linear-gradient(to top, rgba(5,5,8,0.6), transparent);
      pointer-events: none;
    }

    /* Horizontal scan lines — cinematic detail */
    .hero-scanline {
      position: absolute;
      left: 0; right: 0;
      height: 1px;
      background: linear-gradient(90deg, transparent, rgba(255,255,255,0.04), transparent);
      pointer-events: none;
    }
    .hero-scanline.top { top: 80px; }
    .hero-scanline.bot { bottom: 90px; }

    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 800px;
    }

    .hero-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 5px;
      color: var(--red);
      margin-bottom: 32px;
      opacity: 0;
      animation: fadeUp 0.9s cubic-bezier(0.32,0.72,0,1) 0.2s forwards;
    }
    .hero-eyebrow span {
      display: block;
      width: 28px; height: 1px;
      background: var(--red);
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    .hero h1 {
      font-size: clamp(46px, 8vw, 90px);
      font-weight: 900;
      line-height: 0.96;
      letter-spacing: -3px;
      color: var(--white);
      margin-bottom: 28px;
      opacity: 0;
      animation: fadeUp 1s cubic-bezier(0.32,0.72,0,1) 0.35s forwards;
    }

    .hero h1 .italic-accent {
      font-family: var(--serif);
      font-style: italic;
      font-weight: 300;
      color: rgba(255,255,255,0.55);
      letter-spacing: -1px;
    }

    .hero h1 .red { color: var(--red); }

    .hero-sub {
      font-size: clamp(14px, 2vw, 17px);
      color: rgba(255,255,255,0.42);
      max-width: 460px;
      margin: 0 auto 44px;
      font-weight: 400;
      line-height: 1.7;
      opacity: 0;
      animation: fadeUp 1s cubic-bezier(0.32,0.72,0,1) 0.5s forwards;
    }

    /* Logos pill */
    .hero-pill {
      display: inline-flex;
      align-items: center;
      gap: 12px;
      background: rgba(255,255,255,0.05);
      border: 1px solid var(--hairline);
      border-radius: 50px;
      padding: 9px 20px;
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: rgba(255,255,255,0.35);
      opacity: 0;
      animation: fadeUp 1s cubic-bezier(0.32,0.72,0,1) 0.65s forwards;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.05);
    }
    .hero-pill .dot {
      width: 3px; height: 3px;
      border-radius: 50%;
      background: var(--red);
      opacity: 0.8;
    }

    /* Scroll indicator — absolute bottom, NOT in content flow */
    .hero-scroll {
      position: absolute;
      bottom: 36px; left: 50%;
      transform: translateX(-50%);
      z-index: 3;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 6px;
      color: rgba(255,255,255,0.25);
      font-size: 9px;
      font-weight: 700;
      letter-spacing: 3px;
      text-transform: uppercase;
      cursor: pointer;
      transition: color 0.25s cubic-bezier(0.32,0.72,0,1);
      opacity: 0;
      animation: fadeUp 1s cubic-bezier(0.32,0.72,0,1) 1s forwards;
    }
    .hero-scroll:hover { color: rgba(255,255,255,0.55); }
    .hero-scroll-text { white-space: nowrap; }
    .hero-scroll-line {
      width: 1px; height: 28px;
      background: linear-gradient(to bottom, transparent, rgba(255,255,255,0.25));
    }
    .hero-scroll-chevron {
      animation: scrollBounce 2.2s cubic-bezier(0.32,0.72,0,1) infinite;
    }
    @keyframes scrollBounce {
      0%, 100% { transform: translateY(0); }
      50%       { transform: translateY(6px); }
    }

    /* ═══════════════════════════════════════
       ALERT STRIP
    ═══════════════════════════════════════ */
    .alert-strip {
      background: var(--red);
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 12px;
      padding: 11px 24px;
      font-size: 12px;
      font-weight: 700;
      letter-spacing: 0.5px;
    }
    .alert-strip svg { width: 14px; height: 14px; flex-shrink: 0; opacity: 0.85; }
    .alert-badge {
      background: rgba(255,255,255,0.18);
      border-radius: 50px;
      padding: 2px 10px;
      font-size: 10px;
      font-weight: 800;
      letter-spacing: 1.5px;
      text-transform: uppercase;
    }

    /* ═══════════════════════════════════════
       SHARED LAYOUT
    ═══════════════════════════════════════ */
    .container {
      max-width: 1120px;
      margin: 0 auto;
      padding: 0 24px;
    }

    .sec-eyebrow {
      display: inline-flex;
      align-items: center;
      gap: 10px;
      font-size: 10px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 4px;
      color: var(--red);
      margin-bottom: 14px;
    }
    .sec-eyebrow::before {
      content: '';
      display: block;
      width: 20px; height: 1px;
      background: var(--red);
    }

    .sec-h2 {
      font-size: clamp(30px, 5vw, 50px);
      font-weight: 900;
      line-height: 1.05;
      letter-spacing: -1.5px;
    }
    .sec-h2 em {
      font-family: var(--serif);
      font-style: italic;
      font-weight: 300;
    }
    .sec-dark  { color: var(--white); }
    .sec-light { color: var(--text); }

    .sec-sub {
      font-size: 15px;
      line-height: 1.65;
      max-width: 500px;
    }
    .sec-sub-dark  { color: rgba(255,255,255,0.4); }
    .sec-sub-light { color: var(--muted); }

    /* ═══════════════════════════════════════
       COURSES — White section, double-bezel cards
    ═══════════════════════════════════════ */
    .courses-sec {
      background: var(--white);
      padding: 112px 0 120px;
    }

    .courses-header {
      text-align: center;
      margin-bottom: 72px;
    }
    .courses-header .sec-eyebrow { justify-content: center; }
    .courses-header .sec-eyebrow::before { display: none; }
    .courses-header .sec-sub { margin: 12px auto 0; }

    /* THREE-COL GRID */
    .cards-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }
    @media (max-width: 900px) {
      .cards-grid { grid-template-columns: 1fr; gap: 20px; }
    }

    /* Double-bezel card: outer shell → inner core */
    .card-shell {
      background: var(--surface);
      border: 1px solid var(--hairline-l);
      border-radius: 22px;
      padding: 5px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.04);
      transition: box-shadow 0.35s cubic-bezier(0.32,0.72,0,1),
                  transform 0.35s cubic-bezier(0.32,0.72,0,1);
    }
    .card-shell:hover {
      transform: translateY(-6px);
      box-shadow: 0 28px 56px rgba(0,0,0,0.11);
    }

    .card-core {
      background: var(--white);
      border-radius: calc(22px - 5px);
      overflow: hidden;
      display: flex;
      flex-direction: column;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.9);
    }

    /* Colored top accent line */
    .card-line {
      height: 3px;
      background: var(--line-color, var(--red));
    }
    .card-line.red    { background: linear-gradient(90deg, var(--red), #ff6b82); }
    .card-line.purple { background: linear-gradient(90deg, #7c3aed, #a78bfa); }
    .card-line.gold   { background: linear-gradient(90deg, var(--gold), #fbbf24); }

    .card-head {
      background: var(--ink-2);
      padding: 30px 28px 26px;
      position: relative;
    }

    .card-badge {
      display: inline-block;
      font-size: 9px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 2.5px;
      padding: 4px 11px;
      border-radius: 50px;
      margin-bottom: 22px;
    }
    .badge-red    { background: rgba(224,48,80,0.2);   color: #ff8097; border: 1px solid rgba(224,48,80,0.3); }
    .badge-purple { background: rgba(124,58,237,0.2);  color: #c4b5fd; border: 1px solid rgba(124,58,237,0.3); }
    .badge-gold   { background: rgba(232,160,32,0.2);  color: #fcd34d; border: 1px solid rgba(232,160,32,0.3); }

    .card-icon-ring {
      width: 46px; height: 46px;
      border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 18px;
    }
    .ring-red    { background: rgba(224,48,80,0.12);  border: 1px solid rgba(224,48,80,0.2); }
    .ring-purple { background: rgba(124,58,237,0.12); border: 1px solid rgba(124,58,237,0.2); }
    .ring-gold   { background: rgba(232,160,32,0.12); border: 1px solid rgba(232,160,32,0.2); }

    .card-icon-ring svg { width: 22px; height: 22px; }
    .c-red    { color: #ff6b82; }
    .c-purple { color: #a78bfa; }
    .c-gold   { color: #fcd34d; }

    .card-head h3 {
      font-size: 21px;
      font-weight: 800;
      color: var(--white);
      line-height: 1.18;
      letter-spacing: -0.4px;
      margin-bottom: 8px;
    }
    .card-head p {
      font-size: 13px;
      color: rgba(255,255,255,0.4);
      line-height: 1.5;
    }

    .card-diploma-chip {
      position: absolute;
      top: 14px; right: 14px;
      background: var(--gold);
      color: #0a0a14;
      font-size: 9px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      padding: 4px 10px;
      border-radius: 50px;
    }

    .card-body {
      padding: 24px 28px;
      flex: 1;
      display: flex;
      flex-direction: column;
      gap: 20px;
      background: var(--white);
    }

    .meta-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px;
    }
    .meta-cell {
      background: var(--surface);
      border-radius: 9px;
      padding: 10px 13px;
    }
    .meta-k {
      font-size: 9px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: var(--muted);
      margin-bottom: 2px;
    }
    .meta-v {
      font-size: 13px;
      font-weight: 700;
      color: var(--text);
    }

    .check-list {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 9px;
      flex: 1;
    }
    .check-list li {
      display: flex;
      align-items: flex-start;
      gap: 9px;
      font-size: 13px;
      color: #334155;
      line-height: 1.4;
    }
    .chk {
      width: 17px; height: 17px;
      border-radius: 50%;
      background: rgba(24,200,122,0.1);
      border: 1px solid rgba(24,200,122,0.25);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
      margin-top: 1px;
    }
    .chk svg { width: 9px; height: 9px; color: var(--green); }

    .card-footer {
      background: var(--white);
      padding: 16px 28px 24px;
      border-top: 1px solid var(--hairline-l);
    }

    /* WhatsApp button with nested trailing icon */
    .btn-wa {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 10px;
      width: 100%;
      padding: 13px 20px;
      background: #25D366;
      color: var(--white);
      font-family: var(--font);
      font-size: 13.5px;
      font-weight: 700;
      border-radius: 10px;
      border: none;
      cursor: pointer;
      transition: background 0.2s cubic-bezier(0.32,0.72,0,1),
                  transform 0.15s cubic-bezier(0.32,0.72,0,1),
                  box-shadow 0.2s;
    }
    .btn-wa:hover {
      background: #1dbd5a;
      transform: translateY(-1px);
      box-shadow: 0 6px 20px rgba(37,211,102,0.25);
    }
    .btn-wa:active { transform: scale(0.98); }
    .btn-wa svg { width: 17px; height: 17px; flex-shrink: 0; }

    /* ═══════════════════════════════════════
       BENEFITS — Editorial full-width rows
    ═══════════════════════════════════════ */
    .benefits-sec {
      background: var(--surface);
      padding: 112px 0 120px;
    }

    .benefits-header {
      display: flex;
      flex-direction: column;
      align-items: flex-start;
      margin-bottom: 72px;
    }

    .benefits-list {
      display: flex;
      flex-direction: column;
    }

    .benefit-row {
      display: grid;
      grid-template-columns: 100px 1fr 1fr;
      gap: 0 48px;
      align-items: start;
      padding: 40px 0;
      border-top: 1px solid var(--hairline-l);
      transition: background 0.2s;
    }
    .benefit-row:last-child { border-bottom: 1px solid var(--hairline-l); }

    @media (max-width: 768px) {
      .benefit-row {
        grid-template-columns: 60px 1fr;
        gap: 0 20px;
      }
      .benefit-row-text { grid-column: 2; }
    }

    .benefit-num-big {
      font-size: 72px;
      font-weight: 900;
      color: rgba(0,0,0,0.06);
      line-height: 1;
      letter-spacing: -3px;
      font-variant-numeric: tabular-nums;
      user-select: none;
    }

    .benefit-title {
      font-size: 21px;
      font-weight: 800;
      color: var(--text);
      letter-spacing: -0.4px;
      margin-bottom: 8px;
      padding-top: 12px;
    }

    .benefit-desc {
      font-size: 14px;
      color: var(--muted);
      line-height: 1.65;
      padding-top: 12px;
    }

    @media (max-width: 768px) {
      .benefit-desc { grid-column: 2; }
    }

    /* ═══════════════════════════════════════
       AZTECA ESTUDIOS — Dark split
    ═══════════════════════════════════════ */
    .studio-sec {
      background: var(--ink);
      padding: 112px 0 120px;
      position: relative;
      overflow: hidden;
    }
    .studio-sec::after {
      content: '';
      position: absolute;
      bottom: -200px; right: -200px;
      width: 700px; height: 700px;
      background: radial-gradient(circle, rgba(224,48,80,0.07) 0%, transparent 60%);
      pointer-events: none;
    }

    .studio-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 80px;
      align-items: center;
    }
    @media (max-width: 768px) {
      .studio-grid { grid-template-columns: 1fr; gap: 48px; }
    }

    .studio-list {
      list-style: none;
      display: flex;
      flex-direction: column;
      gap: 0;
      margin-top: 32px;
    }
    .studio-list li {
      display: flex;
      align-items: center;
      gap: 14px;
      font-size: 14px;
      color: rgba(255,255,255,0.6);
      padding: 14px 0;
      border-bottom: 1px solid var(--hairline);
    }
    .studio-list li:first-child { border-top: 1px solid var(--hairline); }
    .studio-list li svg {
      width: 14px; height: 14px;
      color: var(--red);
      flex-shrink: 0;
    }

    /* Studio panel — double-bezel */
    .studio-shell {
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--hairline);
      border-radius: 24px;
      padding: 5px;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.05);
    }
    .studio-core {
      background: var(--ink-3);
      border-radius: calc(24px - 5px);
      padding: 40px;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.04);
    }

    .studio-label-sm {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: var(--red);
      margin-bottom: 4px;
    }
    .studio-name {
      font-size: 52px;
      font-weight: 900;
      color: var(--white);
      letter-spacing: -2.5px;
      line-height: 1;
      margin-bottom: 36px;
    }

    .studio-stats {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }
    .stat-cell {
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--hairline);
      border-radius: 12px;
      padding: 16px;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.04);
    }
    .stat-n {
      font-size: 30px;
      font-weight: 900;
      color: var(--gold);
      line-height: 1;
      font-variant-numeric: tabular-nums;
    }
    .stat-l {
      font-size: 11px;
      color: rgba(255,255,255,0.35);
      margin-top: 4px;
      font-weight: 500;
    }

    /* ═══════════════════════════════════════
       INSTRUCTORS — Dark, 3-column
    ═══════════════════════════════════════ */
    .instructors-sec {
      background: var(--ink-2);
      padding: 112px 0 120px;
      border-top: 1px solid var(--hairline);
    }

    .instructors-header {
      text-align: center;
      margin-bottom: 72px;
    }
    .instructors-header .sec-eyebrow { justify-content: center; }
    .instructors-header .sec-eyebrow::before { display: none; }
    .instructors-header .sec-sub { margin: 12px auto 0; }

    .instructors-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
    }
    @media (max-width: 900px) {
      .instructors-grid { grid-template-columns: 1fr; }
    }

    /* Instructor card: double-bezel on dark */
    .instructor-shell {
      background: rgba(255,255,255,0.03);
      border: 1px solid var(--hairline);
      border-radius: 22px;
      padding: 5px;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.04);
      transition: transform 0.35s cubic-bezier(0.32,0.72,0,1),
                  box-shadow 0.35s cubic-bezier(0.32,0.72,0,1);
    }
    .instructor-shell:hover {
      transform: translateY(-4px);
      box-shadow: 0 24px 48px rgba(0,0,0,0.4), inset 0 1px 0 rgba(255,255,255,0.06);
    }

    .instructor-core {
      background: var(--ink-3);
      border-radius: calc(22px - 5px);
      overflow: hidden;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.04);
    }

    .instructor-photo-wrap {
      padding: 32px 32px 0;
    }

    .instructor-avatar {
      width: 88px; height: 88px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--ink-4) 0%, rgba(224,48,80,0.3) 100%);
      border: 2px solid var(--hairline);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.3), inset 0 1px 0 rgba(255,255,255,0.06);
    }
    .instructor-avatar svg { width: 36px; height: 36px; color: rgba(255,255,255,0.5); }

    /* Placeholder silhouette variant colors */
    .avatar-purple {
      background: linear-gradient(135deg, var(--ink-4) 0%, rgba(124,58,237,0.3) 100%);
    }
    .avatar-gold {
      background: linear-gradient(135deg, var(--ink-4) 0%, rgba(232,160,32,0.3) 100%);
    }

    .instructor-info { padding: 0 32px 32px; }

    .instructor-role {
      display: inline-block;
      font-size: 9px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 2px;
      color: var(--red);
      border: 1px solid rgba(224,48,80,0.3);
      padding: 4px 11px;
      border-radius: 50px;
      margin-bottom: 12px;
    }

    .instructor-role.purple-role {
      color: #c4b5fd;
      border-color: rgba(124,58,237,0.3);
    }
    .instructor-role.gold-role {
      color: #fcd34d;
      border-color: rgba(232,160,32,0.3);
    }

    .instructor-name {
      font-size: 22px;
      font-weight: 800;
      color: var(--white);
      letter-spacing: -0.4px;
      margin-bottom: 10px;
    }

    .instructor-bio {
      font-size: 13px;
      color: rgba(255,255,255,0.38);
      line-height: 1.65;
    }

    .instructor-divider {
      height: 1px;
      background: var(--hairline);
      margin: 20px 32px;
    }

    .instructor-course-tag {
      font-size: 11px;
      font-weight: 600;
      color: rgba(255,255,255,0.25);
      padding: 0 32px 28px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .instructor-course-tag::before {
      content: '';
      display: block;
      width: 12px; height: 1px;
      background: currentColor;
    }

    /* ═══════════════════════════════════════
       FINAL CTA — Dark, dramatic
    ═══════════════════════════════════════ */
    .cta-sec {
      background: var(--ink);
      padding: 112px 0 120px;
      position: relative;
      overflow: hidden;
    }
    .cta-sec::before {
      content: '';
      position: absolute;
      top: -150px; left: 50%;
      transform: translateX(-50%);
      width: 800px; height: 500px;
      background: radial-gradient(ellipse, rgba(224,48,80,0.1) 0%, transparent 65%);
      pointer-events: none;
    }

    .cta-inner {
      position: relative;
      z-index: 1;
      text-align: center;
      margin-bottom: 60px;
    }
    .cta-inner .sec-eyebrow { justify-content: center; }
    .cta-inner .sec-eyebrow::before { display: none; }

    .cta-inner h2 {
      font-size: clamp(32px, 6vw, 60px);
      font-weight: 900;
      color: var(--white);
      letter-spacing: -2px;
      line-height: 1.05;
      margin-top: 14px;
      margin-bottom: 16px;
    }
    .cta-inner h2 .red { color: var(--red); }
    .cta-inner h2 .italic-accent {
      font-family: var(--serif);
      font-style: italic;
      font-weight: 300;
      color: rgba(255,255,255,0.45);
    }
    .cta-inner p {
      font-size: 15px;
      color: rgba(255,255,255,0.35);
      max-width: 380px;
      margin: 0 auto;
    }

    .cta-cards-row {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
      position: relative;
      z-index: 1;
    }
    @media (max-width: 768px) {
      .cta-cards-row { grid-template-columns: 1fr; }
    }

    .cta-mini-shell {
      background: rgba(255,255,255,0.04);
      border: 1px solid var(--hairline);
      border-radius: 18px;
      padding: 4px;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.04);
    }
    .cta-mini-core {
      background: var(--ink-3);
      border-radius: calc(18px - 4px);
      padding: 22px;
      box-shadow: inset 0 1px 0 rgba(255,255,255,0.04);
    }
    .cta-mini-core h4 {
      font-size: 14px;
      font-weight: 700;
      color: var(--white);
      margin-bottom: 3px;
      letter-spacing: -0.2px;
    }
    .cta-mini-meta {
      font-size: 11px;
      color: rgba(255,255,255,0.3);
      margin-bottom: 16px;
      font-weight: 500;
    }

    /* ═══════════════════════════════════════
       FOOTER
    ═══════════════════════════════════════ */
    .footer {
      background: var(--ink);
      border-top: 1px solid var(--hairline);
      padding: 32px 24px;
      text-align: center;
    }
    .footer-logo { height: 24px; width: auto; opacity: 0.4; margin: 0 auto 12px; }
    .footer p { font-size: 11px; color: rgba(255,255,255,0.2); line-height: 1.7; }

    /* ═══════════════════════════════════════
       STICKY WhatsApp FAB
    ═══════════════════════════════════════ */
    .fab {
      position: fixed;
      bottom: 24px; right: 24px;
      z-index: 198;
    }
    .fab a {
      display: flex;
      align-items: center;
      gap: 9px;
      background: #25D366;
      color: var(--white);
      font-size: 13px;
      font-weight: 700;
      padding: 13px 20px;
      border-radius: 50px;
      box-shadow: 0 4px 24px rgba(37,211,102,0.32);
      transition: transform 0.2s cubic-bezier(0.32,0.72,0,1),
                  box-shadow 0.2s cubic-bezier(0.32,0.72,0,1);
    }
    .fab a:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 32px rgba(37,211,102,0.42);
    }
    .fab a:active { transform: scale(0.97); }
    .fab svg { width: 17px; height: 17px; flex-shrink: 0; }

    @media (max-width: 480px) {
      .fab .fab-label { display: none; }
      .fab a { padding: 14px; border-radius: 50%; }
    }

    /* ═══════════════════════════════════════
       RESPONSIVE GLOBAL OVERRIDES
    ═══════════════════════════════════════ */
    @media (max-width: 768px) {
      .benefit-row { grid-template-columns: 60px 1fr; }
      .benefit-desc { grid-column: 1 / -1; padding-left: 80px; padding-top: 0; margin-top: -8px; padding-bottom: 8px; }
    }
    @media (max-width: 480px) {
      .benefit-row { grid-template-columns: 1fr; gap: 8px; }
      .benefit-num-big { font-size: 48px; }
      .benefit-desc { grid-column: auto; padding-left: 0; }
    }
  </style>
</head>
<body>

  <!-- ═══════ NAV ═══════ -->
  <nav class="nav">
    <a class="nav-logo" href="#" aria-label="CEFAT">
      <img src="https://cefat.mx/wp-content/uploads/2025/05/logo-cefat.png" alt="CEFAT" />
    </a>
    <div class="nav-right">
      <a class="nav-link" href="#cursos">Programas</a>
      <a class="nav-link" href="#profesores">Profesores</a>
      <a class="nav-cta" href="https://wa.me/5215530170616?text=Hola%2C%20quiero%20hablar%20con%20un%20asesor%20sobre%20los%20cursos%20CEFAT%202026" target="_blank" rel="noopener">
        <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
        Hablar con asesor
      </a>
    </div>
  </nav>

  <!-- ═══════ HERO ═══════ -->
  <section class="hero">
    <div class="hero-glow-top"></div>
    <div class="hero-scanline top"></div>
    <div class="hero-scanline bot"></div>

    <div class="hero-content">
      <div class="hero-eyebrow">
        <span></span>
        Azteca Estudios · CEFAT MMXXVI
        <span></span>
      </div>

      <h1>
        Aquí Comienza<br>
        <span class="italic-accent">el camino de los</span><br>
        <span class="red">Grandes Actores</span>
      </h1>

      <p class="hero-sub">
        Conducción para TV y digital, actuación para cine y televisión,
        y formación escénica para jóvenes talentos — todo en los estudios
        donde se produce México.
      </p>

      <div class="hero-pill">
        <span>CEFAT</span>
        <span class="dot"></span>
        <span>Azteca Estudios</span>
        <span class="dot"></span>
        <span>TV Azteca</span>
      </div>
    </div>

    <!-- Scroll indicator: absolute bottom, NOT in content flow -->
    <a class="hero-scroll" href="#cursos" aria-label="Ver programas">
      <span class="hero-scroll-text">Ver programas</span>
      <span class="hero-scroll-line"></span>
      <svg class="hero-scroll-chevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
        <polyline points="6 9 12 15 18 9"/>
      </svg>
    </a>

    <div class="hero-vignette"></div>
  </section>

  <!-- ═══════ ALERT STRIP ═══════ -->
  <div class="alert-strip" role="alert">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
    Cupos estrictamente limitados para 2026
    <span class="alert-badge">Reserva el tuyo</span>
  </div>

  <!-- ═══════ COURSES ═══════ -->
  <section class="courses-sec" id="cursos">
    <div class="container">
      <div class="courses-header reveal">
        <div class="sec-eyebrow">Elige tu programa</div>
        <h2 class="sec-h2 sec-light">Tres Programas,<br><em>Un Solo Escenario</em></h2>
        <p class="sec-sub sec-sub-light">Desde la pantalla hasta el escenario, cada programa está diseñado para convertir tu talento en carrera profesional.</p>
      </div>

      <div class="cards-grid">

        <!-- CARD 1: CONDUCCIÓN -->
        <div class="card-shell reveal delay-1">
          <div class="card-core">
            <div class="card-line red"></div>
            <div class="card-head">
              <span class="card-diploma-chip">Diplomado</span>
              <span class="card-badge badge-red">Conducción</span>
              <div class="card-icon-ring ring-red">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="c-red" aria-hidden="true">
                  <rect x="9" y="2" width="6" height="12" rx="3"/>
                  <path d="M5 10a7 7 0 0014 0"/>
                  <line x1="12" y1="20" x2="12" y2="22"/>
                  <line x1="8" y1="22" x2="16" y2="22"/>
                </svg>
              </div>
              <h3>Diplomado en<br>Conducción</h3>
              <p>Formación completa para conductores de TV y plataformas digitales con Karla Cantú</p>
            </div>
            <div class="card-body">
              <div class="meta-grid">
                <div class="meta-cell"><div class="meta-k">Inicio</div><div class="meta-v">23 Feb 2026</div></div>
                <div class="meta-cell"><div class="meta-k">Modalidad</div><div class="meta-v">Presencial</div></div>
                <div class="meta-cell"><div class="meta-k">Instructora</div><div class="meta-v">Karla Cantú</div></div>
                <div class="meta-cell"><div class="meta-k">Sede</div><div class="meta-v">Azteca Estudios</div></div>
              </div>
              <ul class="check-list">
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Comunicación verbal y no verbal en cámara</li>
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Desarrollo de personalidad y marca personal</li>
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Manejo vocal y presencia escénica</li>
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Storytelling y conexión con la audiencia</li>
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Contenido para TV y plataformas digitales</li>
              </ul>
            </div>
            <div class="card-footer">
              <a class="btn-wa" href="https://wa.me/5215530170616?text=Hola%2C%20quiero%20hablar%20con%20un%20asesor%20sobre%20el%20Diplomado%20en%20Conducci%C3%B3n%20CEFAT%202026" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Hablar con un asesor
              </a>
            </div>
          </div>
        </div>

        <!-- CARD 2: ACTUACIÓN -->
        <div class="card-shell reveal delay-2">
          <div class="card-core">
            <div class="card-line purple"></div>
            <div class="card-head">
              <span class="card-badge badge-purple">Actuación</span>
              <div class="card-icon-ring ring-purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="c-purple" aria-hidden="true">
                  <rect x="2" y="7" width="15" height="10" rx="2"/>
                  <path d="M17 9l5-2.5v9L17 13V9z"/>
                  <circle cx="7.5" cy="12" r="1.5" fill="currentColor" stroke="none"/>
                </svg>
              </div>
              <h3>Luces, Cámara<br>¡Actuación!</h3>
              <p>Técnicas especializadas para actuar frente a la cámara de cine y televisión en Azteca Estudios</p>
            </div>
            <div class="card-body">
              <div class="meta-grid">
                <div class="meta-cell"><div class="meta-k">Inicio</div><div class="meta-v">3 Mar 2026</div></div>
                <div class="meta-cell"><div class="meta-k">Duración</div><div class="meta-v">10 ses · 30 hrs</div></div>
                <div class="meta-cell"><div class="meta-k">Nivel</div><div class="meta-v">Adultos</div></div>
                <div class="meta-cell"><div class="meta-k">Sede</div><div class="meta-v">Azteca Estudios</div></div>
              </div>
              <ul class="check-list">
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Lenguaje corporal, voz y emoción en cámara</li>
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Análisis de guión y construcción de personajes</li>
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Marcas, encuadres y continuidad</li>
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Grabación de escenas con retroalimentación profesional</li>
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Red de contactos de la industria del entretenimiento</li>
              </ul>
            </div>
            <div class="card-footer">
              <a class="btn-wa" href="https://wa.me/5215530170616?text=Hola%2C%20quiero%20hablar%20con%20un%20asesor%20sobre%20el%20curso%20Luces%2C%20C%C3%A1mara%2C%20Actuaci%C3%B3n%20CEFAT%202026" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Hablar con un asesor
              </a>
            </div>
          </div>
        </div>

        <!-- CARD 3: JÓVENES -->
        <div class="card-shell reveal delay-3">
          <div class="card-core">
            <div class="card-line gold"></div>
            <div class="card-head">
              <span class="card-badge badge-gold">Jóvenes</span>
              <div class="card-icon-ring ring-gold">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="c-gold" aria-hidden="true">
                  <circle cx="12" cy="8" r="4"/>
                  <path d="M4 20c0-4.4 3.6-8 8-8s8 3.6 8 8"/>
                </svg>
              </div>
              <h3>Actuación para<br>Jóvenes 2026</h3>
              <p>Taller inicial para futuros actores — formación escénica especializada para jóvenes talentos</p>
            </div>
            <div class="card-body">
              <div class="meta-grid">
                <div class="meta-cell"><div class="meta-k">Inicio</div><div class="meta-v">23 Feb 2026</div></div>
                <div class="meta-cell"><div class="meta-k">Duración</div><div class="meta-v">20 ses · 40 hrs</div></div>
                <div class="meta-cell"><div class="meta-k">Nivel</div><div class="meta-v">Jóvenes</div></div>
                <div class="meta-cell"><div class="meta-k">Sede</div><div class="meta-v">Azteca Estudios</div></div>
              </div>
              <ul class="check-list">
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Expresión corporal y manejo de voz</li>
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Improvisación y dinámicas grupales</li>
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Construcción de personajes desde cero</li>
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Formación integral personalizada</li>
                <li><span class="chk"><svg viewBox="0 0 9 9" fill="none" stroke="currentColor" stroke-width="2"><polyline points="1.5 4.5 3.5 6.5 7.5 2.5"/></svg></span>Profesores activos en la industria del entretenimiento</li>
              </ul>
            </div>
            <div class="card-footer">
              <a class="btn-wa" href="https://wa.me/5215530170616?text=Hola%2C%20quiero%20hablar%20con%20un%20asesor%20sobre%20el%20curso%20de%20Actuaci%C3%B3n%20para%20J%C3%B3venes%20CEFAT%202026" target="_blank" rel="noopener">
                <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                Hablar con un asesor
              </a>
            </div>
          </div>
        </div>

      </div><!-- /cards-grid -->
    </div><!-- /container -->
  </section>

  <!-- ═══════ BENEFITS ═══════ -->
  <section class="benefits-sec">
    <div class="container">
      <div class="benefits-header reveal">
        <div class="sec-eyebrow">Por qué elegirnos</div>
        <h2 class="sec-h2 sec-light">La Diferencia <em>CEFAT</em></h2>
        <p class="sec-sub sec-sub-light" style="margin-top:12px;">Formación profesional donde se produce la televisión mexicana.</p>
      </div>

      <div class="benefits-list">
        <div class="benefit-row reveal">
          <div class="benefit-num-big">01</div>
          <div class="benefit-title">Formación Integral</div>
          <div class="benefit-desc">Desarrollo personalizado que trabaja todas las dimensiones del talento: técnica, presencia escénica, personalidad auténtica y marca personal. Sin atajos.</div>
        </div>
        <div class="benefit-row reveal delay-1">
          <div class="benefit-num-big">02</div>
          <div class="benefit-title">Instructores Activos</div>
          <div class="benefit-desc">Profesores que trabajan actualmente en la industria del entretenimiento y la televisión mexicana. No enseñan teoría — te transmiten la práctica real del set.</div>
        </div>
        <div class="benefit-row reveal delay-2">
          <div class="benefit-num-big">03</div>
          <div class="benefit-title">Instalaciones Profesionales</div>
          <div class="benefit-desc">Foros de grabación con iluminación broadcast, estudios de audio, cámaras profesionales y espacios de ensayo. El mismo ambiente que encontrarás en tu carrera.</div>
        </div>
        <div class="benefit-row reveal delay-3">
          <div class="benefit-num-big">04</div>
          <div class="benefit-title">Red de la Industria</div>
          <div class="benefit-desc">Acceso directo a una red de profesionales activos del entretenimiento en México. Las conexiones que abren puertas se construyen desde el primer día de formación.</div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ AZTECA ESTUDIOS ═══════ -->
  <section class="studio-sec">
    <div class="container">
      <div class="studio-grid">
        <div class="studio-text reveal">
          <div class="sec-eyebrow" style="color:var(--red);">
            <span style="display:block;width:20px;height:1px;background:var(--red);"></span>
            Donde todo sucede
          </div>
          <h2 class="sec-h2 sec-dark" style="margin-top:14px;">Entrena Donde<br>los Profesionales<br><em>Trabajan</em></h2>
          <p class="sec-sub sec-sub-dark" style="margin-top:14px;">Todos los programas se realizan en Azteca Estudios, uno de los complejos de producción televisiva más importantes de México.</p>
          <ul class="studio-list">
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>Foro de grabación con equipo broadcast completo</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>Estudio de audio y sala de ensayos</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>Iluminación y tramoya de nivel profesional</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>Retroalimentación en grabaciones reales</li>
            <li><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="20 6 9 17 4 12"/></svg>Experiencia con programas en vivo y grabados</li>
          </ul>
        </div>
        <div class="reveal delay-2">
          <div class="studio-shell">
            <div class="studio-core">
              <div class="studio-label-sm">Sede oficial</div>
              <div class="studio-name">Azteca<br>Estudios</div>
              <div class="studio-stats">
                <div class="stat-cell"><div class="stat-n">3</div><div class="stat-l">Programas 2026</div></div>
                <div class="stat-cell"><div class="stat-n">40+</div><div class="stat-l">Horas de formación</div></div>
                <div class="stat-cell"><div class="stat-n">100%</div><div class="stat-l">Presencial</div></div>
                <div class="stat-cell"><div class="stat-n">Feb</div><div class="stat-l">Próximo inicio</div></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ INSTRUCTORS ═══════ -->
  <section class="instructors-sec" id="profesores">
    <div class="container">
      <div class="instructors-header reveal">
        <div class="sec-eyebrow" style="justify-content:center; color:var(--red);">
          <span style="display:none;"></span>
          Quiénes te enseñan
        </div>
        <h2 class="sec-h2 sec-dark" style="margin-top:10px;">Profesores <em>en Activo</em></h2>
        <p class="sec-sub sec-sub-dark" style="margin:12px auto 0;">Líderes actuales de la industria del entretenimiento y la televisión en México.</p>
      </div>

      <div class="instructors-grid">

        <!-- Instructor 1: Karla Cantú -->
        <div class="instructor-shell reveal delay-1">
          <div class="instructor-core">
            <div class="instructor-photo-wrap">
              <div class="instructor-avatar">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg>
              </div>
            </div>
            <div class="instructor-info">
              <span class="instructor-role">Conducción · Comunicación</span>
              <div class="instructor-name">Karla Cantú</div>
              <p class="instructor-bio">Directora y coach de comunicación con trayectoria activa en medios. Especialista en el desarrollo de conductores para televisión y plataformas digitales.</p>
            </div>
            <div class="instructor-divider"></div>
            <div class="instructor-course-tag">Diplomado en Conducción</div>
          </div>
        </div>

        <!-- Instructor 2: Placeholder Actuación -->
        <div class="instructor-shell reveal delay-2">
          <div class="instructor-core">
            <div class="instructor-photo-wrap">
              <div class="instructor-avatar avatar-purple">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg>
              </div>
            </div>
            <div class="instructor-info">
              <span class="instructor-role purple-role">Actuación · Cine y TV</span>
              <div class="instructor-name">Instructor de Actuación</div>
              <p class="instructor-bio">Actor con presencia activa en proyectos de cine y televisión nacional. Especialista en técnicas de actuación frente a cámara y construcción de personajes.</p>
            </div>
            <div class="instructor-divider"></div>
            <div class="instructor-course-tag" style="color:rgba(196,181,253,0.4);">Luces, Cámara, Actuación</div>
          </div>
        </div>

        <!-- Instructor 3: Placeholder Jóvenes -->
        <div class="instructor-shell reveal delay-3">
          <div class="instructor-core">
            <div class="instructor-photo-wrap">
              <div class="instructor-avatar avatar-gold">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4" aria-hidden="true"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-4.4 3.6-8 8-8s8 3.6 8 8"/></svg>
              </div>
            </div>
            <div class="instructor-info">
              <span class="instructor-role gold-role">Actuación Escénica · Jóvenes</span>
              <div class="instructor-name">Instructor de Jóvenes</div>
              <p class="instructor-bio">Formador especializado en el desarrollo actoral de nuevos talentos. Experiencia en dirección escénica y metodologías de enseñanza para jóvenes actores.</p>
            </div>
            <div class="instructor-divider"></div>
            <div class="instructor-course-tag" style="color:rgba(252,211,77,0.4);">Actuación para Jóvenes 2026</div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ═══════ FINAL CTA ═══════ -->
  <section class="cta-sec">
    <div class="container">
      <div class="cta-inner reveal">
        <div class="sec-eyebrow" style="justify-content:center; color:var(--red);">El set te espera</div>
        <h2>Entre el Deseo<br>y el Logro<br><span class="italic-accent">está</span> <span class="red">la Acción</span></h2>
        <p>Cupo limitado — reserva tu lugar antes de que se agote.</p>
      </div>

      <div class="cta-cards-row">
        <div class="cta-mini-shell reveal delay-1">
          <div class="cta-mini-core">
            <h4>Diplomado en Conducción</h4>
            <p class="cta-mini-meta">23 Feb · Karla Cantú · Diplomado</p>
            <a class="btn-wa" href="https://wa.me/5215530170616?text=Hola%2C%20quiero%20hablar%20con%20un%20asesor%20sobre%20el%20Diplomado%20en%20Conducci%C3%B3n%20CEFAT%202026" target="_blank" rel="noopener">
              <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              Hablar con un asesor
            </a>
          </div>
        </div>

        <div class="cta-mini-shell reveal delay-2">
          <div class="cta-mini-core">
            <h4>Luces, Cámara, Actuación</h4>
            <p class="cta-mini-meta">3 Mar · 10 sesiones · 30 hrs</p>
            <a class="btn-wa" href="https://wa.me/5215530170616?text=Hola%2C%20quiero%20hablar%20con%20un%20asesor%20sobre%20el%20curso%20Luces%2C%20C%C3%A1mara%2C%20Actuaci%C3%B3n%20CEFAT%202026" target="_blank" rel="noopener">
              <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              Hablar con un asesor
            </a>
          </div>
        </div>

        <div class="cta-mini-shell reveal delay-3">
          <div class="cta-mini-core">
            <h4>Actuación para Jóvenes</h4>
            <p class="cta-mini-meta">23 Feb · 20 sesiones · 40 hrs</p>
            <a class="btn-wa" href="https://wa.me/5215530170616?text=Hola%2C%20quiero%20hablar%20con%20un%20asesor%20sobre%20el%20curso%20de%20Actuaci%C3%B3n%20para%20J%C3%B3venes%20CEFAT%202026" target="_blank" rel="noopener">
              <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
              Hablar con un asesor
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ═══════ FOOTER ═══════ -->
  <footer class="footer">
    <img class="footer-logo" src="https://cefat.mx/wp-content/uploads/2025/05/logo-cefat.png" alt="CEFAT" />
    <p>CEFAT · Centro de Formación Artística y Televisiva · Azteca Estudios · Ciudad de México</p>
    <p>© 2026 CEFAT · Todos los derechos reservados</p>
  </footer>

  <!-- ═══════ STICKY FAB ═══════ -->
  <div class="fab">
    <a href="https://wa.me/5215530170616?text=Hola%2C%20quiero%20hablar%20con%20un%20asesor%20sobre%20los%20cursos%20CEFAT%202026" target="_blank" rel="noopener" aria-label="Hablar con un asesor por WhatsApp">
      <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
      <span class="fab-label">Hablar con un asesor</span>
    </a>
  </div>

  <!-- ═══════ SCROLL REVEAL ENGINE ═══════ -->
  <script>
    (function () {
      const observer = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              entry.target.classList.add('in');
              observer.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.1, rootMargin: '0px 0px -40px 0px' }
      );
      document.querySelectorAll('.reveal').forEach(function (el) {
        observer.observe(el);
      });
    })();
  </script>

</body>
</html>
