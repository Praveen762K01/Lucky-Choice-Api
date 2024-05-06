<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Response;

class UserController extends Controller
{
    function create_user(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "mobile" => "required|string",
            "user_name" => "required|string",
            "user_id" => "required|string",
            "refered_by" => "required|string"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);

        } else {
            $old_user = UserModel::where('user_id', "=", $request->user_id)->get();
            if (count($old_user) > 0) {
                return response()->json([
                    "status" => "500",
                    "message" => "user id already esists",
                    "data" => null
                ], 500);
            } else {
                $user = UserModel::create([
                    "user_name" => $request->user_name,
                    "mobile" => $request->mobile,
                    "wallet" => "0.0",
                    "user_id" => $request->user_id,
                    "refered_by" => str_replace("LKCE#", "", $request->refered_by),
                    "is_active" => true,
                    "ref_paid" => $request->refered_by == "No"
                ]);
                return response()->json(
                    [
                        "status" => "200",
                        "message" => "user created successfully",
                        "data" => [
                            "user_name" => $user->user_name,
                            "mobile" => $user->mobile,
                            "wallet" => "0.0",
                            "user_id" => $user->user_id,
                            "refered_by" => $user->refered_by,
                            "is_active" => true
                        ]
                    ],
                    200
                );
            }

        }

    }

    function get_user(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "user_id" => "required|string"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "please provide user id",
                "data" => null
            ], 500);
        } else {

            $user = UserModel::where("user_id", "=", $request->user_id)->get();
            if (count($user) == 1) {
                return response()->json([
                    "status" => "200",
                    "message" => "user fetched successfully",
                    "data" => $user[0]
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


    function get_all_user(Request $request)
    {
        $user = UserModel::get();
        return response()->json([
            "status" => "200",
            "message" => "user fetched successfully",
            "data" => $user
        ], 200);
    }

    function update_user(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "mobile" => "required|string",
            "user_name" => "required|string",
            "user_id" => "required|string"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);

        } else {
            $old_user = UserModel::where('user_id', "=", $request->user_id)->get();
            if (count($old_user) > 0) {
                $user = $old_user[0]->update([
                    "user_name" => $request->user_name,
                    "mobile" => $request->mobile,
                ]);
                return response()->json(
                    [
                        "status" => "200",
                        "message" => "user updated successfully",
                        "data" => null
                    ],
                    200
                );
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "user id dose not esists",
                    "data" => null
                ], 500);

            }

        }

    }

    function get_pdf(Request $request)
    {
        return response()->json(
            [
                "status" => "200",
                "message" => "user updated successfully",
                "data" => [
                    "faq" => "https://pub.dev/packages/url_launcher",
                    "about_us" => "about us url",
                    "contact_us" => "contact us url",
                    "privacy" => "privacy policy url",
                    "tc" => "TC Url"
                ]
            ],
            200
        );
    }


}
