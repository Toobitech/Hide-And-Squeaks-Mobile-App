<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Treat;
class TreatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $treatsDemo = Treat::create([
            'treats'=> 300,
            'price' => 35,


        ]);

        $treatsDemo2 = Treat::create([
            'treats'=> 500,
            'price' => 50,


        ]);
        $treatsDemo2 = Treat::create([
            'treats'=> 1000,
            'price' => 75,


        ]);
    }
}
