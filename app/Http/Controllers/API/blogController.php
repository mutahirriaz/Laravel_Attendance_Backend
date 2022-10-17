<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\blog;
use App\Models\blogchild;

class blogController extends Controller
{
    //

    public function addBlog(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'mainImage' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'mainHeading' => 'string',
            'category' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'FAILURE',
                'message' => $request->path(),
                'requestKey' => $validator->messages()->first()
            ],422);
        }
        
            $uploadFiles = $request->mainImage->store('public/uploads');
            $blog =  blog::create([
                "mainImage" => "storage/app/public/uploads/".$request->mainImage->hashName(),
                "mainHeading" => $input['mainHeading'],
                'category' => $input['category'],
            ]);
    
            return response()->json([
                'status' => 'SUCCESS', 'message' =>  'Blog Add Sucessfully.',
            ]);
    }

    public function updateBlog(Request $request)
    {
        $input = $request->all();
        $blog = blog::find($input['blogId']);
        if($blog === null){
            return response()->json([
                'status'=>'FAILURE',
                'message'=>'Blog not found'
            ]);
        }
        else{
            $blog->update($request->all());
            if($request->mainImage !== null){
                $uploadFiles = $request->mainImage->store('public/uploads');
                $blog->update(['mainImage' => "storage/app/public/uploads/".$request->mainImage->hashName()]);
            }

            // $blog->update(['mainImage' => "storage/app/public/uploads/".$request->mainImage->hashName(), "mainHeading" => $input['mainHeading'], 'category' => $input['category'],]);
            // blog::where('id', $input['blogId'])->update(['mainHeading' => $input['mainHeading']]);
            return response()->json([
                'status'=>'SUCCESS',
                'message'=>'Blog updated Successfully'
            ]);
        }
    }

    public function deleteBlog(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'blogId' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                "message"=>$validator->messages()
            ]);
        }

        blog::where('id', $input['blogId'])->delete();
        blogchild::where('blogId', $input['blogId'])->delete();

        return response()->json([
            'status'=>200,
            "message"=>'Review deleted Successfully'
        ]);
    }



    public function getBlogByCategory(Request $request)
    {
    //    $blogByCategory =  blog::where('category', 'LIKE', "%{$request->category}%")
    //     ->get();
    if($request->category === "All"){
        $blogs =  blog::where('isActive', 1)->get();
        return response()->json([
            'status'=>200,
            'response'=>$blogs
        ]);
    }

    else{
        $categorizedBlog = blog::where('isActive', 1)->Where('category', $request->category)
        ->get();
        return response()->json([
            'status'=>200,
            'response'=>$categorizedBlog
    ]);
    }  
    }

    public function updateBlogStatus(Request $request)
    {
        $input = $request->all();
        $blog = blog::find($input['blogId']);
        if($blog === null){
            return response()->json([
                'status'=>'FAILURE',
                'message'=>'Blog not found'
            ]);
        }
        else{
            $blog->update($request->all());
            return response()->json([
                'status'=>'SUCCESS',
                'message'=>'Blog Status updated Successfully'
            ]);
        }
    }


    public function addChildBlog(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'blogId' => 'required|integer',
            'heading' => 'string',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'peragraph' => 'string',

        ]);

        $uploadFiles = $request->image->store('public/uploads');

        $childBlog =  blogchild::create([
            "blogId" => $input['blogId'],
            "heading" => $input['heading'],
            "image" => "storage/app/public/uploads/".$request->image->hashName(),
            "peragraph" => $input['peragraph'],

        ]);

        return response()->json([
            'status' => 'SUCCESS', 'message' =>  'ChildBlog Add Sucessfully.',
        ]);
    }

    public function getChildBlog(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'blogId' => 'required',
        ]);

        // $blog = blog::where('id', $input['blogId']->get());
        $childBlog = blogchild::where('blogId', $input['blogId'])->get();

        if($childBlog->isEmpty() ){
            return response()->json([
                'status' => 'FAILURE', 'message' =>  'Blog Id is not correct',
            ]);
        }

        else{
            return response()->json([
                'status'=>200,
                'response'=>$childBlog
            ]);
        }
    }
}
