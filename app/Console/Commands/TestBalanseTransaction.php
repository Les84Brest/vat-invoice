<?php

namespace App\Console\Commands;

use App\Models\Company;
use App\Structures\CompanyTransactionStatus;
use Illuminate\Console\Command;

class TestBalanseTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tb:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Протестировать каст Json данных в класс';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $company = new Company();
        $company->transaction_status =  CompanyTransactionStatus::fromArray([
            'reject_code' => 100500,
            'message' => "Some message about что-то важное"
        ]);
        $company->address = "г. Минск, ул. Короля, 22";
        $company->tax_id = 231123654;
        $company->short_title = "Строй-перестрой";
        $company->title = 'ООО "Строй-перестрой"';

        $company->save();
    }
}
