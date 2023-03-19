<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password as RulesPassword;
use DB;

class NewPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        $user = DB::table('users')->where('email',$request->email)->first();
        
        $tokenData = DB::table('password_resets')
        ->where('email', $request->email)->first();
        if ($status == Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => __($status),               
            ]);
        }

        throw ValidationException::withMessages([
            'email' => [trans($status)],
        ]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed', RulesPassword::defaults()],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                $user->tokens()->delete();

                event(new PasswordReset($user));
            }
        );

        if ($status == Password::PASSWORD_RESET) {            
            if($request->wantsJson()){                
                return response()->json([
                    'message'=> 'Password reset successfully'
                ]);
            }
                $str = '<script type="text/javascript">'; 
                $str.='alert("Password reset successfully");'; 
                $str.= 'window.location.href = "/login";';
                $str.= '</script>';
                return print($str);
    
                
        }

        return response()->json([
            'message'=> __($status)
        ], 500);

    }
}
