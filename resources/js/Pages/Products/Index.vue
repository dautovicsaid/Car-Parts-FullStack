<template>
    <Head title="Products"/>
    <div class="mb-4 flex justify-between">
        <div>
            <CreateButton modelName="products"/>
            <ExportButton modelName="products"/>
            <ImportButton modelName="products"/>
        </div>
        <div class="relative">
            <input v-model="search" type="text" placeholder="Search..."
                   class="rounded-lg border border-gray-400 px-3 py-2 pr-8 focus:border-blue-500 focus:outline-none dark:placeholder-gray-400 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300"/>
            <button
                class="absolute top-1/2 right-2 -translate-y-1/2 transform text-gray-500 hover:text-gray-700 focus:outline-none"
                @click="clearSearch">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    <Table :can="can" :items="products.data" :columns="columns" :links="products.meta.links"
           :url="$page.url.split('?')[0]"/>
</template>
<script setup>
import Table from "@/Components/Table.vue";
import {defineProps, ref, watch} from "vue";
import {router} from '@inertiajs/vue3'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import ExportButton from "@/Components/ExportButton.vue";
import CreateButton from "@/Components/CreateButton.vue";
import ImportButton from "@/Components/ImportButton.vue";

let props = defineProps({
    products: {
        type: Object,
        required: true,
    },
    filters: {
        type: Object,
        required: true,
    },
    can: {
        type: Object,
        required: true,
    },
});
const columns = [
    'id',
    'name',
    'description',
    'category',
    'model',
    'brand',
    'price',
    'year_from',
    'year_to',
];
let search = ref(props.filters.search);
let download = async () => {
    const response = await axios.get(route('export.products'), {
        responseType: 'blob',
    });

    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', 'products-sheet.xlsx');
    document.body.appendChild(link);
    link.click();
    link.remove();
};

watch(
    search,
    (value) => {
        router.get('/products', {search: value}, {preserveState: true});
    },
);
</script>
