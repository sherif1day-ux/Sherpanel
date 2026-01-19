<script setup>
import AppLayout from '@/Components/AppLayout.vue';
import Card from '@/Components/Card.vue';
import NeonButton from '@/Components/NeonButton.vue';
import { Head, useForm } from '@inertiajs/vue3';

defineProps({
    users: Array,
});

const form = useForm({
    name: '',
    email: '',
    password: '',
    role: 'user',
});

const submit = () => {
    form.post(route('users.store'), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <Head title="Users" />

    <AppLayout>
        <template #header>
            User Management
        </template>

        <div class="mb-8">
            <Card>
                <h3 class="text-lg font-bold text-white mb-4">Add New User</h3>
                <form @submit.prevent="submit" class="flex flex-col gap-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Name</label>
                            <input v-model="form.name" type="text" class="w-full bg-gray-900 border border-gray-700 text-white rounded focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan p-2">
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Email</label>
                            <input v-model="form.email" type="email" class="w-full bg-gray-900 border border-gray-700 text-white rounded focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan p-2">
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Password</label>
                            <input v-model="form.password" type="password" class="w-full bg-gray-900 border border-gray-700 text-white rounded focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan p-2">
                        </div>
                        <div>
                            <label class="block text-gray-400 text-sm mb-2">Role</label>
                            <select v-model="form.role" class="w-full bg-gray-900 border border-gray-700 text-white rounded focus:border-neon-cyan focus:ring-1 focus:ring-neon-cyan p-2">
                                <option value="user">User</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end">
                        <NeonButton type="submit">Create User</NeonButton>
                    </div>
                </form>
            </Card>
        </div>

        <div class="grid gap-4">
            <Card v-for="user in users" :key="user.id" class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-full bg-neon-cyan/20 flex items-center justify-center text-neon-cyan font-bold">
                        {{ user.name.charAt(0) }}
                    </div>
                    <div>
                        <h4 class="text-lg font-bold text-white">{{ user.name }}</h4>
                        <p class="text-sm text-gray-500">{{ user.email }} • <span class="capitalize">{{ user.role }}</span></p>
                    </div>
                </div>
                <div class="flex gap-2">
                     <Link :href="route('users.destroy', user.id)" method="delete" as="button" class="p-2 text-gray-400 hover:text-red-500">Delete</Link>
                </div>
            </Card>
        </div>
    </AppLayout>
</template>
