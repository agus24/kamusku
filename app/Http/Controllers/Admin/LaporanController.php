<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Report;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laporan = Report::orderBy('reports.created_at', 'desc');
        if (isset($_GET['search'])) {
            $laporan = $laporan->leftJoin('translate', 'translate.id', 'reports.translate_id')
                ->leftJoin('kata as dariKata', 'dariKata.id', 'translate.dari')
                ->leftJoin('kata as tujuanKata', 'tujuanKata.id', 'translate.tujuan')
                ->leftJoin('bahasas as bahasaDari', 'bahasaDari.id', 'dariKata.bahasa_id')
                ->leftJoin('bahasas as bahasaTujuan', 'bahasaTujuan.id', 'tujuanKata.bahasa_id')
                ->leftJoin('users', 'users.id', 'reports.user_id');

            $laporan = $laporan->orWhere('dariKata.kata', 'like', "%{$_GET['search']}%")
                ->orWhere('tujuanKata.kata', 'like', "%{$_GET['search']}%")
                ->orWhere('bahasaDari.nama', 'like', "%{$_GET['search']}%")
                ->orWhere('bahasaTujuan.nama', 'like', "%{$_GET['search']}%")
                ->orWhere('users.name', 'like', "%{$_GET['search']}%");
        }
        $laporan = $laporan->select('reports.*')->paginate(15);

        return view('vendor.voyager.laporan.index', compact('laporan'));
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
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
