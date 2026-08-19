<!DOCTYPE html>
<html lang="fr">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Website Scan Report</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        body{
            font-family:Inter,sans-serif;
            background:
                radial-gradient(circle at top right,#f1f5f9 0%,transparent 28%),
                radial-gradient(circle at bottom left,#eef2f7 0%,transparent 30%),
                linear-gradient(180deg,#fafbfd 0%,#f4f6f9 100%);
            color:#374151;
        }

        .container{
            max-width:1180px;
            padding-top:45px;
            padding-bottom:70px;
        }

        /*TITRES*/

        .page-title{

            font-size:54px;

            font-weight:800;

            color:#1f2937;

            letter-spacing:-1px;

            margin-bottom:10px;

        }

        .page-subtitle{

            color:#6b7280;

            font-size:18px;

            margin-bottom:55px;

        }

        /*LOGOUT*/

        .logout-btn{

            background:#4b5563;

            color:white;

            border:none;

            padding:12px 26px;

            border-radius:14px;

            font-weight:600;

            transition:.3s;

            box-shadow:0 10px 20px rgba(0,0,0,.08);

        }

        .logout-btn:hover{
            background:#374151;
            color:white;
            transform:translateY(-2px);
        }

        /*CARDS*/

        .card{
            background:#ffffff;
            border:1px solid #eceff3;
            border-radius:22px;
            box-shadow:0 12px 30px rgba(15,23,42,.05);
            transition:.35s;
        }

        .card:hover{
            transform:translateY(-5px);
            box-shadow:0 20px 40px rgba(15,23,42,.08);
        }

        /* HERO CARD*/

        .info-card{
            overflow:hidden;
            position:relative;
        }

        .info-card::before{
            content:"";
            position:absolute;
            left:0;
            top:0;
            width:6px;
            height:100%;
            background:#64748b;
        }

        .info-card .badge{
            background:#eef2f7 !important;
            color:#374151 !important;
            border:none;
            font-size:14px;
            font-weight:600;
            padding:10px 18px;
        }

        .info-card h2{
            color:#1f2937;
            font-size:40px;
            font-weight:700;
        }

        .info-card p{
            color:#6b7280;
            font-size:16px;
        }

        /*SCAN STATUS*/

        .scan-status{
            width:95px;
            height:95px;
            border-radius:50%;
            background:#dcfce7;
            color:#16a34a;
            border:3px solid #bbf7d0;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:42px;
            margin:auto;
            box-shadow:0 10px 25px rgba(22,163,74,.15);
        }

        .scan-text{
            color:#16a34a;
            font-weight:700;
            font-size:17px;
            margin-top:15px;
        }

        /*STATISTICS CARDS*/

        .stat-card{
            padding:35px 25px;
            text-align:center;
            height:100%;
        }

        .stat-icon{
            width:72px;
            height:72px;
            border-radius:18px;
            display:flex;
            justify-content:center;
            align-items:center;
            margin:auto auto 20px;
            font-size:30px;
        }

        /* Couleurs des icônes */
        .blue-bg{
            background:#eef2f7;
            color:#475569;
        }

        .orange-bg{
            background:#fff7ed;
            color:#d97706;
        }

        .red-bg{
            background:#fef2f2;
            color:#dc2626;
        }

        .stat-card h5{
            color:#6b7280;
            font-size:18px;
            margin-bottom:12px;
            font-weight:600;
        }

        .stat-number{
            font-size:54px;
            font-weight:700;
            color:#1f2937;
        }

        .stat-number-danger{
            color:#dc2626;
        }

        /* SEPARATEUR */
        hr{
            border-color:#e5e7eb;
            margin:45px 0;
        }

        /*BROKEN LINKS CARD*/
        .card-header{
            background:#f8fafc;
            border-bottom:1px solid #e5e7eb;
            padding:22px 28px;
        }

        .card-header h4{
            margin:0;
            font-size:24px;
            font-weight:700;
            color:#1f2937;
        }

        .card-header .badge{
            background:#eef2f7 !important;
            color:#475569 !important;
            border-radius:50px;
            padding:10px 18px;
            font-size:14px;
            font-weight:600;
        }

        /*TABLE*/

        .table{
            margin-bottom:0;
        }

        .table thead{
            background:#f3f4f6;
        }

        .table thead th{
            color:#374151;
            font-weight:700;
            border:none;
            padding:18px;
        }

        .table tbody td{
            padding:18px;
            border-color:#f1f5f9;
        }

        .table tbody tr{
            transition:.25s;
        }

        .table tbody tr:hover{
            background:#f8fafc;
        }

        .table a{
            color:#2563eb;
            text-decoration:none;
            font-weight:500;
        }

        .table a:hover{
            color:#1d4ed8;
            text-decoration:underline;
        }

        /*BADGES HTTP*/
        .badge{
            padding:9px 16px;
            border-radius:50px;
            font-size:13px;
            font-weight:600;
            letter-spacing:.3px;
        }

        .bg-danger{
            background:#ef4444 !important;
        }

        .bg-warning{
            background:#facc15 !important;
            color:#374151 !important;
        }

        .bg-secondary{
            background:#94a3b8 !important;
        }
        /*Export CSV */
        .export-btn{
            background:#4b5563;
            color:#fff;
            border:none;
            border-radius:14px;
            padding:13px 28px;
            font-weight:600;
            transition:.3s;
            box-shadow:0 8px 18px rgba(0,0,0,.08);
        }

        .export-btn:hover{
            background:#374151;
            color:#fff;
            transform:translateY(-2px);
            box-shadow:0 12px 25px rgba(0,0,0,.15);
        }

        /*Send Report */
        .report-btn{
            background:linear-gradient(135deg,#60a5fa,#3b82f6);
            color:white;
            border:none;
            border-radius:14px;
            padding:13px 28px;
            font-weight:600;
            transition:.3s;
            box-shadow:0 8px 20px rgba(59,130,246,.25);
        }

        .report-btn:hover{
            background:linear-gradient(135deg,#3b82f6,#2563eb);
            color:white;
            transform:translateY(-2px);
        }

        /* Nouvelle analyse */
        .scan-btn{
            background:#e8f1ff;
            color:#2563eb;
            border:1px solid #bfdbfe;
            border-radius:14px;
            padding:13px 34px;
            font-weight:600;
            transition:.3s;
        }

        .scan-btn:hover{
            background:#2563eb;
            color:white;
            transform:translateY(-2px);
            box-shadow:0 10px 24px rgba(37,99,235,.25);
        }
                
        .navbar {
            height: 78px !important;
            background: #e5e7eb !important;
            display: flex;
            align-items: center;
        }

        .navbar .container {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand {
            height: 100%;
            display: flex !important;
            align-items: center !important;
            margin-left: 25px;
        }

        .navbar-logo {
            height: 52px !important;
            width: auto !important;
            max-height: 52px !important;
            object-fit: contain;
            display: block;
        }
    </style>

</head>

<body>

<!-- ================= NAVBAR ================= -->

<nav class="navbar navbar-expand-lg sticky-top">

    <div class="container-fluid px-3">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Website Link Checker"
                 class="navbar-logo">
        </a>

        @auth
            ...
        @else
            <a href="{{ route('login') }}" class="admin-btn">
                <i class="bi bi-person-circle me-2"></i>
                Login
            </a>
        @endauth

    </div>

</nav>

        


<!-- ================= REPORT ================= -->

<div class="container">

    <div class="d-flex justify-content-end mb-4">

        @auth

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button class="btn logout-btn">

                <i class="bi bi-box-arrow-right me-2"></i>

                Logout

            </button>

        </form>

        @endauth

    </div>

    <h1 class="page-title text-center">

        Website Scan Report

    </h1>

    <p class="page-subtitle text-center mb-5">

        Analyse terminée avec succès

    </p>

    <div class="card info-card mb-5">

        <div class="card-body p-4">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <span class="badge bg-primary rounded-pill px-3 py-2 mb-3">

                        Website Scan

                    </span>

                    <h2 class="fw-bold">

                        {{ parse_url($website, PHP_URL_HOST) }}

                    </h2>

                    <p class="text-muted mb-2">

                        <i class="bi bi-globe me-2"></i>

                        {{$website}}

                    </p>

                    <p class="text-muted mb-0">

                        <i class="bi bi-clock-history me-2"></i>

                        {{$updated}}

                    </p>

                </div>

                <div class="col-lg-4 text-center">

                    <div class="scan-status">

                        <i class="bi bi-check2"></i>

                    </div>

                    <div class="scan-text">

                        Scan Completed

                    </div>

                </div>

            </div>

        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card stat-card">
                <div class="stat-icon blue-bg">
                    <i class="bi bi-file-earmark-text"></i>
                </div>
                <h5>Pages indexées</h5>
                <div class="stat-number">
                    {{$indexed}}
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card stat-card">
                <div class="stat-icon orange-bg">
                    <i class="bi bi-skip-forward"></i>
                </div>
                <h5>Pages ignorées</h5>
                <div class="stat-number" style="color:#f59e0b">
                    {{$skipped}}
                </div>

            </div>

        </div>

        <div class="col-md-4">
            <div class="card stat-card">
                <div class="stat-icon red-bg">
                    <i class="bi bi-link-45deg"></i>
                </div>
                <h5>Liens cassés</h5>
                <div class="stat-number stat-number-danger">
                    {{ count($brokenLinks) }}
                </div>
            </div>
        </div>
    </div>

        @if(count($brokenLinks))

    <div class="card mb-5">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                Broken Links
            </h4>
            <span class="badge bg-light text-dark rounded-pill px-3 py-2">
                {{ count($brokenLinks) }} détecté(s)
            </span>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead>
                        <tr>
                            <th>URL</th>
                            <th class="text-center" width="180">
                                HTTP Status
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($brokenLinks as $link)
                        <tr>
                            <td>
                                <a href="{{$link['url']}}"
                                   target="_blank">
                                    {{$link['url']}}
                                </a>
                            </td>

                            <td class="text-center">
                                @if($link['status']==404)
                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                        404 Not Found
                                    </span>

                                @elseif($link['status']==500)
                                    <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                        500 Server Error
                                    </span>

                                @elseif($link['status']==0)
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">
                                        No Response
                                    </span>
                                @else
                                    <span class="badge bg-secondary rounded-pill px-3 py-2">
                                        {{$link['status']}}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <hr>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                <a href="{{ route('export.csv') }}"
                    class="btn export-btn">
                    <i class="bi bi-download me-2"></i>
                    Export CSV
                </a>

                <button
                    class="btn report-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#sendReportModal">
                    <i class="bi bi-envelope-fill me-2"></i>
                    Send Report
                </button>
            </div>
        </div>
    </div>

    @else

    <div class="card text-center p-5 mb-5">
        <div style="font-size:70px;color:#22c55e;">
            <i class="bi bi-check-circle-fill"></i>
        </div>

        <h3 class="mt-3 fw-bold">
            Excellent !
        </h3>

        <p class="text-muted">
            Aucun lien cassé n'a été détecté sur ce site.
        </p>
    </div>

    @endif

    <div class="text-center">
        <a href="/" class="btn scan-btn">
            <i class="bi bi-arrow-repeat me-2"></i>
            Nouvelle analyse
        </a>
    </div>
</div>


@if(session('success'))
<div class="container mt-4">
    <div class="alert alert-success shadow-sm rounded-4">
        {{ session('success') }}
    </div>
</div>
@endif

@if(session('error'))
<div class="container mt-4">
    <div class="alert alert-danger shadow-sm rounded-4">
        {{ session('error') }}
    </div>
</div>
@endif


<!-- Modal -->

<div class="modal fade"
     id="sendReportModal"
     tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <form method="POST"
                  action="{{ route('send.report') }}">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h4 class="fw-bold">
                        <i class="bi bi-envelope-paper-fill text-primary me-2"></i>
                        Send Scan Report
                    </h4>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">
                            Your Name
                        </label>
                        <input type="text"
                               name="name"
                               class="form-control"
                               placeholder="John Doe"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">
                            Email Address
                        </label>

                        <input type="email"
                               name="email"
                               class="form-control"
                               placeholder="example@email.com"
                               required>
                    </div>
                </div>

                <div class="modal-footer border-0">
                    <button type="button"
                            class="btn secondary-btn"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn main-btn">
                        <i class="bi bi-send-fill me-2"></i>
                        Send
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>