<?php

namespace App\Http\Controllers;

use App\BahasaFollow;
use App\Translate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $user = $_GET['user'];
        $followedBahasa = [];
        if($user) {
            $followedBahasa = BahasaFollow::where('user_id', $user)->select('*')->get()->map(function($value){ return $value->bahasa_id; });
        }
        $translate = (new Translate)->getWith()
            ->leftjoin("kata as dariKata", "dariKata.id", 'translate.dari')
            ->leftjoin('kata as tujuanKata', 'tujuanKata.id', 'translate.tujuan');

        if($user && count($followedBahasa) != 0) {
            $translate = $translate->WhereIn('dariKata.bahasa_id', $followedBahasa)
                ->orWhereIn('tujuanKata.bahasa_id', $followedBahasa);
        }

        $translate = $translate->select('translate.*')
            ->orderBy('created_at','desc')->paginate(5);
        return response()->json($translate);
    }
}
