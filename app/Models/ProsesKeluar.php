<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProsesKeluar extends Model
{
    use HasFactory;

    protected $table = 'tabel_proses_keluar';
    
    protected $guarded = [];

    public static function storeModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');
            $date = date('Y-m-d H:i:s');

            $request->validate([
                'id_barang' => 'required',
            ]);

            Barang::where('id', $request->id_barang)->update(['status'=>2]);

            return ['message' => 'success', 'data' => 'Berhasil Simpan'];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
