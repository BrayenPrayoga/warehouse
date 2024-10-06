<?php
namespace App\Imports;

use App\Models\Barang;
use App\Models\MasterKategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\Auth;


class importBarangKeluar implements ToModel, WithStartRow
{
    public function startRow(): int
    {
        return 2; // Mulai impor dari baris ke-2 (misal, baris pertama adalah header)
    }
    /**
     * Method ini akan dipanggil setiap baris pada file Excel
     */
    public function model(array $row)
    {
        date_default_timezone_set('Asia/Jakarta');
        $date = date('Y-m-d H:i:s');
        $kategori = MasterKategori::whereRaw('LOWER(kategori) = ?', [strtolower($row[3])])->first();
        $barang = Barang::where('kode_barang', $row[1])->where('status', 1)->whereNotNull('id_rak')->first();

        if(!empty($barang) && !empty($row[1])){
            return Barang::updateOrCreate(
                [
                    'kode_barang' => $row[1], 
                ],
                [
                    'status' => 2,
                ]
            );
        }
    }
}
?>