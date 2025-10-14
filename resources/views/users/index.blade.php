@extends('layouts.adminlte')

@section('title')
Users
@endsection

@section('page-bar')
<h1 class="m-0">Data Pengguna</h1>
@endsection

@section('contents')
<div class="content">
    <div class="container-fluid">
        <div class="card animate-fade-in-up">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h3 class="mb-0">
                            <i class="fas fa-users mr-2"></i>
                            Manajemen Pengguna
                        </h3>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#addUserModal" style="padding: 0.7rem 1.5rem; border-radius: 12px;">
                            <i class="fas fa-user-plus mr-2"></i>Tambah Pengguna
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body" style="padding: 2rem;">
                <div style="overflow-x: auto;">
                    <table id="usersTable" class="table table-hover" style="border-radius: 10px; overflow: hidden;">
                        <thead>
                            <tr>
                                <th style="width: 25%;"><i class="fas fa-user mr-2"></i>Nama</th>
                                <th style="width: 25%;"><i class="fas fa-envelope mr-2"></i>Email</th>
                                <th style="width: 15%;"><i class="fas fa-user-tag mr-2"></i>Role</th>
                                <th style="width: 15%;"><i class="fas fa-calendar mr-2"></i>Bergabung</th>
                                <th style="width: 20%; text-align: center;"><i class="fas fa-cog mr-2"></i>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="animate-fade-in">
                                <td style="font-weight: 600; color: #333;">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td style="color: #666;">
                                    <i class="fas fa-envelope mr-2" style="color: #667eea;"></i>
                                    {{ $user->email }}
                                </td>
                                <td>
                                    @if($user->roles->isNotEmpty())
                                        @foreach($user->roles as $role)
                                            <span class="badge" style="padding: 0.5rem 1rem; border-radius: 20px; font-weight: 600; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                                <i class="fas fa-shield-alt mr-1"></i>
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="badge badge-secondary" style="padding: 0.5rem 1rem; border-radius: 20px;">
                                            No Role
                                        </span>
                                    @endif
                                </td>
                                <td style="color: #666;">
                                    <i class="far fa-clock mr-2"></i>
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td style="text-align: center;">
                                    <div style="display: flex; gap: 0.5rem; justify-content: center;">
                                        <a data-toggle="modal" data-target="#modalEditUser" onclick="modalEdit({{ $user->id }})" class="btn btn-info btn-sm" style="border-radius: 8px; padding: 0.5rem 1rem;" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" id="delete-form-{{ $user->id }}" style="display:inline; margin: 0;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-danger btn-sm" style="border-radius: 8px; padding: 0.5rem 1rem;" onclick="confirmDelete('delete-form-{{ $user->id }}')" title="Hapus">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
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

<!-- Modal Tambah User -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title" id="addUserModalLabel">
                    <i class="fas fa-user-plus mr-2"></i>Tambah Pengguna Baru
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name"><i class="fas fa-user mr-2"></i>Nama Lengkap</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="form-group">
                        <label for="email"><i class="fas fa-envelope mr-2"></i>Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                    </div>
                    <div class="form-group">
                        <label for="password"><i class="fas fa-lock mr-2"></i>Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation"><i class="fas fa-lock mr-2"></i>Konfirmasi Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                    </div>
                    <div class="form-group">
                        <label for="role"><i class="fas fa-user-tag mr-2"></i>Role</label>
                        <select class="form-control" id="role" name="role">
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer" style="border-top: 2px solid #f0f0f0;">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                            <i class="fas fa-save mr-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" id="modalContent">

    </div>
</div>
@endsection

@section('javascript')
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'excel',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'pdf',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
            ]
        });
    });

    function modalEdit(userId) {
        $.ajax({
            type: 'POST',
            url: '{{ route("users.getEditForm") }}',
            data: {
                '_token': '<?php echo csrf_token() ?>',
                'id': userId,
            },
            success: function(data) {
                $("#modalContent").html(data.msg);
            },
            error: function(xhr) {
                console.log(xhr);
            }
        });
    }
</script>
@endsection
