<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Notifications
            </h2>
        </template>
        <div  class="py-8">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg"> 
                     {{ notifications }}
                    <!-- Employee -->
                    <div v-if="$page.props.user.roles.includes('employee')">
                        <section v-if="props.notifications.data.length" class="text-gray-700 dark:text-gray-400">
                        <div
                            v-for="notification in props.notifications.data"
                            :key="notification.id"
                            class="flex items-center justify-between py-4 border-b border-gray-200 dark:border-gray-800"
                        >
                           
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

                                    <!-- <a 
                                    :href="route('report.show', notification.data.report_id)"
                                    target="_blank"
                                    class="text-indigo-600 dark:text-indigo-400"
                                    >
                                        {{ notification.data.filename }}
                                    </a > -->
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
                                    class="p-2 mr-4 text-xs font-medium uppercase border border-gray-300 rounded-md shadow-sm dark:border-gray-800 hover:border-gray-400 hover:bg-gray-50 dark:hover:border-gray-700 dark:hover:bg-gray-800 "
                                    >Mark as read</Link
                                >
                            </div>
                        </div>
                    </section>
                    <div v-else>No Notifications</div>
                    <section
                        v-if="props.notifications.data.length" 
                        class="flex justify-center w-full mt-8 mb-8"
                    >
                    <Pagination :data="notifications" />
   
                    </section>
                    </div>
                    <!-- Employer -->
                    <div v-if="$page.props.user.roles.includes('employer')">
                    <section v-if="props.notifications.data.length" class="text-gray-700 dark:text-gray-400">
                        <div
                            v-for="notification in props.notifications.data"
                            :key="notification.id"
                            class="flex items-center justify-between py-4 border-b border-gray-200 dark:border-gray-800"
                        >
                            <!-- {{ notifications }} -->
                            <div>
                                <span
                                    v-if="
                                        notification.type ===
                                        'App\\Notifications\\ReportVerified'
                                    "
                                >
                                    <!-- <Link
                                        :href="
                                            route('report.show', notification.data.report_id)
                                        "
                                        class="text-blue-500 border hover:underline border-slate-300"
                                        >{{ notification.data.filename }}</Link
                                    > -->

                                    <!-- <a 
                                    :href="route('report.show', notification.data.report_id)"
                                    target="_blank"
                                    class="text-indigo-600 dark:text-indigo-400"
                                    >
                                        {{ notification.data.filename }}
                                    </a > -->
                                    Report was Submitted by
                                    {{ notification.data.employee_name }} . filename is :
                                    {{ notification.data.filename }}
                                    
                                </span>
                            </div>

                            <div>
                                <Link
                                    :href="route('notification.seen', notification.id)"
                                    as="button"
                                    method="put"
                                    v-if="!notification.read_at"
                                    class="p-2 mr-4 text-xs font-medium uppercase border border-gray-300 rounded-md shadow-sm dark:border-gray-800 hover:border-gray-400 hover:bg-gray-50 dark:hover:border-gray-700 dark:hover:bg-gray-800 "
                                    >Mark as read</Link
                                >
                            </div>
                        </div>
                    </section>
                    <div v-else>No Notifications</div>
                    <section
                        v-if="props.notifications.data.length" 
                        class="flex justify-center w-full mt-8 mb-8"
                    >
                    <Pagination :data="notifications" />
   
                    </section>
                </div>
                </div>
            </div>
        </div>
        
</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from "@inertiajs/vue3";
const props = defineProps({
    notifications: Object,
});
// console.log(props.notifications);
</script>
