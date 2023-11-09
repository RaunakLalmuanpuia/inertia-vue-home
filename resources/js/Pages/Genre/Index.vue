<template>
    <AuthenticatedLayout>
        <div
            v-if="$page.props.flash.message"
            class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
            role="alert"
        >
            <span class="font-medium">
                {{ $page.props.flash.message }}
            </span>
        </div>

        <Link :href="route('genre.create')">
            <PrimaryButton>Create Genre</PrimaryButton>
        </Link>
        <table>
            <thead>
                <tr :v-if="genre !== null">
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="genre in genre" :key="genre.id">
                    <th>{{ genre.name }}</th>

                    <td>
                        <Link :href="route('genre.edit', genre.id)">
                            <PrimaryButton>Edit</PrimaryButton>
                        </Link>
                    </td>
                    <td>
                        <PrimaryButton @click="destroy(genre.id)"
                            >Delete</PrimaryButton
                        >
                    </td>
                </tr>
            </tbody>
        </table>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

const props = defineProps({
    genre: {
        type: Object,
        default: null,
    },
});

const form = useForm({});

function destroy(id) {
    if (confirm("Delete Author")) {
        form.delete(route("genre.destroy", id));
    }
}
</script>
