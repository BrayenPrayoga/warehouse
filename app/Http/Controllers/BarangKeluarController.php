<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\ProsesKeluar;
use App\Models\ProsesMasuk;
use App\Models\SewaGudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class BarangKeluarController extends Controller
{
    //
    function __construct(){
        // $this->middleware('auth');
    }

    public function index(){
        date_default_timezone_set('Asia/Jakarta');

        $data['no'] = 1;
        $data['data'] = Barang::with('RelasiKategori')->join('tabel_proses_keluar','id_barang','tabel_barang.id')->where('status', 3)->orderBy('tabel_barang.id','DESC')->get();

        return view('barang_keluar', $data);
    }

    public function checkBarang(){
        $kode_barang = $_GET['kode_barang'];
        $check_barang = Barang::where('kode_barang', $kode_barang)->first();

        if($check_barang){
            if($check_barang->status == 0){
                return ([ 'status' => 0,'data' => '' ]);
            }elseif($check_barang->status == 1){
                return ([ 'status' => 1,'data' => '' ]);
            }elseif($check_barang->status == 2){
                // Update Status Barang
                Barang::where('kode_barang', $kode_barang)->update(['status'=>3]);

                //Create Or Update ke Proses Barang
                ProsesKeluar::updateOrCreate(
                    ['id_barang' => $check_barang->id],
                    [
                        'id_barang'     => $check_barang->id,
                        'tanggal_keluar' => date('Y-m-d H:i:s'),
                        'created_at'    => date('Y-m-d H:i:s')
                    ]);

                $proses_masuk = ProsesMasuk::where('id_barang', $check_barang->id)->first();
                $proses_keluar = ProsesKeluar::where('id_barang', $check_barang->id)->first();
                $tanggal_masuk = new DateTime($proses_masuk->tanggal_masuk);
                $tanggal_keluar = new DateTime($proses_keluar->tanggal_keluar);
                $selisih = $tanggal_masuk->diff($tanggal_keluar);

                $berat = $check_barang->berat;
                $biaya = $selisih->d * $berat * 2100;

                SewaGudang::updateOrCreate(
                    ['id_barang' => $check_barang->id],
                    [
                        'id_barang'         => $check_barang->id,
                        'tanggal_masuk'     => $tanggal_masuk,
                        'tanggal_keluar'    => $tanggal_keluar,
                        'biaya'             => $biaya,
                        'created_at'        => date('Y-m-d H:i:s')
                    ]);

                $barang = Barang::with('RelasiKategori')->join('tabel_proses_keluar','id_barang','tabel_barang.id')->where('status', 3)->orderBy('tabel_barang.id','DESC')->get();
                return ([ 'status' => 2,'data' => $barang ]);
            }elseif($check_barang->status == 3){
                return ([ 'status' => 3,'data' => '' ]);
            }
        }else{
            return false;
        }
    }
}
