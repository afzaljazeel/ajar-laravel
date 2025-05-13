<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 font-sans antialiased">

<div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-md border-r flex flex-col">
        <div class="px-6 py-4 border-b">
            <h1 class="text-xl font-bold">AJAR</h1>
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 text-sm">
            <a href="{{ route('admin.dashboard') }}"
               class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('admin.dashboard') ? 'bg-black text-white' : '' }}">
                Dashboard
            </a>
            <a href="{{ route('admin.products.index') }}"
               class="block px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('admin.products.*') ? 'bg-black text-white' : '' }}">
                Products
            </a>
        </nav>
        <div class="px-4 py-4 border-t">
            <a href="{{ route('home') }}" target="_blank"
               class="inline-block w-full text-center bg-gray-900 text-white py-2 rounded hover:bg-black">
                Visit Site
            </a>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">
        <!-- Topbar -->
        <header class="bg-white shadow px-6 py-4 border-b">
            <h2 class="text-lg font-semibold">Admin Dashboard</h2>
        </header>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto px-6 py-8">
            @yield('content')
        </main>
    </div>
</div>

</body>
</html>
