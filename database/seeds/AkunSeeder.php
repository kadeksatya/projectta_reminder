<?php

use App\Nasabah;
use App\Pegawai;
use App\Penduduk;
use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AkunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create(
            [
                'nama' => 'owner',
                'username' => 'owner',
                'role' => 'owner',
                'email' => 'owner@gmail.com',
                'password' => Hash::make('owner'),
            ]
        );

        User::create(
            [
                'nama' => 'kasir',
                'username' => 'kasir',
                'role' => 'kasir',
                'email' => 'kasir@gmail.com',
                'password' => Hash::make('kasir'),
            ]
        );
    }
}
