<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use DB;

class LoginLogout extends Controller
{

    public function logout(){
        session(['tradehoopusername' => null]);
        session(['tradehooppassword' => null]);
        session(['tradehooplastname' => null]);
        session(['tradehoopfirstname' => null]);
        session(['tradehoopmiddlename' => null]);
        session(['tradehoopemail' => null]);
        session(['tradehoopbirthdate' => null]);
        session(['tradehoopgender' => null]);
        session(['tradehoopstatus' => null]);
        session(['tradehoopusertype' => null]);

        return redirect('/admin');
    }

/*|--------------------------------------------------------------------------
| ADMIN'S LOGIN LOGOUT CHECKING
|--------------------------------------------------------------------------*/

    public function checkLogin(){
        if(session('tradehoopusername') != null){
            return view('admin.home');
        }else{
            return view('admin.login');
        }
    }

    public function login(Request $request){
        $username = $request->input('username');
        $password = md5($request->input('password'));

        $user = DB::table('user')->where('username', $username)->first();

        if(!empty($request->input('password')) && !empty($username)){
            if(!isset($user)){
                return view('admin.login', ['message' => 'User do not exist']);
            }
            else if($password == $user->password){
                session(['tradehoopusername' => $username]);
                session(['tradehooppassword' => $password]);
                session(['tradehooplastname' => $user->lastname]);
                session(['tradehoopfirstname' => $user->firstname]);
                session(['tradehoopmiddlename' => $user->middlename]);
                session(['tradehoopemail' => $user->email]);
                session(['tradehoopbirthdate' => $user->birthdate]);
                session(['tradehoopgender' => $user->gender]);
                session(['tradehoopstatus' => $user->status]);
                session(['tradehoopusertype' => $user->usertype]);

                return redirect('admin');
            }else{
                return view('admin.login', ['message' => 'User do not exist']);
            }
        }else{
            return view('admin.login', ['message' => 'Both username and password are required']);
        }
    }

    public function adminLogout(){
        session(['tradehoopusername' => null]);
        session(['tradehooppassword' => null]);
        session(['tradehooplastname' => null]);
        session(['tradehoopfirstname' => null]);
        session(['tradehoopmiddlename' => null]);
        session(['tradehoopemail' => null]);
        session(['tradehoopbirthdate' => null]);
        session(['tradehoopgender' => null]);
        session(['tradehoopstatus' => null]);
        session(['tradehoopusertype' => null]);

        return redirect('/admin');
    }


}


