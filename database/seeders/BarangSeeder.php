<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'MKN001', 'barang_nama' => 'Sari Roti', 'harga_beli' => 3000, 'harga_jual' => 5000],
            ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'MKN002', 'barang_nama' => 'Indomie', 'harga_beli' => 4000, 'harga_jual' => 6000],
            ['barang_id' => 3, 'kategori_id' => 2, 'barang_kode' => 'MNM001', 'barang_nama' => 'Aqua', 'harga_beli' => 3000, 'harga_jual' => 4000],
            ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'MNM002', 'barang_nama' => 'Teh Botol', 'harga_beli' => 4500, 'harga_jual' => 7000],
            ['barang_id' => 5, 'kategori_id' => 3, 'barang_kode' => 'PKN001', 'barang_nama' => 'Kaos Oblong', 'harga_beli' => 35000, 'harga_jual' => 55000],
            ['barang_id' => 6, 'kategori_id' => 3, 'barang_kode' => 'PKN002', 'barang_nama' => 'Celana Jeans', 'harga_beli' => 50000, 'harga_jual' => 70000],
            ['barang_id' => 7, 'kategori_id' => 4, 'barang_kode' => 'OBT001', 'barang_nama' => 'Paracetamol', 'harga_beli' => 8000, 'harga_jual' => 10000],
            ['barang_id' => 8, 'kategori_id' => 4, 'barang_kode' => 'OBT002', 'barang_nama' => 'Antangin', 'harga_beli' => 4000, 'harga_jual' => 5000],
            ['barang_id' => 9, 'kategori_id' => 5, 'barang_kode' => 'ELK001', 'barang_nama' => 'Kulkas', 'harga_beli' => 1000000, 'harga_jual' => 1500000],
            ['barang_id' => 10, 'kategori_id' => 5, 'barang_kode' => 'ELK002', 'barang_nama' => 'Laptop', 'harga_beli' => 4000000, 'harga_jual' => 5000000],
        ];        
        DB::table('m_barang')->insert($data);
    }
}
