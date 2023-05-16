<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VacationsController extends Controller
{
    public function index () {

        return view('dashboard.vacations');

    }
}
