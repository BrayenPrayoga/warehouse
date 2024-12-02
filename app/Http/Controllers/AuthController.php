<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Hash;

class AuthController extends Controller
{
    //
    public function login(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required'
        ]);
        
        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 1])) { // admin
            return redirect()->intended('/dashboard');
        }else if (Auth::guard('user_gate_in')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 2])) { // user gate in
            return redirect()->intended('/dashboard');
        }else if (Auth::guard('user_gate_out')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 3])) { // user gate out
            return redirect()->intended('/dashboard');
        }else if (Auth::guard('user_stok')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 4])) { // user stok
            return redirect()->intended('/dashboard');
        }else if (Auth::guard('user_billing')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 5])) { // user nilling
            return redirect()->intended('/dashboard');
        } else if (Auth::guard('supervisor')->attempt(['email' => $request->email, 'password' => $request->password, 'status' => 6])) { // supervisor
            return redirect()->intended('/dashboard');
        } else {
            $request->session()->flash('error', 'Gagal Login, SIlahkan Periksa Email dan Password Anda!');
            return redirect()->intended('/');
        }
  
        $request->session()->flash('error', 'Login Gagal!');
        return redirect()->back()->with(['error'=>'Login Gagal']);
    }

    public function logout(Request $request){
        if (Auth::guard('user_gate_in')->check()) {
            Auth::guard('user_gate_in')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        $request->session()->invalidate();

        return redirect('/');
    }
  
    public function resetPassword($id){
        $data['user'] = User::where('id', $id)->first();

        return view('reset_password', $data);
    }

    public function updatePassword(Request $request){
        $request->validate([
            'email'=>'required',
            'password'=>'required',
            'confirm_password'=>'required|same:password'
        ]);
        $password = Hash::make($request->password);
        $update = User::where('id', $request->id)->update(['password'=>$password]);
        
        $request->session()->flash('success', 'Reset Berhasil, SIlahkan Login');
        return redirect('/');
    }
}
