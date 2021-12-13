<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Exercise;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MobileController extends Controller
{
    public function signup(Request $request)
    {
        // echo"HELLO";
        // return $request->all();

        $validator = Validator::make($request->all(),[
            'f_name'=> 'required|min:8',
            'f_email' => 'required|email:rfc,dns|unique:students,stu_email',
            'f_sch_id' => 'required|digits:4|numeric|exists:schools,school_code',
            'f_pass' => 'required|min:8',
            'f_c_pass' => 'required|same:f_pass',
            'f_u_pic' => 'mimes:jpeg,bmp,png,jpg|max:5120',
        ]);
        if ($validator->fails())
        {
            $str['status']=false;
            $str['data'] = $validator->errors()->toArray();
            return $str;
        }
        else
        {

            $var = new Student;
            $var->stu_name = $request->f_name;
            $var->stu_email = $request->f_email;
            $var->stu_pass = $request->f_pass;

            $var2 = School::where('school_code',$request->f_sch_id)->first();
            $var->school_id = $var2->id;

            if($request->f_u_pic)
            {
                $vbl3 = rand(100000000000000,999999999999999);
                $vbl4 = File::extension($request->f_u_pic->getClientOriginalName());
                request()->f_u_pic->storeAs('public/profile_pictures',$vbl3.".".$vbl4);
                $var->stu_pic = $vbl3.".".$vbl4;
                $var->save();
            }
            else
            {
            $var->stu_pic = "default-user.jpg";
            $var->save();
            }

            $str['status']=true;
            $str['message']="NEW STUDENT CREATED";
            $str['data']=$var;
            return $str;

        }
    }

    public function login(Request $request)
    {
        $eml = $request->uemail;
        $pwd = $request->upass;
        $dbpwd = "";
        $verification = Student::where('stu_email',$eml) -> first();
        // echo $verification;

        if($verification)
        {
            if($pwd == $verification->stu_pass)                  //main directory is here
            {
                $dbpwd = $verification->stu_pass;
                $str['status']=true;
                $str['message']="STUDENT LOGGED IN";
                $str['data']=$verification;
                return $str;
            }
            else
            {
                $validator = Validator::make($request->all(),[
                'upass' => ['required',Rule::in($dbpwd)],
                ], [
                'upass.in' => 'Password is incorrent.',
                'upass.required' => 'Please enter your password.',
                ]);

                if ($validator->fails())
                {
                    $str['status']=false;
                    $str['data'] = $validator->errors()->toArray();
                    return $str;
                }
            }

        }
        else
        {
            $validator = Validator::make($request->all(),[
            'uemail'=>'required|exists:students,stu_email|email:rfc,dns',
            'upass' => 'required',
            ], [
            'upass.required' => 'Please enter your password.',
            'uemail.required' => 'Please enter your email.',
            'uemail.exists' => 'Email is not registered.',
            'uemail.email' => 'Email is invalid.',
            ]);

            if ($validator->fails())
            {
                $str['status']=false;
                $str['data'] = $validator->errors()->toArray();
                return $str;
            }
        }
    }

    public function profile_updated(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'u_id'=> 'required|numeric|exists:students,id',
            'f_name'=> 'required|min:8',
            'f_u_pic' => 'mimes:jpeg,bmp,png,jpg|max:5120',
        ]);
        if ($validator->fails())
        {
            $str['status']=false;
            $str['data'] = $validator->errors()->toArray();
            return $str;
        }
        else
        {
            $var = Student::find($request->u_id);
            $var->stu_name = $request->f_name;

            if($request->f_u_pic)
            {
                $vbl3 = rand(100000000000000,999999999999999);
                $vbl4 = File::extension($request->f_u_pic->getClientOriginalName());
                request()->f_u_pic->storeAs('public/profile_pictures',$vbl3.".".$vbl4);
                $var->stu_pic = $vbl3.".".$vbl4;
            }
            $var->update();

            $str['status']=true;
            $str['message']="STUDENT UPDATED";
            $str['data']=$var;
            return $str;

        }
    }

    public function profile(request $request){

        $vbl = Student::find($request->id);
        if($vbl == "")
        {
            $str['status']=false;
            $str['message']="STUDENT PROFILE NOT FOUND";
            return $str;
        }
        else

            $str['status']=true;
            $str['message']="STUDENT PROFILE FOUND";
            $str['data']=$vbl;
            return $str;
    }

    public function pass_reset(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'u_id'=> 'required|numeric|exists:students,id',
            'f_pass' => 'required|min:8',
            'f_c_pass' => 'required|same:f_pass',
        ]);
        if ($validator->fails())
        {
            $str['status']=false;
            $str['data'] = $validator->errors()->toArray();
            return $str;
        }
        else
        {
            $var = Student::find($request->u_id);
            $var->stu_pass = $request->f_pass;
            $var->update();

            $str['status']=true;
            $str['message']="PASSWORD UPDATED";
            $str['data']=$var;
            return $str;

        }
    }

    public function pass_forgot()
    {

    }

    public function get_cat()
    {
        $vbl = Category::all();
        if(count($vbl)==0)
        {
            $str['status']=false;
            $str['message']="NO CATEGORIES TO SHOW";
            return $str;
        }
        else
        {
            $str['status']=true;
            $str['message']="ALL CATEGORIES SHOWN";
            $str['data']=$vbl;
            return $str;
        }
    }

    public function get_exe(Request $request)
    {
        // $vbl = DB::table('exercises')
        //     ->where('exercises.category_id',$request->id)
        //     ->join('categories','categories.id','=','exercises.category_id')
        //     ->select('exercises.*','categories.cat_name')
        //     ->get();
        //     // return "hello";
        // $vbl = json_decode($vbl, true);
        // return $vbl;

        $vbl1 = Category::find($request->id);
        $vbl2 = Exercise::where('category_id',$request->id)->get();

        if($vbl1 == ""){
            $str['status']=false;
            $str['message']="CATEGORY NOT FOUND";
            return $str;
        }
        else
        {
            if(count($vbl2) == 0)
            {
                $str['status']=true;
                $str['data']['category']=$vbl1;
                $str['message']="NO EXERCISES TO SHOW";
                return $str;
            }
            else
            {
                $str['status']=true;
                $str['message']="ALL EXERCISES SHOWN";
                $str['data']['category']=$vbl1;
                $str['data']['exercises']=$vbl2;
                return $str;
            }
        }
    }

    public function get_que(Request $request)
    {
        $vbl1 = Exercise::find($request->id);

        $vbl2 = DB::table('questions')
            ->where('questions.exercise_id',$request->id)
            ->join('answers','answers.question_id','=','questions.id')
            ->select('questions.que_title','answers.*')
            ->get();
        $vbl2 = json_decode($vbl2, true);
        // return $vbl2;

        if($vbl1 == ""){
            $str['status']=false;
            $str['message']="EXERCISE NOT FOUND";
            return $str;
        }
        else
        {
            if(count($vbl2) == 0)
            {
                $str['status']=true;
                $str['data']['exercise']=$vbl1;
                $str['message']="NO EXERCISES TO SHOW";
                return $str;
            }
            else
            {
                $str['status']=true;
                $str['message']="ALL EXERCISES SHOWN";
                $str['data']['exercise']=$vbl1;
                $str['data']['questions']=$vbl2;
                return $str;
            }
        }
    }
}
