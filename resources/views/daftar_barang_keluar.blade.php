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
                            <p>Format Import : <a href="{{ asset('import/format_import_barang_keluar.xlsx') }}" target="_blank">Download</a></p>
                            <button type="button" class="btn btn-sm btn-success btn-fw" onclick="openModal()">
                                <i class="mdi mdi-plus"></i>Tambah
                            </button>
                            <button type="button" class="btn btn-sm btn-primary btn-fw" data-bs-toggle="modal" data-bs-target="#ImportModal">
                                <i class="mdi mdi-upload"></i>Import
                            </button>
                            <button type="button" class="btn btn-sm btn-dark btn-fw" onclick="exportTableToExcel()">
                                <i class="mdi mdi-file-excel"></i>Export
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
                    <h5 class="modal-title" id="TambahModalLabel">Tambah Daftar Barang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if(Auth::guard('admin')->check())
                <form method="POST" action="{{ route('admin.daftar-barang-keluar.store') }}" enctype="multipart/form-data">
                @elseif(Auth::guard('supervisor')->check())
                <form method="POST" action="{{ route('supervisor.daftar-barang-keluar.store') }}" enctype="multipart/form-data">
                @else
                <form method="POST" action="{{ route('user.daftar-barang-keluar.store') }}" enctype="multipart/form-data">
                @endif
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
                            {{-- <div class="form-group">
                                <label for="rak">Rak</label>
                                <input type="text" class="form-control" id="rak" name="rak" readonly>
                            </div> --}}
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
                                <input type="text" class="form-control decimal" id="berat_barang" name="berat_barang" readonly>
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
    
    <div class="modal fade" id="ImportModal" tabindex="-1" aria-labelledby="ImportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ImportModalLabel">Import Barang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if(Auth::guard('admin')->check())
                <form method="POST" action="{{ route('admin.daftar-barang-keluar.import') }}" enctype="multipart/form-data">
                @elseif(Auth::guard('supervisor')->check())
                <form method="POST" action="{{ route('supervisor.daftar-barang-keluar.import') }}" enctype="multipart/form-data">
                @else
                <form method="POST" action="{{ route('user.daftar-barang-keluar.import') }}" enctype="multipart/form-data">
                @endif
                @csrf
                    <div class="modal-body">
                        <input type="hidden" id="status" name="status" value="0">
                        <div class="form-group">
                            <label for="kode_barang">Upload Excel</label>
                            <input type="file" class="form-control" id="upload_excel" name="upload_excel" placeholder="..." required>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
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
        
        @if(Auth::guard('admin')->check())
        var url = "{{ route('admin.daftar-barang-keluar.getDataBarang') }}";
        @elseif(Auth::guard('supervisor')->check())
        var url = "{{ route('supervisor.daftar-barang-keluar.getDataBarang') }}";
        @else
        var url = "{{ route('user.daftar-barang-keluar.getDataBarang') }}";
        @endif

        $.ajax({
            type: 'GET',
            url: url,
            data : {kode_barang:kode_barang},
            success: function(response){
                console.log(response);
                if(response){
                    var berat = response.berat;
                    $('#data_barang').show();
                    $('#id_barang').val(response.id_barang);
                    // $('#rak').val(response.relasi_rak.nama);
                    $('#nama_barang').val(response.nama);
                    $('#kategori').val(response.relasi_kategori.kategori);
                    $('#tanggal_masuk').val(response.tanggal_masuk);
                    $('#nama_pemilik').val(response.nama_pemilik);
                    $('#alamat').val(response.alamat);
                    $('#berat_barang').val(berat.replace('.',','));
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
                @if(Auth::guard('admin')->check())
                var url = "{{ url('admin/daftar-barang-keluar/delete') }}/"+id_barang;
                @elseif(Auth::guard('supervisor')->check())
                var url = "{{ url('supervisor/daftar-barang-keluar/delete') }}/"+id_barang;
                @else
                var url = "{{ url('user/daftar-barang-keluar/delete') }}/"+id_barang;
                @endif
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
        XLSX.writeFile(wb, "data-barang-keluar.xlsx");
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