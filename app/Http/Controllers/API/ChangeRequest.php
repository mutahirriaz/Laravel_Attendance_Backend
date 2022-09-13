<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChangeRequestt;
use Illuminate\Support\Facades\Validator;
use App\Models\User;




class ChangeRequest extends Controller
{

    // this function is used create changeRequest user in changerequest table
    public function changeRequest(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'userId' => 'required|integer',
            'deviceId' => 'required|string',
        ]);

         if ($validator->fails()) {
            return response()->json([
                'status' => 'FAILURE',
                'message' => $request->path(),
                'requestKey' => $validator->messages()->first(),
                
            ],422);

        }

        $dbuser = ChangeRequestt::where('userId', $input['userId'])->get();

        if($dbuser->isEmpty()){
            $user =  ChangeRequestt::create([
                "userId" => $input['userId'],
                "deviceId" => $input['deviceId'],
            ]);
    
            return response()->json([
                'status' => 'SUCCESS', 'message' =>  'your request  sucessfully submitted.',
            ]);
        }
        else{
            return response()->json([
                'status' => 'FAILURE', 'message' =>  'your request  is in pending.',
            ]);
        }
        
    }

    // function is used to get all users of changeRequestUsers
    public function getChangeReqUser()
    {
        $users = ChangeRequestt::all();
        return response()->json([
            'status'=>200,
            'response'=>$users
        ]);
    }

    // function is used to update deviceId
    public function updateDeviceId(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'deviceId' => 'required',
            'userId' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                "message"=>$validator->messages()
            ]);
        }
        
        User::where('id', $input['userId'])->update(['deviceId' => $input['deviceId']]);

        ChangeRequestt::where('id', $input['userId'])->delete(); 

        return response()->json([
            'status'=>'SUCCESS',
            'message'=>'User deviceId successfully updated'
        ]);

    }


    public function deleteReqDeviceUser(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'userId' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                "message"=>$validator->messages()
            ]);
        }
        
        ChangeRequestt::where('id', $input['userId'])->delete(); 

        return response()->json([
            'status'=>'SUCCESS',
            'message'=>'User Deleted Successfully'
        ]);

    }

}
