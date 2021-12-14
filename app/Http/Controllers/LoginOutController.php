<?php

namespace App\Http\Controllers;

use App\Models\Register;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class LoginOutController extends Controller
{
    public function index()
    {
        if(session()->get('s_uname'))
            return redirect('dashboard');
        else
            return view('login');
    }

    public function loggingIn(Request $request)
    {
        // return $request->all();
        $eml = $request->username;
        $pwd = $request->password;
        $dbpwd = "";
        $verification = Register::where('username',$eml) -> first();
        // echo $verification;

        if($verification)
        {
            if($pwd == $verification->password)                  //main directory is here
            {
                session()->put('s_uname', $verification->username);

                return redirect('dashboard');
            }
            else
            {
                $validator = Validator::make($request->all(),[
                'password' => ['required',Rule::in($dbpwd)],
                ], [
                'password.in' => 'Password is incorrent.',
                'password.required' => 'Please enter your password.',
                ]);

                if ($validator->fails())
                {
                    return back()->withErrors($validator);
                }
            }

        }
        else
        {
            $validator = Validator::make($request->all(),[
            'username'=>'required|exists:registers,username',
            'password' => 'required',
            ], [
            'password.required' => 'Please enter your password.',
            'username.required' => 'Please enter your username.',
            'username.exists' => 'Username is not registered.',
            ]);

            if ($validator->fails())
            {
                return back()->withErrors($validator);
            }
        }
    }

    public function logged_out()
    {
        session()->forget(['s_uname']);
        // session()->forget('name');
        session()->flush();

        return redirect('login');
    }

}
