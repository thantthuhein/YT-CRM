<?php

namespace App\Http\Controllers\Admin;

use App\ServicingContract;
use App\ServicingComplementary;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ServicingController extends Controller
{
    public function index()
    {
        $servicingComplemetaries = ServicingComplementary::all();

        $servicingContracts = ServicingContract::all();

        return view('admin.servicings.index', compact('servicingComplemetaries', 'servicingContracts'));
    }
}
