<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\ProsesMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangKeluarController extends Controller
{
    //
    function __construct(){
        // $this->middleware('auth');
    }

    public function index(){
        date_default_timezone_set('Asia/Jakarta');

        $data['no'] = 1;
        $data['data'] = Barang::with('RelasiKategori')->join('tabel_proses_keluar','id_barang','tabel_barang.id')->where('status', 3)->orderBy('tabel_barang.id','ASC')->get();

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
                ProsesMasuk::updateOrCreate(
                    ['id_barang' => $check_barang->id],
                    [
                        'id_barang'     => $check_barang->id,
                        'tanggal_masuk' => date('Y-m-d H:i:s'),
                        'created_at'    => date('Y-m-d H:i:s')
                    ]);

                $barang = Barang::with('RelasiKategori')->join('tabel_proses_keluar','id_barang','tabel_barang.id')->where('status', 3)->orderBy('tabel_barang.id','ASC')->get();
                return ([ 'status' => 2,'data' => $barang ]);
            }elseif($check_barang->status == 3){
                return ([ 'status' => 3,'data' => '' ]);
            }
        }else{
            return false;
        }
    }
}
