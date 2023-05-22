<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacation;

class HomeController extends Controller
{
    public function index() {

        $vacations=Vacation::all();
        return view('dashboard.content', compact('vacations'));

    }
}
