<template>
    <Head title="Shop"/>
    <div>
        <div class="grid grid-flow-row grid-cols-3 gap-8">
            <ProductCard :product="product" v-for="product in allProducts" :key="product.id"/>
        </div>
        <div v-if="products.meta.links.length > 3" class="mt-5 flex justify-center dark:text-gray-300">
            <InfiniteLoading @infinite="load"/>
        </div>
    </div>
</template>
<script setup>
import ProductCard from "@/Components/ProductCard.vue";
import {ref} from "vue";
import InfiniteLoading from 'v3-infinite-loading';

let page = ref(2);
let props = defineProps({
    products: {
        type: Object,
        required: true,
    },
})
let allProducts = ref(props.products.data);
const load = async (state) => {
    let response = await axios.get(route('shop.indexData', {page: page.value}))
    let data = response.data.data;
    if(data.length === 0) {
        state.complete();
        return;
    }
    allProducts.value = allProducts.value.concat(data);
    page.value++;
    state.loaded();
}

</script>

