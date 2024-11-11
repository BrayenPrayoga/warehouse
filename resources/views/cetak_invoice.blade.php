<html>

<head>
    <title>Faktur Pembayaran</title>
    <style>
        #tabel {
            font-size: 15px;
            border-collapse: collapse;
        }

        #tabel td {
            padding-left: 5px;
            border: 1px solid black;
        }
    </style>
</head>

<body style='font-family:tahoma; font-size:8pt;'>
    <center>
        <table style='width:100%; font-size:8pt; font-family:calibri; border-collapse: collapse;' border='0'>
            <td width='100%' align='left' style='padding-right:80px; vertical-align:top'>
                <span style='font-size:12pt'><b>Warehouse</b></span></br>
                Alamat Toko Alamat Toko Alamat Toko Alamat Toko Alamat Toko Alamat Toko Alamat Toko Alamat Toko Alamat
                Toko Alamat Toko </br>
                <b>Telp</b> : 021-123456789
            </td>
            <td style='vertical-align:top' width='100%' align='left'>
                <b><span style='font-size:12pt'>FAKTUR PENJUALAN</span></b></br>
                <b>No Trans.</b> : INV.{{ date('Ymd') }}.{{ $barang->id }}</br>
                <b>Tanggal</b> : {{ tgl_indo($date) }}</br>
            </td>
        </table>
        <br>
        <table cellspacing='0' style='width:100%; font-size:8pt; font-family:calibri;  border-collapse: collapse;'
            border='1'>

            <tr align='center'>
                <td>Kode Barang</td>
                <td>Nama Barang</td>
                <td>Tanggal Masuk</td>
                <td>Tanggal Keluar</td>
                <td>Waktu Penyimpanan</td>
                <td>Berat (Kg)</td>
                <td>Harga Per Hari</td>
            </tr>
            <tr>
                <td>{{ $barang->kode_barang }}</td>
                <td>{{ $barang->nama }}</td>
                <td>{{ $barang->tanggal_masuk }}</td>
                <td>{{ $barang->tanggal_keluar }}</td>
                <td>{{ $selisih->d }} Hari</td>
                <td>{{ number_format($barang->berat,2,',','.') }}</td>
                <td style='text-align:right'>Rp 2.100,00</td>
            </tr>

            <tr>
                <td colspan='6'>
                    <div style='text-align:right'>Total Yang Harus Di Bayar : </div>
                </td>
                <td style='text-align:right'>Rp {{ number_format($barang->biaya,2,',','.') }}</td>
            </tr>
            <tr>
                <td colspan='7'>
                    <div style='text-align:right'>Terbilang : {{ TerbilangRupiah($barang->biaya) }}</div>
                </td>
            </tr>
            {{-- <tr>
                <td colspan='6'>
                    <div style='text-align:right'>Sisa : </div>
                </td>
                <td style='text-align:right'>Rp0,00</td>
            </tr> --}}
        </table>

        {{-- <table style='width:650; font-size:7pt;' cellspacing='2'>
            <tr>
                <td align='center'>Diterima Oleh,</br></br><u>(............)</u></td>
                <td style='border:1px solid black; padding:5px; text-align:left; width:30%'></td>
                <td align='center'>TTD,</br></br><u>(...........)</u></td>
            </tr>
        </table> --}}
    </center>
</body>

</html>