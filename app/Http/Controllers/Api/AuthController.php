<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Auth\Events\Registered;
use File;
use Illuminate\Support\Facades\Storage;
use DB;

class AuthController extends Controller
{
         /**
     * Create User
     * @param Request $request
     * @return User 
     */
    public function createUser(Request $request)
    {
        try {
            //Validated
            $validateUser = Validator::make($request->all(), 
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'nip' => 'required|unique:users',
                'division' => 'required',
                'position' => 'required',
                'plant' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'nip' => $request->nip,
                'division_code' => $request->division,
                'position_code' => $request->position,
                'plant_code' => $request->plant,
            ]);
            $data = User::findOrFail($user->id)->with(['plant','division','position','roles'])->first();
            $role = Role::findByName($request->role);
            $user->assignRole([$role->id]);
            event(new Registered($user));
            $token = $user->createToken("API TOKEN",array('*'), now('+7')->addDay(3)->toDateTimeString());
            return response()->json([
                'status' => 'success',
                'dataUser' => $data,
                'message' => 'User Created Successfully',
                'token' => $token->plainTextToken,
                'expirate_at' => $token->accessToken->expirate_at,
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Login The User
     * @param Request $request
     * @return User
     */
    public function loginUser(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(), 
            [
                'email' => 'required',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 422);
            }
            $credential =  [];
            if(is_numeric($request->get('email'))){
                $credential =  ['nip'=>$request->get('email'),'password'=>$request->get('password')];
            }
            elseif (filter_var($request->get('email'), FILTER_VALIDATE_EMAIL)) {
                $credential = ['email' => $request->get('email'), 'password'=>$request->get('password')];
            }else{
                $credential = ['name' => $request->get('email'), 'password'=>$request->get('password')];
            }
            
            if(!Auth::attempt($credential)){
                return response()->json([
                    'status' => 'failed',
                    'message' => 'Credential does not match with our record.',
                ], 401);
            }

            $user = User::where('id', Auth::user('sanctum')->id)->with(['plant','division','position'])->first();
            $token = $user->createToken("API TOKEN",array('*'), now('+7')->addDay(3)->toDateTimeString());

            if($user->hasRole('Operator')){
                return response()->json([
                    'status' => 'success',
                    'message' => 'User Logged In Successfully',
                    'user'=> $user,
                    'roles' => Auth::user('sanctum')->roles()->pluck('name'),
                    'token' => $token->plainTextToken ,
                    'expirate_at' => now('+7')->addDay(3)->toDateTimeString(),
                ], 200);
            }else{
                return response()->json(['status'=>'failed','message'=>'Unauthorize, Your role is not allowed'],401);
            }
            

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            Auth::user()->tokens()->delete();
            return [
                'message' => 'You have successfully logged out and the token was successfully deleted'
            ];
            return response()->json([
                'status' => 'success',
                'message' => 'You have successfully logged out and the token was successfully deleted'
            ],);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'failed',
                'message' => $th->getMessage()
            ], 500);
        }
        
    }

    public function changePassword(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if(!Hash::check($request->old_password, auth('sanctum')->user()->password)){
                        
            return response()->json([
                'status' => 'failed',
                'message' => "Old Password Doesn't match!",            
            ]);
        }


        #Update the new Password
        User::findOrFail(auth('sanctum')->user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Password Changed Successfully',            
        ], 200);
    }
    
    public function refresh(Request $request)
    {
        $user = auth('sanctum')->user();
        if(!$user){
            return response()->json([
                'message' => 'Not authenticated'
            ], 401);
        }
        $user->tokens()->delete();
        $token = $user->createToken("API TOKEN",array('*'), now('+7')->addDay(3));
        return response()->json([ 'token' => $token->plainTextToken ,
        'expirate_at' => now('+7')->addDay(3)->toDateTimeString(),]);
    }

    public function getUser(Request $request){                      
        $data = User::where('id',auth('sanctum')->user()->id)->with(['plant','division','position','roles'])->first();        
        return response()->json([
            'status' => 'success',
            'message' => 'Get User Successfully', 
            'user'=> $data,                    
        ], 200);
    }

    public function getPhoto(Request $request){
        $data = auth('sanctum')->user();
        $file = '';
        if( isset($data->url) && Storage::disk('pp')->exists($data->url)){            
           $file =  Storage::disk('pp')->get($data->url);
           $type = Storage::disk('pp')->mimeType($data->url);
        }else{  
            
            if(File::exists(public_path('/pp/blank.jpg'))) {
                $file = File::get(public_path('/pp/blank.jpg'));
                $type = File::mimeType(public_path('/pp/blank.jpg'));
            }else{
                $file = '';
            }                
            
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Get Photo Successfully',            
            'image' => $file != '' ? base64_encode($file) : '-'           
        ], 200);
    }

    public function changePhoto(Request $request){
        $request->validate([            
            'foto' => 'required|mimes:jpeg,bmp,png,gif,jpg,svg|max:20000'
        ]);
        DB::beginTransaction();        
        try {
            $data = $request->foto;
            $path = Storage::disk('pp')->put(time().$request->file('foto')->getClientOriginalName(),$request->file('foto')->get());                   
            $data = User::where('id',auth('sanctum')->user()->id)->first();           
            if(isset($data->url) && Storage::disk('pp')->exists($data->url) && $data->url != 'blank.jpeg' ){
                Storage::disk('pp')->delete($data->url);
            }
            $data->url = time().$request->file('foto')->getClientOriginalName();
            $data->update();
            DB::commit();
            return response()->json(['status'=>'success','message'=>'Data Updated Successfully'],200);
        } catch (\Exception $th) {
            DB::rollback();
            return response()->json(['status'=>'failed','message'=>$e->getMessage()],500);
        }
    }
}
