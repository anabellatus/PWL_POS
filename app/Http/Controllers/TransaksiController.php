<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\StokModel;
use App\Models\TransaksiDetailModel;
use App\Models\TransaksiModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Transaksi Penjualan',
            'list' => ['Home', 'Transaksi Penjualan']
        ];

        $page = (object) [
            'title' => 'Daftar transaksi penjualan yang terdaftar dalam sistem'
        ];

        $activeMenu = 'penjualan';

        $user = UserModel::all();

        return view('transaksi.index', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'activeMenu' => $activeMenu,
            'user' => $user,
        ]);
    }

    public function list(Request $request)
    {
        $penjualans = TransaksiModel::select('penjualan_id', 'user_id', 'penjualan_kode', 'pembeli', 'penjualan_tanggal')->with('user');

        if ($request->user_id) {
            $penjualans->where('user_id', $request->user_id);
        }

        return DataTables::of($penjualans)
            ->addIndexColumn() // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex)
            ->addColumn('aksi', function ($penjualan) { // menambahkan kolom aksi
                $btn = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/edit') . '"class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/penjualan/' . $penjualan->penjualan_id) . '">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                return $btn;
            })
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Tambah Transaksi Penjualan',
            'list' => ['Home', 'Transaksi Penjualan', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah transaksi baru'
        ];

        $user = UserModel::all();
        $barang = BarangModel::with('stok')->get();
        $activeMenu = 'penjualan';

        $counter = (TransaksiModel::selectRaw("CAST(RIGHT(penjualan_kode, 3) AS UNSIGNED) AS counter")->orderBy('penjualan_id', 'desc')->value('counter')) + 1;
        $penjualan_kode = 'PJ' . sprintf("%04d", $counter);
        $total = 0;

        return view('transaksi.create', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'user' => $user,
            'barang' => $barang,
            'penjualan_kode' => $penjualan_kode,
            'activeMenu' => $activeMenu,
            'date' => date("Y-m-d"),
            'total' => $total
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'penjualan_kode' => 'required|string|unique:t_penjualan,penjualan_kode',
            'pembeli' => 'required|string|max:100',
            'barang_id.*' => 'required|integer',
            'jumlah.*' => 'required|integer',
            'harga.*' => 'required|integer',
        ]);

        $total = 0;

        foreach ($request->barang_id as $key => $barang_id) {

            $stok = StokModel::where('barang_id', $barang_id)->value('stok_jumlah');
            $nama_barang = BarangModel::where('barang_id', $barang_id)->value('barang_nama');
            $requestedQuantity = $request->jumlah[$key];

            if ($stok < $requestedQuantity) {
                return redirect()->back()->withInput()->withErrors(['jumlah.' . $key => 'Jumlah Melebihi Stok yang Tersedia. Stok "' . $nama_barang . '" Saat Ini: ' . $stok]);
            }

            $total += $request->jumlah[$key] * $request->harga[$key];
        }

        $penjualan = TransaksiModel::create([
            'user_id' => $request->user_id,
            'penjualan_kode' => $request->penjualan_kode,
            'pembeli' => $request->pembeli,
            'penjualan_tanggal' => now(),
        ]);

        // t_penjualan_detail
        $barang_ids = $request->barang_id;
        $jumlahs = $request->jumlah;
        $hargas = $request->harga;

        foreach ($barang_ids as $key => $barang_id) {
            TransaksiDetailModel::create([
                'penjualan_id' => $penjualan->penjualan_id,
                'barang_id' => $barang_id,
                'harga' => $hargas[$key],
                'jumlah' => $jumlahs[$key],
            ]);

            $stok = (StokModel::where('barang_id', $barang_id)->value('stok_jumlah')) - $jumlahs[$key];
            $date = date('Y-m-d');
            StokModel::where('barang_id', $barang_id)->update(['stok_jumlah' => $stok, 'stok_tanggal' => $date, 'user_id' => $request->user_id]);
        }

        return redirect('/penjualan')->with('success', 'Data transaksi berhasil disimpan');
        // return redirect()->route('transaksi.show', $penjualan->penjualan_id)->with('success', 'Data transaksi berhasil disimpan');
    }

    public function show(string $id)
    {
        $penjualan = TransaksiModel::find($id);
        $penjualan_detail = TransaksiDetailModel::where('penjualan_id', $id)->get();

        $breadcrumb = (object) [
            'title' => 'Detail Transaksi Penjualan',
            'list' => ['Home', 'Transaksi Penjualan', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail transaksi penjualan'
        ];

        $activeMenu = 'penjualan';

        return view('transaksi.show', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'penjualan' => $penjualan,
            'penjualan_detail' => $penjualan_detail,
            'activeMenu' => $activeMenu
        ]);
    }

    public function edit(string $id)
    {
        $transaksi = TransaksiModel::findOrFail($id);
        $user = UserModel::all();
        $barang = BarangModel::with('stok')->get();

        $breadcrumb = (object)[
            'title' => 'Edit Transaksi Penjualan',
            'list' => ['Home', 'Transaksi Penjualan', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit transaksi'
        ];

        $activeMenu = 'penjualan';

        return view('transaksi.edit', [
            'breadcrumb' => $breadcrumb,
            'page' => $page,
            'transaksi' => $transaksi,
            'user' => $user,
            'barang' => $barang,
            'activeMenu' => $activeMenu
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'penjualan_kode' => 'required|string|unique:t_penjualan,penjualan_kode,' . $id . ',penjualan_id',
            'pembeli' => 'required|string|max:100',
            'barang_id.*' => 'required|integer',
            'jumlah.*' => 'required|integer',
            'harga.*' => 'required|integer',
        ]);

        $transaksi = TransaksiModel::findOrFail($id);

        $transaksi->update([
            'user_id' => $request->user_id,
            'penjualan_kode' => $request->penjualan_kode,
            'pembeli' => $request->pembeli,
        ]);

        $transaksi->detail()->delete();

        foreach ($request->barang_id as $key => $barang_id) {
            $transaksi->detail()->create([
                'barang_id' => $barang_id,
                'harga' => $request->harga[$key],
                'jumlah' => $request->jumlah[$key],
            ]);
        }

        return redirect('/penjualan')->with('success', 'Data transaksi berhasil diperbarui');
    }


    public function destroy($id)
    {
        $check = TransaksiModel::find($id);
        if (!$check) {
            return redirect('/penjualan')->with('error', 'Data transaksi tidak ditemukan');
        }
        try {
            $check->detail()->delete();
            $check->delete();

            return redirect('/penjualan')->with('success', 'Data transaksi berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/penjualan')->with('error', 'Data transaksi gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
