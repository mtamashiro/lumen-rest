<?php


namespace Domain\User\Models;


use Illuminate\Database\Eloquent\Model;

class JuridicalPerson extends Model
{
    protected $table = 'juridical_persons';
    protected $fillable = ['razao_social', 'cnpj'];

    public function person(){
        return $this->morphOne(User::class, 'person');
    }
}
