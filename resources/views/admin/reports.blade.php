<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport"  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>
          Historique des Scans | BLC Dashboard
    </title>
    <link rel="icon" href="favicon.ico">
    <link rel="stylesheet" href="{{ asset('admin_old/style.css') }}">
  </head>

    <body
        x-data="{ page: 'ecommerce', 'loaded': true, 'darkMode': false, 'stickyMenu': false, 'sidebarToggle': false, 'scrollTop': false }"
        x-init="
            darkMode = JSON.parse(localStorage.getItem('darkMode'));
            $watch('darkMode', value => localStorage.setItem('darkMode', JSON.stringify(value)))"
        :class="{'dark bg-gray-900': darkMode === true}"
    >
        <!-- ===== Preloader Start ===== -->
        <div
    x-show="loaded"
    x-init="window.addEventListener('DOMContentLoaded', () => {setTimeout(() => loaded = false, 500)})"
    class="fixed left-0 top-0 z-999999 flex h-screen w-screen items-center justify-center bg-white dark:bg-black"
    >
    <div
        class="h-16 w-16 animate-spin rounded-full border-4 border-solid border-brand-500 border-t-transparent"
    ></div>
    </div>

    <!-- ===== Preloader End ===== -->

    <!-- ===== Page Wrapper Start ===== -->
    <div class="flex h-screen overflow-hidden">
      <!-- ===== Sidebar Start ===== -->
      <aside
  :class="sidebarToggle ? 'translate-x-0 lg:w-[90px]' : '-translate-x-full'"
  class="sidebar fixed left-0 top-0 z-9999 flex h-screen w-[290px] flex-col overflow-y-hidden border-r border-gray-200 bg-white px-5 dark:border-gray-800 dark:bg-black lg:static lg:translate-x-0"
>
  <!-- SIDEBAR HEADER -->
  <div
    :class="sidebarToggle ? 'justify-center' : 'justify-between'"
    class="flex items-center gap-2 pt-8 sidebar-header pb-7"
  >
    <a href="{{ url('/admin') }}">
        <div class="flex items-center gap-2">
           <div class="flex flex-col">
                <span class="text-xl font-bold text-brand-600">
                    Broken Link Checker
                </span>

                <span class="text-xs text-gray-500">
                    Administration Panel
                </span>
            </div>
        </div>
    </a>
  </div>
  <!-- SIDEBAR HEADER -->

  <div
    class="flex flex-col overflow-y-auto duration-300 ease-linear no-scrollbar"
  >
    <!-- Sidebar Menu -->
    <nav x-data="{selected: $persist('Dashboard')}">
      <!-- Menu Group -->
      <div>
        <h3 class="mb-4 text-xs uppercase leading-[20px] text-gray-400">
          <span
            class="menu-group-title"
            :class="sidebarToggle ? 'lg:hidden' : ''"
          >
            MENU
          </span>

          <svg
            :class="sidebarToggle ? 'lg:block hidden' : 'hidden'"
            class="mx-auto fill-current menu-group-icon"
            width="24"
            height="24"
            viewBox="0 0 24 24"
            fill="none"
            xmlns="http://www.w3.org/2000/svg"
          >
            <path
              fill-rule="evenodd"
              clip-rule="evenodd"
              d="M5.99915 10.2451C6.96564 10.2451 7.74915 11.0286 7.74915 11.9951V12.0051C7.74915 12.9716 6.96564 13.7551 5.99915 13.7551C5.03265 13.7551 4.24915 12.9716 4.24915 12.0051V11.9951C4.24915 11.0286 5.03265 10.2451 5.99915 10.2451ZM17.9991 10.2451C18.9656 10.2451 19.7491 11.0286 19.7491 11.9951V12.0051C19.7491 12.9716 18.9656 13.7551 17.9991 13.7551C17.0326 13.7551 16.2491 12.9716 16.2491 12.0051V11.9951C16.2491 11.0286 17.0326 10.2451 17.9991 10.2451ZM13.7491 11.9951C13.7491 11.0286 12.9656 10.2451 11.9991 10.2451C11.0326 10.2451 10.2491 11.0286 10.2491 11.9951V12.0051C10.2491 12.9716 11.0326 13.7551 11.9991 13.7551C12.9656 13.7551 13.7491 12.9716 13.7491 12.0051V11.9951Z"
              fill=""
            />
          </svg>
        </h3>

        <ul class="flex flex-col gap-3 mb-6">

    <li>
        <a href="{{ url('/admin') }}"
           style="background:#EEF2FF !important; border:1px solid #C7D2FE !important;"
           class="group flex items-center gap-4 rounded-2xl border border-indigo-100 bg-indigo-50 px-4 py-4 shadow-sm transition-all duration-300 hover:shadow-md">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white shadow-sm">
                <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-6m4 6V7m4 10V4M3 20h18"/>
                </svg>
            </div>

            <span class="font-semibold text-gray-800">Tableau de bord</span>
        </a>
    </li>

    <li>
        <a href="{{ url('/') }}"
           style="background:#ECFEFF !important; border:1px solid #A5F3FC !important;"
           class="group flex items-center justify-between rounded-2xl border border-gray-100 bg-white px-4 py-4 shadow-sm transition-all duration-300 hover:border-cyan-200 hover:shadow-md">

            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-cyan-50">
                    <svg class="h-6 w-6 text-cyan-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z"/>
                    </svg>
                </div>

                <span class="font-medium text-gray-800">Nouveau Scan</span>
            </div>

            <span class="text-gray-400">›</span>
        </a>
    </li>

    <li>
        <a href="{{ url('/admin/scans') }}"
           style="background:#F3E8FF !important; border:1px solid #D8B4FE !important;"
           class="group flex items-center justify-between rounded-2xl border border-gray-100 bg-white px-4 py-4 shadow-sm transition-all duration-300 hover:border-purple-200 hover:shadow-md">

            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50">
                    <svg class="h-6 w-6 text-purple-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

                <span class="font-medium text-gray-800">Historique des Scans</span>
            </div>

            <span class="text-gray-400">›</span>
        </a>
    </li>

    <li>
        <a href="{{ url('/admin/broken-links') }}"
           style="background:#FEF2F2 !important; border:1px solid #FECACA !important;"
           class="group flex items-center justify-between rounded-2xl border border-gray-100 bg-white px-4 py-4 shadow-sm transition-all duration-300 hover:border-red-200 hover:shadow-md">

            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50">
                    <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 14L8 16a4 4 0 01-6-6l2-2m10 2l2-2a4 4 0 116 6l-2 2M8 12h8"/>
                    </svg>
                </div>

                <span class="font-medium text-gray-800">Liens Cassés</span>
            </div>

            <span class="text-gray-400">›</span>
        </a>
    </li>

    <li>
        <a href="{{ url('/admin/reports') }}"
           style="background:#ECFDF5 !important; border:1px solid #A7F3D0 !important;"
           class="group flex items-center justify-between rounded-2xl border border-gray-100 bg-white px-4 py-4 shadow-sm transition-all duration-300 hover:border-green-200 hover:shadow-md">

            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50">
                    <svg class="h-6 w-6 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6M9 8h6m2-5H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2V7l-4-4z"/>
                    </svg>
                </div>

                <span class="font-medium text-gray-800">Rapports</span>
            </div>

            <span class="text-gray-400">›</span>
        </a>
    </li>

    <li>
        <a href="{{ url('/admin/settings') }}"
           style="background:#FFF7ED !important; border:1px solid #FED7AA !important;"
           class="group flex items-center justify-between rounded-2xl border border-gray-100 bg-white px-4 py-4 shadow-sm transition-all duration-300 hover:border-slate-200 hover:shadow-md">

            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-50">
                    <svg class="h-6 w-6 text-slate-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8a4 4 0 100 8 4 4 0 000-8z"/>
                    </svg>
                </div>

                <span class="font-medium text-gray-800">Paramètres</span>
            </div>

            <span class="text-gray-400">›</span>
        </a>
    </li>

</ul>
      </div>
    </nav>
    <!-- Sidebar Menu -->
  </div>
</aside>

      <!-- ===== Sidebar End ===== -->

      <!-- ===== Content Area Start ===== -->
      <div
        class="relative flex flex-col flex-1 overflow-x-hidden overflow-y-auto"
      >
        <!-- Small Device Overlay Start -->
        <div
  @click="sidebarToggle = false"
  :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
  class="fixed w-full h-screen z-9 bg-gray-900/50"
></div>
<!-- Small Device Overlay End -->

        <!-- ===== Header Start ===== -->
        <header
  x-data="{menuToggle: false}"
  class="sticky top-0 z-99999 flex w-full border-gray-200 bg-white lg:border-b dark:border-gray-800 dark:bg-gray-900"
>
  <div
    class="flex grow flex-col items-center justify-between lg:flex-row lg:px-6"
  >
    <div
      class="flex w-full items-center justify-between gap-2 border-b border-gray-200 px-3 py-3 sm:gap-4 lg:justify-normal lg:border-b-0 lg:px-0 lg:py-4 dark:border-gray-800"
    >
      <!-- Hamburger Toggle BTN -->
      <button
        :class="sidebarToggle ? 'lg:bg-transparent dark:lg:bg-transparent bg-gray-100 dark:bg-gray-800' : ''"
        class="z-99999 flex h-10 w-10 items-center justify-center rounded-lg border-gray-200 text-gray-500 lg:h-11 lg:w-11 lg:border dark:border-gray-800 dark:text-gray-400"
        @click.stop="sidebarToggle = !sidebarToggle"
      >
        <svg
          class="hidden fill-current lg:block"
          width="16"
          height="12"
          viewBox="0 0 16 12"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M0.583252 1C0.583252 0.585788 0.919038 0.25 1.33325 0.25H14.6666C15.0808 0.25 15.4166 0.585786 15.4166 1C15.4166 1.41421 15.0808 1.75 14.6666 1.75L1.33325 1.75C0.919038 1.75 0.583252 1.41422 0.583252 1ZM0.583252 11C0.583252 10.5858 0.919038 10.25 1.33325 10.25L14.6666 10.25C15.0808 10.25 15.4166 10.5858 15.4166 11C15.4166 11.4142 15.0808 11.75 14.6666 11.75L1.33325 11.75C0.919038 11.75 0.583252 11.4142 0.583252 11ZM1.33325 5.25C0.919038 5.25 0.583252 5.58579 0.583252 6C0.583252 6.41421 0.919038 6.75 1.33325 6.75L7.99992 6.75C8.41413 6.75 8.74992 6.41421 8.74992 6C8.74992 5.58579 8.41413 5.25 7.99992 5.25L1.33325 5.25Z"
            fill=""
          />
        </svg>

        <svg
          :class="sidebarToggle ? 'hidden' : 'block lg:hidden'"
          class="fill-current lg:hidden"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M3.25 6C3.25 5.58579 3.58579 5.25 4 5.25L20 5.25C20.4142 5.25 20.75 5.58579 20.75 6C20.75 6.41421 20.4142 6.75 20 6.75L4 6.75C3.58579 6.75 3.25 6.41422 3.25 6ZM3.25 18C3.25 17.5858 3.58579 17.25 4 17.25L20 17.25C20.4142 17.25 20.75 17.5858 20.75 18C20.75 18.4142 20.4142 18.75 20 18.75L4 18.75C3.58579 18.75 3.25 18.4142 3.25 18ZM4 11.25C3.58579 11.25 3.25 11.5858 3.25 12C3.25 12.4142 3.58579 12.75 4 12.75L12 12.75C12.4142 12.75 12.75 12.4142 12.75 12C12.75 11.5858 12.4142 11.25 12 11.25L4 11.25Z"
            fill=""
          />
        </svg>

        <!-- cross icon -->
        <svg
          :class="sidebarToggle ? 'block lg:hidden' : 'hidden'"
          class="fill-current"
          width="24"
          height="24"
          viewBox="0 0 24 24"
          fill="none"
          xmlns="http://www.w3.org/2000/svg"
        >
          <path
            fill-rule="evenodd"
            clip-rule="evenodd"
            d="M6.21967 7.28131C5.92678 6.98841 5.92678 6.51354 6.21967 6.22065C6.51256 5.92775 6.98744 5.92775 7.28033 6.22065L11.999 10.9393L16.7176 6.22078C17.0105 5.92789 17.4854 5.92788 17.7782 6.22078C18.0711 6.51367 18.0711 6.98855 17.7782 7.28144L13.0597 12L17.7782 16.7186C18.0711 17.0115 18.0711 17.4863 17.7782 17.7792C17.4854 18.0721 17.0105 18.0721 16.7176 17.7792L11.999 13.0607L7.28033 17.7794C6.98744 18.0722 6.51256 18.0722 6.21967 17.7794C5.92678 17.4865 5.92678 17.0116 6.21967 16.7187L10.9384 12L6.21967 7.28131Z"
            fill=""
          />
        </svg>
      </button>
      <!-- Hamburger Toggle BTN -->

      <a href="index.html" class="lg:hidden">
        <img class="dark:hidden" src="src/images/logo/logo.svg" alt="Logo" />
        <img
          class="hidden dark:block"
          src="src/images/logo/logo-dark.svg"
          alt="Logo"
        />
      </a>
    </div>
    <div
      :class="menuToggle ? 'flex' : 'hidden'"
      class="shadow-theme-md w-full items-center justify-between gap-4 px-5 py-4 lg:flex lg:justify-end lg:px-0 lg:shadow-none"
    >
                <form method="POST" action="/admin/logout">
                @csrf
                <button
                    type="submit"
                    class="flex items-center gap-2 rounded-lg bg-gray-100 px-4 py-2 text-gray-700 transition hover:bg-gray-200">

                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 12H3"/>
                        <path d="M10 7L15 12L10 17"/>
                        <path d="M21 3V21"/>
                    </svg>
                    Déconnexion
                </button>
            </form>
          </div>
</header>
<!-- ===== Header End ===== -->
      <main>
    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">

        <h1 class="mb-6 text-2xl font-bold">
            Rapports
        </h1>
        
        <div class="rounded-2xl border border-gray-200 bg-white p-6">

            <h3 class="mb-4 text-lg font-semibold">
                Évolution des liens cassés
            </h3>

            <canvas id="brokenLinksChart"></canvas>

        </div>

    </div>
</main>
      </div>
      <!-- ===== Content Area End ===== -->
    </div>
    <!-- ===== Page Wrapper End ===== -->
  
  <!--<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>-->
    <script src="{{ asset('admin_old/bundle.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const labels = [
            @foreach($scanHistory as $scan)
                "{{ $scan->host }}",
            @endforeach
        ];

        const data = [
            @foreach($scanHistory as $scan)
                {{ $scan->broken }},
            @endforeach
        ];

        const ctx = document.getElementById('brokenLinksChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Liens cassés',
                    data: data
                }]
            },
            options: {
                responsive: true
            }
        });
    </script>


</body>
</html>
