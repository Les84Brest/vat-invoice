<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Company
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $tax_id
 * @property string $title
 * @property string|null $short_title
 * @property string $address
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $guarded = false;
    protected $fillable = [
        'tax_id',
        'title',
        'short_title',
        'address',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
