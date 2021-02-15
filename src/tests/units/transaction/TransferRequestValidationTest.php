<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use App\Api\Transaction\Validations\TransactionRequestValidation;
use Domain\User\models\NaturalPerson;

class TransactionRequestValidationTest extends TestCase
{
    public function testValidateSuccess()
    {
        $naturalPersonPayer = NaturalPerson::all()->random(1)->first();
        $naturalPersonPayee = NaturalPerson::all()->random(1)->first();

        $request = new Request();
        $request->value = 100.00;
        $request->payer = $naturalPersonPayer->person->id;
        $request->payee = $naturalPersonPayee->person->id;

        $this->assertTrue(TransactionRequestValidation::validate($request));
    }

    public function testInvalidValueTransferException()
    {
        $naturalPersonPayer = NaturalPerson::all()->random(1)->first();
        $naturalPersonPayee = NaturalPerson::all()->random(1)->first();

        $request = new Request();
        $request->value = "aaaa";
        $request->payer = $naturalPersonPayer->person->id;
        $request->payee = $naturalPersonPayee->person->id;

        $this->expectException(InvalidArgumentException::class);
        TransactionRequestValidation::validate($request);
    }

    public function testPayerNotFoundTransferException()
    {
        $naturalPersonPayee = NaturalPerson::all()->random(1)->first();

        $request = new Request();
        $request->value = 100;
        $request->payer = "xaxsao2";
        $request->payee = $naturalPersonPayee->person->id;

        $this->expectException(ModelNotFoundException::class);
        TransactionRequestValidation::validate($request);
    }

    public function testPayeeNotFoundTransferException()
    {
        $naturalPersonPayer = NaturalPerson::all()->random(1)->first();

        $request = new Request();
        $request->value = 100;
        $request->payer = $naturalPersonPayer->person->id;
        $request->payee = "xaxsao2";

        $this->expectException(ModelNotFoundException::class);
        TransactionRequestValidation::validate($request);
    }

    public function testValueLessThenZeroException()
    {
        $naturalPersonPayer = NaturalPerson::all()->random(1)->first();
        $naturalPersonPayee = NaturalPerson::all()->random(1)->first();

        $request = new Request();
        $request->value = -1;
        $request->payer = $naturalPersonPayer->person->id;
        $request->payee = $naturalPersonPayee->person->id;

        $this->expectException(InvalidArgumentException::class);
        TransactionRequestValidation::validate($request);
    }

    public function testValueEqualZeroException()
    {
        $naturalPersonPayer = NaturalPerson::all()->random(1)->first();
        $naturalPersonPayee = NaturalPerson::all()->random(1)->first();

        $request = new Request();
        $request->value = -1;
        $request->payer = $naturalPersonPayer->person->id;
        $request->payee = $naturalPersonPayee->person->id;

        $this->expectException(InvalidArgumentException::class);
        TransactionRequestValidation::validate($request);
    }
}
