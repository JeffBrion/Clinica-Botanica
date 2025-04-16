<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanelController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == 'Trabajador') {
            return redirect()->route('test.users.index');
        }

        return view('panel');
    }
}
