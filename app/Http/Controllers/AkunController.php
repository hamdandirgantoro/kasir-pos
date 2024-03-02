<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function setting()
    {
        $model = User::find(auth()->id());
        return view('setting-akun', compact('model'));
    }

    public function save(Request $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        User::find(auth()->id())->update($data);
        return redirect()->back();
    }
}
