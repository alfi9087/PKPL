<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Paket;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    public function index()
    {
        $pesanan = Pesanan::all();
        $paket = Paket::all();

        return view('kasir.order.index', compact('pesanan', 'paket'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_customer' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_tlp' => 'required|string|max:15',
            'berat' => 'required|numeric|min:0.1',
            'id_paket' => 'required|exists:paket,id',
            'status' => 'required|in:pending,proses,selesai',
            'tgl_masuk' => 'required|date',
        ]);

        $paket = Paket::findOrFail($request->id_paket);

        $totalHarga = $request->berat * $paket->harga;

        Pesanan::create([
            'nama_customer' => $request->nama_customer,
            'alamat' => $request->alamat,
            'no_tlp' => $request->no_tlp,
            'berat' => $request->berat,
            'id_paket' => $request->id_paket,
            'status' => $request->status,
            'total_harga' => $totalHarga,
            'tgl_masuk' => $request->tgl_masuk,
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil ditambahkan');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $pesanan = Pesanan::findOrFail($id);

        $pesanan->status = $request->status;
        $pesanan->save();

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diperbarui'
        ]);
    }

    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->delete();

        return redirect()->route('orders.index')->with('success', 'Paket berhasil dihapus.');
    }

    public function show($id)
{
    $pesanan = Pesanan::with('paket')->find($id);
    return response()->json($pesanan);
}

}
