<template>
    <div
        class="relative overflow-x-auto shadow-md sm:rounded-lg"
    >
        <table
            class="w-full table-auto text-left text-sm text-gray-500 dark:text-gray-400"
        >
            <thead
                class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400"
            >
            <tr>
                <th v-if="items[0].hasOwnProperty('image')" scope="col" class="px-6 py-3"> Image</th>
                <th scope="col" class="px-6 py-3" v-for="(column, index) in columns" :key="index"> {{ column }}</th>
                <th scope="col" class="px-6 py-3"> Show</th>
                <th v-if="can.update || can.delete" scope="col" class="px-6 py-3"> Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800" v-for="(item, index) in items"
                :key="index">
                <td v-if="item.image" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                    <div class="flex h-12 w-12">
                        <img class="rounded-full border border-gray-100 object-cover shadow-sm" :src="item.image.path" alt=" image"/>
                    </div>
                </td>
                <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white"
                    v-for="(column, indexColumn) in columns" :key="indexColumn">
                    {{ typeof item[column] === 'string' ? truncateString(item[column], truncateLength) : item[column] }}
                </td>
                <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 hover:text-gray-300 dark:text-gray-300 dark:hover:text-white">
                    <Link :href="`${url}/${item.id}`">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width={1.5}
                             stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                    </Link>
                </td>
                <td v-if="can.update || can.delete" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-gray-300">
                    <div class="flex gap-3">
                        <Link v-if="can.update" :href="`${url}/${item.id}/edit`" class="hover:text-gray-300 dark:hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/>
                            </svg>
                        </Link>
                        <DeleteModal v-if="can" :url="`${url}/${item.id}`"/>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <Pagination :links="links"/>

</template>

<script setup>
import Pagination from "@/Components/Pagination.vue";
import {router} from "@inertiajs/vue3";
import {ref} from "vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DeleteModal from "@/Components/DeleteModal.vue";

let props = defineProps({
    items: {
        type: Array,
        required: true,
    },
    columns: {
        type: Array,
        required: true,
    },
    links: {
        type: Array,
        required: true,
    },
    url: {
        type: String,
        required: true,
    },
    can : {
        type: Object,
        required: true,
    }
})
const truncateLength = 30;
const disabled = ref(false);

let truncateString = (str, num) => {
    if (str.length <= num) {
        return str;
    }
    return str.slice(0, num) + '...';
}
</script>
