<?php


use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Domain\Transaction\DataTransferObjects\TransactionData;
use Domain\Transaction\Actions\TransactionAction;
use Domain\Transaction\Models\Transaction;
use Domain\Account\Models\Account;
use App\Core\Exceptions\CustomExceptions\NotAllowedAction;
use Domain\User\models\NaturalPerson;
use Domain\User\models\JuridicalPerson;

class TransactionActionTest extends TestCase
{
    public function testTransferSuccess()
    {
        $naturalPersonPayer = NaturalPerson::all()->random(1)->first();
        $naturalPersonPayee = NaturalPerson::all()->random(1)->first();

        $transfer = [
            'value' => 100.00,
            'payer' => $naturalPersonPayer->person->id,
            'payee' => $naturalPersonPayee->person->id
        ];

        $account = Account::where('user_id', $naturalPersonPayer->person->id)->first();
        $account->amount = 100;
        $account->save();

        $transferData = TransactionData::fromRequest((object)$transfer);
        $transferAction = new TransactionAction($transferData);
        $transaction = $transferAction->execute();

        $this->assertTrue($transaction instanceof Transaction);

    }

    public function testTransferInsufficientAccount()
    {
        $naturalPersonPayer = NaturalPerson::all()->random(1)->first();
        $naturalPersonPayee = NaturalPerson::all()->random(1)->first();

        $transfer = [
            'value' => 100.00,
            'payer' => $naturalPersonPayer->person->id,
            'payee' => $naturalPersonPayee->person->id
        ];

        $account = Account::where('user_id', $naturalPersonPayer->person->id)->first();
        $account->amount = 99.99;
        $account->save();

        $transferData = TransactionData::fromRequest((object)$transfer);
        $transferAction = new TransactionAction($transferData);

        $this->expectException(NotAllowedAction::class);
        $transferAction->execute();
    }

    public function testTransferForJuridicalPerson()
    {
        $juridicalPersonPayer = JuridicalPerson::all()->random(1)->first();
        $naturalPersonPayee = NaturalPerson::all()->random(1)->first();

        $transfer = [
            'value' => 100.00,
            'payer' => $juridicalPersonPayer->person->id,
            'payee' => $naturalPersonPayee->person->id
        ];

        $account = Account::where('user_id', $juridicalPersonPayer->person->id)->first();
        $account->amount = 99.99;
        $account->save();

        $transferData = TransactionData::fromRequest((object)$transfer);
        $transferAction = new TransactionAction($transferData);

        $this->expectException(NotAllowedAction::class);
        $transferAction->execute();
    }
}
