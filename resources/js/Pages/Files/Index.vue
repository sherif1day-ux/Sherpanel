<script setup>
import AppLayout from '@/Components/AppLayout.vue';
import Card from '@/Components/Card.vue';
import NeonButton from '@/Components/NeonButton.vue';
import { Head, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    path: String,
    files: Array,
    parent: String,
});

const uploadForm = useForm({
    file: null,
    path: props.path,
});

const fileInput = ref(null);

const navigate = (newPath) => {
    router.get(route('files.index'), { path: newPath });
};

const triggerUpload = () => {
    fileInput.value.click();
};

const handleFileChange = (e) => {
    if (e.target.files.length > 0) {
        uploadForm.file = e.target.files[0];
        uploadForm.path = props.path;
        uploadForm.post(route('files.upload'), {
            onSuccess: () => {
                uploadForm.reset();
                e.target.value = null; // Reset input
            },
        });
    }
};
</script>

<template>
    <Head title="File Manager" />

    <AppLayout>
        <template #header>
            File Manager
        </template>

        <Card>
            <div class="mb-4 flex items-center justify-between">
                <div class="text-sm text-gray-400 flex items-center">
                    <span class="mr-2">Path:</span>
                    <code class="text-neon-cyan bg-gray-900 px-2 py-1 rounded">{{ path }}</code>
                </div>
                <div>
                    <input type="file" ref="fileInput" class="hidden" @change="handleFileChange">
                    <NeonButton @click="triggerUpload" :disabled="uploadForm.processing">
                        {{ uploadForm.processing ? 'Uploading...' : 'Upload File' }}
                    </NeonButton>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-gray-400">
                    <thead class="text-xs uppercase bg-gray-800 text-gray-200">
                        <tr>
                            <th class="px-4 py-3">Name</th>
                            <th class="px-4 py-3">Size</th>
                            <th class="px-4 py-3">Last Modified</th>
                            <th class="px-4 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        <tr v-if="path !== '/'" @click="navigate(parent)" class="hover:bg-gray-800 cursor-pointer transition-colors">
                            <td class="px-4 py-3 font-medium text-white flex items-center">
                                <span class="mr-2">📁</span> ..
                            </td>
                            <td class="px-4 py-3">-</td>
                            <td class="px-4 py-3">-</td>
                            <td class="px-4 py-3"></td>
                        </tr>
                        <tr v-for="file in files" :key="file.name" 
                            class="hover:bg-gray-800 transition-colors group cursor-pointer"
                            @click="file.type === 'directory' ? navigate(file.path) : null">
                            <td class="px-4 py-3 font-medium text-white flex items-center">
                                <span class="mr-2">{{ file.type === 'directory' ? '📁' : '📄' }}</span>
                                {{ file.name }}
                            </td>
                            <td class="px-4 py-3">{{ file.size }}</td>
                            <td class="px-4 py-3">{{ file.last_modified }}</td>
                            <td class="px-4 py-3">
                                <!-- Actions placeholder -->
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </Card>
    </AppLayout>
</template>
