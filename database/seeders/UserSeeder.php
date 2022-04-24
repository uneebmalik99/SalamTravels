<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Usman Raza',
            'email' => 'usmanraza5245@gmail.com',
            'role' => 1,
            'password' => Hash::make('usman12345')
        ]);

        Customer::create([
            'email' => 'usmanraza5245@gmail.com',
            'password' => 'usman12345',
            'contact' => 'Usman Raza',
            'phone' => '3175469006',
            'mobile' => '3175469006',
            'ledger_link' => 'asdf.com',
            'visiting_card' => 'dsfsdfsd',
            'agency_picture' => 'afdsfsdfd',
            'status' => 2,
            'agency_name' => 'XYZ'
        ]);
    }
}
