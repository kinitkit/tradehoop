<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

use DB;

class Administrator extends Controller
{

/*|--------------------------------------------------------------------------
| PERSONAL INFORMATION
|--------------------------------------------------------------------------*/

    public function changePassword(Request $request){
        $oldpasssword = $request->input('oldpassword');
        $newpasssword = $request->input('newpassword');
        $confirmpasssword = $request->input('confirmpassword');

        if(!empty($oldpasssword) && !empty($newpasssword) && !empty($confirmpasssword)){
            $oldpasssword = md5($oldpasssword);
            $newpasssword = md5($newpasssword);
            $confirmpasssword = md5($confirmpasssword);

            if(session('tradehooppassword') != $newpasssword){
                if(session('tradehooppassword') == $oldpasssword){
                    if($newpasssword == $confirmpasssword){
                        DB::table('user')
                        ->where('username', session('tradehoopusername'))
                        ->update(['password' => $newpasssword]);
                        session(['tradehooppassword' => $newpasssword]);
                        return redirect('adminpersonalchangepassword')->with(['message'=>'Your password is successfully changed. Please do not forget it.']);
                    }else{
                        return redirect('adminpersonalchangepassword')->with(['message'=>'Be sure that both passwords are correct']);
                    }
                }else{
                    return redirect('adminpersonalchangepassword')->with(['message'=>'Old password is incorrect']);
                }
            }else{
                return redirect('adminpersonalchangepassword')->with(['message'=>'New password must be not the old password']);
            }
        }else{
            return view('admin.personalpassword', ['message' => 'All fields are required']);
            return redirect('adminpersonalchangepassword')->with(['message'=>'All fields are required']);
        }
    }

    public function updateInformation(Request $request){
        $firstname = $request->input('firstname');
        $middlename = $request->input('middlename');
        $lastname = $request->input('lastname');
        $email = $request->input('email');
        $birthdate = $request->input('birthdate');
        $gender = $request->input('gender');

        session(['tradehoopfirstname' => null]);
        session(['tradehoopmiddlename' => null]);
        session(['tradehooplastname' => null]);
        session(['tradehoopemail' => null]);
        session(['tradehoopbirthdate' => null]);
        session(['tradehoopgender' => null]);

        session(['tradehoopfirstname' => $firstname]);
        session(['tradehoopmiddlename' => $middlename]);
        session(['tradehooplastname' => $lastname]);
        session(['tradehoopemail' => $email]);
        session(['tradehoopbirthdate' => $birthdate]);
        session(['tradehoopgender' => $gender]);

        DB::table('user')
        ->where('username', session('tradehoopusername'))
        ->update(['firstname' => $firstname, 'middlename' => $middlename, 'lastname' => $lastname, 'email' => $email, 'birthdate' => $birthdate, 'gender' => $gender]);

        return redirect('/adminpersonalinfo')->with(['message'=>'Your information is successfully updated. It will be changed after you log out.']);
    }

    public function getContactAddressInformation($message = ""){
        $address = DB::table('useraddress')->where(['user'=> session('tradehoopusername'), 'addresstype' => 'home'])->get();
        $contact = DB::table('usercontact')->where(['user'=> session('tradehoopusername')])->get();
        return view('admin.personalcontactaddress', ['message' => $message])->with('store', $address)->with('contact', $contact); 
    }

    public function updateContactAddressInformation(Request $request){
        $address = $request->input('address');
        $addressline1 = $request->input('addressline1');
        $addressline2 = $request->input('addressline2');
        $city = $request->input('city');
        $region = $request->input('region');
        $country = $request->input('country');

        $contact = $request->input('contact');
        $contactnumber = $request->input('contactnumber');

        $deletecontact = $request->input('deletecontact');
        
        if(!empty($address)){
            if(!empty($addressline1) && !empty($addressline2) && !empty($city) && !empty($region) && !empty($country)){
                DB::table('useraddress')
                ->where(['user'=> session('tradehoopusername'), 'addresstype'=>'home', 'type'=>'addressline1'])
                ->update(['address' => $addressline1]);

                DB::table('useraddress')
                ->where(['user'=> session('tradehoopusername'), 'addresstype'=>'home', 'type'=>'addressline2'])
                ->update(['address' => $addressline2]);

                DB::table('useraddress')
                ->where(['user'=> session('tradehoopusername'), 'addresstype'=>'home', 'type'=>'city'])
                ->update(['address' => $city]);

                DB::table('useraddress')
                ->where(['user'=> session('tradehoopusername'), 'addresstype'=>'home', 'type'=>'region'])
                ->update(['address' => $region]);

                DB::table('useraddress')
                ->where(['user'=> session('tradehoopusername'), 'addresstype'=>'home', 'type'=>'country'])
                ->update(['address' => $country]);

                return redirect('/adminpersonalcontactaddress')->with(['message'=>'Address successfully updated']);
            }
            else{
                return redirect('/adminpersonalcontactaddress')->with(['message'=>'Fill in your address please.']);
            }
        }else if(!empty($contact)){
            if(!empty($contactnumber)){
                $data = array('user'=>session('tradehoopusername'), 'contact'=> $contactnumber, 'contacttype'=>'mobile');
                DB::table('usercontact')->insert($data);
                return redirect('/adminpersonalcontactaddress')->with(['message'=>'Contact successfully added.']);
            }
            else{
                return redirect('/adminpersonalcontactaddress')->with(['message'=>'Write the number in contacts before adding it.']);
            }
        }else if(!empty($deletecontact)){
            DB::table('usercontact')->where(['contact'=>$deletecontact, 'user'=>session('tradehoopusername')])->delete();
            return $this->getContactAddressInformation('Contact deleted successfully.');
        }
        
        /*DB::table('user')
        ->where('username', session('tradehoopusername'))
        ->update(['firstname' => $firstname]);*/
    }




}


