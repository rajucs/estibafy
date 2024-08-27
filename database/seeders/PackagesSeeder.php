<?php

namespace Database\Seeders;

use App\Models\Container;
use App\Models\Package;
use Illuminate\Database\Seeder;

use App\Models\User;

class PackagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Package::truncate();
        $Package =
            array(

                array(
                    'id' => 1,
                    'name' => 'Boxes',
                    'status' => 1,
                )
            ,
                array(
                    'id' =>2,
                    'name' => 'Tanks',
                    'status' => 1,
                )
            );

            Package::insert($Package);

            Container::truncate();
            $Container =
                array(
    
                    array(
                        'id' => 1,
                        'name' => 'Containe 20 feet',
                        'helper_size' => '2',
                        'size' => '20',
                        'type' => '1',
                        'status' => 1,
                    )
                ,
                    array(
                        'id' =>2,
                        'name' => 'Containe 40 feet',
                        'helper_size' => '5',
                        'size' => '40',
                        'type' => '2',
                        'status' => 1,
                    )
                );
    
                Container::insert($Container);
 

    }
}
