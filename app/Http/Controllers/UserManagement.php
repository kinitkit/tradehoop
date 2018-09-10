<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use DB;
// use Symfony\Component\HttpFoundation\Request;

class UserManagement extends Controller
{

    public function userManagement(Request $request)
    {
        $users;
        //$search = $request->input('search');

        if ((session('search') == "")) {
            $users = DB::table('user')->paginate(20);
        } else {
            $search = session('search');
            $users = DB::table('user')
                ->where("firstname", "LIKE", '%' . $search . '%')
                ->orWhere("middlename", "LIKE", '%' . $search . '%')
                ->orWhere("lastname", "LIKE", '%' . $search . '%')
                ->orWhere("username", "LIKE", '%' . $search . '%')
                ->paginate(20);
        }

        return view('admin.userManagement')->with(['users' => $users]);
    }

    public function userManagementProceed(Request $request)
    {
        $search = $request->input("search");
        return redirect('/adminusermanagement')->with(['search' => $search]);
    }

    public function userManagementManageUser(Request $request)
    {
        $user = DB::table('user')
            ->leftJoin('supplier', 'user.username', '=', 'supplier.username')
            ->select('user.*', 'supplier.name AS suppliername', 'supplier.id AS supplierid')
            ->where('user.username', 'LIKE', $request->username)
            ->first();

        $message = (session('message') != "") ? session('message') : "";

        if ($user != "") {
            return view('/admin.userManagementManageUser')->with(['user' => $user])->with(['message' => $message]);
        } else {
            return redirect('/adminusermanagement');
        }
    }

    public function userManagementManageUserProceed(Request $request)
    {
        DB::table('user')
            ->where(['username' => $request->input('username')])
            ->update([
                'firstname' => $request->input('firstname'),
                'middlename' => $request->input('middlename'),
                'lastname' => $request->input('lastname'),
                'email' => $request->input('email'),
                'birthdate' => $request->input('birthdate'),
                'gender' => $request->input('gender'),
                'status' => $request->input('status'),
                'usertype' => $request->input('usertype')
            ]);

        return redirect('/adminusermanagementmanageuser?username=' . $request->input('username'))->with(['message' => 'successfully updated']);
    }

    public function userAdd(Request $request)
    {
        return view('admin.userAdd');
    }

    public function userAddProceed(Request $request)
    {
        $username = $request->input('username');
        $firstname = $request->input('firstname');
        $middlename = $request->input('middlename');
        $lastname = $request->input('lastname');
        $email = $request->input('email');
        $birthdate = $request->input('birthdate');
        $gender = $request->input('gender');
        $usertype = $request->input('usertype');

        $userExist = DB::table('user')->where('username', $username)->first();

        if ($userExist) {
            return redirect('/adminuseradd')->with(['message' => 'User Already Exists']);
        } else {
            $data = array(
                'username' => $username,
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'email' => $email,
                'birthdate' => $birthdate,
                'gender' => $gender,
                'usertype' => $usertype
            );
            DB::table('user')->insert($data);

            $data = array(
                'user' => $username,
                'address' => '',
                'addresstype' => 'home',
                'type' => 'addressline1'
            );
            DB::table('useraddress')->insert($data);

            $data = array(
                'user' => $username,
                'address' => '',
                'addresstype' => 'home',
                'type' => 'addressline2'
            );
            DB::table('useraddress')->insert($data);

            $data = array(
                'user' => $username,
                'address' => '',
                'addresstype' => 'home',
                'type' => 'city'
            );
            DB::table('useraddress')->insert($data);

            $data = array(
                'user' => $username,
                'address' => '',
                'addresstype' => 'home',
                'type' => 'region'
            );
            DB::table('useraddress')->insert($data);

            $data = array(
                'user' => $username,
                'address' => '',
                'addresstype' => 'home',
                'type' => 'country'
            );
            DB::table('useraddress')->insert($data);

            return redirect('/adminuseradd')->with(['message' => 'User added successfully']);
        }
    }

    public function searchSupplierForUser(Request $request)
    {
        $username = $_GET['username'];
        $search = $_GET['searchQuery'];
        

        $suppliers = DB::table('supplier')
            ->where('name', 'like', '%'. $search .'%')
            ->whereNull('username')
            ->get();

        return $suppliers;
    }

    public function userManagementManageUserUpdate(Request $request) {
        $username = $request->input('username');
        $firstname = $request->input('firstname');
        $middlename = $request->input('middlename');
        $lastname = $request->input('lastname');
        $email = $request->input('email');
        $birthdate = $request->input('birthdate');
        $gender = $request->input('gender');
        $status = $request->input('status');
        $usertype = $request->input('usertype');
        $newsupplier = $request->input('newsupplier');
        $user = "";

        DB::table('user')
            ->where(['username' => $request->input('username')])
            ->update([
                'firstname' => $firstname,
                'middlename' => $middlename,
                'lastname' => $lastname,
                'email' => $email,
                'birthdate' => $birthdate,
                'gender' => $gender,
                'status' => $status,
                'usertype' => $usertype
            ]);
        
        if($usertype == 5 && $newsupplier != "") {
            DB::table('supplier')
                ->where(['username' => $username])
                ->update(['username' => null]);

            DB::table('supplier')
                ->where(['id' => $newsupplier])
                ->update(['username' => $username]);
        } else if($usertype != 5) {
            DB::table('supplier')
                ->where(['username' => $username])
                ->update(['username' => null]);
        }

        $user = DB::table('user')
            ->leftJoin('supplier', 'user.username', '=', 'supplier.username')
            ->select('user.*', 'supplier.name AS suppliername', 'supplier.id AS supplierid')
            ->where('user.username', '=', $username)
            ->get();

        return redirect('/adminusermanagementmanageuser?username='. $username)->with(['message' => "successfully updated"]);

    }
}
