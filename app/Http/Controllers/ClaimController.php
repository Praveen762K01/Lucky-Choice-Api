<?php

namespace App\Http\Controllers;

use App\Models\ClaimModel;
use App\Models\PaymentsModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    function get_my_earnings(Request $request)
    {
        $validator = validator()->make($request->all(), [

            "user_id" => "required|string"

        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $user = UserModel::where("user_id", "=", $request->user_id)->get();
            if (count($user) == 1) {

                $earnings = ClaimModel::where("user_id", "=", $request->user_id)->get();
                return response()->json([
                    "status" => "200",
                    "message" => "Earnings fetched",
                    "data" => $earnings
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

    function claim_my_earning(Request $request)
    {
        $validator = validator()->make($request->all(), [

            "user_id" => "required|string",
            "claim_id" => "required|string"

        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $user = UserModel::where("user_id", "=", $request->user_id)->get();
            if (count($user) == 1) {

                $earning = ClaimModel::find($request->claim_id);
                if ($earning) {
                    $old_wallet = (int) $user[0]->wallet;
                    $prize_amount = (int) $earning->amount;
                    $user[0]->update(["wallet" => (string) ($old_wallet + $prize_amount)]);
                    $earning->update([
                        "is_paid" => true
                    ]);
                    PaymentsModel::create([
                        "user_id" => $request->user_id,
                        "amount" => (string) $earning->amount,
                        "transaction_id" => "Claimed from Earnings",
                        "message" => "Claimed from Earnings"
                    ]);
                    return response()->json([
                        "status" => "200",
                        "message" => "Earnings Claimed",
                        "data" => null
                    ], 200);
                } else {
                    return response()->json([
                        "status" => "500",
                        "message" => "Invalid claim id",
                        "data" => null
                    ], 500);
                }



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
