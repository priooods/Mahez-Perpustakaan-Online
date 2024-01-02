<?php

namespace App\Http\Controllers;

use App\Models\UserTab;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    protected $user;
    protected $controller;
    public function __construct(UserTab $user, Controller $controller) {
        $this->user = $user;
        $this->controller = $controller;
    }

    public function viewLogin(){
        return view('form.login');
    }

    public function login(Request $request){
        if($validasi = $this->controller->validating($request,[
            'email' => 'required',
            'password' => 'required',
        ],'form.login')){
            return $validasi;
        }

        $response = $this->controller->responses('Failure',401,null,[
                "type" => "danger",
                "title" => "Form tidak valid",
                "color" => 'red',
                "description" => "User information not valid",
            ]);

        if(!Auth::attempt($request->only('email','password'))){
            return view('form.login',['failure' => $response->getOriginalContent()]);
        }

        return redirect('book');
    }

    public function viewRegister(){
        return view('form.register');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        if($validasi = $this->controller->validating($request,[
            'fullname' => 'required',
            'email' => 'required',
            'password' => 'required',
        ],'form.register')){
            return $validasi;
        }

        try {
            DB::beginTransaction();
            $request['password'] = Hash::make($request->password);
            $request['m_access_tabs_id'] = 2;
            $this->user->create($request->all());
            DB::commit();
            return redirect('book');
        } catch (\Throwable $th) {
            DB::rollBack();
            return view('form.register',['throwable' => $th->getMessage()]);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/');
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
}
