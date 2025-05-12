<nav class="flex items-center justify-between px-6 py-4 shadow-sm bg-white sticky top-0 z-50">
    <a href="{{ route('home') }}" class="text-xl font-bold tracking-tight">AJAR</a>

    <ul class="flex gap-6 text-sm">
        <li><a href="{{ route('shop') }}" class="hover:text-blue-600">Shop</a></li>
        <li><a href="{{ route('wishlist') }}" class="hover:text-blue-600">Wishlist</a></li>
        <li><a href="{{ route('cart') }}" class="hover:text-blue-600">Cart</a></li>
        <li>
            @auth
                <a href="{{ route('profile') }}" class="hover:text-blue-600">Account</a>
            @else
                <a href="{{ route('login') }}" class="hover:text-blue-600">Login</a>
            @endauth
        </li>
    </ul>
</nav>
