<?php

namespace App\Http\Controllers;

use App\Mail\InviteUserMail;
use App\Models\Invites;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class InvitesController extends Controller
{
    public function index()
    {
        $users = User::all();
        $count = $users->count();
        $roles = Role::all();
        $invites = Invites::where('accepted', 0)->get();
        return view('backend.users.index', compact('users', 'count', 'roles', 'invites'));
    }

    public function invitesUser(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:invites,email',
            'role_id' => 'required|exists:roles,id', // disarankan pakai validasi exists
            'pesan' => 'nullable|string|max:255',
        ]);

        $token = Str::random(40);

        Invites::create([
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'pesan' => $validated['pesan'] ?? null,
            'token' => $token,
        ]);

        Mail::to($validated['email'])->send(new InviteUserMail($token));
        notify()->success('Undangan berhasil dikirim.');
        return back();
    }

    public function sendEmail($email)
    {
        $data = [
            'email' => $email,
            'token' => Str::random(40),
        ];

        $invite = Invites::where('email', $data['email'])->first();
        $invite->token = $data['token'];
        $invite->save();
        // Kirim ulang email
        Mail::to($data['email'])->send(new InviteUserMail($data['token']));
        notify()->success('Email undangan berhasil dikirim ke ' . $data['email']);
        return redirect()->back();
    }


    public function accept(Request $request)
    {
        $token = $request->query('token');

        // Cek apakah token valid
        $invite = Invites::where('token', $token)->where('accepted', false)->first();

        if (!$invite) {
            abort(404, 'Token tidak valid atau sudah digunakan.');
        }

        // Tampilkan view form registrasi dari undangan
        return view('backend.users.createUser', compact('invite'));
    }

    public function storeNewUser(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'token' => ['required', 'string'],
        ]);

        // Cek token kembali untuk keamanan
        $invite = Invites::where('token', $request->token)->where('accepted', false)->first();

        // dd($invite->role_id);
        if (!$invite) {
            return redirect()->back()->withErrors(['token' => 'Token tidak valid atau sudah digunakan.']);
        }

        // Buat user berdasarkan data undangan
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $invite->role_id, // Jika ingin ikut peran dari undangan
        ]);

        // Update status undangan
        $invite->accepted = true;
        $invite->save();

        // event(new Registered($user));
        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
