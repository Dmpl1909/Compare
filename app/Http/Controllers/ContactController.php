<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        // Guardar na base de dados
        DB::table('contacts')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Enviar email
        Mail::to(env('CONTACT_EMAIL', 'your-email@example.com'))
            ->send(new ContactFormMail($validated));

        return back()->with('success', 'Mensagem enviada com sucesso! Entraremos em contato em breve.');
    }
}
