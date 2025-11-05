{{-- <!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Edit Reseller</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <!-- Sidebar -->
    @include('layouts.subadminbar')

<div class="container py-4" style="margin-left: 250px;">
  <h3 class="mb-4"><i class="fas fa-user-edit"></i> Edit Reseller</h3>

  <form class="row g-3" action="{{ route('resellers.update', $reseller->id) }}" method="POST">
    @csrf
    @method('PUT')

    <input type="hidden" name="level" value="{{ $reseller->level ?? 11 }}">

    <!-- Data Reseller -->
    <div class="col-md-6">
      <h5>Data Reseller</h5>
      <div class="mb-2">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $reseller->nama_lengkap) }}" required>
      </div>
      <div class="mb-2">
        <label class="form-label">No. Identitas</label>
        <input type="text" name="no_identitas" class="form-control" value="{{ old('no_identitas', $reseller->no_identitas) }}" required>
      </div>
      <div class="mb-2">
        <label class="form-label">Telepon</label>
        <input type="text" name="telepon" class="form-control" value="{{ old('telepon', $reseller->telepon) }}" required>
      </div>
      <div class="mb-2">
        <label class="form-label">Alamat Lengkap</label>
        <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $reseller->alamat) }}</textarea>
      </div>
      <div class="mb-2">
        <label class="form-label">Username Login</label>
        <input type="text" name="username" class="form-control" value="{{ old('username', $reseller->username) }}" required>
      </div>
      <div class="mb-2">
        <label class="form-label">Password Login</label>
        <input type="text" name="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
      </div>
      <div class="mb-2">
        <label class="form-label">Tanggal Bergabung</label>
        <input type="date" name="tgl_bergabung" class="form-control" value="{{ old('tgl_bergabung', $reseller->tgl_bergabung ? $reseller->tgl_bergabung->format('Y-m-d') : '') }}" required>
      </div>
      <div class="mb-2">
        <label class="form-label">Limit Hutang</label>
        <input type="number" name="limit_hutang" class="form-control" value="{{ old('limit_hutang', $reseller->limit_hutang ?? 0) }}">
      </div>
      <div class="mb-2">
        <label class="form-label">Kode Unik</label>
        <input type="number" name="kode_unik" class="form-control" value="{{ old('kode_unik', $reseller->kode_unik ?? 0) }}" min="0" max="9999">
      </div>
    </div>

    <!-- Hak Akses -->
    <div class="col-md-6">
      <h5>Hak Akses</h5>
      <div class="mb-3">
        <label class="fw-bold">Router</label><br>
        <input type="checkbox" name="hak_akses_router[]" value="ALL" {{ in_array('ALL', (array) $reseller->hak_akses_router) ? 'checked' : '' }}> Semua Router<br>
        <input type="checkbox" name="hak_akses_router[]" value="NONE" {{ in_array('NONE', (array) $reseller->hak_akses_router) ? 'checked' : '' }}> Tidak Ada<br>
        <input type="checkbox" name="hak_akses_router[]" value="1" {{ in_array('1', (array) $reseller->hak_akses_router) ? 'checked' : '' }}> SERVER BNC
      </div>
      <div class="mb-3">
        <label class="fw-bold">Server</label><br>
        <input type="checkbox" name="hak_akses_server[]" value="ALL" {{ in_array('ALL', (array) $reseller->hak_akses_server) ? 'checked' : '' }}> Semua Server<br>
        <input type="checkbox" name="hak_akses_server[]" value="NONE" {{ in_array('NONE', (array) $reseller->hak_akses_server) ? 'checked' : '' }}> Tidak Ada<br>
        <input type="checkbox" name="hak_akses_server[]" value="1" {{ in_array('1', (array) $reseller->hak_akses_server) ? 'checked' : '' }}> hotspot1<br>
        <input type="checkbox" name="hak_akses_server[]" value="2" {{ in_array('2', (array) $reseller->hak_akses_server) ? 'checked' : '' }}> server1
      </div>
      <div class="mb-3">
        <label class="fw-bold">Profile</label><br>
        <input type="checkbox" name="hak_akses_profile[]" value="ALL" {{ in_array('ALL', (array) $reseller->hak_akses_profile) ? 'checked' : '' }}> Semua Profile<br>
        <input type="checkbox" name="hak_akses_profile[]" value="NONE" {{ in_array('NONE', (array) $reseller->hak_akses_profile) ? 'checked' : '' }}> Tidak Ada<br>
        <b>Profile Langganan</b><br>
        <input type="checkbox" name="hak_akses_profile[]" value="2" {{ in_array('2', (array) $reseller->hak_akses_profile) ? 'checked' : '' }}> 10Mbps<br>
        <b>Profile Voucher</b><br>
        <input type="checkbox" name="hak_akses_profile[]" value="1" {{ in_array('1', (array) $reseller->hak_akses_profile) ? 'checked' : '' }}> YYYYY<br>
        <input type="checkbox" name="hak_akses_profile[]" value="3" {{ in_array('3', (array) $reseller->hak_akses_profile) ? 'checked' : '' }}> vc1
      </div>
    </div>

    <!-- Tombol -->
    <div class="col-12">
      <a href="/user/mitra" class="btn btn-secondary">Kembali</a>
      <button type="reset" class="btn btn-warning">Reset</button>
      <button type="submit" class="btn btn-primary">Update</button>
    </div>
  </form>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"></script>
</body>
</html> --}}
