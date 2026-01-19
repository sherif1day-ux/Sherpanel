<script setup>
import AppLayout from '@/Components/AppLayout.vue';
import Card from '@/Components/Card.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    stats: Object,
});
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout>
        <template #header>
            Dashboard
        </template>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <Card>
                <h3 class="text-gray-400 text-sm font-medium uppercase tracking-wider">CPU Usage</h3>
                <div class="mt-2 flex items-baseline">
                    <span class="text-4xl font-bold text-neon-cyan">{{ stats.cpu }}%</span>
                </div>
                <div class="w-full bg-gray-800 rounded-full h-2 mt-4">
                    <div class="bg-neon-cyan h-2 rounded-full transition-all duration-500" :style="{ width: stats.cpu + '%' }"></div>
                </div>
            </Card>

            <Card>
                <h3 class="text-gray-400 text-sm font-medium uppercase tracking-wider">RAM Usage</h3>
                <div class="mt-2 flex items-baseline">
                    <span class="text-4xl font-bold text-neon-pink">{{ stats.ram }}%</span>
                </div>
                <div class="w-full bg-gray-800 rounded-full h-2 mt-4">
                    <div class="bg-neon-pink h-2 rounded-full transition-all duration-500" :style="{ width: stats.ram + '%' }"></div>
                </div>
            </Card>

            <Card>
                <h3 class="text-gray-400 text-sm font-medium uppercase tracking-wider">Disk Usage</h3>
                <div class="mt-2 flex items-baseline">
                    <span class="text-4xl font-bold text-purple-500">{{ stats.disk }}%</span>
                </div>
                <div class="w-full bg-gray-800 rounded-full h-2 mt-4">
                    <div class="bg-purple-500 h-2 rounded-full transition-all duration-500" :style="{ width: stats.disk + '%' }"></div>
                </div>
            </Card>

            <Card>
                <h3 class="text-gray-400 text-sm font-medium uppercase tracking-wider">Uptime</h3>
                <div class="mt-2 flex items-baseline">
                    <span class="text-2xl font-bold text-white">{{ (stats.uptime / 3600).toFixed(1) }} Hours</span>
                </div>
            </Card>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <Card>
                <h3 class="text-lg font-bold text-white mb-4">Recent Activity</h3>
                <ul class="space-y-3">
                    <li class="flex items-center text-sm text-gray-400">
                        <span class="w-2 h-2 rounded-full bg-green-500 mr-3"></span>
                        Nginx service restarted
                        <span class="ml-auto text-xs">2 mins ago</span>
                    </li>
                    <li class="flex items-center text-sm text-gray-400">
                        <span class="w-2 h-2 rounded-full bg-blue-500 mr-3"></span>
                        Backup completed
                        <span class="ml-auto text-xs">1 hour ago</span>
                    </li>
                    <li class="flex items-center text-sm text-gray-400">
                        <span class="w-2 h-2 rounded-full bg-neon-pink mr-3"></span>
                        High CPU warning
                        <span class="ml-auto text-xs">3 hours ago</span>
                    </li>
                </ul>
            </Card>
            
             <Card>
                <h3 class="text-lg font-bold text-white mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-4">
                    <button class="p-3 bg-gray-800 rounded border border-gray-700 hover:border-neon-cyan hover:text-neon-cyan transition-all">Restart Nginx</button>
                    <button class="p-3 bg-gray-800 rounded border border-gray-700 hover:border-neon-cyan hover:text-neon-cyan transition-all">Restart PHP</button>
                    <button class="p-3 bg-gray-800 rounded border border-gray-700 hover:border-neon-cyan hover:text-neon-cyan transition-all">Clear Cache</button>
                    <button class="p-3 bg-gray-800 rounded border border-gray-700 hover:border-neon-cyan hover:text-neon-cyan transition-all">Update System</button>
                </div>
            </Card>
        </div>
    </AppLayout>
</template>
