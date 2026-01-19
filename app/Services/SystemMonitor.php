<?php

namespace App\Services;

class SystemMonitor
{
    public function getStats()
    {
        return [
            'cpu' => $this->getCpuUsage(),
            'ram' => $this->getRamUsage(),
            'disk' => $this->getDiskUsage(),
            'uptime' => $this->getUptime(),
        ];
    }

    protected function getCpuUsage()
    {
        // Windows fallback
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $cmd = "wmic cpu get loadpercentage";
            @exec($cmd, $output);
            if ($output) {
                foreach ($output as $line) {
                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                        return $line;
                    }
                }
            }
            return 0;
        }

        // Linux
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return $load[0] * 100; // Rough percentage estimate
        }
        return 0;
    }

    protected function getRamUsage()
    {
        // Windows fallback
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            $cmd = "wmic OS get FreePhysicalMemory,TotalVisibleMemorySize /Value";
            @exec($cmd, $output);
            $total = 0;
            $free = 0;
            if ($output) {
                foreach ($output as $line) {
                    if (preg_match("/^TotalVisibleMemorySize=(\d+)/", $line, $m)) {
                        $total = $m[1];
                    } elseif (preg_match("/^FreePhysicalMemory=(\d+)/", $line, $m)) {
                        $free = $m[1];
                    }
                }
                if ($total > 0) {
                    return round((($total - $free) / $total) * 100, 2);
                }
            }
            return 0;
        }

        // Linux
        try {
            $free = shell_exec('free -m');
            if ($free) {
                $free = (string)trim($free);
                $free_arr = explode("\n", $free);
                if (isset($free_arr[1])) {
                    $mem = explode(" ", $free_arr[1]);
                    $mem = array_filter($mem);
                    $mem = array_merge($mem);
                    if (isset($mem[1]) && isset($mem[2]) && $mem[1] > 0) {
                        $memory_usage = $mem[2] / $mem[1] * 100;
                        return round($memory_usage, 2);
                    }
                }
            }
        } catch (\Exception $e) {
            return 0;
        }
        return 0;
    }

    protected function getDiskUsage()
    {
        $path = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? "C:" : "/";
        $ds = disk_total_space($path);
        $df = disk_free_space($path);
        return round(100 - ($df / $ds * 100), 2);
    }

    protected function getUptime()
    {
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            // Windows uptime is harder to get simply, return 0 or mock
            return 0;
        }

        $uptime = @shell_exec("cut -d. -f1 /proc/uptime");
        return (int)$uptime;
    }
}
