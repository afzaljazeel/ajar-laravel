<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    <aside class="w-64 bg-white border-r flex flex-col justify-between sticky top-0 h-screen shadow-sm">
        <div>
            <div class="px-6 py-4 border-b">
                <h1 class="text-xl font-bold text-gray-900">AJAR</h1>
            </div>
            <nav class="flex-1 px-4 py-6 space-y-1 text-sm text-gray-700">
                <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 transition {{ request()->routeIs('admin.dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7m-9 2v8m4-8v8m5-12h-1a2 2 0 00-2 2v12a2 2 0 002 2h1" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('admin.products.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 transition {{ request()->routeIs('admin.products.*') ? 'bg-gray-200 font-semibold' : '' }}">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M20 13V5a2 2 0 00-2-2H6a2 2 0 00-2 2v8m0 0v6a2 2 0 002 2h12a2 2 0 002-2v-6m-2 0H6" />
                    </svg>
                    Products
                </a>

               <a href="{{ route('admin.users.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 transition {{ request()->routeIs('admin.users.*') ? 'bg-gray-200 font-semibold' : '' }}">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M9 20H4v-2a3 3 0 015.356-1.857M9 4a4 4 0 110 8 4 4 0 010-8zM17 4a4 4 0 110 8 4 4 0 010-8z" />
                    </svg>
                    Users
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M9 17v-2a4 4 0 118 0v2m-6 4h4" />
                    </svg>
                    Statistics
                </a>

                <a href="#" class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 transition">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7" />
                    </svg>
                    Orders
                </a>
            </nav>
        </div>

        <div class="px-4 py-4 border-t space-y-2">
            <a href="{{ route('home') }}" class="flex items-center justify-between text-sm text-gray-800 hover:text-blue-600">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 12l2-2m0 0l7-7 7 7M13 5v14" />
                    </svg>
                    Visit Site
                </span>
                <span>›</span>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center justify-between w-full text-sm text-gray-800 hover:text-red-600">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M17 16l4-4m0 0l-4-4m4 4H7" />
                        </svg>
                        Sign Out
                    </span>
                    <span>›</span>
                </button>
            </form>
        </div>
    </aside>


    {{-- Main content --}}
    <div class="flex-1 flex flex-col">

       <header class="bg-white shadow px-6 py-4 border-b flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">Admin Panel</h2>

        <div class="flex items-center gap-4">
            {{-- Theme Toggle Placeholder (optional JS later) --}}
            <button class="text-gray-500 hover:text-gray-700 transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 3v1m0 16v1m9-9h1M3 12H2m15.36 6.36l-.707-.707M6.34 6.34l-.707-.707m12.02 0l-.707.707M6.34 17.66l-.707.707M12 7a5 5 0 100 10 5 5 0 000-10z"/>
                </svg>
            </button>

            {{-- Profile Dropdown --}}
            <div class="relative">
                <button onclick="document.getElementById('profileDropdown').classList.toggle('hidden')"
                        class="flex items-center gap-2 hover:text-blue-600 text-gray-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 
                            4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 
                            016 0z" />
                    </svg>
                </button>

                {{-- Dropdown Menu --}}
                <div id="profileDropdown"
                    class="absolute right-0 mt-2 w-40 bg-white border rounded shadow-md text-sm hidden z-50">
                    <a href="{{ route('admin.profile') }}"
                    class="block px-4 py-2 text-gray-800 hover:bg-gray-100">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>


        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto px-6 py-8">
            @yield('content')
        </main>

        {{-- Optional Footer --}}
        <footer class="text-center text-xs text-gray-500 py-4">
            &copy; {{ date('Y') }} AJAR Admin
        </footer>
    </div>
</div>

<script>
    document.addEventListener('click', function (e) {
        const dropdown = document.getElementById('profileDropdown');
        const button = dropdown?.previousElementSibling;
        if (dropdown && !dropdown.contains(e.target) && !button.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>


@yield('scripts')
</body>
</html>
