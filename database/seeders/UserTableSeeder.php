<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'firstname'=>'Super', 
                'lastname'=>'Admin', 
                'othername'=>'', 
                'email'=>'admin@bridgecredit.ng', 
                'email_verified_at'=>\Carbon\Carbon::now(), 
                'password'=>'notes2021@1', 
                'mobile'=>'07000000000', 
                'is_admin'=>true, 
            ],
        ];

        foreach ($data as $dat) {
            $user = User::create($dat);
        }
    }
}
