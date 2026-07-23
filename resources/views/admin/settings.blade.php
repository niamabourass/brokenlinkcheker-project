<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Settings | Broken Link Checker</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Google Material Icons -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

    <!-- Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>

    <div class="dashboard-container">
        <aside class="dashboard-sidebar" id="dashboardSidebar">
            <div class="dashboard-brand">
                <button class="dashboard-sidebar-toggle">
                    <span class="material-symbols-rounded">menu</span>
                </button>
                <a class="logo">
                    Broken Link Checker
                </a>
            </div>

            <nav class="dashboard-nav">
                <div class="dashboard-nav-section">
                    <a href="{{ route('admin.dashboard') }}" class="dashboard-nav-item">
                        <span class="nav-icon material-symbols-rounded">dashboard</span>
                        <span class="nav-label">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.new-scan') }}" class="dashboard-nav-item">
                        <span class="nav-icon material-symbols-rounded">search</span>
                        <span class="nav-label">Nouveau Scan</span>
                    </a>
                    <a href="{{ route('admin.scans') }}" class="dashboard-nav-item">
                        <span class="nav-icon material-symbols-rounded">history</span>
                        <span class="nav-label">Historique</span>
                    </a>
                    <a href="{{ route('admin.broken-links') }}" class="dashboard-nav-item">
                        <span class="nav-icon material-symbols-rounded">link_off</span>
                        <span class="nav-label">Liens Cassés</span>
                    </a>
                    <a href="{{ route('admin.reports') }}" class="dashboard-nav-item">
                        <span class="nav-icon material-symbols-rounded">bar_chart</span>
                        <span class="nav-label">Rapports</span>
                    </a>
                    <a href="{{ route('admin.settings') }}" class="dashboard-nav-item active">
                        <span class="nav-icon material-symbols-rounded">settings</span>
                        <span class="nav-label">Paramètres</span>
                    </a>
                </div>
            </nav>
        </aside>

        <div class="dashboard-sidebar-overlay" id="dashboardSidebarOverlay"></div>
        <main class="dashboard-main">
            <header class="dashboard-header">
                <div class="dashboard-header-content">
                    <h1 class="dashboard-header-title">
                        Settings
                    </h1>
                </div>
            </header>

            <div class="dashboard-content">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-title">Total Scans</div>
                            <div class="stat-card-icon primary">
                                <span class="material-symbols-rounded">travel_explore</span>
                            </div>
                        </div>
                        <div class="stat-card-value">
                            {{ $totalScans }}
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-title">Indexed Links</div>
                            <div class="stat-card-icon success">
                                <span class="material-symbols-rounded">link</span>
                            </div>
                        </div>
                        <div class="stat-card-value">
                            {{ $totalIndexedLinks }}
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-title">Broken Links</div>
                            <div class="stat-card-icon warning">
                                <span class="material-symbols-rounded">link_off</span>
                            </div>
                        </div>
                        <div class="stat-card-value">
                            {{ $totalBrokenLinks }}
                        </div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-card-header">
                            <div class="stat-card-title">Last Scan</div>
                            <div class="stat-card-icon info">
                                <span class="material-symbols-rounded">schedule</span>
                            </div>
                        </div>
                        <div class="stat-card-value">
                            {{ $lastScan ? $lastScan->created_at->format('d/m/Y') : '--' }}
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf

    <div class="chart-card" style="margin-top:30px;">

        <div class="chart-card-header">
            <h3 class="chart-card-title">
                👤 Report Information
            </h3>

            <p class="chart-card-subtitle">
                Configure the administrator information displayed in exported reports.
            </p>
        </div>

        <div style="padding:30px;max-width:700px;">

            @if(session('success'))
                <div style="background:#dcfce7;
                            color:#15803d;
                            padding:12px;
                            border-radius:8px;
                            margin-bottom:25px;">
                    {{ session('success') }}
                </div>
            @endif

            <label style="display:block;
              font-weight:600;
              margin-bottom:10px;">
                Administrator Name
            </label>

            <input
                type="text"
                name="admin_name"
                value="{{ old('admin_name', $settings->admin_name) }}"
                placeholder="John Doe"
                style="width:100%;
                    padding:12px;
                    border:1px solid #d1d5db;
                    border-radius:10px;
                    margin-bottom:25px;">

            <label style="display:block;
                          font-weight:600;
                          margin-bottom:10px;">
                Administrator Email
            </label>

            <input
                type="email"
                name="admin_email"
                value="{{ old('admin_email', $settings->admin_email) }}"
                placeholder="john@example.com"
                style="width:100%;
                       padding:12px;
                       border:1px solid #d1d5db;
                       border-radius:10px;
                       margin-bottom:25px;">

            <label style="display:flex;
                          align-items:center;
                          gap:10px;
                          margin-bottom:30px;">

                <input
                    type="checkbox"
                    name="generate_reports"
                    {{ $settings->generate_reports ? 'checked' : '' }}>

                     Include administrator information in exported reports

            </label>

            <button
                type="submit"
                style="background:#2563eb;
                       color:white;
                       padding:12px 30px;
                       border:none;
                       border-radius:10px;
                       cursor:pointer;
                       font-weight:600;">

                Save Settings

            </button>

        </div>

    </div>

</form>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>

</body>

</html>