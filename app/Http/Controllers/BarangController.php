<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\MasterKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    //
    function __construct(){
        // $this->middleware('auth:admin');
    }

    public function index(){
        date_default_timezone_set('Asia/Jakarta');

        $data['no'] = 1;
        $data['data'] = Barang::orderBy('id','ASC')->get();
        $data['kategori'] = MasterKategori::orderBy('id','ASC')->get();
        $date = date('Y-m-d');
        $date_kode = date('Ymd');
        
        $count_barang = Barang::whereDate('created_at', $date)->count();
        if($count_barang == 0){ 
            $kode_barang = 'AR'.$date_kode.'0000'. $count_barang + 1;
        }elseif($count_barang > 0 && $count_barang < 9){ 
            $kode_barang = 'AR'.$date_kode.'0000'. $count_barang + 1;
        }elseif($count_barang > 9 && $count_barang < 99){ // puluhan
            $kode_barang = 'AR'.$date_kode.'000'. $count_barang + 1;
        }elseif($count_barang > 99 && $count_barang < 999){ // ratusan
            $kode_barang = 'AR'.$date_kode.'00'. $count_barang + 1;
        }elseif($count_barang > 999 && $count_barang < 9999){ // ribuan
            $kode_barang = 'AR'.$date_kode.'00'. $count_barang + 1;
        }elseif($count_barang > 9999 && $count_barang < 99999){ // puluhan ribu
            $kode_barang = 'AR'.$date_kode.''. $count_barang + 1;
        }else{
            $kode_barang = 'AR'.$date_kode.''. $count_barang + 1;
        }
        $data['kode_barang'] = $kode_barang;

        return view('barang', $data);
    }

    public function store(Request $request){
        $response = Barang::storeModel($request);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Simpan']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function update(Request $request){
        $response = Barang::updateModel($request);

        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Update']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function delete($id){
        $response = Barang::deleteModel($id);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Hapus']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
}
