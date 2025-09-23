<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Order;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the user's profile.
     */
    public function index()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('profile.index', compact('user', 'orders'));

    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->address = $request->address;

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image) {
                Storage::delete('public/' . $user->profile_image);
            }

            // Store new image
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        }

        $user->save();

        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Show the orders page.
     */
    public function orders(Request $request)
    {
        $user = Auth::user();
        $query = Order::where('user_id', $user->id);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('profile.orders', compact('user', 'orders'));
    }

    /**
     * Show the settings page.
     */
    public function settings()
    {
        $user = Auth::user();
        return view('update.profile', compact('user'));
    }

    /**
     * Show the change password form.
     */
    public function showChangePassword()
    {
        return view('profile.passwoard');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Password berhasil diubah!');
    }

    /**
     * Update notification settings.
     */
    public function updateNotifications(Request $request)
    {
        $user = Auth::user();
        
        $user->email_notifications = $request->has('email_notifications');
        $user->sms_notifications = $request->has('sms_notifications');
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Pengaturan notifikasi berhasil diperbarui!');
    }

    /**
     * Update app preferences.
     */
    public function updatePreferences(Request $request)
    {
        $request->validate([
            'language' => 'required|in:id,en',
            'theme' => 'required|in:light,dark,auto',
            'timezone' => 'required|string',
        ]);

        $user = Auth::user();
        
        $user->language = $request->language;
        $user->theme = $request->theme;
        $user->timezone = $request->timezone;
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Preferensi aplikasi berhasil diperbarui!');
    }

    /**
     * Delete user account.
     */
    public function deleteAccount()
    {
        $user = Auth::user();
        
        // Delete user's profile image if exists
        if ($user->profile_image) {
            Storage::delete('public/' . $user->profile_image);
        }
        
        // Logout user
        Auth::logout();
        
        // Delete user account
        $user->delete();
        
        return redirect()->route('home')->with('success', 'Akun berhasil dihapus.');
    }
}