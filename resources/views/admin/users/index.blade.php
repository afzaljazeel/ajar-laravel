@extends('layouts.admin')

@section('title', 'Users')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Users</h1>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white shadow rounded overflow-x-auto">
    <table class="min-w-full table-auto text-sm text-left">
        <thead class="bg-gray-100 border-b text-xs text-gray-600 uppercase">
            <tr>
                <th class="px-6 py-4">Image</th>
                <th class="px-6 py-4">Name</th>
                <th class="px-6 py-4">Email</th>
                <th class="px-6 py-4">Joined On</th>
                <th class="px-6 py-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr class="border-b hover:bg-gray-50">
                    {{-- Profile Image --}}
                    <td class="px-6 py-4">
                        <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('placeholder.jpg') }}"
                             class="w-12 h-12 rounded-full object-cover border" alt="User">
                    </td>

                    {{-- Name --}}
                    <td class="px-6 py-4 text-gray-800 font-medium">
                        {{ $user->name }}
                    </td>

                    {{-- Email --}}
                    <td class="px-6 py-4 text-gray-700">
                        {{ $user->email }}
                    </td>

                    {{-- Joined Date --}}
                    <td class="px-6 py-4 text-gray-600">
                        {{ $user->created_at->format('M d, Y') }}
                    </td>

                    {{-- Actions --}}
                    <td class="px-6 py-4 space-x-2">
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-600 hover:bg-red-700 text-white text-xs px-4 py-2 rounded">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if($users->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-gray-500 py-10">
                        No users found.
                    </td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
