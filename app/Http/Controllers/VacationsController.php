<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\User;

class VacationsController extends Controller
{
    public function index () {

        $vacations=Vacation::orderBy('vacation_date', 'desc')->get();
        return view('dashboard.vacations', compact('vacations'));

    }

    public function add (Request $Request) {

        $vacation=new Vacation;
        
        dd($Request->vacation_date);
        


        exit;

    }


}
