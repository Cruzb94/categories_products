<?php

use Illuminate\Database\Seeder;
use App\Products;
use App\Categories;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = factory(Categories::class, 5)->create();
        $categories->each(function ($category) {
            $products = factory(Products::class, 10)->make();
            $category->products()->saveMany($products);
        });
    }
}
