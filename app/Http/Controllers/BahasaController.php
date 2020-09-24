<?php

namespace App\Http\Controllers;

use App\Bahasa;
use Auth;
use Illuminate\Http\Request;

class BahasaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bahasa = new Bahasa();
        if (isset($_GET['search'])) {
            $bahasa = $bahasa->where('nama', 'LIKE', "%{$_GET['search']}%")
                ->orWhere('daerah', 'LIKE', "%{$_GET['search']}%");
        }
        $bahasa = $bahasa->get();

        return view('bahasa.index', compact('bahasa'));
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Model\Bahasa $bahasa
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Bahasa $bahasa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Model\Bahasa $bahasa
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Bahasa $bahasa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Model\Bahasa        $bahasa
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bahasa $bahasa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Model\Bahasa $bahasa
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bahasa $bahasa)
    {
        //
    }

    public function follow($id)
    {
        if (Auth::guest()) {
            abort(404);
        }
        $user = Auth::user()->follow($id);

        return redirect()->back();
    }

    public function unfollow($id)
    {
        if (Auth::guest()) {
            abort(404);
        }
        $user = Auth::user()->unfollow($id);

        return redirect()->back();
    }
}
