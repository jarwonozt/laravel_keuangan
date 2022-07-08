@extends('app.master')

@section('konten')

<div class="content-body">

  <div class="row page-titles mx-0 mt-2">

    <h3 class="col p-md-0">Pengguna</h3>

    <div class="col p-md-0">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Pengguna</a></li>
        <li class="breadcrumb-item active"><a href="javascript:void(0)">Tambah</a></li>
      </ol>
    </div>

  </div>

  <div class="container-fluid">

    <div class="card">

      <div class="card-header pt-4">
        <a href="{{ route('user') }}" class="btn btn-primary float-right"><i class="fa fa-arrow-left"></i> &nbsp KEMBALI</a>
        <h4>Tambah Pengguna Sistem</h4>

      </div>
      <div class="card-body pt-0">

        <div class="row">

          <div class="col-lg-5">

            <form method="POST" action="{{ route('user.aksi') }}" enctype="multipart/form-data">
              @csrf

              <div class="form-group">
                <div class="form-group has-feedback">
                  <label class="text-dark">Nama</label>
                  <input id="nama" type="text" placeholder="nama" class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" autocomplete="off">
                  @error('nama')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group">
                <div class="form-group has-feedback">
                  <label class="text-dark">Email</label>
                  <input id="email" type="email" placeholder="Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="off">

                  @error('email')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group">
                <div class="form-group has-feedback">
                  <label class="text-dark">Level</label>
                  <select class="form-control @error('level') is-invalid @enderror" name="level">
                    <option <?php if(old("level") == "admin"){echo "selected='selected'";} ?> value="admin">Admin</option>
                    <option <?php if(old("level") == "bendahara"){echo "selected='selected'";} ?> value="bendahara">Bendahara</option>
                  </select>
                  
                  @error('level')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>


              <div class="form-group">
                <div class="form-group has-feedback">
                  <label class="text-dark">Password</label>
                  <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="current-password">

                  @error('password')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              <div class="form-group">
                <div class="form-group has-feedback">
                  <label class="text-dark">Foto Profil</label>
                  <br>
                  <input id="foto" type="file" placeholder="foto" class="@error('foto') is-invalid @enderror" name="foto" value="{{ old('foto') }}" autocomplete="off">
                  <br>
                  <small class="text-muted"><i>Boleh dikosongkan</i></small>
                  @error('foto')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>

              
              <div class="form-group">
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
            </form>
          </div>


        </div>

      </div>

    </div>

  </div>
  <!-- #/ container -->
</div>

@endsection