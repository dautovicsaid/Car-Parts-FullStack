<template>
    <div class="flex justify-center gap-16">
        <div>
            <ShowCard>
                <img class="w-full" :src="product.data.image.path" alt="Brand image">
                <div class="px-6 py-4">
                    <div class="mb-2 text-xl font-bold">{{ product.data.name }}</div>
                    <p class="mb-2 text-base text-gray-700 dark:text-gray-300">{{product.data.category}}</p>
                    <p v-if="product.data.description" class="text-base text-gray-700 dark:text-gray-500">
                        {{ product.data.description }}
                    </p>
                    <div class="mt-3 flex w-3/4 justify-between">
                        <p class="text-base text-gray-700 dark:text-gray-300">
                            Model: {{ `${product.data.model} ${product.data.brand}` }}
                        </p>
                        <p class="text-base text-gray-700 dark:text-gray-300">
                            Price: {{ product.data.price }} €
                        </p>
                    </div>
                    <div class="mt-3 flex w-3/4 justify-between">
                        <p class="text-base text-gray-700 dark:text-gray-300">
                            Year from: {{ product.data.year_from }}
                        </p>
                        <p class="text-base text-gray-700 dark:text-gray-300">
                            Year to: {{ product.data.year_to }}
                        </p>
                    </div>
                </div>
            </ShowCard>
        </div>
        <div class="mt-10">
            <QuantityForm :productId="product.data.id"/>
        </div>
    </div>
</template>
<script setup>
import ShowCard from "@/Components/ShowCard.vue";
import QuantityForm from "@/Components/QuantityForm.vue";

defineProps({
    product: {
        type: Object,
        required: true
    }
})
</script>
