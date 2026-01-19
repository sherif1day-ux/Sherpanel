<?php

namespace App\Http\Controllers;

use App\Services\SystemMonitor;
use Inertia\Inertia;

class DashboardController extends Controller
{
    protected $monitor;

    public function __construct(SystemMonitor $monitor)
    {
        $this->monitor = $monitor;
    }

    public function index()
    {
        return Inertia::render('Dashboard', [
            'stats' => $this->monitor->getStats()
        ]);
    }

    public function stats()
    {
        return response()->json($this->monitor->getStats());
    }
}
