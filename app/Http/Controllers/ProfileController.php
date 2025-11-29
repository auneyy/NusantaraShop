<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

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
                      ->with(['orderItems.product'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        // Get provinces from RajaOngkir for address form
        $provinces = $this->getProvinces();

        return view('profile.index', compact('user', 'orders', 'provinces'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $provinces = $this->getProvinces();
        
        return view('profile.edit', compact('user', 'provinces'));
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            // Address fields
            'address' => 'nullable|string|max:500',
            'province_id' => 'nullable|string',
            'city_id' => 'nullable|string',
            'district' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            // Delete old image if exists
            if ($user->profile_image && Storage::exists('public/' . $user->profile_image)) {
                Storage::delete('public/' . $user->profile_image);
            }
            
            // Store new image
            $imagePath = $request->file('profile_image')->store('profiles', 'public');
            $validated['profile_image'] = $imagePath;
        }

        // Handle address data - simpan sebagai JSON atau field terpisah
        if ($request->filled('address')) {
            $addressData = [
                'address' => $request->address,
                'province_id' => $request->province_id,
                'province_name' => $this->getProvinceName($request->province_id),
                'city_id' => $request->city_id,
                'city_name' => $this->getCityName($request->province_id, $request->city_id),
                'district' => $request->district,
                'postal_code' => $request->postal_code,
            ];

            // Simpan sebagai JSON di field address_data
            $validated['address_data'] = json_encode($addressData);
        }

        $user->update($validated);

        return redirect()->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Show address form
     */
    public function address()
    {
        $user = Auth::user();
        $provinces = $this->getProvinces();
        
        return view('profile.address', compact('user', 'provinces'));
    }

    /**
     * Update user's address
     */
    public function updateAddress(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'address' => 'required|string|max:500',
            'province_id' => 'required|string',
            'city_id' => 'required|string',
            'district' => 'required|string|max:100',
            'postal_code' => 'required|string|max:10',
        ]);

        // Get province and city names from RajaOngkir
        $provinceName = $this->getProvinceName($request->province_id);
        $cityName = $this->getCityName($request->province_id, $request->city_id);

        $addressData = [
            'address' => $request->address,
            'province_id' => $request->province_id,
            'province_name' => $provinceName,
            'city_id' => $request->city_id,
            'city_name' => $cityName,
            'district' => $request->district,
            'postal_code' => $request->postal_code,
        ];

        $user->update([
            'address_data' => json_encode($addressData)
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Alamat berhasil diperbarui!');
    }

    /**
     * Get cities by province (for AJAX)
     */
    public function getCities($provinceId)
    {
        try {
            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.key')
            ])->get('https://api.rajaongkir.com/starter/city', [
                'province' => $provinceId
            ]);

            if ($response->successful()) {
                $cities = $response->json()['rajaongkir']['results'];
                return response()->json($cities);
            }

            return response()->json(['error' => 'Failed to fetch cities'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get provinces from RajaOngkir
     */
    private function getProvinces()
    {
        try {
            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.key')
            ])->get('https://api.rajaongkir.com/starter/province');

            if ($response->successful()) {
                return $response->json()['rajaongkir']['results'];
            }
        } catch (\Exception $e) {
            // Log error
            \Log::error('Failed to fetch provinces: ' . $e->getMessage());
        }

        return [];
    }

    /**
     * Get province name by ID
     */
    private function getProvinceName($provinceId)
    {
        try {
            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.key')
            ])->get('https://api.rajaongkir.com/starter/province', [
                'id' => $provinceId
            ]);

            if ($response->successful()) {
                $result = $response->json()['rajaongkir']['results'];
                return $result['province'] ?? 'Unknown Province';
            }
        } catch (\Exception $e) {
            \Log::error('Failed to fetch province name: ' . $e->getMessage());
        }

        return 'Unknown Province';
    }

    /**
     * Get city name by province and city ID
     */
    private function getCityName($provinceId, $cityId)
    {
        try {
            $response = Http::withHeaders([
                'key' => config('services.rajaongkir.key')
            ])->get('https://api.rajaongkir.com/starter/city', [
                'province' => $provinceId,
                'id' => $cityId
            ]);

            if ($response->successful()) {
                $result = $response->json()['rajaongkir']['results'];
                return $result['city_name'] ?? 'Unknown City';
            }
        } catch (\Exception $e) {
            \Log::error('Failed to fetch city name: ' . $e->getMessage());
        }

        return 'Unknown City';
    }

    /**
     * Show the orders page.
     */
    public function orders(Request $request)
    {
        $user = Auth::user();

        $query = Order::where('user_id', $user->id)
                      ->with(['orderItems.product']);

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
     * Show the change password form.
     */
    public function showChangePassword()
    {
        $user = Auth::user();
        return view('profile.password', compact('user'));
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
}