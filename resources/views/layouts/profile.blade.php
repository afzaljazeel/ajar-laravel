@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">
    {{-- Sidebar Toggle for Mobile --}}
    <div class="md:hidden absolute top-4 left-4 z-50">
        <button onclick="document.getElementById('userSidebar').classList.toggle('hidden')"
                class="p-2 rounded bg-white shadow border">
            <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    {{-- Sidebar --}}
    <aside id="userSidebar"
           class="w-64 bg-white border-r sticky top-0 h-screen shadow-sm hidden md:block z-40">
        <nav class="flex flex-col px-4 py-6 space-y-1 text-sm text-gray-700">

            <a href="{{ route('home') }}"
               class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 transition {{ request()->is('/') ? 'bg-gray-200 font-semibold' : '' }}">
                <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2"
                     viewBox="0 0 24 24">
                    <path d="M3 12l2-2m0 0l7-7 7 7M13 5v14" />
                </svg>
                Home
            </a>

            <a href="{{ route('orders') }}"
               class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 transition {{ request()->routeIs('orders') ? 'bg-gray-200 font-semibold' : '' }}">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 17h6m-6 0a3 3 0 11-6 0m6 0a3 3 0 006 0m6-2v-5a2 2 0 00-2-2h-3V6a2 2 0 00-2-2H5a2 2 0 00-2 2v11h2m16 0a3 3 0 11-6 0" />
                </svg>
                To Receive
            </a>


            <a href="{{ route('orders.completed') }}"
            class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 transition {{ request()->routeIs('orders.completed') ? 'bg-gray-200 font-semibold' : '' }}">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                </svg>
                Completed Orders
            </a>


            <a href="{{ route('orders.cancelled') }}"
               class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 transition {{ request()->routeIs('orders.cancelled') ? 'bg-gray-200 font-semibold' : '' }}">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v.01M12 15h.01M21 12a9 9 0 11-18 0a9 9 0 0118 0zm-6.5-2.5L10.5 14.5M14.5 14.5L10.5 9.5" />
                </svg>

                Cancelled
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center gap-3 px-4 py-2 rounded hover:bg-gray-100 text-left transition w-full text-gray-700">
                    <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2"
                         viewBox="0 0 24 24">
                        <path d="M17 16l4-4m0 0l-4-4m4 4H7" />
                    </svg>
                    Sign Out
                </button>
            </form>
        </nav>
    </aside>

    {{-- Main Page Content --}}
    <div class="flex-1 px-4 py-8">
        @yield('inner-content')
    </div>
</div>
@endsection
