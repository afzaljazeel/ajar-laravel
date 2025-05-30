<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    //
public function index()
{
    $user = auth()->user();
    $orders = $user->orders()->latest()->take(5)->get(); // Recent 5 orders

    return view('profile.index', compact('user', 'orders'));
}

public function upload(Request $request)
{
    $request->validate([
        'profile_photo' => 'required|image|max:2048',
    ]);

    $user = auth()->user();
    $path = $request->file('profile_photo')->store('profile_photos', 'public');

    // Optionally delete old photo if exists
    if ($user->profile_photo_path && Storage::disk('public')->exists($user->profile_photo_path)) {
        Storage::disk('public')->delete($user->profile_photo_path);
    }

    $user->profile_photo_path = $path;
    $user->save();

    return back()->with('success', 'Profile photo updated.');
}

public function update(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'address' => 'nullable|string|max:255',
        'phone' => 'nullable|string|max:20',
        'password' => 'nullable|string|min:6',
    ]);

    $user = auth()->user();

    $user->name = $request->name;
    $user->email = $request->email;
    $user->address = $request->address;
    $user->phone = $request->phone;

    if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }

    $user->save();

    return back()->with('success', 'Profile updated successfully.');
}

public function updateField(Request $request, $field)
{
    $user = auth()->user();
    $request->validate([
        'value' => 'required|string|max:255',
    ]);

    if (!in_array($field, ['name', 'email', 'address', 'phone', 'password'])) {
        return redirect()->back()->with('error', 'Invalid field');
    }

    if ($field === 'password') {
        $user->password = bcrypt($request->value);
    } else {
        $user->$field = $request->value;
    }

    $user->save();

    return back()->with('success', ucfirst($field) . ' updated successfully.');
}



}

