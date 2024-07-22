<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Auth;

class ProfilController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $data['no'] = 1;
        $data['data'] = User::where('id', Auth::user()->id)->orderBy('id','ASC')->first();

        return view('profil', $data);
    }
    
    public function update(Request $request){
        $response = User::updateProfilModel($request);

        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Update']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
}
