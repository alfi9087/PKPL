@extends('kasir.layout.main')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Paket </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <button type="button" class="btn btn-primary btn-fw" data-toggle="modal" data-target="#tambahPaketModal">Tambah Paket</button>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Daftar Paket</h4>
                        <p class="card-description"> Tabel paket laundry yang tersedia</p>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th> No </th>
                                        <th> Nama Paket </th>
                                        <th> Harga </th>
                                        <th> Aksi </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($paket as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                                        <td>
                                            <button type="button" class="btn btn-warning btn-icon-text" data-toggle="modal" data-target="#editPaketModal{{ $item->id }}">
                                                <i class="mdi mdi-pencil btn-icon-prepend"></i> Edit
                                            </button>

                                            <!-- Modal Edit Paket -->
                                            <div class="modal fade" id="editPaketModal{{ $item->id }}" tabindex="-1" aria-labelledby="editPaketModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editPaketModalLabel">Edit Paket</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('paket.update', $item->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="form-group">
                                                                    <label for="nama{{ $item->id }}">Nama Paket</label>
                                                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama{{ $item->id }}" name="nama" placeholder="Nama Paket" value="{{ old('nama', $item->nama) }}">
                                                                    @error('nama')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="harga{{ $item->id }}">Harga</label>
                                                                    <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga{{ $item->id }}" name="harga" placeholder="Harga" value="{{ old('harga', $item->harga) }}">
                                                                    @error('harga')
                                                                    <div class="invalid-feedback">
                                                                        {{ $message }}
                                                                    </div>
                                                                    @enderror
                                                                </div>
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Hapus -->
                                            <form action="{{ route('paket.destroy', $item->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-icon-text" onclick="return confirm('Apakah Anda yakin ingin menghapus paket ini?')">
                                                    <i class="mdi mdi-delete btn-icon-prepend"></i> Hapus
                                                </button>
                                            </form>
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
</div>

<!-- Modal Tambah Paket -->
<div class="modal fade" id="tambahPaketModal" tabindex="-1" aria-labelledby="tambahPaketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahPaketModalLabel">Tambah Paket</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('paket.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="nama">Nama Paket</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" placeholder="Nama Paket" value="{{ old('nama') }}">
                        @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="number" class="form-control @error('harga') is-invalid @enderror" id="harga" name="harga" placeholder="Harga" value="{{ old('harga') }}">
                        @error('harga')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection