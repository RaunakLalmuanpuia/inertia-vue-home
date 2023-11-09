<template>
    <AuthenticatedLayout>
        <form @submit.prevent="submit">
            <InputLabel for="name" value="Name" />
            <TextInput id="name" type="text" v-model="form.name" required />
            <InputError :message="form.errors.name" />

            <InputLabel for="email" value="Email" />
            <TextInput id="email" type="text" v-model="form.email" required />
            <InputError :message="form.errors.email" />

            <InputLabel for="address" value="Address" />
            <TextInput
                id="address"
                type="text"
                v-model="form.address"
                required
            />
            <InputError :message="form.errors.address" />

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
    author: Object,
});
const form = useForm({
    name: props.author.name,
    email: props.author.email,
    address: props.author.address,
});

const submit = () => {
    form.put(route("author.update", props.author.id));
};
</script>
