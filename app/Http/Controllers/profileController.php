<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\m_division;
use App\Models\m_position;
use App\Models\plant;
use Illuminate\Support\Facades\Hash;
use App\Models\sap_m_plant;
use File;
use DB;
use Illuminate\Support\Facades\Storage;

class profileController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function getFile($namafile)
    {
        $path  = storage_path('app/pp/'.$namafile);
        $path1 = public_path('pp/blank.jpg');


        if (file_exists($path)) {
        $type  = File::mimeType($path);
        $file = File::get($path);
        return 'data:image/'.$type.';base64,'.base64_encode($file).'';
        }
        
        else{
        $type1  = File::mimeType($path1);
        $file1 = File::get($path1);
        return 'data:image/'.$type1.';base64,'.base64_encode($file1).'';
        }
    }

    public function profile($id)
    {
        $data = User::where('id', $id)->get();        
        
        if ($data->first()->url == NULL) {
            $data->first()->foto = '';
        }
        else{
            $data->first()->foto = $this->getFile($data->first()->url);
        }

        return view('profile', [
            'data' => $data,
            'title' => "Profile"
        ]);
    }

    public function editpassword(Request $request)
    {

        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        #Match The Old Password
        if (!Hash::check($request->old_password, auth()->user()->password)) {
            return back()->with("error", "Password lama tidak cocok");
            // echo "gagal";
        }


        #Update the new Password
        $item = User::find($request->id);
        // $pass = hash::make($request->new_password);
        // echo $pass;
        $item->password = hash::make($request->new_password);
        $item->save();

        return back()->with("status", "Password telah terganti");
    }

    //REVISI KESALAHAN = PLANT POSITION DIVISION HARUSNYA KE CODE, BUKAN ID
    public function editprofile(Request $request)
    {
        $request->validate([
            'image'=>'mimes:jpeg,jpg,png,gif|max:10000',
            'email'=>'required|unique:users,email',
            'nip'=>'required|unique:users,nip',
        ]);

        $item = User::find($request->id);

        if ($item->url != 'blank.jpg') {
            Storage::disk('pp')->delete($item->url);
        }

        if ($request->file('image') != null) {
            $file = $request->file('image');
            $target_file = $file->getClientOriginalName();
            // Storage::disk('pp')->put('image.txt',$file);
            Storage::disk('pp')->put($request->nip.$target_file,$request->file('image')->get());
            $item->url              = $request->nip.basename($_FILES["image"]["name"]);
        }

        // dd(basename($_FILES["image"]["name"]));

        $item->name             = $request->name;
        $item->email            = $request->email;
        $item->nip              = $request->nip;
        // $item->division_code    = $request->divisi;
        // $item->plant_code       = $request->plant;
        // $item->position_code    = $request->position;
        $item->save();

        return back()->with("status", "Profile telah terganti");
    }   

    public function user()
    {
        return view('users', [
            'data' => User::all(),
            'division' => m_division::all(),
            'position' => m_position::all(),
            'plant' => sap_m_plant::all(),
            'title' => 'User Management'
        ]);
    }

    //REVISI KESALAHAN = PLANT POSITION DIVISION HARUSNYA KE CODE, BUKAN ID
    public function add(Request $request)
    {
        $request->validate([
            'image'=>'mimes:jpeg,jpg,png,gif|max:10000',
            'email'=>'required|unique:users,email',
            'nip'=>'required|unique:users,nip',
        ]);

        $data = $request->input();

        $user = new User;

        if ($request->file('image') != null) {
            $file = $request->file('image');
            $target_file = $file->getClientOriginalName();
            // Storage::disk('pp')->put('image.txt',$file);
            Storage::disk('pp')->put($request->nip.$target_file,$request->file('image')->get());
            $user->url              = $request->nip.basename($_FILES["image"]["name"]);
        }
        $user->email = $data['email'];
        $user->name = $data['name'];
        $user->password = bcrypt($data['password']);
        $user->nip = $data['nip'];
        $user->plant_code = $data['plant'];
        $user->division_code = $data['division'];
        $user->position_code = $data['position'];
        $user->save();
        $user->assignRole($data['role']);

        return redirect('/usermanagement')->with("status", "Data telah tersimpan");
    }

    public function viewedit($id)
    {
        $data = User::where('id', $id)->get();

        return view('profile', [
            'data' => $data,
            'title' => "Profile"
        ]);
    }


    public function deleteuser($id)
    {
        $item = User::find($id);
        $roles = DB::table('model_has_roles')->where('model_id',$id);
        
        $check = DB::table('model_has_roles')->where([['model_id',$id],['role_id','1']]);
        // echo $check;
        if (!is_null($check->first())) {
            return back()->with("error", "Tidak bisa menghapus admin!");
        }

        if ($item->url != 'blank.jpg') {
            Storage::disk('pp')->delete($item->url);
        }

        $roles->delete();
        $item->delete();

        return back()->with("status", "Data telah terhapus");
    }
}
