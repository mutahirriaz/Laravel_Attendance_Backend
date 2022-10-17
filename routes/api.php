<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AttendanceController;
use App\Http\Controllers\API\ChangeRequest;

use App\Http\Controllers\API\testimonialController;
use App\Http\Controllers\API\blogController;
use App\Http\Controllers\API\contactUsController;
use App\Http\Controllers\API\projectsController;

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

// Linkit_Soft User Admin Portal API'S
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

// Linkit_Soft Website Admin Portal API'S
Route::post('user/addreview', [testimonialController::class, 'createReview']);
Route::post('user/updatereview', [testimonialController::class, 'updateReview']);
Route::post('user/deletereview', [testimonialController::class, 'deleteReview']);
Route::post('user/getallreviews', [testimonialController::class, 'getAllReviews']);
Route::post('user/addblog', [blogController::class, 'addBlog']);
Route::post('user/getblogbycategory', [blogController::class, 'getBlogByCategory']);
Route::post('user/getblogbycategoryforadmin', [blogController::class, 'getBlogByCategoryForAdmin']);
Route::post('user/updateblog', [blogController::class, 'updateBlog']);
Route::post('user/updateblogstatus', [blogController::class, 'updateBlogStatus']);
Route::post('user/deleteblog', [blogController::class, 'deleteBlog']);
Route::post('user/addchildblog', [blogController::class, 'addChildBlog']);
Route::post('user/getchildblog', [blogController::class, 'getChildBlog']);
Route::post('user/addcontact', [contactUsController::class, 'addContact']);
Route::post('user/getcontact', [contactUsController::class, 'getContacts']);
Route::post('user/addproject', [projectsController::class, 'addProject']);
Route::post('user/updateproject', [projectsController::class, 'updateProject']);
Route::post('user/deleteproject', [projectsController::class, 'deleteProject']);
Route::post('user/getprojects', [projectsController::class, 'getProjects']);
Route::post('user/getprojectsforadmin', [projectsController::class, 'getProjectsForAdmin']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
