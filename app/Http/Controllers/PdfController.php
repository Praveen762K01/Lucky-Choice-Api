<?php

namespace App\Http\Controllers;

use App\Models\PdfModel;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    function get_pdf(Request $request)
    {
        $pdfs = PdfModel::get();
        if (count($pdfs) == 1) {
            return response()->json(
                [
                    "status" => "200",
                    "message" => "user updated successfully",
                    "data" => [
                        "faq" =>  $pdfs[0]->faq,
                        "about_us" => $pdfs[0]->about,
                        "contact_us" =>  $pdfs[0]->contact,
                        "privacy" => $pdfs[0]->privacy,
                        "tc" => $pdfs[0]->tc
                    ]
                ],
                200
            );
        } else {
            return response()->json(
                [
                    "status" => "200",
                    "message" => "user updated successfully",
                    "data" => [
                        "faq" =>  "",
                        "about_us" => "",
                        "contact_us" => "",
                        "privacy" => "",
                        "tc" => ""
                    ]
                ],
                200
            );
        }
    }

    function add_pdf(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "type" => "required|string",
            "url" => "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $pdfs = PdfModel::get();
            if (count($pdfs) == 1) {
                $user = $pdfs[0]->update([
                    $request->type => $request->url,
                ]);
                return response()->json(
                    [
                        "status" => "200",
                        "message" => "pdf updated successfully",
                        "data" => null
                    ],
                    200
                );
            } else {
                PdfModel::create([
                    "privacy" => "",
                    "tc" => "",
                    "faq" => "",
                    "about" => "",
                    "contact" => ""
                ]);

                $pdfs = PdfModel::get();
                if (count($pdfs) == 1) {
                    $user = $pdfs[0]->update([
                        $request->type => $request->url,
                    ]);
                    return response()->json(
                        [
                            "status" => "200",
                            "message" => "pdf updated successfully",
                            "data" => null
                        ],
                        200
                    );
                }
            }
        }
    }
}
