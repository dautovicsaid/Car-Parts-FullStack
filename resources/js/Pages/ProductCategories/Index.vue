<template>
    <Head title="Product Categories"/>
    <div class="mb-4 flex justify-between">
        <PrimaryButton v-if="can.create" class="flex items-center">
            <Link :href="route('product-categories.create')">Create</Link>
        </PrimaryButton>
        <div class="relative">
            <input v-model="search" type="text" placeholder="Search..."
                   class="rounded-lg border border-gray-400 px-3 py-2 pr-8 focus:border-blue-500 focus:outline-none"/>
            <button
                class="absolute top-1/2 right-2 -translate-y-1/2 transform text-gray-500 hover:text-gray-700 focus:outline-none"
                @click="clearSearch">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    <Table :can="can" :items="productCategories.data" :columns="columns" :links="productCategories.meta.links"
           :url="$page.url.split('?')[0]"/>
</template>
<script setup>
import Table from "@/Components/Table.vue";
import {defineProps, ref, watch} from "vue";
import {router} from '@inertiajs/vue3'
import PrimaryButton from "@/Components/PrimaryButton.vue";

let props = defineProps({
    productCategories: {
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
];
let search = ref(props.filters.search);

watch(
    search,
    (value) => {
        router.get('/product-categories', {search: value}, {preserveState: true});
    },
);
</script>
