<?php

namespace Database\Factories;

use App\Models\Company;
use App\Types\InvoiceStatus;
use App\Types\InvoiceType;
use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $creationDate = $this->getRandomDate();
        $actionDate = clone $creationDate;
        $actionDate->modify('-14 days');

        $senderCompany = $this->getRandomCompany();

        $author = $senderCompany->users[0];
        $recipientCompany = Company::inRandomOrder()->first();

        $invoiceNumber = $this->generateInvoiceNumber($senderCompany->tax_id, $creationDate->format('dmY'));

        $sumWoVat  = 1 + mt_rand() / mt_getrandmax() * 10000;
        $sumVat = $sumWoVat * 0.2;


        return [
            'number' => $invoiceNumber,
            'creation_date' => $creationDate->format('Y-m-d'),
            'action_date' => $actionDate->format('Y-m-d'),

            'sender_company_id' => $senderCompany->id,
            'author_id' => $author->id,
            'recipient_company_id' => $recipientCompany->id,

            'type' => InvoiceType::ORIGINAL,
            'status' => InvoiceStatus::IN_PROGRESS,

            'total_wo_vat' => round($sumWoVat, 2),
            'total' => round($sumVat + $sumWoVat, 2),
            'total_vat' => round($sumVat, 2),

            'contract_number' => $this->faker->word(),
            'contract_date' => $this->getRandomDate()->format('Y-m-d'),
        ];
    }

    private function getRandomCompany()
    {
        // Only company with registered users can be the source of invoices
        $company = Company::with('users')->inRandomOrder()->first();
        $users = $company->users;

        while (!($users->count() > 0)) {
            $company = Company::with('users')->inRandomOrder()->first();
            $users = $company->users;
        }

        return $company;
    }

    private function getRandomDate(): DateTime
    {
        $now = new DateTime();

        // Subtract 2 months from the current date
        $fourMonthsAgo = (new DateTime())->modify('-4 months');

        // Calculate the difference in seconds between now and two months ago
        $interval = $now->diff($fourMonthsAgo);
        $totalSeconds = $interval->days * 86400 + $interval->h * 3600 + $interval->i * 60 + $interval->s;

        // Generate a random number of seconds within the past two months
        $randomSeconds = mt_rand(0, $totalSeconds);

        // Create a random date by subtracting the random seconds from the current date
        $randomDate = (new DateTime())->modify("-$randomSeconds seconds");

        // Format the random date as desired
        return $randomDate;
    }

    private function generateInvoiceNumber(int $taxId, string $invDate): string
    {
        $randomNumber = $this->generateFormattedRandomNumber();
        return $randomNumber . '-' . $invDate . '-' . $taxId;
    }

    private function generateFormattedRandomNumber(): string
    {
        // Generate a random number between 1 and 999,999,999
        $randomNumber = random_int(1, 999999999);

        // Format the number to ensure it has exactly 9 digits, padding with leading zeros
        $formattedNumber = str_pad($randomNumber, 9, '0', STR_PAD_LEFT);

        return $formattedNumber;
    }
}
