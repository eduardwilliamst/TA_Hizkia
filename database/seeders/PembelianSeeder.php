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
            // Makanan
            [
                'barcode' => '8992234567890',
                'nama' => 'Indomie Goreng',
                'harga_beli' => 2500,
                'harga' => 3500,
                'stok' => 100,
                'kategori' => 'Makanan',
            ],
            [
                'barcode' => '8992234567891',
                'nama' => 'Mie Sedaap Soto',
                'harga_beli' => 2200,
                'harga' => 3000,
                'stok' => 80,
                'kategori' => 'Makanan',
            ],
            [
                'barcode' => '8992234567892',
                'nama' => 'Chitato Sapi Panggang',
                'harga_beli' => 9000,
                'harga' => 12000,
                'stok' => 50,
                'kategori' => 'Makanan',
            ],
            [
                'barcode' => '8992234567893',
                'nama' => 'Oreo Vanilla',
                'harga_beli' => 11000,
                'harga' => 15000,
                'stok' => 40,
                'kategori' => 'Makanan',
            ],
            // Minuman
            [
                'barcode' => '8992234567894',
                'nama' => 'Aqua 600ml',
                'harga_beli' => 3000,
                'harga' => 5000,
                'stok' => 150,
                'kategori' => 'Minuman',
            ],
            [
                'barcode' => '8992234567895',
                'nama' => 'Teh Kotak Jasmine',
                'harga_beli' => 4500,
                'harga' => 7000,
                'stok' => 60,
                'kategori' => 'Minuman',
            ],
            [
                'barcode' => '8992234567896',
                'nama' => 'Coca Cola 390ml',
                'harga_beli' => 5500,
                'harga' => 8000,
                'stok' => 70,
                'kategori' => 'Minuman',
            ],
            [
                'barcode' => '8992234567897',
                'nama' => 'Kopi ABC Susu',
                'harga_beli' => 1500,
                'harga' => 2500,
                'stok' => 120,
                'kategori' => 'Minuman',
            ],
            // Pakaian
            [
                'barcode' => '8991234567890',
                'nama' => 'Kaos Polos Hitam',
                'harga_beli' => 55000,
                'harga' => 85000,
                'stok' => 30,
                'kategori' => 'Pakaian',
            ],
            [
                'barcode' => '8991234567891',
                'nama' => 'Kaos Polos Putih',
                'harga_beli' => 55000,
                'harga' => 85000,
                'stok' => 25,
                'kategori' => 'Pakaian',
            ],
            [
                'barcode' => '8991234567892',
                'nama' => 'Kemeja Lengan Panjang',
                'harga_beli' => 100000,
                'harga' => 150000,
                'stok' => 20,
                'kategori' => 'Pakaian',
            ],
            // Elektronik
            [
                'barcode' => '8993234567890',
                'nama' => 'Charger HP Universal',
                'harga_beli' => 25000,
                'harga' => 45000,
                'stok' => 15,
                'kategori' => 'Elektronik',
            ],
            [
                'barcode' => '8993234567891',
                'nama' => 'Earphone Basic',
                'harga_beli' => 15000,
                'harga' => 30000,
                'stok' => 20,
                'kategori' => 'Elektronik',
            ],
            // Aksesoris
            [
                'barcode' => '8994234567890',
                'nama' => 'Topi Baseball',
                'harga_beli' => 35000,
                'harga' => 65000,
                'stok' => 18,
                'kategori' => 'Aksesoris',
            ],
            [
                'barcode' => '8994234567891',
                'nama' => 'Dompet Kulit Sintetis',
                'harga_beli' => 40000,
                'harga' => 75000,
                'stok' => 12,
                'kategori' => 'Aksesoris',
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
            // Pembelian 1 - PT Maju Jaya (Makanan & Minuman)
            [
                'supplier' => 'PT Maju Jaya',
                'tanggal_pesan' => Carbon::now()->subDays(30),
                'tanggal_datang' => Carbon::now()->subDays(28),
                'products' => ['8992234567890', '8992234567891', '8992234567892', '8992234567893'],
            ],
            // Pembelian 2 - CV Sumber Rezeki (Minuman)
            [
                'supplier' => 'CV Sumber Rezeki',
                'tanggal_pesan' => Carbon::now()->subDays(25),
                'tanggal_datang' => Carbon::now()->subDays(23),
                'products' => ['8992234567894', '8992234567895', '8992234567896', '8992234567897'],
            ],
            // Pembelian 3 - UD Berkah Jaya (Pakaian)
            [
                'supplier' => 'UD Berkah Jaya',
                'tanggal_pesan' => Carbon::now()->subDays(20),
                'tanggal_datang' => Carbon::now()->subDays(18),
                'products' => ['8991234567890', '8991234567891', '8991234567892'],
            ],
            // Pembelian 4 - Toko Grosir Makmur (Elektronik & Aksesoris)
            [
                'supplier' => 'Toko Grosir Makmur',
                'tanggal_pesan' => Carbon::now()->subDays(15),
                'tanggal_datang' => Carbon::now()->subDays(13),
                'products' => ['8993234567890', '8993234567891', '8994234567890', '8994234567891'],
            ],
        ];

        foreach ($pembelianData as $pembelian) {
            $supplierId = $suppliers[$pembelian['supplier']] ?? 1;

            $pembelianId = DB::table('pembelians')->insertGetId([
                'tanggal_pesan' => $pembelian['tanggal_pesan'],
                'tanggal_datang' => $pembelian['tanggal_datang'],
                'supplier_idsupplier' => $supplierId,
                'tipe_idtipe' => $tipeTunai,
                'created_at' => $pembelian['tanggal_datang'],
                'updated_at' => $pembelian['tanggal_datang'],
            ]);

            // Create pembelian_detils
            foreach ($pembelian['products'] as $barcode) {
                if (isset($produkIds[$barcode])) {
                    DB::table('pembelian_detils')->insert([
                        'pembelian_id' => $pembelianId,
                        'produk_id' => $produkIds[$barcode]['id'],
                        'harga' => $produkIds[$barcode]['harga_beli'],
                        'jumlah' => $produkIds[$barcode]['stok'],
                        'created_at' => $pembelian['tanggal_datang'],
                        'updated_at' => $pembelian['tanggal_datang'],
                    ]);
                }
            }
        }
    }
}
