<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trip;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels =[[
            "name" => "MEININGER hotel",
            "type" => "hotel",
            "street" => "Am Postbahnhof 4",
            "zip_code" => "10243",
            "link" => "https://www.meininger-hotels.com/en/hotels/berlin/hotel-berlin-east-side-gallery/?utm_source=gmb&utm_medium=referral&utm_campaign=BER-AP&utm_content=website", 
            "city" => "Berlijn",
            "country" => "Duitsland",
            "phone" => "+49 (0)30 31878787",
            "image1" => "",
            "image2" => "",
        ]];
        foreach($hotels as $hotel){
            Hotel::create($hotel);
        }
    }
}
