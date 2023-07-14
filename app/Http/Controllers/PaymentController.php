<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Models\Payment;
use App\Services\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class PaymentController extends Controller
{
    //
    public PaymentService $paymentService;
    public function __construct() {

        $this->paymentService = new PaymentService();
    }


    public function makePayment(PaymentRequest $request) : JsonResponse
    {
        $user = auth()->user();
        $ref = uniqid();
        $data = [
            'amount' => $request->amount * 100,
            'description' => $request->description,
            'email' => $user->email,
            'user_id' => $user->id,
            'reference' => $ref,
            'callback_url' => route('verifyTransaction')
        ];

        Payment::create(Arr::except($data, 'callback_url', 'email'));

        $result = $this->paymentService->initializeTransaction($data);

        return response()->json([
            "message" => " Payament initialized successfully",
            "data" =>  $result,
            'status' => 200
        ]);

    }

    public function verifyTransaction(Request $request)
    {
        $response =  $this->paymentService->verifyTransaction($request->reference);

        if($response['status'] ==true){
            $payment = Payment::where('reference' ,$request->reference)->first();
            $payment->staus = 'successful';
            $payment->save();

            

            return response()->json([
                "message" => " Payament made successfully",
                "data" =>  $payment,
                'status' => 200
            ]);

        }

        return response()->json([
            "message" => " Payament made was not successfully",
            'status' => 400
        ]);
    }
}