<?php

namespace App\Models;

use App\Casts\InvoiceStatusCast;
use App\Casts\InvoiceTypeCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $guarded = false;

    protected $casts = [
        'status' => InvoiceStatusCast::class,
        'type' => InvoiceTypeCast::class,
    ];

    /**
     * Invoice author
     * 
     */

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function signatory()
    {
        return $this->belongsTo(User::class);
    }

    function sender_company()
    {
        $this->belongsTo(Company::class);
    }

    function recipient_company()
    {
        $this->belongsTo(Company::class);
    }

    /**
     * Parent invoice instance if it exists
     */
    public function parent_invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
