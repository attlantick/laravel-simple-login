<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Models\User;

class HomeController extends Controller
{
    public function index(){
        return view('welcome');
    }

    /**
     * @param StoreUser $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(StoreUser $request){

        return response(['data'=> [
            User::create($request->validated())
        ]],201);

    }
}
