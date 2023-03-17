<template>
    <div :class="['relative z-10', { 'hidden' : !showCartSlider}]" aria-labelledby="slide-over-title"
         role="dialog" aria-modal="true">
        <!--
          Background backdrop, show/hide based on slide-over state.

          Entering: "ease-in-out duration-500"
            From: "opacity-0"
            To: "opacity-100"
          Leaving: "ease-in-out duration-500"
            From: "opacity-100"
            To: "opacity-0"
        -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity dark:bg-gray-700e dark:bg-opacity-75"></div>

        <div class="fixed inset-0 overflow-hidden">
            <div class="absolute inset-0 overflow-hidden">
                <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10">
                    <!--
                      Slide-over panel, show/hide based on slide-over state.

                      Entering: "transform transition ease-in-out duration-500 sm:duration-700"
                        From: "translate-x-full"
                        To: "translate-x-0"
                      Leaving: "transform transition ease-in-out duration-500 sm:duration-700"
                        From: "translate-x-0"
                        To: "translate-x-full"
                    -->
                    <div class="pointer-events-auto w-screen max-w-md">
                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl dark:bg-gray-800">
                            <div class="flex-1 overflow-y-auto px-4 py-6 sm:px-6">
                                <div class="flex items-start justify-between">
                                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-300" id="slide-over-title">
                                        Shopping cart</h2>
                                    <div class="ml-3 flex h-7 items-center">
                                        <button type="button"
                                                class="-m-2 p-2 text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                                            <span class="sr-only">Close panel</span>
                                            <svg @click="closeCartSlider" class="h-6 w-6" fill="none"
                                                 viewBox="0 0 24 24" stroke-width="1.5"
                                                 stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="mt-8">
                                    <div class="flow-root">
                                        <ul v-if="hasOrderItems" role="list"
                                            class="-my-6 divide-y divide-gray-200 dark:divide-gray-500">
                                            <li v-for="orderItem in order.data.order_items"
                                                class="flex py-6">
                                                <div
                                                    class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 dark:border-gray-500">
                                                    <img :src="orderItem.product.image.path"
                                                         :alt="orderItem.product.image.name"
                                                         class="h-full w-full object-cover object-center">
                                                </div>

                                                <div class="ml-4 flex flex-1 flex-col">
                                                    <div>
                                                        <div
                                                            class="flex justify-between text-base font-medium text-gray-900 dark:text-gray-300">
                                                            <h3>
                                                                <a href="#">{{orderItem.product.name}}</a>
                                                            </h3>
                                                            <p class="ml-4">
                                                                {{ orderItem.product.price * orderItem.quantity }} €</p>
                                                        </div>
                                                        <p class="mt-1 text-sm text-gray-500">{{`${orderItem.product.brand} ${orderItem.product.model}`}}</p>
                                                        <p class="mt-1 text-sm text-gray-500">{{`${orderItem.product.year_from} - ${orderItem.product.year_to}`}}</p>
                                                    </div>
                                                    <div
                                                        class="flex flex-1 items-end justify-between text-sm">
                                                        <p class="text-gray-500">Qty
                                                            {{ orderItem.quantity }}</p>

                                                        <div class="flex">
                                                            <button @click="removeFromCart(orderItem.id)" type="button"
                                                                    class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-sky-500 dark:hover:text-sky-400">
                                                                Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div v-else>
                                            <div class="flex flex-col items-center justify-center" :class="{'xl:mt-40 3xl:mt-80' : !hasOrderItems }">
                                                <div>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-24 w-24 dark:text-gray-300">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                                    </svg>
                                                </div>
                                                <div class="my-auto flex flex-col items-center">
                                                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                        Your cart is empty
                                                    </h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t border-gray-200 px-4 py-6 sm:px-6">
                                <div v-if="hasOrderItems ">
                                    <div
                                         class="flex justify-between text-base font-medium text-gray-900 dark:text-gray-300">
                                        <p>Subtotal</p>
                                        <p>{{ order.data.subtotal }} €</p>
                                    </div>
                                    <div class="mt-6">
                                        <a @click="confirmOrder"
                                           class="flex cursor-pointer items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700 dark:bg-sky-600 dark:text-gray-800 dark:hover:bg-sky-500">Confirm</a>
                                    </div>
                                </div>
                                <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                    <p>
                                        <button @click="closeCartSlider" type="button"
                                                class="font-medium text-indigo-600 hover:text-indigo-500 dark:text-sky-500 dark:hover:text-sky-400">
                                            Continue Shopping
                                            <span aria-hidden="true"> &rarr;</span>
                                        </button>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Swal from "sweetalert2";
import {ref, watch, watchEffect} from "vue";
import { defineEmits} from "vue";
import {usePage} from "@inertiajs/vue3";


const order = ref({});
const hasOrderItems = ref(order.data?.order_items.length > 0);

let props = defineProps(
    {
        showingCartSlider: {
            type: Boolean,
            required: true
        },
    })

let emit = defineEmits(['closeCartSlider']);
let showCartSlider = ref(false);

watch(order, (newVal, oldVal) => {

    hasOrderItems.value = newVal.data.order_items?.length > 0;
})

watchEffect(() => {
    if (props.showingCartSlider) {
        openCartSlider();
    }
})
let openCartSlider = async () => {
    let response = await axios.get(route('cart.show'));
    let data = await response.data;
    if(data.data.order_items > 0){
        data.data.order_items = data.data.order_items.sort((a, b) => {
            return b.id - a.id;
        })
    }
    order.value = data;
    showCartSlider.value = true;
}


let closeCartSlider = () => {
    emit('closeCartSlider');
    showCartSlider.value = false;
}

let removeOrderItem = async (id) => {
    let response = await axios.delete(route('orders.removeFromCart', {
        order : order.value.data.id,
        orderItem : id
    }));
    let data = await response.data;
    if (data.success) {
        usePage().props.order.items_count--;
        // decrease subtotal by order item price
        order.value.data.order_items =
            order.value.data.order_items.filter((item) => {
                if (item.id === id){
                    order.value.data.subtotal = order.value.data.subtotal - item.product.price * item.quantity;
                    return false;
                }
                return true;
            })
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: data.message
        })
    }
}

let confirmOrder = async () => {
    try {
        let response = await axios.post(route('orders.confirm', {order: order.value.data.id}),{
            total_price: order.value.data.subtotal
        });
        let data = await response.data;
        if (data.success) {
            usePage().props.order.items_count = 0;
            emit('closeCartSlider');
            showCartSlider.value = false;
            order.value.data.status = 'confirmed';
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message
            })}
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: error.response.data.message
        })
    }
}

let removeFromCart = (id) => {
    console.log()
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            removeOrderItem(id);
        }
    })
}
</script>
