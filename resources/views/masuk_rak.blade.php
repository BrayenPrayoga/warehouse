@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-bullhorn"></i>
                </span> Masuk Rak
            </h3>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Masuk Rak</h4>
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
                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="col-md-4">
                                        <label>RAK</label>
                                        <input type="text" class="form-control" id="kode_rak" name="kode_rak">
                                    </div>
                                    <div class="col-md-4">
                                        <label>KODE BARANG</label>
                                        <input type="text" class="form-control" id="kode_barang" name="kode_barang">
                                    </div>
                                    <button type="button" id="buttonAdd" class="btn btn-sm btn-success btn-fw" onclick="changeStatus()" style="margin-top:23px;">
                                        <i class="mdi mdi-plus"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-dark btn-fw" onclick="exportTableToExcel()" style="margin-top:23px;">
                                        <i class="mdi mdi-file-excel"></i>Export
                                    </button>
                                </div>
                            </div>
                            <table class="table" id="table-id">
                                <thead>
                                    <tr>
                                        <th> No. </th>
                                        <th> Kode Barang </th>
                                        <th> Rak </th>
                                        <th> Barang </th>
                                        <th> Kategori </th>
                                        <th> Nama Pemilik </th>
                                        <th> Alamat </th>
                                        <th> Berat </th>
                                        <th> Tanggal Masuk </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td> {{ $item->kode_barang }} </td>
                                        <td> {{ $item->RelasiRak->nama }} </td>
                                        <td> {{ $item->nama }} </td>
                                        <td> {{ $item->RelasiKategori->kategori }} </td>
                                        <td> {{ $item->nama_pemilik }} </td>
                                        <td> {{ $item->alamat }} </td>
                                        <td> {{ $item->berat }} </td>
                                        <td> {{ $item->tanggal_masuk }} </td>
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

        $("#kode_barang").keyup(function(event) {
            if (event.keyCode === 13) {
                changeStatus();
            }
        });
    });

    function changeStatus(){
        @if(Auth::guard('admin')->check())
            var url = "{{ route('admin.masuk-rak.checkBarang') }}";
        @elseif(Auth::guard('supervisor')->check())
            var url = "{{ route('supervisor.masuk-rak.checkBarang') }}";
        @else
            var url = "{{ route('user.barang-masuk.checkBarang') }}";
        @endif

        var kode_rak = $('#kode_rak').val();
        var kode_barang = $('#kode_barang').val();
            if(kode_rak && kode_barang){
                $.ajax({
                    type: 'GET',
                    url: url,
                    data : {kode_rak:kode_rak,kode_barang:kode_barang},
                    success: function(response){
                        if(response.status == 0){
                            Swal.fire({
                                icon: "info",
                                title: "Barang Tidak Tersedia",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }else if(response.status == 1){
                            Swal.fire({
                                icon: "info",
                                title: "Barang Masuk Rak",
                                showConfirmButton: false,
                                timer: 1500
                            });
                            $('#table-id').DataTable().clear().draw();
                            var table = $('#table-id').DataTable();
                            console.log();
                            $.each(response.data, function(i ,val){
                                var no = i + 1;
                                var berat = val.berat;
                                table.row.add([
                                    no,
                                    val.kode_barang,
                                    (val.relasi_rak.nama) ? val.relasi_rak.nama : '',
                                    val.nama,
                                    val.relasi_kategori.kategori,
                                    val.nama_pemilik,
                                    val.alamat,
                                    val.berat,
                                    val.tanggal_masuk
                                ]).draw();
                            })
                        }else if(response.status == 2){
                            Swal.fire({
                                icon: "info",
                                title: "Barang Proses Keluar",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }else if(response.status == 3){
                            Swal.fire({
                                icon: "info",
                                title: "Barang Sudah Keluar",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }else{
                            Swal.fire({
                                icon: "info",
                                title: "Rak atau Barang Tidak Ditemukan",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    }
                });
            }else{
                Swal.fire({
                    icon: "info",
                    title: "Rak dan Kode Barang Tidak Boleh Kosong",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        $('#kode_barang').val('');
    }

    function edit(obj){
        var item = $(obj).data('item');

        $('#id_barang').val(item.id_barang);
        $('#rak').val(item.id_rak);

        $('#rak').val(0);
        $('#EditModal').modal('show');
    }
    
    function exportTableToExcel() {
        var table = document.getElementById("table-id");

        // Buat salinan tabel tanpa kolom terakhir
        var tempTable = table.cloneNode(true);
        var rows = tempTable.rows;

        // for (var i = 0; i < rows.length; i++) {
        //     rows[i].deleteCell(-1); // Hapus kolom terakhir di setiap baris
        // }

        // Buat workbook dan worksheet dari salinan tabel
        var wb = XLSX.utils.table_to_book(tempTable, { sheet: "Sheet1" });

        // Ekspor workbook ke file Excel
        XLSX.writeFile(wb, "masuk-rak.xlsx");
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