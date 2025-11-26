<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::with(['user', 'comments.user'])->latest()->get();
        return view('announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Announcement::create([
            'user_id' => auth()->id(),
            'content' => $request->content,
        ]);

        return back()->with('success', 'Duyuru paylaşıldı.');
    }

    public function edit(Announcement $announcement)
    {
        if ($announcement->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }
        return view('announcements.edit', compact('announcement'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        if ($announcement->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $announcement->update([
            'content' => $request->content,
        ]);

        return redirect()->route('announcements.index')->with('success', 'Duyuru güncellendi.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->user_id !== auth()->id() && !auth()->user()->is_admin) {
            abort(403);
        }

        $announcement->delete();

        return back()->with('success', 'Duyuru silindi.');
    }
}
