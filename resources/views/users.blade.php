@extends('template.main')

@section('css')

@endsection

@section('content')
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                    <i class="mdi mdi-account"></i>
                </span> Users
            </h3>
        </div>
        <div class="row">
            <div class="col-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">List User</h4>
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
                            <button type="button" class="btn btn-sm btn-success btn-fw" data-bs-toggle="modal" data-bs-target="#StoreModal">
                                <i class="mdi mdi-plus"></i>Tambah
                            </button>
                            <table class="table" id="table-id">
                                <thead>
                                    <tr>
                                        <th> No. </th>
                                        <th> Nama </th>
                                        <th> Email </th>
                                        <th> Role </th>
                                        <th> created at </th>
                                        <th> Aksi </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data as $item)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td> {{ $item->name }} </td>
                                        <td> {{ $item->email }} </td>
                                        <td>
                                            @if($item->status == 1)
                                            <label class="badge badge-gradient-warning">admin</label>
                                            @elseif($item->status == 2)
                                            <label class="badge badge-gradient-success">user gate in</label>
                                            @elseif($item->status == 3)
                                            <label class="badge badge-gradient-success">user gate out</label>
                                            @elseif($item->status == 4)
                                            <label class="badge badge-gradient-success">user stok</label>
                                            @elseif($item->status == 5)
                                            <label class="badge badge-gradient-success">user billing</label>
                                            @endif
                                        </td>
                                        <td> {{ $item->created_at }} </td>
                                        <td>
                                            <button type="button" data-item="{{ json_encode($item) }}" onclick="edit(this)" class="btn btn-primary btn-rounded btn-sm"><i class="mdi mdi-border-color"></i></button>
                                            {{-- <button type="button" class="btn btn-warning btn-rounded btn-sm"><i class="mdi mdi-information"></i></button> --}}
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
    <div class="modal fade" id="StoreModal" tabindex="-1" aria-labelledby="StoreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="StoreModalLabel">Tambah Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="..." maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="..." maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Password</label>
                            <input type="password" class="form-control" id="password" name="password" autocomplete="off" maxlength="255" placeholder="..." required>
                        </div>
                        <div class="form-group">
                            <label for="email">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="1">ADMIN</option>
                                <option value="2">USER GATE IN</option>
                                <option value="3">USER GATE OUT</option>
                                <option value="4">USER STOK</option>
                                <option value="5">USER BILLING</option>
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

    <div class="modal fade" id="EditModal" tabindex="-1" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('users.update') }}" enctype="multipart/form-data">
                @csrf
                    <div class="modal-body">
                        <input type="hidden" id="e_id" name="id">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="e_nama" name="nama" placeholder="..." maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="e_email" name="email" placeholder="..." maxlength="50" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Password</label>
                            <input type="password" class="form-control" id="e_password" name="password" autocomplete="off" maxlength="255" placeholder="...">
                        </div>
                        <div class="form-group">
                            <label for="email">Role</label>
                            <select class="form-control" id="e_role" name="role" required>
                                <option value="1">ADMIN</option>
                                <option value="2">USER GATE IN</option>
                                <option value="3">USER GATE OUT</option>
                                <option value="4">USER STOK</option>
                                <option value="5">USER BILLING</option>
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
    });

    function edit(obj){
        var item = $(obj).data('item');
        console.log(item);
        $('#e_id').val(item.id);
        $('#e_nama').val(item.name);
        $('#e_email').val(item.email);
        $('#e_password').val(item.password);
        $('#e_role').val(item.status);

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
                window.location.href = "{{ url('users/delete') }}/"+id;
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