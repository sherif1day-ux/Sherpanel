<?php

namespace App\Http\Controllers;

use App\Models\Database;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class DatabaseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            $databases = Database::with('user')->latest()->get();
        } else {
            $databases = $user->databases()->latest()->get();
        }

        return Inertia::render('Databases/Index', [
            'databases' => $databases
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:64|regex:/^[a-zA-Z0-9_]+$/',
        ]);

        $dbName = $request->name; // In real world, prefix with user_id to avoid collision e.g., user1_dbname

        // Create actual DB
        try {
            // Dangerous in prod without sanitization/prepared statements for DDL
            // For this demo/MVP, we assume trusted input or strict regex above
            DB::statement("CREATE DATABASE IF NOT EXISTS `{$dbName}`");
            
            Auth::user()->databases()->create([
                'name' => $dbName,
            ]);

            return redirect()->back()->with('message', 'Database created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['name' => 'Failed to create database: ' . $e->getMessage()]);
        }
    }

    public function destroy(Database $database)
    {
        // RBAC Check
        if (Auth::user()->role !== 'admin' && $database->user_id !== Auth::id()) {
            abort(403);
        }

        try {
            DB::statement("DROP DATABASE IF EXISTS `{$database->name}`");
            $database->delete();
            return redirect()->back()->with('message', 'Database deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Failed to delete database']);
        }
    }
}
