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

                <div class="chart-card" style="margin-top:30px;">

                  <div class="chart-card-header">
                      <h3 class="chart-card-title">
                          System Information
                      </h3>

                      <p class="chart-card-subtitle">
                          Overview of your Broken Link Checker application.
                      </p>
                  </div>

                    <div style="padding:30px;">
                      
                      <table style="width:100%;border-collapse:collapse;">

                          <tr style="border-bottom:1px solid #e5e7eb;">
                              <td style="padding:15px;font-weight:600;">Application</td>
                              <td style="padding:15px;">Broken Link Checker</td>
                          </tr>

                          <tr style="border-bottom:1px solid #e5e7eb;">
                              <td style="padding:15px;font-weight:600;">Framework</td>
                              <td style="padding:15px;">Laravel 13</td>
                          </tr>

                          <tr style="border-bottom:1px solid #e5e7eb;">
                              <td style="padding:15px;font-weight:600;">PHP Version</td>
                              <td style="padding:15px;">{{ phpversion() }}</td>
                          </tr>

                          <tr style="border-bottom:1px solid #e5e7eb;">
                              <td style="padding:15px;font-weight:600;">Database</td>
                              <td style="padding:15px;">MySQL</td>
                          </tr>

                          <tr style="border-bottom:1px solid #e5e7eb;">
                              <td style="padding:15px;font-weight:600;">Total Scans</td>
                              <td style="padding:15px;">{{ $totalScans }}</td>
                          </tr>

                          <tr style="border-bottom:1px solid #e5e7eb;">
                              <td style="padding:15px;font-weight:600;">Indexed Links</td>
                              <td style="padding:15px;">{{ $totalIndexedLinks }}</td>
                          </tr>

                          <tr style="border-bottom:1px solid #e5e7eb;">
                              <td style="padding:15px;font-weight:600;">Broken Links</td>
                              <td style="padding:15px;">{{ $totalBrokenLinks }}</td>
                          </tr>

                          <tr style="border-bottom:1px solid #e5e7eb;">
                              <td style="padding:15px;font-weight:600;">Last Scan</td>
                              <td style="padding:15px;">
                                  {{ $lastScan ? $lastScan->created_at->format('d/m/Y H:i') : 'No scan available' }}
                              </td>
                          </tr>

                          <tr>
                              <td style="padding:15px;font-weight:600;">System Status</td>
                              <td style="padding:15px;">
                                  <span style="background:#dcfce7;color:#15803d;padding:6px 12px;border-radius:20px;font-weight:600;">
                                      Running
                                  </span>
                              </td>
                          </tr>

                      </table>

                      <div style="margin-top:30px;padding:20px;background:#eff6ff;border-left:5px solid #2563eb;border-radius:10px;">

                          <h3 style="margin-bottom:15px;color:#2563eb;">
                              About the Application
                          </h3>

                          <p style="line-height:1.8;color:#555;">
                              Broken Link Checker is a Laravel web application designed to analyze websites,
                              detect broken links, monitor indexed pages, and generate detailed reports.
                              The dashboard provides real-time statistics that are automatically updated
                              after each scan.
                          </p>

                      </div>

                    </div>

              </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>

</body>

</html>