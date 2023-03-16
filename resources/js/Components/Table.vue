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
                <td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                    <Link :href="`${url}/${item.id}`">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width={1.5}
                             stroke="currentColor" class="h-6 w-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/>
                        </svg>
                    </Link>
                </td>
                <td v-if="can.update || can.delete" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
                    <div class="flex gap-3">
                        <Link v-if="can.update" :href="`${url}/${item.id}/edit`">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/>
                            </svg>
                        </Link>
                        <button v-if="can.delete" @click="confirmDeletion(item.id)">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke="currentColor" class="h-6 w-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                            </svg>
                        </button>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <Pagination :links="links"/>

    <Modal :show="confirmingDeletion" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg dark:text-gray-200 font-medium text-gray-900">
                Are you sure you want to delete?
            </h2>
            <p class="mt-1 text-sm dark:text-gray-500 text-gray-600">
                Once your delete it, all of its resources and data will be permanently deleted.
            </p>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Cancel</SecondaryButton>
                <DangerButton
                    class="ml-3"
                    :class="{ 'opacity-25': disabled }"
                    :disabled="disabled"
                    @click="deleteRow()"
                >
                    Delete
                </DangerButton>
            </div>
        </div>
    </Modal>

</template>

<script setup>
import Pagination from "@/Components/Pagination.vue";
import {router} from "@inertiajs/vue3";
import {ref} from "vue";
import Modal from "@/Components/Modal.vue";
import DangerButton from "@/Components/DangerButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

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
const confirmingDeletion = ref(false);
const truncateLength = 30;
const disabled = ref(false);

let truncateString = (str, num) => {
    if (str.length <= num) {
        return str;
    }
    return str.slice(0, num) + '...';
}

let deletableId = ref(null);
const confirmDeletion = (id) => {
    confirmingDeletion.value = true;
    deletableId.value = id;
};

const deleteRow = () => {
    disabled.value = true;
    router.delete(`${props.url}/${deletableId.value}`, {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            disabled.value = false;
        }
    });
};

const closeModal = () => {
    confirmingDeletion.value = false;
};
</script>
