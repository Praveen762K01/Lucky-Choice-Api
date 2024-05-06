<?php

namespace App\Http\Controllers;

use App\Models\BankDetailsModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class BankDetailsController extends Controller
{
    function get_bank_details(Request $request)
    {
        $validator = Validator()->make($request->all(), [
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
                $upi = BankDetailsModel::where("user_id", "=", $request->user_id)->get();
                if (count($upi) == 0) {
                    return response()->json([
                        "status" => "500",
                        "message" => "Bank details not found",
                        "data" => null
                    ], 500);
                } else {
                    return response()->json([
                        "status" => "200",
                        "message" => "Bank fetched",
                        "data" => $upi[0]
                    ], 200);
                }
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid user Id",
                    "data" => null
                ], 500);
            }


        }

    }

    function update_bank_details(Request $request)
    {
        $validator = Validator()->make($request->all(), [
            "user_id" => "required|string",
            "bank_name" => "required|string",
            "name" => "required|string",
            "acc_no" => "required|string",
            "ifsc" => "required|string",
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
                $upi = BankDetailsModel::where("user_id", "=", $request->user_id)->get();
                if (count($upi) == 0) {
                    BankDetailsModel::create([

                        "user_id" => $request->user_id,
                        "bank_name" => $request->bank_name,
                        "name" => $request->name,
                        "acc_no" => $request->acc_no,
                        "ifsc" => $request->ifsc,
                    ]);
                    return response()->json([
                        "status" => "200",
                        "message" => "Bank details updated",
                        "data" => null
                    ], 200);
                } else {
                    $upi[0]->update([
                        "bank_name" => $request->bank_name,
                        "name" => $request->name,
                        "acc_no" => $request->acc_no,
                        "ifsc" => $request->ifsc,
                    ]);
                    return response()->json([
                        "status" => "200",
                        "message" => "Bank details updated",
                        "data" => null
                    ], 200);
                }
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid user Id",
                    "data" => null
                ], 500);
            }


        }

    }
}
