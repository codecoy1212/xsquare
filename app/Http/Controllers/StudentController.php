<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        return view('student');
    }

    public function show_students()
    {
        // $vbl = Student::all();

        $vbl2 = DB::table('students')
            ->join('schools','schools.id','=','students.school_id')
            ->select('students.*','schools.school_name')
            ->get();
        $vbl2 = json_decode($vbl2, true);

        return datatables()->of($vbl2)->addColumn('student_pic', function ($row) {

            $btn = '<div class="image-cropper"> <img style="  display: inline; margin: 0 auto; height: 100%; width: auto;"
            class="rounded" src="'.asset('storage/app/public/profile_pictures').'/'.$row['stu_pic'] .'" alt="hello"> </div>';
            return $btn;

        })->addColumn('actions', function ($row) {

            $btn = '<button class="remove_stu button text-white bg-theme-1 shadow-md mr-2" value="' . $row['id'] . '">Remove</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
            return $btn;

        })->rawColumns(['student_pic','actions'])->make(true);
    }

    public function del_student(Request $request)
    {
        // return $request->id;
        $vbl = Student::find($request->id);
        $vbl->delete();
    }
}
