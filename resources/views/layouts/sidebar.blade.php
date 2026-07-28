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