@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-12">
    <h1 class="text-2xl font-bold mb-6 text-gray-900">Checkout</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="text-sm list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form method="POST" action="{{ route('orders.place') }}" class="space-y-6">
        @csrf

        {{-- Delivery Info --}}
        <div>
            <h2 class="text-lg font-semibold mb-2">Delivery Details</h2>
            <input type="text" name="name" required placeholder="Full Name"
                   class="w-full border px-4 py-2 rounded mb-3" />
            <input type="text" name="address" required placeholder="Address"
                   class="w-full border px-4 py-2 rounded mb-3" />
            <input type="text" name="city" required placeholder="City"
                   class="w-full border px-4 py-2 rounded mb-3" />
            <input type="text" name="phone" required placeholder="Phone Number"
                   class="w-full border px-4 py-2 rounded" />
        </div>

        {{-- Payment Method --}}
        <div>
            <h2 class="text-lg font-semibold mb-2">Payment</h2>
            <div class="border px-4 py-3 rounded text-sm text-gray-700 bg-gray-50">
                <input type="radio" name="payment_method" value="cod" checked> Cash on Delivery (COD)
            </div>
        </div>

        {{-- Total Summary --}}
        <div class="text-right text-lg font-semibold text-gray-800 border-t pt-4">
            Total Payable: LKR {{ number_format($total, 2) }}
        </div>

        <button type="submit"
                class="bg-gray-900 text-white px-6 py-2 rounded hover:bg-black transition w-full">
            Confirm Order
        </button>
    </form>
</div>
@endsection
