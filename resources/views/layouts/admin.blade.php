<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title')</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </head>

    <body>

        <div class="dashboard-container">
            @include('layouts.sidebar')
            <div class="dashboard-sidebar-overlay" id="dashboardSidebarOverlay"></div>
            <main class="dashboard-main">
                @yield('content')
            </main>
        </div>
    </body>

</html>