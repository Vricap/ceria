<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $settings = SiteSetting::getAllAsArray();
        return view('contact.index', compact('settings'));
    }

    public function submit(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        Inquiry::create([
            'name'    => $validated['name'],
            'email'   => $validated['email'],
            'phone'   => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? 'Pesan dari halaman kontak',
            'message' => $validated['message'],
            'status'  => 'new',
            'source'  => 'contact_form',
        ]);

        return back()->with('success', 'Pesan Anda telah berhasil dikirim! Kami akan menghubungi Anda segera.');
    }
}
