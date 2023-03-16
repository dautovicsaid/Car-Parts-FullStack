<template>
    <div class="grid max-w-sm rounded-lg border border-gray-200 bg-white shadow dark:border-gray-700 dark:bg-gray-800">
        <div
            class="flex border-b border-gray-200 bg-gray-50 px-3 py-3 w-[380px] h-[380px] dark:border-gray-600 dark:bg-gray-700">
            <img class="rounded rounded-t-lg border border-gray-100 object-cover shadow-sm" :src="product.image.path"
                 alt=""/>
        </div>
        <div class="p-5">
            <a href="#">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ product.name }}</h5>
            </a>
            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                {{ product.description ? truncateString(product.description, 30) : 'No description' }}</p>
            <div class="flex justify-between">
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">Model:
                    {{ `${product.brand} ${product.model} ` }}</p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ `Price: ${product.price} €` }}</p>
            </div>
            <div class="flex justify-between">
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ `Min year: ${product.year_from}` }}</p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{ `Max year: ${product.year_to}` }}</p>
            </div>
            <form @submit.prevent="addToCart">
                <div class="my-3 inline-flex">
                    <div class="cursor-pointer select-none rounded-l border bg-gray-100 px-4 py-2 hover:bg-gray-200"
                         @click="decrease">
                        -
                    </div>

                    <input disabled class="border p-2 text-center outline-none" type="number" v-model="form.quantity"
                           :name="quantity"/>

                    <div class="cursor-pointer select-none rounded-r border bg-gray-100 px-4 py-2 hover:bg-gray-200"
                         @click="increase">
                        +
                    </div>
                </div>
                <button
                    class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">
                    Add to cart
                    <svg aria-hidden="true" class="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"
                         xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</template>

<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import Swal from "sweetalert2";

let props = defineProps(
    {
        product: {
            type: Object,
            required: true
        }
    }
)

let form = useForm({
    product_id: props.product.id,
    quantity: 1
})

let truncateString = (str, num) => {
    if (str.length <= num) {
        return str;
    }
    return str.slice(0, num) + '...';
}

let increase = () => {
    form.quantity++;
}

let decrease = () => {
    if (form.quantity > 1) {
        form.quantity--;
    }
}

let addToCart = async () => {
    try {
        let response = await axios.post(route('products.addToCart', {product: props.product.id}),
            {quantity: form.quantity,})
        let data = await response.data;
        if (data.success) {
            usePage().props.order.items_count++;
            form.quantity = 1;
            Swal.fire({
                title: "Success!",
                text: data.message,
                icon: "success",
                button: "Ok",
            });
        }
    } catch (error) {
        Swal.fire({
            title: "Error!",
            text: error.response.data.message,
            icon: "error",
            button: "Ok",
        });
    }
}
</script>
