<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRak extends Model
{
    use HasFactory;

    protected $table = 'master_rak';
    
    protected $guarded = [];

    public static function storeModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'nama'              =>'required|max:255',
                'lokasi'              =>'required|max:255'
            ]);

            $data = [
                'nama'              => $request->nama,
                'lokasi'            => $request->lokasi,
                'created_at'        => date('Y-m-d H:i:s')
            ];
            $banner = MasterRak::create($data);

            return ['message' => 'success', 'data' => $banner];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
    
    public static function updateModel($request){
        try{
            date_default_timezone_set('Asia/Jakarta');

            $request->validate([
                'nama'              =>'required|max:255',
                'lokasi'              =>'required|max:255'
            ]);

            $data = [
                'nama'              => $request->nama,
                'lokasi'            => $request->lokasi,
                'updated_at'    => date('Y-m-d H:i:s')
            ];
            $banner = MasterRak::where('id', $request->id)->update($data);

            return ['message' => 'success', 'data' => $banner];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }

    public static function deleteModal($id){
        try{
            MasterRak::where('id', $id)->delete();
            
            return ['message' => 'success', 'data' => 'Berhasil Hapus'];
        }catch(Exception $e){
            return ['message' => 'error','data' => $e];
        }
    }
}
