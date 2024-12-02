@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-bullhorn"></i>
                </span> Barang Masuk
            </h3>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Barang Masuk</h4>
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
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="kode_barang" name="kode_barang">
                                    </div>
                                    <button type="button" id="buttonAdd" class="btn btn-sm btn-success btn-fw" onclick="changeStatus()">
                                        <i class="mdi mdi-plus"></i>
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
            var url = "{{ route('admin.barang-masuk.checkBarang') }}";
        @elseif(Auth::guard('supervisor')->check())
        var url = "{{ route('supervisor.barang-masuk.checkBarang') }}";
        @else
            var url = "{{ route('user.barang-masuk.checkBarang') }}";
        @endif

        var kode_barang = $('#kode_barang').val();
        console.log(kode_barang);
        // Swal.fire({
        //     icon: "question",
        //     title: "Apakah Ingin Menyimpan Barang?",
        //     showCancelButton: true,
        //     cancelButtonText: "CANCEL",
        //     confirmButtonText: "SIMPAN"
        //     }).then((result) => {
                // if (result.isConfirmed) {
                    if(kode_barang){
                        $.ajax({
                            type: 'GET',
                            url: url,
                            data : {kode_barang:kode_barang},
                            success: function(response){
                                console.log(response);
                                if(response.status == 0){
                                    Swal.fire({
                                        icon: "info",
                                        title: "Barang Tersedia",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    $('#table-id').DataTable().clear().draw();
                                    var table = $('#table-id').DataTable();
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
                                }else if(response.status == 1){
                                    Swal.fire({
                                        icon: "info",
                                        title: "Barang Sudah Masuk",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
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
                                        title: "Barang Tidak Ditemukan",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            }
                        });
                    }else{
                        Swal.fire({
                            icon: "info",
                            title: "Kode Barang Tidak Boleh Kosong",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                // } else{
                //     Swal.fire("Membatalkan Perubahan", "", "info");
                // }
                $('#kode_barang').val('');
        // });
    }

    function edit(obj){
        var item = $(obj).data('item');

        $('#id_barang').val(item.id_barang);
        $('#rak').val(item.id_rak);

        $('#rak').val(0);
        $('#EditModal').modal('show');
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