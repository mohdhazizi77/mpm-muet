<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\UserRequest;
use App\Services\AuditLogService;

use App\Models\User;
use App\Models\AuditLog;
use Spatie\Permission\Models\Role;

use Exception;
use DataTables;


class UserController extends Controller
{
    public function index()
    {
        $user = Auth::User() ? Auth::User() : abort(403);

        return view('modules.admin.administration.users.index',
            compact([
                'user',
            ]));

    }

    public function getAjax(){

        $users = Auth::User() ? User::get() : abort(403);
        
        $data = [];
        foreach($users as $user){
            $data[] = [
                "id"    => Crypt::encrypt($user->id),
                "role"  => $user->getRoleNames()[0],
                "name"  => $user->name,
                "email" => $user->email,
                "status" => $user->is_deleted,
                "phoneNum" => empty($user->phone_num) ? "Not Available"  : $user->phone_num,
            ];
        };

        return datatables($data)->toJson();

    }

    public function create()
    {
        $role = Role::where('name', '!=', 'CALON')->get();

        return view('modules.admin.administration.users.create',
            compact([
                'role',
            ]));
    }

    public function edit($id){

        try {
            $id = Crypt::decrypt($id);
        } catch (Exception $e) {
            
        }

        $user = User::find($id);
        $role = Role::where('name', '!=', 'CALON')->get();

        return view('modules.admin.administration.users.edit',
            compact([
                'user',
                'role',
            ]));
    }

    public function store(UserRequest $request){

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make("123456");
        $user->phone_num = $request->phonenumber;
        $user->is_deleted = $request->status;
        $user->save();

        //assign role
        $user->assignRole($request->role);

        $old = [
            "name" => '',
            "email" => '',
            "phone_num" => '',
            "role" => '',
            "status" => '',
        ];

        $new = [
            "name" => $user->name,
            "email" => $user->email,
            "phone_num" => $user->phone_num,
            "role" => $request->role,
            "status" => $user->is_deleted == 0 ? "Active" : "Inactive",
        ];

        // Log the activity
        AuditLogService::log($user, 'Create', $old, $new);

        //should send email 
        // for verify and isi password for first time

        return redirect()->route('users.index')->with('success', 'User created successfully.');

    }

    public function update(UserRequest $request, User $user)
    {

        // Old data
        $old = [
            "name" => $user->name,
            "email" => $user->email,
            "phone_num" => $user->phone_num,
            "role" => $user->roles->pluck('name')->first(),
            "status" => $user->is_deleted == 0 ? "Active" : "Inactive",
        ];
        
        // Update role if necessary
        $user->syncRoles($request->role);
        
        // New data
        $new = [
            "name" => $request->name,
            "email" => $request->email,
            "phone_num" => $request->phonenumber,
            "role" => $request->role,
            "status" => $request->status == 0 ? "Active" : "Inactive",
        ];
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_num = $request->phonenumber;
        $user->is_deleted = $request->status;
        $user->save();

        // Compare old and new data, and unset identical values
        foreach ($old as $key => $value) {
            if ($old[$key] === $new[$key]) {
                unset($old[$key]);
                unset($new[$key]);
            }
        }

        AuditLogService::log($user, 'Update', $old, $new);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }
}
