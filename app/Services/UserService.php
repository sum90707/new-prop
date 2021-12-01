<?php

namespace App\Services;

use App\Repositories\UserRepository;
use App\Repositories\RoleRepository;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserService
{

    private $userRepo;
    private $roleRepo;

    public function __construct() 
    {
        $this->userRepo = new UserRepository;
        $this->roleRepo = new RoleRepository;
    }

    private function get($user, $trash = false)
    {
        if(! ($user instanceof \Illuminate\Database\Eloquent\Model) ) {

            $user = $trash ? $this->userRepo->getWithTrashById($user) : $this->userRepo->getById($user);
        }

        return $user;
    }


    public function getUser($user, $columns = null)
    {
        
        $user = self::get($user);

        if( !empty($user) ) {
            return $columns ? $user->only($columns) : $user->toArray();
        }
        
        return null;
    }

    public function update($user, $data)
    {
        $user = self::get($user, 'trash');

        if( !empty($user) && is_array($data)) {
            return $this->userRepo->update($user, $data);
        }
    }
    
    public function list($request)
    {
        return $this->userRepo->buildUserList($request);
    }
   
    public function uploadFile($file, $user)
    {
        $name =  md5(time() . rand(0,9999)) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path("upload/$user->id/"), $name);

        return $name;
    }

    public function imageUploadSave($file, $user)
    {
        $user = self::get($user);

        if(!empty($user)) {
            $name = self::uploadFile($file, $user);
            self::update($user, ['mug_shot' => $name]);

            return asset("upload/" . $user->id) . '/' . $name;
        }
    }

    public function status($user)
    {
        $user = self::get($user, 'trash');
        
        if(!empty($user)) {
            return $this->userRepo->softDel($user);
        }
    }

    public function resetPassWord($request)
    {
        $user = $this->userRepo->getByColumn('email', $request->email);
        
        return  $this->userRepo->forceUpdate($user, [
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60)
                ]);
    }

    public function rolesWithoutSuper($columns)
    {
        $table = $this->userRepo->getTable();
        return $this->roleRepo->rolesWithoutSuper($table, $columns);
    }

}