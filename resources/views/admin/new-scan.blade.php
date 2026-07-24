<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Website Link Chekher</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    </head> 
    <body style="background:linear-gradient(135deg,#f5f5f5,#ffffff);min-height:100vh;">       
         <nav class="navbar navbar-expand-lg navbar-dark shadow" style="background:#2d3748;"> 
           <div class="container">
              <a class="navbar-brand fw-bold" href="/">
                   Website Link Checker
              </a>
            </div>
        </nav>

        <div class="container d-flex justify-content-center align-items-center" style="min-height:85vh;">
                <div class="col-lg-7 col-md-9"> 
                    <div class="card border-0 shadow-lg rounded-4" style="background:#ffffff;">
                        <div class="card-body p-5"> 
                            <div class="text-center mb-3">
                               <i class="bi bi-globe2" style="font-size:60px;color:#4a5568;"></i>
                            </div>
                            <h1 class="text-center mb-4 fw-bold" style="color:#2d3748;"> 
                                Website Link Cheker 
                            </h1> 
                            <p class="text-center text-muted">   
                                Analysez automatiquement tous les liens d'un site web.
                            </p>
                            <form id="scanForm"  method="POST" action="/check-url-statut">
                                @csrf 
                                <div class="mb-3">
                                    <div class="alert border-0 mb-4"
                                        style="background:#ecfeff;color:#0f766e;">
                                        <i class="bi bi-shield-check me-2"></i>
                                        Mode Administrateur activé
                                    </div>

                                    <label class="form-label">
                                        URL du site 
                                    </label>    
                                    <input type="url" name="url" class="form-control form-control-lg rounded-3" placeholder="https://example.com" required>
                                </div>
                                
                                <div class="d-grid">
                                    <button id="scanButton" type="submit" class="btn btn-lg rounded-3 fw-bold text-white" style="background:#4a5568;border:none;">                                        <i class="bi bi-search me-2"></i>      
                                            Scanner le site 
                                    </button>
                                </div>
                                <div id="progressContainer" class="mt-5" style="display:none;">
                                    <div class="card shadow-lg border-0">
                                        <div class="card-body p-5">
                                            <h3 class="text-center mb-4">
                                                Analyse du site en cours ...
                                            </h3>
                                            <p class="text-center">
                                                <strong id="websiteName"></strong>
                                            </p>
                                            <div class="progress mb-4" style="height:30px;border-radius:20px;">
                                                <div  id="progressBar"  class="progress-bar progress-bar-striped progress-bar-animated"  style="background:#38a169;width:0%;font-size:18px;">
                                                      0%
                                                </div>
                                            </div> 
                                            <div class="row text-center">
                                                <div class="col">
                                                    <h2 id="indexed"> 0 </h2>
                                                    <small> Pages indexées </small>
                                                </div>  
                                                <div class="col">
                                                    <h2 id="broken"> 0 </h2>
                                                    <small>Liens cassées </small>
                                                </div>  
                                                <div class="col">
                                                    <h2 id="skipped">0 </h2>
                                                    <small> Ignorées </small>
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
        </div> 

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

                let response = await fetch("/admin/start-scan",{
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

                    response = await fetch("/admin/scan-step",{
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

                        window.location = "/admin/result?scan_id=" + scanId;
                        break;
                    }

                    await new Promise(resolve => setTimeout(resolve, 300));
                }
            });
        </script>

        <div class="text-center mt-4 mb-4">
            <a href="/admin"
            class="btn text-white rounded-pill px-5 py-2 shadow"
            style="background:#1E293B;">
                <i class="bi bi-arrow-left me-2"></i>
                Retour au Dashboard
            </a>
        </div>
    </body> 
    <footer class="text-center text-muted mt-5 mb-3">
              © 2026 Website Link Checker
    </footer>
</html>
