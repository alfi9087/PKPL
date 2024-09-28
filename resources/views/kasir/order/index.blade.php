@extends('kasir.layout.main')

@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Daftar Pesanan </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <button type="button" class="btn btn-primary btn-fw" data-bs-toggle="modal" data-bs-target="#tambahPesananModal">Tambah Pesanan</button>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th> No </th>
                                        <th> Nama Customer </th>
                                        <th> Alamat </th>
                                        <th> Status </th>
                                        <th> Total Harga </th>
                                        <th> Aksi </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pesanan as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->nama_customer }}</td>
                                        <td>{{ $order->alamat }}</td>
                                        <td>
                                            <select class="form-control status-dropdown" data-id="{{ $order->id }}">
                                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="proses" {{ $order->status == 'proses' ? 'selected' : '' }}>Proses</option>
                                                <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            </select>
                                        </td>
                                        <td>{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                        <td>
                                            <!-- Tombol Info -->
                                            <button type="button" class="btn btn-info btn-icon-text" data-bs-toggle="modal" data-bs-target="#infoPesananModal" data-id="{{ $order->id }}">
                                                <i class="mdi mdi-book-minus btn-icon-prepend"></i> Info
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline-block;">
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

<!-- Modal Tambah Pesanan -->
<div class="modal fade" id="tambahPesananModal" tabindex="-1" aria-labelledby="tambahPesananModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formPesanan" action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahPesananModalLabel">Tambah Pesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Input fields -->
                    <div class="form-group">
                        <label>Nama Customer</label>
                        <input type="text" name="nama_customer" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" class="form-control" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>No Telepon</label>
                        <input type="text" name="no_tlp" class="form-control" required maxlength="15">
                    </div>
                    <div class="form-group">
                        <label>Berat (kg)</label>
                        <input type="number" name="berat" class="form-control" id="berat" required>
                    </div>

                    <div class="form-group">
                        <label for="id_paket">Paket</label>
                        <select class="form-control" id="id_paket" name="id_paket" required>
                            <option value="" disabled selected>Pilih Paket</option>
                            @foreach($paket as $p)
                            <option value="{{ $p->id }}" data-harga="{{ $p->harga }}">{{ $p->nama }} - {{ number_format($p->harga, 0, ',', '.') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status" class="form-control" required>
                            <option value="pending">Pending</option>
                            <option value="proses">Proses</option>
                            <option value="selesai">Selesai</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Masuk</label>
                        <input type="date" name="tgl_masuk" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="submitPesanan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Info Pesanan -->
<div class="modal fade" id="infoPesananModal" tabindex="-1" aria-labelledby="infoPesananModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoPesananModalLabel">Detail Pesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Customer:</strong> <span id="infoNamaCustomer"></span></p>
                <p><strong>Alamat:</strong> <span id="infoAlamat"></span></p>
                <p><strong>No Telepon:</strong> <span id="infoNoTelepon"></span></p>
                <p><strong>Paket:</strong> <span id="infoPaket"></span></p>
                <p><strong>Berat:</strong> <span id="infoBerat"></span> kg</p>
                <p><strong>Total Harga:</strong> Rp<span id="infoTotalHarga"></span></p>
                <p><strong>Status:</strong> <span id="infoStatus"></span></p>
                <p><strong>Tanggal Masuk:</strong> <span id="infoTanggalMasuk"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paketSelect = document.getElementById('id_paket');
        const beratInput = document.getElementById('berat');
        const formPesanan = document.getElementById('formPesanan');
        const submitPesananBtn = document.getElementById('submitPesanan');

        function calculateTotal() {
            const selectedPaket = paketSelect.options[paketSelect.selectedIndex];
            const hargaPaket = selectedPaket.getAttribute('data-harga');
            const berat = parseFloat(beratInput.value);

            if (hargaPaket && !isNaN(berat) && berat > 0) {
                const totalHarga = berat * parseFloat(hargaPaket);
                return totalHarga;
            }
            return 0;
        }

        submitPesananBtn.addEventListener('click', function(event) {
            event.preventDefault();

            const totalHarga = calculateTotal();

            if (totalHarga > 0) {
                const confirmation = confirm('Total harga pesanan ini adalah Rp' + new Intl.NumberFormat('id-ID').format(totalHarga) + '. Apakah Anda yakin ingin melanjutkan?');

                if (confirmation) {
                    formPesanan.submit();
                }
            } else {
                alert('Pastikan Anda telah memilih paket dan memasukkan berat yang benar.');
            }
        });

        const statusDropdowns = document.querySelectorAll('.status-dropdown');

        statusDropdowns.forEach(function(dropdown) {
            dropdown.addEventListener('change', function() {
                const status = this.value;
                const pesananId = this.getAttribute('data-id');

                fetch(`/orders/update-status/${pesananId}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            status: status
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Status berhasil diperbarui.');
                        } else {
                            alert('Gagal memperbarui status.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memperbarui status.');
                    });
            });
        });
        const infoModal = document.getElementById('infoPesananModal');

        infoModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget; 
            const pesananId = button.getAttribute('data-id');

            fetch(`/orders/${pesananId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('infoNamaCustomer').textContent = data.nama_customer;
                    document.getElementById('infoAlamat').textContent = data.alamat;
                    document.getElementById('infoNoTelepon').textContent = data.no_tlp;
                    document.getElementById('infoPaket').textContent = data.paket.nama + ' - Rp' + new Intl.NumberFormat('id-ID').format(data.paket.harga);
                    document.getElementById('infoBerat').textContent = data.berat;
                    document.getElementById('infoTotalHarga').textContent = new Intl.NumberFormat('id-ID').format(data.total_harga);
                    document.getElementById('infoStatus').textContent = data.status;
                    document.getElementById('infoTanggalMasuk').textContent = data.tgl_masuk;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Gagal mengambil data pesanan.');
                });
        });
    });
</script>
@endsection