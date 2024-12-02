<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    //
    function __construct(){
        // $this->middleware('auth:admin');
    }

    public function index(){
        $data['no'] = 1;
        $data['data'] = User::orderBy('id','ASC')->get();

        return view('users', $data);
    }

    public function store(Request $request){
        $response = User::storeModel($request);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Simpan']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function update(Request $request){
        $response = User::updateModel($request);

        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Update']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function delete($id){
        $response = User::deleteModal($id);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Hapus']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
}
