<?php

namespace Database\Seeders;

use App\Models\Bid;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $klien = User::create([
            'name' => 'Klien Contoh',
            'email' => 'klien@garudahub.test',
            'password' => 'password123',
            'role' => 'client',
        ]);

        $dev1 = User::create([
            'name' => 'Developer Satu',
            'email' => 'dev1@garudahub.test',
            'password' => 'password123',
            'role' => 'developer',
        ]);

        $dev2 = User::create([
            'name' => 'Developer Dua',
            'email' => 'dev2@garudahub.test',
            'password' => 'password123',
            'role' => 'developer',
        ]);

        $proyek1 = Project::create([
            'client_id' => $klien->id,
            'title' => 'Website Toko Online UMKM',
            'description' => 'Membutuhkan website toko online sederhana dengan katalog produk dan keranjang belanja.',
            'category' => 'Web',
            'budget_min' => 3000000,
            'budget_max' => 6000000,
            'deadline' => now()->addDays(30),
        ]);

        Project::create([
            'client_id' => $klien->id,
            'title' => 'Aplikasi Mobile Absensi Kampus',
            'description' => 'Aplikasi mobile untuk absensi mahasiswa dengan QR code.',
            'category' => 'Mobile',
            'budget_min' => 5000000,
            'budget_max' => 10000000,
            'deadline' => now()->addDays(45),
        ]);

        Bid::create([
            'project_id' => $proyek1->id,
            'developer_id' => $dev1->id,
            'price' => 4500000,
            'duration_days' => 21,
            'proposal' => 'Saya berpengalaman membangun toko online dengan Laravel.',
        ]);

        Bid::create([
            'project_id' => $proyek1->id,
            'developer_id' => $dev2->id,
            'price' => 5000000,
            'duration_days' => 14,
            'proposal' => 'Bisa selesai lebih cepat dengan desain responsif.',
        ]);
    }
}