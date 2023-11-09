<template>
    <AuthenticatedLayout>
        <form @submit.prevent="submit">
            <InputLabel for="title" value="title" />
            <TextInput id="title" type="text" v-model="form.title" required />
            <InputError :message="form.errors.title" />

            <div>
                <select v-model="selectedAuthor">
                    <option value="" disabled>Select an Author</option>
                    <option v-for="author in author" :value="author">
                        {{ author.name }}
                    </option>
                </select>
                <p>Selected Author : {{ selectedAuthor.name }}</p>
            </div>
            <div>
                <select v-model="selectedGenre">
                    <option value="" disabled>Select an Genre</option>
                    <option v-for="genre in genre" :value="genre">
                        {{ genre.name }}
                    </option>
                </select>
                <p>Selected Genre : {{ selectedGenre.name }}</p>
            </div>
            <PrimaryButton type="submit">Create</PrimaryButton>
        </form>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";
const props = defineProps({
    author: Array,
    genre: Array,
});
const selectedAuthor = ref("");
const selectedGenre = ref("");

const form = useForm({
    title: "",
    author_id: "",
    genre_id: "",
});

const submit = () => {
    form.author_id = selectedAuthor.value.id;
    form.genre_id = selectedGenre.value.id;

    form.post(route("books.store"));
};
</script>
