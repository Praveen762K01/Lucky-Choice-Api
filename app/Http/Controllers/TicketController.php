<?php

namespace App\Http\Controllers;

use App\Models\ClaimModel;
use App\Models\PaymentsModel;
use App\Models\PurchaseModel;
use App\Models\TicketModel;
use App\Models\UserModel;
use App\Models\WinnerSelectionModel;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    function create_ticket(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "ticket_name" => "required|string",
            "ticket_price" => "required|string",
            "lot_number" => "required|string",
            "prize_amount" => "required|string",
            "winner_count" => "required|string",
            "max_purchase_limit" => "required|string",
            "color" => "required|string",
            "purchase_count" => "required|string",
            "algo_winner" => "required|string",
            "manual_winner" => "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            TicketModel::create(
                [
                    "ticket_name" => $request->ticket_name,
                    "ticket_price" => $request->ticket_price,
                    "lot_number" => $request->lot_number,
                    "prize_amount" => $request->prize_amount,
                    "winner_count" => $request->winner_count,
                    "max_purchase_limit" => $request->max_purchase_limit,
                    "color" => $request->color,
                    "purchase_count" => $request->purchase_count,
                    "algo_winner" => $request->algo_winner,
                    "manual_winner" => $request->manual_winner,
                    "is_visible" => true,
                    "disable" => false
                ]
            );
            return response()->json([
                "status" => "200",
                "message" => "Ticket created successfully!!",
                "data" => null
            ], 200);
        }
    }

    function update_ticket(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "ticket_name" => "required|string",
            "ticket_price" => "required|string",
            "lot_number" => "required|string",
            "prize_amount" => "required|string",
            "winner_count" => "required|string",
            "max_purchase_limit" => "required|string",
            "color" => "required|string",
            "purchase_count" => "required|string",
            "algo_winner" => "required|string",
            "manual_winner" => "required|string",
            "ticket_id" => "required|string"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $ticket = TicketModel::find($request->ticket_id);
            if ($ticket) {
                $ticket->update(
                    [
                        "ticket_name" => $request->ticket_name,
                        "ticket_price" => $request->ticket_price,
                        "lot_number" => $request->lot_number,
                        "prize_amount" => $request->prize_amount,
                        "winner_count" => $request->winner_count,
                        "max_purchase_limit" => $request->max_purchase_limit,
                        "color" => $request->color,
                        "purchase_count" => $request->purchase_count,
                        "algo_winner" => $request->algo_winner,
                        "manual_winner" => $request->manual_winner,
                    ]
                );
                return response()->json([
                    "status" => "200",
                    "message" => "Ticket updated",
                    "data" => null
                ], 200);
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid Ticket ID",
                    "data" => null
                ], 500);
            }
        }
    }

    function get_cart(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "ticket_id" => "required|string",
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
                $ticket = TicketModel::find($request->ticket_id);
                if ($ticket) {
                    $purchase = PurchaseModel::where("user_id", "=", $request->user_id)
                        ->where("ticket_id", "=", $request->ticket_id)
                        ->where("is_paid", "=", false)
                        ->get();
                    return response()->json([
                        "status" => "200",
                        "message" => "Cart fetched",
                        "data" => $purchase
                    ], 200);
                } else {
                    return response()->json([
                        "status" => "500",
                        "message" => "Invalid Ticket ID",
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

    function get_my_tickets(Request $request)
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

                $purchase = PurchaseModel::where("user_id", "=", $request->user_id)
                    ->where("is_paid", "=", true)
                    ->get();
                return response()->json([
                    "status" => "200",
                    "message" => "Tickets fetched",
                    "data" => $purchase
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


    function check_serial_no(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "ticket_id" => "required|string",
            "user_id" => "required|string",
            "serial_no" => "required|string"

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
                $ticket = TicketModel::find($request->ticket_id);
                if ($ticket) {
                    $purchase = PurchaseModel::where("serial_no", "=", $request->serial_no)
                        ->where("ticket_id", "=", $request->ticket_id)
                        ->get();
                    if (count($purchase) == 0) {
                        return response()->json([
                            "status" => "200",
                            "message" => "Serial number available",
                            "data" => null
                        ], 200);
                    } else {
                        return response()->json([
                            "status" => "500",
                            "message" => "Serial number already selected",
                            "data" => null
                        ], 500);
                    }
                } else {
                    return response()->json([
                        "status" => "500",
                        "message" => "Invalid Ticket ID",
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

    function add_ticket_to_cart(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "ticket_id" => "required|string",
            "user_id" => "required|string",
            "serial_no" => "required|string"

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
                $ticket = TicketModel::find($request->ticket_id);
                if ($ticket) {
                    $purchase = PurchaseModel::where("user_id", "=", $request->user_id)
                        ->where("ticket_id", "=", $request->ticket_id)
                        ->where("is_paid", "=", false)
                        ->get();
                    $purchase_check = PurchaseModel::where("serial_no", "=", $request->serial_no)
                        ->where("ticket_id", "=", $request->ticket_id)
                        ->get();
                    if (count($purchase_check) == 0) {
                        if (count($purchase) < 10) {

                            PurchaseModel::create([
                                "user_id" => $request->user_id,
                                "lot_number" => $ticket->lot_number,
                                "ticket_id" => $request->ticket_id,
                                "serial_no" => $request->serial_no,
                                "is_paid" => false,
                                "ticket_price" => $ticket->ticket_price,
                                "prize" => $ticket->prize_amount,
                                "name" => $ticket->ticket_name,
                                "user_name" => $user[0]->user_name,
                                "number" => $user[0]->mobile
                            ]);

                            return response()->json([
                                "status" => "200",
                                "message" => "Added to cart",
                                "data" => null
                            ], 200);
                        } else {
                            return response()->json([
                                "status" => "500",
                                "message" => "Cart Limit Reached",
                                "data" => null
                            ], 500);
                        }
                    } else {
                        return response()->json([
                            "status" => "500",
                            "message" => "Serial number is already taken",
                            "data" => null
                        ], 500);
                    }
                } else {
                    return response()->json([
                        "status" => "500",
                        "message" => "Invalid Ticket ID",
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

    function remove_ticket_From_cart(Request $request)
    {
        $validator = validator()->make($request->all(), [

            "user_id" => "required|string",
            "cart_id" => "required|string"

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
                $cart = PurchaseModel::find($request->cart_id);
                if ($cart) {
                    $cart->delete();
                    return response()->json([
                        "status" => "200",
                        "message" => "Ticket removed from cart",
                        "data" => null
                    ], 200);
                } else {
                    return response()->json([
                        "status" => "500",
                        "message" => "Invalid Cart ID",
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

    function purchase_ticket(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "ticket_id" => "required|string",
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
                $ticket = TicketModel::find($request->ticket_id);

                if ($ticket) {

                    $purchase = PurchaseModel::where("user_id", "=", $request->user_id)
                        ->where("ticket_id", "=", $request->ticket_id)
                        ->where("is_paid", "=", false)
                        ->get();
                    $count = (int) $ticket->purchase_count;
                    $total = (int) $ticket->max_purchase_limit;
                    $is_visible = (count($purchase) + $count) < $total;
                    $ticket_amount = (float) $ticket->ticket_price;
                    if ((count($purchase) + $count) <= $total) {
                        $ticket->update(
                            [
                                "purchase_count" => (string) ($count + count($purchase)),
                                "is_visible" => (bool) $is_visible
                            ]
                        );
                        $wallet = (int) $user[0]->wallet;
                        $user[0]->update([
                            "wallet" => (string) ($wallet - (count($purchase) * $ticket_amount))
                        ]);
                        for ($i = 0; $i < count($purchase); $i++) {
                            $purchase[$i]->update([
                                "is_paid" => true
                            ]);
                            if (!$user[0]->ref_paid) {
                                $ref_usr = UserModel::where("id", "=", $user[0]->refered_by)->get();
                                if (count($ref_usr) == 1) {
                                    $amt = (int) (count($purchase) * $ticket_amount);
                                    $amtPaid = (int) $amt * 0.1;
                                    $ref_wallet = (int) $ref_usr[0]->wallet;

                                    $user[0]->update([
                                        "ref_paid" => true
                                    ]);
                                    $ref_usr[0]->update([
                                        "wallet" => (string) ($ref_wallet + $amtPaid)
                                    ]);
                                }
                            }
                            PaymentsModel::create([
                                "user_id" => $request->user_id,
                                "amount" => (string) $ticket_amount,
                                "transaction_id" => "Ticket Purchased",
                                "message" => "Ticket Purchased"
                            ]);
                        }
                        return response()->json([
                            "status" => "200",
                            "message" => "Ticket purchased",
                            "data" => null
                        ], 200);
                    } else {
                        return response()->json([
                            "status" => "500",
                            "message" => "Ticket limit reached reduce cart count",
                            "data" => null
                        ], 500);
                    }
                } else {
                    return response()->json([
                        "status" => "500",
                        "message" => "Invalid Ticket ID",
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

    function get_tickets(Request $request)
    {
        $tickets = TicketModel::where("is_visible", "=", true)->get();
        return response()->json([
            "status" => "200",
            "message" => "Ticket fetched",
            "data" => $tickets
        ], 200);
    }

    function choose_algo_winner(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "ticket_id" => "required|string"

        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $ticket = TicketModel::find($request->ticket_id);

            if ($ticket) {
                $max_range = (int) $ticket->max_purchase_limit;
                $max_limit = (int) $ticket->algo_winner;

                $start = 0;
                $end = $max_range - 1;

                // Specify the number of integers you want to generate
                $numberOfIntegers = $max_limit;

                // Generate unique random integers
                $uniqueIntegers = [];

                while (count($uniqueIntegers) < $numberOfIntegers) {
                    $randomNumber = rand($start, $end);

                    // Check if the number is not already in the array
                    if (!in_array($randomNumber, $uniqueIntegers)) {
                        $uniqueIntegers[] = $randomNumber;
                    }
                }


                $purchase = PurchaseModel::where("ticket_id", "=", $request->ticket_id)
                    ->where("is_paid", "=", true)
                    ->get();
                WinnerSelectionModel::where("ticket_id", "=", $request->ticket_id)->delete();
                for ($i = 0; $i < count($uniqueIntegers); $i++) {
                    WinnerSelectionModel::create([
                        "user_id" => $purchase[(int) ($uniqueIntegers[$i])]->user_id,
                        "ticket_id" => $purchase[(int) ($uniqueIntegers[$i])]->ticket_id,
                        "purchase_id" => $purchase[(int) ($uniqueIntegers[$i])]->id,
                        "serial_no" => $purchase[(int) ($uniqueIntegers[$i])]->serial_no,
                        "winner" => false,
                        "name" => $purchase[(int) ($uniqueIntegers[$i])]->user_name,
                        "number" => $purchase[(int) ($uniqueIntegers[$i])]->number,
                        "price" => $purchase[(int) ($uniqueIntegers[$i])]->ticket_price,
                        "prize" => $purchase[(int) ($uniqueIntegers[$i])]->prize
                    ]);
                }
                return response()->json([
                    "status" => "200",
                    "message" => "algo winner selected",
                    "data" => null
                ], 200);
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid Ticket ID",
                    "data" => null
                ], 500);
            }
        }
    }

    function get_purchased_tickets(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "ticket_id" => "required|string"
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $ticket = TicketModel::find($request->ticket_id);
            if ($ticket) {

                $purchase = PurchaseModel::where("ticket_id", "=", $request->ticket_id)
                    ->where("is_paid", "=", true)
                    ->get();
                return response()->json([
                    "status" => "200",
                    "message" => "Tickets fetched",
                    "data" => $purchase
                ], 200);
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid ticket id",
                    "data" => null
                ], 500);
            }
        }
    }
    function get_all_purchased_tickets(Request $request)
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


            $purchase = PurchaseModel::where("user_id", "=", $request->user_id)
                ->where("is_paid", "=", true)
                ->get();
            return response()->json([
                "status" => "200",
                "message" => "Tickets fetched",
                "data" => $purchase
            ], 200);
        }
    }

    function choose_manual_winner(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "ticket_id" => "required|string",
            "serial_no" => "required|string"

        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide Serial No",
                "data" => null
            ], 500);
        } else {
            $ticket = TicketModel::find($request->ticket_id);

            if ($ticket) {
                $purchase = PurchaseModel::where("serial_no", "=", $request->serial_no)
                    ->where("ticket_id", "=", $request->ticket_id)
                    ->get();
                if (count($purchase) == 1) {
                    $winner = WinnerSelectionModel::where("serial_no", "=", $request->serial_no)->get();
                    if (count($winner) == 0) {
                        WinnerSelectionModel::create([
                            "user_id" => $purchase[0]->user_id,
                            "ticket_id" => $purchase[0]->ticket_id,
                            "purchase_id" => $purchase[0]->id,
                            "serial_no" => $purchase[0]->serial_no,
                            "winner" => false,
                            "name" => $purchase[0]->user_name,
                            "number" => $purchase[0]->number,
                            "price" => $purchase[0]->ticket_price,
                            "prize" => $purchase[0]->prize
                        ]);

                        return response()->json([
                            "status" => "200",
                            "message" => "winner selected",
                            "data" => null
                        ], 200);
                    } else {
                        return response()->json([
                            "status" => "200",
                            "message" => "winner already selected",
                            "data" => null
                        ], 200);
                    }
                } else {
                    return response()->json([
                        "status" => "500",
                        "message" => "Invalid Purchase ID",
                        "data" => null
                    ], 500);
                }
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid Ticket ID",
                    "data" => null
                ], 500);
            }
        }
    }


    function delete_winner(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "ticket_id" => "required|string",
            "purchase_id" => "required|string"

        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $ticket = TicketModel::find($request->ticket_id);

            if ($ticket) {


                $purchase = PurchaseModel::find($request->purchase_id);
                if ($purchase) {
                    $winner = WinnerSelectionModel::where("purchase_id", "=", $request->purchase_id)->where("ticket_id", "=", $request->ticket_id)->get();
                    if (count($winner) == 0) {

                        return response()->json([
                            "status" => "500",
                            "message" => "Invalid Winner Id",
                            "data" => null
                        ], 500);
                    } else {
                        $winner[0]->delete();
                        return response()->json([
                            "status" => "200",
                            "message" => "winner deleted",
                            "data" => null
                        ], 200);
                    }
                } else {
                    return response()->json([
                        "status" => "500",
                        "message" => "Invalid Purchase ID",
                        "data" => null
                    ], 500);
                }
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid Ticket ID",
                    "data" => null
                ], 500);
            }
        }
    }

    function get_selected_winner(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "ticket_id" => "required|string",

        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $ticket = TicketModel::find($request->ticket_id);

            if ($ticket) {


                $winner = WinnerSelectionModel::where("ticket_id", "=", $request->ticket_id)->get();


                return response()->json([
                    "status" => "200",
                    "message" => "selected winners",
                    "data" => $winner
                ], 200);
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid Ticket ID",
                    "data" => null
                ], 500);
            }
        }
    }

    function distribute_prize(Request $request)
    {
        $validator = validator()->make($request->all(), [
            "ticket_id" => "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "status" => "500",
                "message" => "Please provide all fields",
                "data" => null
            ], 500);
        } else {
            $ticket = TicketModel::find($request->ticket_id);

            if ($ticket) {
                $winner = WinnerSelectionModel::where("ticket_id", "=", $request->ticket_id)->where("winner", "=", false)->get();
                if (((int)  $ticket->winner_count)  == count($winner)) {

                    for ($i = 0; $i < count($winner); $i++) {
                        ClaimModel::create([
                            "user_id" => $winner[$i]->user_id,
                            "ticket_id" => $request->ticket_id,
                            "serial_no" => $winner[$i]->serial_no,
                            "amount" => $ticket->prize_amount,
                            "paid_amount" => $ticket->ticket_price,
                            "name" => $ticket->ticket_name,
                            "is_paid" => false
                        ]);
                        $winner[$i]->update(["winner" => true]);
                        // $user = UserModel::where("user_id", "=", $winner[$i]->user_id)->get();
                        // $old_wallet = (int) $user[0]->wallet;
                        // $prize_amount = (int) $ticket->prize_amount;


                        // $user[0]->update(["wallet" => (string) ($old_wallet + $prize_amount)]);
                        $ticket->update(["disable" => true]);
                    }
                    return response()->json([
                        "status" => "200",
                        "message" => "Prize distributed",
                        "data" => null
                    ], 200);
                } else {
                    return response()->json([
                        "status" => "500",
                        "message" => "Please check winner count",
                        "data" => null
                    ], 500);
                }
            } else {
                return response()->json([
                    "status" => "500",
                    "message" => "Invalid Ticket ID",
                    "data" => null
                ], 500);
            }
        }
    }

    function get_completed_tickets(Request $request)
    {
        $tickets = TicketModel::where("is_visible", "=", false)->where("disable", "=", false)->get();
        return response()->json([
            "status" => "200",
            "message" => "Ticket fetched",
            "data" => $tickets
        ], 200);
    }

    function get_expired_tickets(Request $request)
    {
        $tickets = TicketModel::where("is_visible", "=", false)->where("disable", "=", true)->get();
        return response()->json([
            "status" => "200",
            "message" => "Ticket fetched",
            "data" => $tickets
        ], 200);
    }
}
