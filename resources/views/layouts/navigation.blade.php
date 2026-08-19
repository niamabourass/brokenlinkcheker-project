<nav class="bg-white border-b border-gray-200">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="flex justify-between items-center h-16">

            {{-- Logo / Home --}}
            <div class="flex items-center">

                <a
                    href="{{ url('/') }}"
                    class="text-xl font-semibold text-blue-600">

                    Broken Link Checker

                </a>

            </div>


            {{-- Navigation utilisateur --}}
            @auth

                <div class="flex items-center gap-3">

                    {{-- MENU ☰ --}}
                    <div class="relative">

                        <button
                            type="button"
                            id="userMenuButton"
                            class="flex items-center justify-center
                                   w-10 h-10
                                   rounded-md
                                   bg-white
                                   border border-gray-300
                                   text-gray-600
                                   hover:bg-gray-100
                                   focus:outline-none">

                            <span class="text-2xl leading-none">
                                ☰
                            </span>

                        </button>


                        {{-- DROPDOWN --}}
                        <div
                            id="userMenuDropdown"
                            class="hidden absolute right-0 top-12
                                   w-56
                                   bg-white
                                   border border-gray-200
                                   rounded-lg
                                   shadow-lg
                                   z-50">

                            {{-- Informations utilisateur --}}
                            <div class="px-4 py-3 border-b border-gray-100">

                                <div class="font-medium text-sm text-gray-800">
                                    {{ Auth::user()->name }}
                                </div>

                                <div class="text-xs text-gray-500 mt-1">
                                    {{ Auth::user()->email }}
                                </div>

                            </div>


                            {{-- Historique --}}
                            <a
                                href="{{ route('user.history') }}"
                                class="flex items-center gap-3
                                       px-4 py-3
                                       text-sm text-gray-700
                                       hover:bg-gray-100">

                                <span>📋</span>

                                <span>
                                    Historique
                                </span>

                            </a>


                            {{-- Profile --}}
                            <a
                                href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3
                                       px-4 py-3
                                       text-sm text-gray-700
                                       hover:bg-gray-100">

                                <span>👤</span>

                                <span>
                                    Profile
                                </span>

                            </a>

                        </div>

                    </div>


                    {{-- LOGOUT --}}
                    <form
                        method="POST"
                        action="{{ route('logout') }}">

                        @csrf

                        <button
                            type="submit"
                            class="px-4 py-2
                                   rounded-md
                                   text-sm font-medium
                                   text-gray-600
                                   bg-white
                                   border border-gray-300
                                   hover:bg-gray-100">

                            Logout

                        </button>

                    </form>

                </div>

            @endauth

        </div>

    </div>

</nav>


{{-- JavaScript du menu --}}
<script>

document.addEventListener('DOMContentLoaded', function () {

    const button = document.getElementById('userMenuButton');

    const dropdown = document.getElementById('userMenuDropdown');


    if (!button || !dropdown) {
        return;
    }


    button.addEventListener('click', function (event) {

        event.stopPropagation();

        dropdown.classList.toggle('hidden');

    });


    document.addEventListener('click', function () {

        dropdown.classList.add('hidden');

    });

});

</script>