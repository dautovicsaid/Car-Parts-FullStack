<template>

    <div class="mx-auto max-w-lg dark:text-gray-300">
        <h1 class="mb-4 text-3xl font-bold">Details</h1>
        <div class="max-w-xl overflow-hidden rounded shadow-lg dark:shadow-gray-700">
            <slot/>
            <div class="flex gap-3 px-6 py-4">
                <Link v-if="can.update" :href="`${$page.url}/edit`" class="hover:text-gray-300 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"  viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="h-6 w-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"/>
                    </svg>
                </Link>
                <DeleteModal v-if="can.delete" :url="$page.url"/>
            </div>
        </div>
    </div>
</template>
<script setup>
import DeleteModal from "@/Components/DeleteModal.vue";

defineProps({
    can: {
        type: Object,
        default: {}
    }
})
</script>
