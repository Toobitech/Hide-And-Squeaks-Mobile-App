<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Audio;
use App\Models\Video;
use App\Models\Like;
use App\Models\Comment;
use App\Models\User;
use App\Models\View;
use App\Models\Ensurance;
use App\Models\UserSound;
use App\Models\UserPaidSoundCount;
use App\Models\Treat;
use App\Models\PaymentDetails;

use Validator;
use Str;

use App\Http\Controllers\API\BaseController as BaseController;

class HomeController extends BaseController
{
    //Audio Controller functions
    /* MY LIBRARY */
    public function addMyLibrary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'audio_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
        try {
            $user_id = auth()->user()->id;
            $audio = Audio::find($request->audio_id);
            if (!isset($audio)) {
                return $this->sendError('Audio Not Found');
            }


            if ($audio->type == 'paid') {
                $check = UserPaidSoundCount::where([
                    'user_id'=>$user_id,
                    'audio_id'=> $request->audio_id
                ])->count();
                $data['count'] = $check;
                if ($check >= 3) {
                    return $this->sendResponse($data,'First Buy Sound');
                }
                UserPaidSoundCount::create([
                    'user_id'=>$user_id,
                    'audio_id'=> $request->audio_id
                ]);
                return $this->sendResponse($data,'Listen Sound');
            }else{
                $check = UserSound::where([
                    'user_id'=>$user_id,
                    'audio_id'=> $request->audio_id
                ])->first();
                if (isset($check)) {
                    return $this->sendError('Already Exist');
                }
                UserSound::create([
                    'user_id'=>$user_id,
                    'audio_id'=> $request->audio_id
                ]);
            }
            return $this->sendResponse($response = [],'Add My Library');
        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong');
        }
    }

    public function addPaidSoundMyLibrary(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'audio_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
        try {
            $user = auth()->user();

            $user_id = $user->id;
            $audio = Audio::where('id',$request->audio_id)->where('type','paid')->first();
            if (!isset($audio)) {
                return $this->sendError('Audio Not Found');
            }
            $check = UserSound::where([
                'user_id'=>$user_id,
                'audio_id'=> $request->audio_id
            ])->first();
            if (isset($check)) {
                return $this->sendError('Already Exist');
            }
            if ($audio->price > $user->balance) {
                return $this->sendError('Insufficient Balance');
            }
            $user->withdraw($audio->price);
            UserSound::create([
                'user_id'=>$user_id,
                'audio_id'=> $request->audio_id
            ]);
            return $this->sendResponse($response = [],'Add My Library');

        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong');
        }
    }

    public function myLibrary()
    {
        try {
            $user_id = auth()->user()->id;
            $data = UserSound::with(['audio'])->where([
                'user_id'=>$user_id,
            ])->get();


            return $this->sendResponse($data,'My Library');
        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong');
        }
    }

    // public function playPaidSound(Request $request){
    //     $validator = Validator::make($request->all(), [
    //         'audio_id' => 'required',
    //     ]);

    //     if($validator->fails()){
    //         return $this->sendError($validator->errors()->first());

    //     }
    //     try {
    //         $user_id = auth()->user()->id;
    //         $check = UserPaidSoundCount::where([
    //             'user_id'=>$user_id,
    //             'audio_id'=> $request->audio_id
    //         ])->count();
    //         $data['count'] = $check;
    //         if ($check >= 3) {
    //             return $this->sendResponse($data,'First Buy Sound');
    //         }
    //         UserPaidSoundCount::create([
    //             'user_id'=>$user_id,
    //             'audio_id'=> $request->audio_id
    //         ]);
    //         return $this->sendResponse($data,'Listen A Sound');
    //     } catch (\Throwable $e) {
    //         return $this->sendError('Something went wrong');
    //     }
    // }
    public function delFromLibrary(Request $request){
        $validator = Validator::make($request->all(), [
            'audio_id' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
        try {
            $user_id = auth()->user()->id;
            $check = UserSound::where([
                'user_id'=>$user_id,
                'audio_id'=> $request->audio_id
            ])->first();
            if (!isset($check)) {
                return $this->sendError('Audio Not Found');
            }
            $check->delete();

            return $this->sendResponse($response = [],'Delete From My Library');
        } catch (\Throwable $e) {
            return $this->sendError('Something went wrong');
        }
    }

    public function getAudio()
    {
        try {

            $audio = Audio::all();
            $user_id = auth()->user()->id;
            /* Add Count Variable  */
            foreach ($audio as $key => $value) {

                if ($value->type == 'free') {
                    $value->count = 0;
                }else{
                    $audio_count = UserPaidSoundCount::where([
                        'user_id'=>$user_id,
                        'audio_id'=> $value->id
                    ])->count();
                    $value->count = $audio_count;
                }
            }
            return $this->sendResponse($audio);
        }
        catch (\Throwable $th) {

            return $this->sendError('Something went wrong');
        }
    }

     /* MY LIBRARY */

//Audio controller functions end


//Profile Controller functions

    public function profilePost(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'pet_name' => 'required|string',
                'pet_breed' => 'required|string',

                // 'age' => 'required',
            ]);

            if($validator->fails()){
                return $this->sendError($validator->errors()->first());

            }

            $user_id = auth()->user()->id;
            if($request->hasFile('profile'))
            {
                $img = Str::random(20).$request->file('profile')->getClientOriginalName();
                $input['profile'] = 'documents/profile/'.$img;
                $request->profile->move(public_path("documents/profile"), $img);
            }

            $input['pet_name'] = $request->pet_name;
            $input['pet_breed'] = $request->pet_breed;
            $input['pet_age'] = $request->pet_age;
            $pet =User::find($user_id);
            $update_pet = $pet->update($input);
            $response = [
                'name' => $pet->pet_name,
                'breed' => $pet->pet_breed,
                'age' =>$pet->pet_age,
                'profile'=>$pet->profile,
            ];

            return $this->sendResponse($response,'Profile Added');
        } catch (\Throwable $th)
            {
        return $this->sendError('Something went wrong');
            }
    }

    public function getProfile()
    {
        $user_id = auth()->user()->id;
        try {

            $profile = User::find($user_id);
            return $this->sendResponse($profile);
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }
    }
    public function getLegal()
    {
        try
        {
            //code...
            $para = Ensurance::all();
            return $this->sendResponse($para);
        }
        catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }
    }

//Profile controller functions end


//like Controller functions

    public function likePost(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'video_id' => 'required',
            ]);

            if($validator->fails()){
                return $this->sendError($validator->errors()->first());

            }

            $check_video = Video::find($request->video_id);
            if (!isset($check_video)) {
                return $this->sendError('Video Not Found');
            }
            $user_id = auth()->id();
            $check_like = Like::where('user_id',$user_id)->where('video_id',$request->video_id)->first();
            if (isset($check_like)) {
                $check_like->delete();
                return $this->sendResponse($response=[],'Dislike Video');
            }
            $like =Like::create([
                'user_id'=> $user_id,
                'video_id'=>$request->input('video_id'),
            ]);

            $response = [
                'video_id' => $like->video_id,
            ];


        return $this->sendResponse($response,'like Video');
            //code...
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }

    }

    public function totalNumberOfLikes()
    {
        try {

            $like = Like::all();
            return $this->sendResponse($like);
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }

    }

//like controller functions end


//Comment Controller functions

    public function commentPost(Request $request)
    {
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'video_id' => 'required',
                'comment' =>'required',
            ]);

            if($validator->fails()){
                return $this->sendError($validator->errors()->first());

            }
        // $user = auth()->user();

        $check_video = Video::find($request->video_id);
        if (!isset($check_video)) {
            return $this->sendError('Video Not Found');
        }
        $user_id = auth()->id();

            $comment =Comment::create([
                'comment' => $request->input('comment'),
                'user_id'=> $user_id,
                'video_id'=>$request->input('video_id'),
            ]);

            $response = [

                    'comment' => $comment->comment,
                    'user_id' => $comment->user_id,
                    'video_id' => $comment->video_id,

            ];

            return $this->sendResponse($response,'Comment Video');
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }
    }

    public function getComment()
    {
        $comment = Comment::all();
        return response()->json($comment);
    }

//Comment controller functions end


// view video detail with total_views, total_likes, total_comments

    public function videoById(Request $request)
    {
        try {
            //code...
            $validator = Validator::make($request->all(), [
                'video_id' => 'required|exists:videos,id',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $video = Video::with(['comments.user:id,name,profile',"user", 'likes', 'views'])->withCount(['comments', 'likes', 'views'])
                ->find($request->input('video_id'));

            $userLikedVideo = auth()->user() ? $video->likes->contains('user_id', auth()->user()->id) : false;
            $response=[
                'video' => $video,
                'total_comments' => $video->comments_count,
                'total_likes' => $video->likes_count,
                'total_views' => $video->views_count,
                'userLikedVideo' => $userLikedVideo,

            ];
            return $this->sendResponse($response,'View Video Detail');

        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }
    }
     

    public function addView(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'video_id' => 'required',
            ]);

            if($validator->fails()){
                return $this->sendError($validator->errors()->first());

            }

            $check_video = Video::find($request->video_id);
            if (!isset($check_video)) {
                return $this->sendError('Video Not Found');
            }
            $user_id = auth()->id();

            $view =View::create([
                'user_id'=> $user_id,
                'video_id'=>$request->input('video_id'),
            ]);

            $response = [
                'video_id' => $view->video_id,
            ];


        return $this->sendResponse($response,'View Video');
            //code...
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }
    }

// view video detail with total_views, total_likes, total_comments ---end
    /* List of Treats */
    public function treatsList()
    {
        try {

            $data = Treat::all();
            return $this->sendResponse($data,'Purchase Deals');
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }

    }

    public function myBalance()
    {
        try {
            $user = auth()->user();

            $data['balance'] = $user->balance;
            return $this->sendResponse($data,'My Balance');
        } catch (\Throwable $th) {
            return $this->sendError('Something went wrong');
        }

    }

    public function purchaseTreats(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'treats_id' => 'required',
                'price' => 'required',
                'transaction_id' => 'required',
            ]);

            if($validator->fails()){
                return $this->sendError($validator->errors()->first());
            }
            $user = auth()->user();
            $user_id = $user->id;
            $data['treats_id'] = $request->treats_id;
            $data['price'] = $request->price;
            $data['transaction_id'] = $request->transaction_id;
            $data['user_id'] = $user_id;
            $user->deposit($data['price']);
            PaymentDetails::create($data);
            return $this->sendResponse([],'Payment Successfully');

        } catch (\Throwable $th) {
                return $this->sendError('Something went wrong');
            }
    }
}
