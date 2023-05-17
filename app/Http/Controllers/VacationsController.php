<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VacationModel;

class VacationsController extends Controller
{
    public function index () {

        $vacations=VacationModel::orderBy('vacation_date', 'DESC')->get();
        return view('dashboard.vacations', compact('vacations'));

    }
}
