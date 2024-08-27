<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserRoles;


class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRoles::truncate();

        $UserRoles = array(
            array(
                'id' => 1,
                'title' => 'Super Admin',
                'created_by' => 1,
                'status' => 1,

            ),
            array(
                'id' => 2,
                'title' => 'User',
                'created_by' => 1,
                'status' => 1,

            )
        );

        UserRoles::insert($UserRoles);


    }
}
