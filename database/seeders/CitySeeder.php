<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->delete();

        $cities = [
            ['en'=> 'Dahab', 'ar'=> 'دهب'],
            ['en'=> 'Sharm elsheikh', 'ar'=> 'شرم الشيخ'],
            ['en'=> 'Hurghada', 'ar'=> 'الغردقة'],
            ['en'=> 'Marsa Matrouh', 'ar'=> 'مرسى مطروح'],
            ['en'=> 'Giza', 'ar'=> 'الجيزة'],
            ['en'=> 'Alexandria', 'ar'=> 'الإسكندرية'],
            ['en'=> 'Tanta', 'ar'=> 'طنطا'],
            ['en'=> 'Menouf', 'ar'=> 'منوف'],
            ['en'=> 'Aswan', 'ar'=> 'أسوان'],
            ['en'=> 'Cairo', 'ar'=> 'القاهرة'],
        ];

        foreach ($cities as $city) {
            City::create([
                'name' => $city,
                'admin_id' => 1,
            ]);
        }

    }

} //end of seeder
