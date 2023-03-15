<template>
    <Head title="Show Product"/>
    <div class="max-w-lg mx-auto">
        <h1 class="text-3xl font-bold mb-4">Details</h1>
        <div class="max-w-xl rounded overflow-hidden shadow-lg">
            <img class="w-full" :src="product.data.image.path" alt="Brand image">
            <div class="px-6 py-4">
                <div class="font-bold text-xl mb-2">{{ product.data.name }}</div>
                <p v-if="product.data.description" class="text-gray-700 text-base">
                    {{ product.data.description }}
                </p>
                <div class="flex justify-between w-3/4 mt-3">
                    <p  class="text-gray-700 text-base">
                        Model: {{ `${product.data.model} ${product.data.brand}` }}
                    </p>
                    <p  class="text-gray-700 text-base">
                        Price: {{ product.data.price}} €
                    </p>
                </div>
                <div class="flex justify-between w-3/4 mt-3">
                    <p  class="text-gray-700 text-base">
                        Year from: {{ product.data.year_from }}
                    </p>
                    <p  class="text-gray-700 text-base">
                       Year to: {{ product.data.year_to }}
                    </p>
                </div>
            </div>
            <div class="flex gap-3 px-6 py-4">
                <Link v-if="can.update" :href="`${$page.url}/edit`">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-6 h-6">
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
    product: {
        type: Object,
        required: true
    },
    can : {
        type: Object,
        required: true
    }
});
</script>
