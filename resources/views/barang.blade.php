@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-bullhorn"></i>
                </span> Daftar Barang Masuk
            </h3>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List Daftar Barang Masuk</h4>
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
                            <button type="button" class="btn btn-sm btn-success btn-fw" data-bs-toggle="modal" data-bs-target="#TambahModal">
                                <i class="mdi mdi-plus"></i>Tambah
                            </button>
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
                                        <th> Status </th>
                                        <th> Aksi </th>
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
                                        <td> {{ $item->berat }} </td>
                                        <td>
                                            @if($item->status == 0)
                                            {{-- <span class="badge rounded-pill bg-danger">&nbsp;&nbsp;</span> --}}
                                            <span class="badge rounded-pill bg-primary">Daftar Barang Masuk</span>
                                            @elseif($item->status == 1)
                                            {{-- <span class="badge rounded-pill bg-success">&nbsp;&nbsp;</span> --}}
                                            <span class="badge rounded-pill bg-success">Barang Masuk</span>
                                            @elseif($item->status == 2)
                                            <span class="badge rounded-pill bg-warning">Daftar Barang Keluar</span>
                                            @else
                                            <span class="badge rounded-pill bg-danger">Barang Keluar</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button type="button" data-item="{{ json_encode($item) }}" onclick="edit(this)" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-border-color"></i></button>
                                            <button type="button" onclick="hapus({{ $item->id }})" class="btn btn-danger btn-rounded btn-sm"><i class="mdi mdi-delete"></i></button>
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
                    <h5 class="modal-title" id="TambahModalLabel">Tambah Daftar Barang Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('daftar-barang-masuk.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <input type="hidden" id="status" name="status" value="0">
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang</label>
                            <input type="text" class="form-control" id="kode_barang" name="kode_barang" value="{{ $kode_barang }}" maxlength="50" placeholder="..." required readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang" maxlength="255" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control" id="kategori" name="kategori" onchange="setDataBarang()">
                                <option value="0" selected>--PILIH KATEGORI--</option>
                                @foreach($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_pemilik">Nama Pemilik</label>
                            <input type="text" class="form-control" id="nama_pemilik" name="nama_pemilik" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" placeholder="..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="berat">Berat</label>
                            <input type="text" class="form-control" id="berat" name="berat" placeholder="..." required>
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

    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit Bank</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('daftar-barang-masuk.update') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <input type="hidden" id="e_id" name="id">
                        <div class="form-group">
                            <label for="kode_barang">Kode Barang</label>
                            <input type="text" class="form-control" id="e_kode_barang" name="kode_barang" maxlength="50" placeholder="..." required readonly>
                        </div>
                        <div class="form-group">
                            <label for="nama_barang">Barang</label>
                            <input type="text" class="form-control" id="e_nama_barang" name="nama_barang" maxlength="255" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control" id="e_kategori" name="kategori" onchange="setDataBarang()">
                                <option value="0" selected>--PILIH KATEGORI--</option>
                                @foreach($kategori as $item)
                                <option value="{{ $item->id }}">{{ $item->kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_pemilik">Nama Pemilik</label>
                            <input type="text" class="form-control" id="e_nama_pemilik" name="nama_pemilik" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea class="form-control" id="e_alamat" name="alamat" placeholder="..." required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="berat">Berat</label>
                            <input type="text" class="form-control" id="e_berat" name="berat" placeholder="..." required>
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

    function edit(obj){
        var item = $(obj).data('item');

        $('#e_id').val(item.id);
        $('#e_kode_barang').val(item.kode_barang);
        $('#e_nama_barang').val(item.nama);
        $('#e_kategori').val(item.id_kategori);
        $('#e_nama_pemilik').val(item.nama_pemilik);
        $('#e_alamat').val(item.alamat);
        $('#e_berat').val(item.berat);

        $('#EditModal').modal('show');
    }

    function hapus(id) {
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
                window.location.href = "{{ url('daftar-barang-masuk/delete') }}/"+id;
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