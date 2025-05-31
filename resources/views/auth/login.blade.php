@extends('layouts.guest')

@section('title', 'Login')

@section('content')


<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6 space-y-6">


        <div class="flex justify-center mb-4">
            <h1 class="text-3xl font-extrabold tracking-wide" style="font-family: 'Caveat', cursive;">
                AJAR
            </h1>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 text-center">Welcome Back 👋</h2>

        @if (session('status'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded text-sm space-y-1">
                @foreach ($errors->all() as $error)
                    <p>• {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <input type="email" name="email" placeholder="Email"
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black"
                   required autofocus>

            {{-- Password --}}
            <input type="password" name="password" placeholder="Password"
                   class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-black"
                   required>

            {{-- Remember Me + Forgot --}}
            <div class="flex justify-between items-center text-sm text-gray-600">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300">
                    Remember me
                </label>
                <a href="{{ route('password.request') }}" class="text-gray-600 hover:underline">
                    Forgot Pass?
                </a>
            </div>

            {{-- Submit --}}
            <button type="submit"
                    class="w-full bg-gray-900 text-white py-2 rounded hover:bg-black transition">
                Login
            </button>
        </form>

        <p class="text-center text-sm text-gray-600">
            Don’t have an account?
            <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Register</a>
        </p>
    </div>
</div>
@endsection
