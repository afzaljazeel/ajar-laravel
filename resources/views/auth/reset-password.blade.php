@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-md bg-white rounded shadow p-6 space-y-6">
        <h2 class="text-2xl font-bold text-gray-800 text-center">Set a New Password</h2>

        @if ($errors->any())
            <div class="text-red-600 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <input type="hidden" name="email" value="{{ $request->email }}">

            <input type="password" name="password" placeholder="New Password"
                class="w-full border rounded px-4 py-2" required>

            <input type="password" name="password_confirmation" placeholder="Confirm Password"
                class="w-full border rounded px-4 py-2" required>

            <button type="submit"
                class="w-full bg-gray-900 text-white py-2 rounded hover:bg-black transition">
                Reset Password
            </button>
        </form>
    </div>
</div>
@endsection
