<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\School;
use App\Models\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $vbl1 = School::all();
        $vbl1 = sizeof($vbl1);
        $vbl2 = Student::all();
        $vbl2 = sizeof($vbl2);
        $vbl3 = Exercise::all();
        $vbl3 = sizeof($vbl3);
        $vbl4 = array($vbl1,$vbl2,$vbl3);
        return view('dashboard',compact('vbl4'));
    }
}
