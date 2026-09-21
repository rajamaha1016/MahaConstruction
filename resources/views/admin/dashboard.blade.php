<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Maha Constructions Admin Panel</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --navy-950: #080D1A;
            --navy-900: #0F172A;
            --navy-800: #1E293B;
            --navy-700: #334155;
            --slate-600: #475569;
            --slate-500: #64748B;
            --slate-400: #94A3B8;
            --slate-300: #CBD5E1;
            --slate-200: #E2E8F0;
            --slate-100: #F1F5F9;
            --slate-50:  #F8FAFC;
            --white:     #FFFFFF;

            --accent-amber:   #D97706;
            --accent-amber-subtle: #FEF3C7;
            --accent-emerald: #10B981;
            --accent-emerald-subtle: #ECFDF5;
            --accent-red:     #DC2626;
            --accent-red-subtle: #FEF2F2;
            --accent-blue:    #2563EB;
            --accent-blue-subtle: #EFF6FF;

            --font-main: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --shadow-xs: 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow-sm: 0 1px 3px rgba(15, 23, 42, 0.08), 0 1px 2px rgba(15, 23, 42, 0.04);
            --shadow-md: 0 4px 6px -1px rgba(15, 23, 42, 0.08), 0 2px 4px -1px rgba(15, 23, 42, 0.04);
            --shadow-lg: 0 10px 15px -3px rgba(15, 23, 42, 0.08), 0 4px 6px -2px rgba(15, 23, 42, 0.03);
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
        }

        * { box-sizing: border-box; }

        body {
            background: var(--slate-50);
            color: var(--navy-900);
            font-family: var(--font-main);
            font-size: 13px;
            line-height: 1.5;
            margin: 0;
            -webkit-font-smoothing: antialiased;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
            background: var(--slate-50);
        }

        /* ── Sidebar ── */
        .admin-sidebar {
            width: 250px;
            flex-shrink: 0;
            background: var(--navy-900);
            border-right: 1px solid var(--navy-800);
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            overflow-y: auto;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease;
        }

        .admin-sidebar-logo {
            padding: 18px 20px 16px;
            border-bottom: 1px solid var(--navy-800);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .admin-logo-mark {
            width: 34px;
            height: 34px;
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            border: 1px solid rgba(217, 119, 6, 0.5);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            font-size: 0.95rem;
            box-shadow: 0 2px 8px rgba(217,119,6,0.35);
        }

        .admin-title-badge {
            font-family: var(--font-main);
            font-size: 0.88rem;
            font-weight: 700;
            color: #FFFFFF;
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .admin-sub-badge {
            font-family: var(--font-main);
            font-size: 0.65rem;
            color: #94A3B8;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .sidebar-section-heading {
            padding: 14px 20px 4px;
            font-size: 0.65rem;
            font-weight: 700;
            color: #64748B;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .sidebar-nav-list {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding: 0;
            margin: 0;
        }

        .sidebar-nav-link {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 12px;
            margin: 1px 12px;
            border-radius: var(--radius-sm);
            font-size: 0.8rem;
            font-weight: 500;
            color: #94A3B8;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .sidebar-nav-link:hover {
            background: var(--navy-800);
            color: #F8FAFC;
        }

        .sidebar-nav-link.active {
            background: var(--navy-800);
            color: #FFFFFF;
            font-weight: 600;
            box-shadow: inset 3px 0 0 var(--accent-amber);
        }

        .nav-item-content {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-icon {
            width: 16px;
            font-size: 0.85rem;
            color: #64748B;
            transition: color 0.15s ease;
        }

        .sidebar-nav-link:hover .nav-icon,
        .sidebar-nav-link.active .nav-icon {
            color: var(--accent-amber);
        }

        /* ── Per-icon sidebar colors ── */
        .nav-icon.icon-analytics   { color: #10B981; }  /* emerald */
        .nav-icon.icon-video       { color: #F43F5E; }  /* rose */
        .nav-icon.icon-projects    { color: #3B82F6; }  /* blue */
        .nav-icon.icon-packages    { color: #8B5CF6; }  /* violet */
        .nav-icon.icon-leads       { color: #F59E0B; }  /* amber */
        .nav-icon.icon-youtube     { color: #EF4444; }  /* red */
        .nav-icon.icon-banking     { color: #06B6D4; }  /* cyan */
        .nav-icon.icon-intro       { color: #EC4899; }  /* pink */
        .nav-icon.icon-guidebook   { color: #EF4444; }  /* red */
        .nav-icon.icon-contact     { color: #64748B; }  /* slate */
        .nav-icon.icon-security    { color: #64748B; }  /* slate */

        .sidebar-nav-link:hover .nav-icon,
        .sidebar-nav-link.active .nav-icon {
            filter: brightness(1.3);
        }

        .badge-count {
            background: rgba(51,65,85,0.5);
            color: #CBD5E1;
            padding: 2px 7px;
            border-radius: 9999px;
            font-size: 0.68rem;
            font-weight: 700;
            border: 1px solid rgba(255,255,255,0.08);
        }

        /* Colored badges per section */
        .badge-count.bc-green  { background: rgba(16,185,129,0.18); color: #34D399; border-color: rgba(16,185,129,0.3); }
        .badge-count.bc-rose   { background: rgba(244,63,94,0.18);  color: #FB7185; border-color: rgba(244,63,94,0.3); }
        .badge-count.bc-blue   { background: rgba(59,130,246,0.18); color: #60A5FA; border-color: rgba(59,130,246,0.3); }
        .badge-count.bc-violet { background: rgba(139,92,246,0.18); color: #A78BFA; border-color: rgba(139,92,246,0.3); }
        .badge-count.bc-amber  { background: rgba(245,158,11,0.18); color: #FCD34D; border-color: rgba(245,158,11,0.3); }
        .badge-count.bc-red    { background: rgba(239,68,68,0.18);  color: #FCA5A5; border-color: rgba(239,68,68,0.3); }
        .badge-count.bc-cyan   { background: rgba(6,182,212,0.18);  color: #67E8F9; border-color: rgba(6,182,212,0.3); }

        .badge-count.live-pill {
            background: rgba(16, 185, 129, 0.18);
            color: #10B981;
            border-color: rgba(16, 185, 129, 0.35);
            font-weight: 700;
        }

        /* ── Top Header ── */
        .admin-main-view {
            margin-left: 250px;
            flex: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: var(--slate-50);
            width: calc(100% - 250px);
        }

        .admin-header-bar {
            background: #FFFFFF;
            border-bottom: 1px solid var(--slate-200);
            padding: 0 28px;
            height: 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 90;
            box-shadow: 0 1px 2px rgba(15,23,42,0.02);
        }

        .admin-panel-title {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--navy-900);
            letter-spacing: -0.01em;
            line-height: 1.2;
        }

        .admin-panel-sub {
            font-size: 0.72rem;
            color: var(--slate-500);
            font-weight: 500;
        }

        .mobile-toggle-btn {
            display: none;
            background: transparent;
            border: 1px solid var(--slate-300);
            border-radius: 6px;
            color: var(--navy-900);
            padding: 6px 10px;
            font-size: 0.9rem;
            cursor: pointer;
        }

        /* ── Division Switcher ── */
        .division-switcher {
            display: inline-flex;
            align-items: center;
            background: var(--slate-100);
            border: 1px solid var(--slate-200);
            border-radius: 8px;
            padding: 3px;
            gap: 2px;
        }

        .division-btn {
            background: transparent;
            border: none;
            color: var(--slate-600);
            font-family: var(--font-main);
            font-size: 0.76rem;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .division-btn:hover {
            color: var(--navy-900);
        }

        .division-btn.active {
            background: var(--navy-900);
            color: #FFFFFF;
            box-shadow: 0 1px 2px rgba(0,0,0,0.08);
        }

        .btn-top-live {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            font-size: 0.76rem;
            font-weight: 600;
            color: var(--navy-900);
            background: #FFFFFF;
            border: 1px solid var(--slate-300);
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
        }

        .btn-top-live:hover {
            background: var(--slate-100);
            border-color: var(--slate-400);
        }

        .btn-top-logout {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            font-size: 0.76rem;
            font-weight: 600;
            color: var(--accent-red);
            background: var(--accent-red-subtle);
            border: 1px solid #FECACA;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-top-logout:hover {
            background: #FEE2E2;
            border-color: #FCA5A5;
        }

        /* Dedicated logout header button — avoids action-del-btn's 30px fixed size */
        .btn-header-logout {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            width: auto !important;
            height: auto !important;
            padding: 7px 14px !important;
            font-size: 0.78rem !important;
            font-weight: 600 !important;
            white-space: nowrap !important;
            color: var(--accent-red) !important;
            background: var(--accent-red-subtle) !important;
            border: 1px solid #FECACA !important;
            border-radius: var(--radius-sm) !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            justify-content: center !important;
            text-decoration: none !important;
            font-family: var(--font-main) !important;
        }

        .btn-header-logout:hover {
            background: #FEE2E2 !important;
            border-color: #FCA5A5 !important;
            color: var(--accent-red) !important;
        }

        /* ── Body Content Area ── */
        .admin-body-content {
            padding: 24px 28px;
            flex: 1;
            max-width: 1600px;
            width: 100%;
            margin: 0 auto;
        }

        .admin-tab-pane { display: none; }
        .admin-tab-pane.active { display: block; animation: fadeIn 0.2s ease-in-out; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(3px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ── Card Panel ── */
        .card-dark-panel {
            background: #FFFFFF !important;
            border: 1px solid var(--slate-200) !important;
            border-radius: var(--radius-md) !important;
            padding: 20px 24px !important;
            margin-bottom: 20px !important;
            box-shadow: var(--shadow-xs) !important;
        }

        .panel-header-title {
            font-family: var(--font-main) !important;
            font-size: 1.05rem !important;
            font-weight: 700 !important;
            color: var(--navy-900) !important;
            margin-bottom: 4px !important;
            letter-spacing: -0.01em !important;
            text-transform: none !important;
        }

        .panel-header-sub {
            font-family: var(--font-main) !important;
            font-size: 0.8rem !important;
            color: var(--slate-500) !important;
            margin-bottom: 18px !important;
            line-height: 1.4 !important;
        }

        /* ── Buttons ── */
        .btn-gold-pill, .btn-gold-submit {
            background: var(--navy-900) !important;
            color: #FFFFFF !important;
            border: 1px solid var(--navy-900) !important;
            font-family: var(--font-main) !important;
            font-weight: 600 !important;
            font-size: 0.8rem !important;
            padding: 7px 16px !important;
            border-radius: var(--radius-sm) !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            text-decoration: none !important;
            box-shadow: var(--shadow-xs) !important;
        }

        .btn-gold-pill:hover, .btn-gold-submit:hover {
            background: var(--navy-800) !important;
            border-color: var(--navy-800) !important;
            transform: none !important;
        }

        .btn-whatsapp-outline {
            background: #FFFFFF !important;
            color: var(--navy-900) !important;
            border: 1px solid var(--slate-300) !important;
            font-family: var(--font-main) !important;
            font-weight: 600 !important;
            font-size: 0.78rem !important;
            padding: 6px 14px !important;
            border-radius: var(--radius-sm) !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            text-decoration: none !important;
        }

        .btn-whatsapp-outline:hover {
            background: var(--slate-100) !important;
            border-color: var(--slate-400) !important;
            color: var(--navy-950) !important;
        }

        .action-del-btn {
            background: var(--accent-red-subtle) !important;
            color: var(--accent-red) !important;
            border: 1px solid #FECACA !important;
            width: 30px !important;
            height: 30px !important;
            border-radius: var(--radius-sm) !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            font-size: 0.78rem !important;
        }

        .action-del-btn:hover {
            background: var(--accent-red) !important;
            color: #FFFFFF !important;
            border-color: var(--accent-red) !important;
            transform: none !important;
            box-shadow: 0 2px 8px rgba(220,38,38,0.35) !important;
        }

        .action-edit-btn {
            background: rgba(59,130,246,0.08) !important;
            color: #3B82F6 !important;
            border: 1px solid rgba(59,130,246,0.25) !important;
            min-width: 30px !important;
            min-height: 30px !important;
            border-radius: var(--radius-sm) !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            font-size: 0.78rem !important;
            box-sizing: border-box !important;
        }

        .action-edit-btn:hover {
            background: #3B82F6 !important;
            color: #FFFFFF !important;
            border-color: #3B82F6 !important;
            transform: none !important;
            box-shadow: 0 2px 8px rgba(59,130,246,0.35) !important;
        }

        .btn-text-edit {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            width: auto !important;
            height: auto !important;
            padding: 6px 14px !important;
            font-size: 0.78rem !important;
            font-weight: 600 !important;
            white-space: nowrap !important;
            color: #2563EB !important;
            background: rgba(37,99,235,0.08) !important;
            border: 1px solid rgba(37,99,235,0.25) !important;
            border-radius: var(--radius-sm) !important;
            cursor: pointer !important;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
            font-family: var(--font-main) !important;
        }

        .btn-text-edit:hover {
            background: #2563EB !important;
            color: #FFFFFF !important;
            border-color: #2563EB !important;
            box-shadow: 0 4px 12px rgba(37,99,235,0.35) !important;
            transform: translateY(-1px) !important;
        }

        /* ── STRUCTURAL DIVISION WORKSPACE & SCOPE CONTROL ── */
        .division-scope-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            background: #FFFFFF;
            border: 1px solid var(--slate-200);
            border-left: 4px solid var(--navy-900);
            padding: 12px 18px;
            border-radius: var(--radius-md);
            margin: 16px 0 22px 0;
            box-shadow: var(--shadow-xs);
            animation: divisionBannerEnter 0.28s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .division-scope-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .division-scope-badge {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.76rem;
            font-weight: 800;
            letter-spacing: 0.04em;
            text-transform: uppercase;
            background: var(--navy-900);
            color: #FFFFFF;
            box-shadow: 0 2px 6px rgba(15,23,42,0.18);
        }

        .division-scope-badge .scope-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #10B981;
            box-shadow: 0 0 6px #10B981;
            animation: pulseGlow 1.8s ease-in-out infinite;
        }

        .division-scope-desc {
            font-size: 0.8rem;
            color: var(--slate-600);
            font-weight: 500;
        }

        .division-scope-switch-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 14px;
            font-size: 0.76rem;
            font-weight: 700;
            color: var(--navy-900);
            background: var(--slate-100);
            border: 1px solid var(--slate-300);
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: var(--font-main);
        }

        .division-scope-switch-btn:hover {
            background: var(--navy-900);
            color: #FFFFFF;
            border-color: var(--navy-900);
            box-shadow: 0 3px 10px rgba(15,23,42,0.2);
            transform: translateY(-1px);
        }

        .btn-text-danger {
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            width: auto !important;
            height: auto !important;
            padding: 6px 14px !important;
            font-size: 0.78rem !important;
            font-weight: 600 !important;
            white-space: nowrap !important;
            color: var(--accent-red) !important;
            background: var(--accent-red-subtle) !important;
            border: 1px solid #FECACA !important;
            border-radius: var(--radius-sm) !important;
            cursor: pointer !important;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
            font-family: var(--font-main) !important;
        }

        .btn-text-danger:hover {
            background: var(--accent-red) !important;
            color: #FFFFFF !important;
            border-color: var(--accent-red) !important;
            box-shadow: 0 4px 12px rgba(220,38,38,0.35) !important;
            transform: translateY(-1px) !important;
        }

        .btn-text-danger:active {
            transform: translateY(0) !important;
        }

        /* ── ANIMATIONS ── */
        @keyframes tabFadeSlideIn {
            from {
                opacity: 0;
                transform: translateY(12px) scale(0.995);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes cardEnterCascade {
            from {
                opacity: 0;
                transform: translateY(16px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulseGlow {
            0%, 100% {
                opacity: 1;
                transform: scale(1);
            }
            50% {
                opacity: 0.55;
                transform: scale(1.25);
            }
        }

        @keyframes divisionBannerEnter {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes badgeBounce {
            0%, 100% { transform: scale(1); }
            40% { transform: scale(1.18); }
            70% { transform: scale(0.95); }
        }

        .admin-tab-pane.active {
            animation: tabFadeSlideIn 0.28s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .card-dark-panel,
        .project-video-card,
        .stat-card-custom,
        .package-card {
            transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.25s cubic-bezier(0.16, 1, 0.3, 1), border-color 0.25s ease !important;
        }

        .project-video-card:hover,
        .package-card:hover {
            transform: translateY(-5px) scale(1.008) !important;
            box-shadow: 0 14px 28px -6px rgba(15, 23, 42, 0.12), 0 6px 12px -4px rgba(15, 23, 42, 0.06) !important;
        }

        .sidebar-nav-link {
            transition: background-color 0.2s ease, color 0.2s ease, transform 0.2s cubic-bezier(0.16, 1, 0.3, 1) !important;
        }

        .sidebar-nav-link:hover {
            transform: translateX(4px) !important;
        }

        .sidebar-nav-link.active {
            transform: translateX(4px) !important;
        }

        /* ── WORKSPACE DIVISION SWITCHER IN TOP HEADER ── */
        .division-switcher {
            display: inline-flex;
            background: var(--slate-100);
            padding: 4px;
            border-radius: var(--radius-md);
            border: 1px solid var(--slate-200);
            gap: 4px;
        }

        .division-btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 7px 16px;
            font-size: 0.78rem;
            font-weight: 700;
            border-radius: var(--radius-sm);
            border: none;
            background: transparent;
            color: var(--slate-600);
            cursor: pointer;
            transition: all 0.22s cubic-bezier(0.16, 1, 0.3, 1);
            font-family: var(--font-main);
            letter-spacing: 0.03em;
        }

        .division-btn:hover {
            color: var(--navy-900);
            background: rgba(255, 255, 255, 0.85);
        }

        .division-btn.active {
            background: var(--navy-900);
            color: #FFFFFF;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.2);
        }

        /* ── Tables ── */
        .table-custom-dark {
            width: 100% !important;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            font-size: 0.82rem !important;
            border: 1px solid var(--slate-200) !important;
            border-radius: var(--radius-md) !important;
            overflow: hidden !important;
            margin-top: 14px !important;
        }

        .table-custom-dark th {
            font-family: var(--font-main) !important;
            background: var(--slate-50) !important;
            color: var(--slate-600) !important;
            padding: 10px 14px !important;
            font-size: 0.72rem !important;
            font-weight: 600 !important;
            letter-spacing: 0.04em !important;
            text-transform: uppercase !important;
            text-align: left !important;
            border: none !important;
            border-bottom: 1px solid var(--slate-200) !important;
        }

        .table-custom-dark td {
            font-family: var(--font-main) !important;
            padding: 11px 14px !important;
            border: none !important;
            border-bottom: 1px solid var(--slate-100) !important;
            color: var(--navy-900) !important;
            background: #FFFFFF !important;
            font-size: 0.82rem !important;
            vertical-align: middle !important;
        }

        .table-custom-dark tr:last-child td {
            border-bottom: none !important;
        }

        .table-custom-dark tr:hover td {
            background: var(--slate-50) !important;
        }

        /* ── Pill Filters ── */
        .analytics-pill-group {
            display: inline-flex !important;
            align-items: center !important;
            background: var(--slate-100) !important;
            border: 1px solid var(--slate-200) !important;
            border-radius: 8px !important;
            padding: 2px !important;
            gap: 2px !important;
        }

        .analytics-pill-btn {
            background: transparent !important;
            border: none !important;
            color: var(--slate-600) !important;
            font-family: var(--font-main) !important;
            font-size: 0.72rem !important;
            font-weight: 600 !important;
            padding: 5px 12px !important;
            border-radius: 6px !important;
            cursor: pointer !important;
            transition: all 0.15s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 5px !important;
            box-shadow: none !important;
        }

        .analytics-pill-btn:hover {
            color: var(--navy-900) !important;
        }

        .analytics-pill-btn.active {
            background: #FFFFFF !important;
            color: var(--navy-900) !important;
            font-weight: 700 !important;
            box-shadow: 0 1px 2px rgba(0,0,0,0.06) !important;
        }

        /* ── Input Controls ── */
        .input-dark, input[type="text"], input[type="email"], input[type="password"], input[type="number"], select, textarea {
            background: #FFFFFF !important;
            border: 1px solid var(--slate-300) !important;
            color: var(--navy-900) !important;
            border-radius: var(--radius-sm) !important;
            padding: 8px 12px !important;
            font-size: 0.82rem !important;
            font-family: var(--font-main) !important;
            transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
        }

        .input-dark:focus, input:focus, select:focus, textarea:focus {
            border-color: var(--navy-900) !important;
            outline: none !important;
            box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08) !important;
        }

        /* ── Cards & Media Grids ── */
        .projects-grid-2 {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)) !important;
            gap: 16px !important;
            margin-top: 16px !important;
        }

        .project-video-card {
            background: #FFFFFF !important;
            border: 1px solid var(--slate-200) !important;
            border-radius: var(--radius-md) !important;
            overflow: hidden !important;
            display: flex !important;
            flex-direction: column !important;
            transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
            box-shadow: var(--shadow-xs) !important;
        }

        .project-video-card:hover {
            border-color: var(--slate-300) !important;
            box-shadow: var(--shadow-md) !important;
            transform: none !important;
        }

        .project-video-card .video-thumb-frame {
            height: 170px !important;
            position: relative !important;
            background: var(--navy-950) !important;
            overflow: hidden !important;
        }

        .project-video-card .video-thumb-frame img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
        }

        .play-btn-circle {
            width: 40px !important;
            height: 40px !important;
            font-size: 0.85rem !important;
            background: #FFFFFF !important;
            color: var(--navy-900) !important;
            border-radius: 50% !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            box-shadow: var(--shadow-md) !important;
            transition: transform 0.15s ease !important;
        }

        .project-video-card:hover .play-btn-circle {
            transform: scale(1.08) !important;
        }

        .project-card-info {
            padding: 12px 14px !important;
            flex: 1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            background: #FFFFFF !important;
        }

        .project-card-info h4 {
            font-size: 0.88rem !important;
            font-weight: 600 !important;
            line-height: 1.35 !important;
            margin: 0 0 3px 0 !important;
            color: var(--navy-900) !important;
        }

        /* ── Packages Grid ── */
        .pricing-grid-3 {
            display: grid !important;
            grid-template-columns: repeat(auto-fill, minmax(290px, 1fr)) !important;
            gap: 16px !important;
            margin-top: 16px !important;
        }

        .package-card {
            background: #FFFFFF !important;
            border: 1px solid var(--slate-200) !important;
            border-radius: var(--radius-md) !important;
            padding: 18px 20px !important;
            box-shadow: var(--shadow-xs) !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            transition: border-color 0.15s ease, box-shadow 0.15s ease !important;
        }

        .package-card:hover {
            border-color: var(--slate-300) !important;
            box-shadow: var(--shadow-md) !important;
        }

        .plan-tier-label {
            font-size: 0.7rem !important;
            font-weight: 700 !important;
            color: var(--slate-500) !important;
            letter-spacing: 0.05em !important;
            text-transform: uppercase !important;
        }

        .plan-title {
            font-size: 1.05rem !important;
            font-weight: 700 !important;
            color: var(--navy-900) !important;
            margin: 4px 0 !important;
        }

        .plan-price {
            font-size: 1.35rem !important;
            font-weight: 800 !important;
            color: var(--navy-900) !important;
            margin: 6px 0 !important;
            letter-spacing: -0.01em !important;
        }

        .plan-price span {
            font-size: 0.75rem !important;
            color: var(--slate-500) !important;
            font-weight: 500 !important;
        }

        /* ── Custom Delete Confirmation Modal ── */
        .delete-modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.6);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 99999;
            padding: 18px;
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .delete-modal-backdrop.show { opacity: 1; }

        .delete-modal-card {
            background: #FFFFFF !important;
            border: 1px solid var(--slate-200) !important;
            box-shadow: var(--shadow-lg) !important;
            border-radius: var(--radius-lg) !important;
            padding: 26px !important;
            width: 100% !important;
            max-width: 420px !important;
            text-align: center !important;
            transform: scale(0.95);
            transition: transform 0.2s ease !important;
        }

        .delete-modal-backdrop.show .delete-modal-card { transform: scale(1); }

        .delete-icon-wrapper {
            width: 52px;
            height: 52px;
            margin: 0 auto 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--accent-red-subtle);
            border-radius: 50%;
            border: 1px solid #FECACA;
        }

        .delete-icon-glow { display: none; }
        .delete-icon-circle { background: transparent; border: none; box-shadow: none; }
        .delete-icon-symbol { font-size: 1.4rem; color: var(--accent-red); }

        .delete-modal-title {
            font-family: var(--font-main) !important;
            color: var(--navy-900) !important;
            font-size: 1.05rem !important;
            font-weight: 700 !important;
            letter-spacing: -0.01em !important;
            margin-bottom: 6px !important;
            text-transform: none !important;
        }

        .delete-modal-description {
            color: var(--slate-600) !important;
            font-size: 0.82rem !important;
            line-height: 1.45 !important;
            margin-bottom: 20px !important;
            padding: 0 4px !important;
        }

        .delete-modal-actions {
            display: flex;
            gap: 10px;
            justify-content: center;
        }

        .btn-delete-cancel {
            flex: 1;
            background: #FFFFFF !important;
            border: 1px solid var(--slate-300) !important;
            color: var(--slate-600) !important;
            font-size: 0.82rem !important;
            font-weight: 600 !important;
            padding: 8px 16px !important;
            border-radius: var(--radius-sm) !important;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-delete-cancel:hover {
            background: var(--slate-100) !important;
            color: var(--navy-900) !important;
        }

        .btn-delete-confirm {
            flex: 1.2;
            background: var(--accent-red) !important;
            border: 1px solid var(--accent-red) !important;
            color: #FFFFFF !important;
            font-size: 0.82rem !important;
            font-weight: 600 !important;
            padding: 8px 16px !important;
            border-radius: var(--radius-sm) !important;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: none !important;
        }

        .btn-delete-confirm:hover {
            background: #B91C1C !important;
            border-color: #B91C1C !important;
            transform: none !important;
        }

        /* ── Responsive ── */
        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
            }
            .admin-sidebar.mobile-open {
                transform: translateX(0);
                box-shadow: 0 0 30px rgba(0,0,0,0.3);
            }
            .admin-main-view {
                margin-left: 0;
                width: 100%;
            }
            .mobile-toggle-btn {
                display: inline-flex;
            }
            .admin-header-bar {
                padding: 0 16px;
            }
            .admin-body-content {
                padding: 16px;
            }
        }

        /* ── Sidebar Section Label (li.sidebar-section-title) ── */
        li.sidebar-section-title {
            padding: 14px 20px 5px;
            font-size: 0.6rem;
            font-weight: 800;
            color: #475569;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            list-style: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        li.sidebar-section-title::before {
            content: '';
            display: inline-block;
            width: 14px;
            height: 1px;
            background: #334155;
        }

        /* ── Sidebar Logo Mark (colorful amber gradient) ── */
        .admin-sidebar-logo .admin-logo-icon-wrap {
            width: 34px; height: 34px;
            border-radius: 8px;
            background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);
            color: #FFFFFF;
            display: flex; align-items: center; justify-content: center;
            font-size: 0.95rem; font-weight: 800;
            border: 1px solid rgba(217,119,6,0.5);
            box-shadow: 0 2px 8px rgba(217,119,6,0.35);
        }

        /* ── Colorful table row hover ── */
        .table-custom-dark tr:hover td {
            background: rgba(59,130,246,0.03) !important;
        }

        /* ── Colorful add/primary action button ── */
        .btn-primary-action {
            background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%) !important;
            color: #FFFFFF !important;
            border: none !important;
            border-radius: var(--radius-sm) !important;
            padding: 8px 18px !important;
            font-size: 0.8rem !important;
            font-weight: 700 !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 7px !important;
            transition: all 0.15s ease !important;
            white-space: nowrap !important;
            box-shadow: 0 2px 6px rgba(15,23,42,0.25) !important;
        }
        .btn-primary-action:hover {
            background: linear-gradient(135deg, #0F172A 0%, #020617 100%) !important;
            box-shadow: 0 4px 12px rgba(15,23,42,0.35) !important;
        }

        /* ── Colored status pills ── */
        .status-pill-new    { background: rgba(245,158,11,0.12); color: #D97706; border: 1px solid rgba(245,158,11,0.25); padding: 2px 10px; border-radius: 9999px; font-size: 0.7rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; }
        .status-pill-read   { background: rgba(16,185,129,0.1);  color: #059669; border: 1px solid rgba(16,185,129,0.2);  padding: 2px 10px; border-radius: 9999px; font-size: 0.7rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; }
        .status-pill-active { background: rgba(59,130,246,0.1);  color: #2563EB; border: 1px solid rgba(59,130,246,0.2);  padding: 2px 10px; border-radius: 9999px; font-size: 0.7rem; font-weight: 700; display: inline-flex; align-items: center; gap: 4px; }
    </style>
</head>
<body>

<div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-logo">
            <div style="display:flex;align-items:center;gap:10px;">
                <div style="width:34px;height:34px;border-radius:8px;background:linear-gradient(135deg,#F59E0B 0%,#D97706 100%);color:#FFFFFF;display:flex;align-items:center;justify-content:center;font-size:0.95rem;font-weight:800;border:1px solid rgba(217,119,6,0.5);box-shadow:0 2px 8px rgba(217,119,6,0.3);">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
                <div>
                    <div class="admin-title-badge">MAHA GROUP</div>
                    <div class="admin-sub-badge" id="adminSidebarSubBadge">ADMINISTRATION CONSOLE</div>
                </div>
            </div>
        </div>

        <!-- Sidebar Workspace Division Selector -->
        <div style="padding:12px 16px 10px;border-bottom:1px solid var(--navy-800);">
            <div style="font-size:0.62rem;font-weight:800;color:var(--slate-400);letter-spacing:0.1em;text-transform:uppercase;margin-bottom:8px;display:flex;align-items:center;justify-content:space-between;">
                <span>ACTIVE WORKSPACE</span>
                <span id="sidebarActiveDivisionIndicator" style="color:{{ $activeDivision === 'interior' ? '#D97706' : '#10B981' }};font-size:0.6rem;font-weight:700;">● {{ $activeDivision === 'interior' ? 'INTERIOR' : 'CONST' }}</span>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:5px;background:rgba(15,23,42,0.9);padding:3px;border-radius:8px;border:1px solid rgba(255,255,255,0.08);">
                <a href="{{ route('admin.construction') }}" id="sideDivConst" style="text-decoration:none;border:none;background:{{ $activeDivision === 'construction' ? '#FFFFFF' : 'transparent' }};color:{{ $activeDivision === 'construction' ? 'var(--navy-900)' : 'var(--slate-400)' }};padding:6px 8px;font-size:0.72rem;font-weight:800;border-radius:6px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:5px;transition:all 0.2s cubic-bezier(0.16,1,0.3,1);box-shadow:{{ $activeDivision === 'construction' ? '0 1px 4px rgba(0,0,0,0.15)' : 'none' }};">
                    <i class="fa-solid fa-building" style="color:{{ $activeDivision === 'construction' ? 'var(--navy-900)' : 'var(--slate-400)' }};"></i> <span>Const.</span>
                </a>
                <a href="{{ route('admin.interior') }}" id="sideDivInt" style="text-decoration:none;border:none;background:{{ $activeDivision === 'interior' ? '#FFFFFF' : 'transparent' }};color:{{ $activeDivision === 'interior' ? 'var(--navy-900)' : 'var(--slate-400)' }};padding:6px 8px;font-size:0.72rem;font-weight:800;border-radius:6px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:5px;transition:all 0.2s cubic-bezier(0.16,1,0.3,1);box-shadow:{{ $activeDivision === 'interior' ? '0 1px 4px rgba(0,0,0,0.15)' : 'none' }};">
                    <i class="fa-solid fa-couch" style="color:{{ $activeDivision === 'interior' ? 'var(--navy-900)' : 'var(--slate-400)' }};"></i> <span>Interior</span>
                </a>
            </div>
        </div>

        <ul class="sidebar-nav-list">
            <li class="sidebar-section-title" id="sidebarSectionOperations">{{ $activeDivision === 'interior' ? 'INTERIOR OPERATIONS' : 'CONSTRUCTION OPERATIONS' }}</li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('analytics', this)">
                    <i class="fa-solid fa-chart-line nav-icon icon-analytics"></i>
                    <span id="sidebarLabelAnalytics">{{ $activeDivision === 'interior' ? 'Interior Analytics' : 'Construction Analytics' }}</span>
                    <span class="badge-count live-pill">LIVE</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link active" onclick="switchAdminTab('reviews', this)">
                    <i class="fa-solid fa-video nav-icon icon-video"></i>
                    <span id="sidebarLabelReviews">{{ $activeDivision === 'interior' ? 'Interior Video Reviews' : 'Homeowner Testimonials' }}</span>
                    <span class="badge-count bc-rose" id="sidebarReviewsCount">{{ $stats['reviews'] }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('projects', this)">
                    <i class="fa-solid fa-building-circle-check nav-icon icon-projects"></i>
                    <span id="sidebarLabelProjects">{{ $activeDivision === 'interior' ? 'Interior Projects' : 'Completed Buildings' }}</span>
                    <span class="badge-count bc-blue" id="sidebarProjectsCount">{{ $stats['projects'] }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('packages', this)">
                    <i class="fa-solid fa-cubes nav-icon icon-packages"></i>
                    <span id="sidebarLabelPackages">{{ $activeDivision === 'interior' ? 'Interior Packages' : 'Building Packages' }}</span>
                    <span class="badge-count bc-violet" id="sidebarPackagesCount">{{ $stats['packages'] }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('quotes', this)">
                    <i class="fa-solid fa-inbox nav-icon icon-leads"></i>
                    <span id="sidebarLabelQuotes">{{ $activeDivision === 'interior' ? 'Design Consultations' : 'Building Inquiries' }}</span>
                    <span class="badge-count bc-amber" id="sidebarQuotesCount">{{ $stats['quotes'] }}</span>
                </a>
            </li>

            <li class="sidebar-section-title">MEDIA &amp; PARTNERS</li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('youtube', this)">
                    <i class="fa-brands fa-youtube nav-icon icon-youtube"></i>
                    <span id="sidebarLabelYoutube">YouTube Channels</span>
                    <span class="badge-count bc-red" id="sidebarYtCount">{{ ($settings['youtube_video_count'] ?? null)?->value ?? '0' }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('partners', this)">
                    <i class="fa-solid fa-handshake nav-icon icon-banking"></i>
                    <span>Banking &amp; Vendors</span>
                    <span class="badge-count bc-cyan">{{ \App\Models\Partner::count() }}</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('intro', this)">
                    <i class="fa-solid fa-clapperboard nav-icon icon-intro"></i>
                    <span>Intro Video</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('guidebook', this)">
                    <i class="fa-solid fa-file-pdf nav-icon icon-guidebook"></i>
                    <span>Guidebook Downloads</span>
                    <span class="badge-count bc-red">{{ \App\Models\GuidebookLead::count() }}</span>
                </a>
            </li>

            <li class="sidebar-section-title">SYSTEM &amp; CONFIG</li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('contact', this)">
                    <i class="fa-solid fa-address-book nav-icon icon-contact"></i>
                    <span>Office &amp; Contact</span>
                </a>
            </li>
            <li>
                <a href="#" class="sidebar-nav-link" onclick="switchAdminTab('security', this)">
                    <i class="fa-solid fa-shield-halved nav-icon icon-security"></i>
                    <span>Account Security</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main View -->
    <main class="admin-main-view">
        <!-- Top Bar with Division Switcher -->
        <header class="admin-header-bar">
            <div style="display:flex;align-items:center;gap:14px;">
                <button type="button" class="mobile-toggle-btn" onclick="toggleAdminSidebar()" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <div>
                    <div class="admin-panel-title">Operations Console</div>
                    <div class="admin-panel-sub" id="adminHeaderConsoleSub">{{ $activeDivision === 'interior' ? 'Maha Interior — Bespoke Design & Turnkey Fitouts' : 'Maha Construction — Luxury Villas & Structural Building' }}</div>
                </div>
            </div>

            <!-- Division Switcher Bar -->
            <div class="division-switcher">
                <a href="{{ route('admin.construction') }}" id="btnDivConstruction" class="division-btn {{ $activeDivision === 'construction' ? 'active' : '' }}" style="text-decoration:none;">
                    <i class="fa-solid fa-building" style="margin-right:6px;"></i> CONSTRUCTION
                </a>
                <a href="{{ route('admin.interior') }}" id="btnDivInterior" class="division-btn {{ $activeDivision === 'interior' ? 'active' : '' }}" style="text-decoration:none;">
                    <i class="fa-solid fa-couch" style="margin-right:6px;"></i> INTERIOR
                </a>
            </div>

            <div style="display:flex;gap:10px;align-items:center;">
                <a id="adminLiveWebsiteLink" href="{{ $activeDivision === 'interior' ? route('interior') : route('home') }}" target="_blank" class="btn-whatsapp-outline" style="font-size:0.78rem;padding:7px 14px;">
                    <i class="{{ $activeDivision === 'interior' ? 'fa-solid fa-couch' : 'fa-solid fa-building' }}" style="margin-right:5px;font-size:0.75rem;"></i> Live {{ $activeDivision === 'interior' ? 'Interior Site' : 'Construction Site' }}
                </a>
                <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-header-logout" title="Sign out of administration">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Logout
                    </button>
                </form>
            </div>
        </header>

        <!-- Body Content -->
        <div class="admin-body-content">

            <!-- 0. WEBSITE & LEAD ANALYTICS TAB -->
            <div class="admin-tab-pane" id="tab-analytics">
                <div class="card-dark-panel" style="margin-bottom:20px;">
                    <!-- Top Bar: Title & Selectors -->
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;margin-bottom:24px;">
                        <div>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <h2 class="panel-header-title" style="margin-bottom:0;"><i class="fa-solid fa-chart-line" style="color:var(--navy-900);margin-right:6px;"></i> Website & Lead Analytics</h2>
                                <span style="background:rgba(22,163,74,0.12);color:var(--accent-green);border:1px solid rgba(22,163,74,0.25);padding:2px 8px;border-radius:12px;font-size:0.68rem;font-weight:700;letter-spacing:0.04em;">LIVE METRICS</span>
                            </div>
                            <p class="panel-header-sub" style="margin-bottom:0;margin-top:3px;">Actionable performance intelligence across Construction & Interior divisions</p>
                        </div>

                        <!-- Action Toolbar: Division Filter, Period Filter & Refresh -->
                        <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                            <!-- Division Selector -->
                            <div class="analytics-pill-group" id="analyticsDivisionGroup">
                                <button type="button" class="analytics-pill-btn {{ $activeDivision === 'construction' ? 'active' : '' }}" onclick="setAnalyticsDivision('construction')" id="btnDivConst">
                                    <i class="fa-solid fa-building" style="margin-right:4px;"></i> Construction
                                </button>
                                <button type="button" class="analytics-pill-btn {{ $activeDivision === 'interior' ? 'active' : '' }}" onclick="setAnalyticsDivision('interior')" id="btnDivInt">
                                    <i class="fa-solid fa-couch" style="margin-right:4px;"></i> Interior
                                </button>
                                <button type="button" class="analytics-pill-btn" onclick="setAnalyticsDivision('all')" id="btnDivAll">
                                    ALL
                                </button>
                            </div>

                            <!-- Date Period Selector -->
                            <div class="analytics-pill-group" id="analyticsPeriodGroup">
                                <button type="button" class="analytics-pill-btn" onclick="setAnalyticsPeriod('today')" id="btnPeriodToday">TODAY</button>
                                <button type="button" class="analytics-pill-btn" onclick="setAnalyticsPeriod('7days')" id="btnPeriod7days">7 DAYS</button>
                                <button type="button" class="analytics-pill-btn active" onclick="setAnalyticsPeriod('30days')" id="btnPeriod30days">30 DAYS</button>
                                <button type="button" class="analytics-pill-btn" onclick="setAnalyticsPeriod('3months')" id="btnPeriod3months">3 MONTHS</button>
                                <button type="button" class="analytics-pill-btn" onclick="setAnalyticsPeriod('1year')" id="btnPeriod1year">1 YEAR</button>
                            </div>

                            <button type="button" onclick="fetchAdminAnalytics()" class="btn-gold-pill" style="padding:6px 14px;font-size:0.75rem;display:inline-flex;align-items:center;gap:6px;" title="Refresh Analytics Data">
                                <i class="fa-solid fa-arrows-rotate" id="analyticsRefreshIcon"></i> Refresh
                            </button>
                        </div>
                    </div>

                    <!-- 5 Primary Metric KPI Cards -->
                    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(180px, 1fr));gap:14px;margin-bottom:20px;">
                        <!-- Card 1: Visitors -->
                        <div class="kpi-card-metric">
                            <div>
                                <div class="kpi-card-label">Unique Visitors</div>
                                <div class="kpi-card-value" id="kpiVisitors">0</div>
                            </div>
                            <div class="kpi-card-sub" id="kpiVisitorBreakdown">
                                <span>New: <b id="kpiNewVisitors">0</b></span> • <span>Returning: <b id="kpiReturningVisitors">0</b></span>
                            </div>
                        </div>

                        <!-- Card 2: Page Views -->
                        <div class="kpi-card-metric">
                            <div>
                                <div class="kpi-card-label">Page Views</div>
                                <div class="kpi-card-value" id="kpiPageViews">0</div>
                            </div>
                            <div class="kpi-card-sub">
                                Total Events: <b id="kpiTotalEvents" style="color:var(--navy-900);">0</b>
                            </div>
                        </div>

                        <!-- Card 3: Sessions -->
                        <div class="kpi-card-metric">
                            <div>
                                <div class="kpi-card-label">Sessions / Visits</div>
                                <div class="kpi-card-value" id="kpiSessions">0</div>
                            </div>
                            <div class="kpi-card-sub">
                                30-min browsing windows
                            </div>
                        </div>

                        <!-- Card 4: Enquiries & Consultations -->
                        <div class="kpi-card-metric">
                            <div>
                                <div class="kpi-card-label">Total Leads</div>
                                <div class="kpi-card-value" style="color:var(--accent-green);" id="kpiEnquiries">0</div>
                            </div>
                            <div class="kpi-card-sub">
                                Consultations: <b id="kpiConsultations" style="color:var(--accent-green);">0</b>
                            </div>
                        </div>

                        <!-- Card 5: Conversion Rate -->
                        <div class="kpi-card-metric">
                            <div>
                                <div class="kpi-card-label">Conversion Rate</div>
                                <div class="kpi-card-value" id="kpiConversionRate">0.00%</div>
                            </div>
                            <div class="kpi-card-sub" title="Formula: (Successful Enquiries / Unique Visitors) × 100">
                                Leads / Visitors × 100
                            </div>
                        </div>
                    </div>

                    <!-- Construction vs Interior Head-to-Head Comparison Strip -->
                    <div style="background:#FFFFFF;border:1px solid var(--slate-200);border-radius:var(--radius-md);padding:16px 20px;margin-bottom:20px;box-shadow:var(--shadow-xs);">
                        <div style="font-size:0.8rem;font-weight:700;color:var(--navy-900);letter-spacing:0.04em;text-transform:uppercase;margin-bottom:12px;display:flex;align-items:center;justify-content:space-between;">
                            <span style="display:flex;align-items:center;gap:8px;"><i class="fa-solid fa-code-compare" style="color:var(--navy-800);"></i> Division Performance Comparison</span>
                            <span style="font-size:0.72rem;color:var(--slate-500);font-weight:500;text-transform:none;">Division-specific filtering active</span>
                        </div>
                        <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(280px, 1fr));gap:16px;">
                            <!-- Construction Column -->
                            <div style="background:var(--slate-50);border:1px solid var(--slate-200);border-radius:var(--radius-sm);padding:14px;">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;border-bottom:1px solid var(--slate-200);padding-bottom:8px;">
                                    <span style="font-weight:700;font-size:0.82rem;color:var(--navy-900);"><i class="fa-solid fa-building" style="margin-right:6px;color:var(--navy-800);"></i> Maha Construction</span>
                                    <span style="font-size:0.72rem;color:var(--slate-600);font-weight:700;">CONV: <b id="constConvRate" style="color:var(--navy-900);">0.00%</b></span>
                                </div>
                                <div style="display:grid;grid-template-columns:repeat(4, 1fr);gap:8px;text-align:center;">
                                    <div>
                                        <div style="font-size:0.68rem;color:var(--slate-500);font-weight:600;">VISITORS</div>
                                        <div style="font-size:1.05rem;font-weight:800;color:var(--navy-900);margin-top:2px;" id="constVisitors">0</div>
                                    </div>
                                    <div>
                                        <div style="font-size:0.68rem;color:var(--slate-500);font-weight:600;">SESSIONS</div>
                                        <div style="font-size:1.05rem;font-weight:800;color:var(--navy-900);margin-top:2px;" id="constSessions">0</div>
                                    </div>
                                    <div>
                                        <div style="font-size:0.68rem;color:var(--slate-500);font-weight:600;">VIEWS</div>
                                        <div style="font-size:1.05rem;font-weight:800;color:var(--navy-900);margin-top:2px;" id="constPageViews">0</div>
                                    </div>
                                    <div>
                                        <div style="font-size:0.68rem;color:var(--slate-500);font-weight:600;">LEADS</div>
                                        <div style="font-size:1.05rem;font-weight:800;color:var(--accent-green);margin-top:2px;" id="constEnquiries">0</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Interior Column -->
                            <div style="background:var(--slate-50);border:1px solid var(--slate-200);border-radius:var(--radius-sm);padding:14px;">
                                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:10px;border-bottom:1px solid var(--slate-200);padding-bottom:8px;">
                                    <span style="font-weight:700;font-size:0.82rem;color:var(--navy-900);"><i class="fa-solid fa-couch" style="margin-right:6px;color:var(--navy-800);"></i> Maha Interior</span>
                                    <span style="font-size:0.72rem;color:var(--slate-600);font-weight:700;">CONV: <b id="intConvRate" style="color:var(--navy-900);">0.00%</b></span>
                                </div>
                                <div style="display:grid;grid-template-columns:repeat(4, 1fr);gap:8px;text-align:center;">
                                    <div>
                                        <div style="font-size:0.68rem;color:var(--slate-500);font-weight:600;">VISITORS</div>
                                        <div style="font-size:1.05rem;font-weight:800;color:var(--navy-900);margin-top:2px;" id="intVisitors">0</div>
                                    </div>
                                    <div>
                                        <div style="font-size:0.68rem;color:var(--slate-500);font-weight:600;">SESSIONS</div>
                                        <div style="font-size:1.05rem;font-weight:800;color:var(--navy-900);margin-top:2px;" id="intSessions">0</div>
                                    </div>
                                    <div>
                                        <div style="font-size:0.68rem;color:var(--slate-500);font-weight:600;">VIEWS</div>
                                        <div style="font-size:1.05rem;font-weight:800;color:var(--navy-900);margin-top:2px;" id="intPageViews">0</div>
                                    </div>
                                    <div>
                                        <div style="font-size:0.68rem;color:var(--slate-500);font-weight:600;">LEADS</div>
                                        <div style="font-size:1.05rem;font-weight:800;color:var(--accent-green);margin-top:2px;" id="intEnquiries">0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Charts Grid -->
                    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(420px, 1fr));gap:16px;margin-bottom:20px;">
                        <!-- Chart 1: Visitors & Views Over Time -->
                        <div style="background:#FFFFFF;border:1px solid var(--slate-200);border-radius:var(--radius-md);padding:18px 20px;box-shadow:var(--shadow-xs);">
                            <div style="font-size:0.85rem;font-weight:700;color:var(--navy-900);margin-bottom:4px;">
                                <i class="fa-solid fa-chart-area" style="color:var(--navy-800);margin-right:6px;"></i> Visitors & Page Views Over Time
                            </div>
                            <p style="font-size:0.75rem;color:var(--slate-500);margin-bottom:14px;">Daily visitor volume and page interactions across selected date window</p>
                            <div style="position:relative;height:250px;width:100%;">
                                <canvas id="chartVisitorsTimeline"></canvas>
                            </div>
                        </div>

                        <!-- Chart 2: Construction vs Interior Comparison -->
                        <div style="background:#FFFFFF;border:1px solid var(--slate-200);border-radius:var(--radius-md);padding:18px 20px;box-shadow:var(--shadow-xs);">
                            <div style="font-size:0.85rem;font-weight:700;color:var(--navy-900);margin-bottom:4px;">
                                <i class="fa-solid fa-chart-simple" style="color:var(--navy-800);margin-right:6px;"></i> Construction vs Interior Traffic & Leads
                            </div>
                            <p style="font-size:0.75rem;color:var(--slate-500);margin-bottom:14px;">Comparative breakdown of visitor reach and lead generation</p>
                            <div style="position:relative;height:250px;width:100%;">
                                <canvas id="chartDivisionComparison"></canvas>
                            </div>
                        </div>

                        <!-- Chart 3: Traffic Sources -->
                        <div style="background:#FFFFFF;border:1px solid var(--slate-200);border-radius:var(--radius-md);padding:18px 20px;box-shadow:var(--shadow-xs);">
                            <div style="font-size:0.85rem;font-weight:700;color:var(--navy-900);margin-bottom:4px;">
                                <i class="fa-solid fa-compass" style="color:var(--navy-800);margin-right:6px;"></i> Traffic Sources Breakdown
                            </div>
                            <p style="font-size:0.75rem;color:var(--slate-500);margin-bottom:14px;">Referral origins including Organic Search, Social, Direct & Campaigns</p>
                            <div style="position:relative;height:250px;width:100%;">
                                <canvas id="chartTrafficSources"></canvas>
                            </div>
                        </div>

                        <!-- Chart 4: Device Breakdown -->
                        <div style="background:#FFFFFF;border:1px solid var(--slate-200);border-radius:var(--radius-md);padding:18px 20px;box-shadow:var(--shadow-xs);">
                            <div style="font-size:0.85rem;font-weight:700;color:var(--navy-900);margin-bottom:4px;">
                                <i class="fa-solid fa-mobile-screen" style="color:var(--navy-800);margin-right:6px;"></i> Device Usage Breakdown
                            </div>
                            <p style="font-size:0.75rem;color:var(--slate-500);margin-bottom:14px;">Distribution of visitors by Mobile, Desktop and Tablet hardware</p>
                            <div style="position:relative;height:250px;width:100%;">
                                <canvas id="chartDeviceBreakdown"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Interior 7-Section Funnel Performance -->
                    <div style="background:#FFFFFF;border:1px solid var(--slate-200);border-radius:var(--radius-md);padding:18px 20px;margin-bottom:20px;box-shadow:var(--shadow-xs);">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:6px;flex-wrap:wrap;gap:8px;">
                            <div style="font-size:0.88rem;font-weight:700;color:var(--navy-900);">
                                <i class="fa-solid fa-filter" style="color:var(--navy-800);margin-right:6px;"></i> Interior Single-Page Section Funnel (#interior)
                            </div>
                            <span style="font-size:0.72rem;color:var(--slate-500);">De-duplicated per session via 1000ms dwell observer</span>
                        </div>
                        <p style="font-size:0.78rem;color:var(--slate-500);margin-bottom:16px;">Shows visitor flow and drop-off through the 7 core sections of the single-page showcase.</p>
                        <div style="position:relative;height:230px;width:100%;">
                            <canvas id="chartSectionFunnel"></canvas>
                        </div>
                    </div>

                    <!-- Top Pages & Content Performance Tables -->
                    <div style="display:grid;grid-template-columns:repeat(auto-fit, minmax(380px, 1fr));gap:16px;margin-bottom:20px;">
                        <!-- Table: Top Pages -->
                        <div style="background:#FFFFFF;border:1px solid var(--slate-200);border-radius:var(--radius-md);padding:18px 20px;box-shadow:var(--shadow-xs);">
                            <div style="font-size:0.85rem;font-weight:700;color:var(--navy-900);margin-bottom:12px;">
                                <i class="fa-solid fa-file-lines" style="color:var(--navy-800);margin-right:6px;"></i> Top Visited Pages
                            </div>
                            <div style="overflow-x:auto;">
                                <table class="table-custom-dark" style="margin-top:0;">
                                    <thead>
                                        <tr>
                                            <th>PAGE</th>
                                            <th>VIEWS</th>
                                            <th>UNIQUE VISITORS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableTopPagesBody">
                                        <tr><td colspan="3" style="text-align:center;color:var(--slate-500);">Loading top pages...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Table: Top Content / Traffic Sources -->
                        <div style="background:#FFFFFF;border:1px solid var(--slate-200);border-radius:var(--radius-md);padding:18px 20px;box-shadow:var(--shadow-xs);">
                            <div style="font-size:0.85rem;font-weight:700;color:var(--navy-900);margin-bottom:12px;">
                                <i class="fa-solid fa-globe" style="color:var(--navy-800);margin-right:6px;"></i> Top Referrer Channels
                            </div>
                            <div style="overflow-x:auto;">
                                <table class="table-custom-dark" style="margin-top:0;">
                                    <thead>
                                        <tr>
                                            <th>SOURCE</th>
                                            <th>VISITORS</th>
                                            <th>TOTAL EVENTS</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableTopSourcesBody">
                                        <tr><td colspan="3" style="text-align:center;color:var(--slate-500);">Loading sources...</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Leads With Attribution -->
                    <div style="background:#FFFFFF;border:1px solid var(--slate-200);border-radius:var(--radius-md);padding:18px 20px;box-shadow:var(--shadow-xs);">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;flex-wrap:wrap;gap:8px;">
                            <div style="font-size:0.88rem;font-weight:700;color:var(--navy-900);">
                                <i class="fa-solid fa-bullseye" style="color:var(--navy-800);margin-right:6px;"></i> Recent Inbound Leads with Marketing Attribution
                            </div>
                            <span style="font-size:0.72rem;color:var(--slate-500);">Privacy-conscious visitor context without raw personal tracking</span>
                        </div>
                        <div style="overflow-x:auto;">
                            <table class="table-custom-dark" style="margin-top:0;">
                                <thead>
                                    <tr>
                                        <th>LEAD ID</th>
                                        <th>DIVISION</th>
                                        <th>CLIENT NAME</th>
                                        <th>PHONE</th>
                                        <th>PROJECT TYPE</th>
                                        <th>TRAFFIC SOURCE</th>
                                        <th>DEVICE</th>
                                        <th>LANDING PAGE</th>
                                        <th>DATE</th>
                                    </tr>
                                </thead>
                                <tbody id="tableRecentLeadsBody">
                                    <tr><td colspan="9" style="text-align:center;color:var(--slate-500);">Loading recent leads...</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <!-- 1. CLIENT VIDEO REVIEWS TAB -->
            <div class="admin-tab-pane active" id="tab-reviews">
                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                        <div>
                            <h2 class="panel-header-title" id="title-reviews"><i class="{{ $activeDivision === 'interior' ? 'fa-solid fa-couch' : 'fa-solid fa-video' }}" style="margin-right:8px;color:var(--navy-900);"></i> {{ $activeDivision === 'interior' ? 'Luxury Interior Video Reviews' : 'Client Video Testimonials' }}</h2>
                            <p class="panel-header-sub" id="sub-reviews">{{ $activeDivision === 'interior' ? 'Manage walkthrough and testimonial videos from luxury interior clients.' : 'Upload video files or video links from verified homeowners.' }}</p>
                        </div>
                        <button class="btn-gold-pill" id="action-btn-reviews" onclick="openUploadModal('testimonial')"><i class="fa-solid fa-plus" style="margin-right:6px;"></i> {{ $activeDivision === 'interior' ? 'Upload Interior Review' : 'Upload Video Review' }}</button>
                    </div>

                    <!-- Division Scope Banner -->
                    <div class="division-scope-banner" id="banner-reviews">
                        <div class="division-scope-info">
                            <span class="division-scope-badge" id="badge-reviews">
                                <span class="scope-dot"></span>
                                <span id="badge-text-reviews">{{ $activeDivision === 'interior' ? 'INTERIOR STUDIO RECORDS' : 'CONSTRUCTION DIVISION RECORDS' }}</span>
                            </span>
                            <span class="division-scope-desc" id="desc-reviews">
                                {{ $activeDivision === 'interior' ? 'Showing video reviews from verified interior clients across Tamil Nadu.' : 'Showing video testimonials from verified home building clients.' }}
                            </span>
                        </div>
                        <a href="{{ $activeDivision === 'interior' ? route('admin.construction') : route('admin.interior') }}" class="division-scope-switch-btn" id="switch-btn-reviews" style="text-decoration:none;">
                            <span>{{ $activeDivision === 'interior' ? 'Switch to Construction Division' : 'Switch to Interior Studio' }}</span>
                            <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i>
                        </a>
                    </div>

                    <div class="projects-grid-2">
                        @foreach($testimonials as $item)
                        <div class="project-video-card division-filterable" data-business-type="{{ $item->business_type ?? 'construction' }}">
                            <div class="video-thumb-frame" style="height:200px;position:relative;">
                                <img src="{{ $item->image_url ?? 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80' }}" style="width:100%;height:100%;object-fit:cover;" alt="Review">
                                <span style="position:absolute;top:10px;right:10px;z-index:2;background:{{ ($item->business_type ?? 'construction') === 'interior' ? 'rgba(37,99,235,0.92)' : 'rgba(15,23,42,0.92)' }};color:#FFFFFF;padding:3px 8px;border-radius:4px;font-size:0.68rem;font-weight:700;text-transform:uppercase;">
                                    {{ $item->business_type ?? 'construction' }}
                                </span>
                                <div class="video-play-overlay" onclick="window.playVideoModal('{{ $item->video_url }}')">
                                    <div class="play-btn-circle" style="width:44px;height:44px;font-size:0.9rem;"><i class="fa-solid fa-play" style="margin-left:2px;"></i></div>
                                </div>
                            </div>
                            <div class="project-card-info" style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;">
                                <div>
                                    <h4 style="color:var(--navy-900);font-size:0.92rem;font-weight:700;margin:0 0 3px 0;">{{ $item->client_name }}</h4>
                                    <span style="font-size:0.78rem;color:var(--slate-500);">{{ $item->project_name ?? 'Maha Group' }}</span>
                                </div>
                                <div style="display:flex;gap:6px;">
                                    <button type="button" class="action-edit-btn" onclick='openEditModal("testimonial", @json($item))' title="Edit Review"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button type="button" class="action-del-btn" onclick="deleteItem(event, 'testimonials', {{ $item->id }}, this)" title="Delete Review"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="reviewsEmptyState" class="empty-division-state" style="{{ $testimonials->isEmpty() ? 'display:block;' : 'display:none;' }}padding:40px;text-align:center;color:var(--slate-500);">No video testimonials found for the {{ $activeDivision }} division.</div>
                </div>
            </div>

            <!-- 2. COMPLETED PROJECTS TAB -->
            <div class="admin-tab-pane" id="tab-projects">
                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                        <div>
                            <h2 class="panel-header-title" id="title-projects"><i class="{{ $activeDivision === 'interior' ? 'fa-solid fa-couch' : 'fa-solid fa-building-circle-check' }}" style="margin-right:8px;color:var(--navy-900);"></i> {{ $activeDivision === 'interior' ? 'Luxury Interior Design Projects' : 'Completed Projects Walkthroughs' }}</h2>
                            <p class="panel-header-sub" id="sub-projects">{{ $activeDivision === 'interior' ? 'Showcase modular kitchens, living spaces, bedrooms, and commercial interior fitouts.' : 'Manage walkthrough videos, full-resolution photos & project specifications.' }}</p>
                        </div>
                        <button class="btn-gold-pill" id="action-btn-projects" onclick="openUploadModal('project')"><i class="fa-solid fa-plus" style="margin-right:6px;"></i> {{ $activeDivision === 'interior' ? 'Add Interior Project' : 'Add Completed Project' }}</button>
                    </div>

                    <!-- Division Scope Banner -->
                    <div class="division-scope-banner" id="banner-projects">
                        <div class="division-scope-info">
                            <span class="division-scope-badge" id="badge-projects">
                                <span class="scope-dot"></span>
                                <span id="badge-text-projects">{{ $activeDivision === 'interior' ? 'INTERIOR STUDIO RECORDS' : 'CONSTRUCTION DIVISION RECORDS' }}</span>
                            </span>
                            <span class="division-scope-desc" id="desc-projects">
                                {{ $activeDivision === 'interior' ? 'Managing modular kitchens, bespoke living rooms, wardrobes, and commercial spaces.' : 'Managing luxury villas, architectural homes, and turnkey structural buildings.' }}
                            </span>
                        </div>
                        <a href="{{ $activeDivision === 'interior' ? route('admin.construction') : route('admin.interior') }}" class="division-scope-switch-btn" id="switch-btn-projects" style="text-decoration:none;">
                            <span>{{ $activeDivision === 'interior' ? 'Switch to Construction Division' : 'Switch to Interior Studio' }}</span>
                            <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i>
                        </a>
                    </div>

                    <div class="projects-grid-2">
                        @foreach($projects as $project)
                        <div class="project-video-card division-filterable" data-business-type="{{ $project->business_type ?? 'construction' }}">
                            <div class="video-thumb-frame" style="height:200px;position:relative;">
                                <img src="{{ ($project->image_urls && count($project->image_urls)>0) ? $project->image_urls[0] : 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=600&q=80' }}" style="width:100%;height:100%;object-fit:cover;" alt="Project">
                                <span style="position:absolute;top:10px;right:10px;z-index:2;background:{{ ($project->business_type ?? 'construction') === 'interior' ? 'rgba(37,99,235,0.92)' : 'rgba(15,23,42,0.92)' }};color:#FFFFFF;padding:3px 8px;border-radius:4px;font-size:0.68rem;font-weight:700;text-transform:uppercase;">
                                    {{ $project->business_type ?? 'construction' }}
                                </span>
                                @php
                                    $pImgCount = is_array($project->image_urls) ? count($project->image_urls) : 0;
                                @endphp
                                @if($pImgCount > 1)
                                <span style="position:absolute;bottom:10px;left:10px;z-index:2;background:rgba(15,23,42,0.85);color:#FFFFFF;padding:2px 8px;border-radius:4px;font-size:0.68rem;font-weight:700;backdrop-filter:blur(4px);">
                                    <i class="fa-solid fa-images" style="margin-right:4px;"></i> {{ $pImgCount }} Photos
                                </span>
                                @endif
                                @if($project->video_url)
                                <div class="video-play-overlay" onclick="window.playVideoModal('{{ $project->video_url }}')">
                                    <div class="play-btn-circle" style="width:44px;height:44px;font-size:0.9rem;"><i class="fa-solid fa-play" style="margin-left:2px;"></i></div>
                                </div>
                                @endif
                            </div>
                            <div class="project-card-info" style="display:flex;justify-content:space-between;align-items:center;padding:12px 14px;">
                                <div>
                                    <h4 style="color:var(--navy-900);font-size:0.92rem;font-weight:700;margin:0 0 3px 0;">{{ $project->name }}</h4>
                                    <span style="font-size:0.78rem;color:var(--slate-500);"><i class="fa-solid fa-location-dot" style="margin-right:4px;"></i> {{ $project->location ?? 'Nagercoil' }}</span>
                                </div>
                                <div style="display:flex;gap:6px;">
                                    <button type="button" class="action-edit-btn" onclick='openEditModal("project", @json($project))' title="Edit Project"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button type="button" class="action-del-btn" onclick="deleteItem(event, 'projects', {{ $project->id }}, this)" title="Delete Project"><i class="fa-solid fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="projectsEmptyState" class="empty-division-state" style="{{ $projects->isEmpty() ? 'display:block;' : 'display:none;' }}padding:40px;text-align:center;color:var(--slate-500);">No completed projects found for the {{ $activeDivision }} division.</div>
                </div>
            </div>

            <!-- 3. CONSTRUCTION PACKAGES TAB -->
            <div class="admin-tab-pane" id="tab-packages">
                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                        <div>
                            <h2 class="panel-header-title" id="title-packages"><i class="{{ $activeDivision === 'interior' ? 'fa-solid fa-couch' : 'fa-solid fa-cubes' }}" style="margin-right:8px;color:var(--navy-900);"></i> {{ $activeDivision === 'interior' ? 'Luxury Interior Packages & Pricing' : 'Building Construction Packages & Pricing' }}</h2>
                            <p class="panel-header-sub" id="sub-packages">{{ $activeDivision === 'interior' ? 'Manage turnkey interior packages, modular kitchen tiers, and per sq.ft estimates.' : 'Manage per sq.ft pricing & specification details for Residential & Commercial packages.' }}</p>
                        </div>
                        <button class="btn-gold-pill" id="action-btn-packages" onclick="openUploadModal('package')"><i class="fa-solid fa-plus" style="margin-right:6px;"></i> {{ $activeDivision === 'interior' ? 'Add Interior Package' : 'Add Construction Package' }}</button>
                    </div>

                    <!-- Division Scope Banner -->
                    <div class="division-scope-banner" id="banner-packages">
                        <div class="division-scope-info">
                            <span class="division-scope-badge" id="badge-packages">
                                <span class="scope-dot"></span>
                                <span id="badge-text-packages">{{ $activeDivision === 'interior' ? 'INTERIOR STUDIO RECORDS' : 'CONSTRUCTION DIVISION RECORDS' }}</span>
                            </span>
                            <span class="division-scope-desc" id="desc-packages">
                                {{ $activeDivision === 'interior' ? 'Managing modular kitchen packages, bedroom woodwork, and turnkey interior rates.' : 'Managing building packages, structural rates, and material specification tiers.' }}
                            </span>
                        </div>
                        <a href="{{ $activeDivision === 'interior' ? route('admin.construction') : route('admin.interior') }}" class="division-scope-switch-btn" id="switch-btn-packages" style="text-decoration:none;">
                            <span>{{ $activeDivision === 'interior' ? 'Switch to Construction Division' : 'Switch to Interior Studio' }}</span>
                            <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i>
                        </a>
                    </div>

                    <div class="pricing-grid-3">
                        @foreach($packages as $package)
                        <div class="package-card division-filterable" data-business-type="{{ $package->business_type ?? 'construction' }}" style="padding:18px 20px;">
                            <div style="display:flex;justify-content:space-between;align-items:center;">
                                <span class="plan-tier-label">{{ strtoupper($package->division) }} • {{ strtoupper($package->tier) }}</span>
                                <div style="display:flex;gap:6px;align-items:center;">
                                    <span style="font-size:0.68rem;background:{{ ($package->business_type ?? 'construction') === 'interior' ? 'rgba(37,99,235,0.1)' : 'rgba(15,23,42,0.08)' }};color:{{ ($package->business_type ?? 'construction') === 'interior' ? '#1D4ED8' : '#0F172A' }};border:1px solid {{ ($package->business_type ?? 'construction') === 'interior' ? 'rgba(37,99,235,0.2)' : 'rgba(15,23,42,0.15)' }};padding:2px 6px;border-radius:4px;font-weight:700;text-transform:uppercase;">
                                        {{ $package->business_type ?? 'construction' }}
                                    </span>
                                    @if($package->is_highlighted)
                                    <span style="font-size:0.65rem;background:rgba(212,175,55,0.15);color:#B45309;border:1px solid rgba(212,175,55,0.3);padding:2px 6px;border-radius:4px;font-weight:700;">
                                        <i class="fa-solid fa-star" style="font-size:0.6rem;margin-right:2px;"></i> FEATURED
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <h3 class="plan-title" style="font-size:1.05rem;margin-top:6px;">{{ $package->title }}</h3>
                            <div class="plan-price" style="font-size:1.35rem;margin:6px 0;">
                                @if($package->price_per_sqft && $package->price_per_sqft > 0)
                                    ₹{{ number_format($package->price_per_sqft) }} <span>/ sq.ft</span>
                                @else
                                    <span style="font-size:0.95rem;color:var(--navy-900);font-weight:700;">CUSTOM / ON REQUEST</span>
                                @endif
                            </div>
                            <div style="font-size:0.75rem;color:var(--slate-500);margin-bottom:8px;">
                                <i class="fa-solid fa-shield-halved" style="color:var(--slate-500);margin-right:3px;"></i> {{ $package->warranty_years ?? 10 }} Yrs Warranty • <i class="fa-solid fa-clock" style="color:var(--slate-500);margin-right:3px;"></i> {{ $package->delivery_months ?? 12 }} Mo Delivery
                            </div>
                            <div style="display:flex;gap:8px;margin-top:12px;">
                                <button type="button" class="btn-text-edit" onclick='openEditModal("package", @json($package))' title="Edit Package"><i class="fa-solid fa-pen-to-square"></i> Edit</button>
                                <button type="button" class="action-del-btn" onclick="deleteItem(event, 'packages', {{ $package->id }}, this)" title="Delete Package"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div id="packagesEmptyState" class="empty-division-state" style="{{ $packages->isEmpty() ? 'display:block;' : 'display:none;' }}padding:40px;text-align:center;color:var(--slate-500);">No packages found for the {{ $activeDivision }} division.</div>
                </div>

                @if($activeDivision === 'construction')
                <!-- 3B. CONSTRUCTION PACKAGES COMPARISON MATRIX / SPEC TABLE EDITOR -->
                <div class="card-dark-panel division-filterable" data-business-type="construction" style="margin-top:24px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
                        <div>
                            <div style="display:flex;align-items:center;gap:8px;">
                                <i class="fa-solid fa-table-columns" style="font-size:1.1rem;color:var(--navy-900);"></i>
                                <h2 class="panel-header-title" style="margin:0;">Packages Comparison Matrix Editor</h2>
                            </div>
                            <p class="panel-header-sub" style="margin-top:4px;">
                                Edit the live specification benchmark matrix shown on the pricing page ("VIEW SPEC TABLE") and the home page modal.
                            </p>
                        </div>
                        <div style="display:flex;gap:10px;flex-wrap:wrap;">
                            <button type="button" class="btn-gold-pill" onclick="saveActiveMatrix()" style="padding:7px 18px;font-size:0.8rem;">
                                <i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> Save Matrix
                            </button>
                        </div>
                    </div>

                    <!-- Division Toggle Tabs & Toolbar -->
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin:16px 0 14px;padding:10px 14px;background:var(--slate-50);border:1px solid var(--slate-200);border-radius:var(--radius-sm);">
                        <div style="display:flex;gap:8px;">
                            <button type="button" id="btnMatDivRes" class="btn-gold-pill" onclick="switchMatrixDivision('residential')" style="padding:6px 14px;font-size:0.75rem;">
                                <i class="fa-solid fa-house" style="margin-right:5px;"></i> Residential Matrix
                            </button>
                            <button type="button" id="btnMatDivCom" class="btn-whatsapp-outline" onclick="switchMatrixDivision('commercial')" style="padding:6px 14px;font-size:0.75rem;">
                                <i class="fa-solid fa-building" style="margin-right:5px;"></i> Commercial Matrix
                            </button>
                        </div>

                        <div style="display:flex;gap:8px;flex-wrap:wrap;">
                            <button type="button" class="btn-whatsapp-outline" onclick="addMatrixRow()" style="padding:5px 12px;font-size:0.75rem;">
                                <i class="fa-solid fa-plus" style="margin-right:4px;"></i> Add Spec Row
                            </button>
                            <button type="button" class="btn-whatsapp-outline" onclick="addMatrixColumn()" style="padding:5px 12px;font-size:0.75rem;">
                                <i class="fa-solid fa-table-columns" style="margin-right:4px;"></i> Add Tier Column
                            </button>
                            <button type="button" class="btn-whatsapp-outline" onclick="syncMatrixColumnsFromPackages()" title="Auto-fill column headers from active packages in database" style="padding:5px 12px;font-size:0.75rem;">
                                <i class="fa-solid fa-arrows-rotate" style="margin-right:4px;"></i> Sync from Packages
                            </button>
                            <button type="button" class="btn-whatsapp-outline" onclick="resetMatrixToDefaults()" style="padding:5px 12px;font-size:0.75rem;color:var(--slate-600);">
                                <i class="fa-solid fa-rotate-left" style="margin-right:4px;"></i> Reset Defaults
                            </button>
                        </div>
                    </div>

                    <!-- Alert message container -->
                    <div id="matrixAlertBox" style="display:none;margin-bottom:14px;padding:10px 16px;border-radius:var(--radius-sm);font-size:0.82rem;font-weight:600;"></div>

                    <!-- Table Container -->
                    <div class="table-responsive" style="overflow-x:auto;border:1px solid var(--slate-200);border-radius:var(--radius-md);background:#FFFFFF;">
                        <table id="matrixEditorTable" style="width:100%;border-collapse:collapse;font-size:0.82rem;min-width:750px;">
                            <!-- Populated dynamically via JS -->
                        </table>
                    </div>

                    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:14px;flex-wrap:wrap;gap:10px;">
                        <span style="font-size:0.75rem;color:var(--slate-500);">
                            <i class="fa-solid fa-lightbulb" style="color:var(--slate-500);margin-right:4px;"></i> Click on any specification or cell text to edit directly. Click <strong>Save Matrix</strong> to commit changes live.
                        </span>
                        <button type="button" class="btn-gold-pill" onclick="saveActiveMatrix()" style="padding:7px 20px;font-size:0.8rem;">
                            <i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> Save Matrix
                        </button>
                    </div>
                </div>
                @endif
            </div>

            <!-- CONSULTATIONS & ESTIMATE LEADS TAB -->
            <div class="admin-tab-pane" id="tab-quotes">
                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;margin-bottom:14px;">
                        <div>
                            <h2 class="panel-header-title" id="title-quotes"><i class="{{ $activeDivision === 'interior' ? 'fa-solid fa-couch' : 'fa-solid fa-file-invoice-dollar' }}" style="margin-right:8px;color:var(--navy-800);"></i> {{ $activeDivision === 'interior' ? 'INTERIOR CONSULTATION REQUESTS' : 'CONSTRUCTION INQUIRIES & ESTIMATES' }}</h2>
                            <p class="panel-header-sub" id="sub-quotes">{{ $activeDivision === 'interior' ? 'Live record of interior consultation requests and space planning inquiries.' : 'Live inquiries submitted via the website for Free Consultations, Estimates, and Floor Plan Reviews.' }}</p>
                        </div>
                        <div style="display:flex;gap:10px;align-items:center;">
                            <span class="badge-count" id="quotesHeaderTotalBadge" style="padding:6px 14px;font-size:0.82rem;">
                                {{ $stats['quotes'] }} Total Leads
                            </span>
                        </div>
                    </div>

                    <!-- Division Scope Banner -->
                    <div class="division-scope-banner" id="banner-quotes">
                        <div class="division-scope-info">
                            <span class="division-scope-badge" id="badge-quotes">
                                <span class="scope-dot"></span>
                                <span id="badge-text-quotes">{{ $activeDivision === 'interior' ? 'INTERIOR STUDIO RECORDS' : 'CONSTRUCTION DIVISION RECORDS' }}</span>
                            </span>
                            <span class="division-scope-desc" id="desc-quotes">
                                {{ $activeDivision === 'interior' ? 'Showing incoming consultation requests submitted via the Maha Interior studio page.' : 'Showing incoming inquiries for home construction, villas, and building estimates.' }}
                            </span>
                        </div>
                        <a href="{{ $activeDivision === 'interior' ? route('admin.construction') : route('admin.interior') }}" class="division-scope-switch-btn" id="switch-btn-quotes" style="text-decoration:none;">
                            <span>{{ $activeDivision === 'interior' ? 'Switch to Construction Division' : 'Switch to Interior Studio' }}</span>
                            <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i>
                        </a>
                    </div>
                    <!-- Drag & Scroll Control Bar for Leads Table -->
                    <div class="admin-table-drag-bar">
                        <div class="admin-drag-hint">
                            <i class="fa-solid fa-arrows-left-right" style="color:var(--slate-500);"></i>
                            <span>Drag Table / Use Slider To View Status & Action Columns</span>
                        </div>
                        <div class="admin-drag-controls-group">
                            <button type="button" class="admin-table-scroll-btn" onclick="scrollQuotesTable(-250)">
                                <i class="fa-solid fa-chevron-left"></i> Left
                            </button>
                            <input type="range" min="0" max="100" value="0" id="quotesTableDragSlider" class="admin-drag-range-slider" aria-label="Drag table horizontally">
                            <button type="button" class="admin-table-scroll-btn" onclick="scrollQuotesTable(250)">
                                Right <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive" id="quotesTableWrapper">
                        <table class="table-custom-dark" id="quotesTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>DIVISION</th>
                                    <th>CLIENT NAME</th>
                                    <th>PHONE / WHATSAPP</th>
                                    <th>EMAIL</th>
                                    <th>PROJECT TYPE</th>
                                    <th>BUDGET</th>
                                    <th>MESSAGE / REQUIREMENTS</th>
                                    <th>DATE</th>
                                    <th>STATUS</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($quotes as $i => $quote)
                                <tr class="division-filterable" data-business-type="{{ $quote->business_type ?? 'construction' }}">
                                    <td>{{ $i + 1 }}</td>
                                    <td>
                                        <span class="tag-pill {{ ($quote->business_type ?? 'construction') === 'interior' ? 'tag-interior' : 'tag-construction' }}">
                                            <i class="{{ ($quote->business_type ?? 'construction') === 'interior' ? 'fa-solid fa-couch' : 'fa-solid fa-building' }}" style="margin-right:4px;"></i>
                                            {{ $quote->business_type ?? 'construction' }}
                                        </span>
                                    </td>
                                    <td><strong style="color:var(--slate-900);">{{ $quote->name }}</strong></td>
                                    <td>
                                        @if($quote->phone)
                                        <div style="display:flex;gap:6px;align-items:center;">
                                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $quote->phone) }}" style="color:var(--slate-800);text-decoration:none;font-weight:600;font-size:0.85rem;" title="Call Client">
                                                <i class="fa-solid fa-phone" style="margin-right:4px;color:var(--slate-400);"></i> {{ $quote->phone }}
                                            </a>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $quote->phone) }}?text={{ urlencode('Hello ' . $quote->name . ', thank you for your consultation inquiry with Maha Group. How can we assist you today?') }}" target="_blank" class="action-edit-btn" style="color:#059669;border-color:rgba(16,185,129,0.3);padding:4px 8px;font-size:0.75rem;" title="Chat on WhatsApp">
                                                <i class="fa-brands fa-whatsapp"></i>
                                            </a>
                                        </div>
                                        @else
                                        <span style="color:var(--slate-400);">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($quote->email)
                                        <a href="mailto:{{ $quote->email }}" style="color:var(--slate-600);text-decoration:none;font-size:0.82rem;">
                                            <i class="fa-solid fa-envelope" style="margin-right:4px;color:var(--slate-400);"></i> {{ $quote->email }}
                                        </a>
                                        @else
                                        <span style="color:var(--slate-400);">—</span>
                                        @endif
                                    </td>
                                    <td><span style="color:var(--navy-800);font-weight:600;font-size:0.82rem;">{{ $quote->project_type ?? 'General' }}</span></td>
                                    <td><span style="font-size:0.82rem;color:var(--slate-700);font-weight:500;">{{ $quote->budget_range ?? '—' }}</span></td>
                                    <td style="max-width:240px;font-size:0.8rem;color:var(--slate-600);line-height:1.4;">
                                        {{ $quote->message ?: 'No additional notes' }}
                                    </td>
                                    <td style="font-size:0.78rem;color:var(--slate-500);white-space:nowrap;">
                                        {{ $quote->created_at ? $quote->created_at->format('M j, Y g:i A') : 'Recently' }}
                                    </td>
                                    <td>
                                        @if($quote->is_read)
                                        <span style="color:#059669;font-size:0.75rem;font-weight:600;display:inline-flex;align-items:center;gap:4px;"><i class="fa-solid fa-check-double"></i> Read</span>
                                        @else
                                        <button type="button" class="btn-whatsapp-outline" onclick="markQuoteAsRead(event, {{ $quote->id }}, this)" style="padding:3px 8px;font-size:0.7rem;" title="Mark as Read">
                                            <i class="fa-solid fa-envelope" style="margin-right:3px;"></i> New
                                        </button>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="action-del-btn" onclick="deleteQuoteLead(event, {{ $quote->id }}, this)" title="Delete Lead"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="11" style="text-align:center;padding:32px;color:var(--slate-500);">No consultation leads received yet for {{ $activeDivision }}.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div id="quotesEmptyState" class="empty-division-state" style="{{ $quotes->isEmpty() ? 'display:block;' : 'display:none;' }}padding:40px;text-align:center;color:var(--slate-500);">No consultation leads found for the {{ $activeDivision }} division.</div>
                </div>
            </div>

            <!-- 4. BANKING & VENDORS TAB -->
            <div class="admin-tab-pane" id="tab-partners">
                @php
                    $allBanking = \App\Models\Partner::where('division', 'banking')->get();
                    $allVendors = \App\Models\Partner::where('division', 'vendor')->get();
                    $allJVs     = \App\Models\Partner::where('division', 'joint_venture')->get();
                @endphp

                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                        <div>
                            <h2 class="panel-header-title"><i class="fa-solid fa-handshake" style="margin-right:8px;color:var(--navy-800);"></i> BANKING & VENDOR PARTNERS MANAGEMENT</h2>
                            <p class="panel-header-sub">Manually edit, add or upload bank logos for Finance & Loans and vendor material brands.</p>
                        </div>
                        <button class="btn-gold-pill" onclick="openUploadModal('partner')">
                            <i class="fa-solid fa-plus" style="margin-right:6px;"></i> ADD NEW PARTNER / VENDOR
                        </button>
                    </div>

                    <!-- Section A: Banking Partners -->
                    <div style="margin-top:24px;border-top:1px solid var(--slate-200);padding-top:20px;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                            <i class="fa-solid fa-building-columns" style="color:var(--navy-800);font-size:1.1rem;"></i>
                            <h3 style="font-size:0.95rem;font-weight:700;color:var(--navy-800);text-transform:uppercase;margin:0;letter-spacing:0.04em;">
                                BANKING PARTNERS (FINANCE & LOANS) ({{ $allBanking->count() }})
                            </h3>
                        </div>
                        <div class="projects-grid-2">
                            @forelse($allBanking as $item)
                            <div class="project-video-card" style="padding:16px;background:#FFFFFF;border:1px solid var(--slate-200);border-radius:12px;box-shadow:var(--shadow-sm);">
                                <div style="background:#F8FAFC;border-radius:8px;padding:8px 12px;height:64px;display:flex;align-items:center;justify-content:center;border:1px solid var(--slate-200);margin-bottom:12px;">
                                    @if(!empty($item->logo_url))
                                    <img src="{{ asset($item->logo_url) }}" alt="{{ $item->name }}" style="max-height:48px;max-width:100%;object-fit:contain;" onerror="this.style.display='none'">
                                    @else
                                    <div class="partner-badge-circle" style="background:{{ \App\Support\BrandColor::for($item->name) }};">{{ \App\Support\BrandColor::initials($item->name) }}</div>
                                    @endif
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                                    <div>
                                        <h4 style="color:var(--slate-900);font-size:0.92rem;margin:0 0 4px 0;font-weight:700;">{{ $item->name }}</h4>
                                        <span style="font-size:0.75rem;color:#059669;font-weight:600;"><i class="fa-solid fa-circle-check"></i> Home Loan Partner</span>
                                        @if(!empty($item->website_url))
                                        <div style="margin-top:4px;">
                                            <a href="{{ $item->website_url }}" target="_blank" style="font-size:0.75rem;color:var(--slate-500);text-decoration:none;">
                                                <i class="fa-solid fa-link" style="color:var(--slate-400);margin-right:3px;"></i> {{ $item->website_url }}
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                    <div style="display:flex;gap:6px;flex-shrink:0;">
                                        <button type="button" class="action-edit-btn" onclick='openEditModal("partner", @json($item))' title="Edit Bank"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button type="button" class="action-del-btn" onclick="deleteItem(event, 'partners', {{ $item->id }}, this)" title="Delete Bank"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div style="grid-column:1/-1;text-align:center;padding:30px;color:var(--slate-500);">No banking partners added yet. Click "ADD NEW PARTNER / VENDOR" to add one.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Section B: Material Vendors -->
                    <div style="margin-top:32px;border-top:1px solid var(--slate-200);padding-top:20px;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                            <i class="fa-solid fa-helmet-safety" style="color:var(--navy-800);font-size:1.1rem;"></i>
                            <h3 style="font-size:0.95rem;font-weight:700;color:var(--navy-800);text-transform:uppercase;margin:0;letter-spacing:0.04em;">
                                TRUSTED MATERIAL VENDORS & BRANDS ({{ $allVendors->count() }})
                            </h3>
                        </div>
                        <div class="projects-grid-2">
                            @forelse($allVendors as $item)
                            <div class="project-video-card" style="padding:16px;background:#FFFFFF;border:1px solid var(--slate-200);border-radius:12px;box-shadow:var(--shadow-sm);">
                                <div style="background:#F8FAFC;border-radius:8px;padding:8px 12px;height:64px;display:flex;align-items:center;justify-content:center;border:1px solid var(--slate-200);margin-bottom:12px;">
                                    @if(!empty($item->logo_url))
                                    <img src="{{ asset($item->logo_url) }}" alt="{{ $item->name }}" style="max-height:48px;max-width:100%;object-fit:contain;" onerror="this.style.display='none'">
                                    @else
                                    <div class="partner-badge-circle" style="background:{{ \App\Support\BrandColor::for($item->name) }};">{{ \App\Support\BrandColor::initials($item->name) }}</div>
                                    @endif
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                                    <div>
                                        <h4 style="color:var(--slate-900);font-size:0.92rem;margin:0 0 4px 0;font-weight:700;">{{ $item->name }}</h4>
                                        <span style="font-size:0.75rem;color:var(--navy-700);font-weight:600;"><i class="fa-solid fa-shield-halved"></i> Certified Material Brand</span>
                                        @if(!empty($item->website_url))
                                        <div style="margin-top:4px;">
                                            <a href="{{ $item->website_url }}" target="_blank" style="font-size:0.75rem;color:var(--slate-500);text-decoration:none;">
                                                <i class="fa-solid fa-link" style="color:var(--slate-400);margin-right:3px;"></i> {{ $item->website_url }}
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                    <div style="display:flex;gap:6px;flex-shrink:0;">
                                        <button type="button" class="action-edit-btn" onclick='openEditModal("partner", @json($item))' title="Edit Vendor"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button type="button" class="action-del-btn" onclick="deleteItem(event, 'partners', {{ $item->id }}, this)" title="Delete Vendor"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div style="grid-column:1/-1;text-align:center;padding:30px;color:var(--slate-500);">No material vendors added yet.</div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Section C: Joint Venture Partners -->
                    @if($allJVs->count() > 0)
                    <div style="margin-top:32px;border-top:1px solid var(--slate-200);padding-top:20px;">
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:14px;">
                            <i class="fa-solid fa-handshake" style="color:var(--navy-800);font-size:1.1rem;"></i>
                            <h3 style="font-size:0.95rem;font-weight:700;color:var(--navy-800);text-transform:uppercase;margin:0;letter-spacing:0.04em;">
                                JOINT VENTURE PARTNERS ({{ $allJVs->count() }})
                            </h3>
                        </div>
                        <div class="projects-grid-2">
                            @foreach($allJVs as $item)
                            <div class="project-video-card" style="padding:16px;background:#FFFFFF;border:1px solid var(--slate-200);border-radius:12px;box-shadow:var(--shadow-sm);">
                                <div style="background:#F8FAFC;border-radius:8px;padding:8px 12px;height:64px;display:flex;align-items:center;justify-content:center;border:1px solid var(--slate-200);margin-bottom:12px;">
                                    @if(!empty($item->logo_url))
                                    <img src="{{ asset($item->logo_url) }}" alt="{{ $item->name }}" style="max-height:48px;max-width:100%;object-fit:contain;" onerror="this.style.display='none'">
                                    @else
                                    <div class="partner-badge-circle" style="background:{{ \App\Support\BrandColor::for($item->name) }};">{{ \App\Support\BrandColor::initials($item->name) }}</div>
                                    @endif
                                </div>
                                <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:8px;">
                                    <div>
                                        <h4 style="color:var(--slate-900);font-size:0.92rem;margin:0 0 4px 0;font-weight:700;">{{ $item->name }}</h4>
                                        <span style="font-size:0.75rem;color:var(--blue-600);font-weight:600;"><i class="fa-solid fa-handshake"></i> JV Partner</span>
                                    </div>
                                    <div style="display:flex;gap:6px;flex-shrink:0;">
                                        <button type="button" class="action-edit-btn" onclick='openEditModal("partner", @json($item))' title="Edit JV Partner"><i class="fa-solid fa-pen-to-square"></i></button>
                                        <button type="button" class="action-del-btn" onclick="deleteItem(event, 'partners', {{ $item->id }}, this)" title="Delete Partner"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 5. YOUTUBE VIDEOS TAB -->
            <div class="admin-tab-pane" id="tab-youtube">
                @php
                    $ytService = app(\App\Services\YouTubeSyncService::class);

                    // ── Construction YouTube Data ────────────────────────
                    $ytConstUrl      = \App\Services\YouTubeSyncService::getActiveChannelUrl('construction');
                    $ytConstApiKey   = \App\Services\YouTubeSyncService::getApiKey('construction') ?? '';
                    $ytConstSyncedRaw= ($settings['youtube_synced_videos_construction'] ?? null)?->value
                        ?? ($settings['youtube_synced_videos'] ?? null)?->value ?? '[]';
                    $ytConstVideos   = json_decode($ytConstSyncedRaw, true) ?: [];
                    if (empty($ytConstVideos)) {
                        try {
                            $ytConstVideos = $ytService->getVideos($ytConstUrl, false, 'construction')['videos'] ?? [];
                        } catch (\Throwable $e) {}
                    }
                    $ytConstHiddenIds= \App\Services\YouTubeSyncService::getHiddenVideoIds('construction');
                    $ytConstLastSync = ($settings['youtube_last_synced_at_construction'] ?? null)?->value
                        ?? ($settings['youtube_last_synced_at'] ?? null)?->value ?? null;
                    $ytConstCount    = count($ytConstVideos);
                    $ytConstName     = ($settings['youtube_channel_name_construction'] ?? null)?->value
                        ?? ($settings['youtube_channel_name'] ?? null)?->value ?? 'Maha Constructions';

                    // ── Interior YouTube Data ────────────────────────────
                    $ytIntUrl        = \App\Services\YouTubeSyncService::getActiveChannelUrl('interior');
                    $ytIntApiKey     = \App\Services\YouTubeSyncService::getApiKey('interior') ?? '';
                    $ytIntSyncedRaw  = ($settings['youtube_synced_videos_interior'] ?? null)?->value ?? '[]';
                    $ytIntVideos     = json_decode($ytIntSyncedRaw, true) ?: [];
                    if (empty($ytIntVideos)) {
                        try {
                            $ytIntVideos = $ytService->getVideos($ytIntUrl, false, 'interior')['videos'] ?? [];
                        } catch (\Throwable $e) {}
                    }
                    $ytIntHiddenIds  = \App\Services\YouTubeSyncService::getHiddenVideoIds('interior');
                    $ytIntLastSync   = ($settings['youtube_last_synced_at_interior'] ?? null)?->value ?? null;
                    $ytIntCount      = count($ytIntVideos);
                    $ytIntName       = ($settings['youtube_channel_name_interior'] ?? null)?->value ?? 'Maha Interiors';
                @endphp

                <!-- Division Switcher Bar for YouTube Tab -->
                <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:14px;margin-bottom:24px;background:#FFFFFF;border:1px solid var(--slate-200);border-radius:12px;padding:14px 20px;box-shadow:var(--shadow-sm);">
                    <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                        <span style="font-size:0.8rem;font-weight:700;letter-spacing:0.04em;color:var(--navy-800);text-transform:uppercase;">
                            <i class="fa-brands fa-youtube" style="color:#DC2626;margin-right:6px;font-size:1rem;"></i> MANAGE CHANNEL:
                        </span>
                        <div class="division-switcher" style="background:#F1F5F9;border:1px solid var(--slate-200);border-radius:9999px;padding:4px;display:inline-flex;gap:4px;">
                            <button type="button" id="btnYtDivConst" onclick="switchYtDivision('construction')" class="division-btn {{ $activeDivision === 'construction' ? 'active' : '' }}" style="padding:7px 20px;border-radius:9999px;font-size:0.8rem;font-weight:700;letter-spacing:0.04em;transition:all 0.2s;cursor:pointer;">
                                <i class="fa-solid fa-building" style="margin-right:6px;"></i> CONSTRUCTION YOUTUBE
                            </button>
                            <button type="button" id="btnYtDivInt" onclick="switchYtDivision('interior')" class="division-btn {{ $activeDivision === 'interior' ? 'active' : '' }}" style="padding:7px 20px;border-radius:9999px;font-size:0.8rem;font-weight:700;letter-spacing:0.04em;transition:all 0.2s;cursor:pointer;">
                                <i class="fa-solid fa-couch" style="margin-right:6px;"></i> INTERIOR YOUTUBE
                            </button>
                        </div>
                    </div>
                    <div style="font-size:0.78rem;color:var(--slate-500);font-weight:500;">
                        <i class="fa-solid fa-circle-info" style="color:var(--slate-400);margin-right:5px;"></i> Construction & Interior channels have completely separate URLs, live feeds, and video catalogues.
                    </div>
                </div>

                <!-- ========================================================= -->
                <!-- PANE 1: CONSTRUCTION YOUTUBE CHANNEL                      -->
                <!-- ========================================================= -->
                <div id="yt-pane-construction" class="yt-division-pane" style="display:{{ $activeDivision === 'construction' ? 'block' : 'none' }};">
                    <div class="card-dark-panel">
                        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                            <div>
                                <div style="display:inline-flex;align-items:center;gap:6px;background:#FEE2E2;border:1px solid #FECACA;border-radius:20px;padding:3px 12px;margin-bottom:8px;">
                                    <i class="fa-brands fa-youtube" style="color:#DC2626;font-size:0.85rem;"></i>
                                    <span style="font-size:0.7rem;font-weight:700;letter-spacing:0.06em;color:#991B1B;text-transform:uppercase;">CONSTRUCTION • LIVE YOUTUBE SYNC</span>
                                </div>
                                <h2 class="panel-header-title" style="margin-bottom:4px;">CONSTRUCTION YOUTUBE AUTOMATION & SYNC</h2>
                                <p class="panel-header-sub" style="margin-bottom:0;">Videos synced here appear live on the Construction Home page (Site tours, building walkthroughs, drone views).</p>
                            </div>
                            <div style="display:flex;gap:10px;">
                                <button id="btnSyncYtLive_construction" class="btn-gold-pill" onclick="triggerLiveYouTubeSync('construction')">
                                    <i class="fa-solid fa-bolt" style="margin-right:6px;"></i> SYNC CONSTRUCTION VIDEOS NOW
                                </button>
                            </div>
                        </div>

                        <!-- Sync Status Info Banner -->
                        <div id="ytStatusBanner_construction" style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:12px;padding:18px 20px;margin-top:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
                            <div style="display:flex;align-items:center;gap:16px;">
                                <div style="width:44px;height:44px;background:#FEE2E2;border:1px solid #FECACA;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#DC2626;font-size:1.3rem;">
                                    <i class="fa-brands fa-youtube"></i>
                                </div>
                                <div>
                                    <div style="font-size:0.95rem;font-weight:700;color:var(--slate-900);" id="ytChannelNameDisplay_construction">{{ $ytConstName }}</div>
                                    <div style="font-size:0.75rem;color:var(--slate-500);margin-top:2px;">
                                        Channel: <a href="{{ $ytConstUrl }}" target="_blank" id="ytChannelLink_construction" style="color:var(--blue-600);text-decoration:none;">{{ $ytConstUrl }}</a>
                                    </div>
                                </div>
                            </div>

                            <div style="display:flex;gap:24px;align-items:center;">
                                <div style="text-align:right;">
                                    <div style="font-size:0.7rem;font-weight:700;color:var(--slate-500);text-transform:uppercase;">Synced Videos</div>
                                    <div style="font-size:1.15rem;font-weight:800;color:var(--navy-800);" id="ytVideoCountDisplay_construction">{{ $ytConstCount }} Videos</div>
                                </div>
                                <div style="text-align:right;border-left:1px solid var(--slate-200);padding-left:24px;">
                                    <div style="font-size:0.7rem;font-weight:700;color:var(--slate-500);text-transform:uppercase;">Last Synced</div>
                                    <div style="font-size:0.85rem;font-weight:600;color:#059669;" id="ytLastSyncedDisplay_construction">
                                        {{ $ytConstLastSync ? date('M j, Y, g:i a', strtotime($ytConstLastSync)) : 'Not synced yet' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Channel Configuration Settings Form -->
                        <div style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:12px;padding:20px;margin-top:20px;">
                            <h4 style="color:var(--navy-800);font-size:0.88rem;margin-bottom:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;">
                                <i class="fa-solid fa-sliders" style="margin-right:6px;color:var(--slate-600);"></i> CONSTRUCTION CHANNEL SETTINGS & API CONFIGURATION
                            </h4>
                            
                            <form id="formYouTubeSettings_construction" onsubmit="saveYouTubeSettings(event, 'construction')">
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                                    <div>
                                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:6px;">CONSTRUCTION YOUTUBE CHANNEL URL OR HANDLE *</label>
                                        <input id="cfg_yt_channel_url_construction" type="text" value="{{ $ytConstUrl }}" required placeholder="e.g. https://www.youtube.com/@mahaconstructions2013 or @mahaconstructions2013" class="input-dark" style="width:100%;box-sizing:border-box;">
                                        <span style="font-size:0.72rem;color:var(--slate-500);margin-top:4px;display:block;">Supports handle (@name), custom URL, or channel ID (UC...).</span>
                                    </div>
                                    <div>
                                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:6px;">YOUTUBE DATA API V3 KEY (OPTIONAL)</label>
                                        <input id="cfg_yt_api_key_construction" type="text" value="{{ $ytConstApiKey }}" placeholder="Optional: Google Cloud API key (zero key required for RSS)" class="input-dark" style="width:100%;box-sizing:border-box;">
                                        <span style="font-size:0.72rem;color:var(--slate-500);margin-top:4px;display:block;">Optional: YouTube RSS sync works 100% free with zero quota restrictions.</span>
                                    </div>
                                </div>

                                <div id="ytSettingsAlert_construction" style="display:none;margin-top:14px;padding:10px 16px;border-radius:8px;font-size:0.82rem;font-weight:600;"></div>

                                <div style="margin-top:18px;display:flex;gap:12px;">
                                    <button type="submit" id="btnSaveYtSettings_construction" class="btn-gold-submit" style="width:auto;padding:10px 24px;font-size:0.85rem;">
                                        <i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> SAVE & SYNC CONSTRUCTION CHANNEL
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Synced Videos Visual Grid -->
                    <div class="card-dark-panel" style="margin-top:24px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                            <div>
                                <h2 class="panel-header-title">CONSTRUCTION SYNCED VIDEOS (<span id="ytGridCount_construction">{{ count($ytConstVideos) }}</span>)</h2>
                                <p class="panel-header-sub">These live videos are visible to visitors on the Construction Home page. Click "Delete" on any video to remove it.</p>
                            </div>
                        </div>

                        <div id="ytVideosGrid_construction" class="projects-grid-2">
                            @forelse($ytConstVideos as $vid)
                            <div class="project-video-card" id="yt-card-construction-{{ $vid['youtubeId'] }}">
                                <div class="video-thumb-frame">
                                    <img src="{{ $vid['thumbnail'] ?? 'https://img.youtube.com/vi/'.$vid['youtubeId'].'/hqdefault.jpg' }}"
                                         alt="{{ $vid['title'] }}"
                                         onerror="this.src='https://img.youtube.com/vi/{{ $vid['youtubeId'] }}/hqdefault.jpg'">
                                    <div class="video-play-overlay" onclick="window.playVideoModal('{{ $vid['videoUrl'] }}', '{{ addslashes($vid['title']) }}')" style="position:absolute;inset:0;background:rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;cursor:pointer;">
                                        <div class="play-btn-circle">
                                            <i class="fa-solid fa-play" style="margin-left:2px;"></i>
                                        </div>
                                    </div>
                                    <div style="position:absolute;bottom:8px;right:8px;background:rgba(15,23,42,0.85);backdrop-filter:blur(4px);color:#FFFFFF;font-size:0.68rem;font-weight:700;padding:2px 7px;border-radius:4px;border:1px solid rgba(255,255,255,0.15);">
                                        <i class="fa-solid fa-play" style="font-size:0.55rem;margin-right:3px;color:var(--gold);"></i>{{ $vid['duration'] ?? 'Video' }}
                                    </div>
                                </div>
                                <div style="padding:14px 16px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                                    <div>
                                        <div style="font-size:0.72rem;color:var(--slate-500);font-weight:600;margin-bottom:4px;">
                                            ID: {{ $vid['youtubeId'] }} @if(!empty($vid['views'])) • {{ $vid['views'] }} @endif
                                        </div>
                                        <h4 style="color:var(--slate-900);font-size:0.88rem;line-height:1.35;margin:0;font-weight:700;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" title="{{ $vid['title'] }}">
                                            {{ $vid['title'] }}
                                        </h4>
                                    </div>
                                    <div style="margin-top:14px;padding-top:10px;border-top:1px solid var(--slate-100);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
                                        <div style="display:flex;gap:8px;align-items:center;">
                                            <button type="button" class="btn-whatsapp-outline" onclick="window.playVideoModal('{{ $vid['videoUrl'] }}', '{{ addslashes($vid['title']) }}')" style="padding:5px 10px;font-size:0.75rem;cursor:pointer;border-radius:6px;display:inline-flex;align-items:center;gap:5px;">
                                                <i class="fa-solid fa-play" style="font-size:0.7rem;"></i> Preview
                                            </button>
                                            <button type="button" class="btn-text-danger" onclick="deleteYouTubeVideoItem(event, '{{ $vid['youtubeId'] }}', this, 'construction')" title="Delete video from website">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </div>
                                        <a href="{{ $vid['watchUrl'] ?? 'https://www.youtube.com/watch?v='.$vid['youtubeId'] }}" target="_blank" style="font-size:0.75rem;color:#DC2626;text-decoration:none;display:inline-flex;align-items:center;gap:5px;font-weight:600;">
                                            <i class="fa-brands fa-youtube"></i> Watch <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.6rem;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--slate-500);">
                                <i class="fa-brands fa-youtube" style="font-size:2.5rem;color:#DC2626;margin-bottom:10px;display:block;"></i>
                                No Construction videos currently displayed. Click "SYNC CONSTRUCTION VIDEOS NOW" to fetch your channel videos.
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Excluded / Removed Videos Panel -->
                    <div class="card-dark-panel" id="ytExcludedVideosPanel_construction" style="margin-top:24px;border-color:var(--slate-200);{{ empty($ytConstHiddenIds) ? 'display:none;' : '' }}">
                        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
                            <div>
                                <h3 style="color:var(--slate-900);font-size:0.92rem;margin:0 0 4px;font-weight:700;display:flex;align-items:center;gap:8px;">
                                    <i class="fa-solid fa-ban" style="color:#DC2626;"></i> CONSTRUCTION EXCLUDED VIDEOS (<span id="ytExcludedCount_construction">{{ count($ytConstHiddenIds) }}</span>)
                                </h3>
                                <p style="color:var(--slate-500);font-size:0.75rem;margin:0;">These videos are hidden from the live Construction showcase. Click "Restore" to put them back.</p>
                            </div>
                        </div>
                        <div style="margin-top:14px;display:flex;flex-wrap:wrap;gap:10px;" id="ytExcludedVideosList_construction">
                            @foreach($ytConstHiddenIds as $hid)
                            <div class="yt-excluded-badge" id="yt-excluded-construction-{{ $hid }}" style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:8px;padding:6px 12px;display:inline-flex;align-items:center;gap:8px;font-size:0.75rem;color:var(--slate-800);">
                                <span><i class="fa-brands fa-youtube" style="color:#DC2626;margin-right:4px;"></i>ID: <strong>{{ $hid }}</strong></span>
                                <a href="https://www.youtube.com/watch?v={{ $hid }}" target="_blank" style="color:var(--slate-500);text-decoration:none;" title="View on YouTube"><i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.65rem;"></i></a>
                                <button type="button" onclick="restoreYouTubeVideoItem('{{ $hid }}', this, 'construction')" class="btn-gold-pill" style="padding:3px 10px;font-size:0.7rem;line-height:1;margin-left:4px;cursor:pointer;" title="Restore to Construction Website">
                                    <i class="fa-solid fa-rotate-left" style="margin-right:3px;"></i> Restore
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- ========================================================= -->
                <!-- PANE 2: INTERIOR YOUTUBE CHANNEL                          -->
                <!-- ========================================================= -->
                <div id="yt-pane-interior" class="yt-division-pane" style="display:{{ $activeDivision === 'interior' ? 'block' : 'none' }};">
                    <div class="card-dark-panel">
                        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                            <div>
                                <div style="display:inline-flex;align-items:center;gap:6px;background:#FEF3C7;border:1px solid #FDE68A;border-radius:20px;padding:3px 12px;margin-bottom:8px;">
                                    <i class="fa-brands fa-youtube" style="color:#B45309;font-size:0.85rem;"></i>
                                    <span style="font-size:0.7rem;font-weight:700;letter-spacing:0.06em;color:#92400E;text-transform:uppercase;">INTERIOR • LIVE YOUTUBE SYNC</span>
                                </div>
                                <h2 class="panel-header-title" style="margin-bottom:4px;">INTERIOR YOUTUBE AUTOMATION & SYNC</h2>
                                <p class="panel-header-sub" style="margin-bottom:0;">Videos synced here appear live on the Interior Page (Modular kitchen tours, wardrobe masterclasses, luxury styling).</p>
                            </div>
                            <div style="display:flex;gap:10px;">
                                <button id="btnSyncYtLive_interior" class="btn-gold-pill" onclick="triggerLiveYouTubeSync('interior')">
                                    <i class="fa-solid fa-bolt" style="margin-right:6px;"></i> SYNC INTERIOR VIDEOS NOW
                                </button>
                            </div>
                        </div>

                        <!-- Sync Status Info Banner -->
                        <div id="ytStatusBanner_interior" style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:12px;padding:18px 20px;margin-top:20px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
                            <div style="display:flex;align-items:center;gap:16px;">
                                <div style="width:44px;height:44px;background:#FEF3C7;border:1px solid #FDE68A;border-radius:10px;display:flex;align-items:center;justify-content:center;color:#B45309;font-size:1.3rem;">
                                    <i class="fa-brands fa-youtube"></i>
                                </div>
                                <div>
                                    <div style="font-size:0.95rem;font-weight:700;color:var(--slate-900);" id="ytChannelNameDisplay_interior">{{ $ytIntName }}</div>
                                    <div style="font-size:0.75rem;color:var(--slate-500);margin-top:2px;">
                                        Channel: <a href="{{ $ytIntUrl }}" target="_blank" id="ytChannelLink_interior" style="color:var(--blue-600);text-decoration:none;">{{ $ytIntUrl }}</a>
                                    </div>
                                </div>
                            </div>

                            <div style="display:flex;gap:24px;align-items:center;">
                                <div style="text-align:right;">
                                    <div style="font-size:0.7rem;font-weight:700;color:var(--slate-500);text-transform:uppercase;">Synced Videos</div>
                                    <div style="font-size:1.15rem;font-weight:800;color:var(--navy-800);" id="ytVideoCountDisplay_interior">{{ $ytIntCount }} Videos</div>
                                </div>
                                <div style="text-align:right;border-left:1px solid var(--slate-200);padding-left:24px;">
                                    <div style="font-size:0.7rem;font-weight:700;color:var(--slate-500);text-transform:uppercase;">Last Synced</div>
                                    <div style="font-size:0.85rem;font-weight:600;color:#059669;" id="ytLastSyncedDisplay_interior">
                                        {{ $ytIntLastSync ? date('M j, Y, g:i a', strtotime($ytIntLastSync)) : 'Not synced yet' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Channel Configuration Settings Form -->
                        <div style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:12px;padding:20px;margin-top:20px;">
                            <h4 style="color:var(--navy-800);font-size:0.88rem;margin-bottom:14px;font-weight:700;text-transform:uppercase;letter-spacing:0.04em;">
                                <i class="fa-solid fa-sliders" style="margin-right:6px;color:var(--slate-600);"></i> INTERIOR CHANNEL SETTINGS & API CONFIGURATION
                            </h4>
                            
                            <form id="formYouTubeSettings_interior" onsubmit="saveYouTubeSettings(event, 'interior')">
                                <div style="display:grid;grid-template-columns:1fr 1fr;gap:18px;">
                                    <div>
                                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:6px;">INTERIOR YOUTUBE CHANNEL URL OR HANDLE *</label>
                                        <input id="cfg_yt_channel_url_interior" type="text" value="{{ $ytIntUrl }}" required placeholder="e.g. https://www.youtube.com/@mahainteriors or channel handle" class="input-dark" style="width:100%;box-sizing:border-box;">
                                        <span style="font-size:0.72rem;color:var(--slate-500);margin-top:4px;display:block;">Supports channel handle (@mahainteriors), custom URL, or channel ID.</span>
                                    </div>
                                    <div>
                                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:6px;">YOUTUBE DATA API V3 KEY (OPTIONAL)</label>
                                        <input id="cfg_yt_api_key_interior" type="text" value="{{ $ytIntApiKey }}" placeholder="Optional: Dedicated API key or blank to use official RSS" class="input-dark" style="width:100%;box-sizing:border-box;">
                                        <span style="font-size:0.72rem;color:var(--slate-500);margin-top:4px;display:block;">Optional: Zero key required for standard YouTube channel sync.</span>
                                    </div>
                                </div>

                                <div id="ytSettingsAlert_interior" style="display:none;margin-top:14px;padding:10px 16px;border-radius:8px;font-size:0.82rem;font-weight:600;"></div>

                                <div style="margin-top:18px;display:flex;gap:12px;">
                                    <button type="submit" id="btnSaveYtSettings_interior" class="btn-gold-submit" style="width:auto;padding:10px 24px;font-size:0.85rem;">
                                        <i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> SAVE & SYNC INTERIOR CHANNEL
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Synced Videos Visual Grid -->
                    <div class="card-dark-panel" style="margin-top:24px;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px;">
                            <div>
                                <h2 class="panel-header-title">INTERIOR SYNCED VIDEOS (<span id="ytGridCount_interior">{{ count($ytIntVideos) }}</span>)</h2>
                                <p class="panel-header-sub">These live videos are visible to visitors on the Interior page. Click "Delete" on any video to remove it.</p>
                            </div>
                        </div>

                        <div id="ytVideosGrid_interior" class="projects-grid-2">
                            @forelse($ytIntVideos as $vid)
                            <div class="project-video-card" id="yt-card-interior-{{ $vid['youtubeId'] }}">
                                <div class="video-thumb-frame">
                                    <img src="{{ $vid['thumbnail'] ?? 'https://img.youtube.com/vi/'.$vid['youtubeId'].'/hqdefault.jpg' }}"
                                         alt="{{ $vid['title'] }}"
                                         onerror="this.src='https://img.youtube.com/vi/{{ $vid['youtubeId'] }}/hqdefault.jpg'">
                                    <div class="video-play-overlay" onclick="window.playVideoModal('{{ $vid['videoUrl'] }}', '{{ addslashes($vid['title']) }}')" style="position:absolute;inset:0;background:rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;cursor:pointer;">
                                        <div class="play-btn-circle">
                                            <i class="fa-solid fa-play" style="margin-left:2px;"></i>
                                        </div>
                                    </div>
                                    <div style="position:absolute;bottom:8px;right:8px;background:rgba(15,23,42,0.85);backdrop-filter:blur(4px);color:#FFFFFF;font-size:0.68rem;font-weight:700;padding:2px 7px;border-radius:4px;border:1px solid rgba(255,255,255,0.15);">
                                        <i class="fa-solid fa-play" style="font-size:0.55rem;margin-right:3px;color:var(--gold);"></i>{{ $vid['duration'] ?? 'Video' }}
                                    </div>
                                </div>
                                <div style="padding:14px 16px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                                    <div>
                                        <div style="font-size:0.72rem;color:var(--slate-500);font-weight:600;margin-bottom:4px;">
                                            ID: {{ $vid['youtubeId'] }} @if(!empty($vid['views'])) • {{ $vid['views'] }} @endif
                                        </div>
                                        <h4 style="color:var(--slate-900);font-size:0.88rem;line-height:1.35;margin:0;font-weight:700;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" title="{{ $vid['title'] }}">
                                            {{ $vid['title'] }}
                                        </h4>
                                    </div>
                                    <div style="margin-top:14px;padding-top:10px;border-top:1px solid var(--slate-100);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
                                        <div style="display:flex;gap:8px;align-items:center;">
                                            <button type="button" class="btn-whatsapp-outline" onclick="window.playVideoModal('{{ $vid['videoUrl'] }}', '{{ addslashes($vid['title']) }}')" style="padding:5px 10px;font-size:0.75rem;cursor:pointer;border-radius:6px;display:inline-flex;align-items:center;gap:5px;">
                                                <i class="fa-solid fa-play" style="font-size:0.7rem;"></i> Preview
                                            </button>
                                            <button type="button" class="btn-text-danger" onclick="deleteYouTubeVideoItem(event, '{{ $vid['youtubeId'] }}', this, 'interior')" title="Delete video from website">
                                                <i class="fa-solid fa-trash"></i> Delete
                                            </button>
                                        </div>
                                        <a href="{{ $vid['watchUrl'] ?? 'https://www.youtube.com/watch?v='.$vid['youtubeId'] }}" target="_blank" style="font-size:0.75rem;color:#DC2626;text-decoration:none;display:inline-flex;align-items:center;gap:5px;font-weight:600;">
                                            <i class="fa-brands fa-youtube"></i> Watch <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.6rem;"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div style="grid-column:1/-1;text-align:center;padding:40px;color:var(--slate-500);">
                                <i class="fa-brands fa-youtube" style="font-size:2.5rem;color:#DC2626;margin-bottom:10px;display:block;"></i>
                                No Interior videos currently displayed. Click "SYNC INTERIOR VIDEOS NOW" to fetch your channel videos.
                            </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Excluded / Removed Videos Panel -->
                    <div class="card-dark-panel" id="ytExcludedVideosPanel_interior" style="margin-top:24px;border-color:var(--slate-200);{{ empty($ytIntHiddenIds) ? 'display:none;' : '' }}">
                        <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;">
                            <div>
                                <h3 style="color:var(--slate-900);font-size:0.92rem;margin:0 0 4px;font-weight:700;display:flex;align-items:center;gap:8px;">
                                    <i class="fa-solid fa-ban" style="color:#DC2626;"></i> INTERIOR EXCLUDED VIDEOS (<span id="ytExcludedCount_interior">{{ count($ytIntHiddenIds) }}</span>)
                                </h3>
                                <p style="color:var(--slate-500);font-size:0.75rem;margin:0;">These videos are hidden from the live Interior showcase. Click "Restore" to put them back.</p>
                            </div>
                        </div>
                        <div style="margin-top:14px;display:flex;flex-wrap:wrap;gap:10px;" id="ytExcludedVideosList_interior">
                            @foreach($ytIntHiddenIds as $hid)
                            <div class="yt-excluded-badge" id="yt-excluded-interior-{{ $hid }}" style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:8px;padding:6px 12px;display:inline-flex;align-items:center;gap:8px;font-size:0.75rem;color:var(--slate-800);">
                                <span><i class="fa-brands fa-youtube" style="color:#DC2626;margin-right:4px;"></i>ID: <strong>{{ $hid }}</strong></span>
                                <a href="https://www.youtube.com/watch?v={{ $hid }}" target="_blank" style="color:var(--slate-500);text-decoration:none;" title="View on YouTube"><i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.65rem;"></i></a>
                                <button type="button" onclick="restoreYouTubeVideoItem('{{ $hid }}', this, 'interior')" class="btn-gold-pill" style="padding:3px 10px;font-size:0.7rem;line-height:1;margin-left:4px;cursor:pointer;" title="Restore to Interior Website">
                                    <i class="fa-solid fa-rotate-left" style="margin-right:3px;"></i> Restore
                                </button>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- 5. CONTACT DETAILS & ADDRESS TAB -->
            <div class="admin-tab-pane" id="tab-contact">
                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                        <div>
                            <h2 class="panel-header-title"><i class="fa-solid fa-address-book" style="margin-right:8px;color:var(--navy-800);"></i> HEAD OFFICE & CONTACT INFO</h2>
                            <p class="panel-header-sub">Update phone numbers, Nagercoil office address, email, branches & hours across the entire live website.</p>
                        </div>
                    </div>

                    <form id="contactDetailsForm" onsubmit="saveContactSettings(event)" class="quote-form-grid" style="margin-top:24px;">
                        <div class="form-field">
                            <label>PRIMARY PHONE</label>
                            <input type="text" id="cfg_company_phone" name="company_phone" value="{{ ($settings['company_phone'] ?? null)?->value ?? '+91 90959 29543' }}" placeholder="+91 90959 29543" class="input-dark" required>
                        </div>
                        <div class="form-field">
                            <label>SECONDARY / ENGINEER PHONE</label>
                            <input type="text" id="cfg_company_phone_secondary" name="company_phone_secondary" value="{{ ($settings['company_phone_secondary'] ?? null)?->value ?? '+91 90959 29543' }}" placeholder="+91 90959 29543" class="input-dark">
                        </div>
                        <div class="form-field">
                            <label>WHATSAPP NUMBER</label>
                            <input type="text" id="cfg_company_whatsapp" name="company_whatsapp" value="{{ ($settings['company_whatsapp'] ?? null)?->value ?? '+91 90959 29543' }}" placeholder="+91 90959 29543" class="input-dark" required>
                        </div>
                        <div class="form-field">
                            <label>EMAIL ADDRESS</label>
                            <input type="email" id="cfg_company_email" name="company_email" value="{{ ($settings['company_email'] ?? null)?->value ?? 'Mahaconstructions2013@gmail.com' }}" placeholder="Mahaconstructions2013@gmail.com" class="input-dark" required>
                        </div>
                        <div class="form-field">
                            <label>WORKING / BUSINESS HOURS</label>
                            <input type="text" id="cfg_company_hours" name="company_hours" value="{{ ($settings['company_hours'] ?? null)?->value ?? 'Monday - Saturday: 10:00 AM - 6:00 PM' }}" placeholder="Monday - Saturday: 10:00 AM - 6:00 PM" class="input-dark">
                        </div>
                        <div class="form-field">
                            <label>BRANCH LOCATIONS (HERO BADGE)</label>
                            <input type="text" id="cfg_company_branches" name="company_branches" value="{{ ($settings['company_branches'] ?? null)?->value ?? 'KANYAKUMARI, TIRUNELVELI, AND CHENNAI' }}" placeholder="KANYAKUMARI, TIRUNELVELI, AND CHENNAI" class="input-dark">
                        </div>
                        <div class="form-field full-width">
                            <label>HEAD OFFICE ADDRESS</label>
                            <input type="text" id="cfg_company_address" name="company_address" value="{{ ($settings['company_address'] ?? null)?->value ?? 'Tamilnomi complex, 1st floor, ICICI Bank Upstar, Near kottar police station, Nagercoil' }}" placeholder="Head Office Address" class="input-dark" required>
                        </div>

                        <div id="contactSettingsAlert" style="display:none;margin-top:14px;padding:12px 18px;border-radius:10px;font-size:0.85rem;font-weight:600;" class="full-width"></div>

                        <div class="form-field full-width" style="margin-top:12px;">
                            <button type="submit" id="btnSaveContactSettings" class="btn-gold-submit" style="width:auto;padding:12px 32px;display:inline-flex;align-items:center;gap:8px;">
                                <i class="fa-solid fa-floppy-disk"></i> SAVE CONTACT DETAILS
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- HERO SECTION CONTENT PANEL -->
            <div class="card-dark-panel" style="margin-top:24px;" id="heroContentPanel">
                <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:12px;">
                    <div>
                        <h2 class="panel-header-title"><i class="fa-solid fa-pen-ruler" style="margin-right:8px;color:var(--navy-800);"></i> HERO SECTION CONTENT</h2>
                        <p class="panel-header-sub">Edit the homepage hero title, subtitle, checklist badges, and CTA button text.</p>
                    </div>
                </div>
                <form id="heroContentForm" onsubmit="saveHeroContent(event)" class="quote-form-grid" style="margin-top:24px;">
                    <div class="form-field full-width">
                        <label>HERO MAIN TITLE</label>
                        <input type="text" id="cfg_hero_title" name="hero_title" value="{{ ($settings['hero_title'] ?? null)?->value ?? 'BUILDING LUXURY ARCHITECTURAL MASTERPIECES WITH UNCOMPROMISING EXCELLENCE' }}" placeholder="Main headline" class="input-dark" required>
                    </div>
                    <div class="form-field full-width">
                        <label>HERO SUBTITLE / DESCRIPTION</label>
                        <textarea id="cfg_hero_subtitle" name="hero_subtitle" rows="3" class="input-dark" style="resize:vertical;" placeholder="Short description below the title">{{ ($settings['hero_subtitle'] ?? null)?->value ?? "Tamil Nadu's premier government-registered engineering firm..." }}</textarea>
                    </div>
                    <div class="form-field">
                        <label>CHECKLIST BADGE 1</label>
                        <input type="text" id="cfg_hero_check1" name="hero_check1" value="{{ ($settings['hero_check1'] ?? null)?->value ?? 'Premium Materials' }}" class="input-dark" placeholder="e.g. Premium Materials">
                    </div>
                    <div class="form-field">
                        <label>CHECKLIST BADGE 2</label>
                        <input type="text" id="cfg_hero_check2" name="hero_check2" value="{{ ($settings['hero_check2'] ?? null)?->value ?? 'Transparent Pricing' }}" class="input-dark" placeholder="e.g. Transparent Pricing">
                    </div>
                    <div class="form-field">
                        <label>CHECKLIST BADGE 3</label>
                        <input type="text" id="cfg_hero_check3" name="hero_check3" value="{{ ($settings['hero_check3'] ?? null)?->value ?? 'On-Time Delivery' }}" class="input-dark" placeholder="e.g. On-Time Delivery">
                    </div>
                    <div class="form-field">
                        <label>CHECKLIST BADGE 4</label>
                        <input type="text" id="cfg_hero_check4" name="hero_check4" value="{{ ($settings['hero_check4'] ?? null)?->value ?? 'Expert Engineers' }}" class="input-dark" placeholder="e.g. Expert Engineers">
                    </div>
                    <div class="form-field">
                        <label>CHECKLIST BADGE 5</label>
                        <input type="text" id="cfg_hero_check5" name="hero_check5" value="{{ ($settings['hero_check5'] ?? null)?->value ?? 'Lifetime Support' }}" class="input-dark" placeholder="e.g. Lifetime Support">
                    </div>
                    <div class="form-field">
                        <label>PRIMARY CTA BUTTON TEXT</label>
                        <input type="text" id="cfg_hero_cta_primary" name="hero_cta_primary" value="{{ ($settings['hero_cta_primary'] ?? null)?->value ?? 'BOOK FREE CONSULTATION' }}" class="input-dark" placeholder="e.g. BOOK FREE CONSULTATION">
                    </div>

                    <div id="heroContentAlert" style="display:none;margin-top:14px;padding:12px 18px;border-radius:10px;font-size:0.85rem;font-weight:600;" class="full-width"></div>

                    <div class="form-field full-width" style="margin-top:12px;">
                        <button type="submit" id="btnSaveHeroContent" class="btn-gold-submit" style="width:auto;padding:12px 32px;display:inline-flex;align-items:center;gap:8px;">
                            <i class="fa-solid fa-floppy-disk"></i> SAVE HERO CONTENT
                        </button>
                    </div>
                </form>
            </div>

            <!-- 6. GUIDEBOOK PDF MANAGEMENT & READERS LOG TAB -->
            <div class="admin-tab-pane" id="tab-guidebook">
                <div class="card-dark-panel">
                    <div style="display:flex;justify-content:space-between;align-items:center;">
                        <div>
                            <h2 class="panel-header-title"><i class="fa-solid fa-book-open" style="margin-right:8px;color:var(--navy-800);"></i> FREE GUIDEBOOK PDF MANAGEMENT</h2>
                            <p class="panel-header-sub">Upload, view, or remove the PDF document served as the free "Nam Kanavu Illam" home builder guide.</p>
                        </div>
                    </div>

                    <!-- Current PDF Status & Active Cover -->
                    <div id="currentPdfBox" style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:12px;padding:20px;margin-top:16px;display:flex;gap:24px;align-items:center;flex-wrap:wrap;">
                        <img src="/images/guidebook-cover.jpg" alt="Guidebook Cover" style="width:90px;height:120px;object-fit:cover;border-radius:8px;border:1px solid var(--slate-200);box-shadow:var(--shadow-sm);">
                        <div style="flex:1;min-width:260px;">
                            <div style="font-size:0.75rem;color:var(--navy-800);font-weight:700;margin-bottom:8px;"><i class="fa-solid fa-file-pdf" style="margin-right:6px;color:#DC2626;"></i> CURRENT ACTIVE PDF DOCUMENT & COVER</div>
                            <div id="activePdfDisplay" style="font-size:0.85rem;color:var(--slate-600);word-break:break-all;margin-bottom:16px;">
                                {{ $settings['guidebook_pdf_url']->value ?? '/uploads/1785792673_new book.pdf' }}
                            </div>
                            <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap;">
                                <a href="{{ $settings['guidebook_pdf_url']->value ?? '/uploads/1785792673_new book.pdf' }}" target="_blank" id="btnOpenPdf" class="btn-gold-pill">
                                    <i class="fa-solid fa-arrow-up-right-from-square" style="margin-right:6px;"></i> OPEN PDF
                                </a>
                                <button type="button" class="btn-text-danger" onclick="deleteGuidebookPdf(event, this)">
                                    <i class="fa-solid fa-trash"></i> DELETE PDF
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Upload New PDF -->
                    <div style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:12px;padding:24px;margin-top:16px;">
                        <div style="font-size:0.78rem;color:var(--navy-800);font-weight:700;margin-bottom:14px;"><i class="fa-solid fa-upload" style="margin-right:6px;"></i> UPLOAD NEW PDF FILE</div>

                        <div id="pdfDropZone" onclick="document.getElementById('guidebookFileInput').click()"
                             style="border:2px dashed var(--slate-300);border-radius:12px;padding:32px;text-align:center;cursor:pointer;transition:all 0.2s;background:#FFFFFF;"
                             onmouseover="this.style.borderColor='var(--navy-800)';this.style.background='var(--slate-50)';"
                             onmouseout="this.style.borderColor='var(--slate-300)';this.style.background='#FFFFFF';">
                            <i class="fa-solid fa-file-pdf" style="font-size:2rem;color:#DC2626;margin-bottom:10px;display:block;"></i>
                            <div style="color:var(--slate-900);font-weight:700;margin-bottom:4px;">Click to select PDF file</div>
                            <div style="color:var(--slate-500);font-size:0.8rem;">PDF only • Max 20MB</div>
                            <input type="file" id="guidebookFileInput" accept="application/pdf,.pdf" style="display:none;" onchange="handleGuidebookUpload(event)">
                        </div>

                        <div id="pdfUploadProgress" style="display:none;margin-top:16px;">
                            <div style="background:var(--slate-200);border-radius:8px;height:8px;overflow:hidden;">
                                <div id="pdfProgressBar" style="height:100%;width:0%;background:var(--navy-800);transition:width 0.4s ease;border-radius:8px;"></div>
                            </div>
                            <div id="pdfUploadStatus" style="color:var(--navy-800);font-size:0.85rem;margin-top:8px;text-align:center;">Uploading...</div>
                        </div>
                    </div>
                </div>

                <!-- Guidebook Downloads & Readers Table -->
                <div class="card-dark-panel">
                    <h2 class="panel-header-title"><i class="fa-solid fa-book-open" style="margin-right:8px;color:var(--navy-800);"></i> GUIDEBOOK DOWNLOADS & READERS ({{ \App\Models\GuidebookLead::count() }})</h2>
                    <p class="panel-header-sub">Live record of home buyers who submitted their details on the website to access the PDF guide.</p>

                    <div class="table-responsive">
                        <table class="table-custom-dark">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>NAME</th>
                                    <th>MOBILE PHONE</th>
                                    <th>GMAIL / EMAIL</th>
                                    <th>DATE & TIME</th>
                                    <th>ACTION</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\GuidebookLead::orderBy('id','desc')->get() as $i => $lead)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><strong style="color:var(--slate-900);">{{ $lead->name }}</strong></td>
                                    <td><i class="fa-solid fa-phone" style="margin-right:6px;color:var(--slate-400);"></i> {{ $lead->phone }}</td>
                                    <td><i class="fa-solid fa-envelope" style="margin-right:6px;color:var(--slate-400);"></i> {{ $lead->email }}</td>
                                    <td style="color:var(--slate-500);font-size:0.8rem;">{{ $lead->created_at ? $lead->created_at->format('n/j/Y, g:i:s a') : 'Recently' }}</td>
                                    <td>
                                        <button type="button" class="action-del-btn" onclick="deleteGuidebookLead(event, {{ $lead->id }}, this)"><i class="fa-solid fa-trash"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- 7. INTRO VIDEO TAB -->
            <div class="admin-tab-pane" id="tab-intro">
                <div class="card-dark-panel">
                    <h2 class="panel-header-title"><i class="fa-solid fa-video" style="margin-right:8px;color:var(--navy-800);"></i> WEBSITE INTRO VIDEO MANAGEMENT</h2>
                    <p class="panel-header-sub">Upload, paste URL, or manage the intro video that appears in the hero section or Engineer introduction section.</p>

                    <!-- Current Video Status -->
                    <div style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:12px;padding:20px;margin-top:16px;">
                        <div style="font-size:0.75rem;color:var(--navy-800);font-weight:700;margin-bottom:8px;"><i class="fa-solid fa-video" style="margin-right:6px;"></i> CURRENT ACTIVE INTRO VIDEO</div>
                        <div id="activeVideoDisplay" style="font-size:0.85rem;color:var(--slate-600);word-break:break-all;margin-bottom:16px;">
                            {{ $settings['intro_video_url']->value ?? '/uploads/1785711422_WhatsApp Video 2026-07-30 at 10.50.53 AM.mp4' }}
                        </div>
                        <div style="display:flex;gap:12px;flex-wrap:wrap;">
                            <button type="button" class="btn-gold-pill" id="btnPreviewVideo" onclick="previewIntroVideo()">
                                <i class="fa-solid fa-play" style="margin-right:6px;"></i> PREVIEW VIDEO
                            </button>
                            <button type="button" class="btn-text-danger" onclick="deleteIntroVideo(event, this)">
                                <i class="fa-solid fa-trash"></i> REMOVE VIDEO
                            </button>
                        </div>
                    </div>

                    <!-- Upload New Video File (Up to 2GB) -->
                    <div style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:12px;padding:24px;margin-top:16px;">
                        <div style="font-size:0.78rem;color:var(--navy-800);font-weight:700;margin-bottom:14px;"><i class="fa-solid fa-cloud-arrow-up" style="margin-right:6px;"></i> UPLOAD NEW VIDEO FILE (MAX 2GB)</div>

                        <div id="videoDropZone" onclick="document.getElementById('introVideoFileInput').click()"
                             style="border:2px dashed var(--slate-300);border-radius:12px;padding:32px;text-align:center;cursor:pointer;transition:all 0.2s;background:#FFFFFF;"
                             onmouseover="this.style.borderColor='var(--navy-800)';this.style.background='var(--slate-50)';"
                             onmouseout="this.style.borderColor='var(--slate-300)';this.style.background='#FFFFFF';">
                            <i class="fa-solid fa-video" style="font-size:2rem;color:var(--navy-800);margin-bottom:10px;display:block;"></i>
                            <div style="color:var(--slate-900);font-weight:700;margin-bottom:4px;">Click to select MP4 / MOV / WebM video file</div>
                            <div style="color:var(--slate-500);font-size:0.8rem;">MP4, MOV, WebM, MKV • Max 2.0 GB (Lossless Chunked Stream)</div>
                            <input type="file" id="introVideoFileInput" accept="video/mp4,video/quicktime,video/webm,video/x-matroska,video/avi,.mp4,.mov,.webm,.mkv,.avi" style="display:none;" onchange="handleIntroVideoUpload(event)">
                        </div>

                        <div id="videoUploadProgress" style="display:none;margin-top:16px;">
                            <div style="display:flex;justify-content:space-between;margin-bottom:6px;font-size:0.78rem;color:var(--slate-600);">
                                <span id="introUploadMetrics">0 MB / 0 MB • 0.0 MB/s</span>
                                <span id="introUploadPercentText" style="color:var(--navy-800);font-weight:800;">0%</span>
                            </div>
                            <div style="background:var(--slate-200);border-radius:8px;height:8px;overflow:hidden;">
                                <div id="videoProgressBar" style="height:100%;width:0%;background:var(--navy-800);transition:width 0.25s ease;border-radius:8px;"></div>
                            </div>
                            <div style="display:flex;justify-content:space-between;align-items:center;margin-top:8px;">
                                <div id="videoUploadStatus" style="color:var(--navy-800);font-size:0.82rem;">Uploading...</div>
                                <button type="button" onclick="cancelCurrentUpload()" style="background:#FEE2E2;border:1px solid #FECACA;color:#DC2626;padding:3px 10px;border-radius:6px;font-size:0.72rem;cursor:pointer;">Cancel</button>
                            </div>
                        </div>
                    </div>

                    <!-- Paste Video URL (alternative) -->
                    <div style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:12px;padding:20px;margin-top:16px;">
                        <div style="font-size:0.78rem;color:var(--navy-800);font-weight:700;margin-bottom:8px;"><i class="fa-solid fa-link" style="margin-right:6px;"></i> OR PASTE A VIDEO URL</div>
                        <p style="font-size:0.8rem;color:var(--slate-500);margin-bottom:12px;">Paste a direct video link (YouTube, Google Drive direct link, or your hosted .mp4 URL).</p>
                        <div style="display:flex;gap:10px;">
                            <input type="url" id="introVideoUrlInput"
                                   value="{{ $settings['intro_video_url']->value ?? '' }}"
                                   class="input-dark" style="flex:1;"
                                   placeholder="https://... (YouTube embed or direct .mp4 URL)">
                            <button class="btn-gold-submit" onclick="saveIntroVideoUrl()" style="width:auto;padding:10px 22px;white-space:nowrap;">
                                <i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> SAVE URL
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 8. ADMIN ACCOUNT & SECURITY TAB -->
            <div class="admin-tab-pane" id="tab-security">
                <div class="card-dark-panel" style="max-width:680px;">
                    <h2 class="panel-header-title"><i class="fa-solid fa-shield-halved" style="margin-right:8px;color:var(--navy-800);"></i> ADMIN ACCOUNT & LOGIN CREDENTIALS</h2>
                    <p class="panel-header-sub">Manage the email address and password required to access this Admin Panel. Changes take effect immediately.</p>

                    <div id="securityAlert" style="display:none;padding:14px 18px;border-radius:10px;margin-bottom:22px;font-size:0.9rem;font-weight:600;line-height:1.5;"></div>

                    <form id="adminAccountForm" class="quote-form-grid" style="margin-top:20px;" onsubmit="event.preventDefault(); saveAdminCredentials(document.getElementById('btnSaveCredentials'));">
                        <div class="form-field full-width">
                            <label>ADMIN LOGIN EMAIL *</label>
                            <input type="email" id="adminEmail" value="{{ $adminUser->email ?? session('admin_email', 'Mahaconstructions2013@gmail.com') }}" class="input-dark" required autocomplete="username" placeholder="admin@example.com">
                        </div>
                        <div class="form-field full-width">
                            <label>NEW ADMIN LOGIN PASSWORD <span style="color:var(--slate-500);font-size:0.8rem;text-transform:none;font-weight:normal;">(Leave blank to keep current password)</span></label>
                            <div style="position:relative;">
                                <input type="password" id="adminPassword" placeholder="Enter new password (min. 6 characters)" class="input-dark" style="width:100%;padding-right:48px;box-sizing:border-box;" autocomplete="new-password">
                                <button type="button" onclick="togglePwdAdmin('adminPassword','adminEyeIcon')"
                                        style="position:absolute;right:14px;top:50%;transform:translateY(-50%);background:none;border:none;color:var(--slate-400);cursor:pointer;padding:4px;font-size:1rem;display:flex;align-items:center;justify-content:center;transition:color 0.2s;"
                                        onmouseover="this.style.color='var(--navy-800)'" onmouseout="this.style.color='var(--slate-400)'"
                                        title="Toggle password visibility">
                                    <i class="fa-solid fa-eye" id="adminEyeIcon"></i>
                                </button>
                            </div>
                            <small style="color:var(--slate-500);font-size:0.75rem;margin-top:6px;display:block;">If you do not want to change your password, simply leave this field empty and click Save.</small>
                        </div>
                        <div class="form-field full-width" style="margin-top:20px;">
                            <button type="button" id="btnSaveCredentials" onclick="saveAdminCredentials(this)" class="btn-gold-submit" style="width:auto;padding:12px 32px;display:inline-flex;align-items:center;gap:8px;">
                                <i class="fa-solid fa-floppy-disk"></i> SAVE CREDENTIALS
                            </button>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </main>
</div>

<!-- ═══════════════════ UPLOAD & EDIT MODAL ═══════════════════ -->
<div id="uploadModal" style="display:none;position:fixed;inset:0;z-index:9999;background:rgba(15,23,42,0.6);backdrop-filter:blur(6px);align-items:center;justify-content:center;padding:20px;overflow-y:auto;">
    <div style="background:#FFFFFF;border:1px solid var(--slate-200);border-radius:16px;padding:28px 32px;width:600px;max-width:96vw;position:relative;box-shadow:var(--shadow-xl);max-height:92vh;overflow-y:auto;">
        <button onclick="closeUploadModal()" style="position:absolute;top:16px;right:16px;background:var(--slate-100);border:none;color:var(--slate-500);width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:0.9rem;display:flex;align-items:center;justify-content:center;transition:all 0.2s;" onmouseover="this.style.background='var(--slate-200)'" onmouseout="this.style.background='var(--slate-100)'"><i class="fa-solid fa-xmark"></i></button>
        <div id="modalTitle" style="font-size:1.15rem;font-weight:800;color:var(--navy-800);text-transform:uppercase;margin-bottom:4px;letter-spacing:0.04em;">UPLOAD VIDEO REVIEW</div>
        <div id="modalSub" style="font-size:0.8rem;color:var(--slate-500);margin-bottom:20px;">Fill in or update the details below</div>

        <!-- 1. TESTIMONIAL FORM (CREATE & EDIT) -->
        <form id="formTestimonial" style="display:none;" onsubmit="submitTestimonial(event)">
            <input type="hidden" id="t_editing_id" value="">
            <div style="display:flex;flex-direction:column;gap:13px;">
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">BUSINESS DIVISION *</label>
                    <select id="t_business_type" class="input-dark" style="width:100%;">
                        <option value="construction" {{ $activeDivision === 'construction' ? 'selected' : '' }}>Maha Construction</option>
                        <option value="interior" {{ $activeDivision === 'interior' ? 'selected' : '' }}>Maha Interior</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">CLIENT NAME *</label>
                    <input id="t_client_name" type="text" required placeholder="e.g. Dr. Suresh & Family" class="input-dark" style="width:100%;box-sizing:border-box;">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">PROJECT / LOCATION</label>
                        <input id="t_project_name" type="text" placeholder="e.g. Royal Palms Villa, Nagercoil" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">CLIENT ROLE / PROFESSION</label>
                        <input id="t_client_role" type="text" placeholder="e.g. Villa Homeowner" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">FEEDBACK / TESTIMONIAL TEXT</label>
                    <textarea id="t_feedback" rows="2" placeholder="Enter client's words or key quote..." class="input-dark" style="width:100%;box-sizing:border-box;resize:vertical;"></textarea>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">VIDEO FILE (MP4/MOV) OR VIDEO URL</label>
                    <input id="t_video_file" type="file" accept="video/mp4,video/quicktime,video/webm" class="input-dark" style="width:100%;box-sizing:border-box;padding:8px;" onchange="onTestimonialVideoChosen(event)">
                    <input id="t_video_url" type="text" placeholder="Or paste video / YouTube URL here" class="input-dark" style="width:100%;box-sizing:border-box;margin-top:6px;" oninput="onTestimonialVideoUrlChanged(this.value)">
                </div>

                <!-- Cover Image & Auto Video Frame Extractor -->
                <div style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:10px;padding:14px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;margin:0;">
                            <i class="fa-solid fa-image" style="margin-right:4px;color:var(--slate-500);"></i> COVER IMAGE (POSTER / THUMBNAIL)
                        </label>
                        <button type="button" onclick="captureTestimonialFrame()" id="btnCaptureTFrame" style="display:none;background:var(--slate-100);border:1px solid var(--slate-200);color:var(--navy-800);font-size:0.7rem;font-weight:700;padding:3px 8px;border-radius:6px;cursor:pointer;">
                            <i class="fa-solid fa-camera" style="margin-right:4px;"></i> CAPTURE FROM VIDEO
                        </button>
                    </div>
                    <input id="t_image_file" type="file" accept="image/*" class="input-dark" style="width:100%;box-sizing:border-box;padding:8px;" onchange="previewSelectedImage(event, 't_cover_preview_img')">
                    <input id="t_image_url" type="text" placeholder="Or image URL (auto-extracted from video if left blank)" class="input-dark" style="width:100%;box-sizing:border-box;margin-top:6px;">

                    <!-- Live Cover Frame Preview -->
                    <div id="t_cover_preview_box" style="margin-top:10px;display:none;align-items:center;gap:12px;background:#FFFFFF;padding:8px 12px;border-radius:8px;border:1px solid var(--slate-200);">
                        <img id="t_cover_preview_img" src="" style="width:70px;height:50px;object-fit:cover;border-radius:6px;border:1px solid var(--slate-200);" alt="Cover Preview">
                        <div style="font-size:0.72rem;color:var(--slate-600);">
                            <span id="t_cover_preview_status" style="color:#059669;font-weight:700;"><i class="fas fa-check" style="margin-right:4px;"></i> Active Cover Frame</span>
                            <div style="font-size:0.65rem;color:var(--slate-500);margin-top:2px;">Will be used as video thumbnail across site</div>
                        </div>
                    </div>
                </div>

                <div id="modalError" style="color:#DC2626;font-size:0.8rem;display:none;"></div>
                <button type="submit" id="btnSubmitTestimonial" class="btn-gold-submit" style="width:100%;padding:13px;margin-top:4px;"><i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> SAVE VIDEO REVIEW</button>
            </div>
        </form>

        <!-- 2. PROJECT FORM (CREATE & EDIT) -->
        <form id="formProject" style="display:none;" onsubmit="submitProject(event)">
            <input type="hidden" id="p_editing_id" value="">
            <div style="display:flex;flex-direction:column;gap:13px;">
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">BUSINESS DIVISION *</label>
                    <select id="p_business_type" class="input-dark" style="width:100%;" onchange="onProjectDivisionChanged(this.value)">
                        <option value="construction" {{ $activeDivision === 'construction' ? 'selected' : '' }}>Maha Construction</option>
                        <option value="interior" {{ $activeDivision === 'interior' ? 'selected' : '' }}>Maha Interior</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">PROJECT NAME *</label>
                    <input id="p_name" type="text" required placeholder="e.g. Royal Heritage Luxury Villa" class="input-dark" style="width:100%;box-sizing:border-box;">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">CATEGORY / SPACE *</label>
                        <select id="p_category" class="input-dark" style="width:100%;">
                            <optgroup label="Interior Spaces (Maha Interior)" id="optgroupInteriorCats">
                                <option value="living-room">Living Room</option>
                                <option value="modular-kitchen">Modular Kitchen</option>
                                <option value="bedroom">Bedroom</option>
                                <option value="office-interior">Office Interior</option>
                                <option value="full-home-interior">Full Home</option>
                                <option value="commercial-interior">Commercial</option>
                            </optgroup>
                            <optgroup label="Construction Types (Maha Construction)" id="optgroupConstructionCats">
                                <option value="villa">Luxury Villa</option>
                                <option value="residential">Residential Residence</option>
                                <option value="commercial">Commercial Hub</option>
                            </optgroup>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">LOCATION</label>
                        <input id="p_location" type="text" placeholder="e.g. Nagercoil, Tamil Nadu" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">BUILT-UP AREA / SPECS</label>
                        <input id="p_duration" type="text" placeholder="e.g. 3,600 sq.ft" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">BUDGET / COST</label>
                        <input id="p_budget" type="text" placeholder="e.g. ₹85 Lakhs" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">PROJECT DESCRIPTION</label>
                    <textarea id="p_description" rows="2" placeholder="Brief details about architecture, materials, floor plan..." class="input-dark" style="width:100%;box-sizing:border-box;resize:vertical;"></textarea>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">PROJECT WALKTHROUGH VIDEO (MP4) OR VIDEO URL</label>
                    <input id="p_video_file" type="file" accept="video/mp4,video/quicktime,video/webm" class="input-dark" style="width:100%;box-sizing:border-box;padding:8px;" onchange="onProjectVideoChosen(event)">
                    <input id="p_video_url" type="text" placeholder="Or paste video / YouTube URL here" class="input-dark" style="width:100%;box-sizing:border-box;margin-top:6px;" oninput="onProjectVideoUrlChanged(this.value)">
                </div>

                <!-- Project Photos (Multiple Images & Slideshow Gallery Support) -->
                <div style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:10px;padding:16px;">
                    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;flex-wrap:wrap;gap:8px;">
                        <div>
                            <label style="font-size:0.75rem;font-weight:700;color:var(--navy-800);text-transform:uppercase;margin:0;display:flex;align-items:center;gap:6px;">
                                <i class="fa-solid fa-images"></i> PROJECT PHOTOS & GALLERY (MULTIPLE IMAGES SUPPORTED)
                            </label>
                            <span style="font-size:0.7rem;color:var(--slate-500);display:block;margin-top:2px;">
                                Select multiple images in a single upload. They will automatically slideshow and be viewable in full resolution!
                            </span>
                        </div>
                        <button type="button" onclick="captureProjectFrame()" id="btnCapturePFrame" style="display:none;background:var(--slate-100);border:1px solid var(--slate-200);color:var(--navy-800);font-size:0.7rem;font-weight:700;padding:4px 10px;border-radius:6px;cursor:pointer;">
                            <i class="fa-solid fa-camera" style="margin-right:4px;"></i> CAPTURE FROM VIDEO
                        </button>
                    </div>

                    <!-- Multiple File Picker -->
                    <div style="position:relative;margin-top:8px;">
                        <input id="p_image_files" type="file" accept="image/*" multiple class="input-dark" style="width:100%;box-sizing:border-box;padding:10px;border:1px dashed var(--slate-300);background:#FFFFFF;cursor:pointer;" onchange="onProjectImagesSelected(event)">
                        <span style="font-size:0.7rem;color:var(--slate-500);margin-top:4px;display:block;">Tip: Hold Ctrl / Cmd or Shift to select multiple photos at once in the file picker.</span>
                    </div>

                    <!-- Or Paste Direct URL / Add URL -->
                    <div style="display:flex;gap:8px;margin-top:10px;">
                        <input id="p_single_url_input" type="text" placeholder="Or paste photo URL (https://...)" class="input-dark" style="flex:1;box-sizing:border-box;font-size:0.8rem;">
                        <button type="button" onclick="addProjectImageUrl()" class="btn-whatsapp-outline" style="padding:6px 14px;font-size:0.75rem;white-space:nowrap;cursor:pointer;">
                            <i class="fa-solid fa-plus" style="margin-right:4px;"></i> ADD URL
                        </button>
                    </div>

                    <!-- Live Gallery Preview Grid -->
                    <div id="p_gallery_preview_container" style="margin-top:14px;display:none;">
                        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                            <span style="font-size:0.7rem;font-weight:700;color:var(--slate-600);text-transform:uppercase;">
                                SELECTED PHOTOS (<span id="p_gallery_count">0</span>) • First photo is Primary Cover
                            </span>
                            <button type="button" onclick="clearAllProjectImages()" style="background:none;border:none;color:#DC2626;font-size:0.7rem;font-weight:700;cursor:pointer;">
                                <i class="fa-solid fa-trash"></i> Clear All
                            </button>
                        </div>
                        <div id="p_gallery_grid" style="display:grid;grid-template-columns:repeat(auto-fill, minmax(95px, 1fr));gap:10px;">
                            <!-- Dynamically populated thumbnails -->
                        </div>
                    </div>
                </div>

                <div id="projectModalError" style="color:#DC2626;font-size:0.8rem;display:none;"></div>
                <button type="submit" id="btnSubmitProject" class="btn-gold-submit" style="width:100%;padding:13px;margin-top:4px;"><i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> SAVE PROJECT</button>
            </div>
        </form>

        <!-- 3. PACKAGE FORM (CREATE & EDIT) -->
        <form id="formPackage" style="display:none;" onsubmit="submitPackage(event)">
            <input type="hidden" id="pk_editing_id" value="">
            <div style="display:flex;flex-direction:column;gap:13px;">
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">BUSINESS DIVISION *</label>
                    <select id="pk_business_type" class="input-dark" style="width:100%;" onchange="onPackageDivisionChanged(this.value)">
                        <option value="construction" {{ $activeDivision === 'construction' ? 'selected' : '' }}>Maha Construction</option>
                        <option value="interior" {{ $activeDivision === 'interior' ? 'selected' : '' }}>Maha Interior</option>
                    </select>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">DIVISION *</label>
                        <select id="pk_division" class="input-dark" style="width:100%;" required>
                            <option value="residential">Residential</option>
                            <option value="commercial">Commercial</option>
                            <option value="interior">Interior (Modular & Turnkey)</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">TIER CATEGORY * <span style="color:var(--slate-500);font-weight:400;text-transform:none;">(Select or type custom)</span></label>
                        <input id="pk_tier" type="text" list="pk_tier_presets" required placeholder="e.g. Basic, Standard, Premium, Luxury, Elite or Custom" class="input-dark" style="width:100%;box-sizing:border-box;">
                        <datalist id="pk_tier_presets">
                            <option value="basic">Basic Tier</option>
                            <option value="standard">Standard Tier</option>
                            <option value="premium">Premium Tier</option>
                            <option value="luxury">Luxury Tier</option>
                            <option value="elite">Elite Tier</option>
                        </datalist>
                    </div>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">PACKAGE TITLE *</label>
                    <input id="pk_title" type="text" required placeholder="e.g. Premium Residential Package" class="input-dark" style="width:100%;box-sizing:border-box;">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">PRICE PER SQ.FT (₹) <span style="color:var(--slate-500);font-weight:400;text-transform:none;">(Optional)</span></label>
                        <input id="pk_price" type="number" placeholder="e.g. 1850 (Optional)" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">WARRANTY (YEARS) *</label>
                        <input id="pk_warranty" type="number" min="0" max="100" required placeholder="e.g. 10, 15, 20" class="input-dark" style="width:100%;box-sizing:border-box;" value="10">
                    </div>
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">DELIVERY TIMELINE (MONTHS)</label>
                        <input id="pk_delivery" type="number" min="1" max="60" placeholder="e.g. 12, 14, 18" class="input-dark" style="width:100%;box-sizing:border-box;" value="12">
                    </div>
                    <div style="display:flex;align-items:center;padding-top:18px;">
                        <label style="display:inline-flex;align-items:center;gap:8px;font-size:0.75rem;color:var(--slate-800);font-weight:700;cursor:pointer;">
                            <input type="checkbox" id="pk_highlighted" style="accent-color:var(--navy-800);width:18px;height:18px;cursor:pointer;">
                            <span><i class="fa-solid fa-star" style="color:var(--gold);margin-right:4px;"></i> MOST POPULAR / HIGHLIGHTED</span>
                        </label>
                    </div>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">SUBTITLE / TAGLINE</label>
                    <input id="pk_subtitle" type="text" placeholder="e.g. Best for luxury family residences" class="input-dark" style="width:100%;box-sizing:border-box;">
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">DESCRIPTION / SPECS HIGHLIGHTS</label>
                    <textarea id="pk_description" rows="2" placeholder="Key materials, structural specifications, warranty..." class="input-dark" style="width:100%;box-sizing:border-box;resize:vertical;"></textarea>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">MATERIAL FEATURES <span style="color:var(--slate-500);font-weight:400;text-transform:none;">(one per line — shown as checklist on pricing cards)</span></label>
                    <textarea id="pk_features" rows="8" placeholder="Fe-500 TMT steel
Coromandel / ACC cement
M-Sand blockwork
Vitrified floor tiles (2'×2')
Parryware CP fittings
Kundan / Anchor concealed wiring
Flush door entry system
Asian Paints Emulsion finish" class="input-dark" style="width:100%;box-sizing:border-box;resize:vertical;font-size:0.82rem;line-height:1.6;"></textarea>
                    <div style="font-size:0.72rem;color:var(--slate-500);margin-top:4px;"><i class="fa-solid fa-lightbulb" style="margin-right:4px;color:var(--slate-400);"></i> Each line becomes one feature on the pricing card. Leave blank lines to skip.</div>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">INCLUSIONS <span style="color:var(--slate-500);font-weight:400;text-transform:none;">(one per line)</span></label>
                    <textarea id="pk_inclusions" rows="5" placeholder="Site supervision
Civil structural work
Plastering & waterproofing" class="input-dark" style="width:100%;box-sizing:border-box;resize:vertical;font-size:0.82rem;line-height:1.6;"></textarea>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">EXCLUSIONS <span style="color:var(--slate-500);font-weight:400;text-transform:none;">(one per line)</span></label>
                    <textarea id="pk_exclusions" rows="4" placeholder="Interior design
Modular kitchen
Landscaping" class="input-dark" style="width:100%;box-sizing:border-box;resize:vertical;font-size:0.82rem;line-height:1.6;"></textarea>
                </div>
                <div id="packageModalError" style="color:#DC2626;font-size:0.8rem;display:none;"></div>
                <button type="submit" id="btnSubmitPackage" class="btn-gold-submit" style="width:100%;padding:13px;margin-top:4px;"><i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> SAVE PACKAGE</button>
            </div>
        </form>

        <!-- 4. PARTNER & VENDOR FORM (CREATE & EDIT) -->
        <form id="formPartner" style="display:none;" onsubmit="submitPartner(event)">
            <input type="hidden" id="pt_editing_id" value="">
            <div style="display:flex;flex-direction:column;gap:13px;">
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">PARTNER / BANK / VENDOR NAME *</label>
                    <input id="pt_name" type="text" required placeholder="e.g. State Bank of India or UltraTech Cement" class="input-dark" style="width:100%;box-sizing:border-box;">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">CATEGORY / DIVISION *</label>
                        <select id="pt_division" class="input-dark" style="width:100%;">
                            <option value="banking">Banking Partner (Finance & Loans)</option>
                            <option value="vendor">Material Vendor / Brand</option>
                            <option value="joint_venture">Joint Venture Partner</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">OFFICIAL WEBSITE URL</label>
                        <input id="pt_website_url" type="url" placeholder="https://www.example.com" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                </div>

                <!-- Logo Image Upload / URL -->
                <div style="background:#F8FAFC;border:1px solid var(--slate-200);border-radius:10px;padding:14px;">
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:6px;">
                        <i class="fa-solid fa-image" style="margin-right:4px;color:var(--slate-500);"></i> LOGO IMAGE (UPLOAD FILE OR ENTER URL)
                    </label>
                    <input id="pt_logo_file" type="file" accept="image/*" class="input-dark" style="width:100%;box-sizing:border-box;padding:8px;" onchange="previewSelectedImage(event, 'pt_logo_preview_img', 'pt_logo_preview_box')">
                    <input id="pt_logo_url" type="text" placeholder="Or enter logo image URL (e.g. /images/banks/sbi.png)" class="input-dark" style="width:100%;box-sizing:border-box;margin-top:6px;" oninput="onPartnerLogoUrlChanged(this.value)">

                    <!-- Live Logo Preview -->
                    <div id="pt_logo_preview_box" style="margin-top:10px;display:none;align-items:center;gap:12px;background:#FFFFFF;padding:8px 12px;border-radius:8px;border:1px solid var(--slate-200);">
                        <div style="background:#fff;padding:4px 8px;border-radius:6px;border:1px solid var(--slate-200);display:flex;align-items:center;justify-content:center;min-width:90px;height:48px;">
                            <img id="pt_logo_preview_img" src="" style="max-height:40px;max-width:110px;object-fit:contain;" alt="Logo Preview">
                        </div>
                        <div style="font-size:0.72rem;color:var(--slate-600);">
                            <span style="color:#059669;font-weight:700;"><i class="fas fa-check" style="margin-right:4px;"></i> Active Logo Preview</span>
                            <div style="font-size:0.65rem;color:var(--slate-500);margin-top:2px;">Displayed across Banking & Vendor website sections</div>
                        </div>
                    </div>
                </div>

                <div id="partnerModalError" style="color:#DC2626;font-size:0.8rem;display:none;"></div>
                <button type="submit" id="btnSubmitPartner" class="btn-gold-submit" style="width:100%;padding:13px;margin-top:4px;"><i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> SAVE PARTNER</button>
            </div>
        </form>

        <!-- 5. SERVICE FORM (CREATE & EDIT) -->
        <form id="formService" style="display:none;" onsubmit="submitService(event)">
            <input type="hidden" id="s_editing_id" value="">
            <div style="display:flex;flex-direction:column;gap:13px;">
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">BUSINESS DIVISION *</label>
                    <select id="s_business_type" class="input-dark" style="width:100%;">
                        <option value="construction" {{ $activeDivision === 'construction' ? 'selected' : '' }}>Maha Construction</option>
                        <option value="interior" {{ $activeDivision === 'interior' ? 'selected' : '' }}>Maha Interior</option>
                    </select>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">SERVICE NAME *</label>
                    <input id="s_name" type="text" required placeholder="e.g. Modular Kitchen Design & Execution" class="input-dark" style="width:100%;box-sizing:border-box;" oninput="autoGenerateServiceSlug(this.value)">
                </div>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">SLUG *</label>
                        <input id="s_slug" type="text" required placeholder="modular-kitchen-design" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                    <div>
                        <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">CATEGORY</label>
                        <input id="s_category" type="text" placeholder="e.g. Modular Kitchen, Luxury, Civil" class="input-dark" style="width:100%;box-sizing:border-box;">
                    </div>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">OVERVIEW / DESCRIPTION</label>
                    <textarea id="s_overview" rows="3" placeholder="Describe this service offering, workflow, and materials..." class="input-dark" style="width:100%;box-sizing:border-box;resize:vertical;"></textarea>
                </div>
                <div>
                    <label style="font-size:0.72rem;font-weight:700;color:var(--slate-700);text-transform:uppercase;display:block;margin-bottom:5px;">COVER IMAGE FILE OR URL</label>
                    <input id="s_image_file" type="file" accept="image/*" class="input-dark" style="width:100%;box-sizing:border-box;padding:8px;" onchange="previewSelectedImage(event, 's_cover_preview_img', 's_cover_preview_box')">
                    <input id="s_image_url" type="text" placeholder="Or paste image URL here" class="input-dark" style="width:100%;box-sizing:border-box;margin-top:6px;">
                    <div id="s_cover_preview_box" style="margin-top:10px;display:none;align-items:center;gap:12px;background:#FFFFFF;padding:8px 12px;border-radius:8px;border:1px solid var(--slate-200);">
                        <img id="s_cover_preview_img" src="" style="width:70px;height:50px;object-fit:cover;border-radius:6px;border:1px solid var(--slate-200);" alt="Cover Preview">
                        <span style="font-size:0.72rem;color:#059669;font-weight:700;"><i class="fas fa-check" style="margin-right:4px;"></i> Image Selected</span>
                    </div>
                </div>
                <div id="serviceModalError" style="color:#DC2626;font-size:0.8rem;display:none;"></div>
                <button type="submit" id="btnSubmitService" class="btn-gold-submit" style="width:100%;padding:13px;margin-top:4px;"><i class="fa-solid fa-floppy-disk" style="margin-right:6px;"></i> SAVE SERVICE</button>
            </div>
        </form>

        <!-- Live Uploading Indicator with Real-Time Progress -->
        <div id="uploadingIndicator" style="display:none;padding:16px 0;">
            <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <i class="fa-solid fa-spinner fa-spin" style="font-size:1.2rem;color:var(--navy-800);"></i>
                    <div style="color:var(--navy-800);font-weight:700;letter-spacing:0.04em;font-size:0.88rem;" id="modalUploadTitle">UPLOADING & PROCESSING...</div>
                </div>
                <span id="modalUploadPercentText" style="color:var(--navy-800);font-weight:800;font-size:1rem;">0%</span>
            </div>

            <div style="background:var(--slate-200);border-radius:8px;height:10px;overflow:hidden;border:1px solid var(--slate-200);">
                <div id="modalUploadProgressBar" style="height:100%;width:0%;background:var(--navy-800);transition:width 0.25s ease;border-radius:8px;"></div>
            </div>

            <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;margin-top:10px;font-size:0.76rem;color:var(--slate-600);">
                <span id="modalUploadMetrics">0 MB / 0 MB • 0.0 MB/s</span>
                <span id="modalUploadEta">ETA: Calculating...</span>
                <button type="button" onclick="cancelCurrentUpload()" style="background:#FEE2E2;border:1px solid #FECACA;color:#DC2626;padding:3px 10px;border-radius:6px;font-size:0.72rem;cursor:pointer;">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- Custom Animated Delete Confirmation Modal -->
<div id="customDeleteModal" class="delete-modal-backdrop" onclick="closeDeleteModalOnBackdrop(event)">
    <div class="delete-modal-card" id="deleteModalCard">
        <!-- Glowing Floating Trash Icon -->
        <div class="delete-icon-wrapper">
            <div class="delete-icon-glow"></div>
            <div class="delete-icon-circle">
                <i class="fas fa-trash-can delete-icon-symbol"></i>
            </div>
        </div>

        <!-- Title & Description -->
        <h3 class="delete-modal-title" id="deleteModalTitle">CONFIRM PERMANENT DELETE</h3>
        <p class="delete-modal-description" id="deleteModalMessage">
            Are you sure you want to permanently delete this item? This action is permanent and will remove all associated files and data.
        </p>

        <!-- Action Buttons -->
        <div class="delete-modal-actions">
            <button type="button" class="btn-delete-cancel" onclick="closeDeleteModal(false)">
                <i class="fas fa-xmark" style="margin-right:6px;"></i> Cancel
            </button>
            <button type="button" class="btn-delete-confirm" id="btnConfirmDelete">
                <i class="fas fa-trash-arrow-up" style="margin-right:6px;"></i> Yes, Delete
            </button>
        </div>
    </div>
</div>

<!-- Hidden Background Video & Canvas Elements for Auto Frame Extraction -->
<video id="hiddenVideoExtractor" crossOrigin="anonymous" muted playsinline style="display:none;"></video>
<canvas id="hiddenCanvasExtractor" style="display:none;"></canvas>

<script>
const CSRF = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

function togglePwdAdmin(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if (!input || !icon) return;
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('fa-eye', 'fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('fa-eye-slash', 'fa-eye');
    }
}

async function saveAdminCredentials(btn) {
    const emailInput = document.getElementById('adminEmail');
    const passwordInput = document.getElementById('adminPassword');

    const email = emailInput ? emailInput.value.trim() : '';
    const password = passwordInput ? passwordInput.value : '';

    if (!email) {
        showSecurityAlert('<i class="fas fa-circle-exclamation" style="margin-right:6px;"></i> Please enter an admin email address.', 'error');
        if (emailInput) emailInput.focus();
        return;
    }

    if (password && password.length < 6) {
        showSecurityAlert('<i class="fas fa-circle-exclamation" style="margin-right:6px;"></i> New password must be at least 6 characters long.', 'error');
        if (passwordInput) passwordInput.focus();
        return;
    }

    const originalText = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> SAVING...';
    btn.style.opacity = '0.7';

    try {
        const response = await fetch('/api/admin/credentials', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                password: password
            })
        });

        const data = await response.json().catch(() => ({}));

        if (response.status === 401) {
            alert('Your admin session has expired. Redirecting to login...');
            window.location.href = '/admin/login';
            return;
        }

        if (!response.ok) {
            const msg = data.message || (data.errors ? Object.values(data.errors).flat().join('<br>') : 'Failed to update credentials.');
            showSecurityAlert('<i class="fas fa-circle-exclamation" style="margin-right:6px;"></i> ' + msg, 'error');
            return;
        }

        showSecurityAlert('<i class="fas fa-circle-check" style="margin-right:6px;"></i> ' + (data.message || 'Credentials updated successfully!'), 'success');

        if (passwordInput) {
            passwordInput.value = '';
            const icon = document.getElementById('adminEyeIcon');
            if (icon && passwordInput.type === 'text') {
                passwordInput.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    } catch (err) {
        console.error('Error updating credentials:', err);
        showSecurityAlert('<i class="fas fa-circle-exclamation" style="margin-right:6px;"></i> Network error: ' + err.message, 'error');
    } finally {
        btn.disabled = false;
        btn.innerHTML = originalText;
        btn.style.opacity = '1';
    }
}

function showSecurityAlert(message, type) {
    const box = document.getElementById('securityAlert');
    if (!box) return;
    box.style.display = 'flex';
    if (type === 'success') {
        box.style.background = '#ECFDF5';
        box.style.border = '1px solid #A7F3D0';
        box.style.color = '#065F46';
    } else {
        box.style.background = '#FEF2F2';
        box.style.border = '1px solid #FECACA';
        box.style.color = '#991B1B';
    }
    box.innerHTML = message;
    box.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

// ─── ADMIN WEBSITE & LEAD ANALYTICS JAVASCRIPT ENGINE ───────────
let analyticsDivision = '{{ $activeDivision }}';
let analyticsPeriod = '30days';
let chartInstances = {};

function setAnalyticsDivision(div) {
    analyticsDivision = div;
    ['all', 'construction', 'interior'].forEach(d => {
        const btn = document.getElementById('btnDiv' + (d === 'all' ? 'All' : (d === 'construction' ? 'Const' : 'Int')));
        if (btn) btn.classList.toggle('active', d === div);
    });
    fetchAdminAnalytics();
}

function setAnalyticsPeriod(p) {
    analyticsPeriod = p;
    ['today', '7days', '30days', '3months', '1year'].forEach(item => {
        const btn = document.getElementById('btnPeriod' + item);
        if (btn) btn.classList.toggle('active', item === p);
    });
    fetchAdminAnalytics();
}

function destroyChart(chartId) {
    if (chartInstances[chartId]) {
        try { chartInstances[chartId].destroy(); } catch(e) {}
        delete chartInstances[chartId];
    }
}

async function fetchAdminAnalytics() {
    const icon = document.getElementById('analyticsRefreshIcon');
    if (icon) icon.classList.add('fa-spin');

    try {
        const res = await fetch(`/api/admin/analytics/overview?division=${analyticsDivision}&period=${analyticsPeriod}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        if (!res.ok) throw new Error('Failed to load analytics: ' + res.status);
        const data = await res.json();
        renderAdminAnalytics(data);
    } catch(err) {
        console.error('Analytics load error:', err);
    } finally {
        if (icon) icon.classList.remove('fa-spin');
    }
}

function renderAdminAnalytics(data) {
    if (!data || !data.kpis) return;

    // 1. KPI Cards
    const kpis = data.kpis;
    const vEl = document.getElementById('kpiVisitors');
    if (vEl) vEl.textContent = (kpis.visitors || 0).toLocaleString();
    const nvEl = document.getElementById('kpiNewVisitors');
    if (nvEl) nvEl.textContent = (kpis.new_visitors || 0).toLocaleString();
    const rvEl = document.getElementById('kpiReturningVisitors');
    if (rvEl) rvEl.textContent = (kpis.returning_visitors || 0).toLocaleString();
    const pvEl = document.getElementById('kpiPageViews');
    if (pvEl) pvEl.textContent = (kpis.page_views || 0).toLocaleString();
    const teEl = document.getElementById('kpiTotalEvents');
    if (teEl) teEl.textContent = (kpis.total_events || 0).toLocaleString();
    const sEl = document.getElementById('kpiSessions');
    if (sEl) sEl.textContent = (kpis.sessions || 0).toLocaleString();
    const eEl = document.getElementById('kpiEnquiries');
    if (eEl) eEl.textContent = (kpis.enquiries || 0).toLocaleString();
    const cEl = document.getElementById('kpiConsultations');
    if (cEl) cEl.textContent = (kpis.consultations || 0).toLocaleString();
    const crEl = document.getElementById('kpiConversionRate');
    if (crEl) crEl.textContent = (kpis.conversion_rate || 0).toFixed(2) + '%';

    // 2. Division Comparison Strip
    if (data.division_comparison) {
        const c = data.division_comparison.construction || {};
        const i = data.division_comparison.interior || {};

        const cv = document.getElementById('constVisitors'); if (cv) cv.textContent = (c.visitors || 0).toLocaleString();
        const cs = document.getElementById('constSessions'); if (cs) cs.textContent = (c.sessions || 0).toLocaleString();
        const cp = document.getElementById('constPageViews'); if (cp) cp.textContent = (c.page_views || 0).toLocaleString();
        const ce = document.getElementById('constEnquiries'); if (ce) ce.textContent = (c.enquiries || 0).toLocaleString();
        const ccr = document.getElementById('constConvRate'); if (ccr) ccr.textContent = (c.conversion_rate || 0).toFixed(2) + '%';

        const iv = document.getElementById('intVisitors'); if (iv) iv.textContent = (i.visitors || 0).toLocaleString();
        const is = document.getElementById('intSessions'); if (is) is.textContent = (i.sessions || 0).toLocaleString();
        const ip = document.getElementById('intPageViews'); if (ip) ip.textContent = (i.page_views || 0).toLocaleString();
        const ie = document.getElementById('intEnquiries'); if (ie) ie.textContent = (i.consultations || i.enquiries || 0).toLocaleString();
        const icr = document.getElementById('intConvRate'); if (icr) icr.textContent = (i.conversion_rate || 0).toFixed(2) + '%';
    }

    // 3. Render Chart 1: Visitors & Views Over Time
    if (data.time_series && typeof Chart !== 'undefined') {
        renderTimelineChart(data.time_series);
    }

    // 4. Render Chart 2: Division Comparison Chart
    if (data.division_comparison && typeof Chart !== 'undefined') {
        renderDivisionChart(data.division_comparison);
    }

    // 5. Render Chart 3: Traffic Sources
    if (data.traffic_sources && typeof Chart !== 'undefined') {
        renderSourcesChart(data.traffic_sources);
    }

    // 6. Render Chart 4: Device Breakdown
    if (data.device_breakdown && typeof Chart !== 'undefined') {
        renderDeviceChart(data.device_breakdown);
    }

    // 7. Render Chart 5: Interior Section Funnel
    if (data.section_performance && typeof Chart !== 'undefined') {
        renderSectionFunnelChart(data.section_performance);
    }

    // 8. Top Pages Table
    renderTopPagesTable(data.top_pages || []);

    // 9. Top Sources Table
    renderTopSourcesTable(data.traffic_sources || []);

    // 10. Recent Leads Table
    renderRecentLeadsTable(data.recent_leads || []);
}

function renderTimelineChart(ts) {
    destroyChart('chartVisitorsTimeline');
    const ctx = document.getElementById('chartVisitorsTimeline')?.getContext('2d');
    if (!ctx) return;

    chartInstances['chartVisitorsTimeline'] = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ts.labels || [],
            datasets: [
                {
                    label: 'Unique Visitors',
                    data: ts.visitors || [],
                    borderColor: '#0F172A',
                    backgroundColor: 'rgba(15, 23, 42, 0.05)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3,
                    pointRadius: 3,
                    pointHoverRadius: 5,
                },
                {
                    label: 'Page Views',
                    data: ts.page_views || [],
                    borderColor: '#2563EB',
                    backgroundColor: 'transparent',
                    borderWidth: 2,
                    borderDash: [4, 4],
                    tension: 0.3,
                    pointRadius: 2,
                },
                {
                    label: 'Enquiries',
                    data: ts.enquiries || [],
                    borderColor: '#10B981',
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    pointRadius: 4,
                    pointBackgroundColor: '#10B981',
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { labels: { color: '#475569', font: { family: 'Inter', size: 11, weight: '600' } } }
            },
            scales: {
                x: { ticks: { color: '#64748B', font: { size: 10 } }, grid: { color: '#E2E8F0' } },
                y: { ticks: { color: '#64748B', font: { size: 10 } }, grid: { color: '#E2E8F0' }, beginAtZero: true }
            }
        }
    });
}

function renderDivisionChart(comp) {
    destroyChart('chartDivisionComparison');
    const ctx = document.getElementById('chartDivisionComparison')?.getContext('2d');
    if (!ctx) return;

    const c = comp.construction || {};
    const i = comp.interior || {};

    chartInstances['chartDivisionComparison'] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Unique Visitors', 'Page Views', 'Enquiries'],
            datasets: [
                {
                    label: 'Construction',
                    data: [c.visitors || 0, c.page_views || 0, c.enquiries || 0],
                    backgroundColor: '#0F172A',
                    borderColor: '#0F172A',
                    borderWidth: 1,
                    borderRadius: 4,
                },
                {
                    label: 'Interior',
                    data: [i.visitors || 0, i.page_views || 0, i.enquiries || 0],
                    backgroundColor: '#2563EB',
                    borderColor: '#2563EB',
                    borderWidth: 1,
                    borderRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { labels: { color: '#475569', font: { family: 'Inter', size: 11, weight: '600' } } }
            },
            scales: {
                x: { ticks: { color: '#64748B' }, grid: { color: '#E2E8F0' } },
                y: { ticks: { color: '#64748B' }, grid: { color: '#E2E8F0' }, beginAtZero: true }
            }
        }
    });
}

function renderSourcesChart(sources) {
    destroyChart('chartTrafficSources');
    const ctx = document.getElementById('chartTrafficSources')?.getContext('2d');
    if (!ctx) return;

    const labels = sources.map(s => s.referrer_host || 'Direct');
    const data = sources.map(s => s.visitors || s.total || 0);

    if (labels.length === 0) {
        labels.push('Direct');
        data.push(1);
    }

    chartInstances['chartTrafficSources'] = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: [
                    '#0F172A', '#2563EB', '#0D9488', '#F59E0B', '#8B5CF6', '#64748B', '#94A3B8'
                ],
                borderWidth: 2,
                borderColor: '#FFFFFF'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right', labels: { color: '#475569', font: { family: 'Inter', size: 10 } } }
            }
        }
    });
}

function renderDeviceChart(devices) {
    destroyChart('chartDeviceBreakdown');
    const ctx = document.getElementById('chartDeviceBreakdown')?.getContext('2d');
    if (!ctx) return;

    const labels = ['Mobile', 'Desktop', 'Tablet'];
    const data = [
        devices['mobile'] ? devices['mobile'].count : 0,
        devices['desktop'] ? devices['desktop'].count : 0,
        devices['tablet'] ? devices['tablet'].count : 0,
    ];

    if (data.every(v => v === 0)) {
        data[1] = 1;
    }

    chartInstances['chartDeviceBreakdown'] = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: ['#10B981', '#0F172A', '#2563EB'],
                borderWidth: 2,
                borderColor: '#FFFFFF'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'right', labels: { color: '#475569', font: { family: 'Inter', size: 10 } } }
            }
        }
    });
}

function renderSectionFunnelChart(sections) {
    destroyChart('chartSectionFunnel');
    const ctx = document.getElementById('chartSectionFunnel')?.getContext('2d');
    if (!ctx) return;

    const labels = sections.map(s => s.section_name);
    const data = sections.map(s => s.views || 0);

    chartInstances['chartSectionFunnel'] = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Section Views (Unique Sessions)',
                data: data,
                backgroundColor: [
                    '#0F172A', '#1E293B', '#334155', '#475569', '#64748B', '#2563EB', '#10B981'
                ],
                borderRadius: 4,
                borderWidth: 1,
                borderColor: 'rgba(15, 23, 42, 0.1)'
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                x: { ticks: { color: '#64748B' }, grid: { color: '#E2E8F0' }, beginAtZero: true },
                y: { ticks: { color: '#1E293B', font: { weight: '600', size: 11 } }, grid: { display: false } }
            }
        }
    });
}

function renderTopPagesTable(pages) {
    const tbody = document.getElementById('tableTopPagesBody');
    if (!tbody) return;
    if (pages.length === 0) {
        tbody.innerHTML = '<tr><td colspan="3" style="text-align:center;color:#64748B;padding:16px;">No page view data recorded yet in this time window.</td></tr>';
        return;
    }

    let html = '';
    pages.forEach(p => {
        html += `
            <tr>
                <td style="font-weight:600;color:var(--navy-900);">
                    <i class="fas fa-file-lines" style="color:var(--slate-500);margin-right:6px;"></i> ${p.page_name}
                </td>
                <td style="color:var(--navy-800);font-weight:700;">${(p.views || 0).toLocaleString()}</td>
                <td style="color:var(--slate-600);font-weight:600;">${(p.visitors || 0).toLocaleString()}</td>
            </tr>
        `;
    });
    tbody.innerHTML = html;
}

function renderTopSourcesTable(sources) {
    const tbody = document.getElementById('tableTopSourcesBody');
    if (!tbody) return;
    if (sources.length === 0) {
        tbody.innerHTML = '<tr><td colspan="3" style="text-align:center;color:#64748B;padding:16px;">No external referrer data recorded yet.</td></tr>';
        return;
    }

    let html = '';
    sources.forEach(s => {
        html += `
            <tr>
                <td style="font-weight:600;color:var(--navy-900);">
                    <i class="fas fa-globe" style="color:var(--slate-500);margin-right:6px;"></i> ${s.referrer_host || 'Direct'}
                </td>
                <td style="color:var(--navy-800);font-weight:700;">${(s.visitors || 0).toLocaleString()}</td>
                <td style="color:var(--slate-600);">${(s.total || 0).toLocaleString()}</td>
            </tr>
        `;
    });
    tbody.innerHTML = html;
}

function renderRecentLeadsTable(leads) {
    const tbody = document.getElementById('tableRecentLeadsBody');
    if (!tbody) return;
    if (leads.length === 0) {
        tbody.innerHTML = '<tr><td colspan="9" style="text-align:center;color:#64748B;padding:16px;">No recent leads recorded yet.</td></tr>';
        return;
    }

    let html = '';
    leads.forEach(l => {
        const isInt = l.division === 'INTERIOR';
        const divBadge = isInt 
            ? `<span style="background:#EFF6FF;color:#2563EB;border:1px solid #BFDBFE;padding:2px 8px;border-radius:4px;font-size:0.68rem;font-weight:700;">INTERIOR</span>`
            : `<span style="background:#F1F5F9;color:#0F172A;border:1px solid #CBD5E1;padding:2px 8px;border-radius:4px;font-size:0.68rem;font-weight:700;">CONSTRUCTION</span>`;

        html += `
            <tr>
                <td style="font-weight:700;color:var(--navy-900);">#${l.id}</td>
                <td>${divBadge}</td>
                <td style="font-weight:600;color:var(--navy-900);">${l.name}</td>
                <td style="font-family:monospace;color:var(--slate-600);">${l.phone}</td>
                <td style="color:var(--navy-800);font-weight:600;">${l.project_type}</td>
                <td><span style="background:var(--slate-100);color:var(--slate-700);border:1px solid var(--slate-200);padding:2px 6px;border-radius:4px;font-size:0.75rem;">${l.source}</span></td>
                <td style="color:var(--slate-600);">${l.device}</td>
                <td style="color:var(--slate-500);font-family:monospace;font-size:0.75rem;">${l.landing_page}</td>
                <td style="color:var(--slate-500);font-size:0.75rem;">${l.created_at}</td>
            </tr>
        `;
    });
    tbody.innerHTML = html;
}

function toggleAdminSidebar() {
    const sidebar = document.querySelector('.admin-sidebar');
    if (sidebar) {
        sidebar.classList.toggle('open');
    }
}

function switchAdminTab(tabKey, linkEl) {
    if (!linkEl) {
        linkEl = document.querySelector(`.sidebar-nav-link[onclick*="'${tabKey}'"]`) || 
                 document.querySelector(`.sidebar-nav-link[onclick*='"${tabKey}"']`);
    }
    document.querySelectorAll('.sidebar-nav-link').forEach(el => el.classList.remove('active'));
    if (linkEl) linkEl.classList.add('active');
    document.querySelectorAll('.admin-tab-pane').forEach(pane => pane.classList.remove('active'));
    const targetPane = document.getElementById('tab-' + tabKey);
    if (targetPane) targetPane.classList.add('active');

    const sidebar = document.querySelector('.admin-sidebar');
    if (sidebar && sidebar.classList.contains('open')) {
        sidebar.classList.remove('open');
    }

    if (tabKey === 'analytics') {
        if (typeof fetchAdminAnalytics === 'function') {
            fetchAdminAnalytics();
        }
    }

    try {
        localStorage.setItem('maha_admin_active_tab', tabKey);
        history.replaceState(null, null, '#' + tabKey);
    } catch(e) {}
}

// ── DIVISION WORKSPACE ENGINE (CONSTRUCTION VS INTERIOR SEPARATION) ──
let currentDivision = '{{ $activeDivision }}';

function toggleDivisionQuickly() {
    const nextDiv = currentDivision === 'construction' ? 'interior' : 'construction';
    window.location.href = nextDiv === 'interior' ? '{{ route("admin.interior") }}' : '{{ route("admin.construction") }}';
}

function setAdminDivision(division) {
    if (division !== currentDivision) {
        window.location.href = division === 'interior' ? '{{ route("admin.interior") }}' : '{{ route("admin.construction") }}';
        return;
    }
    try {
        localStorage.setItem('maha_admin_division', division);
    } catch(e) {}

    const isInt = division === 'interior';

    // 1. Update Header division buttons
    const btnConst = document.getElementById('btnDivConstruction');
    const btnInt = document.getElementById('btnDivInterior');
    if (btnConst && btnInt) {
        btnConst.classList.toggle('active', !isInt);
        btnInt.classList.toggle('active', isInt);
    }

    // 2. Update Sidebar workspace buttons & indicator
    const sideConst = document.getElementById('sideDivConst');
    const sideInt = document.getElementById('sideDivInt');
    const sideInd = document.getElementById('sidebarActiveDivisionIndicator');
    if (sideConst && sideInt) {
        if (isInt) {
            sideConst.style.background = 'transparent';
            sideConst.style.color = 'var(--slate-400)';
            sideConst.style.boxShadow = 'none';
            if (sideConst.querySelector('i')) sideConst.querySelector('i').style.color = 'var(--slate-400)';

            sideInt.style.background = '#FFFFFF';
            sideInt.style.color = 'var(--navy-900)';
            sideInt.style.boxShadow = '0 1px 4px rgba(0,0,0,0.15)';
            if (sideInt.querySelector('i')) sideInt.querySelector('i').style.color = 'var(--navy-900)';
        } else {
            sideConst.style.background = '#FFFFFF';
            sideConst.style.color = 'var(--navy-900)';
            sideConst.style.boxShadow = '0 1px 4px rgba(0,0,0,0.15)';
            if (sideConst.querySelector('i')) sideConst.querySelector('i').style.color = 'var(--navy-900)';

            sideInt.style.background = 'transparent';
            sideInt.style.color = 'var(--slate-400)';
            sideInt.style.boxShadow = 'none';
            if (sideInt.querySelector('i')) sideInt.querySelector('i').style.color = 'var(--slate-400)';
        }
    }
    if (sideInd) {
        sideInd.innerHTML = isInt ? '<span style="color:#C8952B;">● INTERIOR</span>' : '<span style="color:#10B981;">● CONST</span>';
    }

    // 3. Filter all cards across Reviews, Projects, Packages, and Quotes
    document.querySelectorAll('.division-filterable').forEach(el => {
        const itemType = el.getAttribute('data-business-type') || 'construction';
        if (itemType === division) {
            el.style.display = '';
            el.style.animation = 'cardEnterCascade 0.28s cubic-bezier(0.16, 1, 0.3, 1) forwards';
        } else {
            el.style.display = 'none';
        }
    });

    // 4. Update empty states
    checkEmptyStates();

    // 5. Update panel titles, banners, action buttons, and descriptions
    updatePanelTitlesForDivision(division);

    // 6. Update sidebar navigation labels & dynamic badge counts
    updateSidebarCountsForDivision(division);

    // 7. Update top header live site link
    const liveLink = document.getElementById('adminLiveWebsiteLink');
    if (liveLink) {
        if (isInt) {
            liveLink.href = '{{ route("interior") }}';
            liveLink.innerHTML = '<i class="fas fa-couch" style="margin-right:6px;"></i> Live Interior Site';
        } else {
            liveLink.href = '{{ route("home") }}';
            liveLink.innerHTML = '<i class="fas fa-building" style="margin-right:6px;"></i> Live Construction Site';
        }
    }

    // 8. Sync YouTube sub-tab if active
    if (typeof switchYtDivision === 'function') {
        switchYtDivision(division);
    }
}

function updatePanelTitlesForDivision(division) {
    const isInt = division === 'interior';
    
    // Sidebar Header Brand Sub-badge
    const subBadge = document.getElementById('adminSidebarSubBadge');
    if (subBadge) {
        subBadge.textContent = isInt ? 'INTERIOR STUDIO WORKSPACE' : 'CONSTRUCTION WORKSPACE';
    }

    // Top Header Subtitle
    const headerSub = document.getElementById('adminHeaderConsoleSub');
    if (headerSub) {
        headerSub.textContent = isInt ? 'Maha Interior — Bespoke Design & Turnkey Fitouts' : 'Maha Construction — Luxury Villas & Structural Building';
    }

    // Sidebar Section Header
    const sbSecOps = document.getElementById('sidebarSectionOperations');
    if (sbSecOps) {
        sbSecOps.textContent = isInt ? 'INTERIOR OPERATIONS' : 'CONSTRUCTION OPERATIONS';
    }

    // Sidebar Navigation Labels
    const sbLblAnalytics = document.getElementById('sidebarLabelAnalytics');
    if (sbLblAnalytics) sbLblAnalytics.textContent = isInt ? 'Interior Analytics' : 'Construction Analytics';

    const sbLblReviews = document.getElementById('sidebarLabelReviews');
    if (sbLblReviews) sbLblReviews.textContent = isInt ? 'Interior Video Reviews' : 'Homeowner Testimonials';

    const sbLblProjects = document.getElementById('sidebarLabelProjects');
    if (sbLblProjects) sbLblProjects.textContent = isInt ? 'Interior Projects' : 'Completed Buildings';

    const sbLblPackages = document.getElementById('sidebarLabelPackages');
    if (sbLblPackages) sbLblPackages.textContent = isInt ? 'Interior Packages' : 'Building Packages';

    const sbLblQuotes = document.getElementById('sidebarLabelQuotes');
    if (sbLblQuotes) sbLblQuotes.textContent = isInt ? 'Design Consultations' : 'Building Inquiries';

    // ── Scope Banners & Action Buttons in Tabs ──
    const targetSwitchText = isInt ? 'Switch to Construction Division' : 'Switch to Interior Studio';
    const targetSwitchUrl  = isInt ? '{{ route("admin.construction") }}' : '{{ route("admin.interior") }}';

    // Reviews Tab
    const rTitle = document.getElementById('title-reviews');
    const rSub = document.getElementById('sub-reviews');
    const rBtn = document.getElementById('action-btn-reviews');
    const rBText = document.getElementById('badge-text-reviews');
    const rBDesc = document.getElementById('desc-reviews');
    const rBSwitch = document.getElementById('switch-btn-reviews');
    if (rTitle) rTitle.innerHTML = isInt ? '<i class="fa-solid fa-couch" style="margin-right:8px;color:var(--navy-900);"></i> Luxury Interior Video Reviews' : '<i class="fa-solid fa-video" style="margin-right:8px;color:var(--navy-900);"></i> Construction Video Testimonials';
    if (rSub) rSub.textContent = isInt ? 'Manage walkthrough and testimonial videos from luxury interior clients.' : 'Manage client video testimonials from verified villa and home construction homeowners.';
    if (rBtn) rBtn.innerHTML = isInt ? '<i class="fa-solid fa-plus" style="margin-right:6px;"></i> Upload Interior Review' : '<i class="fa-solid fa-plus" style="margin-right:6px;"></i> Upload Construction Review';
    if (rBText) rBText.textContent = isInt ? 'INTERIOR STUDIO RECORDS' : 'CONSTRUCTION DIVISION RECORDS';
    if (rBDesc) rBDesc.textContent = isInt ? 'Showing video reviews from interior clients across Tamil Nadu.' : 'Showing video testimonials from verified residential and villa homeowners.';
    if (rBSwitch) {
        rBSwitch.href = targetSwitchUrl;
        rBSwitch.innerHTML = `<span>${targetSwitchText}</span> <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i>`;
    }

    // Projects Tab
    const pTitle = document.getElementById('title-projects');
    const pSub = document.getElementById('sub-projects');
    const pBtn = document.getElementById('action-btn-projects');
    const pBText = document.getElementById('badge-text-projects');
    const pBDesc = document.getElementById('desc-projects');
    const pBSwitch = document.getElementById('switch-btn-projects');
    if (pTitle) pTitle.innerHTML = isInt ? '<i class="fa-solid fa-couch" style="margin-right:8px;color:var(--navy-900);"></i> Luxury Interior Design Projects' : '<i class="fa-solid fa-building-circle-check" style="margin-right:8px;color:var(--navy-900);"></i> Completed Construction Projects';
    if (pSub) pSub.textContent = isInt ? 'Showcase modular kitchens, living spaces, bedrooms, and commercial interior fitouts.' : 'Showcase luxury villas, commercial complexes, and turnkey structural buildings.';
    if (pBtn) pBtn.innerHTML = isInt ? '<i class="fa-solid fa-plus" style="margin-right:6px;"></i> Add Interior Project' : '<i class="fa-solid fa-plus" style="margin-right:6px;"></i> Add Construction Project';
    if (pBText) pBText.textContent = isInt ? 'INTERIOR STUDIO RECORDS' : 'CONSTRUCTION DIVISION RECORDS';
    if (pBDesc) pBDesc.textContent = isInt ? 'Managing modular kitchens, bespoke living rooms, wardrobes, and commercial spaces.' : 'Managing completed villas, residences, and architectural homes.';
    if (pBSwitch) {
        pBSwitch.href = targetSwitchUrl;
        pBSwitch.innerHTML = `<span>${targetSwitchText}</span> <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i>`;
    }

    // Packages Tab
    const pkTitle = document.getElementById('title-packages');
    const pkSub = document.getElementById('sub-packages');
    const pkBtn = document.getElementById('action-btn-packages');
    const pkBText = document.getElementById('badge-text-packages');
    const pkBDesc = document.getElementById('desc-packages');
    const pkBSwitch = document.getElementById('switch-btn-packages');
    if (pkTitle) pkTitle.innerHTML = isInt ? '<i class="fa-solid fa-couch" style="margin-right:8px;color:var(--navy-900);"></i> Luxury Interior Packages & Pricing' : '<i class="fa-solid fa-cubes" style="margin-right:8px;color:var(--navy-900);"></i> Building Construction Packages & Pricing';
    if (pkSub) pkSub.textContent = isInt ? 'Manage turnkey interior packages, modular kitchen tiers, and per sq.ft estimates.' : 'Manage per sq.ft rates for Residential & Commercial building construction packages.';
    if (pkBtn) pkBtn.innerHTML = isInt ? '<i class="fa-solid fa-plus" style="margin-right:6px;"></i> Add Interior Package' : '<i class="fa-solid fa-plus" style="margin-right:6px;"></i> Add Construction Package';
    if (pkBText) pkBText.textContent = isInt ? 'INTERIOR STUDIO RECORDS' : 'CONSTRUCTION DIVISION RECORDS';
    if (pkBDesc) pkBDesc.textContent = isInt ? 'Managing modular kitchen packages, bedroom woodwork, and turnkey interior rates.' : 'Managing building packages, structural rates, and material specification tiers.';
    if (pkBSwitch) {
        pkBSwitch.href = targetSwitchUrl;
        pkBSwitch.innerHTML = `<span>${targetSwitchText}</span> <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i>`;
    }

    // Quotes Tab
    const qTitle = document.getElementById('title-quotes');
    const qSub = document.getElementById('sub-quotes');
    const qBText = document.getElementById('badge-text-quotes');
    const qBDesc = document.getElementById('desc-quotes');
    const qBSwitch = document.getElementById('switch-btn-quotes');
    if (qTitle) qTitle.innerHTML = isInt ? '<i class="fa-solid fa-couch" style="margin-right:8px;color:var(--navy-900);"></i> Interior Consultation Requests' : '<i class="fa-solid fa-file-invoice-dollar" style="margin-right:8px;color:var(--navy-800);"></i> Construction Inquiries & Estimates';
    if (qSub) qSub.textContent = isInt ? 'Live record of interior consultation requests and space planning inquiries.' : 'Live record of inquiries for house building estimates, floor plans, and turnkey construction.';
    if (qBText) qBText.textContent = isInt ? 'INTERIOR STUDIO RECORDS' : 'CONSTRUCTION DIVISION RECORDS';
    if (qBDesc) qBDesc.textContent = isInt ? 'Showing incoming consultation requests submitted via the Maha Interior studio page.' : 'Showing incoming building estimate requests submitted via the Maha Construction website.';
    if (qBSwitch) {
        qBSwitch.href = targetSwitchUrl;
        qBSwitch.innerHTML = `<span>${targetSwitchText}</span> <i class="fa-solid fa-arrow-right" style="font-size:0.7rem;"></i>`;
    }
}

function updateSidebarCountsForDivision(division) {
    const revCount = document.querySelectorAll('#tab-reviews .division-filterable:not([style*="display: none"])').length;
    const projCount = document.querySelectorAll('#tab-projects .division-filterable:not([style*="display: none"])').length;
    const pkgCount = document.querySelectorAll('#tab-packages .division-filterable:not([style*="display: none"])').length;
    const quoteCount = document.querySelectorAll('#tab-quotes .division-filterable:not([style*="display: none"])').length;

    const animateCount = (el, val) => {
        if (!el) return;
        el.textContent = val;
        el.style.animation = 'none';
        void el.offsetWidth; // trigger reflow
        el.style.animation = 'badgeBounce 0.35s ease';
    };

    animateCount(document.getElementById('sidebarReviewsCount'), revCount);
    animateCount(document.getElementById('sidebarProjectsCount'), projCount);
    animateCount(document.getElementById('sidebarPackagesCount'), pkgCount);
    animateCount(document.getElementById('sidebarQuotesCount'), quoteCount);
}

function checkEmptyStates() {
    ['reviews', 'projects', 'packages', 'services', 'quotes'].forEach(tab => {
        const pane = document.getElementById('tab-' + tab);
        if (!pane) return;
        const visibleItems = pane.querySelectorAll('.division-filterable:not([style*="display: none"])');
        const emptyEl = document.getElementById(tab + 'EmptyState');
        if (emptyEl) {
            emptyEl.style.display = visibleItems.length === 0 ? 'block' : 'none';
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    setAdminDivision(currentDivision);

    let savedTab = window.location.hash ? window.location.hash.replace('#', '') : null;
    if (!savedTab) {
        savedTab = localStorage.getItem('maha_admin_active_tab');
    }
    if (savedTab && document.getElementById('tab-' + savedTab)) {
        switchAdminTab(savedTab);
    }
});

// ── CUSTOM ANIMATED DELETE CONFIRMATION MODAL ENGINE ──────────────
let deleteModalResolve = null;

function showDeleteConfirmModal(options = {}) {
    const title = options.title || 'CONFIRM PERMANENT DELETE';
    const message = options.message || 'Are you sure you want to permanently delete this item? This action is permanent and cannot be undone.';
    const confirmText = options.confirmText || 'Yes, Delete';

    document.getElementById('deleteModalTitle').textContent = title;
    document.getElementById('deleteModalMessage').textContent = message;
    const confirmBtn = document.getElementById('btnConfirmDelete');
    confirmBtn.innerHTML = `<i class="fas fa-trash-arrow-up" style="margin-right:6px;"></i> ${confirmText}`;

    const modal = document.getElementById('customDeleteModal');
    modal.style.display = 'flex';
    // Trigger CSS scale/fade animation
    requestAnimationFrame(() => {
        modal.classList.add('show');
    });

    return new Promise((resolve) => {
        deleteModalResolve = resolve;
    });
}

function closeDeleteModal(result = false) {
    const modal = document.getElementById('customDeleteModal');
    modal.classList.remove('show');
    setTimeout(() => {
        modal.style.display = 'none';
        if (deleteModalResolve) {
            deleteModalResolve(result);
            deleteModalResolve = null;
        }
    }, 280);
}

function closeDeleteModalOnBackdrop(e) {
    if (e.target.id === 'customDeleteModal') {
        closeDeleteModal(false);
    }
}

document.getElementById('btnConfirmDelete').addEventListener('click', function() {
    closeDeleteModal(true);
});

// ── ROBUST DELETE ITEM ENGINE ─────────────────────────────────────
async function deleteItem(event, endpoint, id, btnEl) {
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }

    const entityNames = {
        'testimonials': 'Client Video Review',
        'projects': 'Completed Project',
        'packages': 'Package',
        'partners': 'Banking / Vendor Partner',
        'services': 'Service',
        'leads': 'Lead Inquiry'
    };
    const entityName = entityNames[endpoint] || 'Item';

    const confirmed = await showDeleteConfirmModal({
        title: `DELETE ${entityName.toUpperCase()}?`,
        message: `Are you sure you want to permanently delete this ${entityName}? This action is immediate and will remove all associated files and data.`,
        confirmText: 'Yes, Delete Permanently'
    });
    if (!confirmed) return;

    const originalHtml = btnEl ? btnEl.innerHTML : '';
    if (btnEl) {
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btnEl.style.opacity = '0.7';
    }

    try {
        const res = await fetch('/api/' + endpoint + '/' + id, {
            method: 'DELETE',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (res.status === 401) {
            alert('Your admin session has expired. Redirecting to login...');
            window.location.href = '/admin/login';
            return;
        }

        if (!res.ok && res.status !== 404) {
            const errData = await res.json().catch(() => ({}));
            throw new Error(errData.message || 'Server error (' + res.status + ')');
        }

        // Smooth visual card removal with shrink + blur animation
        const card = btnEl ? (btnEl.closest('.project-video-card') || btnEl.closest('.package-card') || btnEl.closest('tr')) : null;
        if (card) {
            card.style.transition = 'all 0.38s cubic-bezier(0.4, 0, 0.2, 1)';
            card.style.transform = 'scale(0.85) translateY(-8px)';
            card.style.opacity = '0';
            card.style.filter = 'blur(4px)';
            setTimeout(() => {
                card.remove();
            }, 380);
        } else {
            location.reload();
        }
    } catch (err) {
        console.error('Delete error:', err);
        alert('Delete failed: ' + err.message);
        if (btnEl) {
            btnEl.disabled = false;
            btnEl.innerHTML = originalHtml;
            btnEl.style.opacity = '1';
        }
    }
}


async function deleteGuidebookLead(event, id, btnEl) {
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }
    const confirmed = await showDeleteConfirmModal({
        title: 'DELETE GUIDEBOOK INQUIRY?',
        message: 'Are you sure you want to permanently delete this reader guidebook lead inquiry?',
        confirmText: 'Yes, Delete Lead'
    });
    if (!confirmed) return;

    const originalHtml = btnEl ? btnEl.innerHTML : '';
    if (btnEl) {
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btnEl.style.opacity = '0.7';
    }

    try {
        const res = await fetch('/api/leads/guidebook/' + id, {
            method: 'DELETE',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (res.status === 401) {
            alert('Your admin session has expired. Redirecting to login...');
            window.location.href = '/admin/login';
            return;
        }

        if (!res.ok && res.status !== 404) {
            const errData = await res.json().catch(() => ({}));
            throw new Error(errData.message || 'Server error (' + res.status + ')');
        }

        const row = btnEl ? btnEl.closest('tr') : null;
        if (row) {
            row.style.transition = 'all 0.35s ease';
            row.style.opacity = '0';
            row.style.transform = 'scale(0.9)';
            setTimeout(() => row.remove(), 350);
        }
    } catch (err) {
        console.error('Delete error:', err);
        alert('Delete failed: ' + err.message);
        if (btnEl) {
            btnEl.disabled = false;
            btnEl.innerHTML = originalHtml;
            btnEl.style.opacity = '1';
        }
    }
}

async function markQuoteAsRead(event, id, btnEl) {
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }
    const originalHtml = btnEl ? btnEl.innerHTML : '';
    if (btnEl) {
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    }

    try {
        const res = await fetch('/api/quotes/' + id + '/read', {
            method: 'PUT',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (res.status === 401) {
            alert('Your admin session has expired. Redirecting to login...');
            window.location.href = '/admin/login';
            return;
        }

        if (!res.ok) {
            throw new Error('Server error (' + res.status + ')');
        }

        if (btnEl) {
            const parentTd = btnEl.parentElement;
            parentTd.innerHTML = '<span style="color:#25D366;font-size:0.72rem;font-weight:700;"><i class="fas fa-check-double"></i> Read</span>';
        }
    } catch (err) {
        console.error('Mark read error:', err);
        alert('Error: ' + err.message);
        if (btnEl) {
            btnEl.disabled = false;
            btnEl.innerHTML = originalHtml;
        }
    }
}

async function deleteQuoteLead(event, id, btnEl) {
    if (event) {
        event.stopPropagation();
        event.preventDefault();
    }
    const confirmed = await showDeleteConfirmModal({
        title: 'DELETE CONSULTATION LEAD?',
        message: 'Are you sure you want to permanently delete this consultation lead entry?',
        confirmText: 'Yes, Delete Lead'
    });
    if (!confirmed) return;

    const originalHtml = btnEl ? btnEl.innerHTML : '';
    if (btnEl) {
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btnEl.style.opacity = '0.7';
    }

    try {
        const res = await fetch('/api/quotes/' + id, {
            method: 'DELETE',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        if (res.status === 401) {
            alert('Your admin session has expired. Redirecting to login...');
            window.location.href = '/admin/login';
            return;
        }

        if (!res.ok && res.status !== 404) {
            const errData = await res.json().catch(() => ({}));
            throw new Error(errData.message || 'Server error (' + res.status + ')');
        }

        const row = btnEl ? btnEl.closest('tr') : null;
        if (row) {
            row.style.transition = 'all 0.38s cubic-bezier(0.4, 0, 0.2, 1)';
            row.style.transform = 'scale(0.85) translateY(-8px)';
            row.style.opacity = '0';
            setTimeout(() => {
                row.remove();
                const table = document.getElementById('quotesTable');
                const remaining = table ? table.querySelectorAll('tbody tr.division-filterable').length : 0;
                const sidebarBadge = document.getElementById('sidebarQuotesCount');
                if (sidebarBadge) sidebarBadge.textContent = remaining;
                const totalBadge = document.getElementById('quotesHeaderTotalBadge');
                if (totalBadge) totalBadge.textContent = remaining + ' Total Leads';
                checkEmptyStates();
            }, 380);
        } else {
            location.reload();
        }
    } catch (err) {
        console.error('Delete error:', err);
        alert('Delete failed: ' + err.message);
        if (btnEl) {
            btnEl.disabled = false;
            btnEl.innerHTML = originalHtml;
            btnEl.style.opacity = '1';
        }
    }
}

// ── MODAL MANAGEMENT (CREATE & EDIT MODES) ────────────────────────
let autoExtractedTestimonialBlob = null;
let autoExtractedProjectBlob     = null;
let projectGalleryItems          = [];

function resetAllForms() {
    ['formTestimonial','formProject','formPackage','formPartner','formService'].forEach(id => {
        const f = document.getElementById(id);
        if (f) { f.style.display = 'none'; f.reset(); }
    });
    ['modalError','projectModalError','packageModalError','partnerModalError','serviceModalError'].forEach(id => {
        const el = document.getElementById(id);
        if (el) { el.style.display = 'none'; el.textContent = ''; }
    });
    document.getElementById('uploadingIndicator').style.display = 'none';
    const _tBox = document.getElementById('t_cover_preview_box'); if (_tBox) _tBox.style.display = 'none';
    const _ptBox = document.getElementById('pt_logo_preview_box'); if (_ptBox) _ptBox.style.display = 'none';
    if (document.getElementById('s_cover_preview_box')) document.getElementById('s_cover_preview_box').style.display = 'none';
    document.getElementById('btnCaptureTFrame').style.display = 'none';
    document.getElementById('btnCapturePFrame').style.display = 'none';
    document.getElementById('t_editing_id').value = '';
    document.getElementById('p_editing_id').value = '';
    document.getElementById('pk_editing_id').value = '';
    document.getElementById('pt_editing_id').value = '';
    if (document.getElementById('s_editing_id')) document.getElementById('s_editing_id').value = '';
    if (document.getElementById('pk_warranty')) document.getElementById('pk_warranty').value = '10';
    if (document.getElementById('pk_delivery')) document.getElementById('pk_delivery').value = '12';
    if (document.getElementById('pk_highlighted')) document.getElementById('pk_highlighted').checked = false;
    autoExtractedTestimonialBlob = null;
    autoExtractedProjectBlob     = null;
    projectGalleryItems          = [];
    if (typeof renderProjectGalleryGrid === 'function') renderProjectGalleryGrid();
}

function onProjectDivisionChanged(div) {
    const catSelect = document.getElementById('p_category');
    if (!catSelect) return;
    if (div === 'interior') {
        catSelect.value = 'living-room';
    } else {
        catSelect.value = 'villa';
    }
}

function onPackageDivisionChanged(div) {
    const pkDiv = document.getElementById('pk_division');
    if (!pkDiv) return;
    if (div === 'interior') {
        pkDiv.value = 'interior';
    } else if (pkDiv.value === 'interior') {
        pkDiv.value = 'residential';
    }
}

function openUploadModal(type) {
    resetAllForms();
    const modal = document.getElementById('uploadModal');
    modal.style.display = 'flex';

    const curDiv = (typeof currentDivision !== 'undefined' && currentDivision) ? currentDivision : 'construction';
    const isInt = curDiv === 'interior';

    const titles = {
        testimonial: [
            isInt ? 'UPLOAD INTERIOR VIDEO REVIEW' : 'UPLOAD HOMEOWNER TESTIMONIAL',
            isInt ? 'Add a luxury interior walkthrough & client review' : 'Add a verified homeowner building testimonial video',
            'formTestimonial',
            'btnSubmitTestimonial',
            isInt ? 'SAVE INTERIOR REVIEW' : 'SAVE CONSTRUCTION TESTIMONIAL'
        ],
        project: [
            isInt ? 'ADD COMPLETED INTERIOR PROJECT' : 'ADD COMPLETED BUILDING PROJECT',
            isInt ? 'Showcase modular kitchen, living space, bedroom, or turnkey interior' : 'Add a luxury villa, residence, or commercial building walkthrough',
            'formProject',
            'btnSubmitProject',
            isInt ? 'SAVE INTERIOR PROJECT' : 'SAVE CONSTRUCTION PROJECT'
        ],
        package: [
            isInt ? 'ADD NEW INTERIOR PACKAGE' : 'ADD NEW BUILDING PACKAGE',
            isInt ? 'Create a turnkey modular kitchen or interior package tier' : 'Create a residential or commercial building construction package',
            'formPackage',
            'btnSubmitPackage',
            isInt ? 'SAVE INTERIOR PACKAGE' : 'SAVE CONSTRUCTION PACKAGE'
        ],
        partner:     ['ADD NEW PARTNER / VENDOR', 'Add a banking partner for loans or a certified material vendor', 'formPartner', 'btnSubmitPartner', 'SAVE PARTNER'],
        service:     ['ADD NEW SERVICE', 'Create a new service offering for Construction or Interior', 'formService', 'btnSubmitService', 'SAVE SERVICE'],
    };

    const cfg = titles[type];
    if (!cfg) return;
    document.getElementById('modalTitle').textContent = cfg[0];
    document.getElementById('modalSub').textContent   = cfg[1];
    document.getElementById(cfg[2]).style.display      = 'block';
    if (cfg[3] && document.getElementById(cfg[3])) {
        document.getElementById(cfg[3]).textContent = cfg[4];
    }

    // Default division dropdown to current active division
    if (document.getElementById('t_business_type')) document.getElementById('t_business_type').value = curDiv;
    if (document.getElementById('p_business_type')) document.getElementById('p_business_type').value = curDiv;
    if (document.getElementById('pk_business_type')) document.getElementById('pk_business_type').value = curDiv;
    if (document.getElementById('s_business_type')) document.getElementById('s_business_type').value = curDiv;
    if (type === 'package' && document.getElementById('pk_division')) {
        document.getElementById('pk_division').value = (curDiv === 'interior') ? 'interior' : 'residential';
    }
    if (type === 'project') {
        onProjectDivisionChanged(curDiv);
        projectGalleryItems = [];
        renderProjectGalleryGrid();
    }
}

function openEditModal(type, item) {
    resetAllForms();
    const modal = document.getElementById('uploadModal');
    modal.style.display = 'flex';

    if (type === 'testimonial') {
        document.getElementById('modalTitle').textContent = 'EDIT VIDEO REVIEW';
        document.getElementById('modalSub').textContent   = 'Update client review details, video, or cover image';
        document.getElementById('formTestimonial').style.display = 'block';
        document.getElementById('btnSubmitTestimonial').innerHTML = '<i class="fas fa-floppy-disk" style="margin-right:6px;"></i> UPDATE VIDEO REVIEW';

        document.getElementById('t_editing_id').value   = item.id;
        if (document.getElementById('t_business_type')) document.getElementById('t_business_type').value = item.business_type || 'construction';
        document.getElementById('t_client_name').value  = item.client_name || '';
        document.getElementById('t_project_name').value = item.project_name || '';
        document.getElementById('t_client_role').value  = item.client_role || '';
        document.getElementById('t_feedback').value     = item.feedback || '';
        document.getElementById('t_video_url').value    = item.video_url || '';
        document.getElementById('t_image_url').value    = item.image_url || '';

        if (item.image_url) {
            document.getElementById('t_cover_preview_img').src = item.image_url;
            document.getElementById('t_cover_preview_box').style.display = 'flex';
        }
        if (item.video_url) {
            document.getElementById('btnCaptureTFrame').style.display = 'inline-block';
        }
    } else if (type === 'project') {
        document.getElementById('modalTitle').textContent = 'EDIT COMPLETED PROJECT';
        document.getElementById('modalSub').textContent   = 'Update project specs, video walkthrough, or photo gallery';
        document.getElementById('formProject').style.display = 'block';
        document.getElementById('btnSubmitProject').innerHTML = '<i class="fas fa-floppy-disk" style="margin-right:6px;"></i> UPDATE PROJECT';

        document.getElementById('p_editing_id').value    = item.id;
        if (document.getElementById('p_business_type')) document.getElementById('p_business_type').value = item.business_type || 'construction';
        document.getElementById('p_name').value          = item.name || '';
        document.getElementById('p_category').value      = item.category || 'villa';
        document.getElementById('p_location').value      = item.location || '';
        document.getElementById('p_duration').value      = item.duration || '';
        document.getElementById('p_budget').value        = item.budget || '';
        document.getElementById('p_description').value   = item.description || '';
        document.getElementById('p_video_url').value     = item.video_url || '';

        projectGalleryItems = [];
        const existingImages = (item.image_urls && Array.isArray(item.image_urls) && item.image_urls.length > 0)
            ? item.image_urls
            : (item.image_url ? [item.image_url] : []);

        existingImages.forEach((imgUrl, i) => {
            if (imgUrl) {
                projectGalleryItems.push({
                    type: 'url',
                    url: imgUrl,
                    preview: imgUrl,
                    name: 'Photo ' + (i + 1)
                });
            }
        });
        renderProjectGalleryGrid();

        if (item.video_url) {
            document.getElementById('btnCapturePFrame').style.display = 'inline-block';
        }
    } else if (type === 'package') {
        document.getElementById('modalTitle').textContent = 'EDIT PACKAGE';
        document.getElementById('modalSub').textContent   = 'Update per sq.ft pricing, specifications & tier';
        document.getElementById('formPackage').style.display = 'block';
        document.getElementById('btnSubmitPackage').innerHTML = '<i class="fas fa-floppy-disk" style="margin-right:6px;"></i> UPDATE PACKAGE';

        document.getElementById('pk_editing_id').value   = item.id;
        if (document.getElementById('pk_business_type')) document.getElementById('pk_business_type').value = item.business_type || 'construction';
        document.getElementById('pk_division').value     = item.division || 'residential';
        document.getElementById('pk_tier').value         = item.tier || 'standard';
        document.getElementById('pk_title').value        = item.title || '';
        document.getElementById('pk_price').value        = (item.price_per_sqft && item.price_per_sqft > 0) ? item.price_per_sqft : '';
        document.getElementById('pk_warranty').value     = (item.warranty_years !== null && item.warranty_years !== undefined) ? item.warranty_years : 10;
        document.getElementById('pk_delivery').value     = item.delivery_months || 12;
        document.getElementById('pk_highlighted').checked = !!item.is_highlighted;
        document.getElementById('pk_subtitle').value     = item.subtitle || '';
        document.getElementById('pk_description').value  = item.description || '';

        // Populate multi-line feature fields
        const toLines = (arr) => Array.isArray(arr) ? arr.join('\n') : (arr || '');
        document.getElementById('pk_features').value    = toLines(item.features);
        document.getElementById('pk_inclusions').value  = toLines(item.inclusions);
        document.getElementById('pk_exclusions').value  = toLines(item.exclusions);
    } else if (type === 'partner') {
        document.getElementById('modalTitle').textContent = 'EDIT PARTNER / VENDOR';
        document.getElementById('modalSub').textContent   = 'Update partner name, category, website URL, or logo image';
        document.getElementById('formPartner').style.display = 'block';
        document.getElementById('btnSubmitPartner').innerHTML = '<i class="fas fa-floppy-disk" style="margin-right:6px;"></i> UPDATE PARTNER';

        document.getElementById('pt_editing_id').value   = item.id;
        document.getElementById('pt_name').value         = item.name || '';
        document.getElementById('pt_division').value     = item.division || 'banking';
        document.getElementById('pt_website_url').value = item.website_url || '';
        document.getElementById('pt_logo_url').value    = item.logo_url || '';

        if (item.logo_url) {
            document.getElementById('pt_logo_preview_img').src = item.logo_url;
            document.getElementById('pt_logo_preview_box').style.display = 'flex';
        }
    } else if (type === 'service') {
        document.getElementById('modalTitle').textContent = 'EDIT SERVICE';
        document.getElementById('modalSub').textContent   = 'Update service name, category, slug, or cover image';
        document.getElementById('formService').style.display = 'block';
        document.getElementById('btnSubmitService').innerHTML = '<i class="fas fa-floppy-disk" style="margin-right:6px;"></i> UPDATE SERVICE';

        document.getElementById('s_editing_id').value    = item.id;
        if (document.getElementById('s_business_type')) document.getElementById('s_business_type').value = item.business_type || 'construction';
        document.getElementById('s_name').value          = item.name || '';
        document.getElementById('s_slug').value          = item.slug || '';
        document.getElementById('s_category').value      = item.category || '';
        document.getElementById('s_overview').value      = item.overview || '';
        document.getElementById('s_image_url').value     = item.image_url || '';

        if (item.image_url) {
            document.getElementById('s_cover_preview_img').src = item.image_url;
            document.getElementById('s_cover_preview_box').style.display = 'flex';
        }
    }
}

function closeUploadModal() {
    document.getElementById('uploadModal').style.display = 'none';
}
document.getElementById('uploadModal').addEventListener('click', function(e) {
    if (e.target === this) closeUploadModal();
});

function previewSelectedImage(e, imgId, boxId) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(evt) {
        const img = document.getElementById(imgId);
        if (img) img.src = evt.target.result;
        if (boxId) {
            const box = document.getElementById(boxId);
            if (box) box.style.display = 'flex';
        } else if (imgId === 't_cover_preview_img') {
            const b = document.getElementById('t_cover_preview_box'); if (b) b.style.display = 'flex';
        }
    };
    reader.readAsDataURL(file);
}

// ── VIDEO FRAME COVER EXTRACTOR ──────────────────────────────────
function extractFrameFromVideoSource(source, callback) {
    const v = document.getElementById('hiddenVideoExtractor');
    let objectUrl = null;

    if (source instanceof File) {
        objectUrl = URL.createObjectURL(source);
        v.src = objectUrl;
    } else if (typeof source === 'string' && source.trim()) {
        const url = source.trim();
        if (url.includes('youtube.com') || url.includes('youtu.be')) {
            let ytId = '';
            if (url.includes('watch?v=')) ytId = url.split('watch?v=')[1]?.split('&')[0];
            else if (url.includes('youtu.be/')) ytId = url.split('youtu.be/')[1]?.split('?')[0];
            else if (url.includes('/shorts/')) ytId = url.split('/shorts/')[1]?.split('?')[0];
            if (ytId) {
                const ytThumb = `https://img.youtube.com/vi/${ytId}/hqdefault.jpg`;
                callback(null, ytThumb);
                return;
            }
        }
        v.src = url;
    } else {
        callback(null, null);
        return;
    }

    v.onloadedmetadata = function() {
        v.currentTime = Math.min(1.0, (v.duration || 2) * 0.1);
    };

    v.onseeked = function() {
        try {
            const canvas = document.getElementById('hiddenCanvasExtractor');
            canvas.width = v.videoWidth || 640;
            canvas.height = v.videoHeight || 360;
            const ctx = canvas.getContext('2d');
            ctx.drawImage(v, 0, 0, canvas.width, canvas.height);
            canvas.toBlob(function(blob) {
                if (objectUrl) URL.revokeObjectURL(objectUrl);
                const dataUrl = canvas.toDataURL('image/jpeg', 0.85);
                callback(blob, dataUrl);
            }, 'image/jpeg', 0.85);
        } catch (err) {
            console.warn('Cannot extract video canvas frame:', err);
            if (objectUrl) URL.revokeObjectURL(objectUrl);
            callback(null, null);
        }
    };

    v.onerror = function() {
        if (objectUrl) URL.revokeObjectURL(objectUrl);
        callback(null, null);
    };
}

function onTestimonialVideoChosen(event) {
    const file = event.target.files[0];
    if (!file) return;
    document.getElementById('btnCaptureTFrame').style.display = 'inline-block';
    extractFrameFromVideoSource(file, (blob, dataUrl) => {
        if (dataUrl) {
            autoExtractedTestimonialBlob = blob;
            document.getElementById('t_cover_preview_img').src = dataUrl;
            document.getElementById('t_cover_preview_box').style.display = 'flex';
            document.getElementById('t_cover_preview_status').innerHTML = '<i class="fas fa-check" style="margin-right:4px;"></i> Auto-Extracted Frame from Video';
        }
    });
}

function onTestimonialVideoUrlChanged(url) {
    if (!url.trim()) return;
    document.getElementById('btnCaptureTFrame').style.display = 'inline-block';
    extractFrameFromVideoSource(url, (blob, dataUrl) => {
        if (dataUrl) {
            autoExtractedTestimonialBlob = blob;
            document.getElementById('t_cover_preview_img').src = dataUrl;
            document.getElementById('t_cover_preview_box').style.display = 'flex';
            document.getElementById('t_cover_preview_status').innerHTML = '<i class="fas fa-check" style="margin-right:4px;"></i> Auto-Extracted Frame from Video';
        }
    });
}

function captureTestimonialFrame() {
    const file = document.getElementById('t_video_file').files[0];
    const url  = document.getElementById('t_video_url').value.trim();
    extractFrameFromVideoSource(file || url, (blob, dataUrl) => {
        if (dataUrl) {
            autoExtractedTestimonialBlob = blob;
            document.getElementById('t_cover_preview_img').src = dataUrl;
            document.getElementById('t_cover_preview_box').style.display = 'flex';
            document.getElementById('t_cover_preview_status').innerHTML = '<i class="fas fa-check" style="margin-right:4px;"></i> Captured Frame from Video';
        }
    });
}

function onProjectVideoChosen(event) {
    const file = event.target.files[0];
    if (!file) return;
    document.getElementById('btnCapturePFrame').style.display = 'inline-block';
    // Auto-extract a preview frame from the video and add it to the gallery as the cover photo
    extractFrameFromVideoSource(file, (blob, dataUrl) => {
        if (!dataUrl) return;
        autoExtractedProjectBlob = blob;
        // Remove any previous auto-extracted frame (type === 'blob') at index 0
        if (projectGalleryItems.length > 0 && projectGalleryItems[0].type === 'blob') {
            projectGalleryItems.shift();
        }
        projectGalleryItems.unshift({
            type: 'blob',
            blob: blob,
            preview: dataUrl,
            name: 'Auto-Extracted Video Frame (Cover)'
        });
        renderProjectGalleryGrid();
    });
}

function onProjectVideoUrlChanged(url) {
    if (!url.trim()) return;
    document.getElementById('btnCapturePFrame').style.display = 'inline-block';
    extractFrameFromVideoSource(url, (blob, dataUrl) => {
        if (dataUrl) {
            autoExtractedProjectBlob = blob;
            projectGalleryItems.unshift({
                type: 'blob',
                blob: blob,
                preview: dataUrl,
                name: 'Auto-Extracted Video Frame'
            });
            renderProjectGalleryGrid();
        }
    });
}

function captureProjectFrame() {
    const file = document.getElementById('p_video_file').files[0];
    const url  = document.getElementById('p_video_url').value.trim();
    extractFrameFromVideoSource(file || url, (blob, dataUrl) => {
        if (dataUrl) {
            autoExtractedProjectBlob = blob;
            projectGalleryItems.unshift({
                type: 'blob',
                blob: blob,
                preview: dataUrl,
                name: 'Captured Frame from Video'
            });
            renderProjectGalleryGrid();
        }
    });
}

function previewSelectedImage(event, targetImgId) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById(targetImgId);
        if (img) {
            img.src = e.target.result;
            img.closest('div[id$="_cover_preview_box"]').style.display = 'flex';
        }
    };
    reader.readAsDataURL(file);
}

// ── MULTI-IMAGE PROJECT GALLERY HELPERS ─────────────────────────
function onProjectImagesSelected(e) {
    const files = Array.from(e.target.files || []);
    if (!files.length) return;

    files.forEach(f => {
        projectGalleryItems.push({
            type: 'file',
            file: f,
            preview: URL.createObjectURL(f),
            name: f.name
        });
    });
    renderProjectGalleryGrid();
    e.target.value = '';
}

function addProjectImageUrl() {
    const inp = document.getElementById('p_single_url_input');
    const url = inp ? inp.value.trim() : '';
    if (!url) return;
    projectGalleryItems.push({
        type: 'url',
        url: url,
        preview: url,
        name: 'URL Image'
    });
    if (inp) inp.value = '';
    renderProjectGalleryGrid();
}

function removeProjectGalleryItem(idx) {
    projectGalleryItems.splice(idx, 1);
    renderProjectGalleryGrid();
}

function clearAllProjectImages() {
    projectGalleryItems = [];
    renderProjectGalleryGrid();
}

function renderProjectGalleryGrid() {
    const container = document.getElementById('p_gallery_preview_container');
    const grid = document.getElementById('p_gallery_grid');
    const countEl = document.getElementById('p_gallery_count');
    if (!container || !grid) return;

    if (projectGalleryItems.length === 0) {
        container.style.display = 'none';
        grid.innerHTML = '';
        if (countEl) countEl.textContent = '0';
        return;
    }

    container.style.display = 'block';
    if (countEl) countEl.textContent = projectGalleryItems.length;

    grid.innerHTML = projectGalleryItems.map((item, idx) => `
        <div style="position:relative;border-radius:8px;overflow:hidden;border:1.5px solid ${idx === 0 ? '#D4AF37' : 'rgba(212,175,55,0.25)'};background:#0B132B;box-shadow:0 2px 8px rgba(0,0,0,0.4);">
            <img src="${item.preview}" style="width:100%;height:75px;object-fit:cover;display:block;" alt="Photo ${idx+1}" onerror="this.src='https://images.unsplash.com/photo-1600585154340-be6161a56a0c?auto=format&fit=crop&w=300&q=80'">
            <span style="position:absolute;top:4px;left:4px;background:rgba(5,11,20,0.85);color:${idx === 0 ? '#D4AF37' : '#FFFFFF'};padding:1px 5px;border-radius:4px;font-size:0.6rem;font-weight:800;border:1px solid rgba(212,175,55,0.3);">
                ${idx === 0 ? '<i class="fas fa-star" style="margin-right:2px;"></i> COVER' : '#' + (idx + 1)}
            </span>
            <button type="button" onclick="removeProjectGalleryItem(${idx})" style="position:absolute;top:4px;right:4px;background:rgba(239,68,68,0.9);color:#FFF;border:none;border-radius:50%;width:18px;height:18px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:0.6rem;line-height:1;" title="Remove Photo">
                <i class="fas fa-xmark"></i>
            </button>
        </div>
    `).join('');
}

// ── FORMAT HELPERS & ABORT ENGINE ────────────────────────────────
let currentUploadAbortController = null;
let activeUploadId = null;

function formatBytes(bytes, decimals = 2) {
    if (!+bytes) return '0 Bytes';
    const k = 1024;
    const dm = decimals < 0 ? 0 : decimals;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return `${parseFloat((bytes / Math.pow(k, i)).toFixed(dm))} ${sizes[i]}`;
}

function formatDuration(seconds) {
    if (!isFinite(seconds) || seconds < 0) return '--';
    if (seconds < 60) return Math.round(seconds) + 's';
    const m = Math.floor(seconds / 60);
    const s = Math.round(seconds % 60);
    return `${m}m ${s}s`;
}

function cancelCurrentUpload() {
    if (currentUploadAbortController) {
        currentUploadAbortController.abort();
        currentUploadAbortController = null;
    }
    if (activeUploadId) {
        fetch('/api/upload/abort', {
            method: 'POST',
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            body: JSON.stringify({ upload_id: activeUploadId })
        }).catch(() => {});
        activeUploadId = null;
    }
    const ind = document.getElementById('uploadingIndicator');
    if (ind) ind.style.display = 'none';
    const vmProg = document.getElementById('vmProgressContainer');
    if (vmProg) vmProg.style.display = 'none';
    const vDrop = document.getElementById('vmDropZone');
    if (vDrop) vDrop.style.display = 'block';
    const vidProg = document.getElementById('videoUploadProgress');
    if (vidProg) vidProg.style.display = 'none';
    const pdfProg = document.getElementById('pdfUploadProgress');
    if (pdfProg) pdfProg.style.display = 'none';
    alert('Upload cancelled.');
}

// ── RESILIENT CHUNKED UPLOAD ENGINE (UP TO 2GB, LOSSLESS) ────────
async function uploadFileWithChunks(file, options = {}) {
    const chunkSize = options.chunkSize || (5 * 1024 * 1024); // 5MB chunks
    const totalSize = file.size;
    const totalChunks = Math.ceil(totalSize / chunkSize);
    const filename = options.customFilename || file.name || ('upload_' + Date.now() + '.mp4');
    const uploadId = 'up_' + Date.now() + '_' + Math.random().toString(36).substring(2, 9);
    activeUploadId = uploadId;

    currentUploadAbortController = new AbortController();
    const signal = options.abortSignal || currentUploadAbortController.signal;

    const startTime = Date.now();
    let bytesUploaded = 0;

    for (let chunkIndex = 0; chunkIndex < totalChunks; chunkIndex++) {
        if (signal.aborted) {
            await fetch('/api/upload/abort', {
                method: 'POST',
                credentials: 'include',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
                body: JSON.stringify({ upload_id: uploadId })
            }).catch(() => {});
            throw new Error('Upload cancelled by user.');
        }

        const start = chunkIndex * chunkSize;
        const end = Math.min(start + chunkSize, totalSize);
        const chunkBlob = file.slice(start, end);
        const chunkSizeBytes = end - start;

        let chunkUploaded = false;
        let lastError = null;

        // Auto retry up to 3 times per chunk on network drops
        for (let attempt = 1; attempt <= 3; attempt++) {
            try {
                const fd = new FormData();
                fd.append('upload_id', uploadId);
                fd.append('chunk_index', chunkIndex);
                fd.append('total_chunks', totalChunks);
                fd.append('chunk', chunkBlob, `part_${chunkIndex}`);

                const res = await fetch('/api/upload/chunk', {
                    method: 'POST',
                    credentials: 'include',
                    headers: { 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
                    body: fd,
                    signal
                });

                if (!res.ok) {
                    const errJson = await res.json().catch(() => ({}));
                    throw new Error(errJson.message || `Chunk ${chunkIndex + 1}/${totalChunks} failed (${res.status})`);
                }

                chunkUploaded = true;
                bytesUploaded += chunkSizeBytes;

                const elapsedSec = (Date.now() - startTime) / 1000;
                const speedBps = elapsedSec > 0 ? (bytesUploaded / elapsedSec) : 0;
                const remainingBytes = totalSize - bytesUploaded;
                const etaSec = speedBps > 0 ? (remainingBytes / speedBps) : 0;
                const pct = Math.min(99, Math.round((bytesUploaded / totalSize) * 100));

                if (typeof options.onProgress === 'function') {
                    options.onProgress({
                        percent: pct,
                        loaded: bytesUploaded,
                        total: totalSize,
                        loadedFormatted: formatBytes(bytesUploaded),
                        totalFormatted: formatBytes(totalSize),
                        speedFormatted: formatBytes(speedBps) + '/s',
                        etaFormatted: formatDuration(etaSec),
                        chunkIndex: chunkIndex + 1,
                        totalChunks: totalChunks
                    });
                }
                break;
            } catch (err) {
                lastError = err;
                if (signal.aborted) throw err;
                if (attempt < 3) {
                    await new Promise(r => setTimeout(r, 1000 * attempt));
                }
            }
        }

        if (!chunkUploaded) {
            throw lastError || new Error(`Failed to upload chunk ${chunkIndex + 1}/${totalChunks}`);
        }
    }

    // Assembly notification
    if (typeof options.onProgress === 'function') {
        options.onProgress({
            percent: 99,
            loaded: totalSize,
            total: totalSize,
            loadedFormatted: formatBytes(totalSize),
            totalFormatted: formatBytes(totalSize),
            speedFormatted: 'Assembling...',
            etaFormatted: 'Processing stream on disk...',
            chunkIndex: totalChunks,
            totalChunks: totalChunks,
            status: 'assembling'
        });
    }

    const finishRes = await fetch('/api/upload/finish', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
        body: JSON.stringify({
            upload_id: uploadId,
            filename: filename,
            total_chunks: totalChunks,
            total_size: totalSize
        }),
        signal
    });

    if (!finishRes.ok) {
        const errJson = await finishRes.json().catch(() => ({}));
        throw new Error(errJson.message || `Failed to assemble file (${finishRes.status})`);
    }

    const finishData = await finishRes.json();
    if (typeof options.onProgress === 'function') {
        options.onProgress({
            percent: 100,
            loaded: totalSize,
            total: totalSize,
            loadedFormatted: formatBytes(totalSize),
            totalFormatted: formatBytes(totalSize),
            speedFormatted: 'Complete',
            etaFormatted: '0s',
            chunkIndex: totalChunks,
            totalChunks: totalChunks,
            status: 'done'
        });
    }

    currentUploadAbortController = null;
    activeUploadId = null;
    return finishData;
}

// ── UNIVERSAL UPLOAD HELPER ──────────────────────────────────────
async function uploadFile(fileOrBlob, filename = 'cover_frame.jpg', onProgress = null) {
    if (fileOrBlob instanceof File && fileOrBlob.size > (5 * 1024 * 1024)) {
        // Large file (> 5MB up to 2GB) -> use chunked uploader
        const result = await uploadFileWithChunks(fileOrBlob, {
            customFilename: filename !== 'cover_frame.jpg' ? filename : fileOrBlob.name,
            onProgress: onProgress
        });
        return result.url;
    }

    const fd = new FormData();
    if (fileOrBlob instanceof Blob && !(fileOrBlob instanceof File)) {
        fd.append('file', fileOrBlob, filename);
    } else {
        fd.append('file', fileOrBlob);
    }

    if (typeof onProgress === 'function') {
        onProgress({ percent: 40, loadedFormatted: '', totalFormatted: '', speedFormatted: 'Uploading...', etaFormatted: '' });
    }

    const res = await fetch('/api/upload', {
        method: 'POST',
        credentials: 'include',
        headers: { 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
        body: fd
    });

    if (!res.ok) {
        const errData = await res.json().catch(() => ({}));
        throw new Error(errData.message || 'File upload failed (' + res.status + ')');
    }

    if (typeof onProgress === 'function') {
        onProgress({ percent: 100, loadedFormatted: '', totalFormatted: '', speedFormatted: 'Done', etaFormatted: '0s' });
    }

    const data = await res.json();
    return data.url;
}

function onModalVideoFileSelected(event) {
    const file = event.target.files[0];
    if (file) {
        document.getElementById('v_file_selected_text').innerHTML = `<i class="fas fa-check" style="margin-right:4px;"></i> Selected: ${file.name} (${formatBytes(file.size)})`;
    }
}

function updateModalProgress(p) {
    const bar     = document.getElementById('modalUploadProgressBar');
    const pctText = document.getElementById('modalUploadPercentText');
    const metrics = document.getElementById('modalUploadMetrics');
    const eta     = document.getElementById('modalUploadEta');
    if (bar) bar.style.width = (p.percent || 0) + '%';
    if (pctText) pctText.textContent = (p.percent || 0) + '%';
    if (metrics) metrics.textContent = `${p.loadedFormatted || ''} / ${p.totalFormatted || ''} • ${p.speedFormatted || ''}`;
    if (eta) eta.textContent = p.etaFormatted ? `ETA: ${p.etaFormatted}` : '';
}

// ── SUBMIT TESTIMONIAL (CREATE / UPDATE) ─────────────────────────
async function submitTestimonial(e) {
    e.preventDefault();
    const errEl = document.getElementById('modalError');
    errEl.style.display = 'none';

    const editId      = document.getElementById('t_editing_id').value;
    const clientName  = document.getElementById('t_client_name').value.trim();
    const projectName = document.getElementById('t_project_name').value.trim();
    const clientRole  = document.getElementById('t_client_role').value.trim();
    const feedback    = document.getElementById('t_feedback').value.trim();
    const videoFile   = document.getElementById('t_video_file').files[0];
    const videoUrl    = document.getElementById('t_video_url').value.trim();
    const imageFile   = document.getElementById('t_image_file').files[0];
    const imageUrl    = document.getElementById('t_image_url').value.trim();

    if (!clientName) { errEl.textContent = 'Client name is required.'; errEl.style.display='block'; return; }
    
    const indicator = document.getElementById('uploadingIndicator');
    indicator.style.display = 'block';
    document.getElementById('modalUploadTitle').textContent = videoFile ? 'UPLOADING REVIEW VIDEO (UP TO 2GB)...' : 'SAVING REVIEW...';
    document.getElementById('formTestimonial').style.display = 'none';

    try {
        let finalVideoUrl = videoUrl;
        let finalImageUrl = imageUrl;

        if (videoFile) {
            finalVideoUrl = await uploadFile(videoFile, videoFile.name, updateModalProgress);
        }
        if (imageFile) {
            finalImageUrl = await uploadFile(imageFile);
        } else if (!finalImageUrl && autoExtractedTestimonialBlob) {
            finalImageUrl = await uploadFile(autoExtractedTestimonialBlob, 'review_cover_' + Date.now() + '.jpg');
        } else if (!finalImageUrl && finalVideoUrl && (finalVideoUrl.includes('youtube.com') || finalVideoUrl.includes('youtu.be'))) {
            let ytId = '';
            if (finalVideoUrl.includes('watch?v=')) ytId = finalVideoUrl.split('watch?v=')[1]?.split('&')[0];
            else if (finalVideoUrl.includes('youtu.be/')) ytId = finalVideoUrl.split('youtu.be/')[1]?.split('?')[0];
            if (ytId) finalImageUrl = `https://img.youtube.com/vi/${ytId}/hqdefault.jpg`;
        }

        const businessType = document.getElementById('t_business_type') ? document.getElementById('t_business_type').value : (currentDivision || 'construction');
        const payload = {
            client_name: clientName,
            project_name: projectName || null,
            client_role: clientRole || null,
            feedback: feedback || null,
            video_url: finalVideoUrl || null,
            image_url: finalImageUrl || null,
            business_type: businessType
        };

        const url    = editId ? `/api/testimonials/${editId}` : '/api/testimonials';
        const method = editId ? 'PUT' : 'POST';

        const res = await fetch(url, {
            method: method,
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        });
        if (!res.ok) { const d = await res.json().catch(()=>{}); throw new Error(d?.message || 'Save failed'); }
        closeUploadModal();
        switchAdminTab('reviews');
        location.reload();
    } catch (err) {
        indicator.style.display = 'none';
        document.getElementById('formTestimonial').style.display = 'block';
        errEl.innerHTML = '<i class="fas fa-circle-exclamation" style="margin-right:6px;"></i> ' + err.message;
        errEl.style.display = 'block';
    }
}

// ── SUBMIT PROJECT (CREATE / UPDATE) ─────────────────────────────
async function submitProject(e) {
    e.preventDefault();
    const errEl = document.getElementById('projectModalError');
    errEl.style.display = 'none';

    const editId      = document.getElementById('p_editing_id').value;
    const name        = document.getElementById('p_name').value.trim();
    const category    = document.getElementById('p_category').value;
    const locationVal = document.getElementById('p_location').value.trim();
    const duration    = document.getElementById('p_duration').value.trim();
    const budget      = document.getElementById('p_budget').value.trim();
    const description = document.getElementById('p_description').value.trim();
    const videoFile   = document.getElementById('p_video_file').files[0];
    const videoUrl    = document.getElementById('p_video_url').value.trim();

    if (!name) { errEl.textContent = 'Project name is required.'; errEl.style.display='block'; return; }
    
    const indicator = document.getElementById('uploadingIndicator');
    indicator.style.display = 'block';
    document.getElementById('modalUploadTitle').textContent = videoFile ? 'UPLOADING PROJECT WALKTHROUGH (UP TO 2GB)...' : 'SAVING PROJECT...';
    document.getElementById('formProject').style.display = 'none';

    try {
        let finalVideoUrl = videoUrl;

        if (videoFile) {
            finalVideoUrl = await uploadFile(videoFile, videoFile.name, updateModalProgress);
        }

        // Upload any file or blob items from projectGalleryItems
        const finalImageUrls = [];
        for (let i = 0; i < projectGalleryItems.length; i++) {
            const item = projectGalleryItems[i];
            if (item.type === 'url' && item.url) {
                finalImageUrls.push(item.url);
            } else if (item.type === 'file' && item.file) {
                const uploaded = await uploadFile(item.file, item.file.name);
                if (uploaded) finalImageUrls.push(uploaded);
            } else if (item.type === 'blob' && item.blob) {
                const blobName = (item.name ? item.name.replace(/\s+/g, '_') : 'project_photo_' + Date.now()) + '.jpg';
                const uploaded = await uploadFile(item.blob, blobName);
                if (uploaded) finalImageUrls.push(uploaded);
            }
        }

        // Fallback: If no photos uploaded but we have YouTube video, extract YouTube thumbnail
        if (finalImageUrls.length === 0 && finalVideoUrl && (finalVideoUrl.includes('youtube.com') || finalVideoUrl.includes('youtu.be'))) {
            let ytId = '';
            if (finalVideoUrl.includes('watch?v=')) ytId = finalVideoUrl.split('watch?v=')[1]?.split('&')[0];
            else if (finalVideoUrl.includes('youtu.be/')) ytId = finalVideoUrl.split('youtu.be/')[1]?.split('?')[0];
            if (ytId) finalImageUrls.push(`https://img.youtube.com/vi/${ytId}/hqdefault.jpg`);
        }

        const businessType = document.getElementById('p_business_type') ? document.getElementById('p_business_type').value : (currentDivision || 'construction');
        const payload = {
            name,
            category,
            location: locationVal || null,
            duration: duration || null,
            budget: budget || null,
            description: description || null,
            image_urls: finalImageUrls,
            video_url: finalVideoUrl || null,
            business_type: businessType
        };

        const url    = editId ? `/api/projects/${editId}` : '/api/projects';
        const method = editId ? 'PUT' : 'POST';

        const res = await fetch(url, {
            method: method,
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        });
        if (!res.ok) { const d = await res.json().catch(()=>{}); throw new Error(d?.message || 'Save failed'); }
        closeUploadModal();
        switchAdminTab('projects');
        location.reload();
    } catch (err) {
        indicator.style.display = 'none';
        document.getElementById('formProject').style.display = 'block';
        errEl.innerHTML = '<i class="fas fa-circle-exclamation" style="margin-right:6px;"></i> ' + err.message;
        errEl.style.display = 'block';
    }
}

// ── SUBMIT PACKAGE (CREATE / UPDATE) ─────────────────────────────
async function submitPackage(e) {
    e.preventDefault();
    const errEl = document.getElementById('packageModalError');
    errEl.style.display = 'none';

    const editId        = document.getElementById('pk_editing_id').value;
    const division      = document.getElementById('pk_division').value;
    const tier          = document.getElementById('pk_tier').value.trim();
    const title         = document.getElementById('pk_title').value.trim();
    const price         = document.getElementById('pk_price').value;
    const warranty      = document.getElementById('pk_warranty').value;
    const delivery      = document.getElementById('pk_delivery').value;
    const isHighlighted = document.getElementById('pk_highlighted').checked;
    const subtitle      = document.getElementById('pk_subtitle').value.trim();
    const desc          = document.getElementById('pk_description').value.trim();

    // Parse multiline textareas into arrays (filter empty lines)
    const toArray = (id) => document.getElementById(id).value
        .split('\n')
        .map(s => s.trim())
        .filter(s => s.length > 0);

    const features   = toArray('pk_features');
    const inclusions = toArray('pk_inclusions');
    const exclusions = toArray('pk_exclusions');

    if (!title || !tier) { errEl.textContent = 'Title and tier category are required.'; errEl.style.display='block'; return; }

    try {
        const businessType = document.getElementById('pk_business_type') ? document.getElementById('pk_business_type').value : (currentDivision || 'construction');
        const payload = {
            division,
            tier:            tier.toLowerCase(),
            title,
            price_per_sqft:  (price !== '' && price !== null && !isNaN(parseFloat(price)) && parseFloat(price) > 0) ? parseFloat(price) : null,
            warranty_years:  (warranty !== '' && !isNaN(parseInt(warranty))) ? parseInt(warranty) : 10,
            delivery_months: (delivery !== '' && !isNaN(parseInt(delivery))) ? parseInt(delivery) : 12,
            is_highlighted:  isHighlighted,
            subtitle:        subtitle   || null,
            description:     desc      || null,
            features:        features.length   ? features   : null,
            inclusions:      inclusions.length ? inclusions : null,
            exclusions:      exclusions.length ? exclusions : null,
            business_type:   businessType
        };

        const url    = editId ? `/api/packages/${editId}` : '/api/packages';
        const method = editId ? 'PUT' : 'POST';

        const res = await fetch(url, {
            method: method,
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        });
        if (!res.ok) { const d = await res.json().catch(()=>{}); throw new Error(d?.message || 'Save failed'); }
        closeUploadModal();
        switchAdminTab('packages');
        location.reload();
    } catch (err) {
        errEl.innerHTML = '<i class="fas fa-circle-exclamation" style="margin-right:6px;"></i> ' + err.message;
        errEl.style.display = 'block';
    }
}

// ── SUBMIT SERVICE (CREATE / UPDATE) ─────────────────────────────
function autoGenerateServiceSlug(val) {
    const slugInput = document.getElementById('s_slug');
    if (slugInput && !document.getElementById('s_editing_id').value) {
        slugInput.value = val.toLowerCase()
            .replace(/[^\w\s-]/g, '')
            .replace(/[\s_-]+/g, '-')
            .replace(/^-+|-+$/g, '');
    }
}

async function submitService(e) {
    e.preventDefault();
    const errEl = document.getElementById('serviceModalError');
    errEl.style.display = 'none';

    const editId       = document.getElementById('s_editing_id').value;
    const businessType = document.getElementById('s_business_type') ? document.getElementById('s_business_type').value : (currentDivision || 'construction');
    const name         = document.getElementById('s_name').value.trim();
    const slug         = document.getElementById('s_slug').value.trim();
    const category     = document.getElementById('s_category').value.trim();
    const overview     = document.getElementById('s_overview').value.trim();
    const imageFile    = document.getElementById('s_image_file').files[0];
    const imageUrl     = document.getElementById('s_image_url').value.trim();

    if (!name || !slug) {
        errEl.textContent = 'Service name and slug are required.';
        errEl.style.display = 'block';
        return;
    }

    const indicator = document.getElementById('uploadingIndicator');
    indicator.style.display = 'block';
    document.getElementById('modalUploadTitle').textContent = imageFile ? 'UPLOADING SERVICE IMAGE...' : 'SAVING SERVICE...';
    document.getElementById('formService').style.display = 'none';

    try {
        let finalImageUrl = imageUrl;
        if (imageFile) {
            finalImageUrl = await uploadFile(imageFile);
        }

        const payload = {
            name,
            slug,
            category: category || null,
            overview: overview || null,
            image_url: finalImageUrl || null,
            business_type: businessType
        };

        const url    = editId ? `/api/services/${editId}` : '/api/services';
        const method = editId ? 'PUT' : 'POST';

        const res = await fetch(url, {
            method: method,
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        });
        if (!res.ok) { const d = await res.json().catch(()=>{}); throw new Error(d?.message || 'Save failed'); }
        closeUploadModal();
        switchAdminTab('services');
        location.reload();
    } catch (err) {
        indicator.style.display = 'none';
        document.getElementById('formService').style.display = 'block';
        errEl.innerHTML = '<i class="fas fa-circle-exclamation" style="margin-right:6px;"></i> ' + err.message;
        errEl.style.display = 'block';
    }
}

// ── SUBMIT PARTNER / VENDOR (CREATE / UPDATE) ─────────────────────
function onPartnerLogoUrlChanged(url) {
    const box = document.getElementById('pt_logo_preview_box');
    const img = document.getElementById('pt_logo_preview_img');
    if (url && url.trim()) {
        img.src = url.trim();
        box.style.display = 'flex';
    } else {
        box.style.display = 'none';
    }
}

async function submitPartner(e) {
    e.preventDefault();
    const errEl = document.getElementById('partnerModalError');
    errEl.style.display = 'none';

    const editId     = document.getElementById('pt_editing_id').value;
    const name       = document.getElementById('pt_name').value.trim();
    const division   = document.getElementById('pt_division').value;
    const websiteUrl = document.getElementById('pt_website_url').value.trim();
    const logoUrl    = document.getElementById('pt_logo_url').value.trim();
    const logoFile   = document.getElementById('pt_logo_file').files[0];

    if (!name) { errEl.textContent = 'Partner / Bank name is required.'; errEl.style.display='block'; return; }

    document.getElementById('uploadingIndicator').style.display = 'block';
    document.getElementById('modalUploadTitle').textContent = 'SAVING PARTNER...';
    document.getElementById('formPartner').style.display = 'none';

    try {
        let finalLogoUrl = logoUrl;
        if (logoFile) {
            finalLogoUrl = await uploadFile(logoFile);
        }

        const payload = {
            name,
            division,
            website_url: websiteUrl || null,
            logo_url: finalLogoUrl || null,
            is_active: true
        };

        const url    = editId ? `/api/partners/${editId}` : '/api/partners';
        const method = editId ? 'PUT' : 'POST';

        const res = await fetch(url, {
            method: method,
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF(), 'Accept': 'application/json' },
            body: JSON.stringify(payload)
        });

        if (res.status === 401) {
            document.getElementById('uploadingIndicator').style.display = 'none';
            document.getElementById('formPartner').style.display = 'block';
            errEl.innerHTML = '<i class="fas fa-circle-exclamation" style="margin-right:6px;"></i> Session expired. Please login again to save changes.';
            errEl.style.display = 'block';
            alert('Your admin session has expired. Redirecting to login...');
            window.location.href = '/admin/login';
            return;
        }

        if (!res.ok) { const d = await res.json().catch(()=>{}); throw new Error(d?.message || 'Save failed (' + res.status + ')'); }
        closeUploadModal();
        switchAdminTab('partners');
        location.reload();
    } catch (err) {
        document.getElementById('uploadingIndicator').style.display = 'none';
        document.getElementById('formPartner').style.display = 'block';
        errEl.innerHTML = '<i class="fas fa-circle-exclamation" style="margin-right:6px;"></i> ' + err.message;
        errEl.style.display = 'block';
    }
}

// ── YOUTUBE LIVE SYNC & SETTINGS (CONSTRUCTION & INTERIOR) ───────
let currentYtDivision = '{{ $activeDivision }}';

function switchYtDivision(division) {
    currentYtDivision = division === 'interior' ? 'interior' : 'construction';

    const btnConst = document.getElementById('btnYtDivConst');
    const btnInt   = document.getElementById('btnYtDivInt');
    if (btnConst) btnConst.classList.toggle('active', currentYtDivision === 'construction');
    if (btnInt)   btnInt.classList.toggle('active', currentYtDivision === 'interior');

    const paneConst = document.getElementById('yt-pane-construction');
    const paneInt   = document.getElementById('yt-pane-interior');
    if (paneConst) paneConst.style.display = currentYtDivision === 'construction' ? 'block' : 'none';
    if (paneInt)   paneInt.style.display   = currentYtDivision === 'interior' ? 'block' : 'none';

    // Update global sidebar badge to reflect active division
    const gridCountEl = document.getElementById('ytGridCount_' + currentYtDivision);
    const sidebarCountEl = document.getElementById('sidebarYtCount');
    if (gridCountEl && sidebarCountEl) {
        sidebarCountEl.textContent = gridCountEl.textContent;
    }
}

async function triggerLiveYouTubeSync(division = 'construction') {
    const div = division === 'interior' ? 'interior' : 'construction';
    const btn = document.getElementById('btnSyncYtLive_' + div) || document.getElementById('btnSyncYtLive');
    const originalText = btn ? btn.innerHTML : '';
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = `<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> SYNCING ${div.toUpperCase()} CHANNEL...`;
    }

    try {
        const urlInput = document.getElementById('cfg_yt_channel_url_' + div);
        const res = await fetch('/api/youtube/sync', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                url: urlInput ? urlInput.value.trim() : '',
                division: div
            })
        });
        const json = await res.json();
        if (!res.ok || !json.success) {
            throw new Error(json.message || 'Sync failed');
        }

        const data = json.data;
        if (data) {
            const countEl        = document.getElementById('ytVideoCountDisplay_' + div);
            const lastSyncEl     = document.getElementById('ytLastSyncedDisplay_' + div);
            const nameEl         = document.getElementById('ytChannelNameDisplay_' + div);
            const gridCountEl    = document.getElementById('ytGridCount_' + div);
            const sidebarCountEl = document.getElementById('sidebarYtCount');

            if (countEl) countEl.textContent = data.count + ' Videos';
            if (gridCountEl) gridCountEl.textContent = data.count;
            if (sidebarCountEl && currentDivision === div) sidebarCountEl.textContent = data.count;
            if (nameEl && data.channel_name) nameEl.textContent = data.channel_name;
            if (lastSyncEl) lastSyncEl.textContent = 'Just now';

            renderYouTubeVideoGrid(data.videos || [], div);
        }

        alert(json.message);
    } catch (err) {
        alert('Sync failed: ' + err.message);
    } finally {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }
}

async function saveYouTubeSettings(e, division = 'construction') {
    if (e) e.preventDefault();
    const div = division === 'interior' ? 'interior' : 'construction';
    const alertBox = document.getElementById('ytSettingsAlert_' + div);
    const saveBtn  = document.getElementById('btnSaveYtSettings_' + div);
    const channelUrlInput = document.getElementById('cfg_yt_channel_url_' + div);
    const apiKeyInput     = document.getElementById('cfg_yt_api_key_' + div);

    const channelUrl = channelUrlInput ? channelUrlInput.value.trim() : '';
    const apiKey     = apiKeyInput ? apiKeyInput.value.trim() : '';

    if (alertBox) alertBox.style.display = 'none';
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> SAVING & SYNCING...';
    }

    try {
        const res = await fetch('/api/youtube/settings', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                channel_url: channelUrl,
                api_key: apiKey || null,
                division: div
            })
        });
        const json = await res.json();
        if (!res.ok || !json.success) {
            throw new Error(json.message || 'Save failed');
        }

        if (alertBox) {
            alertBox.style.display = 'block';
            alertBox.style.background = 'rgba(37,211,102,0.15)';
            alertBox.style.border = '1px solid rgba(37,211,102,0.4)';
            alertBox.style.color = '#25D366';
            alertBox.innerHTML = '<i class="fas fa-circle-check" style="margin-right:6px;"></i> ' + json.message;
        }

        if (json.data) {
            const data = json.data;
            const countEl        = document.getElementById('ytVideoCountDisplay_' + div);
            const lastSyncEl     = document.getElementById('ytLastSyncedDisplay_' + div);
            const nameEl         = document.getElementById('ytChannelNameDisplay_' + div);
            const linkEl         = document.getElementById('ytChannelLink_' + div);
            const gridCountEl    = document.getElementById('ytGridCount_' + div);
            const sidebarCountEl = document.getElementById('sidebarYtCount');

            if (countEl) countEl.textContent = data.count + ' Videos';
            if (gridCountEl) gridCountEl.textContent = data.count;
            if (sidebarCountEl && currentDivision === div) sidebarCountEl.textContent = data.count;
            if (nameEl && data.channel_name) nameEl.textContent = data.channel_name;
            if (linkEl && data.channel_url) {
                linkEl.href = data.channel_url;
                linkEl.textContent = data.channel_url;
            }
            if (lastSyncEl) lastSyncEl.textContent = 'Just now';

            renderYouTubeVideoGrid(data.videos || [], div);
        }
    } catch (err) {
        if (alertBox) {
            alertBox.style.display = 'block';
            alertBox.style.background = 'rgba(255,59,48,0.15)';
            alertBox.style.border = '1px solid rgba(255,59,48,0.4)';
            alertBox.style.color = '#FF3B30';
            alertBox.innerHTML = '<i class="fas fa-circle-exclamation" style="margin-right:6px;"></i> ' + err.message;
        }
    } finally {
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = `<i class="fas fa-save" style="margin-right:6px;"></i> SAVE & SYNC ${div.toUpperCase()} CHANNEL`;
        }
    }
}

function renderYouTubeVideoGrid(videos, division = 'construction') {
    const div = division === 'interior' ? 'interior' : 'construction';
    const grid = document.getElementById('ytVideosGrid_' + div) || document.getElementById('ytVideosGrid');
    if (!grid) return;
    if (!videos || videos.length === 0) {
        grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:40px;color:#94A3B8;"><i class="fab fa-youtube" style="font-size:2.5rem;color:#FF0000;margin-bottom:10px;display:block;"></i>No ${div} videos currently displayed. Click "SYNC ${div.toUpperCase()} VIDEOS NOW" to fetch your channel videos.</div>`;
        return;
    }

    grid.innerHTML = videos.map(vid => `
        <div class="project-video-card" id="yt-card-${div}-${vid.youtubeId}">
            <div class="video-thumb-frame">
                <img src="${vid.thumbnail || 'https://img.youtube.com/vi/' + vid.youtubeId + '/hqdefault.jpg'}"
                     alt="${escapeHtml(vid.title)}"
                     onerror="this.src='https://img.youtube.com/vi/${vid.youtubeId}/hqdefault.jpg'">
                <div class="video-play-overlay" onclick="window.playVideoModal('${vid.videoUrl}', '${escapeHtml(vid.title)}')" style="position:absolute;inset:0;background:rgba(0,0,0,0.3);display:flex;align-items:center;justify-content:center;cursor:pointer;">
                    <div class="play-btn-circle">
                        <i class="fas fa-play" style="margin-left:2px;"></i>
                    </div>
                </div>
                <div style="position:absolute;bottom:8px;right:8px;background:rgba(5,11,20,0.85);backdrop-filter:blur(4px);color:#F0EBE0;font-size:0.68rem;font-weight:800;padding:2px 7px;border-radius:4px;border:1px solid rgba(255,255,255,0.15);">
                    <i class="fas fa-play" style="font-size:0.55rem;margin-right:3px;color:#D4AF37;"></i>${vid.duration || 'Video'}
                </div>
            </div>
            <div style="padding:12px 14px;flex:1;display:flex;flex-direction:column;justify-content:space-between;">
                <div>
                    <div style="font-size:0.68rem;color:#D4AF37;font-weight:700;margin-bottom:4px;">
                        ID: ${vid.youtubeId} ${vid.views ? '• ' + vid.views : ''}
                    </div>
                    <h4 style="color:#FFF;font-size:0.88rem;line-height:1.35;margin:0;font-weight:700;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;" title="${escapeHtml(vid.title)}">
                        ${escapeHtml(vid.title)}
                    </h4>
                </div>
                <div style="margin-top:12px;padding-top:10px;border-top:1px solid rgba(212,175,55,0.12);display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:8px;">
                    <div style="display:flex;gap:8px;align-items:center;">
                        <button type="button" class="btn-whatsapp-outline" onclick="window.playVideoModal('${vid.videoUrl}', '${escapeHtml(vid.title)}')" style="padding:6px 12px;font-size:0.75rem;border-color:rgba(212,175,55,0.4);color:#D4AF37;cursor:pointer;border-radius:6px;display:inline-flex;align-items:center;gap:5px;">
                            <i class="fas fa-play" style="font-size:0.7rem;"></i> Preview
                        </button>
                        <button type="button" class="btn-text-danger" onclick="deleteYouTubeVideoItem(event, '${vid.youtubeId}', this, '${div}')" title="Delete video from website">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </div>
                    <a href="${vid.watchUrl || 'https://www.youtube.com/watch?v=' + vid.youtubeId}" target="_blank" style="font-size:0.75rem;color:#FF5555;text-decoration:none;display:inline-flex;align-items:center;gap:5px;">
                        <i class="fab fa-youtube"></i> Watch <i class="fas fa-arrow-up-right-from-square" style="font-size:0.6rem;"></i>
                    </a>
                </div>
            </div>
        </div>
    `).join('');
}

async function deleteYouTubeVideoItem(e, videoId, btn, division = 'construction') {
    if (e) {
        e.preventDefault();
        e.stopPropagation();
    }
    const div = division === 'interior' ? 'interior' : 'construction';
    if (!confirm(`Remove this video from your live ${div} website showcase? You can restore it anytime.`)) {
        return;
    }

    const originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';

    try {
        const res = await fetch(`/api/youtube/videos/${videoId}?division=${div}`, {
            method: 'DELETE',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json'
            }
        });
        const json = await res.json();
        if (!res.ok || !json.success) {
            throw new Error(json.message || 'Failed to remove video');
        }

        // Animate card removal
        const card = btn.closest('.project-video-card') || document.getElementById(`yt-card-${div}-${videoId}`);
        if (card) {
            card.style.transition = 'all 0.35s ease';
            card.style.opacity = '0';
            card.style.transform = 'scale(0.9)';
            setTimeout(() => {
                card.remove();
                const grid = document.getElementById('ytVideosGrid_' + div);
                const remaining = grid ? grid.querySelectorAll('.project-video-card').length : 0;
                const gridCountEl = document.getElementById('ytGridCount_' + div);
                const countDisplayEl = document.getElementById('ytVideoCountDisplay_' + div);
                const sidebarCountEl = document.getElementById('sidebarYtCount');

                if (gridCountEl) gridCountEl.textContent = remaining;
                if (countDisplayEl) countDisplayEl.textContent = remaining + ' Videos';
                if (sidebarCountEl && currentDivision === div) sidebarCountEl.textContent = remaining;

                if (remaining === 0 && grid) {
                    grid.innerHTML = `<div style="grid-column:1/-1;text-align:center;padding:40px;color:#94A3B8;"><i class="fab fa-youtube" style="font-size:2.5rem;color:#FF0000;margin-bottom:10px;display:block;"></i>No ${div} videos currently displayed. All videos have been removed or channel has no public videos.</div>`;
                }
            }, 350);
        }

        // Append to Excluded Videos list
        const excludedPanel = document.getElementById('ytExcludedVideosPanel_' + div);
        const excludedList  = document.getElementById('ytExcludedVideosList_' + div);
        const excludedCountEl = document.getElementById('ytExcludedCount_' + div);
        if (excludedPanel && excludedList) {
            excludedPanel.style.display = 'block';
            if (!document.getElementById(`yt-excluded-${div}-${videoId}`)) {
                const badge = document.createElement('div');
                badge.className = 'yt-excluded-badge';
                badge.id = `yt-excluded-${div}-${videoId}`;
                badge.style.cssText = 'background:#0F172A;border:1px solid rgba(239,68,68,0.3);border-radius:8px;padding:6px 12px;display:inline-flex;align-items:center;gap:8px;font-size:0.75rem;color:#E2E8F0;';
                badge.innerHTML = `
                    <span><i class="fab fa-youtube" style="color:#FF0000;margin-right:4px;"></i>ID: <strong>${videoId}</strong></span>
                    <a href="https://www.youtube.com/watch?v=${videoId}" target="_blank" style="color:#94A3B8;text-decoration:none;" title="View on YouTube"><i class="fas fa-external-link-alt" style="font-size:0.65rem;"></i></a>
                    <button type="button" onclick="restoreYouTubeVideoItem('${videoId}', this, '${div}')" class="btn-gold-pill" style="padding:3px 10px;font-size:0.7rem;line-height:1;margin-left:4px;cursor:pointer;" title="Restore to ${div} Website">
                        <i class="fas fa-undo" style="margin-right:3px;"></i> Restore
                    </button>
                `;
                excludedList.appendChild(badge);
            }
            if (excludedCountEl) {
                excludedCountEl.textContent = excludedList.querySelectorAll('.yt-excluded-badge').length;
            }
        }

        alert(`Video removed from ${div} website showcase!`);
    } catch (err) {
        alert('Error: ' + err.message);
        btn.disabled = false;
        btn.innerHTML = originalHtml;
    }
}

async function restoreYouTubeVideoItem(videoId, btn, division = 'construction') {
    const div = division === 'interior' ? 'interior' : 'construction';
    const originalHtml = btn.innerHTML;
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

    try {
        const res = await fetch(`/api/youtube/videos/${videoId}/restore?division=${div}`, {
            method: 'POST',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json'
            }
        });
        const json = await res.json();
        if (!res.ok || !json.success) {
            throw new Error(json.message || 'Failed to restore video');
        }

        // Remove from excluded badges
        const badge = document.getElementById(`yt-excluded-${div}-${videoId}`);
        if (badge) badge.remove();
        const excludedList = document.getElementById('ytExcludedVideosList_' + div);
        const excludedPanel = document.getElementById('ytExcludedVideosPanel_' + div);
        const count = excludedList ? excludedList.querySelectorAll('.yt-excluded-badge').length : 0;
        const countEl = document.getElementById('ytExcludedCount_' + div);
        if (countEl) countEl.textContent = count;
        if (count === 0 && excludedPanel) excludedPanel.style.display = 'none';

        alert(`Video restored to ${div}! Triggering live sync to refresh grid...`);
        triggerLiveYouTubeSync(div);
    } catch (err) {
        alert('Error: ' + err.message);
        btn.disabled = false;
        btn.innerHTML = originalHtml;
    }
}

function escapeHtml(str) {
    if (!str) return '';
    return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

// ── CONTACT DETAILS & ADDRESS SETTINGS ─────────────────────────────
async function saveContactSettings(e) {
    e.preventDefault();
    const alertBox  = document.getElementById('contactSettingsAlert');
    const saveBtn   = document.getElementById('btnSaveContactSettings');
    const originalBtnHtml = saveBtn ? saveBtn.innerHTML : '';

    const payload = {
        company_phone:           document.getElementById('cfg_company_phone').value.trim(),
        company_phone_secondary: document.getElementById('cfg_company_phone_secondary').value.trim(),
        company_whatsapp:        document.getElementById('cfg_company_whatsapp').value.trim(),
        company_email:           document.getElementById('cfg_company_email').value.trim(),
        company_hours:           document.getElementById('cfg_company_hours').value.trim(),
        company_branches:        document.getElementById('cfg_company_branches').value.trim(),
        company_address:         document.getElementById('cfg_company_address').value.trim(),
    };

    if (alertBox) alertBox.style.display = 'none';
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> SAVING CONTACT DETAILS...';
        saveBtn.style.opacity = '0.75';
    }

    try {
        const res = await fetch('/api/settings/contact', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        const json = await res.json();
        if (!res.ok || !json.success) {
            throw new Error(json.message || 'Failed to save contact details');
        }

        if (alertBox) {
            alertBox.style.display = 'block';
            alertBox.style.background = 'rgba(37,211,102,0.15)';
            alertBox.style.border = '1px solid rgba(37,211,102,0.4)';
            alertBox.style.color = '#25D366';
            alertBox.innerHTML = '<i class="fas fa-circle-check" style="margin-right:6px;"></i> ' + json.message + ' (Reflected on live website)';
        }
    } catch (err) {
        if (alertBox) {
            alertBox.style.display = 'block';
            alertBox.style.background = 'rgba(255,59,48,0.15)';
            alertBox.style.border = '1px solid rgba(255,59,48,0.4)';
            alertBox.style.color = '#FF3B30';
            alertBox.innerHTML = '<i class="fas fa-triangle-exclamation" style="margin-right:6px;"></i> ' + err.message;
        }
    } finally {
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalBtnHtml || '<i class="fas fa-floppy-disk"></i> SAVE CONTACT DETAILS';
            saveBtn.style.opacity = '1';
        }
    }
}

// ── HERO CONTENT SETTINGS ─────────────────────────────────────────
async function saveHeroContent(e) {
    e.preventDefault();
    const alertBox       = document.getElementById('heroContentAlert');
    const saveBtn        = document.getElementById('btnSaveHeroContent');
    const originalBtnHtml = saveBtn ? saveBtn.innerHTML : '';

    const payload = {
        hero_title:       document.getElementById('cfg_hero_title').value.trim(),
        hero_subtitle:    document.getElementById('cfg_hero_subtitle').value.trim(),
        hero_check1:      document.getElementById('cfg_hero_check1').value.trim(),
        hero_check2:      document.getElementById('cfg_hero_check2').value.trim(),
        hero_check3:      document.getElementById('cfg_hero_check3').value.trim(),
        hero_check4:      document.getElementById('cfg_hero_check4').value.trim(),
        hero_check5:      document.getElementById('cfg_hero_check5').value.trim(),
        hero_cta_primary: document.getElementById('cfg_hero_cta_primary').value.trim(),
    };

    if (alertBox) alertBox.style.display = 'none';
    if (saveBtn) {
        saveBtn.disabled = true;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> SAVING HERO CONTENT...';
        saveBtn.style.opacity = '0.75';
    }

    try {
        const res = await fetch('/api/settings/contact', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'X-CSRF-TOKEN': CSRF(),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });
        const json = await res.json();
        if (!res.ok || !json.success) {
            throw new Error(json.message || 'Failed to save hero content');
        }
        if (alertBox) {
            alertBox.style.display = 'block';
            alertBox.style.background = 'rgba(37,211,102,0.15)';
            alertBox.style.border = '1px solid rgba(37,211,102,0.4)';
            alertBox.style.color = '#25D366';
            alertBox.innerHTML = '<i class="fas fa-circle-check" style="margin-right:6px;"></i> Hero content saved! Reflected live on the website.';
        }
    } catch (err) {
        if (alertBox) {
            alertBox.style.display = 'block';
            alertBox.style.background = 'rgba(255,59,48,0.15)';
            alertBox.style.border = '1px solid rgba(255,59,48,0.4)';
            alertBox.style.color = '#FF3B30';
            alertBox.innerHTML = '<i class="fas fa-triangle-exclamation" style="margin-right:6px;"></i> ' + err.message;
        }
    } finally {
        if (saveBtn) {
            saveBtn.disabled = false;
            saveBtn.innerHTML = originalBtnHtml || '<i class="fas fa-floppy-disk"></i> SAVE HERO CONTENT';
            saveBtn.style.opacity = '1';
        }
    }
}

// ── GUIDEBOOK PDF MANAGEMENT ──────────────────────────────────────
async function handleGuidebookUpload(event) {
    const file = event.target.files[0];
    if (!file) return;
    if (!file.name.toLowerCase().endsWith('.pdf') && file.type !== 'application/pdf') {
        alert('Please select a valid PDF file.');
        return;
    }
    const progress = document.getElementById('pdfUploadProgress');
    const bar      = document.getElementById('pdfProgressBar');
    const status   = document.getElementById('pdfUploadStatus');
    progress.style.display = 'block';
    status.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> Uploading PDF...';

    try {
        const pdfUrl = await uploadFile(file, file.name, (p) => {
            if (bar) bar.style.width = (p.percent || 0) + '%';
            if (status) status.textContent = `Uploading PDF (${p.percent || 0}%)...`;
        });
        if (bar) bar.style.width = '95%';
        status.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> Saving settings...';
        const res = await fetch('/api/settings/guidebook', {
            method: 'POST',
            credentials: 'include',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() },
            body: JSON.stringify({ url: pdfUrl })
        });
        if (!res.ok) throw new Error('Failed to save setting (HTTP ' + res.status + ')');
        if (bar) bar.style.width = '100%';
        status.innerHTML = '<i class="fas fa-circle-check" style="margin-right:6px;"></i> Done! Reloading...';
        setTimeout(() => location.reload(), 800);
    } catch (err) {
        progress.style.display = 'none';
        alert('Upload failed: ' + err.message);
    }
}

async function deleteGuidebookPdf(event, btnEl) {
    if (event) { event.stopPropagation(); event.preventDefault(); }
    const confirmed = await showDeleteConfirmModal({
        title: 'RESET GUIDEBOOK PDF?',
        message: 'Delete the custom active Guidebook PDF? The system will revert back to the default bundled baseline PDF.',
        confirmText: 'Yes, Reset PDF'
    });
    if (!confirmed) return;

    const originalHtml = btnEl ? btnEl.innerHTML : '';
    if (btnEl) {
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
        btnEl.style.opacity = '0.7';
    }

    try {
        const res = await fetch('/api/settings/guidebook', {
            method: 'DELETE',
            credentials: 'include',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        switchAdminTab('guidebook');
        alert('Guidebook PDF reset successfully. Page will reload.');
        location.reload();
    } catch (err) {
        alert('Delete failed: ' + err.message);
        if (btnEl) {
            btnEl.disabled = false;
            btnEl.innerHTML = originalHtml;
            btnEl.style.opacity = '1';
        }
    }
}

// ── INTRO VIDEO MANAGEMENT ────────────────────────────────────────
async function handleIntroVideoUpload(event) {
    const file = event.target.files[0];
    if (!file) return;
    const progress = document.getElementById('videoUploadProgress');
    const bar      = document.getElementById('videoProgressBar');
    const status   = document.getElementById('videoUploadStatus');
    const metrics  = document.getElementById('introUploadMetrics');
    const pctText  = document.getElementById('introUploadPercentText');

    progress.style.display = 'block';
    status.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> Uploading video (lossless chunked stream)...';

    try {
        const videoUrl = await uploadFile(file, file.name, (p) => {
            if (bar) bar.style.width = (p.percent || 0) + '%';
            if (pctText) pctText.textContent = (p.percent || 0) + '%';
            if (metrics) metrics.textContent = `${p.loadedFormatted || ''} / ${p.totalFormatted || ''} • ${p.speedFormatted || ''}`;
            if (status) status.innerHTML = p.status === 'assembling' ? '<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> Assembling video stream on disk...' : (p.etaFormatted ? `Uploading... ETA: ${p.etaFormatted}` : 'Uploading...');
        });

        status.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> Saving setting...';
        await saveIntroVideoSetting(videoUrl);
        if (bar) bar.style.width = '100%';
        status.innerHTML = '<i class="fas fa-circle-check" style="margin-right:6px;"></i> Intro video updated successfully!';
        
        // Update display directly in the intro tab without switching to reviews
        const activeDisp = document.getElementById('activeVideoDisplay');
        if (activeDisp) activeDisp.textContent = videoUrl;
        switchAdminTab('intro');

        setTimeout(() => {
            progress.style.display = 'none';
            alert('Hero / Intro Video updated successfully!');
        }, 600);
    } catch (err) {
        progress.style.display = 'none';
        alert('Upload failed: ' + err.message);
    }
}

async function saveIntroVideoUrl() {
    const url = document.getElementById('introVideoUrlInput').value.trim();
    if (!url) { alert('Please enter a video URL.'); return; }
    try {
        await saveIntroVideoSetting(url);
        const activeDisp = document.getElementById('activeVideoDisplay');
        if (activeDisp) activeDisp.textContent = url;
        document.getElementById('introVideoUrlInput').value = '';
        switchAdminTab('intro');
        alert('Intro video URL saved successfully!');
    } catch (err) {
        alert('Save failed: ' + err.message);
    }
}

async function saveIntroVideoSetting(url) {
    const res = await fetch('/api/settings/intro-video', {
        method: 'POST',
        credentials: 'include',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() },
        body: JSON.stringify({ url: url })
    });
    if (!res.ok) throw new Error('Failed to save setting (HTTP ' + res.status + ')');
    return res.json();
}

async function deleteIntroVideo(event, btnEl) {
    if (event) { event.stopPropagation(); event.preventDefault(); }
    const confirmed = await showDeleteConfirmModal({
        title: 'RESET INTRO VIDEO?',
        message: 'Remove the active Hero / Engineer Intro video? The website will revert back to the default intro video asset.',
        confirmText: 'Yes, Reset Video'
    });
    if (!confirmed) return;

    const originalHtml = btnEl ? btnEl.innerHTML : '';
    if (btnEl) {
        btnEl.disabled = true;
        btnEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Deleting...';
        btnEl.style.opacity = '0.7';
    }

    try {
        const res = await fetch('/api/settings/intro-video', {
            method: 'DELETE',
            credentials: 'include',
            headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF() }
        });
        if (!res.ok) throw new Error('HTTP ' + res.status);
        const activeDisp = document.getElementById('activeVideoDisplay');
        if (activeDisp) activeDisp.textContent = 'None (Using Default)';
        switchAdminTab('intro');
        alert('Intro video reset successfully.');
    } catch (err) {
        alert('Delete failed: ' + err.message);
        if (btnEl) {
            btnEl.disabled = false;
            btnEl.innerHTML = originalHtml;
            btnEl.style.opacity = '1';
        }
    }
}

function previewIntroVideo() {
    const url = document.getElementById('activeVideoDisplay').textContent.trim();
    if (url && typeof window.playVideoModal === 'function') {
        window.playVideoModal(url, 'Engineer Intro Video Preview');
    } else {
        window.open(url, '_blank');
    }
}

@if($activeDivision === 'construction')
// ══════════════════════════════════════════════════════════════════════════════
// ── CONSTRUCTION PACKAGES COMPARISON MATRIX EDITOR ───────────────────────────
// ══════════════════════════════════════════════════════════════════════════════
const matrixStore = {
    residential: @json($package_spec_matrix_res),
    commercial:  @json($package_spec_matrix_com)
};
const rawDbPackageTitles = {
    residential: @json(\App\Models\PackageDetail::where('division', 'residential')->pluck('title')),
    commercial:  @json(\App\Models\PackageDetail::where('division', 'commercial')->pluck('title'))
};
const dbPackageTiers = {
    residential: (rawDbPackageTitles.residential || []).map(t => t.replace(/\bplan\b|\bpackage\b/ig, '').trim().toUpperCase()).filter(Boolean),
    commercial:  (rawDbPackageTitles.commercial || []).map(t => t.replace(/\bplan\b|\bpackage\b/ig, '').trim().toUpperCase()).filter(Boolean)
};
let activeMatrixDivision = 'residential';

function switchMatrixDivision(division) {
    syncMatrixInputsToStore();
    activeMatrixDivision = division;

    const resBtn = document.getElementById('btnMatDivRes');
    const comBtn = document.getElementById('btnMatDivCom');
    if (division === 'residential') {
        resBtn.className = 'btn-gold-pill';
        resBtn.style.color = '#000';
        comBtn.className = 'btn-whatsapp-outline';
        comBtn.style.color = '#D4AF37';
        comBtn.style.borderColor = 'rgba(212,175,55,0.4)';
    } else {
        comBtn.className = 'btn-gold-pill';
        comBtn.style.color = '#000';
        resBtn.className = 'btn-whatsapp-outline';
        resBtn.style.color = '#D4AF37';
        resBtn.style.borderColor = 'rgba(212,175,55,0.4)';
    }

    renderMatrixEditorTable();
    hideMatrixAlert();
}

function syncMatrixInputsToStore() {
    const table = document.getElementById('matrixEditorTable');
    if (!table) return;

    const current = matrixStore[activeMatrixDivision];
    if (!current) return;

    // Sync header inputs
    const headerInputs = table.querySelectorAll('thead th input.matrix-col-input');
    headerInputs.forEach((inp, idx) => {
        if (inp && idx < current.headers.length) {
            const val = inp.value.trim();
            if (val) current.headers[idx] = val.toUpperCase();
        }
    });

    // Sync row inputs
    const rowEls = table.querySelectorAll('tbody tr.matrix-row-item');
    rowEls.forEach((tr, rIdx) => {
        if (rIdx < current.rows.length) {
            const featureInp = tr.querySelector('input.matrix-feature-input');
            if (featureInp) {
                current.rows[rIdx].feature = featureInp.value.trim() || current.rows[rIdx].feature;
            }
            const valInps = tr.querySelectorAll('input.matrix-val-input');
            valInps.forEach((vInp, cIdx) => {
                if (cIdx < current.headers.length) {
                    current.rows[rIdx].values[cIdx] = vInp.value;
                }
            });
        }
    });
}

function renderMatrixEditorTable() {
    const table = document.getElementById('matrixEditorTable');
    if (!table) return;

    const data = matrixStore[activeMatrixDivision];
    if (!data || !data.headers || !data.rows) return;

    let theadHtml = `<thead>
        <tr style="background:#0F172A;border-bottom:2px solid rgba(212,175,55,0.35);">
            <th style="padding:12px 14px;text-align:left;color:#D4AF37;font-weight:700;font-size:0.75rem;letter-spacing:0.05em;width:240px;">
                SPECIFICATION / MATERIAL
            </th>`;

    data.headers.forEach((headerName, idx) => {
        theadHtml += `
            <th style="padding:10px 12px;text-align:left;color:#D4AF37;font-weight:700;font-size:0.75rem;">
                <div style="display:flex;align-items:center;gap:6px;">
                    <input type="text" class="input-dark matrix-col-input" value="${escapeMatrixHtml(headerName)}"
                           style="padding:5px 8px;font-size:0.75rem;font-weight:700;color:#D4AF37;width:100%;border-color:rgba(212,175,55,0.3);text-transform:uppercase;"
                           onchange="onMatrixColNameChange(${idx}, this.value)" title="Click to rename tier column">
                    ${data.headers.length > 1 ? `
                    <button type="button" class="action-del-btn" onclick="deleteMatrixColumn(${idx})" title="Delete tier column" style="width:26px;height:26px;font-size:0.7rem;">
                        <i class="fas fa-times"></i>
                    </button>` : ''}
                </div>
            </th>`;
    });

    theadHtml += `
            <th style="padding:12px 14px;text-align:center;color:#94A3B8;font-weight:700;font-size:0.72rem;width:90px;">
                ACTIONS
            </th>
        </tr>
    </thead>`;

    let tbodyHtml = `<tbody>`;
    data.rows.forEach((row, rIdx) => {
        tbodyHtml += `
        <tr class="matrix-row-item" style="border-bottom:1px solid rgba(212,175,55,0.15);background:${rIdx % 2 === 0 ? 'rgba(15,23,42,0.4)' : 'rgba(5,11,20,0.3)'};">
            <td style="padding:8px 10px;vertical-align:middle;">
                <input type="text" class="input-dark matrix-feature-input" value="${escapeMatrixHtml(row.feature)}"
                       placeholder="Specification label..."
                       style="padding:6px 10px;font-size:0.8rem;font-weight:700;color:#fff;width:100%;border-color:rgba(212,175,55,0.25);"
                       onchange="onMatrixFeatureChange(${rIdx}, this.value)">
            </td>`;

        data.headers.forEach((_, cIdx) => {
            const cellVal = row.values && row.values[cIdx] !== undefined ? row.values[cIdx] : '';
            tbodyHtml += `
            <td style="padding:8px 10px;vertical-align:middle;">
                <input type="text" class="input-dark matrix-val-input" value="${escapeMatrixHtml(cellVal)}"
                       placeholder="Enter spec..."
                       style="padding:6px 10px;font-size:0.8rem;color:#E2E8F0;width:100%;border-color:rgba(255,255,255,0.1);"
                       onchange="onMatrixCellChange(${rIdx}, ${cIdx}, this.value)">
            </td>`;
        });

        tbodyHtml += `
            <td style="padding:8px 10px;text-align:center;vertical-align:middle;white-space:nowrap;">
                <div style="display:inline-flex;gap:4px;">
                    <button type="button" class="action-edit-btn" onclick="moveMatrixRow(${rIdx}, -1)" title="Move Up" ${rIdx === 0 ? 'disabled style="opacity:0.3;cursor:not-allowed;width:26px;height:26px;"' : 'style="width:26px;height:26px;padding:0;"'}>
                        <i class="fas fa-chevron-up" style="font-size:0.7rem;"></i>
                    </button>
                    <button type="button" class="action-edit-btn" onclick="moveMatrixRow(${rIdx}, 1)" title="Move Down" ${rIdx === data.rows.length - 1 ? 'disabled style="opacity:0.3;cursor:not-allowed;width:26px;height:26px;"' : 'style="width:26px;height:26px;padding:0;"'}>
                        <i class="fas fa-chevron-down" style="font-size:0.7rem;"></i>
                    </button>
                    <button type="button" class="action-del-btn" onclick="deleteMatrixRow(${rIdx})" title="Delete row" style="width:26px;height:26px;">
                        <i class="fas fa-trash" style="font-size:0.7rem;"></i>
                    </button>
                </div>
            </td>
        </tr>`;
    });

    tbodyHtml += `</tbody>`;

    table.innerHTML = theadHtml + tbodyHtml;
}

function escapeMatrixHtml(str) {
    if (str === null || str === undefined) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

function onMatrixColNameChange(colIdx, newName) {
    const val = newName.trim();
    if (val) {
        matrixStore[activeMatrixDivision].headers[colIdx] = val.toUpperCase();
    }
}

function onMatrixFeatureChange(rowIdx, newFeature) {
    const val = newFeature.trim();
    if (val) {
        matrixStore[activeMatrixDivision].rows[rowIdx].feature = val;
    }
}

function onMatrixCellChange(rowIdx, colIdx, newVal) {
    if (matrixStore[activeMatrixDivision].rows[rowIdx]) {
        matrixStore[activeMatrixDivision].rows[rowIdx].values[colIdx] = newVal;
    }
}

function addMatrixRow() {
    syncMatrixInputsToStore();
    const data = matrixStore[activeMatrixDivision];
    const emptyVals = new Array(data.headers.length).fill('');
    data.rows.push({
        feature: 'NEW SPECIFICATION',
        values: emptyVals
    });
    renderMatrixEditorTable();
    showMatrixAlert('Added a new row. Remember to click "SAVE MATRIX" when done.', 'info');
}

function deleteMatrixRow(index) {
    syncMatrixInputsToStore();
    const data = matrixStore[activeMatrixDivision];
    if (data.rows.length <= 1) {
        alert('At least one specification row must remain.');
        return;
    }
    const item = data.rows[index];
    if (confirm(`Delete specification "${item.feature}"?`)) {
        data.rows.splice(index, 1);
        renderMatrixEditorTable();
        showMatrixAlert(`Row "${item.feature}" removed. Click "SAVE MATRIX" to apply.`, 'info');
    }
}

function moveMatrixRow(index, direction) {
    syncMatrixInputsToStore();
    const rows = matrixStore[activeMatrixDivision].rows;
    const target = index + direction;
    if (target < 0 || target >= rows.length) return;
    const temp = rows[index];
    rows[index] = rows[target];
    rows[target] = temp;
    renderMatrixEditorTable();
}

function addMatrixColumn() {
    syncMatrixInputsToStore();
    const colName = prompt('Enter new tier / package column name:', 'NEW TIER');
    if (!colName || !colName.trim()) return;

    const formatted = colName.trim().toUpperCase();
    const data = matrixStore[activeMatrixDivision];
    data.headers.push(formatted);
    data.rows.forEach(r => {
        if (!Array.isArray(r.values)) r.values = [];
        r.values.push('');
    });

    renderMatrixEditorTable();
    showMatrixAlert(`Column "${formatted}" added. Click "SAVE MATRIX" to apply.`, 'info');
}

function deleteMatrixColumn(colIdx) {
    syncMatrixInputsToStore();
    const data = matrixStore[activeMatrixDivision];
    if (data.headers.length <= 1) {
        alert('At least one column is required.');
        return;
    }
    const colName = data.headers[colIdx];
    if (confirm(`Are you sure you want to delete column "${colName}" and all its values?`)) {
        data.headers.splice(colIdx, 1);
        data.rows.forEach(r => {
            if (Array.isArray(r.values) && r.values.length > colIdx) {
                r.values.splice(colIdx, 1);
            }
        });
        renderMatrixEditorTable();
        showMatrixAlert(`Column "${colName}" removed. Click "SAVE MATRIX" to apply.`, 'info');
    }
}

function syncMatrixColumnsFromPackages() {
    syncMatrixInputsToStore();
    const tiers = dbPackageTiers[activeMatrixDivision] || [];
    if (!tiers.length) {
        alert('No active packages found in database for ' + activeMatrixDivision);
        return;
    }

    if (confirm(`Sync columns with active packages (${tiers.join(', ')})? Existing cell values will align to the new column order.`)) {
        const data = matrixStore[activeMatrixDivision];
        data.headers = tiers.map(t => t.toUpperCase());
        data.rows.forEach(r => {
            while (r.values.length < data.headers.length) {
                r.values.push('');
            }
            if (r.values.length > data.headers.length) {
                r.values = r.values.slice(0, data.headers.length);
            }
        });
        renderMatrixEditorTable();
        showMatrixAlert(`Columns synchronized with active ${activeMatrixDivision} packages. Click "SAVE MATRIX" to commit.`, 'info');
    }
}

async function resetMatrixToDefaults() {
    if (!confirm(`Reset ${activeMatrixDivision.toUpperCase()} matrix back to standard default specifications? Any unsaved custom rows will be overwritten.`)) {
        return;
    }

    try {
        const res = await fetch(`/api/matrix/${activeMatrixDivision}`);
        const json = await res.json();
        if (json && json.matrix) {
            matrixStore[activeMatrixDivision] = json.matrix;
            renderMatrixEditorTable();
            showMatrixAlert('Reset to standard specifications. Click "SAVE MATRIX" if you want to commit this to live site.', 'info');
        }
    } catch (e) {
        alert('Failed to load defaults: ' + e.message);
    }
}

async function saveActiveMatrix() {
    syncMatrixInputsToStore();
    const data = matrixStore[activeMatrixDivision];
    hideMatrixAlert();

    const saveButtons = document.querySelectorAll('button[onclick="saveActiveMatrix()"]');
    saveButtons.forEach(btn => {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin" style="margin-right:6px;"></i> SAVING...';
    });

    try {
        const res = await fetch('/api/settings/matrix', {
            method: 'POST',
            credentials: 'include',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': CSRF()
            },
            body: JSON.stringify({
                division: activeMatrixDivision,
                matrix: data
            })
        });

        const json = await res.json();
        if (!res.ok || !json.success) {
            throw new Error(json?.message || 'Save failed');
        }

        showMatrixAlert(`${activeMatrixDivision.toUpperCase()} Comparison Matrix saved successfully! Live website now shows your updated data.`, 'success');
    } catch (err) {
        showMatrixAlert('Error saving matrix: ' + err.message, 'error');
    } finally {
        saveButtons.forEach(btn => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-floppy-disk" style="margin-right:6px;"></i> SAVE MATRIX';
        });
    }
}

function showMatrixAlert(msg, type) {
    const box = document.getElementById('matrixAlertBox');
    if (!box) return;
    box.style.display = 'block';
    if (type === 'success') {
        box.style.background = '#ECFDF5';
        box.style.color = '#065F46';
        box.style.border = '1px solid #A7F3D0';
        box.innerHTML = '<i class="fas fa-circle-check" style="margin-right:6px;"></i> ' + msg;
    } else if (type === 'error') {
        box.style.background = '#FEF2F2';
        box.style.color = '#991B1B';
        box.style.border = '1px solid #FECACA';
        box.innerHTML = '<i class="fas fa-circle-exclamation" style="margin-right:6px;"></i> ' + msg;
    } else {
        box.style.background = '#F8FAFC';
        box.style.color = '#334155';
        box.style.border = '1px solid #E2E8F0';
        box.textContent = msg;
    }
}

function hideMatrixAlert() {
    const box = document.getElementById('matrixAlertBox');
    if (box) box.style.display = 'none';
}

// Initial render of matrix editor when page loads
document.addEventListener('DOMContentLoaded', function() {
    renderMatrixEditorTable();
});
@endif

// ── LEADS TABLE DRAG & SCROLL CONTROL ─────────────────────────
function scrollQuotesTable(offset) {
    const wrap = document.getElementById('quotesTableWrapper');
    if (!wrap) return;
    wrap.scrollBy({ left: offset, behavior: 'smooth' });
}

document.addEventListener('DOMContentLoaded', function() {
    const wrap = document.getElementById('quotesTableWrapper');
    const slider = document.getElementById('quotesTableDragSlider');
    if (!wrap) return;

    // Sync scroll to slider
    wrap.addEventListener('scroll', function() {
        if (!slider) return;
        const maxScroll = wrap.scrollWidth - wrap.clientWidth;
        if (maxScroll > 0) {
            slider.value = Math.round((wrap.scrollLeft / maxScroll) * 100);
        }
    }, { passive: true });

    // Sync slider to scroll
    if (slider) {
        slider.addEventListener('input', function() {
            const maxScroll = wrap.scrollWidth - wrap.clientWidth;
            wrap.scrollLeft = (slider.value / 100) * maxScroll;
        });
    }

    // Direct Mouse Click-and-Drag Scrolling on table
    let isDown = false;
    let startX = 0;
    let scrollLeft = 0;
    let hasDragged = false;

    wrap.addEventListener('mousedown', function(e) {
        if (e.button !== 0 || e.target.closest('a, button, input, select')) return;
        isDown = true;
        hasDragged = false;
        startX = e.pageX - wrap.offsetLeft;
        scrollLeft = wrap.scrollLeft;
        wrap.classList.add('is-dragging');
    });

    const endDrag = function() {
        if (!isDown) return;
        isDown = false;
        wrap.classList.remove('is-dragging');
    };

    wrap.addEventListener('mouseleave', endDrag);
    wrap.addEventListener('mouseup', endDrag);

    wrap.addEventListener('mousemove', function(e) {
        if (!isDown) return;
        e.preventDefault();
        const x = e.pageX - wrap.offsetLeft;
        const walk = (x - startX) * 1.6;
        if (Math.abs(walk) > 4) {
            hasDragged = true;
        }
        wrap.scrollLeft = scrollLeft - walk;
    });

    wrap.addEventListener('click', function(e) {
        if (hasDragged && !e.target.closest('a, button')) {
            e.stopPropagation();
            e.preventDefault();
            hasDragged = false;
        }
    }, true);
});
</script>

</body>
</html>
