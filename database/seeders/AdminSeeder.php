<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();

        Admin::create([
            'name'=>'admin1',
            'email'=>'admin1@gmail.com',
            'password'=>bcrypt('admin1@gmail.com'),
            'code'=>'342',
            'type'=>'1',
            'active'=>'1',
        ]);

    }

} //end of seeder
