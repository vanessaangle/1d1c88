<?php

use Illuminate\Database\Seeder;
use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'oka',
            'password' => bcrypt('123456'),
            'nama' => 'Administrator',
            'alamat' => 'Jalan Puputan Renon No 86 Denpasar',
            'tgl_lahir' => '1995-09-16',
            'tempat_lahir' => 'Renon',
            'role' => 'Admin',
            'status' => 'Aktif'
        ]);
    }
}
