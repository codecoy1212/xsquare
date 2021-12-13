<?php

namespace App\Http\Controllers;

use App\Models\School;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\RequestStack;

class SchoolController extends Controller
{
    public function index()
    {
        return view('school');
    }

    public function add_school(Request $request)
    {
        // return request();
        // return "Hello from controller.";
        $validator = Validator::make($request->all(),[
            'school_name'=> 'required|max:40|min:10',
            'school_code' => 'required|digits:4|numeric',
        ],[
            'school_name.required' => 'School name is required.',
            'school_name.max' => 'School name must be within 40 characters.',
            'school_name.min' => 'School name must be of 10 characters.',
            'school_code.required' => 'School code is required.',
            'school_code.digits' => 'School code can only be of 4 digits.',
            'school_code.numeric' => 'School code can only be numeric.',
        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors()->toArray(),422);
        }
        else
        {
            $vbl = new School;
            $vbl->school_name = $request->school_name;
            $vbl->school_code = $request->school_code;
            $vbl->save();
        }
    }

    public function show_schools()
    {
        // return $vbl = School::all();
        $vbl = School::all();

        return datatables()->of($vbl)->addColumn('actions', function ($row) {

            $btn = '<button class="update_sch button text-white bg-theme-3 shadow-md mr-2" value="' . $row['id'] . '">Update</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            $btn = $btn . '<button class="remove_sch button text-white bg-theme-1 shadow-md mr-2" value="' . $row['id'] . '">Remove</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            return $btn;

        })->rawColumns(['actions'])->make(true);
    }

    public function show_school(Request $request)
    {
        // return $request;
        $vbl = School::find($request->id);
        return $vbl;
    }

    public function update_school(Request $request)
    {
        // return $request;
        $validator = Validator::make($request->all(),[
            'school_name'=> 'required|max:40|min:10',
            'school_code' => 'required|digits:4|numeric',
        ],[
            'school_name.required' => 'School name is required.',
            'school_name.max' => 'School name must be within 40 characters.',
            'school_name.min' => 'School name must be of 10 characters.',
            'school_code.required' => 'School code is required.',
            'school_code.digits' => 'School code can only be of 4 digits.',
            'school_code.numeric' => 'School code can only be numeric.',
        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors()->toArray(),422);
        }
        else
        {
            $vbl = School::find($request->id);
            $vbl->school_name = $request->school_name;
            $vbl->school_code = $request->school_code;
            $vbl->update();
        }
    }

    public function del_school(Request $request)
    {
        // return $request->id;
        $vbl = School::find($request->id);
        $vbl->delete();
    }
}