<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Configuration;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->userSeeder();
        $this->productSeeder();
        $this->productStockSeeder();
        $this->configurationSeeder();
    }

    private function userSeeder()
    {
        User::updateOrCreate(['email' => 'dani@rectmedia.com'], [
            'name' => 'Dani John',
            'email' => 'dani@rectmedia.com',
            'password' => bcrypt('qwerty'), // qwerty
            'role' => 'Admin', 
            ]
        );

        User::updateOrCreate(['email' => 'grace@rectmedia.com'], [
            'name' => 'Grace Meriana',
            'email' => 'grace@rectmedia.com',
            'password' => bcrypt('qwerty'), // qwerty
            'role' => 'Operator', 
            ]
        );
    }


    private function productSeeder()
    {
        $arrDatas = [
            ['name' => 'Korek', 'satuan' => 'Pcs'],
            ['name' => 'T - Shirt', 'satuan' => 'Pcs'],
            ['name' => 'Topi', 'satuan' => 'Pcs'],
            ['name' => 'Tas', 'satuan' => 'Pcs'],
            ['name' => 'Yuzu', 'satuan' => 'Pcs'],
            ['name' => '5 Day', 'satuan' => 'Pack'],
            ['name' => 'Krizzi', 'satuan' => 'Pack'],
            ['name' => 'Lighter', 'satuan' => 'Pcs'],
            ['name' => 'Keychain', 'satuan' => 'Pcs'],
            ['name' => 'Sling bag', 'satuan' => 'Pcs', 'background_color' => '#000000', 'text_color' => '#ffffff'],
        ];

        foreach ($arrDatas as $key => $data) {
            Product::updateOrCreate(['name' => $data['name']], [
                'name' => $data['name'],
                'satuan' => $data['satuan'],
                'background_color' => $data['background_color'] ?? null,
                'text_color' => $data['text_color'] ?? null,
                ]
            );
        }
    }



    private function productStockSeeder()
    {
        $arrDatas = [
            ["name" => "Yuzu", "stock" => 9],
            ["name" => "T - Shirt", "stock" => 30],
            ["name" => "Yuzu", "stock" => 9],
            ["name" => "Sling bag", "stock" => 20],
            ["name" => "Lighter", "stock" => 10],
            ["name" => "Krizzi", "stock" => 10],
            ["name" => "Keychain","stock" => 5],
            ["name" => "Lighter", "stock" => 10],
            ["name" => "Yuzu", "stock" => 9],
            ["name" => "Krizzi", "stock" => 5],
            ["name" => "Lighter", "stock" => 5],
            ["name" => "Krizzi", "stock" => 5]
        ];

        ProductStock::truncate();
        foreach ($arrDatas as $key => $data) {
            $product = Product::where('name', $data['name'])->first();
            if (isset($product)) {
                $insert = new ProductStock();
                $insert->product_id = $product->id;
                $insert->total_stock = $data['stock'];
                $insert->save();
            }
        }
    }


    private function configurationSeeder()
    {
        Configuration::updateOrCreate(['key' => 'show_roulette'], [
            'value' => true,
            ]
        );
    }
}
