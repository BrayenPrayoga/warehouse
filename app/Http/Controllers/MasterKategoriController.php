<?php

namespace App\Http\Controllers;

use App\Models\MasterKategori;
use Illuminate\Http\Request;

class MasterKategoriController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $data['no'] = 1;
        $data['data'] = MasterKategori::orderBy('id','ASC')->get();

        return view('master_kategori', $data);
    }

    public function store(Request $request){
        $response = MasterKategori::storeModel($request);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Simpan']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function update(Request $request){
        $response = MasterKategori::updateModel($request);

        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Update']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function delete($id){
        $response = MasterKategori::deleteModal($id);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Hapus']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
}
