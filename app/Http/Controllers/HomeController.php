<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Translate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function load()
    {
        $translate = Translate::with(['user',
                'dariKata' => function ($child) {
                        return $child->with(["bahasa"]);
                    },
                'tujuanKata' => function ($child) {
                        return $child->with(["bahasa"]);
                    },
            ])->orderBy('created_at','desc')->paginate(20);
        return response()->json($translate);
    }
}
