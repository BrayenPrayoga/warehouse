<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\ProsesKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarBarangKeluarController extends Controller
{
    //
    function __construct(){
        $this->middleware('auth:admin');
    }

    public function index(){
        date_default_timezone_set('Asia/Jakarta');

        $data['no'] = 1;
        $data['data'] = Barang::with('RelasiKategori','RelasiRak')->join('tabel_proses_keluar','id_barang','tabel_barang.id')->where('status', 2)->orderBy('tabel_barang.id','ASC')->get();
        $data['barang_masuk'] = Barang::join('tabel_proses_masuk','id_barang','tabel_barang.id')->where('status', 1)->orderBy('tabel_barang.id','ASC')->get();

        return view('daftar_barang_keluar', $data);
    }

    public function getDataBarang(){
        $kode_barang = $_GET['kode_barang'];
        
        $data = Barang::with('RelasiKategori','RelasiRak')->join('tabel_proses_masuk','id_barang','tabel_barang.id')
                ->where('status', 1)
                ->where('kode_barang', $kode_barang)
                ->orderBy('tabel_barang.id','ASC')
                ->first();

        return $data;
    }
    
    public function store(Request $request){
        $response = ProsesKeluar::storeModel($request);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Simpan']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }

    public function delete($id_barang){
        $response = Barang::deleteModel($id_barang);
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Hapus']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
}
