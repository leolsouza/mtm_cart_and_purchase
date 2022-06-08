<?php

namespace Database\Seeders;

use App\Models\Purchase;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $itens = [
            'arroz','feijão','óleo','carne','café'
        ];

        foreach($itens as $item)
        {
            Purchase::create([
                'product' => $item
            ]);
        }
    }
}
