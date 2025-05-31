@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Users</h1>
    <a href="{{ route('admin.users.create') }}"
       class="bg-gray-900 text-white px-4 py-2 rounded hover:bg-black">
        + Add User
    </a>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white shadow-sm rounded-lg overflow-x-auto">
    <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-100 border-b text-gray-700">
            <tr>
                <th class="px-6 py-3">Image</th>
                <th class="px-6 py-3">Name</th>
                <th class="px-6 py-3">Email</th>
                <th class="px-6 py-3">Joined On</th>
                <th class="px-6 py-3 text-right">Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($users as $user)
            <tr class="border-b hover:bg-gray-50">
                {{-- Profile Image --}}
                <td class="px-6 py-4">
                    <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('placeholder.jpg') }}"
                         class="h-12 w-12 object-cover rounded-full border" alt="{{ $user->name }}">
                </td>

                {{-- Name --}}
                <td class="px-6 py-4 font-semibold text-gray-800">{{ $user->name }}</td>

                {{-- Email --}}
                <td class="px-6 py-4 text-gray-600">{{ $user->email }}</td>

                {{-- Date --}}
                <td class="px-6 py-4 text-gray-500">{{ $user->created_at->format('M d, Y') }}</td>

                {{-- Actions --}}
                <td class="px-6 py-4 text-right space-x-2">
                    <a href="{{ route('admin.users.edit', $user->id) }}"
                       class="inline-block bg-gray-800 text-white px-3 py-1 rounded text-xs hover:bg-black">
                        Edit
                    </a>

                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                          method="POST" class="inline-block"
                          onsubmit="return confirm('Delete this user?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $users->links() }}
</div>
@endsection
