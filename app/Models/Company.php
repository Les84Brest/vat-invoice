<?php

namespace App\Models;

use App\Casts\CompanyTransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $guarded = false;
    protected $casts = [
        'transaction_status' => CompanyTransactionStatus::class,
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
