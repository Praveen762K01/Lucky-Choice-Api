<?php

namespace App\Http\Controllers;

use App\Models\BannerModel;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    function create_banner(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "url" => "required|string",

        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);

        } else {

            BannerModel::create([
                "url" => $request->url,
            ]);
            return response()->json(
                [
                    "status" => "200",
                    "message" => "banner added successfully",
                    "data" => null
                ],
                200
            );


        }

    }

    function get_banner(Request $request)
    {
        $banner = BannerModel::get();
        return response()->json([
            "status" => "200",
            "message" => "banner fetched successfully",
            "data" => $banner
        ], 200);

    }

    function delete_banner(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "id" => "required|string"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);

        } else {
            $banner = BannerModel::find($request->id);
            if ($banner) {
                $banner->delete();
                return response()->json(
                    [
                        "status" => "200",
                        "message" => "banner deleted successfully",
                        "data" => null
                    ],
                    200
                );
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "banner dose not esists",
                    "data" => null
                ], 500);

            }

        }

    }
}
