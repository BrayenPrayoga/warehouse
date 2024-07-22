<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterKategori extends Model
{
    use HasFactory;

    protected $table = 'master_kategori';
    
    protected $guarded = [];

    public static function storeModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'kategori'              =>'required|max:255',
            ]);

            $data = [
                'kategori'          => $request->kategori,
                'created_at'        => date('Y-m-d H:i:s')
            ];
            $banner = MasterKategori::create($data);

            return ['message' => 'success', 'data' => $banner];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function updateModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'kategori'              =>'required|max:255',
            ]);

            $data = [
                'kategori'      => $request->kategori,
                'updated_at'    => date('Y-m-d H:i:s')
            ];
            $banner = MasterKategori::where('id', $request->id)->update($data);

            return ['message' => 'success', 'data' => $banner];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public static function deleteModal($id){
        try{
            MasterKategori::where('id', $id)->delete();
            
            return ['message' => 'success', 'data' => 'Berhasil Hapus'];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
