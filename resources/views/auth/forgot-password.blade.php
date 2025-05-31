@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded shadow p-6 space-y-6">

        <div class="flex justify-center mb-4">
            <h1 class="text-3xl font-extrabold tracking-wide" style="font-family: 'Caveat', cursive;">
                AJAR
            </h1>
        </div>


        <h2 class="text-2xl font-bold text-gray-800 text-center">Reset your password</h2>

        @if (session('status'))
            <div class="text-green-600 text-sm">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            <input type="email" name="email" placeholder="Email"
                class="w-full border rounded px-4 py-2" required autofocus>

            <button type="submit"
                class="w-full bg-gray-900 text-white py-2 rounded hover:bg-black transition">
                Email Password Reset Link
            </button>
        </form>

        <p class="text-center text-sm text-gray-600">
            Remember your password?
            <a href="{{ route('login') }}" class="text-gray-400 hover:underline">Login</a>
        </p>
    </div>
</div>
@endsection
