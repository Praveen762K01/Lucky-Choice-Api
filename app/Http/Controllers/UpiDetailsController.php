<?php

namespace App\Http\Controllers;

use App\Models\UpiDetailsModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Validator;

class UpiDetailsController extends Controller
{
    function get_upi_details(Request $request)
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
                $upi = UpiDetailsModel::where("user_id", "=", $request->user_id)->get();
                if (count($upi) == 0) {
                    return response()->json([
                        "status" => "500",
                        "message" => "UPI details not found",
                        "data" => null
                    ], 500);
                } else {
                    return response()->json([
                        "status" => "200",
                        "message" => "UPI fetched",
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

    function update_upi_details(Request $request)
    {
        $validator = Validator()->make($request->all(), [
            "user_id" => "required|string",
            "name" => "required|string",
            "number" => "required|string",
            "upi_id" => "required|string",
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
                $upi = UpiDetailsModel::where("user_id", "=", $request->user_id)->get();
                if (count($upi) == 0) {
                    UpiDetailsModel::create([
                        "user_id" => $request->user_id,
                        "name" => $request->name,
                        "upi_number" => $request->number,
                        "upi_id" => $request->upi_id,
                    ]);
                    return response()->json([
                        "status" => "200",
                        "message" => "UPI details updated",
                        "data" => null
                    ], 200);
                } else {
                    $upi[0]->update([
                        "name" => $request->name,
                        "upi_number" => $request->number,
                        "upi_id" => $request->upi_id,
                    ]);
                    return response()->json([
                        "status" => "200",
                        "message" => "UPI details updated",
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
