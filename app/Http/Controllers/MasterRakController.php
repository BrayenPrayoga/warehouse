<?php

namespace App\Http\Controllers;

use App\Models\MasterRak;
use Illuminate\Http\Request;

class MasterRakController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        $data['no'] = 1;
        $data['data'] = MasterRak::orderBy('id','ASC')->get();
        $date = date('Y-m-d');

        $count_rak = MasterRak::count();
        if($count_rak == 0){ 
            $kode_rak = 'AR0000'. $count_rak + 1;
        }elseif($count_rak > 0 && $count_rak < 9){ 
            $kode_rak = 'AR0000'. $count_rak + 1;
        }elseif($count_rak > 9 && $count_rak < 99){ // puluhan
            $kode_rak = 'AR000'. $count_rak + 1;
        }elseif($count_rak > 99 && $count_rak < 999){ // ratusan
            $kode_rak = 'AR00'. $count_rak + 1;
        }elseif($count_rak > 999 && $count_rak < 9999){ // ribuan
            $kode_rak = 'AR00'. $count_rak + 1;
        }elseif($count_rak > 9999 && $count_rak < 99999){ // puluhan ribu
            $kode_rak = 'AR'. $count_rak + 1;
        }else{
            $kode_rak = 'AR'. $count_rak + 1;
        }
        $data['kode_rak'] = $kode_rak;

        return view('master_rak', $data);
    }

    public function store(Request $request){
        $response = MasterRak::storeModel($request);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Simpan']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function update(Request $request){
        $response = MasterRak::updateModel($request);

        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Update']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function delete($id){
        $response = MasterRak::deleteModal($id);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Hapus']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
}
