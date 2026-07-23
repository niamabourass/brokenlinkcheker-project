<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body{
            font-family: DejaVu Sans;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        td,th{
            border:1px solid #ccc;
            padding:10px;
        }

        h1{
            color:#2563eb;
        }
    </style>
</head>
<body>

<h1>Broken Link Checker Report</h1>

<p><strong>User :</strong> {{ $name }}</p>

<p><strong>Website :</strong> {{ $scan->website }}</p>

<table>

<tr>
    <th>Indexed Links</th>
    <th>Broken Links</th>
    <th>Skipped Links</th>
</tr>

<tr>
    <td>{{ $scan->indexed }}</td>
    <td>{{ $scan->broken }}</td>
    <td>{{ $scan->skipped }}</td>
</tr>

</table>

@php
    $brokenLinks = is_string($scan->broken_links)
        ? json_decode($scan->broken_links, true)
        : $scan->broken_links;
@endphp

<h2 style="margin-top:30px;">Broken Links</h2>

@if(!empty($brokenLinks))

<table style="width:100%;border-collapse:collapse;">
    <tr>
        <th style="border:1px solid #ccc;padding:8px;">#</th>
        <th style="border:1px solid #ccc;padding:8px;">Broken URL</th>
        <th style="border:1px solid #ccc;padding:8px;">Status</th>
    </tr>

    @foreach($brokenLinks as $index => $link)

    <tr>
        <td style="border:1px solid #ccc;padding:8px;">
            {{ $index + 1 }}
        </td>

        <td style="border:1px solid #ccc;padding:8px;">
            {{ $link['url'] }}
        </td>

        <td style="border:1px solid #ccc;padding:8px;">
            {{ $link['status'] }}
        </td>
    </tr>

    @endforeach

</table>

@else

<p>No broken links found.</p>

@endif

</body>
</html>