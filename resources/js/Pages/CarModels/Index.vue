<template>

    <Head title="Car Models"/>
    <div class="flex justify-between mb-4">
        <PrimaryButton v-if="can.create" class="flex items-center">
            <Link :href="route('car-models.create')">Create</Link>
        </PrimaryButton>
        <div class="relative">
            <input v-model="search" type="text" placeholder="Search..." class="border border-gray-400 rounded-lg py-2 px-3 pr-8 focus:outline-none focus:border-blue-500"/>
            <button class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 focus:outline-none" @click="clearSearch">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
    <Table :can="can" :items="carModels.data" :columns="columns" :links="carModels.meta.links" :url="$page.url.split('?')[0]"/>
</template>

<script setup>

import Table from "@/Components/Table.vue";
import {defineProps, ref, watch} from "vue";
import { router } from '@inertiajs/vue3'
import PrimaryButton from "@/Components/PrimaryButton.vue";

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
    'brand',
];

let search = ref(props.filters.search);

watch(
    search,
    (value) => {
        router.get('/car-models', { search: value }, { preserveState: true });
    },
);

</script>
