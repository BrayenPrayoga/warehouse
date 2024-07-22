<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProsesMasuk extends Model
{
    use HasFactory;

    protected $table = 'tabel_proses_masuk';
    
    protected $guarded = [];
    
    public static function updateModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'rak' =>'required',
            ]);

            $data = [
                'id_rak'      => $request->rak,
                'updated_at'    => date('Y-m-d H:i:s')
            ];
            $banner = Barang::where('id', $request->id_barang)->update($data);

            return ['message' => 'success', 'data' => $banner];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
