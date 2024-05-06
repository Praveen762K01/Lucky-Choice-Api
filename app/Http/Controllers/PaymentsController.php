<?php

namespace App\Http\Controllers;

use App\Models\PaymentsModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    function add_payment(Request $request)
    {
        $validate = Validator()->make($request->all(), [
            "user_id" => "required|string",
            "amount" => "required|string",
            "transaction_id" => "required|string",
        ]);
        if ($validate->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $user = UserModel::where("user_id", "=", $request->user_id)->get();
            if (count($user) == 1) {
                $wallet = (int) $user[0]->wallet;
                $amount = (int) $request->amount;
                $total = $wallet + $amount;
                $user[0]->update(["wallet" => (string) $total]);
                PaymentsModel::create([
                    "user_id" => $request->user_id,
                    "amount" => $request->amount,
                    "transaction_id" => $request->transaction_id,
                    "message" => "Wallet Top Up"
                ]);
                return response()->json([
                    "status" => "200",
                    "message" => "Payment added",
                    "data" => null
                ], 200);
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid user id",
                    "data" => null
                ], 500);
            }
        }
    }

    function get_payment(Request $request)
    {
        $validate = Validator()->make($request->all(), [
            "user_id" => "required|string"
        ]);
        if ($validate->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $user = UserModel::where("user_id", "=", $request->user_id)->get();
            if (count($user) == 1) {
                $payments = PaymentsModel::where("user_id", "=", $request->user_id)->get();
                return response()->json([
                    "status" => "200",
                    "message" => "Payments Fetched",
                    "data" => $payments
                ], 500);
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid user id",
                    "data" => null
                ], 500);
            }
        }
    }
}
