<script setup>
import { Link, usePage, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);
const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-neon-surface border-r border-gray-800 flex flex-col fixed h-full z-10">
            <div class="h-16 flex items-center justify-center border-b border-gray-800">
                <h1 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-neon-cyan to-neon-pink font-mono tracking-wider">
                    SherPanel
                </h1>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2">
                <Link :href="route('dashboard')" class="flex items-center px-4 py-3 text-gray-300 hover:text-neon-cyan hover:bg-gray-800 rounded-lg transition-all group" :class="{ 'bg-gray-800 text-neon-cyan box-shadow-neon': $page.url.startsWith('/dashboard') }">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </Link>

                <Link :href="route('sites.index')" class="flex items-center px-4 py-3 text-gray-300 hover:text-neon-cyan hover:bg-gray-800 rounded-lg transition-all" :class="{ 'bg-gray-800 text-neon-cyan box-shadow-neon': $page.url.startsWith('/sites') }">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
                    Websites
                </Link>

                <Link :href="route('files.index')" class="flex items-center px-4 py-3 text-gray-300 hover:text-neon-cyan hover:bg-gray-800 rounded-lg transition-all" :class="{ 'bg-gray-800 text-neon-cyan box-shadow-neon': $page.url.startsWith('/files') }">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                    Files
                </Link>

                <Link :href="route('databases.index')" class="flex items-center px-4 py-3 text-gray-300 hover:text-neon-cyan hover:bg-gray-800 rounded-lg transition-all" :class="{ 'bg-gray-800 text-neon-cyan box-shadow-neon': $page.url.startsWith('/databases') }">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
                    Databases
                </Link>

                <Link :href="route('terminal.index')" class="flex items-center px-4 py-3 text-gray-300 hover:text-neon-cyan hover:bg-gray-800 rounded-lg transition-all" :class="{ 'bg-gray-800 text-neon-cyan box-shadow-neon': $page.url.startsWith('/terminal') }">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l3 3-3 3m5 0h3M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    Terminal
                </Link>

                <Link v-if="user?.role === 'admin'" :href="route('users.index')" class="flex items-center px-4 py-3 text-gray-300 hover:text-neon-cyan hover:bg-gray-800 rounded-lg transition-all" :class="{ 'bg-gray-800 text-neon-cyan box-shadow-neon': $page.url.startsWith('/users') }">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Users
                </Link>
            </nav>

            <div class="p-4 border-t border-gray-800">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-8 h-8 rounded-full bg-neon-pink flex items-center justify-center text-white font-bold">
                            {{ user?.name?.charAt(0) || 'U' }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ user?.name || 'Guest' }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ user?.role || 'Visitor' }}</p>
                        </div>
                    </div>
                    <button @click="logout" class="text-gray-400 hover:text-red-500" title="Logout">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    </button>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 p-8 overflow-y-auto">
            <header class="mb-8 flex justify-between items-center">
                <h2 class="text-3xl font-bold text-white tracking-tight">
                    <slot name="header" />
                </h2>
                <div class="flex space-x-4">
                    <!-- Notifications, etc. -->
                </div>
            </header>
            
            <div class="animate-fade-in-up">
                <slot />
            </div>
        </main>
    </div>
</template>

<style>
.animate-fade-in-up {
    animation: fadeInUp 0.5s ease-out;
}
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
