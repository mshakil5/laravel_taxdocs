<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HowWeWork;

class FrontendController extends Controller
{
    public function index()
    {
        return view('frontend.index');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function getWorkDetails($id)
    {
        $data = HowWeWork::where('id',$id)->first();
        return view('frontend.workdtl', compact('data'));
    }
    public function privacy()
    {
        return view('frontend.privacy');
    }
    public function terms()
    {
        return view('frontend.terms');
    }
}
