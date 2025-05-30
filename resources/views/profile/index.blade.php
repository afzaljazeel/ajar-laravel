@extends('layouts.profile')

@section('title', 'Your Profile')

@section('inner-content')
<div class="grid lg:grid-cols-3 gap-6">

    {{-- Left Card: Profile Section --}}
    <div class="bg-white rounded-lg shadow p-6 text-center">
        {{-- Profile Photo Upload --}}
        <form action="{{ route('profile.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="profile_photo" class="block cursor-pointer">
                <img src="{{ $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : asset('placeholder.jpg') }}"
                     class="w-24 h-24 mx-auto rounded-full object-cover ring-2 ring-gray-300"
                     alt="Profile Photo">
            </label>
            <input type="file" name="profile_photo" id="profile_photo" accept="image/*" class="hidden"
                   onchange="this.form.submit()">
        </form>
        <p class="text-sm text-gray-500 mt-2">Tap to change photo</p>

        {{-- Name + Email --}}
        <h2 class="text-lg font-semibold mt-4">{{ $user->name }}</h2>
        <p class="text-sm text-gray-600">{{ $user->email }}</p>
        <p class="text-xs text-gray-400 mt-1">Joined on {{ $user->created_at->format('jS M Y') }}</p>

        {{-- Edit Button --}}
        <button onclick="toggleForm()" class="mt-4 px-4 py-1 text-sm text-white bg-gray-900 hover:bg-black rounded">
            Edit Details
        </button>

        {{-- Hidden Edit Form --}}
        <form id="editForm" action="{{ route('profile.update') }}" method="POST" class="space-y-4 mt-6 hidden text-left">
            @csrf
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">Name</label>
                <input type="text" name="name" value="{{ $user->name }}"
                       class="w-full border px-4 py-2 rounded focus:outline-none focus:ring">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">Email</label>
                <input type="email" name="email" value="{{ $user->email }}"
                       class="w-full border px-4 py-2 rounded focus:outline-none focus:ring">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">New Password</label>
                <input type="password" name="password" placeholder="New Password"
                       class="w-full border px-4 py-2 rounded focus:outline-none focus:ring">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">Default Address</label>
                <input type="text" name="address" value="{{ $user->address }}"
                       class="w-full border px-4 py-2 rounded focus:outline-none focus:ring">
            </div>
            <div>
                <label class="text-sm font-medium text-gray-700 block mb-1">Mobile Number</label>
                <input type="text" name="phone" value="{{ $user->phone }}"
                       class="w-full border px-4 py-2 rounded focus:outline-none focus:ring">
            </div>

            <div class="text-right">
                <button type="submit"
                        class="px-5 py-2 bg-gray-900 text-white rounded hover:bg-black transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

    {{-- Right Card: Activity Section --}}
    <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Recent Activities</h3>
        <div class="space-y-4">
            @forelse ($orders as $order)
                <div class="flex justify-between items-center bg-gray-50 border rounded px-4 py-3">
                    <div>
                        <p class="text-sm font-medium capitalize">Order #{{ $order->id }} - {{ $order->status ?? 'Pending' }}  </p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->diffForHumans() }}</p>
                    </div>
                    <a href="{{ route('orders') }}"
                       class="text-sm text-blue-600 hover:underline">View Details</a>
                </div>
            @empty
                <p class="text-sm text-gray-500">No recent activity.</p>
            @endforelse
        </div>
    </div>

</div>

{{-- Toggle Form JS --}}
<script>
    function toggleForm() {
        const form = document.getElementById('editForm');
        form.classList.toggle('hidden');
    }
</script>
@endsection
