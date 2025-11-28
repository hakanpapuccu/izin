<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vacation;
use App\Models\User;
use App\Models\Task;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VacationCreated;
use App\Notifications\VacationStatusUpdated;


class VacationsController extends Controller
{
    public function index () {

        $vacations=Vacation::orderBy('vacation_date', 'desc')->where('vacation_user_id', '=', Auth::user()->id)->get();
        return view('dashboard.vacations', compact('vacations'));
        
    }

    public function show()
    {
        $user = Auth::user();

        // Vacation Stats
        if ($user->is_admin) {
            $vacations = Vacation::latest()->take(5)->get();
            $pendingVacationsCount = Vacation::where('is_verified', 2)->count();
            $approvedVacationsCount = Vacation::where('is_verified', 1)->count();
            $rejectedVacationsCount = Vacation::where('is_verified', 0)->count();
            $totalVacationsCount = Vacation::count();
        } else {
            $vacations = Vacation::where('vacation_user_id', $user->id)->latest()->take(5)->get(); // Changed user_id to vacation_user_id
            $pendingVacationsCount = Vacation::where('vacation_user_id', $user->id)->where('is_verified', 2)->count(); // Changed user_id to vacation_user_id
            $approvedVacationsCount = Vacation::where('vacation_user_id', $user->id)->where('is_verified', 1)->count(); // Changed user_id to vacation_user_id
            $rejectedVacationsCount = Vacation::where('vacation_user_id', $user->id)->where('is_verified', 0)->count(); // Changed user_id to vacation_user_id
            $totalVacationsCount = Vacation::where('vacation_user_id', $user->id)->count(); // Changed user_id to vacation_user_id
        }

        // Task Stats
        if ($user->is_admin) {
            $tasks = Task::latest()->take(5)->get();
            $pendingTasksCount = Task::where('status', 'pending')->count();
            $inProgressTasksCount = Task::where('status', 'in_progress')->count();
            $completedTasksCount = Task::where('status', 'completed')->count();
            $totalTasksCount = Task::count();
        } else {
            $tasks = Task::where('assigned_to_id', $user->id)->orWhere('created_by_id', $user->id)->latest()->take(5)->get();
            $pendingTasksCount = Task::where(function ($q) use ($user) {
                $q->where('assigned_to_id', $user->id)->orWhere('created_by_id', $user->id);
            })->where('status', 'pending')->count();
            $inProgressTasksCount = Task::where(function ($q) use ($user) {
                $q->where('assigned_to_id', $user->id)->orWhere('created_by_id', $user->id);
            })->where('status', 'in_progress')->count();
            $completedTasksCount = Task::where(function ($q) use ($user) {
                $q->where('assigned_to_id', $user->id)->orWhere('created_by_id', $user->id);
            })->where('status', 'completed')->count();
            $totalTasksCount = Task::where(function ($q) use ($user) {
                $q->where('assigned_to_id', $user->id)->orWhere('created_by_id', $user->id);
            })->count();
        }

        $pendingVacations = Vacation::where('is_verified', 2)->orderBy('created_at', 'desc')->get();

        return view('dashboard.content', compact(
            'vacations',
            'pendingVacations',
            'tasks',
            'pendingVacationsCount',
            'approvedVacationsCount',
            'rejectedVacationsCount',
            'totalVacationsCount',
            'pendingTasksCount',
            'inProgressTasksCount',
            'completedTasksCount',
            'totalTasksCount'
        ));
    }

    public function add (Request $request) {

        $validated = $request->validate([
            'vacation_date' => 'required|date|after_or_equal:today',
            'vacation_why' => 'required|string|max:255',
            'vacation_start' => 'required|date_format:H:i',
            'vacation_end' => 'required|date_format:H:i|after:vacation_start',
        ]);
      
        $vacation = Vacation::create([
            'vacation_date' => $request->vacation_date,
            'vacation_why' => $request->vacation_why,
            'vacation_start' => $request->vacation_start,
            'vacation_end' => $request->vacation_end,
            'vacation_user_id' => Auth::id(),
            'is_verified' => Vacation::STATUS_PENDING,
        ]);

        // Notify Admins
        $admins = User::where('is_admin', true)->get();
        Notification::send($admins, new VacationCreated($vacation));

        session()->flash('success', 'İzin başarıyla oluşturuldu');
        return redirect()->route('vacations');
 
    }

    public function verify ($id) {

        $vacation=Vacation::findOrFail($id);
        $this->authorize('approve', $vacation);
        
        $vacation->is_verified=Vacation::STATUS_APPROVED;
        $vacation->vacation_verifier_id=Auth::id();
        $vacation->save();

        // Notify User
        $vacation->user->notify(new VacationStatusUpdated($vacation, 'approved'));

        session()->flash('success', 'İzin onaylandı');
        return redirect()->route('dashboard');

    }

    public function reject ($id) {

        $vacation=Vacation::findOrFail($id);
        $this->authorize('approve', $vacation);

        $vacation->is_verified=Vacation::STATUS_REJECTED;
        $vacation->vacation_verifier_id=Auth::id();
        $vacation->save();
        
        // Notify User
        $vacation->user->notify(new VacationStatusUpdated($vacation, 'rejected'));

        session()->flash('success', 'İzin reddedildi');
        return redirect()->route('dashboard');

    }

    
}
