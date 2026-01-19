<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ModuleLoader
{
    protected $modulesPath;

    public function __construct()
    {
        $this->modulesPath = app_path('Modules');
    }

    public function getModules()
    {
        if (!File::exists($this->modulesPath)) {
            File::makeDirectory($this->modulesPath, 0755, true);
        }

        $modules = [];
        $directories = File::directories($this->modulesPath);

        foreach ($directories as $directory) {
            $moduleJson = $directory . '/module.json';
            if (File::exists($moduleJson)) {
                $config = json_decode(File::get($moduleJson), true);
                if ($config) {
                    $modules[] = $config;
                }
            }
        }

        return $modules;
    }

    public function loadRoutes()
    {
        if (!File::exists($this->modulesPath)) {
            return;
        }

        $directories = File::directories($this->modulesPath);

        foreach ($directories as $directory) {
            $routesFile = $directory . '/routes.php';
            if (File::exists($routesFile)) {
                require $routesFile;
            }
        }
    }
}
