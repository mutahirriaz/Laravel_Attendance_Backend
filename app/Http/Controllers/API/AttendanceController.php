<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Attendance;
use Carbon\Carbon;
use App\Models\User;
use Stevebauman\Location\Facades\Location;




class AttendanceController extends Controller
{
    //

    // this function is used to checkIn and checkOut with one function
    public function checkIn(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'latitude' => 'required',
            'longitude' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json([
                'status' => 'FAILURE',
                'message' => $request->path(),
                'requestKey' => $validator->messages()->first(),
                
            ],422);
        }
        $date = Carbon::now();
        $getuser =  Attendance::where('userId', auth()->id())->get();
        $userLat = 24.92163186206468;
        $userLong = 67.09241190737441;
        $earthRadius = 6371000;
        $latFrom = deg2rad($input['latitude']);
        $lonFrom = deg2rad($input['longitude']);
        $latTo = deg2rad($userLat);
        $lonTo = deg2rad($userLong);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

        $distance = $angle * $earthRadius;

        if($distance <= 25){
            if($getuser->isEmpty() ){
                $user =  Attendance::create([
                    "checkIn" => $date,
                    "userId" => auth()->id(),
                ]);
                return response()->json([
                    'status' => "Checkin Successfully",
                    "loca"=>$userLat
                ]);
            }
            else if($getuser){
                $last = $getuser->last();
                $checkInDate = $last->checkIn;
                $userCheckInDate = date('d:m:y', strtotime($checkInDate));
                $getCurrentDate = date('d:m:y', strtotime($date));
                if($last->checkOut === null && $userCheckInDate === $getCurrentDate ){

                    Attendance::where('id', $last->id)->update(['checkOut' => $date]);
                    return response()->json([
                        'status' => "Checkout Successfully",
                        // 'user' => auth()->user(),
                    ]);
                }
                else if ($userCheckInDate !== $getCurrentDate){
                    $user =  Attendance::create([
                        "checkIn" => $date,
                        "userId" => auth()->id(),
                    ]);
                     return response()->json([
                        'status' => "Checkin Successfully",
                    ]);
                }
                
                
            }
        }
        else{
            return response()->json([
                'status' => 'FAILURE',
                'message' => 'you are out of location',
                'location' => $distance,
                'userLat' => $userLat,
                'userLong' => $userLong
            ]);
        }
    }


    // function is used to get all users of Attendance
    public function getAttendanceUsers()
    {
        $users = Attendance::select('attendance.id', 'attendance.userId', 'attendance.checkOut', 'attendance.checkIn', 'users.name', 'users.email', 'users.phone', 'users.deviceId', 'users.deviceId')->join('users', 'users.id', '=', 'attendance.userId')->get();
        return response()->json([
            'status'=>200,
            'response'=>$users
        ]);
    } 

}
