<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Website Link Checker</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>

        body{
            background:#f6f8fc;
            font-family:Inter,sans-serif;
        }
        .navbar{
            background:white!important;
            border-bottom:1px solid #ececec;
        }

        .navbar-brand{
            color:#2563eb!important;
            font-weight:700;
            font-size:24px;
        }

        .hero{
            padding-top:90px;
            padding-bottom:80px;
            text-align:center;
        }

        .hero h1{
            font-size:42px;
            font-weight:800;
            color:#0f172a;
        }

        .hero p{
            max-width:700px;
            margin:auto;
            font-size:20px;
            color:#64748b;
        }

        .scan-card{
            background:white;
            border:1px solid #e5e7eb;
            border-radius:24px;
            padding:30px;
            box-shadow:
            0 15px 40px rgba(15,23,42,.08);
            transition:.3s;
        }

        .scan-card:hover{
            transform:translateY(-5px);
            box-shadow:
            0 25px 60px rgba(15,23,42,.12);
        }

        .hero-icon{
            width:110px;
            height:110px;
            background:linear-gradient(135deg,#34d399,#10b981);
            color:white;
            border-radius:28px;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:45px;
            margin:auto;
            margin-bottom:30px;
            box-shadow:0 15px 35px rgba(16,185,129,.25);
        }

        .scan-btn{
            background:#4b5563;
            color:white;
            border:none;
            padding:16px 24px;
            font-size:20px;
            font-weight:700;
            border-radius:16px;
            transition:.3s;
            box-shadow:0 10px 25px rgba(75,85,99,.25);
        }

        .scan-btn:hover{
            background:#374151;
            transform:translateY(-2px);
            box-shadow:0 15px 30px rgba(75,85,99,.35);
        }

        .input-group-text{
            background:white;
            border-right:none;
        }

        .form-control{
            border-left:none;
            padding:16px;
        }

        .step-card{

            background:#ffffff;
            border:1px solid #e2e8f0;
            border-radius:24px;
            padding:35px 25px;
            min-height:260px;
            text-align:center;
            transition:.3s;
            box-shadow:
            0 8px 25px rgba(15,23,42,.05);
        }


        .step-card:hover{

            transform:translateY(-8px);
            box-shadow:
            0 20px 45px rgba(15,23,42,.12);

        }

        .step-icon{
            width:70px;
            height:70px;
            border-radius:20px;
            background:#eff6ff;
            color:#2563eb;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:28px;
            margin:auto auto 20px;

        }
        .step-number{
            position:absolute;
            top:22px;
            right:22px;
            font-size:14px;
            font-weight:700;
            color:#cbd5e1;
            letter-spacing:2px;
        }

        .step-card h4{
            color:#0f172a;
        }
        
        .step-card p{
            line-height:1.8;
            font-size:15px;
        }

        .feature-card{
            background:#fff;
            border:1px solid #e9ecef;
            border-radius:20px;
            padding:32px;
            height:100%;
            transition:all .3s ease;
        }

        .feature-card:hover{
            transform:translateY(-6px);
            border-color:#cbd5e1;
            box-shadow:0 15px 35px rgba(0,0,0,.08);
        }

        .feature-icon{
            width:70px;
            height:70px;
            border-radius:18px;
            display:flex;
            justify-content:center;
            align-items:center;
            margin:0 auto 25px;
            font-size:30px;
        }

        .icon-blue{
            background:#eef4ff;
            color:#2563eb;
        }

        .icon-red{
            background:#fff1f2;
            color:#ef4444;
        }

        .icon-green{
            background:#ecfdf5;
            color:#10b981;
        }

        .icon-yellow{
            background:#fffbeb;
            color:#f59e0b;
        }
        
        .navbar{
            background:#e5e7eb !important;
            border-bottom:none;
            padding:18px 0;
        }
        /* Logo */
        .logo-box{
            width:46px;
            height:46px;
            border-radius:14px;
            background:#f3f4f6;
            border:1px solid #e5e7eb;
            color:#374151;
            display:flex;
            justify-content:center;
            align-items:center;
            font-size:22px;
            transition:.3s;
        }

        .logo-box:hover{
            background:#111827;
            color:white;
        }

        /* Nom */
        .navbar-brand{
            font-size:22px;
            font-weight:700;
            color:#111827!important;
        }

        /* Liens */
        .nav-link-custom{
            text-decoration:none;
            color:#6b7280;
            font-weight:500;
            transition:.3s;
            position:relative;
        }

        .nav-link-custom:hover{
            color:#111827;
        }

        .nav-link-custom::after{
            content:"";
            position:absolute;
            left:0;
            bottom:-6px;
            width:0;
            height:2px;
            background:#374151;
            transition:.3s;
        }

        .nav-link-custom:hover::after{
            width:100%;
        }

        /* Bouton Admin */
        .admin-btn{
            text-decoration:none;
            background:#f9fafb;
            color:#374151;
            border:1px solid #e5e7eb;
            border-radius:30px;
            padding:10px 22px;
            font-weight:600;
            transition:.3s;
        }

        .admin-btn:hover{
            background:#111827;
            color:white;
            border-color:#111827;
        }

        /*REDUIRE LA TAILLE DE LA PAGE*/
        .navbar{
            padding:10px 0;
        }

        .logo-box{
            width:38px;
            height:38px;
            font-size:18px;
        }

        .navbar-brand{
            font-size:18px;
        }

        /* HERO */

        .hero{
            padding-top:55px;
            padding-bottom:55px;
        }

        .hero p{
            font-size:16px;
            margin-bottom:30px !important;
        }

        .hero-icon{
            width:80px;
            height:80px;
            font-size:32px;
            margin-bottom:20px;
        }

        /* CARTE SCAN */

        .scan-card{
            border-radius:20px;
        }

        .scan-card .card-body{
            padding:25px !important;
        }

        .form-control{
            padding:10px;
        }

        .scan-btn{
            padding:10px 18px;
            font-size:16px;
        }

        /* PROGRESS */
        #progressContainer .card-body{
            padding:25px !important;
        }

        #progressContainer h3{
            font-size:22px;
        }

        #progressContainer h2{
            font-size:28px;
        }
        /* SECTIONS */

        section.py-5{
            padding-top:35px !important;
            padding-bottom:35px !important;
        }

        /* TITRES HOW IT WORKS + FEATURES */
        .display-5{
            font-size:32px !important;
        }

        /* CARTES */
        .feature-card{
            padding:20px;
        }

        .feature-icon{
            width:55px;
            height:55px;
            font-size:24px;
        }

        .feature-card p{
            font-size:14px;
        }

        /* FOOTER */
        footer{
            font-size:14px;
        }

        .login-modal{
            border:none;
            border-radius:22px;
            background:#ffffff;
            box-shadow:0 20px 45px rgba(15,23,42,.10);
            overflow:hidden;
        }

        .login-modal .modal-body{
            padding:40px 35px;
        }

        .login-icon{
            width:75px;
            height:75px;
            margin:auto;
            margin-bottom:25px;
            border-radius:50%;
            background:#f3f4f6;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .login-icon i{
            font-size:34px;
            color:#4b5563;
        }

        .login-title{
            font-size:28px;
            font-weight:700;
            color:#1f2937;
            margin-bottom:15px;
        }

        .login-text{
            color:#6b7280;
            line-height:1.7;
            margin-bottom:30px;
            font-size:15px;
        }

        .login-btn{
            background:#4b5563;
            color:white;
            border:none;
            border-radius:14px;
            padding:14px;
            font-weight:600;
            transition:.3s;
        }

        .login-btn:hover{
            background:#374151;
            color:white;
            transform:translateY(-2px);
        }

        .cancel-btn{
            background:#f3f4f6;
            color:#4b5563;
            border:none;
            border-radius:14px;
            padding:14px;
            font-weight:600;
            transition:.3s;
        }

        .cancel-btn:hover{
            background:#e5e7eb;
        }

        .login-btn,
        .cancel-btn{
            box-shadow:none;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-menu {
            position: relative;
        }

        .menu-btn {
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            color: #4b5563;
            cursor: pointer;
            font-size: 22px;
            transition: 0.2s;
        }

        .menu-btn:hover {
            background: #f3f4f6;
        }

        .user-dropdown {
            display: none;
            position: absolute;
            top: 50px;
            right: 0;
            width: 230px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
            z-index: 9999;
            overflow: hidden;
        }

        .user-dropdown.show {
            display: block;
        }

        .user-info {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .user-info strong {
            color: #1f2937;
        }

        .user-info small {
            color: #6b7280;
            font-size: 12px;
        }

        .user-dropdown a {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            color: #374151;
            text-decoration: none;
            font-size: 14px;
        }

        .user-dropdown a:hover {
            background: #f3f4f6;
        }

        .navbar-logo {
            height: 40px;
            width: auto;
            object-fit: contain;
            transform: scale(1.5);
            margin-left: 25px;
            margin-top: 5px;
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="/" style="margin-left: 25px;">
                <img src="{{ asset('images/logo.png') }}"
                    alt="Website Link Checker"
                    class="navbar-logo">
            </a>
            <!-- Admin -->

            @auth

            <div class="user-actions">

                <!-- Menu utilisateur -->
                <div class="user-menu">

                    <button
                        type="button"
                        class="menu-btn"
                        id="userMenuButton">

                        <i class="bi bi-list"></i>

                    </button>


                    <!-- Menu déroulant -->
                    <div
                        class="user-dropdown"
                        id="userDropdown">

                        <div class="user-info">

                            <strong>
                                {{ Auth::user()->name }}
                            </strong>

                            <small>
                                {{ Auth::user()->email }}
                            </small>

                        </div>

                        <a href="{{ route('user.history') }}">
                            <i class="bi bi-clock-history me-2"></i>
                            Historique
                        </a>
                    </div>

                </div>


                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="admin-btn">
                        <i class="bi bi-box-arrow-right me-2"></i>
                        Logout
                    </button>
                </form>
            </div>

            @else
            <a href="{{ route('login') }}" class="admin-btn">
                <i class="bi bi-person-circle me-2"></i>
                Login
            </a>
            @endauth
                    </div>

                </nav>

                <section class="hero">
                
                <div class="container">
                        <div class="hero-icon">
                <i class="bi bi-shield-check"></i>
            </div>

            <h1>
                Check Your Website<br>
                For Broken Links
            </h1>

            <p class="mt-4 mb-5">

                Analyze your website automatically,
                detect broken links,
                redirects,
                and generate detailed reports in seconds.

            </p>

            <div class="row justify-content-center">

                 <div class="col-lg-8">

                    <div class="card scan-card">

                        <div class="card-body p-3">

                            <form id="scanForm"  method="POST" action="/check-url-statut">
                              @csrf
                              <label class="fw-semibold mb-3">
                                   Website URL
                              </label>

                              <div class="input-group input-group-lg mb-4">

                                <span class="input-group-text">

                                <i class="bi bi-globe"></i>

                                </span>

                                <input  type="url" name="url" class="form-control"  placeholder="https://example.com"  required>

                              </div>

                              <div class="d-grid">

                                <button

                                id="scanButton"

                                class="btn scan-btn text-white rounded-4"

                                type="submit">

                                <i class="bi bi-search"></i>

                                Scan Website

                                </button>

                              </div>
                                <!-- Progress -->

                              <div id="progressContainer" class="mt-5" style="display:none;">

                                <div class="card border-0 shadow rounded-4">

                                    <div class="card-body p-5">

                                        <h3 class="fw-bold text-center mb-3">

                                            Website Analysis

                                        </h3>

                                        <p class="text-center text-muted mb-4">

                                            <span class="spinner-border spinner-border-sm text-secondary me-2"></span>

                                            Scanning

                                            <strong id="websiteName"></strong>

                                        </p>

                                        <div class="progress rounded-pill mb-5"

                                            style="height:26px;">

                                            <div

                                                id="progressBar"

                                                class="progress-bar progress-bar-striped progress-bar-animated"

                                                style="width:0%;
                                                background:#2563eb;
                                                font-size:16px;">

                                                0%

                                            </div>

                                        </div>

                                        <div class="row g-4">

                                            <div class="col-md-4">

                                                <div class="card border-0 bg-light rounded-4">

                                                    <div class="card-body text-center">

                                                        <i class="bi bi-file-earmark-text"

                                                        style="font-size:38px;color:#2563eb;"></i>

                                                        <h2

                                                            id="indexed"

                                                            class="fw-bold mt-3">

                                                            0

                                                        </h2>

                                                        <p class="text-muted mb-0">

                                                            Indexed Pages

                                                        </p>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-4">

                                                <div class="card border-0 bg-light rounded-4">

                                                    <div class="card-body text-center">

                                                        <i class="bi bi-x-circle-fill"

                                                        style="font-size:38px;color:#ef4444;"></i>

                                                        <h2

                                                            id="broken"

                                                            class="fw-bold mt-3">

                                                            0

                                                        </h2>

                                                        <p class="text-muted mb-0">

                                                            Broken Links

                                                        </p>

                                                    </div>

                                                </div>

                                            </div>

                                            <div class="col-md-4">

                                                <div class="card border-0 bg-light rounded-4">

                                                    <div class="card-body text-center">

                                                        <i class="bi bi-arrow-repeat"

                                                        style="font-size:38px;color:#22c55e;"></i>

                                                        <h2

                                                            id="skipped"

                                                            class="fw-bold mt-3">

                                                            0

                                                        </h2>

                                                        <p class="text-muted mb-0">
                                                            Skipped Links
                                                        </p>

                                                    </div>

                                                </div>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                             </div>

                            </form>

                            </div>

                            </div>

                            </div>

                        </div>
    </section>


<!-- Features -->

    <section class="py-4 bg-light">

        <div class="container">

            <div class="text-center mb-5">

                <span class="badge rounded-pill px-3 py-2"
                    style="background:#eef4ff;color:#2563eb;">
                    HOW IT WORKS
                </span>

                <h2 class="fw-bold display-6 mt-3">
                    Scan your website in 3 simple steps
                </h2>

                <p class="text-muted fs-5 mx-auto" style="max-width:700px;">
                    Start scanning your website in less than a minute.
                    Our tool automatically checks every page and generates a detailed report.
                </p>

            </div>

            <div class="row g-4">

                <!-- Step 1 -->

                <div class="col-lg-4">

                    <div class="feature-card text-center">

                        <div class="feature-icon icon-blue">

                            <i class="bi bi-globe2"></i>

                        </div>

                        <div class="mt-4">

                            <span class="badge rounded-pill text-bg-primary mb-3">
                                STEP 1
                            </span>

                            <h4 class="fw-bold">
                                Enter Your Website
                            </h4>

                            <p class="text-muted">

                                Enter the URL of the website you want to analyze.
                                The scanner accepts any public website.

                            </p>

                        </div>

                    </div>

                </div>

                <!-- Step 2 -->

                <div class="col-lg-4">

                    <div class="feature-card text-center">

                        <div class="feature-icon icon-green">

                            <i class="bi bi-search"></i>

                        </div>

                        <div class="mt-4">

                            <span class="badge rounded-pill bg-success mb-3">
                                STEP 2
                            </span>

                            <h4 class="fw-bold">
                                Automatic Scan
                            </h4>

                            <p class="text-muted">

                                The crawler visits every page,
                                detects broken links,
                                redirects and inaccessible resources.

                            </p>

                        </div>

                    </div>

                </div>

                <!-- Step 3 -->

                <div class="col-lg-4">

                    <div class="feature-card text-center">

                        <div class="feature-icon icon-yellow">

                            <i class="bi bi-bar-chart-line"></i>

                        </div>

                        <div class="mt-4">

                            <span class="badge rounded-pill bg-warning text-dark mb-3">
                                STEP 3
                            </span>

                            <h4 class="fw-bold">
                                View Your Report
                            </h4>

                            <p class="text-muted">

                                Review all detected issues,
                                export your results as CSV,
                                and improve your website.

                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <section class="py-4 bg-light">
        <div class="container">
            <div class="text-center mb-5">

                <span class="badge rounded-pill px-3 py-2 mb-3"
                    style="background:#eef4ff;color:#2563eb;">
                    FEATURES
                </span>

                <h2 class="fw-bold display-6">
                    Powerful Features
                    For Better Website Monitoring
                </h2>

                <p class="text-muted fs-5 mx-auto" style="max-width:750px;">

                    Website Link Checker provides everything you need to monitor,
                    analyze and maintain your website. From detecting broken links
                    to exporting detailed reports, every feature is designed to help
                    improve your website's quality and user experience.

                </p>

            </div>

            <div class="row g-4 mt-3">

                <div class="col-md-6">

                    <div class="d-flex align-items-start">

                        <div class="feature-icon icon-blue me-4">

                            <i class="bi bi-globe2"></i>

                        </div>

                        <div>

                            <h5 class="fw-bold">

                                Complete Website Crawling

                            </h5>

                            <p class="text-muted mb-0">

                                Explore every accessible page automatically to
                                ensure that no important link is left unchecked.

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-6">

                    <div class="d-flex align-items-start">

                        <div class="feature-icon icon-red me-4">

                            <i class="bi bi-link-45deg"></i>

                        </div>

                        <div>

                            <h5 class="fw-bold">

                                Broken Link Detection

                            </h5>

                            <p class="text-muted mb-0">

                                Instantly identify invalid URLs, missing pages
                                and inaccessible resources before they affect visitors.

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-6 mt-5">

                    <div class="d-flex align-items-start">

                        <div class="feature-icon icon-green me-4">

                            <i class="bi bi-arrow-repeat"></i>

                        </div>

                        <div>

                            <h5 class="fw-bold">

                                Redirect Monitoring

                            </h5>

                            <p class="text-muted mb-0">

                                Analyze redirects and understand how your links
                                behave across your entire website.

                            </p>

                        </div>

                    </div>

                </div>

                <div class="col-md-6 mt-5">

                    <div class="d-flex align-items-start">

                        <div class="feature-icon icon-yellow me-4">
                            <i class="bi bi-file-earmark-spreadsheet"></i>
                        </div>

                        <div>

                            <h5 class="fw-bold">
                                CSV Report Export
                            </h5>

                            <p class="text-muted mb-0">
                                Download comprehensive reports containing all
                                detected issues for easier analysis and maintenance.
                            </p>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        const isAuthenticated = @json(auth()->check());
   </script>
                             
    <script>
        const form = document.getElementById("scanForm");
        const progressContainer = document.getElementById("progressContainer");
        const progressBar = document.getElementById("progressBar");
        const scanButton = document.getElementById("scanButton");

        form.addEventListener("submit", async function(e) {
            // VÉRIFICATION AUTHENTIFICATION
            if (!isAuthenticated) {
                e.preventDefault();

                const modal = new bootstrap.Modal(
                    document.getElementById('loginModal')
                );

                modal.show();

                return;
            }
            e.preventDefault();
            // PRÉPARATION DE L'INTERFACE
            progressContainer.style.display = "block";

            document.getElementById("websiteName").textContent =
                form.url.value;

            scanButton.disabled = true;

            scanButton.textContent = "Analyse en cours...";
            const formData = new FormData(form);
            try {

                let response = await fetch("/start-scan", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN":
                            document.querySelector(
                                'input[name="_token"]'
                            ).value
                    }
                });

                let start = await response.json();

                if (!start.success) {

                    alert(
                        start.message ||
                        "Impossible d'accéder au site."
                    );

                    scanButton.disabled = false;

                    scanButton.textContent =
                        "Scanner le site";

                    progressContainer.style.display =
                        "none";

                    return;
                }

                // RÉSULTAT DÉJÀ EXISTANT
                if (start.existing === true) {
                    // Afficher directement les statistiques
                    document.getElementById("indexed").textContent =
                        start.indexed;

                    document.getElementById("broken").textContent =
                        start.broken;

                    document.getElementById("skipped").textContent =
                        start.skipped;

                    progressBar.style.width = "100%";

                    progressBar.textContent =
                        "100%";


                    scanButton.textContent =
                        "Résultat trouvé";

                    setTimeout(function() {

                        window.location =
                            "/result?scan_id=" +
                            start.scan_id;

                    }, 500);


                    return;
                }

                let scanId = start.scan_id;


                    // RÉSULTAT EXISTANT
                    if (start.existing) {

                        progressContainer.style.display = "block";

                        progressBar.style.width = "100%";
                        progressBar.textContent = "100%";

                        document.getElementById("indexed").textContent = start.indexed;
                        document.getElementById("broken").textContent = start.broken;
                        document.getElementById("skipped").textContent = start.skipped;

                        scanButton.textContent = "Résultat récupéré";

                        // Aller directement au résultat
                        window.location = "/result";

                        return;
                    }

                   // NOUVEAU SCAN
                    while(true){
                    response = await fetch("/scan-step", {
                        method: "POST",
                        body: JSON.stringify({
                            scan_id: scanId
                        }),
                        headers: {

                            "Content-Type":
                                "application/json",

                            "X-CSRF-TOKEN":
                                document.querySelector(
                                    'input[name="_token"]'
                                ).value
                        }
                    });


                    let data = await response.json();


                    // ==========================================
                    // VÉRIFICATION ERREUR
                    // ==========================================

                    if (data.error) {

                        alert(data.error);

                        scanButton.disabled = false;

                        scanButton.textContent =
                            "Scanner le site";

                        break;
                    }


                    // ==========================================
                    // MISE À JOUR PROGRESSION
                    // ==========================================

                    progressBar.style.width =
                        data.progress + "%";

                    progressBar.textContent =
                        data.progress + "%";


                    document.getElementById("indexed").textContent =
                        data.indexed;

                    document.getElementById("broken").textContent =
                        data.broken;

                    document.getElementById("skipped").textContent =
                        data.skipped;


                    // ==========================================
                    // SCAN TERMINÉ
                    // ==========================================

                    if (data.finished) {

                        progressBar.style.width =
                            "100%";

                        progressBar.textContent =
                            "100%";


                        window.location =
                            "/result?scan_id=" +
                            scanId;

                        break;
                    }


                    // Petite pause avant le prochain lien

                    await new Promise(
                        resolve => setTimeout(resolve, 300)
                    );
                }


            } catch (error) {

                console.error(
                    "Erreur pendant le scan :",
                    error
                );

                alert(
                    "Une erreur est survenue pendant l'analyse."
                );

                scanButton.disabled = false;

                scanButton.textContent =
                    "Scanner le site";

                progressContainer.style.display =
                    "none";
            }

        });
    </script>



        <div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">

                <div class="modal-content login-modal">

                    <div class="modal-body text-center">

                        <div class="login-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>

                        <h3 class="login-title">
                            Connexion requise
                        </h3>

                        <p class="login-text">
                            Connectez-vous pour lancer une analyse, consulter les résultats
                            et accéder à toutes les fonctionnalités du Website Link Checker.
                        </p>

                        <a href="{{ route('login') }}" class="btn login-btn w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Se connecter
                        </a>

                        <button class="btn cancel-btn w-100 mt-3"
                                data-bs-dismiss="modal">
                            Annuler
                        </button>

                    </div>

                </div>

            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

        <script>
    document.addEventListener('DOMContentLoaded', function () {

        const button = document.getElementById('userMenuButton');
        const dropdown = document.getElementById('userDropdown');

        if (!button || !dropdown) {
            return;
        }

        button.addEventListener('click', function (event) {

            event.stopPropagation();

            dropdown.classList.toggle('show');

        });


        document.addEventListener('click', function () {

            dropdown.classList.remove('show');

        });

    });
    </script>
    </body> 

    <footer class="text-center text-muted mt-5 mb-3">
              © 2026 Website Link Checker
    </footer>
</html>
