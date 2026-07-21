<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reports | Broken Link Checker</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <!-- Material Icons -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
  <div class="dashboard-container">
      <!-- Sidebar -->
      <aside class="dashboard-sidebar">
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

                  <a href="{{ route('admin.reports') }}" class="dashboard-nav-item active">
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
      <div class="dashboard-sidebar-overlay"></div>

      <!-- Main -->
      <main class="dashboard-main">
          <header class="dashboard-header">
              <div class="dashboard-header-content">
                  <h1 class="dashboard-header-title">
                      Reports
                  </h1>
              </div>
          </header>

          <div class="dashboard-content">
              <!-- Cards -->
              <div class="stats-grid">
                  <div class="stat-card">
                      <div class="stat-card-header">
                          <div class="stat-card-title">
                              Total Reports
                          </div>

                          <div class="stat-card-icon primary">
                              <span class="material-symbols-rounded">
                                  analytics
                              </span>
                          </div>
                      </div>

                      <div class="stat-card-value">
                          {{ $scanHistory->count() }}
                      </div>
                  </div>

                  <div class="stat-card">
                      <div class="stat-card-header">
                          <div class="stat-card-title">
                              Worst Website
                          </div>

                          <div class="stat-card-icon warning">
                              <span class="material-symbols-rounded">
                                  warning
                              </span>
                          </div>
                      </div>

                      <div class="stat-card-value" style="font-size:18px;">
                          {{ $scanHistory->first()->host ?? '--' }}
                      </div>
                  </div>
              </div>

              <!-- Chart -->
              <div class="chart-card" style="margin-top:30px;">
                  <div class="chart-card-header">
                      <h3 class="chart-card-title">
                          Broken Links Evolution
                      </h3>

                      <p class="chart-card-subtitle">
                          Number of broken links detected for each scanned website.
                      </p>
                  </div>

                  <div style="height:420px;padding:20px;">
                      <canvas id="brokenLinksChart"></canvas>
                  </div>
              </div>

              <!-- Table -->
              <div class="dashboard-table-container" style="margin-top:30px;">
                  <div class="dashboard-table-header">
                      <h3 class="dashboard-table-title">
                          Scan History
                      </h3>
                  </div>

                  <table class="dashboard-table">
                      <thead>
                        <tr>
                            <th>Website</th>
                            <th>Broken Links</th>
                            <th>Indexed Links</th>
                            <th>Date</th>
                        </tr>
                      </thead>

                      <tbody>
                      @foreach($scanHistory as $scan)
                          <tr>
                              <td>{{ $scan->host }}</td>
                              <td>{{ $scan->broken }}</td>
                              <td>{{ $scan->indexed }}</td>
                              <td>{{ $scan->created_at->format('d/m/Y') }}</td>
                          </tr>
                      @endforeach
                      </tbody>
                  </table>
              </div>
          </div>
      </main>
  </div>

  <script src="{{ asset('js/dashboard.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
      const labels = [
          @foreach($scanHistory as $scan)
              "{{ $scan->host }}",
          @endforeach
      ];

      const data = [
          @foreach($scanHistory as $scan)
              {{ $scan->broken }},
          @endforeach
      ];

      const ctx = document.getElementById('brokenLinksChart');

      new Chart(ctx, {
          type: 'bar',
          data: {
              labels: labels,
              datasets: [{
                  label: 'Broken Links',
                  data: data,

                  backgroundColor: 'rgba(59, 130, 246, 0.7)', // Bleu
                  borderColor: '#2563eb',                     // Bleu foncé
                  borderWidth: 2,
                  borderRadius: 8,
                  hoverBackgroundColor: '#1d4ed8'
              }]
          },
          options: {
              responsive: true,
              maintainAspectRatio: false,

              plugins: {
                  legend: {
                      labels: {
                          color: '#374151',
                          font: {
                              size: 14,
                              weight: 'bold'
                          }
                      }
                  }
              },

              scales: {
                  x: {
                      ticks: {
                          color: '#374151'
                      },
                      grid: {
                          display: false
                      }
                  },
                  y: {
                      beginAtZero: true,
                      ticks: {
                          stepSize: 1,
                          color: '#374151'
                      },
                      grid: {
                          color: '#e5e7eb'
                      }
                  }
              }
          }
      });
  </script>

</body>

</html>