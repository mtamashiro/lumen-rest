<?php


namespace Domain\User\models;

use Domain\Person\models\Person;
use Illuminate\Database\Eloquent\Model;


class NaturalPerson extends Model
{
    protected $table = 'natural_persons';
    protected $fillable = ['cpf'];

    public function person(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(User::class, 'person');
    }
}
