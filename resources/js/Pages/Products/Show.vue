<template>
    <Head title="Show Product"/>
    <ShowCard :can="can">
        <img class="w-full" :src="product.data.image.path" alt="Brand image">
        <div class="px-6 py-4">
            <div class="mb-2 text-xl font-bold">{{ product.data.name }}</div>
            <p v-if="product.data.description" class="text-base text-gray-700">
                {{ product.data.description }}
            </p>
            <div class="mt-3 flex w-3/4 justify-between">
                <p class="text-base text-gray-700">
                    Model: {{ `${product.data.model} ${product.data.brand}` }}
                </p>
                <p class="text-base text-gray-700">
                    Price: {{ product.data.price }} €
                </p>
            </div>
            <div class="mt-3 flex w-3/4 justify-between">
                <p class="text-base text-gray-700">
                    Year from: {{ product.data.year_from }}
                </p>
                <p class="text-base text-gray-700">
                    Year to: {{ product.data.year_to }}
                </p>
            </div>
        </div>
    </ShowCard>
</template>

<script setup>
import ShowCard from "@/Components/ShowCard.vue";

defineProps({
    product: {
        type: Object,
        required: true
    },
    can: {
        type: Object,
        required: true
    }
});
</script>
