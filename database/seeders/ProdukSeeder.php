<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * CATATAN PENTING:
     * Seeder ini tidak digunakan lagi karena produk harus dibuat melalui PEMBELIAN
     * agar HPP (Harga Pokok Penjualan) dapat dihitung dengan benar.
     *
     * Untuk membuat produk awal, silakan:
     * 1. Gunakan fitur Pembelian di aplikasi
     * 2. Atau buat PembelianSeeder yang akan otomatis membuat produk dengan HPP yang benar
     */
    public function run(): void
    {
        // SEEDER INI DI-DISABLE - Gunakan Pembelian untuk membuat produk
        return;

        $kategoris = DB::table('kategoris')->pluck('idkategori', 'nama');

        DB::table('produks')->insert([
            // Kategori Popok & Diaper
            [
                'barcode' => '8991001000001',
                'nama' => 'Pampers Premium Care NB 52',
                'harga' => 185000,
                'stok' => 50,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Popok & Diaper'] ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barcode' => '8991001000002',
                'nama' => 'MamyPoko Pants M 58',
                'harga' => 155000,
                'stok' => 60,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Popok & Diaper'] ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kategori Makanan Bayi
            [
                'barcode' => '8991002000001',
                'nama' => 'Milna Bubur Bayi 6+ Ayam Sayur',
                'harga' => 25000,
                'stok' => 80,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Makanan Bayi'] ?? 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barcode' => '8991002000002',
                'nama' => 'Cerelac Bubur Sereal Ayam',
                'harga' => 48000,
                'stok' => 60,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Makanan Bayi'] ?? 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kategori Susu Formula
            [
                'barcode' => '8991003000001',
                'nama' => 'SGM Eksplor 1+ Madu 900g',
                'harga' => 115000,
                'stok' => 35,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Susu Formula'] ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barcode' => '8991003000002',
                'nama' => 'Bebelac 3 Vanila 800g',
                'harga' => 165000,
                'stok' => 30,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Susu Formula'] ?? 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kategori Perlengkapan Mandi
            [
                'barcode' => '8991004000001',
                'nama' => 'Johnson Baby Shampoo 200ml',
                'harga' => 38000,
                'stok' => 70,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Perlengkapan Mandi'] ?? 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barcode' => '8991004000002',
                'nama' => 'Zwitsal Baby Bath 300ml',
                'harga' => 45000,
                'stok' => 55,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Perlengkapan Mandi'] ?? 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kategori Pakaian Bayi
            [
                'barcode' => '8991005000001',
                'nama' => 'Jumper Bayi Polos 0-3 Bulan',
                'harga' => 55000,
                'stok' => 30,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Pakaian Bayi'] ?? 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barcode' => '8991005000002',
                'nama' => 'Setelan Bayi Motif 3-6 Bulan',
                'harga' => 68000,
                'stok' => 25,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Pakaian Bayi'] ?? 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kategori Mainan Bayi
            [
                'barcode' => '8991006000001',
                'nama' => 'Rattle Bayi Set 5pcs',
                'harga' => 65000,
                'stok' => 35,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Mainan Bayi'] ?? 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barcode' => '8991006000002',
                'nama' => 'Teether Silikon Buah',
                'harga' => 38000,
                'stok' => 60,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Mainan Bayi'] ?? 6,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Kategori Perlengkapan Makan
            [
                'barcode' => '8991007000001',
                'nama' => 'Botol Susu Pigeon 240ml',
                'harga' => 98000,
                'stok' => 45,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Perlengkapan Makan'] ?? 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'barcode' => '8991007000002',
                'nama' => 'Dot Silikon Pigeon S',
                'harga' => 48000,
                'stok' => 70,
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris['Perlengkapan Makan'] ?? 7,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
