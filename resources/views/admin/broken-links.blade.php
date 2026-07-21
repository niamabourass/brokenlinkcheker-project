<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Broken Links | Broken Link Checker</title>

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
</head>

<body>

<div class="dashboard-container">

    <!-- Sidebar -->
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

                <a href="{{ route('admin.broken-links') }}" class="dashboard-nav-item active">
                    <span class="nav-icon material-symbols-rounded">link_off</span>
                    <span class="nav-label">Liens Cassés</span>
                </a>

                <a href="{{ route('admin.reports') }}" class="dashboard-nav-item">
                    <span class="nav-icon material-symbols-rounded">bar_chart</span>
                    <span class="nav-label">Rapports</span>
                </a>

                <a href="{{ route('admin.settings') }}" class="dashboard-nav-item">
                    <span class="nav-icon material-symbols-rounded">settings</span>
                    <span class="nav-label">Paramètres</span>
                </a>

            </div>

        </nav>

    </aside>

    <div class="dashboard-sidebar-overlay" id="dashboardSidebarOverlay"></div>

    <!-- Main -->
    <main class="dashboard-main">

        <header class="dashboard-header">

            <div class="dashboard-header-content">
                <h1 class="dashboard-header-title">
                    Broken Links
                </h1>
            </div>

        </header>

        <div class="dashboard-content">

            <!-- Statistics -->

            <div class="stats-grid">

                <div class="stat-card">

                    <div class="stat-card-header">

                        <div class="stat-card-title">
                            Websites
                        </div>

                        <div class="stat-card-icon primary">
                            <span class="material-symbols-rounded">
                                language
                            </span>
                        </div>

                    </div>

                    <div class="stat-card-value">
                        {{ $scans->count() }}
                    </div>

                </div>

                <div class="stat-card">

                    <div class="stat-card-header">

                        <div class="stat-card-title">
                            Broken Links
                        </div>

                        <div class="stat-card-icon warning">
                            <span class="material-symbols-rounded">
                                link_off
                            </span>
                        </div>

                    </div>

                    <div class="stat-card-value">
                        {{ $scans->sum('broken') }}
                    </div>

                </div>

            </div>

            <!-- Table -->

            <div class="chart-card" style="margin-top:30px;">

                <div class="chart-card-header">

                    <h3 class="chart-card-title">
                        Broken Links List
                    </h3>

                    <p class="chart-card-subtitle">
                        Websites containing broken links detected by the scanner.
                    </p>

                </div>

                <div style="padding:25px; overflow-x:auto;">

                    <table class="dashboard-table">

                        <thead>

                            <tr>
                                <th>Website</th>
                                <th>Broken Links</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($scans as $scan)

                            <tr>

                                <td>
                                    {{ $scan->host }}
                                </td>

                                <td>

                                    <span style="
                                        background:#fee2e2;
                                        color:#dc2626;
                                        padding:6px 12px;
                                        border-radius:20px;
                                        font-weight:600;
                                    ">
                                        {{ $scan->broken }}
                                    </span>

                                </td>

                                <td>

                                    <a href="{{ route('admin.scan.details',$scan->id) }}"
                                       class="btn btn-primary">

                                        View Links

                                    </a>

                                </td>

                            </tr>

                            @empty

                            <tr>

                                <td colspan="3" style="text-align:center;padding:40px;">
                                    🎉 No broken links found.
                                </td>

                            </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </main>

</div>

<script src="{{ asset('js/dashboard.js') }}"></script>

</body>
</html>