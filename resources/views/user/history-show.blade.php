<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Détails du scan</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        body {
            background: #f8fbff;
            font-family: Arial, sans-serif;
        }

        .container-page {
            max-width: 1100px;
            margin: 50px auto;
        }

        .header {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            margin-bottom: 25px;
        }

        .website {
            font-size: 22px;
            font-weight: 600;
            color: #1f2937;
            word-break: break-all;
        }

        .date {
            color: #6b7280;
            font-size: 14px;
        }

        .stat-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 25px;
            text-align: center;
        }

        .stat-number {
            font-size: 30px;
            font-weight: 700;
        }

        .indexed {
            color: #2563eb;
        }

        .broken {
            color: #dc2626;
        }

        .skipped {
            color: #6b7280;
        }

        .broken-section {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 25px;
            margin-top: 25px;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            padding: 9px 16px;
            border-radius: 7px;
            background: #e0efff;
            color: #2563eb;
            text-decoration: none;
        }

        .back-btn:hover {
            background: #dbeafe;
            color: #1d4ed8;
        }
    </style>
</head>


<body>
    <div class="container container-page">
        <!-- Retour -->
        <a
            href="{{ route('user.history') }}"
            class="back-btn">
            ← Retour à l'historique
        </a>

        <!-- Informations du scan -->
        <div class="header">
            <div class="website">
                🌐 {{ $website }}
            </div>

            <div class="date mt-2">
                Scan effectué le
                {{ $updated ? $updated->format('d/m/Y à H:i') : '-' }}
            </div>
        </div>

        <!-- Statistiques -->

        <div class="row g-4">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-number indexed">
                        {{ $indexed }}
                    </div>
                    <div>
                        Indexed Links
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-number broken">
                        {{ count($brokenLinks) }}
                    </div>
                    <div>
                        Broken Links
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-number skipped">
                        {{ $skipped }}
                    </div>
                    <div>
                        Skipped
                    </div>
                </div>
            </div>
        </div>


        <!-- Broken Links -->
        <div class="broken-section">
            <h4 class="mb-4">
                Broken Links
            </h4>

            @if(count($brokenLinks) > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>URL</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($brokenLinks as $link)
                                <tr>
                                    <td style="word-break: break-all;">
                                        {{ $link['url'] ?? '-' }}
                                    </td>

                                    <td>
                                        <span class="badge bg-danger">
                                            {{ $link['status'] ?? '-' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            @else
                <div class="alert alert-success mb-0">
                    Aucun lien cassé trouvé. 🎉
                </div>
            @endif
        </div>
    </div>
</body>
</html>