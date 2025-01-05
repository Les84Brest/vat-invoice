<?php

namespace App\Models;

use App\Casts\InvoiceStatusCast;
use App\Casts\InvoiceTypeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Invoice
 *
 * @package App\Models
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * 
 * @property App\Types\InvoiceType $type
 * @property App\Types\InvoiceStatus $status
 * @property DateTime $action_date
 * @property DateTime $creation_date
 * @property string $number  
 * @property float $total
 * @property float $total_vat
 * @property float $total_wo_vat
 * @property int|null $signatory
 * @property int $recipient_company 
 * @property int $author
 * @property int $sender_company
 * @property array $delivery_documents
 * @property DateTime $contract_date
 * @property string $contract_number
 */

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $fillable = [
        'type',
        'status',
        'action_date',
        'creation_date',
        'number ',
        'total',
        'total_vat',
        'total_wo_vat',
        'signatory',
        'recipient_company',
        'author',
        'sender_company',
        'delivery_documents',
        'contract_date',
        'contract_number',
    ];

    protected $casts = [
        'status' => InvoiceStatusCast::class,
        'type' => InvoiceTypeCast::class,
    ];

    /**
     * Invoice author
     * 
     */

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns sygnatory model  if the invoice was signed
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function signatory(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    function sender_company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    function recipient_company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Parent invoice instance if it exists
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent_invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
