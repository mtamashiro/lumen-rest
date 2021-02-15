<?php


namespace Domain\Transaction\Models;


use Domain\Account\Models\Account;
use Domain\Transaction\States\TransactionStates;
use Illuminate\Database\Eloquent\Model;
use Spatie\ModelStates\HasStates;

/**
 * @property \App\States\PaymentState $state
 */
class Transaction extends Model
{
    use HasStates;

    protected $casts = [
        'state' => TransactionStates::class,
    ];

    public $timestamps = true;

    protected $fillable = [
        'account_payer_id', 'account_payee_id', 'amount', 'state'
    ];

    public function account_payer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_payer_id');
    }

    public function account_payee(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Account::class, 'account_payee_id');
    }

    public function transfer() : bool
    {
        return $this->state->execute($this);
    }
}
