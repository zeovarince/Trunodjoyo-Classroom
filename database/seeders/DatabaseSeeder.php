<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(15)->create();
        User::create([
            'name' => 'Dr. Rifqi Fairurrafi',
            'email' => 'dosen@trunojoyo.ac.id',
            'password' => bcrypt('dosen123'),
            'fakultas' => 'Teknik',
            'prodi' => 'Teknik Informatika',
            'role' => 'dosen',
            'npm' => '198001012005011201',
            'exp' => 0,
        ]);

        User::create([
            'name' => 'Ainur Raftuzzaki',
            'email' => '240411100034@student.trunojoyo.ac.id',
            'password' => bcrypt('tes123'),
            'fakultas' => 'Teknik',
            'prodi' => 'Teknik Informatika',
            'role' => 'mahasiswa',
            'npm' => '240411100034',
            'exp' => 500,

        ]);
        User::create([
            'name' => 'A. Choiril Anwar EL-Asfihani Risydan',
            'email' => '240411100098@student.trunojoyo.ac.id',
            'password' => bcrypt('riel123'),
            'fakultas' => 'Teknik',
            'prodi' => 'Teknik Informatika',
            'role' => 'mahasiswa',
            'npm' => '240411100098',
            'exp' => 350,

        ]);
        User::create([
            'name' => 'M. Zaidan Nabil Rafi',
            'email' => ' 240411100068@student.trunojoyo.ac.id',
            'password' => bcrypt('zaidan123'),
            'fakultas' => 'Teknik',
            'prodi' => 'Teknik Informatika',
            'role' => 'mahasiswa',
            'npm' => ' 240411100068',
            'exp' => 250,

        ]);
        User::create([
            'name' => 'Muhammad Izzul Millah Aqil',
            'email' => '240411100087@student.trunojoyo.ac.id',
            'password' => bcrypt('ijul123'),
            'fakultas' => 'Teknik',
            'prodi' => 'Teknik Informatika',
            'role' => 'mahasiswa',
            'npm' => '240411100087',
            'exp' => 400,

        ]);
        User::create([
            'name' => 'Verdy Setiyawan',
            'email' => '2404111000100@student.trunojoyo.ac.id',
            'password' => bcrypt('perdi123'),
            'fakultas' => 'Teknik',
            'prodi' => 'Teknik Informatika',
            'role' => 'mahasiswa',
            'npm' => '240411100100',
            'exp' => 95,

        ]);
    }
}
