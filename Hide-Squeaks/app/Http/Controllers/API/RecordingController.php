<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Recording;
use Validator;
use Str;
use Auth;
use App\Http\Controllers\API\BaseController as BaseController;
class RecordingController extends BaseController
{
    
    public function index()
    {
        // $user_id = auth()->user()->id;
        $user_id = Auth::user()->id;
        $data = Recording::where(
        'user_id',$user_id
        )->get();


        return $this->sendResponse($data,'My Recording');
    }

    public function store(Request $request)
    {
               // Validate the request data
    $validator = Validator::make($request->all(), [
        'file' => 'required',
        'audio_length' => 'required',
        'title' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()->first()], 400);
    }

    // Handle thumbnail upload
    $audio = $request->file('file');
    $audioFileName = Str::random(20) . '.' . $audio->getClientOriginalExtension();
    $audio->move(public_path('documents/recording/'), $audioFileName);

    $user_id = Auth::id();

    $upload = new Recording();
    $upload->title = $request->title;
    $upload->file_path = 'documents/recording/' . $audioFileName;
    $upload->audio_length = $request->audio_length;
    $upload->user_id = $user_id;
    $upload->save();

    // Create the video record in the database
    // vidoe::create([
    //     'title' => $request->input('title'),
    //     'description' => $request->input('description'),
    //     // 'video_type' => $request->input('video_type'),
    //     'thumbnail_path' => 'thumbnails/' . $thumbnailFileName,
    //     'file_path' => 'videos/' . $videoFileName,
    // ]);

    return response()->json(['message' => 'Audio uploaded successfully'], 200);
    }
    
    // public function index(Request $request)
    // {
    //     try {
    //         $user_id = auth()->user()->id;
    //         $data = Recording::where(
    //             'user_id',$user_id
    //         )->get();


    //         return $this->sendResponse($data,'My Recording');
    //     } catch (\Throwable $e) {
    //         return $this->sendError('Something went wrong');
    //     }
    // }
    // public function store(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //         'file' => 'required',
    //         'audio_length' => 'required',
    //         'title' => 'required',
    //     ]);

    //     if($validator->fails()){
    //         return $this->sendError($validator->errors()->first());

    //     }
    //     try {
    //         $user_id = auth()->user()->id;
    //         if($request->hasFile('file'))
    //         {
    //             $img = Str::random(20).$request->file('file')->getClientOriginalName();
    //             $input['file_path'] = 'documents/recording/'.$img;
    //             $request->file->move(public_path("documents/recording"), $img);
    //         }

    //         $input['audio_length'] = $request->audio_length;
    //         $input['title'] = $request->title;
    //         $input['user_id'] = $user_id ;
    //         Recording::create($input);
    //         return $this->sendResponse([],'Recording Added');
    //         // file_path
    //     } catch (\Throwable $e) {
    //         return $this->sendError('Something went wrong');

    //     }
    // }
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
        try {
            $data = Recording::find($request->id);
            if (!$data) {
                return $this->sendError('Data Not Found');
            }
            $data->delete(); 
            return $this->sendResponse('Deleted Successfully');
        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong');

        }
    }
}
