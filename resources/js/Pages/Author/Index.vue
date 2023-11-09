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

        <Link :href="route('author.create')">
            <PrimaryButton>Create Author</PrimaryButton>
        </Link>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="author in author" :key="author.id">
                    <th>{{ author.name }}</th>
                    <th>{{ author.email }}</th>
                    <th>{{ author.address }}</th>
                    <td>
                        <Link :href="route('author.edit', author.id)">
                            <PrimaryButton>Edit</PrimaryButton>
                        </Link>
                    </td>
                    <td>
                        <PrimaryButton @click="destroy(author.id)"
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
    author: Object,
});

const form = useForm({});

function destroy(id) {
    if (confirm("Delete Author")) {
        form.delete(route("author.destroy", id));
    }
}
</script>
