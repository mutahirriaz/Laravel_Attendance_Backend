<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\contactform;


class contactUsController extends Controller
{
    //

    public function addContact(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'firstName' => 'required|string',
            'lastName' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'companyName' => 'required|string',
            'helpMsg' => 'required|string',
            // 'estimateBudget' => 'string',
            // 'technologies' => 'array',

           
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'FAILURE',
                'message' => $request->path(),
                'requestKey' => $validator->messages()->first()
            ],422);
        }
       
        $contact =  contactform::create([
            "firstName" => $input['firstName'],
            "lastName" => $input['lastName'],
            "email" => $input['email'],
            "phone" => $input['phone'],
            "companyName" => $input['companyName'],
            "helpMsg" => $input['helpMsg'],
            "estimateBudget" => $input['estimateBudget'],
            "technologies" => $input['technologies']
        ]);
    
        return response()->json([
            'status' => 'SUCCESS', 'message' =>  'Contact Submitted Sucessfully.',
        ]);
    }


    public function getContacts()
    {
        $contacts = contactform::all();
        return response()->json([
            'status'=>200,
            'response'=>$contacts
        ]);
    }
    

}
