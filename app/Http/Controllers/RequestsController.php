<?php

namespace App\Http\Controllers;

use App\Models\BankDetailsModel;
use App\Models\RequestModel;
use App\Models\UpiDetailsModel;
use App\Models\UserModel;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
    function add_request(Request $request)
    {
        $validate = Validator()->make($request->all(), [
            "user_id" => "required|string",
            "amount" => "required|string",
            "mode" => "required|string"
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
                $amount = (double) $request->amount;
                $total = $wallet - $amount;
                $user[0]->update(["wallet" => (string) $total]);
                RequestModel::create([
                    "user_id" => $request->user_id,
                    "amount" => $request->amount,
                    "mode" => $request->mode,
                    "status" => false
                ]);
                return response()->json([
                    "status" => "200",
                    "message" => "Request added",
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

    function get_my_request(Request $request)
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
                $requests = RequestModel::where("user_id", "=", $request->user_id)->get();
                return response()->json([
                    "status" => "200",
                    "message" => "Payments Fetched",
                    "data" => $requests
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

    function get_pending_request(Request $request)
    {

        $requests = RequestModel::where("status", "=", false)->get();
        return response()->json([
            "status" => "200",
            "message" => "Payments Fetched",
            "data" => $requests
        ], 200);

    }

    function get_completed_request(Request $request)
    {

        $requests = RequestModel::where("status", "=", true)->get();
        return response()->json([
            "status" => "200",
            "message" => "Payments Fetched",
            "data" => $requests
        ], 200);

    }

    function update_request(Request $request)
    {
        $validate = Validator()->make($request->all(), [
            "request_id" => "required|string",
            "status" => "required|boolean"
        ]);
        if ($validate->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $req = RequestModel::find($request->request_id);

            if ($req) {
                $req->update(["status" => $request->status]);
                return response()->json([
                    "status" => "200",
                    "message" => "Request Updated",
                    "data" => null
                ], 200);
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid request id",
                    "data" => null
                ], 500);
            }
        }
    }

    function get_request_details(Request $request)
    {
        $validate = Validator()->make($request->all(), [
            "request_id" => "required|string"
        ]);
        if ($validate->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $req = RequestModel::find($request->request_id);

            if ($req) {

                $user = UserModel::where("user_id", "=", $req->user_id)->get();
                if (count($user) == 1) {
                    $details = [
                        "name" => $user[0]->user_name,
                        "date" => $req->created_at,
                        "amount" => $req->amount,
                        "wallet" => $user[0]->wallet,
                        "status" => $req->status

                    ];
                    $bank = BankDetailsModel::where("user_id", "=", $request->user_id)->get();
                    if (count($bank) == 1) {
                        $details['bank'] = $bank[0]->bank_name;
                        $details['account'] = $bank[0]->acc_no;
                        $details['ifsc'] = $bank[0]->ifsc;
                    } else {
                        $details['bank'] = "";
                        $details['account'] = "";
                        $details['ifsc'] = "";
                    }
                    $upi = UpiDetailsModel::where("user_id", "=", $request->user_id)->get();
                    if (count($upi) == 1) {
                        $details['upi'] = $upi[0]->upi_id;
                        $details['upi_name'] = $upi[0]->name;
                    } else {
                        $details['upi'] = "";
                        $details['upi_name'] = "";
                    }
                    return response()->json([
                        "status" => "200",
                        "message" => "Request Fetched",
                        "data" => $details
                    ], 200);
                } else {
                    return response()->json([
                        "status" => "500",
                        "message" => "User Not Found",
                        "data" => null
                    ], 200);
                }

            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid request id",
                    "data" => null
                ], 500);
            }
        }
    }
}


