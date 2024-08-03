<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\ProsesKeluar;
use App\Models\ProsesMasuk;
use App\Models\SewaGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class SewaBarangController extends Controller
{
    //
    function __construct(){
        // $this->middleware('auth');
    }

    public function index(){
        date_default_timezone_set('Asia/Jakarta');

        $data['no'] = 1;
        $data['data'] = Barang::select('tabel_barang.kode_barang','tabel_barang.nama','tabel_barang.berat','tabel_proses_masuk.tanggal_masuk','tabel_proses_keluar.tanggal_keluar','sewa_gudang.biaya')
                        ->join('tabel_proses_masuk','tabel_proses_masuk.id_barang','tabel_barang.id')
                        ->join('tabel_proses_keluar','tabel_proses_keluar.id_barang','tabel_barang.id')
                        ->join('sewa_gudang','sewa_gudang.id_barang','tabel_barang.id')
                        ->where('status', 3)
                        ->orderBy('tabel_barang.id','ASC')
                        ->get();

        return view('sewa_barang', $data);
    }
}
