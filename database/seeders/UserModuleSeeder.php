<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserModule;

class UserModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserModule::truncate();

        $UserModule = array(

            array('module_title' => 'Users', 'module_slug' => 'user-view', 'created_by' => 1, 'status' => 1, 'action_title' => 'View'),
            array('module_title' => 'Users', 'module_slug' => 'user-add', 'created_by' => 1, 'status' => 1, 'action_title' => 'Add'),
            array('module_title' => 'Users', 'module_slug' => 'user-edit', 'created_by' => 1, 'status' => 1, 'action_title' => 'Edit'),
            array('module_title' => 'Users', 'module_slug' => 'user-delete', 'created_by' => 1, 'status' => 1, 'action_title' => 'Delete'),

            array('module_title' => 'User Role', 'module_slug' => 'user-role-view', 'created_by' => 1, 'status' => 1, 'action_title' => 'View'),
            array('module_title' => 'User Role', 'module_slug' => 'user-role-add', 'created_by' => 1, 'status' => 1, 'action_title' => 'Add'),
            array('module_title' => 'User Role', 'module_slug' => 'user-role-edit', 'created_by' => 1, 'status' => 1, 'action_title' => 'Edit'),
            array('module_title' => 'User Role', 'module_slug' => 'user-role-delete', 'created_by' => 1, 'status' => 1, 'action_title' => 'Delete'),

            array('module_title' => 'Companies', 'module_slug' => 'CompaniesView', 'created_by' => 1, 'status' => 1, 'action_title' => 'View'),
            array('module_title' => 'Companies', 'module_slug' => 'CompaniesAdd', 'created_by' => 1, 'status' => 1, 'action_title' => 'Add'),
            array('module_title' => 'Companies', 'module_slug' => 'CompaniesEdit', 'created_by' => 1, 'status' => 1, 'action_title' => 'Edit'),
            array('module_title' => 'Companies', 'module_slug' => 'CompaniesDelete', 'created_by' => 1, 'status' => 1, 'action_title' => 'Delete'),


        );

        UserModule::insert($UserModule);
    }
}
