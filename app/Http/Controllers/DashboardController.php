<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use DB;

class DashboardController extends Controller
{
    //
    function __construct(){
        // $this->middleware('auth');
    }

    public function index(){
        $data['tanggal'] = Barang::select(DB::raw('DATE(created_at) as created_date'))->groupBy('created_at')->orderBy('created_at','ASC')->get();

        return view('dashboard', $data);
    }


    public function chartColumnHarian(){
        date_default_timezone_set('Asia/Jakarta');

        $tanggal = ($_GET['tanggal']) ? $_GET['tanggal'] : date('Y-m-d');
    
        $barang_masuk = Barang::select(DB::raw('COUNT(*) as jumlah'), DB::raw('SUM(berat) as berat'))->join('tabel_proses_masuk','tabel_proses_masuk.id_barang','tabel_barang.id')
                    ->whereIn('status', [1,2,3])->whereDate('tabel_proses_masuk.tanggal_masuk', $tanggal)->get();
        $barang_keluar = Barang::select(DB::raw('COUNT(*) as jumlah'), DB::raw('SUM(berat) as berat'))->join('tabel_proses_keluar','tabel_proses_keluar.id_barang','tabel_barang.id')
                    ->where('status', 3)->whereDate('tabel_proses_keluar.tanggal_keluar', $tanggal)->get();

        $jumlah_barang_masuk = (count($barang_masuk)!=0) ? $barang_masuk[0]->jumlah : 0;
        $jumlah_barang_keluar = (count($barang_keluar)!=0) ? $barang_keluar[0]->jumlah : 0;
        $jumlah_barang_gudang = $jumlah_barang_masuk - $jumlah_barang_keluar;
        
        $berat_barang_masuk = (count($barang_masuk)!=0) ? (float)$barang_masuk[0]->berat : 0;
        $berat_barang_keluar = (count($barang_keluar)!=0) ? (float)$barang_keluar[0]->berat : 0;
        $berat_barang_gudang = $berat_barang_masuk - $berat_barang_keluar;

        $jumlah = [$jumlah_barang_masuk, $jumlah_barang_keluar, $jumlah_barang_gudang];
        $berat = [$berat_barang_masuk, $berat_barang_keluar, $berat_barang_gudang];

        return ([
            'tanggal' => $tanggal,
            'jumlah' => $jumlah,
            'berat' => $berat
        ]);
    }

    public function chartColumnBulanan(){
        $series = [];
        $category = [];
        $cat = [];

        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember',
        ];

        foreach($bulan as $cat){
            $category[] = $cat;
        }

        foreach($bulan as $key=>$item){
            $barang_masuk = Barang::select(DB::raw('COUNT(*) as jumlah'), DB::raw('SUM(berat) as berat'))->join('tabel_proses_masuk','tabel_proses_masuk.id_barang','tabel_barang.id')
                    ->whereIn('status', [1,2,3])->whereMonth('tabel_barang.created_at', $key)->get();
            $barang_keluar = Barang::select(DB::raw('COUNT(*) as jumlah'), DB::raw('SUM(berat) as berat'))->join('tabel_proses_keluar','tabel_proses_keluar.id_barang','tabel_barang.id')
                    ->where('status', 3)->whereMonth('tabel_barang.created_at', $key)->get();

            $data_barang_masuk[] = (count($barang_masuk)!=0) ? $barang_masuk[0]->jumlah : 0;
            $data_barang_keluar[] = (count($barang_keluar)!=0) ? $barang_keluar[0]->jumlah : 0;
            $data_barang_gudang[] = ((count($barang_masuk)!=0) ? $barang_masuk[0]->jumlah : 0) - ((count($barang_keluar)!=0) ? $barang_keluar[0]->jumlah : 0);

        }
        $jumlah_barang_masuk = $data_barang_masuk;
        $jumlah_barang_keluar = $data_barang_keluar;
        $jumlah_barang_gudang = $data_barang_gudang;

        return ([
            'category' => $category,
            'barang_masuk' => $jumlah_barang_masuk,
            'barang_keluar' => $jumlah_barang_keluar,
            'barang_gudang' => $jumlah_barang_gudang
        ]);
    }
    
    public function chartPie(){
        $series = [];
        $count_barang = Barang::whereIn('status',[1,2,3])->orWhereNull('status')->count();
        
        $barang_masuk = Barang::select(DB::raw('COUNT(*) as jumlah'), DB::raw('SUM(berat) as berat'))->join('tabel_proses_masuk','tabel_proses_masuk.id_barang','tabel_barang.id')
                ->whereIn('status', [1,2,3])->get();
        $barang_keluar = Barang::select(DB::raw('COUNT(*) as jumlah'), DB::raw('SUM(berat) as berat'))->join('tabel_proses_keluar','tabel_proses_keluar.id_barang','tabel_barang.id')
                ->where('status', 3)->get();

        $data_barang_masuk = (count($barang_masuk)!=0) ? $barang_masuk[0]->jumlah : 0;
        $data_barang_keluar = (count($barang_keluar)!=0) ? $barang_keluar[0]->jumlah : 0;
        $data_barang_gudang = ((count($barang_masuk)!=0) ? $barang_masuk[0]->jumlah : 0) - ((count($barang_keluar)!=0) ? $barang_keluar[0]->jumlah : 0);
        $jumlah_seluruh = $data_barang_masuk + $data_barang_keluar + $data_barang_gudang;

        if($count_barang != 0){
            $persentase_barang_masuk = $data_barang_masuk / $count_barang * 100;
            $persentase_barang_keluar = $data_barang_keluar / $count_barang * 100;
            $persentase_barang_gudang = $data_barang_gudang / $count_barang * 100;
        }else{
            $persentase_barang_masuk = 0;
            $persentase_barang_keluar = 0;
            $persentase_barang_gudang = 0;
        }

        $category_masuk[] = 'Barang Masuk';
        $category_masuk[] = Round($persentase_barang_masuk,2);
        $series[] = $category_masuk;
        $category_keluar[] = 'Barang Keluar';
        $category_keluar[] = Round($persentase_barang_keluar,2);
        $series[] = $category_keluar;
        $category_gudang[] = 'Barang Di Gudang';
        $category_gudang[] = Round($persentase_barang_gudang,2);
        $series[] = $category_gudang;

        return ([
            'series' => $series
        ]);
    }
    
}
