<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    function __construct(){
        // $this->middleware('auth');
    }

    public function index(){
        $data['startYear'] = date('Y') - 10;
        $data['Year'] = date('Y');

        return view('dashboard', $data);
    }

    public function chartColumn(){
        $series = [];
        $category = [];
        $cat = [];

        $tahun = $_GET['tahun'];
        $terjual = Transaksi::with('RelasiDetailTransaksi')->whereYear('tanggal_transaksi', $tahun)->get();

        foreach($terjual as $item){
            foreach($item->RelasiDetailTransaksi as $val){
                if(!in_array($val->id_produk, $cat, true)){
                    array_push($cat, $val->id_produk);
                }
            }
        }

        if(count($terjual) > 0){
            foreach($cat as $item){
                $produk = Produk::where('id',$item)->first();
                $category[] = ($produk) ? $produk->produk : '-';
                $series[] = DetailTransaksi::where('id_produk', $item)->count();
            }
        }else{
            $category[] = ['-'];
            $series[] = [0];
        }

        return ([
            'tahun' => $tahun,
            'category' => $category,
            'series' => $series
        ]);
    }
    
    public function chartPie(){
        $series = [];
        $cat = [];

        $tahun = $_GET['tahun'];
        $terjual = Transaksi::with('RelasiDetailTransaksi')->whereYear('tanggal_transaksi', $tahun)->get();

        foreach($terjual as $item){
            foreach($item->RelasiDetailTransaksi as $val){
                if(!in_array($val->id_produk, $cat, true)){
                    array_push($cat, $val->id_produk);
                }
            }
        }

        if(count($terjual) > 0){
            foreach($cat as $item){
                $produk = Produk::where('id',$item)->first();
                $jumlah_produk_terjual = DetailTransaksi::where('id_produk', $item)->count();
                $persentase = $jumlah_produk_terjual / $produk->stok * 100;

                $category[] = ($produk) ? $produk->produk : '-';
                $category[] = Round($persentase,2);
                $series[] = $category;
                $category = [];
            }
        }else{
            $category[] = ['-'];
            $series[] = [0];
        }

        return ([
            'tahun' => $tahun,
            'series' => $series
        ]);
    }
}
