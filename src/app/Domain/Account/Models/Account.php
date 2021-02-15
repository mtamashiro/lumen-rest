<?php


namespace Domain\Account\Models;


use Domain\Transaction\Models\Transaction;
use Domain\User\Models\User;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'amount', 'user_id'
    ];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
