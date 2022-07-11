<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("service_categories")->insert([
            [
                "name" => "Document",
                "slug" => "document",
                "image" => "1521974355.png",
            ], [
                "name" => "Movers & Packers",
                "slug" => "Movers-Packers",
                "image" => "1521969599.png",
            ], [
                "name" => "Home Automation",
                "slug" => "home-automation",
                "image" => "1521969622.png",
            ], [
                "name" => "Laundry",
                "slug" => "laundry",
                "image" => "1521972624.png"
            ], [
                "name" => "Painting",
                "slug" => "painting",
                "image" => "1521972643.png"
            ], [
                "name" => "Shower Filter",
                "slug" => "Shower-Filter",
                "image" => ""
            ], [
                "name" => "Home Cleaning",
                "slug" => "Home-Cleaning",
                "image" => "1521969446.png"
            ], [
                "name" => "Plumbing",
                "slug" => "Plumbing",
                "image" => ""
            ], [
                "name" => "Beauty",
                "slug" => "Beauty",
                "image" => "1521969358.png"
            ], [
                "name" => "Pest Control",
                "slug" => "Pest-Control",
                "image" => "1521969464.png"
            ], [
                "name" => "Electrical",
                "slug" => "electrical",
                "image" => "1521969419.png"
            ], [
                "name" => "Carpentry",
                "slug" => "carpentry",
                "image" => "1521969454.png"
            ], [
                "name" => "Chimney Hob",
                "slug" => "Chimney-Hob",
                "image" => ""
            ], [
                "name" => "Water Purifier",
                "slug" => "Water-Purifier",
                "image" => ""
            ], [
                "name" => "Computer Repair",
                "slug" => "Computer-Repair",
                "image" => ""
            ], [
                "name" => "TV",
                "slug" => "tv",
                "image" => ""
            ], [
                "name" => "Refrigerator",
                "slug" => "refrigerator",
                "image" => ""
            ], [
                "name" => "Geyser",
                "slug" => "geyser",
                "image" => ""
            ], [
                "name" => "Car",
                "slug" => "car",
                "image" => ""
            ]
        ]);
    }
}
