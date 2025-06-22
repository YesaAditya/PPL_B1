<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('status_transaksis')->insert([
            'status_transaksi' => 'Dicek',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('status_transaksis')->insert([
            'status_transaksi' => 'Dibatalkan',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('status_transaksis')->insert([
            'status_transaksi' => 'Diproses',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('status_transaksis')->insert([
            'status_transaksi' => 'Dikirim',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('status_transaksis')->insert([
            'status_transaksi' => 'Selesai',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('metode_pengirimans')->insert([
            'metode_pengiriman' => 'Offline',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('metode_pengirimans')->insert([
            'metode_pengiriman' => 'Online',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('roles')->insert([
            // ['id' => 1, 'nama_role' => 'Superadmin'],
            ['id' => 1, 'nama_role' => 'Admin Penjualan', 'created_at' => now(),
        'updated_at' => now()],
            ['id' => 2, 'nama_role' => 'Customer', 'created_at' => now(),
        'updated_at' => now()],
        ]);

        DB::table('users')->insert([
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'), // Dihash!
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('profil')->insert([
        'id' => 1,
        'user_id' => 1,
        'nama' => 'Admin',
        'no_telepon' => '08980634932',
        'kecamatan' => 'jember',
        'kelurahan' => 'Jember',
        'alamat' => 'Jl. Rembangan 68113 Jember',
        'created_at' => now(),
        'updated_at' => now(),
        ]);

        DB::table('katalog')->insert([
            [
                'nama_produk' => 'Susu Original',
                'deskripsi' => 'Susu sapi segar langsung dari peternakan Rembangan, tanpa pengawet',
                'stok' => 150,
                'harga' => 10000.00,
                'foto' => 'katalog/susuori.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_produk' => 'Susu Rasa Coklat',
                'deskripsi' => 'Susu sapi segar langsung dari peternakan Rembangan dengan tambahan rasa coklat, tanpa pengawet',
                'stok' => 150,
                'harga' => 12000.00,
                'foto' => 'katalog/susucoklat.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_produk' => 'Susu Rasa Durian',
                'deskripsi' => 'Susu sapi segar langsung dari peternakan Rembangan dengan tambahan rasa durian, tanpa pengawet',
                'stok' => 150,
                'harga' => 12000.00,
                'foto' => 'katalog/susudurian.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_produk' => 'Susu Rasa Matcha',
                'deskripsi' => 'Susu sapi segar langsung dari peternakan Rembangan dengan tambahan rasa matcha, tanpa pengawet',
                'stok' => 150,
                'harga' => 12000.00,
                'foto' => 'katalog/susumatcha.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_produk' => 'Susu Rasa Milo',
                'deskripsi' => 'Susu sapi segar langsung dari peternakan Rembangan dengan tambahan rasa milo, tanpa pengawet',
                'stok' => 150,
                'harga' => 12000.00,
                'foto' => 'katalog/susumilo.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_produk' => 'Susu Rasa Oreo',
                'deskripsi' => 'Susu sapi segar langsung dari peternakan Rembangan dengan tambahan rasa oreo, tanpa pengawet',
                'stok' => 150,
                'harga' => 12000.00,
                'foto' => 'katalog/susuoreo.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_produk' => 'Susu Rasa Strawberry',
                'deskripsi' => 'Susu sapi segar langsung dari peternakan Rembangan dengan tambahan rasa strawberry, tanpa pengawet',
                'stok' => 150,
                'harga' => 12000.00,
                'foto' => 'katalog/susustrawberry.png',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama_produk' => 'Susu Rasa Thai Tea',
                'deskripsi' => 'Susu sapi segar langsung dari peternakan Rembangan dengan tambahan rasa thai tea, tanpa pengawet',
                'stok' => 150,
                'harga' => 12000.00,
                'foto' => 'katalog/susuthaitea.jpg',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
