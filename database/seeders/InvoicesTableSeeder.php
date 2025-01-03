<?php

namespace Database\Seeders;

use App\Models\Invoice;
use Illuminate\Database\Seeder;



class InvoicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $invoices = Invoice::factory(200)->create();
    }
}
