<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembelianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeder ini membuat produk melalui pembelian agar HPP dapat dihitung dengan benar.
     */
    public function run(): void
    {
        // Get kategori IDs
        $kategoris = DB::table('kategoris')->pluck('idkategori', 'nama');

        // Get supplier IDs
        $suppliers = DB::table('suppliers')->pluck('idsupplier', 'nama');

        // Get tipe ID (Pembelian Tunai)
        $tipeTunai = DB::table('tipes')->where('keterangan', 'Pembelian Tunai')->value('idtipe');

        // Define products with their purchase prices (HPP) and selling prices
        $produkData = [
            // Popok & Diaper
            [
                'barcode' => '8991001000001',
                'nama' => 'Pampers Premium Care NB 52',
                'harga_beli' => 145000,
                'harga' => 185000,
                'stok' => 50,
                'kategori' => 'Popok & Diaper',
            ],
            [
                'barcode' => '8991001000002',
                'nama' => 'Pampers Premium Care S 48',
                'harga_beli' => 140000,
                'harga' => 180000,
                'stok' => 45,
                'kategori' => 'Popok & Diaper',
            ],
            [
                'barcode' => '8991001000003',
                'nama' => 'MamyPoko Pants M 58',
                'harga_beli' => 120000,
                'harga' => 155000,
                'stok' => 60,
                'kategori' => 'Popok & Diaper',
            ],
            [
                'barcode' => '8991001000004',
                'nama' => 'MamyPoko Pants L 52',
                'harga_beli' => 125000,
                'harga' => 160000,
                'stok' => 55,
                'kategori' => 'Popok & Diaper',
            ],
            [
                'barcode' => '8991001000005',
                'nama' => 'Sweety Silver Pants XL 42',
                'harga_beli' => 95000,
                'harga' => 125000,
                'stok' => 40,
                'kategori' => 'Popok & Diaper',
            ],
            // Makanan Bayi
            [
                'barcode' => '8991002000001',
                'nama' => 'Milna Bubur Bayi 6+ Ayam Sayur',
                'harga_beli' => 18000,
                'harga' => 25000,
                'stok' => 80,
                'kategori' => 'Makanan Bayi',
            ],
            [
                'barcode' => '8991002000002',
                'nama' => 'Milna Bubur Bayi 6+ Beras Merah',
                'harga_beli' => 18000,
                'harga' => 25000,
                'stok' => 75,
                'kategori' => 'Makanan Bayi',
            ],
            [
                'barcode' => '8991002000003',
                'nama' => 'Cerelac Bubur Sereal Ayam',
                'harga_beli' => 35000,
                'harga' => 48000,
                'stok' => 60,
                'kategori' => 'Makanan Bayi',
            ],
            [
                'barcode' => '8991002000004',
                'nama' => 'Sun Bubur Sereal Susu Pisang',
                'harga_beli' => 12000,
                'harga' => 18000,
                'stok' => 90,
                'kategori' => 'Makanan Bayi',
            ],
            [
                'barcode' => '8991002000005',
                'nama' => 'Promina Puffs Keju 8+ Bulan',
                'harga_beli' => 22000,
                'harga' => 32000,
                'stok' => 50,
                'kategori' => 'Makanan Bayi',
            ],
            // Susu Formula
            [
                'barcode' => '8991003000001',
                'nama' => 'SGM Eksplor 1+ Madu 900g',
                'harga_beli' => 85000,
                'harga' => 115000,
                'stok' => 35,
                'kategori' => 'Susu Formula',
            ],
            [
                'barcode' => '8991003000002',
                'nama' => 'Bebelac 3 Vanila 800g',
                'harga_beli' => 125000,
                'harga' => 165000,
                'stok' => 30,
                'kategori' => 'Susu Formula',
            ],
            [
                'barcode' => '8991003000003',
                'nama' => 'Dancow 1+ Madu 800g',
                'harga_beli' => 95000,
                'harga' => 125000,
                'stok' => 40,
                'kategori' => 'Susu Formula',
            ],
            [
                'barcode' => '8991003000004',
                'nama' => 'Lactogrow 3 Vanila 750g',
                'harga_beli' => 110000,
                'harga' => 145000,
                'stok' => 25,
                'kategori' => 'Susu Formula',
            ],
            // Perlengkapan Mandi
            [
                'barcode' => '8991004000001',
                'nama' => 'Johnson Baby Shampoo 200ml',
                'harga_beli' => 28000,
                'harga' => 38000,
                'stok' => 70,
                'kategori' => 'Perlengkapan Mandi',
            ],
            [
                'barcode' => '8991004000002',
                'nama' => 'Cussons Baby Cream 100g',
                'harga_beli' => 18000,
                'harga' => 26000,
                'stok' => 65,
                'kategori' => 'Perlengkapan Mandi',
            ],
            [
                'barcode' => '8991004000003',
                'nama' => 'Zwitsal Baby Bath 300ml',
                'harga_beli' => 32000,
                'harga' => 45000,
                'stok' => 55,
                'kategori' => 'Perlengkapan Mandi',
            ],
            [
                'barcode' => '8991004000004',
                'nama' => 'Pigeon Baby Lotion 200ml',
                'harga_beli' => 42000,
                'harga' => 58000,
                'stok' => 45,
                'kategori' => 'Perlengkapan Mandi',
            ],
            [
                'barcode' => '8991004000005',
                'nama' => 'Mitu Baby Wipes 50 sheets',
                'harga_beli' => 15000,
                'harga' => 22000,
                'stok' => 100,
                'kategori' => 'Perlengkapan Mandi',
            ],
            // Pakaian Bayi
            [
                'barcode' => '8991005000001',
                'nama' => 'Jumper Bayi Polos 0-3 Bulan',
                'harga_beli' => 35000,
                'harga' => 55000,
                'stok' => 30,
                'kategori' => 'Pakaian Bayi',
            ],
            [
                'barcode' => '8991005000002',
                'nama' => 'Setelan Bayi Motif 3-6 Bulan',
                'harga_beli' => 45000,
                'harga' => 68000,
                'stok' => 25,
                'kategori' => 'Pakaian Bayi',
            ],
            [
                'barcode' => '8991005000003',
                'nama' => 'Kaos Kaki Bayi 3 Pasang',
                'harga_beli' => 18000,
                'harga' => 28000,
                'stok' => 50,
                'kategori' => 'Pakaian Bayi',
            ],
            [
                'barcode' => '8991005000004',
                'nama' => 'Topi Bayi Rajut',
                'harga_beli' => 22000,
                'harga' => 35000,
                'stok' => 40,
                'kategori' => 'Pakaian Bayi',
            ],
            // Mainan Bayi
            [
                'barcode' => '8991006000001',
                'nama' => 'Rattle Bayi Set 5pcs',
                'harga_beli' => 45000,
                'harga' => 65000,
                'stok' => 35,
                'kategori' => 'Mainan Bayi',
            ],
            [
                'barcode' => '8991006000002',
                'nama' => 'Teether Silikon Buah',
                'harga_beli' => 25000,
                'harga' => 38000,
                'stok' => 60,
                'kategori' => 'Mainan Bayi',
            ],
            [
                'barcode' => '8991006000003',
                'nama' => 'Playmat Bayi Motif Binatang',
                'harga_beli' => 85000,
                'harga' => 125000,
                'stok' => 15,
                'kategori' => 'Mainan Bayi',
            ],
            [
                'barcode' => '8991006000004',
                'nama' => 'Buku Kain Bayi Edukasi',
                'harga_beli' => 35000,
                'harga' => 52000,
                'stok' => 40,
                'kategori' => 'Mainan Bayi',
            ],
            // Perlengkapan Makan
            [
                'barcode' => '8991007000001',
                'nama' => 'Botol Susu Pigeon 240ml',
                'harga_beli' => 75000,
                'harga' => 98000,
                'stok' => 45,
                'kategori' => 'Perlengkapan Makan',
            ],
            [
                'barcode' => '8991007000002',
                'nama' => 'Dot Silikon Pigeon S',
                'harga_beli' => 35000,
                'harga' => 48000,
                'stok' => 70,
                'kategori' => 'Perlengkapan Makan',
            ],
            [
                'barcode' => '8991007000003',
                'nama' => 'Training Cup 180ml',
                'harga_beli' => 55000,
                'harga' => 78000,
                'stok' => 35,
                'kategori' => 'Perlengkapan Makan',
            ],
            [
                'barcode' => '8991007000004',
                'nama' => 'Set Mangkok Sendok Bayi',
                'harga_beli' => 42000,
                'harga' => 62000,
                'stok' => 40,
                'kategori' => 'Perlengkapan Makan',
            ],
            [
                'barcode' => '8991007000005',
                'nama' => 'Sterilizer Botol Portable',
                'harga_beli' => 185000,
                'harga' => 250000,
                'stok' => 10,
                'kategori' => 'Perlengkapan Makan',
            ],
        ];

        // Create products first
        $produkIds = [];
        foreach ($produkData as $produk) {
            $produkId = DB::table('produks')->insertGetId([
                'barcode' => $produk['barcode'],
                'nama' => $produk['nama'],
                'harga' => $produk['harga'],
                'harga_beli' => $produk['harga_beli'],
                'stok' => $produk['stok'],
                'gambar' => 'images/default.png',
                'kategori_idkategori' => $kategoris[$produk['kategori']] ?? 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $produkIds[$produk['barcode']] = [
                'id' => $produkId,
                'harga_beli' => $produk['harga_beli'],
                'stok' => $produk['stok'],
            ];
        }

        // Create pembelian records (simulate purchases from different suppliers on different dates)
        $pembelianData = [
            // Pembelian 1 - PT Pampers Indonesia (Popok & Diaper)
            [
                'supplier' => 'PT Pampers Indonesia',
                'tanggal_pesan' => Carbon::now()->subDays(30),
                'products' => ['8991001000001', '8991001000002', '8991001000003', '8991001000004', '8991001000005'],
            ],
            // Pembelian 2 - CV Baby Care Supply (Makanan Bayi, Perlengkapan Mandi)
            [
                'supplier' => 'CV Baby Care Supply',
                'tanggal_pesan' => Carbon::now()->subDays(25),
                'products' => ['8991002000001', '8991002000002', '8991002000003', '8991002000004', '8991002000005', '8991004000001', '8991004000002', '8991004000003', '8991004000004', '8991004000005'],
            ],
            // Pembelian 3 - PT Nutricia Indonesia (Susu Formula, Perlengkapan Makan)
            [
                'supplier' => 'PT Nutricia Indonesia',
                'tanggal_pesan' => Carbon::now()->subDays(20),
                'products' => ['8991003000001', '8991003000002', '8991003000003', '8991003000004', '8991007000001', '8991007000002', '8991007000003', '8991007000004', '8991007000005'],
            ],
            // Pembelian 4 - UD Baby Fashion (Pakaian Bayi, Mainan Bayi)
            [
                'supplier' => 'UD Baby Fashion',
                'tanggal_pesan' => Carbon::now()->subDays(15),
                'products' => ['8991005000001', '8991005000002', '8991005000003', '8991005000004', '8991006000001', '8991006000002', '8991006000003', '8991006000004'],
            ],
        ];

        foreach ($pembelianData as $pembelian) {
            $supplierId = $suppliers[$pembelian['supplier']] ?? 1;

            $pembelianId = DB::table('pembelians')->insertGetId([
                'tanggal_pesan' => $pembelian['tanggal_pesan'],
                'supplier_idsupplier' => $supplierId,
                'tipe_idtipe' => $tipeTunai,
                'created_at' => $pembelian['tanggal_pesan'],
                'updated_at' => $pembelian['tanggal_pesan'],
            ]);

            // Create pembelian_detils
            foreach ($pembelian['products'] as $barcode) {
                if (isset($produkIds[$barcode])) {
                    DB::table('pembelian_detils')->insert([
                        'pembelian_id' => $pembelianId,
                        'produk_id' => $produkIds[$barcode]['id'],
                        'harga' => $produkIds[$barcode]['harga_beli'],
                        'jumlah' => $produkIds[$barcode]['stok'],
                        'created_at' => $pembelian['tanggal_pesan'],
                        'updated_at' => $pembelian['tanggal_pesan'],
                    ]);
                }
            }
        }
    }
}
