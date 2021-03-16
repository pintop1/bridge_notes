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
                'password'=>\Hash::make('notes2021@1'), 
                'mobile'=>'07000000000', 
                'is_admin'=>true, 
            ],
            [
                'firstname'=>'Super', 
                'lastname'=>'Admin', 
                'othername'=>'', 
                'email'=>'amonehin@bridgecredit.com.ng', 
                'email_verified_at'=>\Carbon\Carbon::now(), 
                'password'=>\Hash::make('notes2021@1'), 
                'mobile'=>'07000000002', 
                'is_admin'=>true, 
            ],
            [
                'firstname'=>'Super', 
                'lastname'=>'Admin', 
                'othername'=>'', 
                'email'=>'wagbonze@bridgecredit.com.ng', 
                'email_verified_at'=>\Carbon\Carbon::now(), 
                'password'=>\Hash::make('notes2021@1'), 
                'mobile'=>'07000000003', 
                'is_admin'=>true, 
            ],
            [
                'firstname'=>'Super', 
                'lastname'=>'Admin', 
                'othername'=>'', 
                'email'=>'rbalogun@bridgecredit.com.ng', 
                'email_verified_at'=>\Carbon\Carbon::now(), 
                'password'=>\Hash::make('notes2021@1'), 
                'mobile'=>'07000000004', 
                'is_admin'=>true, 
            ],
            [
                'firstname'=>'Super', 
                'lastname'=>'Admin', 
                'othername'=>'', 
                'email'=>'ooyelere@bridgecredit.com.ng', 
                'email_verified_at'=>\Carbon\Carbon::now(), 
                'password'=>\Hash::make('notes2021@1'), 
                'mobile'=>'07000000005', 
                'is_admin'=>true, 
            ],
        ];

        foreach ($data as $dat) {
            $user = User::create($dat);
        }
    }
}
