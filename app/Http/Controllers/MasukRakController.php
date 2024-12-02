<?php

namespace App\Http\Controllers;

use App\Models\MasterRak;
use App\Models\Barang;
use Illuminate\Http\Request;

class MasukRakController extends Controller
{
    //
    function __construct(){
        // $this->middleware('auth:admin');
    }

    public function index(){
        date_default_timezone_set('Asia/Jakarta');

        $data['no'] = 1;
        $data['data'] = Barang::join('tabel_proses_masuk','id_barang','tabel_barang.id')->where('status', 1)->whereNotNull('id_rak')->orderBy('tabel_proses_masuk.tanggal_masuk','DESC')->get();
        $data['rak'] = MasterRak::orderBy('id','ASC')->get();

        return view('masuk_rak', $data);
    }
    
    public function checkBarang(){
        date_default_timezone_set('Asia/Jakarta');
        
        $kode_rak = $_GET['kode_rak'];
        $kode_barang = $_GET['kode_barang'];

        $check_rak = MasterRak::where('kode_rak', $kode_rak)->first();
        $check_barang = Barang::where('kode_barang', $kode_barang)->first();

        if($check_rak){
            if($check_barang){
                if($check_barang->status == 0){
                    return ([ 'status' => 0,'data' => '' ]);
                }elseif($check_barang->status == 1){

                    // Update Status Barang
                    Barang::where('kode_barang', $kode_barang)->update(['id_rak'=>$check_rak->id]);

                    $barang = Barang::with('RelasiKategori','RelasiRak')->join('tabel_proses_masuk','id_barang','tabel_barang.id')->where('status', 1)->whereNotNull('id_rak')->orderBy('tabel_proses_masuk.tanggal_masuk','DESC')->get();
                    
                    return ([ 'status' => 1,'data' => $barang ]);
                }elseif($check_barang->status == 2){
                    return ([ 'status' => 2,'data' => '' ]);
                }elseif($check_barang->status == 3){
                    return ([ 'status' => 3,'data' => '' ]);
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

}
