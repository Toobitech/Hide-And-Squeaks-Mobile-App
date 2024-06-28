<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use App\Mail\sendEmail;
use App\Mail\ResetPasswordEmail;
use Mail;

use Log;
class UserController extends BaseController
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }


        $input = $request->except(['password','name','last_name'],$request->all());
        $name = $request->name;
        $last_name = $request->last_name;
        $input['name'] =   $name .' '.$last_name;
        $input['password'] = Hash::make($request->password);
        $user = User::create($input);
        // $success['token'] =  $user->createToken('Hide-and-squeaks')->accessToken;
        $success['name'] =  Str::upper($user->name);
        $success['id'] = $user->id;
        return $this->sendResponse($success, 'User register successfully.');



    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'password' => 'required',
        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
        try {
            if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
                $user = Auth::user();
                $success['token'] =  $user->createToken('Hide-and-squeaks')->accessToken;

                $success['name'] =  $user->name;
                $success['id'] =  $user->id ;
                $success['profile'] = $user->profile ;


                return $this->sendResponse($success, 'User login successfully.');
            }

            return $this->sendError('Invalid Email Password.');

            //code...
        } catch (\Throwable $th) {
            return $this->sendError('SomeThing went wrong.');
        }
    }
    public function requestOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
         $otp = rand(1000, 9999);

        $user = User::where('email', $request->email)->update([
            'otp' => $otp,

        ]);
        $details['otp'] = $otp;
        if ($user) {
            $email = $request->email;
            Mail::to($request->email)->send(new ResetPasswordEmail($otp));
            // Mail::send('emails.reset-password-email', $details, function($message) use ($email) {
            //       $message->to($email, 'Verification Code From Hide And Squeaks')->subject
            //           ('You have recieved Verification Code');
            //       $message->from('info@digimaestros.com ','Verification Code');
            //     });
             
            $success['otp'] =  $otp;

            return $this->sendResponse($success, 'OTP Sent Successfully');
        }
            return $this->sendError('Invalid Email');

    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'otp' => 'required|numeric',

        ]);

        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
        $otp_match = User::where([
            'email' => $request->email,
            'otp' => $request->otp,
        ])->first();

        if ($otp_match) {
            return $this->sendResponse('OTP matched. Proceed to reset password.');
        } else {
            return $this->sendError('Invalid OTP');
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'email' => 'required|email',
            'password' => 'required',

        ]);
        if($validator->fails()){
            return $this->sendError($validator->errors()->first());

        }
        $user = User::where([
            'email' => $request->email,
        ])->first();

        if ($user) {
            // Reset the password
            $user->password = Hash::make($request->password);
            $user->otp = null; // Clear the OTP
            $user->save();

            return $this->sendResponse('Password reset successfully');
        } else {
            return $this->sendError('Invalid OTP or reset token');
        }
    }
   }
