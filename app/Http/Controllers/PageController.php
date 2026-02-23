<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home');
    }

    public function features()
    {
        return view('pages.features');
    }

    public function pricing()
    {
        return view('pages.pricing');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function demo()
    {
        return view('pages.demo');
    }

    public function ocr()
    {
        return view('pages.ocr');
    }
}
