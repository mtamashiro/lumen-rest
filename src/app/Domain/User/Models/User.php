<?php


namespace Domain\User\Models;


use Domain\Account\Models\Account;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = true;

    protected $fillable = [
        'name', 'email', 'password'
    ];

    public function accounts(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Account::class);
    }

    public function person(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo('person');
    }
}
