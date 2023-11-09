<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Image Create
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div>
                                <label for="File">File Upload</label>
                                <input
                                    type="file"
                                    @change="previewImage"
                                    :v-model="form.image"
                                    class="w-full px-4 py-2 mt-2 border rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600"
                                />
                                <img
                                    v-if="url"
                                    :src="url"
                                    alt="image"
                                    class="w-full mt-4 h-80"
                                />
                            </div>
                            <div class="flex items-center mt-4">
                                <button
                                    class="px-6 py-2 text-green-600 bg-gray-900 rounded"
                                    :disabled="form.processing"
                                >
                                    Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const form = useForm({
    image: null,
});

const url = ref(null);

const submit = () => {
    form.post(route("image.store"), {
        forceFormData: true,
    });
};

const previewImage = (e) => {
    const file = e.target.files[0];
    url.value = URL.createObjectURL(file);
};
</script>
