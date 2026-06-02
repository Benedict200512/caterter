<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Juan Dela Cruz',
                'address' => 'Brgy. North Poblacion, City of Naga, Cebu',
                'date_of_birth' => '2000-01-15',
                'phone' => '09123456789',
                'username' => 'juan01',
                'email' => 'juan01@example.com',
                'role' => 'customer',
                'password' => Hash::make('Benedict-2005'),
            ],
            [
                'name' => 'Maria Santos',
                'address' => 'Brgy. South Poblacion, Cebu City',
                'date_of_birth' => '1999-05-20',
                'phone' => '09123456780',
                'username' => 'maria02',
                'email' => 'maria02@example.com',
                'role' => 'customer',
                'password' => Hash::make('Benedict-2005'),
            ],
            [
                'name' => 'Pedro Reyes',
                'address' => 'Talisay City, Cebu',
                'date_of_birth' => '2001-03-10',
                'phone' => '09123456781',
                'username' => 'pedro03',
                'email' => 'pedro03@example.com',
                'role' => 'customer',
                'password' => Hash::make('Benedict-2005'),
            ],
            [
                'name' => 'Ana Lopez',
                'address' => 'Minglanilla, Cebu',
                'date_of_birth' => '2002-07-25',
                'phone' => '09123456782',
                'username' => 'ana04',
                'email' => 'ana04@example.com',
                'role' => 'customer',
                'password' => Hash::make('Benedict-2005'),
            ],
            [
                'name' => 'Mark Garcia',
                'address' => 'San Fernando, Cebu',
                'date_of_birth' => '1998-11-12',
                'phone' => '09123456783',
                'username' => 'mark05',
                'email' => 'mark05@example.com',
                'role' => 'customer',
                'password' => Hash::make('Benedict-2005'),
            ],
            [
                'name' => 'Liza Ramos',
                'address' => 'Carcar City, Cebu',
                'date_of_birth' => '2000-09-30',
                'phone' => '09123456784',
                'username' => 'liza06',
                'email' => 'liza06@example.com',
                'role' => 'customer',
                'password' => Hash::make('Benedict-2005'),
            ],
            [
                'name' => 'John Paul Cruz',
                'address' => 'Naga City, Cebu',
                'date_of_birth' => '2001-06-18',
                'phone' => '09123456785',
                'username' => 'john07',
                'email' => 'john07@example.com',
                'role' => 'customer',
                'password' => Hash::make('Benedict-2005'),
            ],
            [
                'name' => 'Karen Villanueva',
                'address' => 'Toledo City, Cebu',
                'date_of_birth' => '1997-12-05',
                'phone' => '09123456786',
                'username' => 'karen08',
                'email' => 'karen08@example.com',
                'role' => 'customer',
                'password' => Hash::make('Benedict-2005'),
            ],
            [
                'name' => 'Chris Bautista',
                'address' => 'Lapu-Lapu City, Cebu',
                'date_of_birth' => '2003-02-14',
                'phone' => '09123456787',
                'username' => 'chris09',
                'email' => 'chris09@example.com',
                'role' => 'customer',
                'password' => Hash::make('Benedict-2005'),
            ],
            [
                'name' => 'Angelica Flores',
                'address' => 'Mandaue City, Cebu',
                'date_of_birth' => '2002-08-22',
                'phone' => '09123456788',
                'username' => 'angel10',
                'email' => 'angel10@example.com',
                'role' => 'customer',
                'password' => Hash::make('Benedict-2005'),
            ],
        ]);
    }
}