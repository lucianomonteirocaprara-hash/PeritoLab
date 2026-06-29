<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PeritoLab — <?= htmlspecialchars($pageTitle ?? 'Dashboard', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --bg-base:       #0B1220;
            --bg-surface:    #111827;
            --bg-elevated:   #1F2937;
            --accent-cyan:   #00E5FF;
            --accent-green:  #10B981;
            --accent-red:    #EF4444;
            --accent-yellow: #F59E0B;
            --text-primary:  #F9FAFB;
            --text-muted:    #6B7280;
            --text-dim:      #374151;
            --border:        #1F2937;
            --border-bright: #374151;
            --sidebar-w:     260px;
            --font-mono:     'JetBrains Mono', monospace;
            --font-sans:     'Inter', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            background: var(--bg-base);
            color: var(--text-primary);
            font-family: var(--font-sans);
            font-size: 14px;
            line-height: 1.6;
        }

        /* ── Scrollbar ── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg-base); }
        ::-webkit-scrollbar-thumb { background: var(--bg-elevated); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--border-bright); }

        /* ── Layout ── */
        .app-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            min-height: 100vh;
            background: var(--bg-surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            transition: transform .25s ease;
        }

        .sidebar-logo {
            padding: 1.5rem 1.25rem 1rem;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo .brand-name {
            font-family: var(--font-mono);
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--accent-cyan);
            letter-spacing: .04em;
            text-decoration: none;
        }

        .sidebar-logo .brand-sub {
            font-size: .65rem;
            color: var(--text-muted);
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-top: .15rem;
        }

        .status-dot {
            width: 7px; height: 7px;
            background: var(--accent-green);
            border-radius: 50%;
            display: inline-block;
            margin-right: .4rem;
            animation: pulse-dot 2.5s infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: .35; }
        }

        .sidebar-section {
            padding: 1.25rem 1rem .5rem;
        }

        .sidebar-label {
            font-size: .6rem;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 0 .25rem;
            margin-bottom: .5rem;
        }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .55rem .75rem;
            border-radius: 6px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: .8rem;
            font-weight: 500;
            transition: all .18s ease;
            margin-bottom: .15rem;
            position: relative;
        }

        .nav-item-link i {
            font-size: .95rem;
            width: 16px;
            text-align: center;
            flex-shrink: 0;
        }

        .nav-item-link:hover {
            background: var(--bg-elevated);
            color: var(--text-primary);
        }

        .nav-item-link.active {
            background: rgba(0, 229, 255, .08);
            color: var(--accent-cyan);
            border: 1px solid rgba(0, 229, 255, .15);
        }

        .nav-item-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 20%; bottom: 20%;
            width: 3px;
            background: var(--accent-cyan);
            border-radius: 0 3px 3px 0;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 1rem 1.25rem;
            border-top: 1px solid var(--border);
        }

        .system-info {
            font-family: var(--font-mono);
            font-size: .6rem;
            color: var(--text-muted);
            line-height: 1.8;
        }

        .sys-val { color: var(--accent-green); }

        /* ── Main content ── */
        .main-content {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            height: 56px;
            background: var(--bg-surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 1.75rem;
            gap: 1rem;
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .topbar-breadcrumb {
            font-size: .7rem;
            color: var(--text-muted);
            font-family: var(--font-mono);
        }

        .topbar-breadcrumb .sep { margin: 0 .4rem; }
        .topbar-breadcrumb .current { color: var(--accent-cyan); }

        .topbar-right {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .clock {
            font-family: var(--font-mono);
            font-size: .7rem;
            color: var(--text-muted);
        }

        .badge-version {
            background: rgba(0, 229, 255, .08);
            border: 1px solid rgba(0, 229, 255, .2);
            color: var(--accent-cyan);
            font-family: var(--font-mono);
            font-size: .6rem;
            padding: .2rem .55rem;
            border-radius: 4px;
            letter-spacing: .04em;
        }

        .page-body {
            padding: 2rem 1.75rem;
            flex: 1;
        }

        /* ── Page header ── */
        .page-header {
            margin-bottom: 1.75rem;
        }

        .page-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 .25rem;
        }

        .page-subtitle {
            font-size: .75rem;
            color: var(--text-muted);
        }

        /* ── Cards ── */
        .card-dark {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
        }

        .card-dark-header {
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: .65rem;
        }

        .card-dark-header .header-icon {
            width: 32px; height: 32px;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: .9rem;
        }

        .card-dark-header .header-title {
            font-size: .85rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .card-dark-header .header-sub {
            font-size: .65rem;
            color: var(--text-muted);
        }

        .card-dark-body {
            padding: 1.25rem;
        }

        /* ── Tool cards (home) ── */
        .tool-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 1.5rem;
            text-decoration: none;
            color: inherit;
            transition: all .22s ease;
            display: block;
            position: relative;
            overflow: hidden;
        }

        .tool-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(0,229,255,.04) 0%, transparent 60%);
            opacity: 0;
            transition: opacity .22s;
        }

        .tool-card:hover {
            border-color: rgba(0, 229, 255, .3);
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .4);
            color: inherit;
        }

        .tool-card:hover::after { opacity: 1; }

        .tool-card-icon {
            width: 48px; height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .tool-card-title {
            font-size: .9rem;
            font-weight: 600;
            margin-bottom: .4rem;
            color: var(--text-primary);
        }

        .tool-card-desc {
            font-size: .72rem;
            color: var(--text-muted);
            line-height: 1.5;
            margin: 0;
        }

        .tool-card-arrow {
            position: absolute;
            top: 1.25rem; right: 1.25rem;
            color: var(--text-dim);
            font-size: .85rem;
            transition: transform .18s, color .18s;
        }

        .tool-card:hover .tool-card-arrow {
            color: var(--accent-cyan);
            transform: translate(2px, -2px);
        }

        /* ── Forms ── */
        .form-label-custom {
            font-size: .72rem;
            font-weight: 600;
            color: var(--text-muted);
            letter-spacing: .05em;
            text-transform: uppercase;
            margin-bottom: .45rem;
        }

        .form-control-dark {
            background: var(--bg-base) !important;
            border: 1px solid var(--border-bright) !important;
            color: var(--text-primary) !important;
            border-radius: 7px;
            font-size: .82rem;
            padding: .6rem .85rem;
            transition: border-color .18s, box-shadow .18s;
        }

        .form-control-dark:focus {
            border-color: var(--accent-cyan) !important;
            box-shadow: 0 0 0 3px rgba(0, 229, 255, .12) !important;
            outline: none;
        }

        .form-control-dark::placeholder { color: var(--text-muted); opacity: .6; }

        .upload-zone {
            border: 2px dashed var(--border-bright);
            border-radius: 10px;
            padding: 2.5rem 1.5rem;
            text-align: center;
            background: var(--bg-base);
            cursor: pointer;
            transition: all .2s ease;
            position: relative;
        }

        .upload-zone:hover,
        .upload-zone.drag-over {
            border-color: var(--accent-cyan);
            background: rgba(0, 229, 255, .03);
        }

        .upload-zone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .upload-icon {
            font-size: 2rem;
            color: var(--text-muted);
            margin-bottom: .75rem;
            display: block;
        }

        .upload-text {
            font-size: .8rem;
            color: var(--text-muted);
        }

        .upload-text strong {
            color: var(--accent-cyan);
        }

        /* ── Buttons ── */
        .btn-lab {
            background: linear-gradient(135deg, #00c4db, #00E5FF);
            border: none;
            color: #0B1220;
            font-weight: 700;
            font-size: .8rem;
            padding: .65rem 1.5rem;
            border-radius: 7px;
            letter-spacing: .04em;
            transition: all .18s ease;
            cursor: pointer;
        }

        .btn-lab:hover {
            background: linear-gradient(135deg, #00E5FF, #33eaff);
            box-shadow: 0 4px 16px rgba(0, 229, 255, .25);
            transform: translateY(-1px);
        }

        .btn-lab-outline {
            background: transparent;
            border: 1px solid var(--accent-cyan);
            color: var(--accent-cyan);
            font-weight: 600;
            font-size: .8rem;
            padding: .65rem 1.5rem;
            border-radius: 7px;
            transition: all .18s ease;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .btn-lab-outline:hover {
            background: rgba(0, 229, 255, .08);
            color: var(--accent-cyan);
        }

        /* ── Result panels ── */
        .result-panel {
            background: var(--bg-base);
            border: 1px solid var(--border-bright);
            border-radius: 8px;
            padding: 1.25rem;
        }

        .result-identical {
            border-color: var(--accent-green);
            background: rgba(16, 185, 129, .05);
        }

        .result-different {
            border-color: var(--accent-red);
            background: rgba(239, 68, 68, .05);
        }

        .hash-value {
            font-family: var(--font-mono);
            font-size: .72rem;
            color: var(--accent-cyan);
            word-break: break-all;
            background: var(--bg-base);
            border: 1px solid var(--border);
            border-radius: 5px;
            padding: .5rem .75rem;
            margin-top: .3rem;
        }

        .hash-label {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .1em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .badge-algo {
            font-family: var(--font-mono);
            font-size: .6rem;
            padding: .2rem .5rem;
            border-radius: 4px;
            font-weight: 600;
            letter-spacing: .04em;
        }

        .badge-algo.md5    { background: rgba(245,158,11,.12); color: var(--accent-yellow); border: 1px solid rgba(245,158,11,.2); }
        .badge-algo.sha1   { background: rgba(139,92,246,.12); color: #A78BFA; border: 1px solid rgba(139,92,246,.2); }
        .badge-algo.sha256 { background: rgba(0,229,255,.1); color: var(--accent-cyan); border: 1px solid rgba(0,229,255,.2); }
        .badge-algo.sha512 { background: rgba(16,185,129,.1); color: var(--accent-green); border: 1px solid rgba(16,185,129,.2); }

        /* ── Alert ── */
        .alert-lab {
            border-radius: 8px;
            padding: .85rem 1rem;
            font-size: .8rem;
            border-left: 3px solid;
        }

        .alert-lab.danger {
            background: rgba(239,68,68,.08);
            border-color: var(--accent-red);
            color: #FCA5A5;
        }

        .alert-lab.success {
            background: rgba(16,185,129,.08);
            border-color: var(--accent-green);
            color: #6EE7B7;
        }

        /* ── Stats row ── */
        .stat-box {
            background: var(--bg-base);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 1rem;
            text-align: center;
        }

        .stat-box .stat-val {
            font-family: var(--font-mono);
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--accent-cyan);
            line-height: 1;
        }

        .stat-box .stat-lbl {
            font-size: .65rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            margin-top: .3rem;
        }

        /* ── Metadata table ── */
        .meta-table { width: 100%; }

        .meta-table tr + tr td { border-top: 1px solid var(--border); }

        .meta-table td {
            padding: .6rem .75rem;
            font-size: .78rem;
            vertical-align: top;
        }

        .meta-table .meta-key {
            font-family: var(--font-mono);
            color: var(--text-muted);
            width: 40%;
            white-space: nowrap;
        }

        .meta-table .meta-val {
            color: var(--text-primary);
            word-break: break-word;
        }

        /* ── Copy button ── */
        .btn-copy {
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: .15rem .35rem;
            font-size: .75rem;
            border-radius: 4px;
            transition: color .15s;
        }

        .btn-copy:hover { color: var(--accent-cyan); }

        /* ── GPS badge ── */
        .gps-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: rgba(16,185,129,.1);
            border: 1px solid rgba(16,185,129,.25);
            color: var(--accent-green);
            font-family: var(--font-mono);
            font-size: .7rem;
            padding: .35rem .75rem;
            border-radius: 20px;
        }

        /* ── Print / PDF styles for custody doc ── */
        .custody-doc {
            background: #fff;
            color: #1a1a2e;
            padding: 2.5rem;
            border-radius: 8px;
            font-family: 'Inter', sans-serif;
        }

        @media print {
            .sidebar, .topbar, .page-header, .no-print { display: none !important; }
            .main-content { margin-left: 0 !important; }
            .page-body { padding: 0 !important; }
            .custody-doc {
                padding: 0;
                border-radius: 0;
                border: none;
                box-shadow: none;
            }
        }

        /* ── Responsive ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
        }

        /* ── Scan line effect ── */
        .scan-overlay {
            position: fixed;
            inset: 0;
            pointer-events: none;
            background: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(0,0,0,.03) 2px,
                rgba(0,0,0,.03) 4px
            );
            z-index: 9999;
        }
    </style>
</head>
<body>
<div class="scan-overlay"></div>

<div class="app-wrapper">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-logo">
            <a href="/" class="brand-name d-block text-decoration-none">
                <i class="bi bi-shield-lock-fill me-2"></i>PeritoLab
            </a>
            <div class="brand-sub">
                <span class="status-dot"></span>Sistema Operacional
            </div>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Navegação</div>
            <a href="/" class="nav-item-link <?= ($activeMenu ?? '') === 'dashboard' ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2"></i>
                <span>Dashboard</span>
            </a>
        </div>

        <div class="sidebar-section">
            <div class="sidebar-label">Ferramentas</div>
            <a href="/hash" class="nav-item-link <?= ($activeMenu ?? '') === 'hash' ? 'active' : '' ?>">
                <i class="bi bi-hash"></i>
                <span>Hash Generator</span>
            </a>
            <a href="/integrity" class="nav-item-link <?= ($activeMenu ?? '') === 'integrity' ? 'active' : '' ?>">
                <i class="bi bi-shield-check"></i>
                <span>Verificador de Integridade</span>
            </a>
            <a href="/custody" class="nav-item-link <?= ($activeMenu ?? '') === 'custody' ? 'active' : '' ?>">
                <i class="bi bi-file-earmark-text"></i>
                <span>Cadeia de Custódia</span>
            </a>
            <a href="/metadata" class="nav-item-link <?= ($activeMenu ?? '') === 'metadata' ? 'active' : '' ?>">
                <i class="bi bi-search"></i>
                <span>Metadata Inspector</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <div class="system-info">
                <div>PHP <span class="sys-val"><?= PHP_MAJOR_VERSION . '.' . PHP_MINOR_VERSION ?></span></div>
                <div>HOST <span class="sys-val">peritolab.local</span></div>
                <div>BUILD <span class="sys-val">v1.0.0</span></div>
                <div><?= date('d/m/Y') ?></div>
            </div>
        </div>
    </aside>

    <!-- Main -->
    <div class="main-content">

        <!-- Topbar -->
        <header class="topbar">
            <button class="btn-copy d-md-none me-1" onclick="document.getElementById('sidebar').classList.toggle('open')">
                <i class="bi bi-list" style="font-size:1.1rem"></i>
            </button>
            <div class="topbar-breadcrumb">
                <span>peritolab</span>
                <span class="sep">/</span>
                <span class="current"><?= htmlspecialchars($pageTitle ?? 'dashboard', ENT_QUOTES, 'UTF-8') ?></span>
            </div>
            <div class="topbar-right">
                <div class="clock" id="clock"></div>
                <span class="badge-version">v1.0.0</span>
            </div>
        </header>

        <!-- Content -->
        <main class="page-body">
            <?= $content ?>
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Live clock
    function tick() {
        const now = new Date();
        document.getElementById('clock').textContent =
            now.toLocaleTimeString('pt-BR', { hour12: false });
    }
    tick();
    setInterval(tick, 1000);

    // Drag-over effect for upload zones
    document.querySelectorAll('.upload-zone').forEach(zone => {
        const input = zone.querySelector('input[type="file"]');
        ['dragenter','dragover'].forEach(ev => zone.addEventListener(ev, e => {
            e.preventDefault();
            zone.classList.add('drag-over');
        }));
        ['dragleave','drop'].forEach(ev => zone.addEventListener(ev, () => {
            zone.classList.remove('drag-over');
        }));
        if (input) {
            input.addEventListener('change', () => {
                const fileName = input.files[0]?.name;
                const label = zone.querySelector('.upload-text strong');
                if (label && fileName) label.textContent = fileName;
            });
        }
    });

    // Copy to clipboard
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            const el = document.activeElement;
            if (el) {
                const orig = el.innerHTML;
                el.innerHTML = '<i class="bi bi-check2"></i>';
                setTimeout(() => el.innerHTML = orig, 1500);
            }
        });
    }
</script>
</body>
</html>
