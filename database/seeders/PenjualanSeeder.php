<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['penjualan_id' => 1, 'user_id' => 3, 'pembeli' => 'Ana', 'penjualan_kode' => 'PJL001', 'penjualan_tanggal' => '2024-03-06'],
            ['penjualan_id' => 2, 'user_id' => 3, 'pembeli' => 'Bella', 'penjualan_kode' => 'PJL002', 'penjualan_tanggal' => '2024-03-06'],
            ['penjualan_id' => 3, 'user_id' => 3, 'pembeli' => 'Melati', 'penjualan_kode' => 'PJL003', 'penjualan_tanggal' => '2024-03-07'],
            ['penjualan_id' => 4, 'user_id' => 3, 'pembeli' => 'Jihan', 'penjualan_kode' => 'PJL004', 'penjualan_tanggal' => '2024-03-07'],
            ['penjualan_id' => 5, 'user_id' => 3, 'pembeli' => 'Dea', 'penjualan_kode' => 'PJL005', 'penjualan_tanggal' => '2024-03-08'],
            ['penjualan_id' => 6, 'user_id' => 3, 'pembeli' => 'Fanessa', 'penjualan_kode' => 'PJL006', 'penjualan_tanggal' => '2024-03-08'],
            ['penjualan_id' => 7, 'user_id' => 3, 'pembeli' => 'Elva', 'penjualan_kode' => 'PJL007', 'penjualan_tanggal' => '2024-03-08'],
            ['penjualan_id' => 8, 'user_id' => 3, 'pembeli' => 'Nadilla', 'penjualan_kode' => 'PJL008', 'penjualan_tanggal' => '2024-03-09'],
            ['penjualan_id' => 9, 'user_id' => 3, 'pembeli' => 'Putri', 'penjualan_kode' => 'PJL009', 'penjualan_tanggal' => '2024-03-09'],
            ['penjualan_id' => 10, 'user_id' => 3, 'pembeli' => 'Octa', 'penjualan_kode' => 'PJL010', 'penjualan_tanggal' => '2024-03-10'],
        ];
        DB::table('t_penjualan')->insert($data);
    }
}
