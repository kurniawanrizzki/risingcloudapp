<?php

use Illuminate\Database\Seeder;

class RisingCloudSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
          '1' => [
                    'id' => 1,
                    'username' => 'administrator',
                    'password' => Hash::make('Password 123'),
                    'phone' => '621282395560',
                    'address' => 'Jakarta Selatan, DKI Jakarta',
                    'role' => 0,
                    'created_by' => 0,
                    'created_at' => date('Y-m-d H:i:s')
          ],
          '2' => [
                    'id' => 2,
                    'username' => 'employee',
                    'password' => Hash::make('Password 123'),
                    'phone' => '6281282395560',
                    'address' => 'Jakarta Selatan, DKI Jakarta',
                    'role' => 1,
                    'created_by' => 1,
                    'created_at' => date('Y-m-d H:i:s')
          ]
        ];
        
        foreach ($users as $key => $user) {
            DB::table('users')->insert($user);
        }
        
    }
}
