<?php


namespace App\Api\Transaction\Controllers;

use App\Api\Transaction\FormatResponse\TransactionFormatResponse;
use App\Api\Transaction\Validations\TransactionRequestValidation;
use App\Core\Http\Controllers\Controller;
use Domain\Transaction\Actions\TransactionAction;
use Domain\Transaction\DataTransferObjects\TransactionData;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function transfer(Request $request): \Illuminate\Http\JsonResponse
    {
        TransactionRequestValidation::validate($request);
        $transactionData = TransactionData::fromRequest($request);
        $transactionAction = new TransactionAction($transactionData);
        $response = $transactionAction->execute();

        return response()->json(TransactionFormatResponse::format($response), 201);
    }
}
