<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #111827;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2563eb;
            margin: 0;
            font-size: 28px;
        }

        .subtitle {
            color: #6b7280;
            margin-top: 8px;
        }

        .section {
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            color: #111827;
        }

        .stats {
            width: 100%;
            border-collapse: collapse;
        }

        .stats td {
            border: 1px solid #e5e7eb;
            padding: 10px;
        }

        .stats td:first-child {
            font-weight: bold;
            width: 220px;
        }

        table.report {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table.report th {
            background: #2563eb;
            color: white;
            padding: 10px;
            text-align: left;
        }

        table.report td {
            border: 1px solid #e5e7eb;
            padding: 8px;
        }

        table.report tr:nth-child(even) {
            background: #f9fafb;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            color: #6b7280;
            font-size: 11px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>BROKEN LINK CHECKER</h1>
        <div class="subtitle">Administrator Export Report</div>
    </div>

    <div class="section">
        <div class="section-title">Administrator Information</div>

        <table class="stats">
            <tr>
                <td>Administrator Name</td>
                <td>{{ $settings->admin_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Administrator Email</td>
                <td>{{ $settings->admin_email ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Generated On</td>
                <td>{{ now()->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Global Statistics</div>

        <table class="stats">
            <tr>
                <td>Total Scans</td>
                <td>{{ $stats['totalScans'] }}</td>
            </tr>
            <tr>
                <td>Indexed Links</td>
                <td>{{ $stats['indexed'] }}</td>
            </tr>
            <tr>
                <td>Broken Links</td>
                <td>{{ $stats['broken'] }}</td>
            </tr>
            <tr>
                <td>Skipped Links</td>
                <td>{{ $stats['skipped'] }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Scan History</div>

        <table class="report">
            <thead>
                <tr>
                    <th>Website</th>
                    <th>Indexed</th>
                    <th>Broken</th>
                    <th>Skipped</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($scans as $scan)
                    <tr>
                        <td>{{ $scan->website }}</td>
                        <td>{{ $scan->indexed }}</td>
                        <td>{{ $scan->broken }}</td>
                        <td>{{ $scan->skipped }}</td>
                        <td>{{ $scan->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        Broken Link Checker — Generated automatically by the administration dashboard.
    </div>

</body>
</html>