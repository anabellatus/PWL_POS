<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransaksiModel;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        return TransaksiModel::all();
    }

    public function show(string $id)
    {
        $penjualan = TransaksiModel::with('detail.barang')->findOrFail($id);

        $response = [
            'id penjualan' => $penjualan->penjualan_id,
            'pembeli' => $penjualan->pembeli,
            'kode penjualan' => $penjualan->penjualan_kode,
            'tanggal' => $penjualan->penjualan_tanggal,
            'barang yang dibeli' => [],
            'total belanja' => 0,
        ];

        foreach ($penjualan->detail as $item) {
            $barang = $item->barang;
            $subtotal = $item->harga * $item->jumlah;
            $response['barang yang dibeli'][] = [
                'nama barang' => $barang->barang_nama,
                'harga' => $item->harga,
                'jumlah' => $item->jumlah,
                'subtotal' => $subtotal,
                'image' => url('storage/posts/' . $barang->image),
            ];
            $response['total belanja'] += $subtotal;
        }

        return response()->json($response, 200);
    }
}
