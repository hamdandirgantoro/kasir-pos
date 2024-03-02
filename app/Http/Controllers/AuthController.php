<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function indexLogin()
    {
        $auth = 1;
        return view('auth.index', compact('auth'));
    }

    public function indexRegister()
    {
        $auth = 1;
        return view('auth.index', compact('auth'));
    }

    public function handleLogin(AuthRequest $request)
    {
        $remember = $request['remember'] ? $request['remember'] : false;
        if (Auth::attempt($request->except(['_token']), $remember)) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login')->withErrors('Login Gagal, Silahkan Cek Username,Password, atau Emailmu');
        }
    }

    public function handleRegister(AuthRequest $request)
    {
        $remember = $request['remember'] ? $request['remember'] : false;
        $user = User::create($request->all());
        if (!$user) {
            return redirect()->route('register')->withErrors('Internal Server Error');
        }
        if (Auth::attempt($request->except(['_token', 'type']), $remember)) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('register')->withErrors('Login Gagal, Silahkan Cek Username,Password, atau Emailmu');
        }
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function lupaPasswordHandle(Request $request) {
        $data = $request->all();
        $user = User::where('name', $data['name'])->first();
        if (!$user) {
            return response()->json(['success' => 0]);
        }
        if (date('Y-m-d', strtotime($user->created_at)) == $data['created_at']) {
            return response()->json(['success' => 1, 'html'=> view('auth.edit-password')->render(), 'id_user' => $user->id]);
        } else {
            return response()->json(['success' => 0]);
        }
    }

    public function lupaPasswordUpdate(Request $request, $id)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        User::find($id)->update($data);
        return response()->json(['success' => 1]);
    }
}
