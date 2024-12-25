@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-bullhorn"></i>
                </span> Sewa Barang
            </h3>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Sewa Barang</h4>
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <strong>Error!</strong> {{ $error }}
                            </div>
                            @endforeach
                        @endif
                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-md-12 d-flex">
                                    <button type="button" class="btn btn-sm btn-dark btn-fw" onclick="exportTableToExcel()">
                                        <i class="mdi mdi-file-excel"></i>Export
                                    </button>
                                </div>
                            </div>
                            <table class="table" id="table-id">
                                <thead>
                                    <tr>
                                        <th> No. </th>
                                        <th> Kode Barang </th>
                                        <th> Barang </th>
                                        <th> Tanggal Masuk </th>
                                        <th> Tanggal Keluar </th>
                                        <th> Berat </th>
                                        <th> Biaya </th>
                                        <th> Aksi </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td> {{ $item->kode_barang }} </td>
                                        <td> {{ $item->nama }} </td>
                                        <td> {{ $item->tanggal_masuk }} </td>
                                        <td> {{ $item->tanggal_keluar }} </td>
                                        <td> {{ number_format($item->berat,2,',','.') }} </td>
                                        <td> {{ number_format($item->biaya,2,',','.') }} </td>
                                        <td>
                                            @if(Auth::guard('admin')->check())
                                            <a href="{{ route('admin.sewa-barang.cetak.invoice',[base64_encode($item->id)]) }}" target="_blank" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-printer"></i></a>
                                            @elseif(Auth::guard('supervisor')->check())
                                            <a href="{{ route('supervisor.sewa-barang.cetak.invoice',[base64_encode($item->id)]) }}" target="_blank" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-printer"></i></a>
                                            @else
                                            <a href="{{ route('user.sewa-barang.cetak.invoice',[base64_encode($item->id)]) }}" target="_blank" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-printer"></i></a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('javascript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script>
    $(document).ready( function () {
        $('#table-id').DataTable();
    });
    
    function exportTableToExcel() {
        var table = document.getElementById("table-id");

        // Buat salinan tabel tanpa kolom terakhir
        var tempTable = table.cloneNode(true);
        var rows = tempTable.rows;

        for (var i = 0; i < rows.length; i++) {
            rows[i].deleteCell(-1); // Hapus kolom terakhir di setiap baris
        }

        // Buat workbook dan worksheet dari salinan tabel
        var wb = XLSX.utils.table_to_book(tempTable, { sheet: "Sheet1" });

        // Ekspor workbook ke file Excel
        XLSX.writeFile(wb, "data-sewa-barang.xlsx");
    }
</script>

@if(Session::has('success'))
    <script type="text/javascript">
        Swal.fire({
        icon: 'success',
        text: '{{Session::get("success")}}',
        showConfirmButton: false,
        timer: 1500
    });
    </script>
    <?php
        Session::forget('success');
    ?>
@endif
@if(Session::has('error'))
    <script type="text/javascript">
        Swal.fire({
        icon: 'error',
        text: '{{Session::get("error")}}',
        showConfirmButton: false,
        timer: 1500
    });
    </script>
    <?php
        Session::forget('error');
    ?>
@endif
@endsection