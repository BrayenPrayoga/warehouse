@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-bullhorn"></i>
                </span> Barang Keluar
            </h3>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Barang Keluar</h4>
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
                                        <th> Barang </th>
                                        <th> Kategori </th>
                                        <th> Nama Pemilik </th>
                                        <th> Alamat </th>
                                        <th> Berat </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td> {{ $item->kode_barang }} </td>
                                        <td> {{ $item->nama }} </td>
                                        <td> {{ $item->RelasiKategori->kategori }} </td>
                                        <td> {{ $item->nama_pemilik }} </td>
                                        <td> {{ $item->alamat }} </td>
                                        <td> {{ number_format($item->berat,2,',','.') }} </td>
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
            var url = "{{ route('admin.barang-keluar.checkBarang') }}";
        @else
            var url = "{{ route('user.barang-keluar.checkBarang') }}";
        @endif

        var kode_barang = $('#kode_barang').val();
        // Swal.fire({
        //     icon: "question",
        //     title: "Apakah Ingin Menyimpan Barang?",
        //     showCancelButton: true,
        //     cancelButtonText: "CANCEL",
        //     confirmButtonText: "SIMPAN"
        //     }).then((result) => {
        //         if (result.isConfirmed) {
                    if(kode_barang){
                        $.ajax({
                            type: 'GET',
                            url: "{{ route('admin.barang-keluar.checkBarang') }}",
                            data : {kode_barang:kode_barang},
                            success: function(response){
                                console.log(response);
                                if(response.status == 0){
                                    Swal.fire({
                                        icon: "info",
                                        title: "Barang Belum Masuk",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }else if(response.status == 1){
                                    Swal.fire({
                                        icon: "info",
                                        title: "Barang Belum Keluar",
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }else if(response.status == 2){
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
                                            val.nama,
                                            val.relasi_kategori.kategori,
                                            val.nama_pemilik,
                                            val.alamat,
                                            berat.replace('.',','),
                                            val.tanggal_keluar,
                                            '<button type="button" data-item="{{ json_encode('+val+') }}" onclick="edit(this)" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-border-color"></i></button><button type="button" onclick="hapus('+val.id+')" class="btn btn-danger btn-rounded btn-sm"><i class="mdi mdi-delete"></i></button>'
                                        ]).draw();
                                    })
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

        $('#e_id').val(item.id);
        $('#e_jenis').val(item.jenis);
        $('#e_nomer_rekening').val(item.nomer_rekening);

        $('#EditModal').modal('show');
    }

    function hapus(id) {
        @if(Auth::guard('admin')->check())
            var url = "{{ url('admin/barang-keluar/delete') }}/"+id;
        @else
            var url = "{{ url('user/barang-keluar/delete') }}/"+id;
        @endif

        Swal.fire({
            title: "Apa anda yakin?",
            text: "ingein menghapus data ini!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete!"
        }).then((result) => {
            if(result.isConfirmed) {
                window.location.href = url;
            }else{
                Swal.fire({
                    title: "Batal!",
                    text: "Batal Hapus",
                    icon: "warning",
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
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