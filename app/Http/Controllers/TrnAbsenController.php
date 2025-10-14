<?php

namespace App\Http\Controllers;

use App\Models\TrnAbsen;
use Illuminate\Http\Request;

class TrnAbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return response()->json(TrnAbsen::all());
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(TrnAbsen $trnAbsen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TrnAbsen $trnAbsen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TrnAbsen $trnAbsen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TrnAbsen $trnAbsen)
    {
        //
    }
}
