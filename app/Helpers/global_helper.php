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
?>