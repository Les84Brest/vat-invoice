<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $companiesData = [
            [
                'title' => 'ОАО "Ключевая Точка"',
                'short_title' => 'Ключевая Точка ОАО',
                'address' => 'г. Пинск, ул Заслонова, 12',
                'tax_id' => 291333444, // Cast to integer
            ],
            [
                'title' => 'ООО "Магнат"',
                'short_title' => 'Магнат ООО',
                'address' => 'г. Барановичи, ул. Брестская, 122, пом 400',
                'tax_id' => 291555666, // Cast to integer
            ],
            [
                'title' => 'УП "Оазис"',
                'short_title' => 'Оазис УП',
                'address' => 'г. Брест, ул. Дмитрия Донского, д. 223, к. 33',
                'tax_id' => 291666777, // Cast to integer
            ],
            [
                'title' => 'ЧТУП "Техкомплекс"',
                'short_title' => 'Техкомплекс ЧТУП',
                'address' => 'г. Брест, ул. Зерновая, 115, пом. 30',
                'tax_id' => 291777888, // Cast to integer
            ],
            [
                'title' => 'ОАО "Графтех"',
                'short_title' => 'Графтех ОАО',
                'address' => 'г. Кобрин, ул. Суворова, д. 400, к. 800',
                'tax_id' => 291888999, // Cast to integer
            ],
            [
                'title' => 'ЗАО "Арес-медтехника"',
                'short_title' => 'Арес-медтехника ЗАО',
                'address' => 'г. Гродно, ул. Курчатова, д. 220',
                'tax_id' => 291999888, // Cast to integer
            ],
            [
                'title' => 'УП "Орбита"',
                'short_title' => 'Орбита УП',
                'address' => 'г. Витебск, ул. Сикорского, д. 350',
                'tax_id' => 291111444, // Cast to integer
            ],
            [
                'title' => 'ООО "Болид"',
                'short_title' => 'Болид ООО',
                'address' => 'г. Брест, бульвар Космонавтов, д. 225/17',
                'tax_id' => 291222333, // Cast to integer
            ],
        ];

        foreach ($companiesData as $company) {
            Company::create($company);
        }
    }
}
