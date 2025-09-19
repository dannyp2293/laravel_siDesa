<?php

namespace Database\Seeders;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin SiDesa',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'status' => 'approved',
            'role_id' => '1', //admin
        ]);

        User::create([
            'id' =>2,
            'name' => 'Penududuk 1',
            'email' => 'penduduk@gmail.com',
            'password' => Hash::make('password'),
            'status' => 'approved',
            'role_id' => '1', //admin
        ]);
        Resident::create([
            'user_id' => 2,
            'nik' => '1234567890123456',
            'name' => 'Penduduk 1',
            'gender' => 'male',
            'birth_date' => '2005-01-01',
            'birth_place' => 'Cirebon',
            'address' => 'cirebon',
            'marital_status' => 'single',
        ]);
    }
}
