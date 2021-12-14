<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Exercise;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    public function index($cat_id, $exe_id)
    {
        // return array($cat_id,$exe_id);
        // $vbl = Exercise::find($exe_id);

        // $vbl = DB::table('exercises')
        //     ->where('exercises.category_id',$cat_id)
        //     ->join('categories','categories.id','=','exercises.category_id')
        //     ->select('exercises.*', 'categories.cat_name',)
        //     // ->select('products.p_name', 'categories.c_name', 'categories.c_picture')
        //     ->get();
        // $vbl = json_decode($vbl, true);

        if(session()->get('s_uname'))
        {
            $vbl1= Category::find($cat_id);
            $vbl2 = Exercise::find($exe_id);
            return view('exercise.question.question',compact('vbl1','vbl2'));
        }
        else
            return redirect('login');
    }

    public function add_question($cat_id, $exe_id, Request $request)
    {
        // return array($cat_id,$exe_id);
        // return request()->all();
        // return "Hello from controller.";
        if(session()->get('s_uname'))
        {
            $validator = Validator::make($request->all(),[
                'q_name'=> 'required|max:50|min:10',
                'opt_1'=> 'required|max:20|min:1',
                'opt_2'=> 'required|max:20|min:1',
                'opt_3'=> 'required|max:20|min:1',
                'opt_4'=> 'required|max:20|min:1',
                'rit_ans'=> 'required|numeric|digits:1',
                'ta_input'=> 'required',
                'yt_link'=> 'required',
                'img_sol_file'=> 'required|mimes:jpeg,bmp,png,jpg|max:5120',
            ],[
                'q_name.required' => 'Question is required.',
                'q_name.max' => 'Qustion must be within 50 characters.',
                'q_name.min' => 'Question must be of 10 characters.',
                'opt_1.required' => 'Option 1 is required.',
                'opt_1.max' => 'Option 1 must be of 20 characters.',
                'opt_1.min' => 'Option 1 must be of 1 characters.',
                'opt_2.required' => 'Option 2 is required.',
                'opt_2.max' => 'Option 2 must be of 20 characters.',
                'opt_2.min' => 'Option 2 must be of 1 characters.',
                'opt_3.required' => 'Option 3 is required.',
                'opt_3.max' => 'Option 3 must be of 20 characters.',
                'opt_3.min' => 'Option 3 must be of 1 characters.',
                'opt_4.required' => 'Option 4 is required.',
                'opt_4.max' => 'Option 4 must be of 20 characters.',
                'opt_4.min' => 'Option 4 must be of 1 characters.',
                'img_sol_file.required' => 'Image Solution must be attached.',
                'img_sol_file.mimes' => 'Only Images are allowed.',
                'img_sol_file.max' => 'File must not be greater than 5 MB.',
                'yt_link.required' => 'Youtube Link is required.',
                'rit_ans' => 'Youtube Link is required.',
                'ta_input.required'=> 'Text Solution is required for the answer.',
            ]);
            if ($validator->fails())
            {
                return response()->json($validator->errors()->toArray(),422);
            }
            else
            {
                // return rand(100000000000000,999999999999999);
                $vbl3 = rand(100000000000000,999999999999999);

                // $filename = $request->img_sol_file->getClientOriginalName();
                // request()->img_sol_file->storeAs('public/profile_pic',$filename);

                // $filename = $request->img_sol_file->getClientOriginalName();
                $vbl4 = File::extension($request->img_sol_file->getClientOriginalName());
                request()->img_sol_file->storeAs('public/image_solutions',$vbl3.".".$vbl4);

                $vbl1 = new Question;
                $vbl1->que_title = $request->q_name;
                $vbl1->exercise_id = $exe_id;
                $vbl1->save();

                $vbl2 = new Answer;
                $vbl2->question_id = $vbl1->id;
                $vbl2->option_1 = $request->opt_1;
                $vbl2->option_2 = $request->opt_2;
                $vbl2->option_3 = $request->opt_3;
                $vbl2->option_4 = $request->opt_4;
                $vbl2->right_ans = $request->rit_ans;
                $vbl2->text_sol = $request->ta_input;
                $vbl2->yt_link = $request->yt_link;
                $vbl2->img_sol = $vbl3.".".$vbl4;

                $vbl2->save();
            }
        }
        else
            return redirect('login');
    }

    public function show_questions($cat_id,$exe_id)
    {
        // return array($cat_id,$exe_id);
        // return $vbl = School::all();
        // $vbl = Question::where('exercise_id',$exe_id)->get();
        // return $vbl;
        if(session()->get('s_uname'))
        {
            $vbl = DB::table('questions')
            ->where('questions.exercise_id',$exe_id)
            ->join('answers','answers.question_id','=','questions.id')
            ->select('questions.*', 'answers.*',)
            // ->select('products.p_name', 'categories.c_name', 'categories.c_picture')
            ->get();
        $vbl = json_decode($vbl, true);

        return datatables()->of($vbl)->addColumn('t_sol', function ($row) {

            $btn = '<button class="open_t_sol button text-white bg-theme-11 shadow-md mr-2" value="' . $row['id'] . '">Open</button>';
            return $btn;

        })->addColumn('i_sol', function ($row) {

            $btn = '<button class="open_i_sol button text-white bg-theme-11 shadow-md mr-2" value="' . $row['id'] . '">Open</button>';
            return $btn;

        })->addColumn('ut_link', function ($row) {

            $btn = '<a href="'.$row['yt_link'].'" class="button text-white bg-theme-11 shadow-md mr-2">Open</a>';
            return $btn;

        })->addColumn('actions', function ($row) {

            $btn = '<button class="update_que button text-white bg-theme-3 shadow-md mr-2" value="' . $row['id'] . '">Update</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $btn = $btn . '<button class="remove_que button text-white bg-theme-1 shadow-md mr-2" value="' . $row['id'] . '">Remove</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            return $btn;

        //below when true it makes the simple data html things
        })->rawColumns(['t_sol','i_sol','ut_link','actions'])->make(true);
        }
        else
            return redirect('login');
    }

    public function show_question($cat_id,$exe_id, Request $request)
    {
        // echo $request->id;

        if(session()->get('s_uname'))
        {
            $vbl = Answer::where('question_id',$request->id)->first();
            $vbl->img_sol=asset('storage/app/public/image_solutions/'.$vbl->img_sol);
            return $vbl;
        }
        else
            return redirect('login');
    }

    public function update_question($cat_id, $exe_id, Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return $request->all();
        $validator = Validator::make($request->all(),[
            'q_name'=> 'required|max:50|min:10',
            'opt_1'=> 'required|max:20|min:1',
            'opt_2'=> 'required|max:20|min:1',
            'opt_3'=> 'required|max:20|min:1',
            'opt_4'=> 'required|max:20|min:1',
            'rit_ans'=> 'required|numeric|digits:1',
            'ta_input'=> 'required',
            'yt_link'=> 'required',
            'img_sol_file'=> 'required|mimes:jpeg,bmp,png,jpg|max:5120',
        ],[
            'q_name.required' => 'Question is required.',
            'q_name.max' => 'Qustion must be within 50 characters.',
            'q_name.min' => 'Question must be of 10 characters.',
            'opt_1.required' => 'Option 1 is required.',
            'opt_1.max' => 'Option 1 must be of 20 characters.',
            'opt_1.min' => 'Option 1 must be of 1 characters.',
            'opt_2.required' => 'Option 2 is required.',
            'opt_2.max' => 'Option 2 must be of 20 characters.',
            'opt_2.min' => 'Option 2 must be of 1 characters.',
            'opt_3.required' => 'Option 3 is required.',
            'opt_3.max' => 'Option 3 must be of 20 characters.',
            'opt_3.min' => 'Option 3 must be of 1 characters.',
            'opt_4.required' => 'Option 4 is required.',
            'opt_4.max' => 'Option 4 must be of 20 characters.',
            'opt_4.min' => 'Option 4 must be of 1 characters.',
            'img_sol_file.required' => 'Image Solution must be attached.',
            'img_sol_file.mimes' => 'Only Images are allowed.',
            'img_sol_file.max' => 'File must not be greater than 5 MB.',
            'yt_link.required' => 'Youtube Link is required.',
            'rit_ans' => 'Youtube Link is required.',
            'ta_input.required'=> 'Text Solution is required for the answer.',
        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors()->toArray(),422);
        }
        else
        {
            // return rand(100000000000000,999999999999999);
            $vbl3 = rand(100000000000000,999999999999999);

            // $filename = $request->img_sol_file->getClientOriginalName();
            // request()->img_sol_file->storeAs('public/profile_pic',$filename);

            // $filename = $request->img_sol_file->getClientOriginalName();
            $vbl4 = File::extension($request->img_sol_file->getClientOriginalName());
            request()->img_sol_file->storeAs('public/image_solutions',$vbl3.".".$vbl4);

            $vbl1 = Question::find($request->id);
            $vbl1->que_title = $request->q_name;
            $vbl1->exercise_id = $exe_id;
            $vbl1->update();

            $vbl2 = Answer::find($request->id);
            $vbl2->question_id = $vbl1->id;
            $vbl2->option_1 = $request->opt_1;
            $vbl2->option_2 = $request->opt_2;
            $vbl2->option_3 = $request->opt_3;
            $vbl2->option_4 = $request->opt_4;
            $vbl2->right_ans = $request->rit_ans;
            $vbl2->text_sol = $request->ta_input;
            $vbl2->yt_link = $request->yt_link;
            $vbl2->img_sol = $vbl3.".".$vbl4;

            $vbl2->update();
        }
        }
        else
            return redirect('login');
    }

    public function del_question($cat_id, $exe_id, Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return "hello";
        // return $request->id;
        $vbl = Answer::find($request->id);
        $vbl->delete();
        $vbl = Question::find($request->id);
        $vbl->delete();
        }
        else
            return redirect('login');
    }

    public function show_question_det($cat_id,$exe_id, Request $request)
    {
        if(session()->get('s_uname'))
        {
            // echo $request->id;
        // return $request->id;
        $vbl = DB::table('questions')
        ->where('questions.id',$request->id)
        ->join('answers','answers.question_id','=','questions.id')
        ->select('questions.*', 'answers.*',)
        // ->select('products.p_name', 'categories.c_name', 'categories.c_picture')
        ->first();
    // $vbl = json_decode($vbl, true);
    return $vbl;
        }
        else
            return redirect('login');
    }
}
