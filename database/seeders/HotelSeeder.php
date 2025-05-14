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
        $hotels = [
            [
                "name" => "MEININGER hotel",
                "type" => "hotel",
                "street" => "Am Postbahnhof 4",
                "zip_code" => "10243",
                "link" => "https://www.meininger-hotels.com/en/hotels/berlin/hotel-berlin-east-side-gallery/?utm_source=gmb&utm_medium=referral&utm_campaign=BER-AP&utm_content=website",
                "city" => "Berlijn",
                "country" => "Duitsland",
                "phone" => "+49 (0)30 31878787",
                "image1" => "http://localhost/storage/files/1/hotel1.png",
                "image2" => "http://localhost/storage/files/1/hotel2.png",
            ],
            [
                "name" => "Märchenhotel",
                "type" => "hotel",
                "street" => "Dorfstrasse 24",
                "zip_code" => "8784",
                "link" => "https://www.maerchenhotel.ch/?trv_reference=ee25998f-0234-389a-bb58-6948b4b5947d",
                "city" => "Braunwald",
                "country" => "Zwitserland",
                "phone" => "+41(55)6537171",
                "image1" => "http://localhost/storage/files/1/hotel3.png",
                "image2" => "http://localhost/storage/files/1/hotel4.png",
            ],
            [
                "name" => "Pfefferbett Hostel",
                "type" => "Jeugdherberg",
                "street" => "Christinenstraße 18-19",
                "zip_code" => "10119",
                "link" => "https://pfefferbett.de/en/",
                "city" => "Berlijn",
                "country" => "Duitsland",
                "phone" => "+49 30 233288100",
                "image1" => "http://localhost/storage/files/1/hotel5.jpg",
                "image2" => "http://localhost/storage/files/1/hotel6.jpg",
            ],
            [
                "name" => "Hotel Aurora",
                "type" => "Jeugdherberg",
                "street" => "Cristoforo Colombo 57",
                "zip_code" => "04029",
                "link" => "https://www.hotelaurorasperlonga.it/home-page-eng/?trv_reference=977523ab-b4c4-3b80-8f28-3440874d6de6",
                "city" => "Sperlonga",
                "country" => "Italië",
                "phone" => "+390(771)549266",
                "image1" => "http://localhost/storage/files/1/hotel7.jpg",
                "image2" => "http://localhost/storage/files/1/hotel8.jpg",
            ]
        ];
        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }
    }
}
