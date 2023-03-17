<template>
    <Head title="Car Models"/>
    <div class="mb-4 flex justify-between">
        <div>
            <CreateButton model-name="car-models" v-if="can.create"/>
            <ExportButton model-name="car-models"/>
        </div>
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
    <Table :can="can" :items="carModels.data" :columns="columns" :links="carModels.meta.links"
           :url="$page.url.split('?')[0]"/>
</template>
<script setup>
import Table from "@/Components/Table.vue";
import {defineProps, ref, watch} from "vue";
import {router} from '@inertiajs/vue3'
import PrimaryButton from "@/Components/PrimaryButton.vue";
import CreateButton from "@/Components/CreateButton.vue";
import ExportButton from "@/Components/ExportButton.vue";

let props = defineProps({
    carModels: {
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
    'brand',
];

let search = ref(props.filters.search);

watch(
    search,
    (value) => {
        router.get('/car-models', {search: value}, {preserveState: true});
    },
);

</script>
