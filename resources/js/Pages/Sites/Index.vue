<script setup>
import AppLayout from '@/Components/AppLayout.vue';
import Card from '@/Components/Card.vue';
import NeonButton from '@/Components/NeonButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    sites: Array,
});

const form = useForm({
    domain: '',
    php_version: '8.2',
});

const submit = () => {
    form.post(route('sites.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Websites" />

    <AppLayout>
        <template #header>
            Websites
        </template>

        <div class="mb-8">
            <Card>
                <h3 class="text-lg font-bold text-white mb-4">Add New Website</h3>
                <form @submit.prevent="submit" class="flex gap-4 items-end">
                    <div class="flex-1">
                        <label class="block text-gray-400 text-sm mb-2">Domain Name</label>
                        <input v-model="form.domain" type="text" class="w-full bg-gray-900 border border-gray-700 text-white rounded focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan p-2" placeholder="example.com">
                    </div>
                    <div class="w-48">
                        <label class="block text-gray-400 text-sm mb-2">PHP Version</label>
                        <select v-model="form.php_version" class="w-full bg-gray-900 border border-gray-700 text-white rounded focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan p-2">
                            <option value="8.2">PHP 8.2</option>
                            <option value="8.1">PHP 8.1</option>
                            <option value="8.0">PHP 8.0</option>
                        </select>
                    </div>
                    <NeonButton type="submit">Create</NeonButton>
                </form>
            </Card>
        </div>

        <div class="grid gap-4">
            <div v-for="site in sites" :key="site.id" class="bg-gray-900 border border-gray-800 rounded-lg p-4 flex items-center justify-between hover:border-neon-cyan transition-colors">
                <div>
                    <h4 class="text-lg font-bold text-white">{{ site.domain }}</h4>
                    <p class="text-sm text-gray-500">PHP {{ site.php_version }} • <span :class="site.status === 'active' ? 'text-green-500' : 'text-red-500'">{{ site.status }}</span></p>
                </div>
                <div class="flex gap-2">
                    <button class="p-2 text-gray-400 hover:text-white">Settings</button>
                    <button class="p-2 text-gray-400 hover:text-red-500">Delete</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
