<!DOCTYPE html>
<html>
<head>
    <title>Détails du scan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
        <div class="max-w-5xl mx-auto bg-white rounded-lg shadow p-6">

            <h1 class="text-2xl font-bold mb-4">
                Détails du scan
            </h1>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div class="rounded-2xl border border-blue-100 bg-blue-50 p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-100">
                        🌐
                    </div>
                    <div>
                        <p class="text-sm text-blue-500 font-medium">
                            Site analysé
                        </p>
                    </div>
                </div>
                <a href="{{ $scan->website }}"
                target="_blank"
                class="font-semibold text-gray-800 hover:text-blue-600 break-all">
                    {{ $scan->website }}
                </a>
        </div>

            <div class="rounded-2xl border border-purple-100 bg-purple-50 p-5 shadow-sm">

                <div class="flex items-center gap-3 mb-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-purple-100">
                        📅
                    </div>

                    <div>
                        <p class="text-sm text-purple-500 font-medium">
                            Date du scan
                        </p>
                    </div>

                </div>

                <p class="font-semibold text-gray-800">
                    {{ $scan->created_at->format('d/m/Y H:i') }}
                </p>
            </div>

            <div class="rounded-2xl border border-red-200 bg-red-50 p-5 shadow-sm">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-100">
                        🚨
                    </div>
                    <div>
                        <p class="text-sm text-red-500 font-medium">
                            Liens cassés détectés
                        </p>
                    </div>
                </div>
                <p class="text-4xl font-bold text-red-600">
                    {{ $scan->broken }}
                </p>
            </div>
        </div>


    <h1 class="text-2xl font-bold mb-4">
        Liste des liens cassés
    </h1>


    @if(count($brokenLinks) > 0)

        <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm">
          <table class="w-full">

            <thead class="bg-gray-50">
                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        URL
                    </th>

                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-600">
                        Statut
                    </th>
                </tr>
            </thead>


            <tbody>

            @foreach($brokenLinks as $link)

                <tr class="border-t border-gray-100 hover:bg-gray-50 transition">
                    <td class="px-6 py-4">
                        <a href="{{ $link['url'] ?? '#' }}"
                            target="_blank"
                            class="font-bold text-blue-600 hover:underline">
                            {{ $link['url'] ?? 'Inconnu' }}
                        </a>
                    </td>

                    <td class="px-6 py-4">
                        <span class="rounded-full bg-red-100 px-3 py-1 text-sm font-bold text-red-600">
                            {{ $link['status'] ?? 'Erreur' }}
                        </span>
                    </td>
                </tr>

            @endforeach

            </tbody>

        </table>


    @else

        <p class="text-green-600">
            Aucun lien cassé trouvé 
        </p>

    @endif


    <a href="/admin" class="inline-flex items-center gap-2 mt-6 rounded-xl bg-blue-600 px-5 py-3 font-medium text-white transition hover:bg-blue-700">
        Retour Dashboard
    </a>

</div>

</body>
</html>