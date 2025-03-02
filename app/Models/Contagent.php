<?php

namespace App\Models;

use App\Traits\HasContragentTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property integer $id
 * @property integer $user_id
 * @property string $inn
 * @property string $name
 * @property string $ogrn
 * @property string $address
 * @property User $user
 */
class Contagent extends Model
{
    use HasContragentTrait;

    protected $fillable = [
        'inn',
        'name',
        'ogrn',
        'address',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
