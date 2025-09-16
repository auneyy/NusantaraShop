<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'email'   => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // Simpan ke database
        Message::create([
            'name'    => $validated['name'],
            'phone'   => $validated['phone'] ?? null,
            'email'   => $validated['email'],
            'subject' => $validated['subject'] ?? null,
            'message' => $validated['message'],
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Pesan berhasil dikirim!');
    }
}
