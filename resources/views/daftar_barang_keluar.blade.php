@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-bullhorn"></i>
                </span> Daftar Barang Keluar
            </h3>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Daftar Barang Keluar</h4>
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                <strong>Error!</strong> {{ $error }}
                            </div>
                            @endforeach
                        @endif
                        <div class="table-responsive">
                            <br>
                            <button type="button" class="btn btn-sm btn-success btn-fw" onclick="openModal()">
                                <i class="mdi mdi-plus"></i>Tambah
                            </button>
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
                                        <td> {{ $item->berat }} </td>
                                        <td>
                                            <button type="button" onclick="hapus({{ $item->id_barang }})" class="btn btn-danger btn-rounded btn-sm"><i class="mdi mdi-delete"></i></button>
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
    <div class="modal fade" id="TambahModal" tabindex="-1" aria-labelledby="TambahModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="TambahModalLabel">Tambah Daftar Barang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('daftar-barang-keluar.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <input type="hidden" id="id_barang" name="id_barang" value="">
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang</label>
                            <select class="form-control" id="kode_barang" name="kode_barang" onchange="setDataBarang()">
                                <option value="0" selected>--PILIH KODE BARANG--</option>
                                @foreach($barang_masuk as $item)
                                <option value="{{ $item->kode_barang }}">{{ $item->kode_barang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="data_barang" style="display:none">
                            <div class="form-group">
                                <label for="rak">Rak</label>
                                <input type="text" class="form-control" id="rak" name="rak" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nama_barang">Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang" readonly>
                            </div>
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <input type="text" class="form-control" id="kategori" name="kategori" readonly>
                            </div>
                            <div class="form-group">
                                <label for="tanggal_masuk">Tanggal Masuk</label>
                                <input type="text" class="form-control" id="tanggal_masuk" name="tanggal_masuk" readonly>
                            </div>
                            <div class="form-group">
                                <label for="nama_pemilik">Nama Pemilik</label>
                                <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" readonly>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <textarea rows="4" class="form-control" id="alamat" name="alamat" readonly></textarea>
                            </div>
                            <div class="form-group">
                                <label for="berat_barang">Berat</label>
                                <input type="text" class="form-control" id="berat_barang" name="berat_barang" readonly>
                            </div>
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
    });

    function openModal(){
        $('#kode_barang').val(0);
        $('#data_barang').hide();
        $('#TambahModal').modal('show');
    }

    function setDataBarang(){
        var kode_barang= $('#kode_barang').val();
        
        $.ajax({
            type: 'GET',
            url: "{{ route('daftar-barang-keluar.getDataBarang') }}",
            data : {kode_barang:kode_barang},
            success: function(response){
                console.log(response);
                if(response){
                    $('#data_barang').show();
                    $('#id_barang').val(response.id_barang);
                    $('#rak').val(response.relasi_rak.nama);
                    $('#nama_barang').val(response.nama);
                    $('#kategori').val(response.relasi_kategori.kategori);
                    $('#tanggal_masuk').val(response.tanggal_masuk);
                    $('#nama_pemilik').val(response.nama_pemilik);
                    $('#alamat').val(response.alamat);
                    $('#berat_barang').val(response.berat);
                }else{
                    $('#data_barang').hide();
                }
            }
        });
    }

    function hapus(id_barang) {
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
                window.location.href = "{{ url('daftar-barang-keluar/delete') }}/"+id_barang;
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