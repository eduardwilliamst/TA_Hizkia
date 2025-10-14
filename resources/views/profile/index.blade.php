@extends('layouts.adminlte')

@section('title')
Akun Saya
@endsection

@section('page-bar')
<h1 class="m-0">Informasi Akun</h1>
@endsection

@section('contents')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- Profile Card -->
            <div class="col-md-4">
                <div class="card animate-fade-in-up" style="box-shadow: 0 4px 20px rgba(102, 126, 234, 0.15); border-radius: 15px; border: none;">
                    <div class="card-header text-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; padding: 2rem;">
                        <div style="width: 120px; height: 120px; margin: 0 auto 1rem; border-radius: 50%; background: white; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
                            <span style="font-size: 3rem; font-weight: 700; color: #667eea;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </span>
                        </div>
                        <h3 class="mb-0" style="font-weight: 600;">{{ Auth::user()->name }}</h3>
                        <p class="mb-0" style="opacity: 0.9; font-size: 0.95rem;">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="card-body" style="padding: 2rem;">
                        <div class="mb-4">
                            <label style="font-weight: 600; color: #666; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Role</label>
                            <div class="mt-2">
                                @if(Auth::user()->roles->isNotEmpty())
                                    @foreach(Auth::user()->roles as $role)
                                        <span class="badge" style="padding: 0.6rem 1.2rem; border-radius: 20px; font-weight: 600; font-size: 0.9rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                                            <i class="fas fa-shield-alt mr-1"></i>
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                @else
                                    <span class="badge badge-secondary" style="padding: 0.6rem 1.2rem; border-radius: 20px; font-size: 0.9rem;">No Role</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <label style="font-weight: 600; color: #666; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">Member Since</label>
                            <div class="mt-2" style="font-size: 1rem; color: #333;">
                                <i class="far fa-calendar mr-2" style="color: #667eea;"></i>
                                {{ Auth::user()->created_at->format('d F Y') }}
                            </div>
                        </div>

                        <div>
                            <label style="font-weight: 600; color: #666; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">User ID</label>
                            <div class="mt-2" style="font-size: 1rem; color: #333;">
                                <i class="fas fa-id-badge mr-2" style="color: #667eea;"></i>
                                #{{ Auth::user()->id }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Profile Card -->
            <div class="col-md-8">
                <div class="card animate-fade-in-up" style="box-shadow: 0 4px 20px rgba(102, 126, 234, 0.15); border-radius: 15px; border: none;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h3 class="mb-0">
                            <i class="fas fa-user-edit mr-2"></i>
                            Edit Profil
                        </h3>
                    </div>
                    <div class="card-body" style="padding: 2rem;">
                        <form action="{{ route('profile.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="name" style="font-weight: 600; color: #333;">
                                    <i class="fas fa-user mr-2" style="color: #667eea;"></i>Nama Lengkap
                                </label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 0.75rem 1rem;">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" style="font-weight: 600; color: #333;">
                                    <i class="fas fa-envelope mr-2" style="color: #667eea;"></i>Email
                                </label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 0.75rem 1rem;">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <hr style="margin: 2rem 0; border-top: 2px solid #f0f0f0;">

                            <h5 style="color: #667eea; margin-bottom: 1.5rem; font-weight: 600;">
                                <i class="fas fa-lock mr-2"></i>Ubah Password
                            </h5>

                            <div class="alert" style="background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border-left: 4px solid #667eea; border-radius: 10px;">
                                <i class="fas fa-info-circle mr-2"></i>
                                Kosongkan jika tidak ingin mengubah password
                            </div>

                            <div class="form-group">
                                <label for="current_password" style="font-weight: 600; color: #333;">
                                    <i class="fas fa-key mr-2" style="color: #667eea;"></i>Password Saat Ini
                                </label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" placeholder="Masukkan password saat ini" style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 0.75rem 1rem;">
                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password" style="font-weight: 600; color: #333;">
                                    <i class="fas fa-lock mr-2" style="color: #667eea;"></i>Password Baru
                                </label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan password baru" style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 0.75rem 1rem;">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" style="font-weight: 600; color: #333;">
                                    <i class="fas fa-lock mr-2" style="color: #667eea;"></i>Konfirmasi Password Baru
                                </label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password baru" style="border-radius: 10px; border: 2px solid #e0e0e0; padding: 0.75rem 1rem;">
                            </div>

                            <div class="form-group text-right" style="margin-top: 2rem;">
                                <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 0.75rem 2rem; border-radius: 10px; font-weight: 600; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions Card (Optional - shows user permissions) -->
        @if(Auth::user()->getAllPermissions()->isNotEmpty())
        <div class="row mt-4">
            <div class="col-12">
                <div class="card animate-fade-in-up" style="box-shadow: 0 4px 20px rgba(102, 126, 234, 0.15); border-radius: 15px; border: none;">
                    <div class="card-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 15px 15px 0 0; padding: 1.5rem;">
                        <h3 class="mb-0">
                            <i class="fas fa-key mr-2"></i>
                            Hak Akses Saya
                        </h3>
                    </div>
                    <div class="card-body" style="padding: 2rem;">
                        <div class="row">
                            @foreach(Auth::user()->getAllPermissions() as $permission)
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div style="padding: 1rem; background: linear-gradient(135deg, rgba(102, 126, 234, 0.1) 0%, rgba(118, 75, 162, 0.1) 100%); border-radius: 10px; border-left: 4px solid #667eea;">
                                        <i class="fas fa-check-circle mr-2" style="color: #667eea;"></i>
                                        <span style="font-weight: 500; color: #333;">{{ ucfirst($permission->name) }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
