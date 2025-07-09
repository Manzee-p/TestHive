@extends('layouts.backend')
@section('content')
<div class="content-wrapper">
  <!-- Content -->
  <div class="container-xxl flex-grow-1 container-p-y">
    
    {{-- Kartu Ucapan / Dashboard --}}
    <div class="row">
      <div class="col-xxl-8 mb-6 order-0">
        <div class="card">
          <div class="d-flex align-items-start row">
            <div class="col-sm-7">
              <div class="card-body">
                <h5 class="card-title text-primary mb-3">Congratulations John! 🎉</h5>
                <p class="mb-6">
                  You have done 72% more sales today.<br />Check your new badge in your profile.
                </p>
                <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
              </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
              <div class="card-body pb-0 px-0 px-md-6">
                <img
                  src="{{ asset('assets/backend/img/illustrations/man-with-laptop.png') }}"
                  height="175"
                  alt="View Badge User" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Daftar Kategori Diperlebar --}}
    <div class="row mt-4">
      <div class="col-12"> {{-- Lebar penuh --}}
        <div class="card shadow-sm">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Kategori Soal</h5>
            <a href="{{ route('backend.kategori.create') }}" class="btn btn-primary rounded-pill">
              <i class='bx bx-plus me-2 align-middle'></i> Tambah Kategori
            </a>
          </div>
          
          <div class="card-body gx-4 px-2">
            <div class="table-responsive">
              <table class="table table-hover align-middle">
                <thead class="text-muted">
                  <tr>
                    <th><i class='bx bx-hash me-1 align-middle'></i></th>
                    <th><i class='bx bx-file me-2 align-middle'></i> Nama Kategori</th>
                    <th class="text-center"><i class='bx bxs-cog me-2 align-middle'></i> Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($kategories as $index => $kategori)
                    <tr>
                      <td>
                        <span class="badge bg-label-primary fs-6">{{ $index + 1 }}</span>
                      </td>
                      <td>
                        <i class='bx bx-book-bookmark me-2 align-middle'></i> {{ $kategori->nama_kategori }}
                      </td>
                      <td class="text-center">
                        <div class="d-flex justify-content-center gap-2">
                          <a href="{{ route('backend.kategori.edit', $kategori->id) }}" 
                            class="btn btn-warning btn-sm d-inline-flex align-items-center px-3" 
                            title="Edit">
                            <i class='bx bx-edit-alt text-white me-1'></i> Edit
                          </a>
                          <form action="{{ route('backend.kategori.destroy', $kategori->id) }}" 
                                method="POST" 
                                onsubmit="return confirm('Hapus kategori ini?')" 
                                class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-danger btn-sm d-inline-flex align-items-center px-3" 
                                    title="Hapus">
                              <i class='bx bxs-trash text-white me-1'></i> Hapus
                            </button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="3" class="text-center text-muted py-4">
                        Belum ada kategori.
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection