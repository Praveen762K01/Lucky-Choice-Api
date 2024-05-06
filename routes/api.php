<?php

use App\Http\Controllers\BankDetailsController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\ClaimController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UpiDetailsController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// User
Route::post('create_user', [UserController::class, "create_user"]);
Route::post('get_user', [UserController::class, "get_user"]);
Route::post('update_user', [UserController::class, "update_user"]);
Route::post('get_all_user', [UserController::class, "get_all_user"]);
// Ticket
Route::post('create_ticket', [TicketController::class, "create_ticket"]);
Route::post('update_ticket', [TicketController::class, "update_ticket"]);
Route::post('get_ticket', [TicketController::class, "get_tickets"]);
Route::post('get_cart', [TicketController::class, "get_cart"]);
Route::post('check_serial_no', [TicketController::class, "check_serial_no"]);
Route::post('add_ticket_to_cart', [TicketController::class, "add_ticket_to_cart"]);
Route::post('remove_ticket_From_cart', [TicketController::class, "remove_ticket_From_cart"]);
Route::post('get_my_tickets', [TicketController::class, "get_my_tickets"]);
Route::post('purchase_ticket', [TicketController::class, "purchase_ticket"]);
Route::post('choose_algo_winner', [TicketController::class, "choose_algo_winner"]);
Route::post('get_purchased_tickets', [TicketController::class, "get_purchased_tickets"]);
Route::post('get_all_purchased_tickets', [TicketController::class, "get_all_purchased_tickets"]);
Route::post('choose_manual_winner', [TicketController::class, "choose_manual_winner"]);
Route::post('delete_winner', [TicketController::class, "delete_winner"]);
Route::post('get_selected_winner', [TicketController::class, "get_selected_winner"]);
Route::post('distribute_prize', [TicketController::class, "distribute_prize"]);
Route::post('get_completed_tickets', [TicketController::class, "get_completed_tickets"]);
Route::post('get_expired_tickets', [TicketController::class, "get_expired_tickets"]);
// Claim Price
Route::post('get_my_earnings', [ClaimController::class, "get_my_earnings"]);
Route::post('claim_my_earning', [ClaimController::class, "claim_my_earning"]);
// UPI
Route::post('get_upi_details', [UpiDetailsController::class, "get_upi_details"]);
Route::post('update_upi_details', [UpiDetailsController::class, "update_upi_details"]);
// Bank
Route::post('get_bank_details', [BankDetailsController::class, "get_bank_details"]);
Route::post('update_bank_details', [BankDetailsController::class, "update_bank_details"]);
// Payment
Route::post('add_payment', [PaymentsController::class, "add_payment"]);
Route::post('get_payment', [PaymentsController::class, "get_payment"]);
// Request
Route::post('add_request', [RequestsController::class, "add_request"]);
Route::post('get_my_request', [RequestsController::class, "get_my_request"]);
Route::post('get_pending_request', [RequestsController::class, "get_pending_request"]);
Route::post('get_completed_request', [RequestsController::class, "get_completed_request"]);
Route::post('update_request', [RequestsController::class, "update_request"]);
Route::post('get_request_details', [RequestsController::class, "get_request_details"]);
// URL
Route::post('get_pdf', [UserController::class, "get_pdf"]);
// Banner
Route::post('create_banner', [BannerController::class, "create_banner"]);
Route::post('get_banner', [BannerController::class, "get_banner"]);
Route::post('delete_banner', [BannerController::class, "delete_banner"]);
