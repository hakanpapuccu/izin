<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FileShare;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FileShareController extends Controller
{
    public function index()
    {
        $files = FileShare::with('user')->latest()->get();
        return view('files.index', compact('files'));
    }

    public function create()
    {
        return view('files.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|file|max:10240', // 10MB max
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('files', 'public');

        FileShare::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $fileName,
        ]);

        return redirect()->route('files.index')->with('success', 'Dosya başarıyla yüklendi.');
    }

    public function download($id)
    {
        $file = FileShare::findOrFail($id);
        
        if (Storage::disk('public')->exists($file->file_path)) {
            return Storage::disk('public')->download($file->file_path, $file->file_name);
        }

        return back()->with('error', 'Dosya bulunamadı.');
    }
}
