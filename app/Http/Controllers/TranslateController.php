<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bahasa;
use App\Katum as Kata;
use App\Translate;
use Auth;

class TranslateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bahasa = Bahasa::all();
        $kata = Kata::where('bahasa_id', 1)->select('id','kata as label', 'kata as value')->get();
        return view('translate.index', compact('bahasa', 'kata'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($kata_id)
    {
        $bahasa = Bahasa::all();
        $kata = Kata::find($kata_id);
        return view('translate.create', compact('bahasa', 'kata'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $kata_id)
    {
        $this->validate($request, [
            "kata" => "required",
            "ke_bahasa" => "required|integer|different:bahasa_asal",
            "bahasa_asal" => "required|integer",
            "translate" => "required"
        ]);
        $kata = new Kata;
        $kata->bahasa_id = $request->ke_bahasa;
        $kata->kata = $request->translate;
        $kata->save();
        Translate::create([
            "dari" => $kata_id,
            "tujuan" => $kata->id,
            "user_id" => Auth::user()->id
        ]);

        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getTranslateData(Request $request)
    {
        $status = 200;
        $data = $request->params;
        $translate = new Translate;
        $result = $translate->with('tujuanKata', 'dariKata', 'user')
            ->join('kata as a', 'a.id','dari')
            ->join('kata as b', 'b.id','tujuan')
            ->where('a.bahasa_id', $data['dari'])
            ->where('b.bahasa_id', $data['ke'])
            ->where('a.kata',"like", "%".$data['kata']."%")
            ->orWhere('b.kata', "like", "%".$data['kata']."%")
            ->orderBy('rate','desc')
            ->select('translate.*')
            ->get();

        if(!$result) {
            $status = 504;
        }

        return response()->json($result, $status);
    }
}
