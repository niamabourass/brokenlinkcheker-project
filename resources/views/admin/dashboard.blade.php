<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Broken Link Checker</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <!-- Google Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  </head>
  <body>
    <div class="dashboard-container">
      <!-- Dashboard Sidebar -->
      <aside class="dashboard-sidebar" id="dashboardSidebar">
        <div class="dashboard-brand">
          <button class="dashboard-sidebar-toggle">
            <span class="material-symbols-rounded">menu</span>
          </button>
          <a class="logo">Broken Link Checker</a>
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

            <a href="{{ route('admin.settings') }}" class="dashboard-nav-item">
                <span class="nav-icon material-symbols-rounded">settings</span>
                <span class="nav-label">Paramètres</span>
            </a>
          </div>
        </nav>
        <!-- Back to Site Button -->
        <div class="sidebar-footer">
          <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-secondary sidebar-back-button" style="width:100%;">
                <span class="material-symbols-rounded">logout</span>
                <span class="btn-label">Se déconnecter</span>
            </button>
        </form>
        </div>
      </aside>
      <div class="dashboard-sidebar-overlay" id="dashboardSidebarOverlay"></div>
      <!-- Dashboard Main Content -->
      <main class="dashboard-main">
        <!-- Dashboard Header -->
        <header class="dashboard-header">
          <!-- Header Content -->
          <div class="dashboard-header-content">
            <button class="dashboard-sidebar-toggle">
              <span class="material-symbols-rounded">menu</span>
            </button>
            <h1 class="dashboard-header-title" id="dashboardTitle">Overview</h1>
          </div>
          <div class="dashboard-header-actions">

            <!-- Dernier scan -->
            <div class="header-info">
                <span class="material-symbols-rounded">schedule</span>
                <span>
                    Last Scan :
                    {{ $lastScan ? $lastScan->created_at->format('d/m/Y H:i') : 'No scan' }}
                </span>
            </div>

            <!-- Score global -->
            <div class="header-info">
                <span class="material-symbols-rounded">health_and_safety</span>
                <span>Health : {{ $healthScore }}%</span>
            </div>

            <!-- Utilisateur -->
            <div class="header-info">
                <span class="material-symbols-rounded">admin_panel_settings</span>
                <span>Administrator</span>
            </div>

        </div>
        </header>
        <!-- Dashboard Content -->
        <div class="dashboard-content">
        <!-- Overview View -->
        <div class="dashboard-view active" id="overview">
            <!-- Stats Cards -->
            <div class="stats-grid">
                <!-- Websites Scanned -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">
                            Websites Scanned
                        </div>

                        <div class="stat-card-icon primary">
                            <span class="material-symbols-rounded">
                            language
                            </span>
                        </div>
                    </div>

                    <div class="stat-card-value">
                    {{ $totalSites }}
                    </div>

                    <div class="stat-card-change positive">
                        <span class="material-symbols-rounded">
                            trending_up
                        </span>

                        <span>
                            Total websites
                        </span>
                    </div>
                </div>

                <!-- URLs Checked -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">
                            URLs Checked
                        </div>

                        <div class="stat-card-icon success">
                            <span class="material-symbols-rounded">
                            link
                            </span>
                        </div>
                    </div>

                    <div class="stat-card-value">
                    {{ $totalLinks }}
                    </div>

                    <div class="stat-card-change positive">
                        <span class="material-symbols-rounded">
                            trending_up
                        </span>

                        <span>
                            Indexed + Broken
                        </span>
                    </div>
                </div>

                <!-- Broken Links -->
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
                    {{ $totalBrokenLinks }}
                    </div>

                    <div class="stat-card-change negative">
                        <span class="material-symbols-rounded">
                            trending_down
                        </span>

                        <span>
                            Detected errors
                        </span>
                    </div>
                </div>

                <!-- Health Score -->
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-card-title">
                            Health Score
                        </div>

                        <div class="stat-card-icon info">
                            <span class="material-symbols-rounded">
                            health_and_safety
                            </span>
                        </div>
                    </div>

                    <div class="stat-card-value">
                    {{ $healthScore }}%
                    </div>

                    <div class="stat-card-change positive">
                        <span class="material-symbols-rounded">
                            trending_up
                        </span>

                        <span>
                            Website health
                        </span>
                    </div>
                </div>
            </div>
            <!-- Charts -->
            <div class="chart-grid">
                <!-- Scan Activity -->
                <div class="chart-card">
                    <div class="chart-card-header">
                        <h3 class="chart-card-title">
                            Scan Activity
                        </h3>

                        <p class="chart-card-subtitle">
                            Number of scans during the last days
                        </p>
                    </div>
                    <div class="chart-container">
                        <canvas id="progressChart"></canvas>
                    </div>
                </div>
                <!-- HTTP Errors -->
                <div class="chart-card">
                    <div class="chart-card-header">
                        <h3 class="chart-card-title">
                            HTTP Errors
                        </h3>

                        <p class="chart-card-subtitle">
                            Distribution of broken links by HTTP status code
                        </p>
                    </div>
                    <div class="chart-container">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
            <!-- Recent Scans -->
            <div class="dashboard-table-container">
                <div class="dashboard-table-header">
                    <h3 class="dashboard-table-title">Recent Scans</h3>
                </div>

                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Website</th>
                            <th>Indexed</th>
                            <th>Broken</th>
                            <th>Health</th>
                            <th>Date</th>
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($recentScans as $scan)
                        <tr>
                            <td>
                                {{ $scan->website }}
                            </td>
                            <td>
                                {{ $scan->indexed }}
                            </td>
                            <td>
                                {{ $scan->broken }}
                            </td>
                            <td>
                                @php
                                    $health = ($scan->indexed + $scan->broken) > 0
                                        ? round(($scan->indexed / ($scan->indexed + $scan->broken)) * 100)
                                        : 0;
                                @endphp

                                @if($health >= 90)
                                    <span class="status-badge success">
                                        {{ $health }}%
                                    </span>
                                @elseif($health >= 70)
                                    <span class="status-badge warning">
                                        {{ $health }}%
                                    </span>
                                @else
                                    <span class="status-badge danger">
                                        {{ $health }}%
                                    </span>
                                @endif

                            </td>

                            <td>
                                {{ $scan->created_at->format('d/m/Y H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center;">
                                No scans available.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
      </main>
    </div>
    <!-- Scripts -->
     <script>
      window.scanChartData = @json($scanChartData);
      window.httpErrors = @json($httpErrors);
    </script>

<script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
  </body>
</html>