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
            background:#f8fbff;
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
            font-size:58px;
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
            border:none;
            border-radius:30px;
            box-shadow:0 20px 60px rgba(0,0,0,.08);
            padding:20px;
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

            position:relative;

            background:#fff;

            border:1px solid #e5e7eb;

            border-radius:22px;

            padding:40px 30px;

            text-align:center;

            height:100%;

            transition:.35s;

        }

        .step-card:hover{

            transform:translateY(-8px);

            border-color:#d1d5db;

            box-shadow:0 15px 35px rgba(0,0,0,.08);

        }

        .step-icon{

            width:72px;

            height:72px;

            margin:auto;

            border-radius:18px;

            background:#f3f4f6;

            color:#374151;

            display:flex;

            justify-content:center;

            align-items:center;

            font-size:30px;

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
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg sticky-top">

        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center" href="/">
                <div class="logo-box">
                    <i class="bi bi-link-45deg"></i>
                </div>

                <span class="ms-3">
                    Website Link Checker
                </span>

            </a>
            <!-- Admin -->

            <a href="/admin" class="admin-btn">
                <i class="bi bi-person-circle me-2"></i>
                  Admin
            </a>

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

                        <div class="card-body p-5">

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

    <section class="py-5 bg-light">

        <div class="container">

            <div class="text-center mb-5">

                <span class="badge rounded-pill px-3 py-2"
                    style="background:#eef4ff;color:#2563eb;">
                    HOW IT WORKS
                </span>

                <h2 class="fw-bold display-5 mt-3">
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

    <section class="py-5 bg-light">
        <div class="container">
            <div class="text-center mb-5">

                <span class="badge rounded-pill px-3 py-2 mb-3"
                    style="background:#eef4ff;color:#2563eb;">
                    FEATURES
                </span>

                <h2 class="fw-bold display-5">
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
            const form = document.getElementById("scanForm");
            const progressContainer = document.getElementById("progressContainer");
            const progressBar = document.getElementById("progressBar");
            const scanButton = document.getElementById("scanButton");

            form.addEventListener("submit", async function(e){

                e.preventDefault();

                progressContainer.style.display = "block";
                document.getElementById("websiteName").textContent = form.url.value;

                scanButton.disabled = true;
                scanButton.textContent = "Analyse en cours...";

                const formData = new FormData(form);

                let response = await fetch("/start-scan",{
                    method:"POST",
                    body:formData,
                    headers:{
                        "X-CSRF-TOKEN":document.querySelector('input[name="_token"]').value
                    }
                });

                let start = await response.json();

                if(!start.success){
                    alert("Impossible d'accéder au site.");
                    scanButton.disabled = false;
                    scanButton.textContent = "Scanner le site";
                    return;
                }

                let scanId = start.scan_id;

                while(true){

                    response = await fetch("/scan-step",{
                        method:"POST",
                        body:JSON.stringify({
                            scan_id: scanId
                        }),
                        headers:{
                            "Content-Type":"application/json",
                            "X-CSRF-TOKEN":document.querySelector('input[name="_token"]').value
                        }
                    });

                    let data = await response.json();

                    progressBar.style.width = data.progress + "%";
                    progressBar.textContent = data.progress + "%";

                    document.getElementById("indexed").textContent = data.indexed;
                    document.getElementById("broken").textContent = data.broken;
                    document.getElementById("skipped").textContent = data.skipped;

                    if(data.finished){

                        progressBar.style.width = "100%";
                        progressBar.textContent = "100%";

                        window.location = "/result?scan_id=" + scanId;
                        break;
                    }

                    await new Promise(resolve => setTimeout(resolve, 300));
                }
            });
        </script>
    </body> 

    <footer class="text-center text-muted mt-5 mb-3">
              © 2026 Website Link Checker
    </footer>
</html>
