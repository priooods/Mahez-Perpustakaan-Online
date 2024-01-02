<?php

namespace App\Http\Controllers;

use App\Models\category\MCategoryTab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    protected $category;
    protected $controller;
    public function __construct(MCategoryTab $category, Controller $controller) {
        $this->controller = $controller;
        $this->category = $category;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'tableTitle' => 'Data Category Buku',
            'tableDesc' => 'Semua category yang ada dapat kamu lihat disini',
            'usefilter' => false,
            'column' => [
                auth()->user()->m_access_tabs_id == 1 
                    ? [ 'key' => 'creator', 'title' => "Dibuat Oleh", 'type' => 'text', 'align' => 'start' ] 
                    : null,
                [ 'key' => 'title', 'title' => "Nama Category", 'type' => 'text', 'align' => 'start' ],
                [ 'key' => 'action', 'title' => "Action", 'type' => 'action', 'attr' => [
                    [ 'key' => 'update', 'title' => 'UPDATED', 'actionUrl' => 'category/' ],
                    [ 'key' => 'delete', 'title' => 'DELETED', 'actionUrl' => 'category/delete/' ]
                ]],
            ],
            'data' => $this->category->filter(auth()->user())->with('user')->get()
        ];
        return view('dashboard.category.list',['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.category.form',['form' => []]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        if($validasi = $this->controller->validating($request,
            [
                'title' => 'required',
            ]
        ,'dashboard.category.form', 'form', []
        )){
            return $validasi;
        }
        try {
            DB::beginTransaction();
            $request['user_tabs_id'] = auth()->user()->id;
            $this->category->create($request->all());
            DB::commit();
            return redirect('category');
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('dashboard.category.form', 
                ['throwable' => $th->getMessage(), 'form' => []]);
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
            'detail' => $this->category->find($id),
            'update' => [
                'id' => $id,
                'title' => 'Update Form Category',
                'description' => 'Pastikan semua form dilengkapi untuk update data'
            ]
        ];
        return view('dashboard.category.form',['form' => $form]);
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
    public function categoryupdate(Request $request, $id)
    {
        if($validasi = $this->controller->validating($request,
            [
                'title' => 'required',
            ]
        ,'dashboard.category.form', 'form', []
        )){
            return $validasi;
        }

        try {
            DB::beginTransaction();
            $category = $this->category->where('id',$id)->first();
            $category->update([
                    'title'=>$request->input('title'),
                ]);
            DB::commit();
            return redirect('category');
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
            $this->category->where('id',$id)->delete();
            DB::commit();
            return redirect('category');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect('category');
        }
    }
}
