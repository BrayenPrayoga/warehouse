<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\ProsesKeluar;
use Illuminate\Http\Request;
use App\Imports\importBarangKeluar;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class DaftarBarangKeluarController extends Controller
{
    //
    function __construct(){
        // $this->middleware('auth:admin');
    }

    public function index(){
        date_default_timezone_set('Asia/Jakarta');

        $data['no'] = 1;
        $data['data'] = Barang::with('RelasiKategori','RelasiRak')->where('status', 2)->orderBy('id','DESC')->get();
        $data['barang_masuk'] = Barang::join('tabel_proses_masuk','id_barang','tabel_barang.id')->where('status', 1)->orderBy('tabel_barang.id','DESC')->get();

        return view('daftar_barang_keluar', $data);
    }

    public function getDataBarang(){
        $kode_barang = $_GET['kode_barang'];
        
        $data = Barang::with('RelasiKategori','RelasiRak')->join('tabel_proses_masuk','id_barang','tabel_barang.id')
                ->where('status', 1)
                ->where('kode_barang', $kode_barang)
                ->orderBy('tabel_barang.id','DESC')
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
        $response = Barang::deleteModel($id_barang, 'keluar');
        
        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Hapus']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
    
    public function import(Request $request){
        // Validasi file yang diunggah
        $request->validate([
            'upload_excel' => 'required|mimes:xls,xlsx'
        ]);

        // Mengimpor file menggunakan YourDataImport
        Excel::import(new importBarangKeluar, $request->file('upload_excel'));

        return back()->with('success', 'Data berhasil diimpor!');
    }
}
