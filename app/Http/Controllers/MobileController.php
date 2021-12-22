<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Exercise;
use App\Models\Given_Answer;
use App\Models\Question;
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
            'f_name'=> 'required|min:3',
            'f_email' => 'required|email:rfc,dns|unique:students,stu_email',
            'f_sch_id' => 'required|digits:4|numeric|exists:schools,school_code',
            'f_pass' => 'required|min:6',
            'f_u_pic' => 'mimes:jpeg,bmp,png,jpg|max:5120',
        ], [
            'f_name.required' => 'Please enter your Name.',
            'f_name.min' => 'Name must be at least 3 characters.',
            'f_email.required' => 'Please enter your Email.',
            'f_sch_id.required' => 'Please enter your School Code.',
            'f_sch_id.digits' => 'School Code Must be 4 Digits.',
            'f_sch_id.numeric' => 'School Code Must Numeric.',
            'f_sch_id.exists' => 'School Code Not Exist.',
            'f_pass.required' => 'Please enter your Password.',
            'f_pass.min' => 'Password Not Less Than 6 Digits.',
            'f_u_pic.mimes' => 'Picture Is Not Valid.',
            'f_email.unique' => 'Email is Already registered.',
            'f_email.email' => 'Email is invalid.',
            ]);
        if ($validator->fails())
        {
            $str['status']=false;
            $error=$validator->errors()->toArray();
            foreach($error as $x => $x_value){
                $err[]=$x_value[0];
            }
             $str['message'] =$err['0'];
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

                     $error=$validator->errors()->toArray();
            foreach($error as $x => $x_value){
                $err[]=$x_value[0];
            }
             $str['message'] =$err['0'];
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
                $error=$validator->errors()->toArray();
            foreach($error as $x => $x_value){
                $err[]=$x_value[0];
            }
             $str['message'] =$err['0'];
                // $str['data'] = $validator->errors()->toArray();
                return $str;
            }
        }
    }

    public function profile_updated(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'u_id'=> 'required|numeric|exists:students,id',
            'f_name'=> 'required|min:3',

        ], [
            'u_id.required' => 'Empty Fields.',
           'f_name.required' => 'Please enter your Name.',
            'f_name.min' => 'Name must be at least 3 characters.',
            ]);
        if ($validator->fails())
        {
            $str['status']=false;
            $error=$validator->errors()->toArray();
            foreach($error as $x => $x_value){
                $err[]=$x_value[0];
            }
             $str['message'] =$err['0'];
            // $str['data'] = $validator->errors()->toArray();
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
            $str['message']="STUDENT PROFILE ";
            $str['data']=$vbl;
            return $str;
    }

    public function pass_reset(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'u_id'=> 'required|numeric|exists:students,id',
            'o_pass' => 'required|min:6',
            'n_pass' => 'required|min:6',
        ],[
            'u_id.required'=>'Empty Fields',
            'u_id.exists'=>'User Not Found',
            'o_pass.required'=>'Enter Your Old Password',
            'o_pass.min'=>'Password Not Less Than 6 Digits',
             'n_pass.required'=>'Enter Your New Password',
            'n_pass.min'=>'Password Not Less Than 6 Digits',
            ]);
        if ($validator->fails())
        {
            $str['status']=false;
            $error=$validator->errors()->toArray();
            foreach($error as $x => $x_value){
                $err[]=$x_value[0];
            }
             $str['message'] =$err['0'];
            // $str['data'] = $validator->errors()->toArray();
            return $str;
        }
        else
        {
            $var = Student::find($request->u_id);
            if($request->o_pass == $var->stu_pass)
            {
            $var->stu_pass = $request->n_pass;
            $var->update();

            $str['status']=true;
            $str['message']="PASSWORD UPDATED";
            $str['data']=$var;
            return $str;
            }else{
                  $str['status']=false;
            $str['message']="Old Password Is Incorrect!";
            return $str;
            }


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

        // return $request;

        $vbl1 = Category::find($request->cat_id);
        $vbl00 = Student::find($request->user_id);
        $vbl2 = Exercise::where('category_id',$request->cat_id)->get();

        // $exe_status = false;
        $vbl4 = array();



        foreach ($vbl2 as $value) {
            $questions = DB::table('questions')->select(DB::raw('count(*) as tot_question'))
            ->where('questions.exercise_id',$value->id)
            ->first();

            $ans = DB::table('given__answers')->select(DB::raw('count(*) as tot_question'))
            ->join('questions','questions.id','given__answers.answer_id')
            ->where('questions.exercise_id',$value->id)
            ->where('given__answers.student_id',$request->user_id)->first();

            // $value->tot=$questions->tot_question;
            // $value->ans=$ans->tot_question;
            // $vbl4[]=$value;
           if($questions->tot_question==$ans->tot_question AND $questions->tot_question>0){
            $value->exe_status=true;
            $vbl4[]=$value;
           }else{
            $value->exe_status=false;
            $vbl4[]=$value;
           }
        }

        // return $vbl4;

        if($vbl1 == "" || $vbl00 == ""){
            $str['status']=false;
            $str['message']="CATEGORY OR USER DOES NOT FOUND";
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
                $str['data']['exercises']=$vbl4;
                return $str;
            }
        }
    }

    public function get_que(Request $request)
    {
        $vbl1 = Exercise::find($request->exe_id);

        $vbl5 = Student::find($request->user_id);

        $vbl3 = DB::table('questions')
            ->where('questions.exercise_id',$request->exe_id)
            ->join('answers','answers.question_id','=','questions.id')
            ->select('questions.que_title','answers.*')
            ->get();
        // $vbl3 = json_decode($vbl2, true);

        // return $vbl3;

        $vbl4 = array();

        foreach($vbl3 as $var){
            $ans = DB::table('given__answers')
            ->where('answer_id',$var->question_id)
            ->where('student_id',$request->user_id)->first();
            if($ans)
            {
                $var->ans_status=true;
                array_push($vbl4,$var);
            }else
            {
                $var->ans_status=false;
                array_push($vbl4,$var);
            }
        }

        // return $vbl4;

        if($vbl1 == "" || $vbl5 == ""){
            $str['status']=false;
            $str['message']="EXERCISE OR USER NOT FOUND";
            return $str;
        }
        else
        {
            if(count($vbl3) == 0)
            {
                $str['status']=true;
                $str['data']['exercise']=$vbl1;
                $str['message']="NO QUESTIONS TO SHOW";
                return $str;
            }
            else
            {
                $str['status']=true;
                $str['message']="ALL QUESTIONS SHOWN";
                $str['data']['exercise']=$vbl1;
                $str['data']['questions']=$vbl4;
                return $str;
            }
        }
    }

    public function give_ans(Request $request)
    {
        // return $request;

        $vbl1 = Student::find($request->user_id);
        $vbl2 = Answer::find($request->que_id);

        if(empty($vbl1) || empty($vbl2))
        {
            $str['status']=false;
            $str['message']="STUDENT OR QUESTION ID DOES NOT EXIST";
            return $str;
        }
        else
        {
            if($request->ans_no == null || $request->ans_no == "")
            {
                $str['status']=false;
                $str['message']=" MCQ NOT GIVEN";
                return $str;
            }
            else
            {
                if($request->ans_no == 1 || $request->ans_no == 2 || $request->ans_no == 3 || $request->ans_no == 4 )
                {
                    $vbl3 = new Given_Answer;
                    $vbl3->student_id = $request->user_id;
                    $vbl3->answer_id = $request->que_id;
                    $vbl3->submitted_ans = $request->ans_no;
                    $vbl3->status = true;
                    $vbl3->save();


                    $str['status']=true;
                    $str['message']="GIVEN ANSWER OK";
                    $str['data']=$vbl3;
                    return $str;
                }
                else
                {
                    $str['status']=false;
                    $str['message']="MCQ DOES NOT EXIST";
                    return $str;
                }
            }
        }

    }

    public function reset_stu(Request $request)
    {
        $vbl1 = Student::find($request->user_id);
        $vbl2 = Exercise::find($request->exe_id);

        $vbl3 = DB::table('questions')
            ->where('questions.exercise_id',$request->exe_id)
            ->join('answers','answers.question_id','=','questions.id')
            ->join('given__answers','given__answers.answer_id','=','answers.id')
            ->where('student_id',$request->user_id)
            ->select('questions.que_title','given__answers.*')
            ->get();
        // $vbl3 = json_decode($vbl3, true);

        //

        if(empty($vbl1) || empty($vbl2))
        {
            $str['status']=false;
            $str['message']="STUDENT OR EXERCISE DOES NOT EXIST";
            return $str;
        }
        else
        {
            // return $vbl3;

            if(count($vbl3) == 0)
            {
                $str['status']=true;
                $str['message']="STUDENT ALREADY RESET";
                return $str;
            }
            else
            {
                foreach ($vbl3 as $value) {
                    $vbl10 = Given_Answer::find($value->id);
                    $vbl10->delete();
                }

                $str['status']=true;
                $str['message']="STUDENT RESET DONE";
                return $str;
            }
        }
    }

    public function training()
    {
        $vbl = DB::table('questions')
            ->join('answers','answers.question_id','=','questions.id')
            ->select('questions.que_title','answers.*')
            ->inRandomOrder()
            ->get();

        // return $vbl;

        if(count($vbl) == 0)
        {
            $str['status']=false;
            $str['message']="NO QUESTIONS EXIST";
            return $str;
        }
        else
        {
            $str['status']=true;
            $str['message']="RANDOM QUESTION SHOWN";
            $str['data']=$vbl;
            return $str;

        }
    }

    public function spec_que(Request $request)
    {
        // return $request;
        $vbl = DB::table('questions')
            ->join('answers','answers.question_id','=','questions.id')
            ->where('questions.id',$request->que_id)
            ->select('questions.que_title','answers.*')
            ->get();
        // return $vbl;

        if(count($vbl) == 0)
        {
            $str['status']=false;
            $str['message']="QUESTIONS DO NOT EXIST";
            return $str;
        }
        else
        {
            $str['status']=true;
            $str['message']="SPECIFIC QUESTION SHOWN";
            $str['data']=$vbl;
            return $str;

        }
    }
}
