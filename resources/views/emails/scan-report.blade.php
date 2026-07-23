<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
</head>
<body style="margin:0;padding:0;background:#f4f7fb;font-family:Arial,sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f7fb;padding:30px;">
<tr>
<td align="center">

<table width="650" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:10px;overflow:hidden;">

    <tr>
        <td style="background:#2563eb;padding:25px;text-align:center;color:white;">
            <h1 style="margin:0;">🔍 Broken Link Checker</h1>
            <p style="margin-top:8px;">Website Scan Report</p>
        </td>
    </tr>

    <tr>
        <td style="padding:30px;">

            <h2>Hello {{ $name }}, 👋</h2>

            <p>
                Your website scan has been completed successfully.
            </p>

            <table width="100%" cellpadding="12" cellspacing="0"
                   style="background:#f8fafc;border-radius:8px;">

                <tr>
                    <td><strong>🌐 Website</strong></td>
                    <td>{{ $scan->website }}</td>
                </tr>

                <tr>
                    <td><strong>✅ Indexed Links</strong></td>
                    <td>{{ $scan->indexed }}</td>
                </tr>

                <tr>
                    <td><strong>❌ Broken Links</strong></td>
                    <td>{{ $scan->broken }}</td>
                </tr>

                <tr>
                    <td><strong>⏭️ Skipped Links</strong></td>
                    <td>{{ $scan->skipped }}</td>
                </tr>

            </table>

            <br>

            <p>
                📎 Please find your detailed scan report attached.
            </p>

            <br>

            <div style="text-align:center;">

                <a href="{{ url('/') }}"
                   style="
                        background:#2563eb;
                        color:white;
                        text-decoration:none;
                        padding:14px 28px;
                        border-radius:6px;
                        display:inline-block;">
                    Visit Broken Link Checker
                </a>

            </div>

        </td>
    </tr>

    <tr>
        <td style="background:#f3f4f6;padding:20px;text-align:center;color:#666;font-size:13px;">
            © {{ date('Y') }} Broken Link Checker
        </td>
    </tr>

</table>

</td>
</tr>
</table>

</body>
</html>