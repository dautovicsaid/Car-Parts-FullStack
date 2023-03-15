<template>
    <div class="grid grid-cols-3 grid-flow-row gap-8">
        <ProductCard :product="product" v-for="product in products.data" :key="product.id"/>
    </div>
</template>

<script setup>

import ProductCard from "@/Components/ProductCard.vue";

defineProps({
    products : {
        type: Array,
        required: true,
    },
})
</script>
