<?php
use App\Constants\ErrorCode as EC;
use App\Constants\ErrorMessage as EM;

    if(!function_exists('tgl_indo')){
        function tgl_indo($tanggal)
        {
            $bulan = array(
                1 =>   'Januari',
                'Februari',
                'Maret',
                'April',
                'Mei',
                'Juni',
                'Juli',
                'Agustus',
                'September',
                'Oktober',
                'November',
                'Desember'
            );
            $pecahkan = explode('-', $tanggal);

            return $pecahkan[2] . ' ' . $bulan[(int) $pecahkan[1]] . ' ' . $pecahkan[0];
        }
    }
    
    if(!function_exists('responseData')){
        function responseData($data = false, $paginate = null)
        {
            if ($paginate == null) {
                $response = [
                    "meta" => ['code' => EC::HTTP_OK, 'message' => EM::HTTP_OK],
                    "data" => $data
                ];
            } else {
                $response = [
                    "meta" => ['code' => EC::HTTP_OK, 'message' => EM::HTTP_OK, 'page' => $paginate],
                    "data" => $data
                ];
            }

            return response()->json($response, 200);
        }
    }

    
if(! function_exists('TerbilangRupiah')){
    function TerbilangRupiah($angka){
        $angka = (float)$angka;
        $bilangan = array('','Satu','Dua','Tiga','Empat','Lima','Enam','Tujuh','Delapan','Sembilan','Sepuluh','Sebelas');

        if ($angka < 12) {
            return $bilangan[$angka];
        } else if ($angka < 20) {
            return $bilangan[$angka - 10] . ' Belas';
        } else if ($angka < 100) {
            $hasil_bagi = (int)($angka / 10);
            $hasil_mod = $angka % 10;
            return trim(sprintf('%s Puluh %s', $bilangan[$hasil_bagi], $bilangan[$hasil_mod]));
        } else if ($angka < 200) {
            return sprintf('Seratus %s', TerbilangRupiah($angka - 100));
        } else if ($angka < 1000) {
            $hasil_bagi = (int)($angka / 100);
            $hasil_mod = $angka % 100;
            return trim(sprintf('%s Ratus %s', $bilangan[$hasil_bagi], TerbilangRupiah($hasil_mod)));
        } else if ($angka < 2000) {
            return trim(sprintf('Seribu %s', TerbilangRupiah($angka - 1000)));
        } else if ($angka < 1000000) {
            $hasil_bagi = (int)($angka / 1000);
            $hasil_mod = $angka % 1000;
            return sprintf('%s Ribu %s', TerbilangRupiah($hasil_bagi), TerbilangRupiah($hasil_mod));
        } else if ($angka < 1000000000) {
            $hasil_bagi = (int)($angka / 1000000);
            $hasil_mod = $angka % 1000000;
            return trim(sprintf('%s Juta %s', TerbilangRupiah($hasil_bagi), TerbilangRupiah($hasil_mod)));
        } else if ($angka < 1000000000000) {
            $hasil_bagi = (int)($angka / 1000000000);
            $hasil_mod = fmod($angka, 1000000000);
            return trim(sprintf('%s Milyar %s', TerbilangRupiah($hasil_bagi), TerbilangRupiah($hasil_mod)));
        } else if ($angka < 1000000000000000) {
            $hasil_bagi = $angka / 1000000000000;
            $hasil_mod = fmod($angka, 1000000000000);
            return trim(sprintf('%s Triliun %s', TerbilangRupiah($hasil_bagi), TerbilangRupiah($hasil_mod)));
        } else {
            return 'Data Salah';
        }
    }
}
?>