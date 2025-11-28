<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\FileShare;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\Folder;

class FileShareController extends Controller
{
    public function index(Request $request)
    {
        $folderId = $request->query('folder_id');
        $currentFolder = null;
        $breadcrumbs = [];

        if ($folderId) {
            $currentFolder = Folder::findOrFail($folderId);
            
            // Build breadcrumbs
            $tempFolder = $currentFolder;
            while ($tempFolder) {
                array_unshift($breadcrumbs, $tempFolder);
                $tempFolder = $tempFolder->parent;
            }
        }

        $folders = Folder::where('parent_id', $folderId)->where('user_id', Auth::id())->get();
        $files = FileShare::where('folder_id', $folderId)->with('user')->latest()->get();

        return view('files.index', compact('files', 'folders', 'currentFolder', 'breadcrumbs'));
    }

    public function create()
    {
        return view('files.create');
    }

    public function storeFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:folders,id',
        ]);

        Folder::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'user_id' => Auth::id(),
        ]);

        return back()->with('success', 'Klasör oluşturuldu.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'file' => 'required|file|max:10240', // 10MB max
            'folder_id' => 'nullable|exists:folders,id',
        ]);

        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('files', 'public');

        FileShare::create([
            'user_id' => Auth::id(),
            'folder_id' => $request->folder_id,
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'file_name' => $fileName,
        ]);

        return back()->with('success', 'Dosya başarıyla yüklendi.');
    }

    public function download($id)
    {
        $file = FileShare::findOrFail($id);
        
        if (Storage::disk('public')->exists($file->file_path)) {
            return Storage::disk('public')->download($file->file_path, $file->file_name);
        }

        return back()->with('error', 'Dosya bulunamadı.');
    }

    public function destroy($id)
    {
        $file = FileShare::findOrFail($id);

        if (Auth::id() !== $file->user_id && !Auth::user()->is_admin) {
            return back()->with('error', 'Bu dosyayı silme yetkiniz yok.');
        }

        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return back()->with('success', 'Dosya başarıyla silindi.');
    }

    public function move(Request $request, $id)
    {
        if (!Auth::user()->is_admin) {
            return back()->with('error', 'Bu işlem için yetkiniz yok.');
        }

        $request->validate([
            'target_folder_id' => 'nullable|exists:folders,id',
        ]);

        $file = FileShare::findOrFail($id);
        $file->folder_id = $request->target_folder_id;
        $file->save();

        return back()->with('success', 'Dosya başarıyla taşındı.');
    }
}
