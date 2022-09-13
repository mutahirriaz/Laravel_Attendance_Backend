<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\ChangeRequest;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('user/register', [UserController::class, 'Register']);
Route::post('user/signin', [UserController::class, 'signIn']);
Route::post('user/updateuser', [UserController::class, 'updateUser']);
Route::get('user/getusers', [UserController::class, 'getAllUsers']);
Route::post('user/getsingleuser', [UserController::class, 'getSingeUser']);
Route::post('user/updatestatus', [UserController::class, 'updateUserStatus']);
Route::post('user/deleteuser', [UserController::class, 'deleteUser']);
Route::post('user/employerrequest', [UserController::class, 'employerRequest']);
Route::middleware('auth:sanctum')->post('user/checkinrequest', [AttendanceController::class, 'checkIn']);
Route::post('user/changerequest', [ChangeRequest::class, 'changeRequest']);
Route::post('user/getchangerequser', [ChangeRequest::class, 'getChangeReqUser']);
Route::post('user/updatedeviceid', [ChangeRequest::class, 'updateDeviceId']);
Route::post('user/deldeviceiduser', [ChangeRequest::class, 'deleteReqDeviceUser']);
Route::post('user/getattendanceusers', [AttendanceController::class, 'getAttendanceUsers']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
