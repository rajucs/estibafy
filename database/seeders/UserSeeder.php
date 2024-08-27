<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        $adminRecords =
            array(

                array(
                    'id' => 1,
                    'name' => 'admin',
                    'user_type' => 1,
                    'mobile' => '03242193100',
                    'email' => 'admin@admin.com',
                    'password' => bcrypt(123456),
                    'image' => 'default-admin.jpeg',
                    'status' => 1,

                )
            ,
                array(

                    'id' => 2,
                    'name' => 'Sufee Latif',
                    'user_type' => 2,
                    'mobile' => '03332599077',
                    'email' => 'sufeelatif@gmail.com',
                    'password' => bcrypt(123456),
                    'image' => 'default-admin.jpeg',
                    'status' => 1,

                )
            );

        User::insert($adminRecords);
    }
}
