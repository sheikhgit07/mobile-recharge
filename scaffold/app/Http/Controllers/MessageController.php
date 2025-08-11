<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'body' => ['required', 'string', 'max:5000'],
        ]);

        Message::create($data);

        return back()->with('status', 'Message sent. We will get back to you soon.');
    }
}