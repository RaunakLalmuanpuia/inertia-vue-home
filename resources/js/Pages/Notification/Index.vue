<template>
    <h1>Your Notifications</h1>

    <section v-if="props.notifications.data.length">
        <div
            v-for="notification in props.notifications.data"
            :key="notification.id"
        >
            <!-- {{ notifications }} -->
            <div>
                <span
                    v-if="
                        notification.type ===
                        'App\\Notifications\\ReportVerified'
                    "
                >
                    <!-- <a
                        :href="
                            route('report.show', notification.data.report_id)
                        "
                        class="text-blue-500 border hover:underline border-slate-300"
                        >{{ notification.data.name }}</a
                    > -->

                    <Link
                        :href="
                            route('report.show', notification.data.report_id)
                        "
                    >
                        {{ notification.data.filename }}
                    </Link>
                    Report was Verified by
                    {{ notification.data.employer_name }} . Status is :
                    {{ notification.data.status }}
                    Feedback :
                    {{ notification.data.feedback }}
                </span>
            </div>

            <div>
                <Link
                    :href="route('notification.seen', notification.id)"
                    as="button"
                    method="put"
                    v-if="!notification.read_at"
                    >Mark as read</Link
                >
            </div>
        </div>
    </section>
    <div v-else>No Notifications</div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    notifications: Object,
});
console.log(props.notifications);
</script>
