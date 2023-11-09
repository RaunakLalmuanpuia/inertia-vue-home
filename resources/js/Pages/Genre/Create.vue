<template>
    <AuthenticatedLayout>
        <Head title="Genre" />
        <h2>Create Genre</h2>
        <form @submit.prevent="submit">
            <InputLabel for="name" value="Name" />
            <TextInput id="name" type="text" v-model="form.name" required />
            <InputError :message="form.errors.name" />

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
import { Head, useForm } from "@inertiajs/vue3";
const props = defineProps({});

const form = useForm({
    name: "",
});

const submit = () => {
    form.post(route("genre.store"));
};
</script>
