<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Auth\Access\AuthorizationException;
use App\Models\User;

class EmailVerificationController extends Controller
{

    public function sendVerificationEmail(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            response()->json([
                'message' => 'Already Verified'
            ]);
        }

        $request->user()->sendEmailVerificationNotification();

        response()->json(['status' => 'verification-link-sent']);
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail($request->id);

        if (!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
            throw new AuthorizationException;
        }
        if ($user->email_verified_at) {
            if($request->wantsJson()){                
                response()->json([
                    'message'=>'Email already verified'
                ]);
            }
                $str = '<script type="text/javascript">'; 
                $str.='alert("Email already verified");'; 
                $str.= 'window.location.href = "/login";';
                $str.= '</script>';
                return print($str);
            
        }

        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        if($request->wantsJson()){                
            response()->json([
                'message'=>'Email has been verified'
            ]);
        }
            $str = '<script type="text/javascript">'; 
            $str.='alert("Email already verified");'; 
            $str.= 'window.location.href = "/login";';
            $str.= '</script>';
            return print($str);

        return response()->json([
            'message'=>'Email has been verified'
        ]);
    }
}