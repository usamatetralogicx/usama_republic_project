<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'Men Clothing & Accessories',
            'Women Clothing & Accessories',
            'Toys & Hobbies',
            'Beauty and Health',
            'Watches',
            'Jewelry & Accessories',
            'Home & Garden',
            'Mother & Kids',
            'Sports & Entertainment',
            'Automobiles & Motorcycles',
            'Computer & Office',
            'Electronic Components & Supplies',
            'Furniture',
            'Home Improvement',
            'Lights & Lighting',
            'Luggage & Bags',
            'Novelty & Special Use',
            'Office & School Supplies',
            'Phone & Telecommunications',
            'Shoes',
            'Weddings & Events',
        ];

        foreach ($categories as $category) {
//            $cat = Category::create(['name' => $category]);
            $cat = Category::firstOrCreate(['name' => $category]);

            $cat->save();
        }


    }
}
