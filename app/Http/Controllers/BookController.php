<?php

namespace App\Http\Controllers;

use App\Exports\BookExport;
use App\Models\book\TBookTab;
use App\Models\category\MCategoryTab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class BookController extends Controller
{
    protected $book;
    protected $category;
    protected $controller;
    public function __construct(TBookTab $book, MCategoryTab $category, Controller $controller) {
        $this->book = $book;
        $this->controller = $controller;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $book = $this->book->filter(auth()->user())
                ->where('m_category_tabs_id','like','%'.$request->filter.'%')
                ->with('user','category')->get();
        $data = [
            'tableTitle' => 'Data Buku',
            'tableDesc' => 'Semua buku yang ada dapat kamu lihat disini',
            'usefilter' => true,
            'excel' => [
                'show' => true,
                'url' => 'book/excel'
            ],
            'filtering' => [
                'action' => 'book?'.$request,
                'filterOptions' => $this->category->all()
            ],
            'column' => [
                auth()->user()->m_access_tabs_id == 1 
                    ? [ 'key' => 'creator', 'title' => "Dibuat Oleh", 'type' => 'text', 'align' => 'start' ] 
                    : null,
                [ 'key' => 'title', 'title' => "Nama Buku", 'type' => 'text', 'align' => 'start' ],
                [ 'key' => 'detail_category', 'title' => "Kategori", 'type' => 'text', 'align' => 'start' ],
                [ 'key' => 'description', 'title' => "Deskripsi", 'type' => 'text', 'align' => 'start' ],
                [ 'key' => 'count', 'title' => "Jumlah", 'type' => 'number', 'align' => 'center' ],
                [ 'key' => 'book_file', 'title' => "Ebook", 'type' => 'action', 'align' => 'center',
                    'attr' => [
                        [ 'key' => 'download', 'title' => 'Download', 'actionUrl' => 'book/download/ebook/' ],
                    ]
                ],
                [ 'key' => 'book_cover', 'title' => "Cover Buku", 'type' => 'action', 'align' => 'center',
                    'attr' => [
                            [ 'key' => 'download', 'title' => 'Download', 'actionUrl' => 'book/download/cover/' ],
                        ]    
                ],
                [ 'key' => 'action', 'title' => "Action", 'type' => 'action', 'attr' => [
                    [ 'key' => 'update', 'title' => 'UPDATED', 'actionUrl' => 'book/' ],
                    [ 'key' => 'delete', 'title' => 'DELETED', 'actionUrl' => 'book/delete/' ]
                ]],
            ],
            'data' => $book
        ];
        return view('dashboard.books.list',['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $form = [
            'category' => $this->category->get()
        ];
        return view('dashboard.books.form',['form' => $form]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = [
            'category' => $this->category->get()
        ];
        if($validasi = $this->controller->validating($request,
            [
                'title' => 'required',
                'm_category_tabs_id' => 'required',
                'count' => 'required',
                'description' => 'required',
                'book_file' => 'required',
                'book_cover' => 'required',
            ]
        ,'dashboard.books.form', 'form', $form
        )){
            return $validasi;
        }
        try {
            DB::beginTransaction();
            $request['user_tabs_id'] = auth()->user()->id;
            $book = $this->book->create($request->all());
            if ($request->hasFile('book_file')) {
                $file = $request->file('book_file');
                $filename = auth()->user()->id . '_' . $file->getClientOriginalName();
                $file->move(public_path('file'), $filename);
                $book->update(['book_file' =>  $filename]);
            }
            if ($request->hasFile('book_cover')) {
                $file = $request->file('book_cover');
                $filename = auth()->user()->id . '_' . $file->getClientOriginalName();
                $file->move(public_path('file'), $filename);
                $book->update(['book_cover' =>  $filename]);
            }
            DB::commit();
            return redirect('book');
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('dashboard.books.form', ['throwable' => $th->getMessage(), 'form' => $form]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $form = [
            'category' => $this->category->get(),
            'detail' => $this->book->find($id),
            'update' => [
                'id' => $id,
                'title' => 'Update Form Buku',
                'description' => 'Pastikan semua form dilengkapi untuk update data'
            ]
        ];
        return view('dashboard.books.form',['form' => $form]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($type,$id) : BinaryFileResponse
    {
        $book = $this->book->where('id',$id)->first();
        return response()->download(public_path($type === 'cover' 
            ? 'file/'.$book->book_cover : 'file/'.$book->book_file));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bookupdate(Request $request, $id)
    {
        $form = [
            'category' => $this->category->get(),
            'detail' => $this->book->find($id),
            'update' => [
                'id' => $id,
                'title' => 'Update Form Buku',
                'description' => 'Pastikan semua form dilengkapi untuk update data'
            ]
        ];
        if($validasi = $this->controller->validating($request,
            [
                'title' => 'required',
                'm_category_tabs_id' => 'required',
                'count' => 'required',
                'description' => 'required',
            ]
        ,'dashboard.books.form', 'form', $form
        )){
            return $validasi;
        }

        try {
            DB::beginTransaction();
            $book = $this->book->where('id',$id)->first();
            $book->update([
                    'title'=>$request->input('title'),
                    'm_category_tabs_id'=>$request->input('m_category_tabs_id'),
                    'count'=>$request->input('count'),
                    'description'=>$request->input('description'),
                ]);
            if ($request->hasFile('book_file')) {
                $file = $request->file('book_file');
                $filename = auth()->user()->id . '_' . $file->getClientOriginalName();
                unlink(public_path('file/'.$book->book_file));
                $file->move(public_path('file'), $filename);
                $book->update(['book_file' =>  $filename]);
            }
            if ($request->hasFile('book_cover')) {
                $file = $request->file('book_cover');
                $filename = auth()->user()->id . '_' . $file->getClientOriginalName();
                unlink(public_path('file/'.$book->book_cover));
                $file->move(public_path('file'), $filename);
                $book->update(['book_cover' =>  $filename]);
            }
            DB::commit();
            return redirect('book');
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        try {
            DB::beginTransaction();
            $this->book->where('id',$id)->delete();
            DB::commit();
            return redirect('book');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('book');
        }
    }

    public function exportExcel(){
        
        return Excel::download(new BookExport(auth()->user()->m_access_tabs_id, auth()->user()->user_tabs_id),'book.xlsx');
    }
}
