<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileManagerController extends Controller
{
    public function index(Request $request)
    {
        // Default to root, but ensure it doesn't traverse up
        $path = $request->get('path', '/');
        
        // Prevent directory traversal attacks
        if (Str::contains($path, '..')) {
            $path = '/';
        }

        $files = [];

        try {
            // Get directories
            $directories = Storage::disk('local')->directories($path);
            foreach ($directories as $dir) {
                $files[] = [
                    'name' => basename($dir),
                    'path' => $dir,
                    'type' => 'directory',
                    'size' => '-',
                    'last_modified' => date('Y-m-d H:i:s', Storage::disk('local')->lastModified($dir)),
                ];
            }

            // Get files
            $fileList = Storage::disk('local')->files($path);
            foreach ($fileList as $file) {
                $files[] = [
                    'name' => basename($file),
                    'path' => $file,
                    'type' => 'file',
                    'size' => $this->formatSize(Storage::disk('local')->size($file)),
                    'last_modified' => date('Y-m-d H:i:s', Storage::disk('local')->lastModified($file)),
                ];
            }
        } catch (\Exception $e) {
            // Handle error (e.g., path not found)
            return redirect()->route('files.index')->with('error', 'Invalid path');
        }

        return Inertia::render('Files/Index', [
            'path' => $path,
            'files' => $files,
            'parent' => dirname($path) === '.' ? '/' : dirname($path)
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'path' => 'required|string',
        ]);

        $path = $request->input('path');
        
        // Security check
        if (Str::contains($path, '..')) {
            abort(403, 'Invalid path');
        }

        $file = $request->file('file');
        
        try {
            $file->storeAs($path, $file->getClientOriginalName(), 'local');
            return redirect()->back()->with('message', 'File uploaded successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['file' => 'Upload failed']);
        }
    }

    private function formatSize($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
