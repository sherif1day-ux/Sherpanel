<script setup>
import AppLayout from '@/Components/AppLayout.vue';
import Card from '@/Components/Card.vue';
import NeonButton from '@/Components/NeonButton.vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    databases: Array,
});

const form = useForm({
    name: '',
});

const createDb = () => {
    form.post(route('databases.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Databases" />

    <AppLayout>
        <template #header>
            Databases
        </template>

        <div class="mb-8">
             <Card>
                <h3 class="text-lg font-bold text-white mb-4">Create Database</h3>
                <form @submit.prevent="createDb" class="flex gap-4 items-end">
                    <div class="flex-1">
                        <label class="block text-gray-400 text-sm mb-2">Database Name</label>
                        <input v-model="form.name" type="text" class="w-full bg-gray-900 border border-gray-700 text-white rounded focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan p-2" placeholder="my_database">
                        <p v-if="form.errors.name" class="text-red-500 text-xs mt-1">{{ form.errors.name }}</p>
                    </div>
                    <NeonButton type="submit" :disabled="form.processing">Create</NeonButton>
                </form>
            </Card>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <Card v-for="db in databases" :key="db.id">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 rounded-full bg-gray-800 flex items-center justify-center text-xl mr-3">🗄️</div>
                        <div>
                            <h3 class="font-bold text-white">{{ db.name }}</h3>
                            <p class="text-sm text-gray-500">User: {{ db.user?.name || 'Self' }}</p>
                        </div>
                    </div>
                </div>
                <div class="flex gap-2 mt-4 pt-4 border-t border-gray-800">
                    <button class="flex-1 py-2 bg-gray-800 text-sm text-gray-300 rounded hover:bg-gray-700">phpMyAdmin</button>
                    <Link :href="route('databases.destroy', db.id)" method="delete" as="button" class="px-3 py-2 bg-red-900/20 text-red-500 rounded hover:bg-red-900/40">🗑️</Link>
                </div>
            </Card>
        </div>
    </AppLayout>
</template>
