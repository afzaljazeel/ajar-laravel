<nav class="flex items-center justify-between px-6 py-4 shadow-sm bg-white sticky top-0 z-50">
    {{-- Logo --}}
    <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">AJAR</a>

    {{-- Nav Links --}}
    <ul class="flex items-center gap-6 text-sm text-gray-700">
        <li>
            <a href="{{ route('shop') }}" class="flex items-center gap-1 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18l-1 13H4L3 3z" />
                </svg>
                Shop
            </a>
        </li>
        <li>
            <a href="{{ route('wishlist') }}" class="flex items-center gap-1 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" stroke="none">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 
                             2 6 4 4 6.5 4c1.74 0 3.41 1.04 
                             4.13 2.61h1.74C14.09 5.04 
                             15.76 4 17.5 4 20 4 22 6 
                             22 8.5c0 3.78-3.4 6.86-8.55 
                             11.54L12 21.35z"/>
                </svg>
                Wishlist
            </a>
        </li>
        <li>
            <a href="{{ route('cart') }}" class="flex items-center gap-1 hover:text-blue-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A1 1 0 007 17h10a1 1 0 001-1.3L17 13M7 13l.4-2M17 13l-.4-2M9 21h.01M15 21h.01" />
                </svg>
                Cart
            </a>
        </li>
        <li>
            @auth
                <a href="{{ route('profile') }}" class="flex items-center gap-1 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 
                              4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 
                              016 0z" />
                    </svg>
                    Account
                </a>
            @else
                <a href="{{ route('login') }}" class="flex items-center gap-1 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 
                              4.847.655 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 
                              016 0z" />
                    </svg>
                    Login
                </a>
            @endauth
        </li>
    </ul>
</nav>
