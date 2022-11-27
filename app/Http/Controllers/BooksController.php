<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Category;
use App\Models\Keywords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data       = Books::orderBy('id', 'DESC');

        // FILTER
        $request->title         == '' ? '' : $data = $data->where('title', 'LIKE', '%' . $request->title . '%');
        $request->description   == '' ? '' : $data = $data->where('description', 'LIKE', '%' . $request->description . '%');
        $request->price         == '' ? '' : $data = $data->where('price', 'LIKE', '%' . $request->price . '%');
        $request->stock         == '' ? '' : $data = $data->where('stock', 'LIKE', '%' . $request->stock . '%');

        $data       = $data->get();
        $category   = Category::orderBy('name', 'ASC')->get();
        $keyword    = Keywords::orderBy('name', 'ASC')->get();
        return view('page.books', compact('category', 'keyword', 'data'));
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
                'title'         => 'required',
                'description'   => 'required',
                'category_id'   => 'required',
                'keyword_id'    => 'required',
                'price'         => 'required',
                'stock'         => 'required',
                'publisher'     => 'required',
            ],
        );
        $data = Books::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'category_id'   => json_encode($request->category_id),
            'keyword_id'    => json_encode($request->keyword_id),
            'price'         => str_replace('.', '', $request->price),
            'stock'         => str_replace('.', '', $request->stock),
            'publisher'     => $request->publisher,
        ]);
        return redirect()->back()->with('success', 'Berhasil menambahkan data');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate(
            $request,
            [
                'title'         => 'required',
                'description'   => 'required',
                'category_id'   => 'required',
                'keyword_id'    => 'required',
                'price'         => 'required',
                'stock'         => 'required',
                'publisher'     => 'required',
            ],
        );
        $data = Books::find($request->id);
        $data->update([
            'title'         => $request->title,
            'description'   => $request->description,
            'category_id'   => json_encode($request->category_id),
            'keyword_id'    => json_encode($request->keyword_id),
            'price'         => str_replace('.', '', $request->price),
            'stock'         => str_replace('.', '', $request->stock),
            'publisher'     => $request->publisher,
        ]);
        return redirect()->back()->with('success', 'Berhasil memperbarui data');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Books  $books
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $data = Books::find($request->id);
        $data->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }
    public function destroySelected(Request $request)
    {
        if (isset($request->id_books)) {
            DB::table('books')->whereIn('id', $request->id_books)->delete();
            return redirect()->back()->with('success', 'Berhasil menghapus data terpilih');
        } else {
            return redirect()->back()->with('error', 'Belum ada data yang dipilih');
        }
    }
}
