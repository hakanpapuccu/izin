<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacation;


class VacationsController extends Controller
{
    public function index () {

        $vacations=Vacation::orderBy('vacation_date', 'desc')->where('vacation_user_id', '=', Auth::user()->id)->get();
        return view('dashboard.vacations', compact('vacations'));
        
    }

    public function show () {

        $vacations=Vacation::where('is_verified', '=' , '2')->get();
        $lastvacations=Vacation::all();
        return view('dashboard.content', compact('vacations', 'lastvacations'));

    }

    public function add (Request $Request) {

      
        $vacation=new Vacation;
        $vacation->vacation_date=$Request->vacation_date;
        $vacation->vacation_why=$Request->vacation_why;
        $vacation->vacation_start=$Request->vacation_start;
        $vacation->vacation_end=$Request->vacation_end;
        $vacation->vacation_user_id=Auth::user()->id;
        

        $vacation->save();
        toastr()->success('İzin başarıyla oluşturuldu', 'Başarılı');
        return redirect()->route('vacations');
 
    }

    public function verify ($id) {

        
        $vacation=Vacation::findOrfail($id);
        $vacation->is_verified="1";
        $vacation->vacation_verifier_id=Auth::user()->id;
        $vacation->save();
        toastr()->success('İzin onaylandı', 'Başarılı');
        return redirect()->route('dashboard');

    }

    public function reject ($id) {

        
        $vacation=Vacation::findOrfail($id);
        $vacation->is_verified="3";
        $vacation->vacation_verifier_id=Auth::user()->id;
        $vacation->save();
        
        toastr()->success('İzin reddedildi', 'Başarılı');
        return redirect()->route('dashboard');

    }

    
}
