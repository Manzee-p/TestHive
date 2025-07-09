@extends('layouts.backend')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
  <div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
      <h5 class="mb-0">Tambah Kategori Soal</h5>
      <a href="{{ route('backend.kategori.index') }}" class="btn btn-secondary">
        <i class="ti ti-arrow-left me-1"></i> Kembali
      </a>
    </div>

    <div class="card-body">
      <form action="{{ route('backend.kategori.store') }}" method="POST">
        @csrf

        {{-- Nama Kategori --}}
        <div class="mb-3">
          <label for="nama_kategori" class="form-label">Nama Kategori <span class="text-danger">*</span></label>
          <input type="text"
                 name="nama_kategori"
                 id="nama_kategori"
                 class="form-control @error('nama_kategori') is-invalid @enderror"
                 value="{{ old('nama_kategori') }}"
                 required>
          @error('nama_kategori')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="d-flex justify-content-end">
          <button type="submit" class="btn btn-primary">
            <i class="ti ti-device-floppy me-1"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
