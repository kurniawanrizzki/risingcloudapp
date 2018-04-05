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
                    'password' => bcrypt('Password 123'),
                    'phone' => '621282395560',
                    'address' => 'Jakarta Selatan, DKI Jakarta',
                    'role' => 0,
                    'created_by' => 0,
                    'created_at' => date('Y-m-d H:i:s')
          ],
          '2' => [
                    'id' => 2,
                    'username' => 'employee',
                    'password' => bcrypt('Password 123'),
                    'phone' => '6281282395560',
                    'address' => 'Jakarta Selatan, DKI Jakarta',
                    'role' => 1,
                    'created_by' => 1,
                    'created_at' => date('Y-m-d H:i:s')
          ]
        ];
        
        $categories = [
            '1' => [
                'id' => 1,
                'name' => 'Liquid',
                'description'=> "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sit amet tristique enim. Pellentesque nec accumsan risus.",
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '2' => [
                'id' => 2,
                'name' => 'Components',
                'description'=> "Nam dolor ex, varius vel vestibulum sit amet, elementum id velit. Etiam ante enim, varius dapibus massa non, fringilla egestas elit.",
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '3' => [
                'id' => 3,
                'name' => 'Electric Cigaretes',
                'description'=> "Pellentesque sollicitudin nunc eu magna pharetra posuere. Sed porttitor mauris interdum sit amet.",
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        $products = [
            '1' => [
                'id' => 1,
                'category_id' => 1,
                'name' => '5 x 120mL High Class Vape Co',
                'description' => 'Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.',
                'purchase' => 99000,
                'sell' => 125000,
                'stock' => 5,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '2' => [
                'id' => 2,
                'category_id' => 1,
                'name' => '3 x Vape Craft 120 mL Bottles',
                'description' => 'Praesent eu massa ac sapien luctus lobortis.',
                'purchase' => 65000,
                'sell' => 100000,
                'stock' => 8,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '3' => [
                'id' => 3,
                'name' => 'Cotton Candy Liquid',
                'category_id' => 1,
                'description' => 'Nunc justo dolor, molestie id orci quis, euismod tempor tellus. Aliquam aliquam blandit neque, suscipit iaculis massa laoreet at.',
                'purchase' => 89000,
                'sell' => 120000,
                'stock' => 10,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '4' => [
                'id' => 4,
                'name' => 'Pina Colada Liquid',
                'category_id' => 1,
                'description' => 'Aliquam erat volutpat. Maecenas laoreet bibendum leo, vitae convallis mi volutpat commodo. Aenean malesuada diam ut felis auctor.',
                'purchase' => 140000,
                'sell' => 200000,
                'stock' => 10,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '5' => [
                'id' => 5,
                'name' => 'Apple Candy',
                'category_id' => 1,
                'description' => 'vitae feugiat lacus efficitur. Nulla eu eleifend tortor. Cras urna risus, imperdiet eget vulputate eu, ultricies non libero.',
                'purchase' => 100000,
                'sell' => 160000,
                'stock' => 3,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '6' => [
                'id' => 6,
                'category_id' => 1,
                'name' => 'Icy Menthol',
                'description' => 'Nullam eget nisl neque. Etiam dictum dui sed quam ultricies tristique.',
                'purchase' => 175000,
                'sell' => 225000,
                'stock' => 2,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '7' => [
                'id' => 7,
                'category_id' => 3,
                'name' => 'Vaporesso Switcher 220W TC Box Mod *Used* ',
                'description' => 'Cras eu est iaculis, fermentum dolor et, egestas tortor.',
                'purchase' => 499000,
                'sell' => 600000,
                'stock' => 3,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '8' => [
                'id' => 8,
                'category_id' => 3,
                'name' => 'Smok X-Priv Kit *Used* ',
                'description' => 'Pellentesque hendrerit ante eget commodo varius. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos.',
                'purchase' => 390000,
                'sell' => 450000,
                'stock' => 5,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '9' => [
                'id' => 9,
                'category_id' => 3,
                'name' => 'SMOK GX 2/4 Kit *Used* ',
                'description' => 'Sed vel semper odio, nec mattis ex. Maecenas at nisl dui. Proin sed lobortis arcu. Integer aliquam, odio quis aliquam lacinia, purus sem scelerisque velit, ac dapibus nunc lorem sed est.',
                'purchase' => 250000,
                'sell' => 400000,
                'stock' => 2,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '10' => [
                'id' => 10,
                'category_id' => 3,
                'name' => 'Efest Slim K2 Charger *Used* ',
                'description' => 'Suspendisse tristique nunc non ipsum sollicitudin tincidunt. ',
                'purchase' => 279000,
                'sell' => 345000,
                'stock' => 1,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '11' => [
                'id' => 11,
                'category_id' => 3,
                'name' => 'White HexOhm 3.0 Ready to Rock!',
                'description' => 'Nullam sagittis, massa sed dignissim pellentesque, dolor mi tincidunt purus, non auctor mi tellus a diam. Interdum et malesuada fames ac ante ipsum primis in faucibus.',
                'purchase' => 330000,
                'sell' => 440000,
                'stock' => 5,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '12' => [
                'id' => 12,
                'category_id' => 2,
                'name' => '18650 Battery Tower - 3D Printed ',
                'description' => 'Etiam in congue massa, non laoreet sapien. Quisque ac turpis nibh. Interdum et malesuada fames ac ante ipsum primis in faucibus.',
                'purchase' => 100000,
                'sell' => 200000,
                'stock' => 4,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '13' => [
                'id' => 13,
                'category_id' => 2,
                'name' => 'Aspire Coils ',
                'description' => 'Fusce eget rutrum diam, in accumsan enim. Ut sed fringilla tortor. Aliquam consequat feugiat metus.',
                'purchase' => 400000,
                'sell' => 499000,
                'stock' => 5,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '14' => [
                'id' => 14,
                'category_id' => 2,
                'name' => 'Aspire Cleito Sub Ohm Tank ',
                'description' => 'Aliquam pretium eleifend quam.',
                'purchase' => 299000,
                'sell' => 349000,
                'stock' => 10,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ],
            '15' => [
                'id' => 15,
                'category_id' => 2,
                'name' => 'Atmos Greedy Replacement Coil ',
                'description' => 'Vivamus eu dolor nec ex euismod tincidunt iaculis semper nulla. Sed consectetur elit ut tincidunt vehicula.',
                'purchase' => 219000,
                'sell' => 400000,
                'stock' => 5,
                'img' =>'noimage.png',
                'created_by' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        
        foreach ($users as $key => $user) {
            DB::table('users')->insert($user);
        }
        
        foreach ($categories as $key => $category) {
            DB::table('categories')->insert($category);
        }
        
        foreach ($products as $key => $product) {
            DB::table('products')->insert($product);
        }
        
    }
}
