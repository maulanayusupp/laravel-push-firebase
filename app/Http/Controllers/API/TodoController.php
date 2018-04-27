<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Todo;

class TodoController extends Controller
{
    public function store(Request $request) {
    	Todo::create($request->all());
        return redirect('/');
    }
}
