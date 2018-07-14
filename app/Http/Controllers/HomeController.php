<?php

namespace App\Http\Controllers;

use App\BahasaFollow;
use App\Translate;
use App\Bahasa;
use App\TranslateComment;
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
        $terpopuler = Translate::groupBy('user_id')
            ->select('translate.*', DB::raw('count(*) as total_kontribusi'))
            ->orderBy(DB::raw('count(*)'), 'desc')
            ->limit(4)
            ->get();
        $terjemahan = Translate::orderBy(DB::raw('rate'), 'desc')
            ->limit(4)
            ->get();
        $terhangat = Translate::join('translate_comments','translate.id', 'translate_comments.translate_id')
            ->groupBy('translate_comments.translate_id')
            ->select('translate.*', DB::raw('count(*) as total_komentar'))
            ->orderBy(DB::raw('rate'), 'desc')
            ->limit(4)
            ->get();
        $bahasa = Bahasa::all();
        return view('home', compact('terpopuler','bahasa', 'terjemahan', 'terhangat'));
    }

    public function load()
    {
        $user = $_GET['user'];
        $tipe = $_GET['tipe'];
        $followedBahasa = [];
        if($user && $tipe == "bahasa") {
            $followedBahasa = BahasaFollow::where('user_id', $user)->select('*')->get()->map(function($value){ return $value->bahasa_id; });
        }
        $translate = (new Translate)->getWith()
            ->leftjoin("kata as dariKata", "dariKata.id", 'translate.dari')
            ->leftjoin('kata as tujuanKata', 'tujuanKata.id', 'translate.tujuan');

        if($user && $tipe == "bahasa") {
            $translate = $translate->WhereIn('dariKata.bahasa_id', $followedBahasa)
                ->orWhereIn('tujuanKata.bahasa_id', $followedBahasa);
        }

        $translate = $translate->select('translate.*')
            ->orderBy('created_at','desc');

        return response()->json($translate->paginate(5));
    }

    public function show($id)
    {
        if(!Auth::guest()) {
            $hasLike = Auth::user()->hasLike($id);
        } else {
            $hasLike = false;
        }

        $translate = (new Translate)->getWith()->where('id', $id)->get()[0];
        return view('translate.show', compact('translate', 'id', 'hasLike'));
    }

    public function store(Request $request, $id)
    {
        $comment = new TranslateComment;
        $comment->comment = $request->comment;
        $comment->user_id = Auth::user()->id;
        $comment->translate_id = $id;
        $comment->save();

        return redirect("terjemahan/".$id);
    }

    public function like(Request $request, $id)
    {
        $translate_id = $id;
        $user = Auth::user();
        if($user->hasLike($translate_id)) {
            $user->unlikeTranslate($translate_id);
        } else {
            $user->likeTranslate($translate_id);
        }
        return redirect('terjemahan/'.$id);
    }
}
