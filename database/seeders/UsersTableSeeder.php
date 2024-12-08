<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;



class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userData = [

            [
                'last_name' => 'Давыдов',
                'name' =>    'Гордей',
                'password' => bcrypt('secret'),
                'email' => 'a1@bbb.com',
                'role' => USER::ROLE_USER,
                'company_id' => 1
            ],
            [
                'last_name' => 'Махов',
                'name' =>    'Руслан',
                'password' => bcrypt('secret'),
                'email' => 'a2@bbb.com',
                'role' => USER::ROLE_USER,
                'company_id' => 2
            ],
            [
                'last_name' => 'Благово',
                'name' =>    'Инесса',
                'password' => bcrypt('secret'),
                'email' => 'a3@bbb.com',
                'role' => USER::ROLE_USER,
                'company_id' => 3
            ],
            [
                'last_name' => 'Дондукова',
                'name' =>    'Братислава',
                'password' => bcrypt('secret'),
                'email' => 'a4@bbb.com',
                'role' => USER::ROLE_USER,
                'company_id' => 4
            ],
            [
                'last_name' => 'Голубь',
                'name' =>    'Алена',
                'password' => bcrypt('secret'),
                'email' => 'a5@bbb.com',
                'role' => USER::ROLE_USER,
                'company_id' => 2
            ],
            [
                'last_name' => 'Семенюк',
                'name' =>    'Екатерина',
                'password' => bcrypt('secret1'),
                'email' => 'kate@sem.com',
                'role' => USER::ROLE_ADMIN,
            ],
        
        ];

        foreach ($userData as $user) {
            User::create($user);
        }
    }
}
