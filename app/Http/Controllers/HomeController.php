<?php

namespace App\Http\Controllers;

use App\Bahasa;
use App\BahasaFollow;
use App\Notifications\CommentNotification;
use App\Notifications\LikeTranslate;
use App\Report;
use App\Translate;
use App\TranslateComment;
use App\User;
use Carbon\Carbon;
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
        $terhangat = Translate::join('translate_comments', 'translate.id', 'translate_comments.translate_id')
            ->groupBy('translate_comments.translate_id')
            ->select('translate.*', DB::raw('count(*) as total_komentar'))
            ->orderBy(DB::raw('rate'), 'desc')
            ->limit(4)
            ->get();
        $bahasa = Bahasa::all();

        return view('home', compact('terpopuler', 'bahasa', 'terjemahan', 'terhangat'));
    }

    public function load()
    {
        $user = $_GET['user'];
        $tipe = $_GET['tipe'];
        $followedBahasa = [];
        $userList = [];
        if ($user && $tipe == 'bahasa') {
            $followedBahasa = BahasaFollow::where('user_id', $user)->select('*')->get()->map(function ($value) {
                return $value->bahasa_id;
            });
        }

        if ($user && $tipe == 'user') {
            $userList = DB::table('user_follow')->where('user_id', $user)->get()->map(function ($value) {
                return $value->following;
            });
        }

        $translate = (new Translate())->getWith()
            ->leftjoin('kata as dariKata', 'dariKata.id', 'translate.dari')
            ->leftjoin('kata as tujuanKata', 'tujuanKata.id', 'translate.tujuan');

        if ($user && $tipe == 'bahasa') {
            $translate = $translate->orWhereIn('dariKata.bahasa_id', $followedBahasa)
                ->orWhereIn('tujuanKata.bahasa_id', $followedBahasa);
        }

        if ($user && $tipe == 'user') {
            $translate = $translate->orWhereIn('translate.user_id', $userList);
        }

        $translate = $translate->select('translate.*')
            ->orderBy('created_at', 'desc');

        return response()->json($translate->paginate(5));
    }

    public function show($id)
    {
        if (isset($_GET['notif_id'])) {
            $notif = DB::table('notifications')->where('id', $_GET['notif_id']);
            $notif->update(['read_at' => Carbon::now()]);
        }

        if (!Auth::guest()) {
            $hasLike = Auth::user()->hasLike($id);
        } else {
            $hasLike = false;
        }

        $translate = (new Translate())->getWith()->where('id', $id)->get()[0];

        return view('translate.show', compact('translate', 'id', 'hasLike'));
    }

    public function store(Request $request, $id)
    {
        $translate = Translate::find($id);
        $comment = new TranslateComment();
        $comment->comment = $request->comment;
        $comment->user_id = Auth::user()->id;
        $comment->translate_id = $id;
        $comment->save();

        User::find($translate->user_id)->notify(new CommentNotification($request->translate_id, Auth::user()));

        return redirect('terjemahan/'.$id);
    }

    public function like(Request $request, $id)
    {
        $translate_id = $id;
        $user = Auth::user();
        $translate = Translate::find($translate_id);
        if ($user->hasLike($translate_id)) {
            $user->unlikeTranslate($translate_id);
        } else {
            $user->likeTranslate($translate_id);
            if ($translate->user_id != $user->id) {
                User::find($translate->user_id)->notify(new LikeTranslate($translate_id, User::find($translate->user_id)));
            }
        }

        return redirect('terjemahan/'.$id);
    }

    public function reportForm($id)
    {
        $translate = Translate::find($id);

        return view('report.create', compact('translate'));
    }

    public function report(Request $request, $id)
    {
        $this->validate($request, [
            'laporan' => 'required',
        ]);

        $report = new Report();
        $report->translate_id = $id;
        $report->user_id = Auth::user()->id;
        $report->laporan = $request->laporan;
        $report->save();

        return redirect('/');
    }
}
