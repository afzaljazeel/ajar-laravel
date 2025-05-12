@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="text-center py-20">
        <h1 class="text-4xl font-bold mb-4">Welcome to AJAR</h1>
        <p class="text-gray-600">Explore our exclusive collection of shoes, perfumes, and lifestyle products.</p>
        <a href="{{ route('shop') }}" class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            Start Shopping
        </a>
    </div>
@endsection
