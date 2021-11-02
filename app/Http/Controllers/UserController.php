<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Role;
use App\Traits\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    use Permission;

    const MENU = 'User';
    private $user;

    public function __construct()
    {
        $this->user = new User;
    }
    
    public function index(Request $request)
    {
        return view('user.index');
    }

    public function profile(Request $request)
    {
        $user = User::select('name', 'email', 'language', 'role_id', 'introduce', 'mug_shot')
                    ->where('id', Auth::User()->id)
                    ->first()
                    ->makeHidden(['role', 'role_id'])
                    ->toArray();

        return new JsonResponse($user);
    }


    public function edit(Request $request, User $user)
    {
        $error = $request->validate([
            'User.name' => ['required'],
            'User.language' => ['required', 
                                Rule::in(array_keys(config('languages')))]
        ]);

        try {
            $user->fill($request->post('User'));
            if ($user->isDirty()) {
                $user->save();
            }

            return new JsonResponse([
                'message' => 'User updated successfully.'
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([
                'message' => 'An error occurred while saving.'
            ], 400);
        }
    }

    public function list(Request $request)
    {
        return User::buildUserList($request);
    }

    public function image(Request $request, User $user)
    {  
        request()->validate([
            'image' => ['required',
                        'image',
                        'max:2048',
                        'mimes:jpeg,png,jpg,gif,svg,jpeg'],
        ]);
        
        try {

            $imageName = md5(time() . rand(0,9999)) . '.' . request()->image->getClientOriginalExtension();
            request()->image->move(public_path("upload/$user->id/"), $imageName);
            $user->update(['mug_shot' => $imageName]);

            return new JsonResponse([ 
                'message' => 'Mug shot upload successfully.',
                'image' => asset("upload/" . Auth::id()) . '/' . $imageName
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([ 
                'message' => 'Mug shot upload fail'
            ], 422);
        
        }
        
    }

    public function status(Request $request, $id)
    {
        try { 
            $user = User::withTrashed()
                        ->find($id);

            $user->trashed() ? $user->restore() : $user->delete();

            return new JsonResponse([ 
                'message' => 'update successfully.',
                'deleted' => $user->trashed()
            ]);
                
        } catch (\Throwable $th) { 
            return new JsonResponse([ 
                'message' => 'Operation fail'
            ], 422);
        }
    }

    public function auth(Request $request, User $user)
    {
        $allowAuths = Role::rolesWithoutSuper(User::getTableName(), ['id', 'name']);

        request()->validate([
            'toggle' =>  ['required', 
                           Rule::in($allowAuths)]
        ]);
        
        try { 
            $user->update(['role_id' => $request->toggle]);

            return new JsonResponse([ 
                'message' => "update successfully. </br>
                              $user->name is " . $user->role->name . ' now !' ,
            ]);
        } catch (\Throwable $th) { 
            return new JsonResponse([ 
                'message' => 'Operation fail' . $th
            ], 422);
        }
        
    }

    public function resetpassword(Request $request, User $user)
    {
        request()->validate([
            'email' => [
                'required',
                'email',
                Rule::exists('users')->where(function($query) use($request) {
                    $query->where('email', $request->email);
                }) 
            ],
            'password' => 'required|string|min:6|confirmed'
        ]);

        try { 

            $updateUser = User::where('email', $request->email)->first();

            $updateUser->forceFill([
                'password' => Hash::make($request->password)
            ])->setRememberToken(Str::random(60));
            
            $updateUser->save();

            return new JsonResponse([ 
                'message' => "$updateUser->name update password successfully" ,
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([ 
                'message' => 'Operation fail' . $th
            ], 422);
        }
    }
}
