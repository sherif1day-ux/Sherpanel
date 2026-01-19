<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Auth;

class TerminalController extends Controller
{
    public function index()
    {
        return Inertia::render('Terminal/Index');
    }

    public function execute(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json(['output' => 'Permission denied. Only admins can use the terminal.'], 403);
        }

        $request->validate([
            'command' => 'required|string',
        ]);

        $command = $request->input('command');

        // Whitelist allowed commands for safety (or allow all if you are brave/reckless)
        // For a hosting panel, usually you want full access, but let's be careful.
        // We will restrict to simple commands for this demo.
        
        $allowed = ['ls', 'pwd', 'whoami', 'date', 'git', 'composer', 'php', 'npm', 'uptime', 'df', 'free'];
        $cmdParts = explode(' ', trim($command));
        $baseCmd = $cmdParts[0];

        if (!in_array($baseCmd, $allowed)) {
             return response()->json(['output' => "Command '$baseCmd' is not allowed in this web terminal."], 403);
        }

        // Execute command
        // Note: This is a synchronous execution. Long running commands will timeout.
        try {
            $process = Process::fromShellCommandline($command, base_path());
            $process->run();

            if (!$process->isSuccessful()) {
                throw new ProcessFailedException($process);
            }

            return response()->json(['output' => $process->getOutput()]);
        } catch (\Exception $e) {
            return response()->json(['output' => $e->getMessage()], 500);
        }
    }
}
