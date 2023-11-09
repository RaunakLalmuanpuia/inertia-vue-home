<template>
    <Head title="Blogs" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Blogs Index
            </h2>
        </template>
        <!-- <iframe width="780" height="439" src="https://www.youtube.com/embed/pe0NLyhtchU" title="Conor McGregor (Ireland) vs Floyd Mayweather (USA) | KNOCKOUT, BOXING fight, HD, 60 fps" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe> -->
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    v-if="$page.props.flash.message"
                    class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                    role="alert"
                >
                    <span class="font-medium">
                        {{ $page.props.flash.message }}
                    </span>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-2">
                            <Link :href="route('blogs.create')">
                                <PrimaryButton class="bg-blue-500"
                                    >Add Blog</PrimaryButton
                                >
                            </Link>
                        </div>
                        <div
                            class="relative overflow-x-auto shadow-md sm:rounded-lg"
                        >
                            <div class="flex items-center space-x-4 mb-4">
                                <div class="relative inline-block w-1/3">
                                    <!--searrch -- diffrent tailwind css style for select Multiple options  -->
                                    <select
                                        v-model="selectedSearchOptions"
                                        multiple
                                        @mouseenter="checkOverflow"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    >
                                        <option value="title">Title</option>
                                        <option value="id">Id</option>
                                        <option value="date">Created_at</option>
                                    </select>
                                </div>
                                <input
                                    v-model="search"
                                    type="text"
                                    placeholder="Search Blogs"
                                    class="w-2/3 px-4 py-2 leading-tight bg-white border rounded-lg appearance-none focus:outline-none focus:shadow-outline"
                                />
                            </div>

                            <table
                                class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                            >
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                                >
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            id
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Title
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Created At
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Edit
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Delete
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="blog in filteredBlogs"
                                        :key="blog.id"
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                    >
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"
                                        >
                                            {{ blog.id }}
                                        </th>
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"
                                        >
                                            {{ blog.title }}
                                        </th>
                                        <th
                                            scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap"
                                        >
                                            {{ formatDate(blog.created_at) }}
                                        </th>

                                        <td class="px-6 py-4">
                                            <Link
                                                :href="
                                                    route('blogs.edit', blog.id)
                                                "
                                            >
                                                <PrimaryButton
                                                    class="px-4 py-2 text-gray-900 bg-blue-600 rounded-lg"
                                                    >Edit</PrimaryButton
                                                ></Link
                                            >
                                        </td>
                                        <td class="px-6 py-4">
                                            <PrimaryButton
                                                class="bg-red-700"
                                                @click="destroy(blog.id)"
                                            >
                                                Delete
                                            </PrimaryButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- Div/Container of Model -->
                Model Container
                <div
                    class="px-4 py-4 overflow-hidden bg-white shadow-xl sm:rounded-lg"
                >
                    <!-- Open Modal -->
                    <button
                        @click="openModal"
                        class="px-4 py-2 my-3 font-bold text-white bg-blue-500 rounded hover:bg-blue-700"
                    >
                        Open Modal
                    </button>
                    <!-- Model Component -->
                    <div
                        class="fixed inset-0 z-10 overflow-y-auto ease-out duration-400"
                        v-if="isOpen"
                    >
                        <div
                            class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0"
                        >
                            <div class="fixed inset-0 transition-opacity">
                                <div
                                    class="absolute inset-0 bg-gray-500 opacity-75"
                                ></div>
                            </div>
                            <span
                                class="hidden sm:inline-block sm:align-middle sm:h-screen"
                            ></span>
                            <div
                                class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-lg shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                                role="dialog"
                                aria-modal="true"
                                aria-labelledby="modal-headline"
                            >
                                <!-- Model Content Starts -->
                                <div class="mt-6 mb-16 ml-3 mr-3">
                                    <h1
                                        class="mb-4 font-bold leading-tight tracking-normal text-gray-800 font-lg"
                                    >
                                        Enter Billing Details
                                    </h1>
                                    <label
                                        for="name"
                                        class="text-sm font-bold leading-tight tracking-normal text-gray-800"
                                        >Owner Name</label
                                    >
                                    <input
                                        id="name"
                                        class="flex items-center w-full h-10 pl-3 mt-2 mb-5 text-sm font-normal text-gray-600 border border-gray-300 rounded focus:outline-none focus:border focus:border-indigo-700"
                                        placeholder="James"
                                    />
                                    <label
                                        for="email2"
                                        class="text-sm font-bold leading-tight tracking-normal text-gray-800"
                                        >Card Number</label
                                    >
                                    <div class="relative mt-2 mb-5">
                                        <div
                                            class="absolute flex items-center h-full px-4 text-gray-600 border-r"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-credit-card"
                                                width="20"
                                                height="20"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                />
                                                <rect
                                                    x="3"
                                                    y="5"
                                                    width="18"
                                                    height="14"
                                                    rx="3"
                                                />
                                                <line
                                                    x1="3"
                                                    y1="10"
                                                    x2="21"
                                                    y2="10"
                                                />
                                                <line
                                                    x1="7"
                                                    y1="15"
                                                    x2="7.01"
                                                    y2="15"
                                                />
                                                <line
                                                    x1="11"
                                                    y1="15"
                                                    x2="13"
                                                    y2="15"
                                                />
                                            </svg>
                                        </div>
                                        <input
                                            id="email2"
                                            class="flex items-center w-full h-10 pl-16 text-sm font-normal text-gray-600 border border-gray-300 rounded focus:outline-none focus:border focus:border-indigo-700"
                                            placeholder="XXXX - XXXX - XXXX - XXXX"
                                        />
                                    </div>
                                    <label
                                        for="expiry"
                                        class="text-sm font-bold leading-tight tracking-normal text-gray-800"
                                        >Expiry Date</label
                                    >
                                    <div class="relative mt-2 mb-5">
                                        <div
                                            class="absolute right-0 flex items-center h-full pr-3 text-gray-600 cursor-pointer"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-calendar-event"
                                                width="20"
                                                height="20"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                />
                                                <rect
                                                    x="4"
                                                    y="5"
                                                    width="16"
                                                    height="16"
                                                    rx="2"
                                                />
                                                <line
                                                    x1="16"
                                                    y1="3"
                                                    x2="16"
                                                    y2="7"
                                                />
                                                <line
                                                    x1="8"
                                                    y1="3"
                                                    x2="8"
                                                    y2="7"
                                                />
                                                <line
                                                    x1="4"
                                                    y1="11"
                                                    x2="20"
                                                    y2="11"
                                                />
                                                <rect
                                                    x="8"
                                                    y="15"
                                                    width="2"
                                                    height="2"
                                                />
                                            </svg>
                                        </div>
                                        <input
                                            id="expiry"
                                            class="flex items-center w-full h-10 pl-3 text-sm font-normal text-gray-600 border border-gray-300 rounded focus:outline-none focus:border focus:border-indigo-700"
                                            placeholder="MM/YY"
                                        />
                                    </div>
                                    <label
                                        for="cvc"
                                        class="text-sm font-bold leading-tight tracking-normal text-gray-800"
                                        >CVC</label
                                    >
                                    <div class="relative mt-2 mb-5">
                                        <div
                                            class="absolute right-0 flex items-center h-full pr-3 text-gray-600 cursor-pointer"
                                        >
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-info-circle"
                                                width="20"
                                                height="20"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor"
                                                fill="none"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                            >
                                                <path
                                                    stroke="none"
                                                    d="M0 0h24v24H0z"
                                                ></path>
                                                <circle
                                                    cx="12"
                                                    cy="12"
                                                    r="9"
                                                ></circle>
                                                <line
                                                    x1="12"
                                                    y1="8"
                                                    x2="12.01"
                                                    y2="8"
                                                ></line>
                                                <polyline
                                                    points="11 12 12 12 12 16 13 16"
                                                ></polyline>
                                            </svg>
                                        </div>
                                        <input
                                            id="cvc"
                                            class="flex items-center w-full h-10 pl-3 mb-8 text-sm font-normal text-gray-600 border border-gray-300 rounded focus:outline-none focus:border focus:border-indigo-700"
                                            placeholder="MM/YY"
                                        />
                                    </div>
                                    <div
                                        class="flex items-center justify-start w-full"
                                    >
                                        <button
                                            class="px-8 py-2 text-sm text-white transition duration-150 ease-in-out bg-indigo-700 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-700 hover:bg-indigo-600"
                                        >
                                            Submit
                                        </button>
                                        <button
                                            class="px-8 py-2 ml-3 text-sm text-gray-600 transition duration-150 ease-in-out bg-gray-100 border rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-400 hover:border-gray-400 hover:bg-gray-300"
                                            @click="closeModal"
                                        >
                                            Cancel
                                        </button>
                                    </div>
                                    <button
                                        class="absolute top-0 right-0 mt-4 mr-5 text-gray-400 transition duration-150 ease-in-out rounded cursor-pointer hover:text-gray-600 focus:ring-2 focus:outline-none focus:ring-gray-600"
                                        @click="closeModal"
                                        aria-label="close modal"
                                        role="button"
                                    >
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-x"
                                            width="20"
                                            height="20"
                                            viewBox="0 0 24 24"
                                            stroke-width="2.5"
                                            stroke="currentColor"
                                            fill="none"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                        >
                                            <path
                                                stroke="none"
                                                d="M0 0h24v24H0z"
                                            />
                                            <line
                                                x1="18"
                                                y1="6"
                                                x2="6"
                                                y2="18"
                                            />
                                            <line
                                                x1="6"
                                                y1="6"
                                                x2="18"
                                                y2="18"
                                            />
                                        </svg>
                                    </button>
                                </div>
                                <!-- Close Modal -->
                                <!-- <button
                                @click="closeModal"
                                type="button"
                                class="inline-flex justify-center w-full px-4 py-2 text-base font-medium leading-6 text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue sm:text-sm sm:leading-5"
                            >
                                Cancel
                            </button> -->
                                <!-- Model Content Ends -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";

import { usePage } from "@inertiajs/vue3";
import { watch } from "vue";
// Modal Code starts
import { ref } from "vue";

const isOpen = ref(false);

const openModal = () => {
    isOpen.value = true;
};

const closeModal = () => {
    isOpen.value = false;
};
// Modal Code Ends
const props = defineProps({
    blogs: Object,
    search: Object,
});

const form = useForm({});

function destroy(id) {
    if (confirm("Are you sure you want to delete the Blog")) {
        form.delete(route("blogs.destroy", id));
    }
}

// search function
const { blogs } = usePage().props;
console.log(usePage().props);
const selectedSearchOptions = ref([]); // Initialize selectedSearchOptions as an empty array
const search = ref("");
const filteredBlogs = ref(blogs);

const applySearchFilter = () => {
    const searchTerm = search.value.toLowerCase();
    filteredBlogs.value = blogs.filter((blog) => {
        return (
            selectedSearchOptions.value.length === 0 ||
            selectedSearchOptions.value.some((option) => {
                if (option === "id") {
                    return !search.value || blog[option] == search.value;
                } else if (option === "title") {
                    return (
                        typeof blog[option] === "string" &&
                        blog[option].toLowerCase().includes(searchTerm)
                    );
                } else if (option === "date") {
                    // Handle the date option
                    return (
                        typeof formatDate(blog.created_at) === "string" &&
                        formatDate(blog.created_at)
                            .toLowerCase()
                            .includes(searchTerm)
                    );
                } else if (!isNaN(search.value) && !isNaN(blog[option])) {
                    return (
                        parseFloat(blog[option]) === parseFloat(search.value)
                    );
                }
            })
        );
    });
};

watch([search, selectedSearchOptions], applySearchFilter);

// format date type
const formatDate = (datetime) => {
    // Format the datetime as YYYY-MM-DD
    const dateObj = new Date(datetime);
    if (isNaN(dateObj)) {
        return "";
    }
    const year = dateObj.getFullYear();
    const month = (dateObj.getMonth() + 1).toString().padStart(2, "0");
    const day = dateObj.getDate().toString().padStart(2, "0");
    return `${day}-${month}-${year}`;
};
//remove scroll from options if option is less
const checkOverflow = () => {
    const select = document.querySelector("select"); // Select the select element
    if (select.scrollHeight > select.clientHeight) {
        // Check if the content is overflowing
        select.style.overflowY = "scroll"; // If overflowing, enable the scrollbar
    } else {
        select.style.overflowY = "hidden"; // If not overflowing, hide the scrollbar
    }
};
</script>
