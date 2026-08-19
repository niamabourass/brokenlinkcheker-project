<!DOCTYPE html>
<html lang="fr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Historique des scans</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <style>

        body {
            background: #f8fbff;
            font-family: Arial, sans-serif;
        }

        .history-container {
            max-width: 1100px;
            margin: 60px auto;
        }

        .history-title {
            margin-bottom: 35px;
        }

        .scan-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 22px;
            margin-bottom: 18px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.04);
        }

        .website {
            font-size: 19px;
            font-weight: 600;
            color: #1f2937;
        }

        .date {
            font-size: 13px;
            color: #6b7280;
        }

        .stat {
            text-align: center;
            padding: 10px;
        }

        .stat-number {
            font-size: 22px;
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

        .details-btn {
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 7px;
            padding: 9px 16px;
            text-decoration: none;
            display: inline-block;
        }

        .details-btn:hover {
            background: #1d4ed8;
            color: white;
        }

        .new-scan-btn {
            background: #e0efff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            border-radius: 7px;
            padding: 9px 16px;
            text-decoration: none;
        }

        .scan-date {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 6px;
            background-color: #f1f5f9;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
        }

    </style>

</head>


<body>

<div class="container history-container">

    <div class="d-flex justify-content-between align-items-center history-title">

        <div>
            <h2>
                Historique des scans
            </h2>

            <p class="text-muted mb-0">
                Voici les sites que vous avez scannés.
            </p>
        </div>

        <a
            href="{{ url('/') }}"
            class="new-scan-btn">
            ← Retour au scan
        </a>
    </div>


    @if($scans->count() > 0)
        @foreach($scans as $scan)
            <div class="scan-card">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <div class="website">

                            🌐 {{ $scan->website }}

                        </div>

                        <div class="date mt-2">
                            <span class="scan-date">
                                🕒 Scanné le
                                <strong>{{ $scan->created_at->format('d/m/Y à H:i') }}</strong>
                            </span>
                        </div>

                    </div>


                    <a
                        href="{{ route('user.history.show', $scan->id) }}"
                        class="details-btn">

                        Voir détails

                    </a>

                </div>


                <hr>


                <div class="row">

                    <div class="col-md-4 stat">

                        <div class="stat-number indexed">

                            {{ $scan->indexed }}

                        </div>

                        <div>

                            Indexed Links

                        </div>

                    </div>


                    <div class="col-md-4 stat">

                        <div class="stat-number broken">

                            {{ $scan->broken }}

                        </div>

                        <div>

                            Broken Links

                        </div>

                    </div>


                    <div class="col-md-4 stat">

                        <div class="stat-number skipped">

                            {{ $scan->skipped }}

                        </div>

                        <div>

                            Skipped

                        </div>

                    </div>

                </div>

            </div>

        @endforeach


    @else

        <div class="alert alert-info">

            Vous n'avez encore effectué aucun scan.

        </div>

    @endif

</div>

</body>

</html>