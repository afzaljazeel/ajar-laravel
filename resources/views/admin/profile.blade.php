@extends('layouts.admin')

@section('title', 'Admin Profile')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold mb-4">Update Admin Profile</h2>

    <form action="#" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium">Name</label>
                <input type="text" value="{{ auth()->user()->name }}" class="w-full border px-3 py-2 rounded" />
            </div>
            <div>
                <label class="block text-sm font-medium">Email</label>
                <input type="email" value="{{ auth()->user()->email }}" class="w-full border px-3 py-2 rounded" />
            </div>
            <div>
                <label class="block text-sm font-medium">New Password</label>
                <input type="password" class="w-full border px-3 py-2 rounded" />
            </div>
            <div>
                <label class="block text-sm font-medium">Confirm Password</label>
                <input type="password" class="w-full border px-3 py-2 rounded" />
            </div>
        </div>

        <button class="mt-6 w-full bg-black text-white py-2 rounded hover:bg-gray-800">
            Update Profile
        </button>
    </form>
</div>
@endsection
