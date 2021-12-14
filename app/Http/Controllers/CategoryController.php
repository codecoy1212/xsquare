<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function add_category(Request $request)
    {
        if(session()->get('s_uname'))
        {
            // return request();
        // return "Hello from controller.";
        $validator = Validator::make($request->all(),[
            'cat_name'=> 'required|max:30|min:5',
        ],[
            'cat_name.required' => 'Category name is required.',
            'cat_name.max' => 'Category name must be within 30 characters.',
            'cat_name.min' => 'Category name must be of 5 characters.',
        ]);
        if ($validator->fails())
        {
            return response()->json($validator->errors()->toArray(),422);
        }
        else
        {
            $vbl = new Category;
            $vbl->cat_name = $request->cat_name;
            $vbl->save();
        }
        }
        else
            return redirect('login');
    }

    public function show_categories()
    {
        if(session()->get('s_uname'))
        {
            $vbl = Category::all();
            return $vbl;
        }
        else
            return redirect('login');
    }

    // public function show_category(Request $request)
    // {
    //     // return $request;
    //     $vbl = Category::find($request->id);
    //     return $vbl;
    // }

    // public function update_category(Request $request)
    // {
    //     // return $request;
    //     $validator = Validator::make($request->all(),[
    //         'cat_name'=> 'required|max:30|min:5',
    //     ],[
    //         'cat_name.required' => 'Category name is required.',
    //         'cat_name.max' => 'Category name must be within 30 characters.',
    //         'cat_name.min' => 'Category name must be of 5 characters.',
    //     ]);
    //     if ($validator->fails())
    //     {
    //         return response()->json($validator->errors()->toArray(),422);
    //     }
    //     else
    //     {
    //         $vbl = Category::find($request->id);
    //         $vbl->cat_name = $request->cat_name;
    //         $vbl->update();
    //     }
    // }

    // public function del_category(Request $request)
    // {
    //     // return $request->id;
    //     $vbl = Category::find($request->id);
    //     $vbl->delete();
    // }
}
