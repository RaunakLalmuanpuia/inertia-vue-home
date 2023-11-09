<template>
    <Head title="Dashboard" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>
        <div>
            <div>
                <div>
                    <div>
                        <h3>Laravel 9 Inertia JS Datatable</h3>
                        <Table :resource="users" />
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Table } from "@protonemedia/inertiajs-tables-laravel-query-builder";

defineProps(["users"]);
</script>
