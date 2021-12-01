<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Services\UserService;
use App\Traits\DataTableSearch;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    use DataTableSearch;

    private $userService;

    public function __construct()
    {
        $this->userService = new UserService;
    }
    
    public function index(Request $request)
    {
        return view('user.index');
    }

    public function profile(Request $request)
    {
        $columns = ['name', 'email', 'role_name', 'language', 'introduce', 'mug_shot'];
        $this->userService->getUser(Auth::User(), $columns);
        try {
            return new JsonResponse([
                'message' => 'Operation successfully.',
                'data' => $this->userService->getUser(Auth::User(), $columns)
            ]);
        }catch (\Throwable $th) { 
            return new JsonResponse([
                'message' => 'Operation fail.'
            ], 400);
        }
        
    }


    public function edit(Request $request, User $user)
    {
        $error = $request->validate([
            'User.name' => ['required'],
            'User.language' => ['required', 
                                Rule::in(array_keys(config('languages')))]
        ]);

        $userData = $request->post('User');
        
        try {
            $successfully = $this->userService->update($user, $userData);

            return new JsonResponse([
                'message' => 'User updated ' . ($successfully ? 'successfully .' : 'fail .')
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([
                'message' => 'An error occurred while saving.'
            ], 400);
        }
    }

    public function list(Request $request)
    {
        $list = $this->userService->list($request);
        return self::dataTableSearch($list, $request->input(), ['name', 'email'], ['role', 'role_id']);
    }

    public function image(Request $request, User $user)
    {   
        try {
            return new JsonResponse([ 
                'message' => 'Mug shot upload successfully.',
                'image' => $this->userService->imageUploadSave(request()->image, $user)
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

            return new JsonResponse([ 
                'message' => 'update successfully.',
                'deleted' => $this->userService->status($id)
            ]);
                
        } catch (\Throwable $th) { 
            return new JsonResponse([ 
                'message' => 'Operation fail'
            ], 422);
        }
    }

    public function auth(Request $request, User $user)
    {
        $allowAuths = $this->userService->rolesWithoutSuper(['id', 'name']);

        request()->validate([
            'toggle' =>  ['required', 
                           Rule::in($allowAuths)]
        ]);
        
        try { 

            $this->userService->update($user, ['role_id' => $request->toggle]);
            $user = $this->userService->getUser($user);

            return new JsonResponse([ 
                'message' => "update successfully. </br>
                             " . $user['name'] . " is " . $user['role_name'] . " now !" ,
            ]);
        } catch (\Throwable $th) { 
            return new JsonResponse([ 
                'message' => 'Operation fail'
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
            $this->userService->resetPassWord($request);

            return new JsonResponse([ 
                'message' => "update password successfully" ,
            ]);
        } catch (\Throwable $th) {
            return new JsonResponse([ 
                'message' => 'Operation fail'
            ], 422);
        }
    }
}
