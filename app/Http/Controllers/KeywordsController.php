<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Keywords;
use Illuminate\Http\Request;

class KeywordsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data       = Keywords::orderBy('id', 'DESC')->get();
        return view('page.keyword', compact('data'));
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
        $this->validate(
            $request,
            [
                'name'      => 'required',
            ],
        );
        $data = Keywords::create([
            'name'          => $request->name,
        ]);
        return redirect()->back()->with('success', 'Berhasil menambahkan data');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function show(Keywords $keywords)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function edit(Keywords $keywords)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Keywords $keywords)
    {
        $this->validate(
            $request,
            [
                'name'      => 'required',
            ],
        );
        $data = Keywords::find($request->id);
        $data->update([
            'name'          => $request->name,
        ]);
        return redirect()->back()->with('success', 'Berhasil memperbarui data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keywords  $keywords
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $isHaveCategory = Books::where('keyword_id', 'LIKE', '%"' . $request->id . '"%')->count();
        if ($isHaveCategory > 0) {
            return redirect()->back()->with('error', 'Data masih digunakan');
        } else {
            $data           = Keywords::find($request->id);
            $data->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data');
        }
    }
}
