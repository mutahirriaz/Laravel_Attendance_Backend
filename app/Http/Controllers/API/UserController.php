<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Stevebauman\Location\Facades\Location;



class UserController extends Controller
{
    // function used for register user
    public function Register(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'deviceId' => 'required',
            'phone' => 'required',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'FAILURE',
                'message' => $request->path(),
                'requestKey' => $validator->messages()->first()
            ],422);
        }
        
       $user = User::where('email', $input['email'])->get();
        if($user->isEmpty()){
            $uploadFiles = $request->image->store('public/uploads');
            $user =  User::create([
                "name" => $input['name'],
                "email" => $input['email'],
                "image" => "storage/app/public/uploads/".$request->image->hashName(),
                "password" => Hash::make($input['password']),
                "deviceId" => $input['deviceId'],
                "phone" => $input['phone'],
            ]);
    
            return response()->json([
                'status' => 'SUCCESS', 'message' =>  'User registered Sucessfully.',
            ]);
        }
        else{
            return response()->json([
                'status' => 'Faild', 'message' =>  'User already exists.',
            ]);
        }

        
    }

    // function used for signin user
    public function signIn(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'email' => 'required|email',
            'password' => 'required',
            'deviceId' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'FAILURE',
                'message' => $request->path(),
                'requestKey' => $validator->messages()->first()
            ],422);
        }

        if(!Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['status' => 'FAILURE', 'message' => 'Invalid User Credentials', 'requestKey' => $validator->messages()->first()]);
        }
        $user = Auth::user();
        if($user->status != 1){
            return response()->json([
                'status'=>'FAILURE',
                "message"=>'Account Not Approved',
            ]);
        }
        else if($user->deviceId !== $input['deviceId']){
            return response()->json([
                'status'=>"FAILURE",
                "response"=>"Your deviceId is change please request to the admin",
                "message"=>$user->id,
            ]);
        }
        else{
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'status'=>200,
                "response"=>$user,
                "token"=>$token
            ]);
        }
       
    }


    // function is used to get all users
    public function getAllUsers()
    {
        $users = User::all();
        return response()->json([
            'status'=>200,
            'response'=>$users
        ]);
    }

    // function is used to get single user by id
    public function getSingeUser(Request $request)
    {
        $input = $request->all();
        $user = User::find($input['userId']);
        if($user !== null){
            return response()->json([
                'status'=>'SUCCESS',
                'response'=>$user
            ]);
        }
        else{
            return response()->json([
                'status'=>'FAILURE',
                'response'=>'no user found'
            ]);
        }
       
        
    }

    // function is used to update user profile
    public function updateUser(Request $request)
    {
        $input = $request->all();
        $user = User::find($input['userId']);
        if($user === null){
            return response()->json([
                'status'=>'FAILURE',
                'message'=>'user not found'
            ]);
        }
        else{
            $user->update($request->all());
            return response()->json([
                'status'=>'SUCCESS',
                'message'=>'User status updated Successfully'
            ]);
        }
        
      
    }


    // function is used to update user status
    public function updateUserStatus(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'status' => 'required',
            'userId' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                "message"=>$validator->messages()
            ]);
         }
        // $user=User::find($input['userId'])->update('status', $input['status']);
        User::where('id', $input['userId'])->update(['status' => $input['status']]);
        return response()->json([
            'status'=>'SUCCESS',
            'message'=>'User status updated Successfully'
        ]);
      
    }


    // function is used to delete user from user database
    public function deleteUser(Request $request)
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

        User::where('id', $input['userId'])->delete();
        return response()->json([
            'status'=>200,
            "message"=>'User deleted Successfully'
        ]);
    }


    // function is used to get Employer Request Users and Registered Employers Users by status
    public function employerRequest(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'status' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                "message"=>$validator->messages()
            ]);
        }

        $users =  User::where('status', $input['status'])->get();

        return response()->json([
            'status' => 200,
            'response'=>$users
        ]);
    }

}
