@extends('layouts.guest')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded shadow p-6 space-y-6">

        <div class="flex justify-center mb-4">
            <h1 class="text-3xl font-extrabold tracking-wide" style="font-family: 'Caveat', cursive;">
                AJAR
            </h1>
        </div>


        <h2 class="text-2xl font-bold text-gray-800 text-center">Create an Account</h2>

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

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <input type="text" name="name" placeholder="Full Name"
                class="w-full border rounded px-4 py-2" required autofocus>

            <input type="email" name="email" placeholder="Email"
                class="w-full border rounded px-4 py-2" required>

            <input type="password" name="password" placeholder="Password"
                class="w-full border rounded px-4 py-2" required>

            <input type="password" name="password_confirmation" placeholder="Confirm Password"
                class="w-full border rounded px-4 py-2" required>

            <button type="submit"
                class="w-full bg-gray-900 text-white py-2 rounded hover:bg-black transition">
                Register
            </button>
        </form>

        <p class="text-center text-sm text-gray-600">
            Already registered?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login here</a>
        </p>
    </div>
</div>
@endsection
