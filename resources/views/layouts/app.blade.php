    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield('title', 'AJAR')</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-white text-gray-800 font-sans antialiased">

    {{-- Navbar --}}
        <header class="bg-white shadow-sm sticky top-0 z-50 border-b">
            <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between relative">

                {{-- Left Nav --}}
                <div class="flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('shop') }}" class="hover:text-gray-400">Shop</a>
                    <a href="{{ url('/shop?category=shoes') }}" class="hover:text-gray-400">Shoes</a>
                    <a href="{{ url('/shop?category=perfumes') }}" class="hover:text-gray-400">Perfumes</a>
                </div>

                {{-- Center Logo --}}
                <div class="absolute left-1/2 transform -translate-x-1/2">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-gray-900" style="font-family: 'Caveat', cursive;">
                        AJAR
                    </a>
                </div>

                {{-- Right Nav --}}
                <div class="flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('wishlist') }}" class="hover:text-gray-400">Wishlist</a>
                    <a href="{{ route('cart') }}" class="hover:text-gray-400">Cart</a>
                    @auth
                        @if (auth()->user()->is_admin)
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-400">Dashboard</a>
                        @else
                            <a href="{{ route('profile') }}" class="hover:text-gray-400">Profile</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="hover:text-gray-400">Sign In</a>
                    @endauth
                </div>
            </div>

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="max-w-4xl mx-auto mt-4 px-4 py-3 bg-green-100 border border-green-300 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="max-w-4xl mx-auto mt-4 px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded">
            {{ session('error') }}
        </div>
    @endif

    {{-- Page Content --}}
    <main class="min-h-screen">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-gray-100 text-center text-sm text-gray-600 py-6 mt-16">
        &copy; {{ date('Y') }} AJAR Co. All rights reserved.
    </footer>

    {{-- Auto-hide Flash Script --}}
    <script>
        setTimeout(() => {
            document.querySelectorAll('.bg-green-100, .bg-red-100').forEach(el => {
                el.style.display = 'none';
            });
        }, 3000);
    </script>

    </body>
    </html>
