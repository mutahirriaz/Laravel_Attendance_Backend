<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\projects;

class projectsController extends Controller
{
    //

    public function addProject(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'heading' => 'required|string',
            'peragraph' => 'required|string',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
           
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'FAILURE',
                'message' => $request->path(),
                'requestKey' => $validator->messages()->first()
            ],422);
        }
        $uploadFiles = $request->image->store('public/uploads');
        $uploadLogo = $request->logo->store('public/uploads');
        $project =  projects::create([
            "heading" => $input['heading'],
            "peragraph" => $input['peragraph'],
            "image" => "storage/app/public/uploads/".$request->image->hashName(),
            "logo" => "storage/app/public/uploads/".$request->logo->hashName(),
        ]);
    
        return response()->json([
            'status' => 'SUCCESS', 'message' =>  'Project Add Sucessfully.',
        ]);
    }

    public function updateProject(Request $request)
    {
        $input = $request->all();
        $project = projects::find($input['projectId']);
        if($project === null){
            return response()->json([
                'status'=>'FAILURE',
                'message'=>'Project not found'
            ]);
        }
        else{
            $project->update($request->all());

            if($request->image !== null){
                $uploadFiles = $request->image->store('public/uploads');
                $blog->update(["image" => "storage/app/public/uploads/".$request->image->hashName()]);
            }
            if($request->logo !== null){
                $uploadLogo = $request->logo->store('public/uploads');
                $blog->update(["logo" => "storage/app/public/uploads/".$request->logo->hashName()]);
            }
            return response()->json([
                'status'=>'SUCCESS',
                'message'=>'Project updated Successfully'
            ]);
        }
    }

    public function deleteProject(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'projectId' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'status'=>422,
                "message"=>$validator->messages()
            ]);
        }

        projects::where('id', $input['projectId'])->delete();

        return response()->json([
            'status'=>200,
            "message"=>'Project deleted Successfully'
        ]);
    }


    public function getProjects(Request $request)
    {
        $project = projects::where('isActive', 1)->Where('isDelete', 0)
        ->get();
        return response()->json([
            'status'=>200,
            'response'=>$project
    ]);
    }
}
