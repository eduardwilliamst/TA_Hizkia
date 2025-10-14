<div class="modal-content">
    <div class="modal-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
        <h5 class="modal-title">
            <i class="fas fa-user-edit mr-2"></i>Edit Pengguna
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- User Info Display -->
            <div class="alert" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border-left: 4px solid #667eea;">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 1.5rem;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h5 style="margin: 0; color: #333;">{{ $user->name }}</h5>
                        <small style="color: #666;">Member since {{ $user->created_at->format('d M Y') }}</small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="edit_name"><i class="fas fa-user mr-2"></i>Nama Lengkap</label>
                <input type="text" class="form-control" id="edit_name" name="name" value="{{ $user->name }}" required>
            </div>

            <div class="form-group">
                <label for="edit_email"><i class="fas fa-envelope mr-2"></i>Email</label>
                <input type="email" class="form-control" id="edit_email" name="email" value="{{ $user->email }}" required>
            </div>

            <div class="form-group">
                <label for="edit_password"><i class="fas fa-lock mr-2"></i>Password Baru</label>
                <input type="password" class="form-control" id="edit_password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                <small class="form-text text-muted">Biarkan kosong jika tidak ingin mengubah password</small>
            </div>

            <div class="form-group">
                <label for="edit_password_confirmation"><i class="fas fa-lock mr-2"></i>Konfirmasi Password Baru</label>
                <input type="password" class="form-control" id="edit_password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru">
            </div>

            <div class="form-group">
                <label for="edit_role"><i class="fas fa-user-tag mr-2"></i>Role</label>
                <select class="form-control" id="edit_role" name="role">
                    <option value="">Pilih Role</option>
                    @foreach($roles as $role)
                    <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                        {{ ucfirst($role->name) }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="modal-footer" style="border-top: 2px solid #f0f0f0;">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times mr-2"></i>Batal
                </button>
                <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none;">
                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
