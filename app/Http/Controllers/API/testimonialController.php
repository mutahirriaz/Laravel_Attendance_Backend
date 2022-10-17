<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\testimonials;

class testimonialController extends Controller
{
    //
    public function createReview(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'review' => 'required|string',
            'username' => 'required|string',
           
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'FAILURE',
                'message' => $request->path(),
                'requestKey' => $validator->messages()->first()
            ],422);
        }
        $review =  testimonials::create([
            "review" => $input['review'],
            "username" => $input['username'],
        ]);
    
        return response()->json([
            'status' => 'SUCCESS', 'message' =>  'User registered Sucessfully.',
        ]);
    }

    public function updateReview(Request $request)
    {
        $input = $request->all();
        $review = testimonials::find($input['reviewId']);
        if($review === null){
            return response()->json([
                'status'=>'FAILURE',
                'message'=>'Review not found'
            ]);
        }
        else{
            $review->update($request->all());
            return response()->json([
                'status'=>'SUCCESS',
                'message'=>'Review status updated Successfully'
            ]);
        }
    }


    // function is used to delete Review from testimonials database
    public function deleteReview(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'reviewId' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                "message"=>$validator->messages()
            ]);
        }

        testimonials::where('id', $input['reviewId'])->delete();
        return response()->json([
            'status'=>200,
            "message"=>'Review deleted Successfully'
        ]);
    }

    // function is used to get all Reviewas
    public function getAllReviews()
    {
        $review = testimonials::all();
        return response()->json([
            'status'=>200,
            'response'=>$review
        ]);
    }
}
