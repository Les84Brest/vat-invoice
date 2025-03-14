<?php

namespace App\Models;

use App\Casts\InvoiceDocumentsCast;
use App\Casts\InvoiceItemsCast;
use App\Casts\InvoiceStatusCast;
use App\Casts\InvoiceTypeCast;
use App\Models\Traits\Filterable;
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
    use HasFactory, Filterable;

    protected $table = 'invoices';
    protected $fillable = [
        'type',
        'status',
        'action_date',
        'creation_date',
        'number',
        'total',
        'total_vat',
        'total_wo_vat',
        'signatory_id',
        'recipient_company_id',
        'author_id',
        'sender_company_id',
        'delivery_documents',
        'contract_date',
        'contract_number',
        'invoice_items',
    ];

    protected $dates = [
        'action_date',
        'creation_date',
        'contract_date',
    ];

    protected $casts = [
        'status' => InvoiceStatusCast::class,
        'type' => InvoiceTypeCast::class,
        'delivery_documents' => InvoiceDocumentsCast::class,
        'invoice_items' => InvoiceItemsCast::class,
    ];

    /**
     * Invoice author
     * 
     */

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id', 'id');
    }

    /**
     * Returns sygnatory model  if the invoice was signed
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function signatory(): BelongsTo
    {
        return $this->belongsTo(User::class, 'signatory_id', 'id');
    }

    function sender_company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'sender_company_id', 'id');
    }

    function recipient_company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'recipient_company_id', 'id');
    }

    /**
     * Parent invoice instance if it exists
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent_invoice()
    {
        return $this->belongsTo(Invoice::class, 'parent_invoice_id', 'id');
    }
}
