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
                                        <th> Aksi </th>
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
                                        <td> {{ number_format($item->berat,2,',','.') }} </td>
                                        <td> {{ $item->tanggal_masuk }} </td>
                                        <td>
                                            <button type="button" data-item="{{ json_encode($item) }}" onclick="edit(this)" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-border-color"></i></button>
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

    {{-- Modal Pop Up --}}
    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Tambah Daftar Barang Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST"
                @if(Auth::guard('admin')->check())
                    action="{{ route('admin.barang-masuk.update') }}"
                @else
                    action="{{ route('user.barang-masuk.update') }}"
                @endif
                enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id_barang" name="id_barang" value="0">
                        <div class="form-group">
                            <label for="rak">Rak</label>
                            <select class="form-control" id="rak" name="rak">
                                <option value="0" selected>--PILIH RAK--</option>
                                @foreach($rak as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">TUTUP</button>
                        <button type="submit" class="btn btn-primary">SIMPAN</button>
                    </div>
                </form>
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
        @else
            var url = "{{ route('user.barang-masuk.checkBarang') }}";
        @endif

        var kode_barang = $('#kode_barang').val();
        Swal.fire({
            icon: "question",
            title: "Apakah Ingin Menyimpan Barang?",
            showCancelButton: true,
            cancelButtonText: "CANCEL",
            confirmButtonText: "SIMPAN"
            }).then((result) => {
                if (result.isConfirmed) {
                    if(kode_barang){
                        $.ajax({
                            type: 'GET',
                            url: url,
                            data : {kode_barang:kode_barang},
                            success: function(response){
                                console.log(response);
                                if(response.status == 0){
                                    Swal.fire("Barang Tersedia", "", "success");
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
                                            berat.replace('.',','),
                                            val.tanggal_masuk,
                                            '<button type="button" data-item="{{ json_encode($item) }}" onclick="edit(this)" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-border-color"></i></button>'
                                        ]).draw();
                                    })
                                }else if(response.status == 1){
                                    Swal.fire("Barang Sudah Masuk", "", "info");
                                }else if(response.status == 2){
                                    Swal.fire("Barang Proses Keluar", "", "info");
                                }else if(response.status == 3){
                                    Swal.fire("Barang Sudah Keluar", "", "info");
                                }else{
                                    Swal.fire("Barang Tidak Ditemukan", "", "error");
                                }
                            }
                        });
                    }else{
                        Swal.fire("Kode Barang Tidak Boleh Kosong", "", "info");
                    }
                } else{
                    Swal.fire("Membatalkan Perubahan", "", "info");
                }
                $('#kode_barang').val('');
        });
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