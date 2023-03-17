<template>
    <form @submit.prevent="addToCart">
        <h1 class="text-gray-700 dark:text-gray-300">Quantity:</h1>
        <div class="my-3 inline-flex">
            <div
                class="cursor-pointer select-none rounded-l border bg-gray-100 px-4 py-2 hover:bg-gray-700 dark:bg-gray-800 dark:text-gray-300"
                @click="decrease">
                -
            </div>

            <input disabled class="border p-2 text-center outline-none dark:bg-gray-900 dark:text-gray-200"
                   type="number" v-model="form.quantity"
                   :name="quantity"/>

            <div
                class="cursor-pointer select-none rounded-r border bg-gray-100 px-4 py-2 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
                @click="increase">
                +
            </div>
        </div>
        <button
            class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-sky-400 dark:bg-sky-500 dark:text-gray-800">
            Add to cart
            <svg aria-hidden="true" class="-mr-1 ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20"
                 xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                      d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                      clip-rule="evenodd"></path>
            </svg>
        </button>
    </form>
</template>
<script setup>

import {useForm, usePage} from "@inertiajs/vue3";
import Swal from "sweetalert2";

let props = defineProps(
    {
        productId: {
            type: Number,
            required: true
        },
    })

let form = useForm({
    quantity: 1,
    product_id: props.productId
})


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
        let response = await axios.post(route('products.addToCart', {product: props.productId}),
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
