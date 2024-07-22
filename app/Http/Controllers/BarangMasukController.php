<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\MasterRak;
use App\Models\ProsesMasuk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangMasukController extends Controller
{
    //
    function __construct(){
        // $this->middleware('auth');
    }

    public function index(){
        date_default_timezone_set('Asia/Jakarta');

        $data['no'] = 1;
        $data['data'] = Barang::join('tabel_proses_masuk','id_barang','tabel_barang.id')->where('status', 1)->orderBy('tabel_barang.id','ASC')->get();
        $data['rak'] = MasterRak::orderBy('id','ASC')->get();

        return view('barang_masuk', $data);
    }

    public function checkBarang(){
        $kode_barang = $_GET['kode_barang'];
        $check_barang = Barang::where('kode_barang', $kode_barang)->first();

        if($check_barang){
            if($check_barang->status == 0){
                // Update Status Barang
                Barang::where('kode_barang', $kode_barang)->update(['status'=>1]);

                //Create Or Update ke Proses Barang
                ProsesMasuk::updateOrCreate(
                    ['id_barang' => $check_barang->id],
                    [
                        'id_barang'     => $check_barang->id,
                        'tanggal_masuk' => date('Y-m-d H:i:s'),
                        'created_at'    => date('Y-m-d H:i:s')
                    ]);

                $barang = Barang::with('RelasiKategori','RelasiRak')->join('tabel_proses_masuk','id_barang','tabel_barang.id')->where('status', 1)->orderBy('tabel_barang.id','ASC')->get();
                return ([ 'status' => 0,'data' => $barang ]);
            }elseif($check_barang->status == 1){
                return ([ 'status' => 1,'data' => '' ]);
            }elseif($check_barang->status == 2){
                return ([ 'status' => 2,'data' => '' ]);
            }elseif($check_barang->status == 3){
                return ([ 'status' => 3,'data' => '' ]);
            }
        }else{
            return false;
        }
    }
    
    public function update(Request $request){
        $response = ProsesMasuk::updateModel($request);

        if($response['message'] == 'success'){
            return redirect()->back()->with(['success'=>'Berhasil Update']);
        }else{
            return redirect()->back()->with(['error'=>$response['data']]);
        }
    }
}
