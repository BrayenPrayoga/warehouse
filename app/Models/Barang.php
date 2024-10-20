<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'tabel_barang';

    const DAFTAR_BARANG_MASUK = NULL; 
    const BARANG_MASUK = 1; 
    const DAFTAR_BARANG_KELUAR = 2; 
    const BARANG_KELUAR = 3; 
    
    protected $guarded = [];
    
    public static function storeModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d H:i:s');

            $request->validate([
                'kode_barang'  =>'required|max:50',
                'nama_barang'  =>'required|max:255',
                'kategori'     =>'required',
                'nama_pemilik' =>'required|max:255',
                'alamat'       =>'required',
                'berat'        =>'required',
            ]);

            $data = [
                'id_users'      => auth::user()->id,
                'kode_barang'   => $request->kode_barang,
                'nama'          => $request->nama_barang,
                'id_kategori'   => $request->kategori,
                'nama_pemilik'  => $request->nama_pemilik,
                'alamat'        => $request->alamat,
                'berat'         => str_replace(',','.',$request->berat),
                'created_at'    => $date
            ];
            $store = Barang::create($data);

            return ['message' => 'success', 'data' => $store];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function updateModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d H:i:s');

            $request->validate([
                'kode_barang'  =>'required|max:50',
                'nama_barang'  =>'required|max:255',
                'kategori'     =>'required',
                'nama_pemilik' =>'required|max:255',
                'alamat'       =>'required',
                'berat'        =>'required',
            ]);

            $data = [
                'id_users'      => auth::user()->id,
                'kode_barang'   => $request->kode_barang,
                'nama'          => $request->nama_barang,
                'id_kategori'   => $request->kategori,
                'nama_pemilik'  => $request->nama_pemilik,
                'alamat'        => $request->alamat,
                'berat'         => str_replace(',','.',$request->berat),
                'created_at'    => $date
            ];
            $banner = Barang::where('id', $request->id)->update($data);

            return ['message' => 'success', 'data' => $banner];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public static function deleteModel($id_barang){
        try{
            Barang::where('id', $id_barang)->update(['status'=>1]);
            ProsesKeluar::where('id_barang', $id_barang)->delete();
            
            return ['message' => 'success', 'data' => 'Berhasil Hapus'];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public function RelasiKategori(){
        return $this->belongsTo(MasterKategori::class,'id_kategori','id')->withDefault(['kategori'=>'']);
    }
    
    public function RelasiRak(){
        return $this->belongsTo(MasterRak::class,'id_rak','id')->withDefault(['kategori'=>'']);
    }
}
