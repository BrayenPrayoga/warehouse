<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $data['data'] = Barang::select('tabel_barang.id','tabel_barang.kode_barang','tabel_barang.nama','tabel_barang.berat','tabel_proses_masuk.tanggal_masuk','tabel_proses_keluar.tanggal_keluar','sewa_gudang.biaya')
                        ->join('tabel_proses_masuk','tabel_proses_masuk.id_barang','tabel_barang.id')
                        ->join('tabel_proses_keluar','tabel_proses_keluar.id_barang','tabel_barang.id')
                        ->join('sewa_gudang','sewa_gudang.id_barang','tabel_barang.id')
                        ->where('status', 3)
                        ->orderBy('tabel_barang.id','DESC')
                        ->get();

        return view('sewa_barang', $data);
    }

    public function cetakInvoice($id_barang){
        date_default_timezone_set('Asia/Jakarta');
        $data['date'] = date('Y-m-d');

        $id_barang = base64_decode($id_barang);
        $data['barang'] = Barang::where('tabel_barang.id', $id_barang)
                        ->join('tabel_proses_masuk','tabel_proses_masuk.id_barang','tabel_barang.id')
                        ->join('tabel_proses_keluar','tabel_proses_keluar.id_barang','tabel_barang.id')
                        ->join('sewa_gudang','sewa_gudang.id_barang','tabel_barang.id')
                        ->first();
                        
        $tanggal_masuk = new DateTime($data['barang']->tanggal_masuk);
        $tanggal_keluar = new DateTime($data['barang']->tanggal_keluar);
        $data['selisih'] = $tanggal_masuk->diff($tanggal_keluar);

        // return view('cetak_invoice', $data);
        $pdf = Pdf::loadView('cetak_invoice', $data);
        $pdf->setPaper('B5', 'landscape');
        return $pdf->stream('Invoice_'.$data['date'].'.pdf');
    }

}
