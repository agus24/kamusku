<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Translate;
use Illuminate\Http\Request;

class TranslateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $translates = (new Translate);
        if(isset($_GET['search']))
        {
            $search = $_GET['search'];
            $translates = $translates->join('kata as dariKata', 'dariKata.id', 'translate.dari')
                ->join('kata as tujuanKata', 'tujuanKata.id', 'translate.tujuan')
                ->join('bahasas as dariBahasa', 'dariBahasa.id', 'dariKata.bahasa_id')
                ->join('bahasas as tujuanBahasa', 'tujuanBahasa.id', 'tujuanKata.bahasa_id')
                ->select('translate.*')
                ->orWhere('dariKata.kata', 'like', "%$search%")
                ->orWhere('tujuanKata.kata', 'like', "%$search%")
                ->orWhere('dariBahasa.nama', 'like', "%$search%")
                ->orWhere('tujuanBahasa.nama', 'like', "%$search%");
        }

        $translates = $translates->paginate(25);
        return view('vendor.voyager.translate.index', compact('translates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $translate = Translate::find($id);
        $translate->delete();
        return redirect()->back();
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
}
