<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SiteController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // If admin, show all? Or just own? Let's show own for now, or all if admin.
        // For simplicity and "all users" context, users manage their own sites.
        // If we want admin to see all, we can check role.
        
        if ($user->role === 'admin') {
             $sites = Site::with('user')->latest()->get();
        } else {
             $sites = $user->sites()->latest()->get();
        }

        return Inertia::render('Sites/Index', [
            'sites' => $sites
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'domain' => 'required|string|unique:sites,domain',
            'php_version' => 'required|string',
        ]);

        $site = Auth::user()->sites()->create([
            'domain' => $request->domain,
            'php_version' => $request->php_version,
            'status' => 'active',
        ]);

        // Logic to generate Nginx config
        $config = $this->generateNginxConfig($request->domain, $request->php_version);
        
        // Save config (mocking the path for safety in this environment)
        // In real prod: /etc/nginx/sites-available/
        Storage::disk('local')->put('nginx/sites-available/' . $request->domain, $config);
        
        return redirect()->back()->with('message', 'Site created successfully');
    }

    protected function generateNginxConfig($domain, $phpVersion)
    {
        return "server {
    listen 80;
    server_name {$domain};
    root /var/www/{$domain}/public;
    index index.php index.html;

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php{$phpVersion}-fpm.sock;
    }
}";
    }
}
