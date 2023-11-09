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

        <Link :href="route('books.create')">
            <PrimaryButton>Create Book</PrimaryButton>
        </Link>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Genre</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="book in book" :key="book.id">
                    <th>{{ book.title }}</th>
                    <th>{{ book.author.name }}</th>
                    <th>{{ book.genre.name }}</th>
                    <td>
                        <Link :href="route('books.edit', book.id)">
                            <PrimaryButton>Edit</PrimaryButton>
                        </Link>
                    </td>
                    <td>
                        <PrimaryButton @click="destroy(book.id)"
                            >Delete</PrimaryButton
                        >
                    </td>
                </tr>
            </tbody>
        </table>
        <br />
        <br />
        <p>All user with role Employee</p>
        <table>
            <thead>
                <tr>
                    <th>user</th>
                    <th>role Name</th>
                    <th>role id</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="role in role" :key="role.id">
                    <th>{{ role.name }}</th>
                    <th>{{ $page.props.auth.user.roles[0].name }}</th>
                    <th>{{ role.pivot.role_id }}</th>
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
    book: Array,
    author: Object,
    genre: Object,
    role: Object,
});

const form = useForm({});

function destroy(id) {
    if (confirm("Delete Book")) {
        form.delete(route("books.destroy", id));
    }
}
</script>
