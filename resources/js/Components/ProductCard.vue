<template>
    <div class="grid max-w-sm rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-800">
        <Link :href="route('shop.productShow',{product:product.id})"
            class="flex border-b border-gray-200 bg-gray-50 px-3 py-3 w-[380px] h-[380px] dark:border-gray-600 dark:bg-gray-700">
            <img class="rounded rounded-t-lg border border-gray-100 object-cover shadow-sm" :src="product.image.path"
                 alt=""/>
        </Link>
        <div class="p-5">
            <Link :href="route('shop.productShow',{product:product.id})">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-300">{{ product.name }}</h5>
            </Link>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-300">
                {{ product.description ? truncateString(product.description, 30) : 'No description' }}</p>
            <div class="flex justify-between">
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-300">Model:
                    {{ `${product.brand} ${product.model} ` }}</p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-300">{{ `Price: ${product.price} €` }}</p>
            </div>
            <div class="flex justify-between">
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-300">{{ `Min year: ${product.year_from}` }}</p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-300">{{ `Max year: ${product.year_to}` }}</p>
            </div>
            <QuantityForm :productId="product.id"/>
        </div>
    </div>
</template>

<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import Swal from "sweetalert2";
import QuantityForm from "@/Components/QuantityForm.vue";

let props = defineProps(
    {
        product: {
            type: Object,
            required: true
        },
    }
)


let truncateString = (str, num) => {
    if (str.length <= num) {
        return str;
    }
    return str.slice(0, num) + '...';
}
</script>
