@extends('layouts.admin')

@section('title', 'Add User')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow-sm">
    <h2 class="text-xl font-bold mb-6">Add New User</h2>

    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" class="mt-1 w-full border rounded px-3 py-2" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Profile Photo</label>
            <input type="file" name="profile_photo" class="mt-1 w-full">
        </div>

        <button type="submit"
                class="bg-gray-900 text-white px-6 py-2 rounded hover:bg-black">
            Add User
        </button>
    </form>
</div>
@endsection
