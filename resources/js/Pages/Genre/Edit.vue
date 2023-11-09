<template>
    <AuthenticatedLayout>
        <form @submit.prevent="submit">
            <InputLabel for="name" value="Name" />
            <TextInput id="name" type="text" v-model="form.name" required />
            <InputError :message="form.errors.name" />

            <PrimaryButton type="submit">Update</PrimaryButton>
        </form>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, useForm } from "@inertiajs/vue3";

const props = defineProps({
    genre: Object,
});
const form = useForm({
    name: props.genre.name,
});

const submit = () => {
    form.put(route("genre.update", props.genre.id));
};
</script>
