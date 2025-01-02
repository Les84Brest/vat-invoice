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
                'tax_id' => 291746258
            ],
            [
                'title' => 'ООО "Магнат"',
                'short_title' => 'Магнат ООО',
                'address' => 'г. Барановичи, ул. Брестская, 522, пом 400',
                'tax_id' => 291583492
            ],
            [
                'title' => 'УП "Оазис"',
                'short_title' => 'Оазис УП',
                'address' => 'г. Брест, ул. Дмитрия Донского, д. 223, к. 33',
                'tax_id' => 291829531
            ],
            [
                'title' => 'ЧТУП "Техкомплекс"',
                'short_title' => 'Техкомплекс ЧТУП',
                'address' => 'г. Брест, ул. Зерновая, 115, пом. 30',
                'tax_id' => 291437568
            ],
            [
                'title' => 'ОАО "Графтех"',
                'short_title' => 'Графтех ОАО',
                'address' => 'г. Кобрин, ул. Суворова, д. 400, к. 800',
                'tax_id' => 291920475
            ],
            [
                'title' => 'ЗАО "Арес-медтехника"',
                'short_title' => 'Арес-медтехника ЗАО',
                'address' => 'г. Гродно, ул. Курчатова, д. 220',
                'tax_id' => 291265849
            ],
            [
                'title' => 'УП "Орбита"',
                'short_title' => 'Орбита УП',
                'address' => 'г. Витебск, ул. Сикорского, д. 350',
                'tax_id' => 291153748
            ],
            [
                'title' => 'ООО "Болид"',
                'short_title' => 'Болид ООО',
                'address' => 'г. Брест, бульвар Космонатов, д. 225',
                'tax_id' => 291384657
            ],
            [
                'title' => 'УП "Мегаполис"',
                'short_title' => 'Мегаполис УП',
                'address' => 'г. Могилев, ул. Леденцовая, 156',
                'tax_id' => 291678934
            ],
            [
                'title' => 'ЧТУП "Архитектурное бюро Хадид"',
                'short_title' => 'Архитектурное бюро Хадид ЧТУП',
                'address' => 'г. Витебск, ул. Б. Обамы, 456',
                'tax_id' => 291497263
            ],
            [
                'title' => 'ЗАО "Симфония"',
                'short_title' => 'Симфония ЗАО',
                'address' => 'г. Минск, бульвар Мулявина, д. 800, пом. 200',
                'tax_id' => 291826547
            ],
            [
                'title' => 'ТП "ТоргЗапрос"',
                'short_title' => 'ТоргЗапрос ТП',
                'address' => 'г. Волковыск, ул. Ленина, 115',
                'tax_id' => 291379654
            ],
            [
                'title' => 'ТП "РитейлФронт"',
                'short_title' => 'РитейлФронт ТП',
                'address' => 'г. Бобруйск, просп. Бобровый, 321',
                'tax_id' => 291548632
            ],
            [
                'title' => 'ООО "Веб-роут"',
                'short_title' => 'Веб-роут ООО',
                'address' => 'г. Лунинец, ул. Калиновского, 115',
                'tax_id' => 291762439
            ],
            [
                'title' => 'ЧТУП "Реализация"',
                'short_title' => 'Реализация ЧТУП',
                'address' => 'г. Дрогичин, ул. Костюшко, 116',
                'tax_id' => 291905847
            ]
        ];
        foreach ($companiesData as $company) {
            Company::create($company);
        }
    }
}
