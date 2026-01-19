<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import NeonButton from '@/Components/NeonButton.vue';

const form = useForm({
    email: 'admin@sherpanel.com',
    password: 'password',
});

const submit = () => {
    form.post(route('login.post'));
};
</script>

<template>
    <Head title="Login" />

    <div class="min-h-screen flex items-center justify-center bg-neon-dark bg-[radial-gradient(circle_at_50%_50%,#1a1a2e_0%,transparent_50%)]">
        <div class="w-full max-w-md p-8 bg-gray-900 border border-gray-800 rounded-xl shadow-[0_0_20px_rgba(0,243,255,0.1)] relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-neon-cyan/5 to-neon-pink/5 pointer-events-none"></div>
            
            <div class="text-center mb-8 relative z-10">
                <h1 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-neon-cyan to-neon-pink font-mono tracking-wider mb-2">
                    SherPanel
                </h1>
                <p class="text-gray-400">Login to your account</p>
            </div>

            <form @submit.prevent="submit" class="space-y-6 relative z-10">
                <div>
                    <label class="block text-gray-400 text-sm mb-2">Email Address</label>
                    <input v-model="form.email" type="email" class="w-full bg-gray-800 border border-gray-700 text-white rounded focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan p-3 transition-colors" placeholder="admin@example.com">
                    <div v-if="form.errors.email" class="text-red-500 text-sm mt-1">{{ form.errors.email }}</div>
                </div>

                <div>
                    <label class="block text-gray-400 text-sm mb-2">Password</label>
                    <input v-model="form.password" type="password" class="w-full bg-gray-800 border border-gray-700 text-white rounded focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan p-3 transition-colors">
                </div>

                <NeonButton class="w-full py-3" :disabled="form.processing">
                    {{ form.processing ? 'Logging in...' : 'Login' }}
                </NeonButton>
            </form>
        </div>
    </div>
</template>
