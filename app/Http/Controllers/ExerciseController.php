<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Exercise;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExerciseController extends Controller
{
    public function index()
    {
        return view('exercise');
    }

    public function specific($id)
    {
        // return $id;
        $vbl = Category::find($id);
        return view('exercise.specific',compact('vbl'));
    }

    public function add_exercise($cat_id, Request $request)
    {
        // return $id;
        // return "Hello from controller.";
        $validator = Validator::make($request->all(),[
            'exe_name'=> 'required|max:30|min:5',
        ],[
            'exe_name.required' => 'Exercise name is required.',
            'exe_name.max' => 'Exercise name must be within 30 characters.',
            'exe_name.min' => 'Exercise name must be of 5 characters.',
        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors()->toArray(),422);
        }
        else
        {
            $vbl = new Exercise;
            $vbl->exe_name = $request->exe_name;
            $vbl->category_id = $cat_id;
            $vbl->save();
        }
    }

    public function show_exercises($cat_id)
    {
        // return $cat_id;
        // return $vbl = School::all();
        $vbl = Exercise::where('category_id',$cat_id);

        return datatables()->of($vbl)->addColumn('exercise_link', function ($row) {

            $btn = '<a href="'. $row['category_id'] .'/exercise/'. $row['id'] .'/questions" class="button text-white bg-theme-11 shadow-md mr-2">'. $row['exe_name'].'</a>';
            return $btn;

        })->addColumn('actions', function ($row) {

            $btn = '<button class="update_exe button text-white bg-theme-3 shadow-md mr-2" value="' . $row['id'] . '">Update</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $btn = $btn . '<button class="remove_exe button text-white bg-theme-1 shadow-md mr-2" value="' . $row['id'] . '">Remove</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            return $btn;

        //below when true it makes the simple data html things
        })->rawColumns(['exercise_link', 'actions'])->make(true);



    }

    public function show_exercise(Request $request)
    {
        // return $cat_id;
        $vbl = Exercise::find($request->id);
        return $vbl;
    }

    public function update_exercise(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(),[
            'exe_name'=> 'required|max:30|min:5',
        ],[
            'exe_name.required' => 'Exercise name is required.',
            'exe_name.max' => 'Exercise name must be within 30 characters.',
            'exe_name.min' => 'Exercise name must be of 5 characters.',
        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors()->toArray(),422);
        }
        else
        {
            $vbl = Exercise::find($request->id);
            $vbl->exe_name = $request->exe_name;
            $vbl->update();
        }
    }

    public function del_exercise(Request $request)
    {
        // return $request->id;

        $vbl = Question::where('exercise_id',$request->id)->get();
        foreach ($vbl as $value1) {
            $vbl2 = Answer::where('question_id',$value1->id)->get();
            foreach ($vbl2 as $value2) {
                $value2->delete();
            }
            $value1->delete();
        }

        $vbl = Exercise::find($request->id);
        $vbl->delete();
    }
}
