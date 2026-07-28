<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website History</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>

        .table tbody tr{
            transition:.25s;
        }

        .table tbody tr:hover{
            background:#eef5ff;
            transform:scale(1.01);
        }

    </style>
    <style>
        .table tbody tr{
            transition:0.3s;
        }

        .table tbody tr:hover{
            background:#eef5ff;
            transform:scale(1.01);
        }

        .badge{
            font-size:14px;
            padding:8px 12px;
            border-radius:20px;
        }

        .badge-danger-soft{
            background-color:#FEE2E2;
            color:#DC2626;
            padding:8px 12px;
            border-radius:20px;
            font-weight:600;
        }

        .badge-success-soft{
            background-color:#DCFCE7;
            color:#16A34A;
            padding:8px 12px;
            border-radius:20px;
            font-weight:600;
        }

        .badge-warning-soft{
            background-color:#FEF3C7;
            color:#D97706;
            padding:8px 12px;
            border-radius:20px;
            font-weight:600;
        }
        .scan-header{
            background:#EFF6FF;
            color:#2563EB;
            font-weight:700;
            font-size:18px;
            border-bottom:1px solid #DBEAFE;
            padding:16px 20px;
        }
        .card{
            border:none;
            border-radius:18px;
        }

        .card-header{
            border-top-left-radius:18px !important;
            border-top-right-radius:18px !important;
        }
    </style>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Google Icons -->
    <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

    <!-- Dashboard CSS -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>

    <div class="dashboard-container">
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
        <main class="dashboard-main">
            <div class="p-4">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary mb-4">
                    ← Back to Dashboard
                </a>

                <div class="card border-0 shadow rounded-4 mb-4">
                    <div class="card-body">
                        <h2 class="fw-bold mb-3">
                            🌐 {{ $website }}
                        </h2>

                        <p class="text-secondary">
                            Complete history of all scans performed on this website.
                        </p>
                        <p class="text-muted">
                            Total Scans : <strong>{{ $history->count() }}</strong>
                        </p>
                    </div>
                </div>

                <div class="card shadow-sm mb-4">
                    <div class="card-header scan-header">
                        📈 Broken Links Evolution
                    </div>

                    <div class="card-body">
                        <div style="height:300px;">
                            <canvas id="brokenChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow rounded-4">
                    <div class="card-header scan-header">
                        📋 Scan History
                    </div>

                    <div class="card-body">
                        <div class="table-responsive rounded-4">
                            <table class="table table-hover align-middle table-borderless mb-0">
                                <thead class="table-primary">
                                    <tr>
                                        <th>📅 Date</th>
                                        <th>❌ Broken</th>
                                        <th>✅ Indexed</th>
                                        <th>⏭️ Skipped</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($history as $scan)
                                <tr>
                                    <td>{{ $scan->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <span class="badge-danger-soft">
                                            {{ $scan->broken }}
                                        </span>
                                    </td>

                                    <td>
                                    <span class="badge-success-soft">
                                        {{ $scan->indexed }}
                                    </span>
                                    </td>

                                    <td>
                                        <span class="badge-warning-soft">
                                        {{ $scan->skipped }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        
            <script>
                const chartData = @json($chartData);
                const labels = chartData.map(item => item.date);
                const broken = chartData.map(item => item.broken);
                const scans = chartData.map(item => item.scans);

                new Chart(document.getElementById('brokenChart'), {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Broken Links',
                            data: broken,
                            borderColor: '#2563eb',
                            backgroundColor: 'rgba(37,99,235,0.15)',
                            fill: true,
                            borderWidth: 3,
                            tension: 0.4,
                            pointRadius: 5,
                            pointHoverRadius: 8,
                            pointBackgroundColor: '#2563eb',
                            pointBorderColor: '#fff',
                            pointBorderWidth: 2
                        }]
                    },

                    options: {
                        responsive: true,
                        maintainAspectRatio: false,

                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    afterLabel: function(context) {
                                        return "Total Scans : " + scans[context.dataIndex];
                                    }
                                }
                            }
                        },

                        animation: {
                            duration: 1500,
                            easing: 'easeOutQuart'
                        },

                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: "#ececec"
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });
            </script>
            <script src="{{ asset('js/dashboard.js') }}"></script>
        </main>
 </div>

 </body>
</html>