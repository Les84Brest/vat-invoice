<?php

namespace Database\Seeders;

use App\Models\Company;
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
                'last_name' => 'Смирнова',
                'name' =>  'Мария',
                'password' => bcrypt('secret'),
                'email' => 'a60@bbb.com',
                'company_id' => 5,
                'role' => User::ROLE_USER
            ],
            [
                'last_name' => 'Кузнецов',
                'name' =>  'Алексей',
                'password' => bcrypt('secret'),
                'email' => 'a70@bbb.com',
                'company_id' => 7,
                'role' => User::ROLE_USER
            ],
            [
                'last_name' => 'Попова',
                'name' =>  'Анна',
                'password' => bcrypt('secret'),
                'email' => 'a80@bbb.com',
                'company_id' => 2,
                'role' => User::ROLE_USER
            ],
            [
                'last_name' => 'Васильев',
                'name' =>  'Дмитрий',
                'password' => bcrypt('secret'),
                'email' => 'a90@bbb.com',
                'company_id' => 3,
                'role' => User::ROLE_USER
            ],
            [
                'last_name' => 'Соколова',
                'name' =>  'Елена',
                'password' => bcrypt('secret'),
                'email' => 'a10@bbb.com',
                'company_id' => 1,
                'role' => User::ROLE_USER
            ],
            [
                'last_name' => 'Петров',
                'name' =>  'Сергей',
                'password' => bcrypt('secret'),
                'email' => 'a111@bbb.com',
                'company_id' => 5,
                'role' => User::ROLE_USER
            ],
            [
                'last_name' => 'Михайлова',
                'name' =>  'Ольга',
                'password' => bcrypt('secret'),
                'email' => 'a12@bbb.com',
                'company_id' => 5,
                'role' => User::ROLE_USER
            ],
            [
                'last_name' => 'Андреев',
                'name' =>  'Михаил',
                'password' => bcrypt('secret'),
                'email' => 'a103@bbb.com',
                'company_id' => 5,
                'role' => User::ROLE_USER
            ],
            [
                'last_name' => 'Фёдорова',
                'name' =>  'Виктория',
                'password' => bcrypt('secret'),
                'email' => 'a1455@bbb.com',
                'company_id' => 5,
                'role' => User::ROLE_USER
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
            $user = User::create($user);
            
            if ($user->role == User::ROLE_USER) {
                $randomCompany = Company::inRandomOrder()->first();
                $user->company_id = $randomCompany->id;
                $user->save();
            }
        }
    }
}
