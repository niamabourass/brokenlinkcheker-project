<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> Résultat du scan </title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
          body{
               background:#eef3f8;
               font-family:Arial, sans-serif;
          }

          .container{
              max-width:1100px;
          }

          .card{
            border:none;
            border-radius:15px;
            box-shadow:0 4px 15px rgba(14, 14, 14, 0.08);
          }

          .table td{
             vertical-align:middle;
          }

          .table a{
            word-break:break-all;
            text-decoration:none;
            color:#0d6efd;
            font-weight:500;
          }

          .table a:hover{
            text-decoration:underline;
            color:#084298;
          }       
        </style>
    </head>       
    <body>
      <div class="container mt-5">   <!--centre le cont et marge en haut-->
        <h1 class="display-5 fw-bold text-primary text-center"> 
          Website Scan Report 
        </h1>
        <p class="text-center text-muted mb-4">
          Analyse terminée avec succès
        </p>
        <h2>Sitemap for {{ parse_url($website, PHP_URL_HOST) }}</h2>  <!--pour afficher que Sitemap for www.google.com-->
        <hr>
          <div class="card shadow-sm mb-4">
            <div class="card-body">
              <h5> <strong>Informations </strong></h5>
              <p>
                <strong> Website: </strong>
                    {{$website}}
              </p>
              <p>
                <strong>Dernière analyse: </strong>
                    {{$updated}}
              </p>
            </div>  
          </div>
          <div class="row text-center mt-4">
            <div class="col-md-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5>Pages indexées </h5>
                  <h1 class="text-primary fw-bold">
                    {{$indexed}}
                  </h1>
                </div> 
              </div>  
            </div>
          
            <div class="col-md-4">
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5> Pages ignorées </h5>
                  <h1 class="text-warning fw-bold">
                    {{$skipped}}
                  </h1>
                </div>  
              </div>  
            </div> 
            <div class="col-md-4">  <!--Decoupe la ligne en 3 col egaux-->
              <div class="card shadow-sm">
                <div class="card-body">
                  <h5> Liens cassés </h5>
                  <h1 class="text-danger fw-bold">
                    {{count($brokenLinks)}}
                  </h1>
                </div>
              </div>
            </div>
          </div>  
          <hr>
          
        @if(count($brokenLinks))
        <div class="card shadow">
          <div class="card-header">
            <h4> Broken Links </h4>
          </div>
          <div class="card-body">
           <div class="table-responsive">
            <table class="table table-hover align-middle">
              <thead class="table-primary">
                <tr>
                  <th width="85%">URL</th>
                  <th class="text-center">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($brokenLinks as $link)
                <tr>
                 <td>
                    <a href="{{$link['url']}}" target="_blank">
                      {{$link['url']}}  
                    </a>
                  </td>
                  <td class="text-center">
                    @if($link['status']==404)
                    <span class="badge bg-danger">
                           404
                    </span>
                    @elseif($link['status']==500)
                    <span class="badge bg-warning text-dark">
                               500
                    </span>
                    @elseif($link['status']==0)
                    <span class="badge bg-danger">
                        Aucun retour HTTP
                    </span>
                    @else
                    <span class="badge bg-secondary">
                         {{$link['status']}}
                    </span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table> 
          </div>
            <div class="text-center mt-4">
                <a href="{{ url('/export-csv') }}"
                  class="btn btn-success me-2">
                    📄 Exporter en CSV
                </a>
                <button
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#sendReportModal">

                    📧 Send Report
                </button>
            </div>
          </div> 
        </div> 
        @else 
        <div class="alert alert-success">
          Aucun lien cassé trouvé.
        </div> 
        @endif  
        <br>
        <div class="text-center mt-4">
          <a href="{{ route('admin.new-scan') }}" class="btn btn-primary btn-lg rounded-pill px-4">
              Nouvelle analyse
          </a>
        </div>  
      </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

      <!-- Modal Send Report -->

      <div class="modal fade" id="sendReportModal" tabindex="-1">
          <div class="modal-dialog">
              <div class="modal-content">
                  <form method="POST" action="{{ route('send.report') }}">
                      @csrf

                      <div class="modal-header">

                          <h5 class="modal-title">
                              Send Scan Report
                          </h5>
                          <button
                              type="button"
                              class="btn-close"
                              data-bs-dismiss="modal">
                          </button>

                      </div>

                      <div class="modal-body">
                          <div class="mb-3">
                              <label>Your Name</label>
                              <input
                                  type="text"
                                  name="name"
                                  class="form-control"
                                  required>
                          </div>

                          <div class="mb-3">
                              <label>Email Address</label>
                              <input
                                  type="email"
                                  name="email"
                                  class="form-control"
                                  required>
                          </div>
                      </div>

                      <div class="modal-footer">
                          <button
                              type="submit"
                              class="btn btn-primary">
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

