<template>
    <Head title="Shop"/>
    <div class="grid grid-flow-row grid-cols-3 gap-8">
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
