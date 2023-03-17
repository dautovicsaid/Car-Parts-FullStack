<template>
    <Head title="Order history" />
        <div class="bg-white dark:bg-gray-800">
            <div v-if="allOrders.length > 0" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8 lg:pb-24">
                <div class="max-w-xl">
                    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-gray-300 sm:text-3xl">Order history</h1>
                    <p class="mt-2 text-sm text-gray-500">Here are all orders you made.</p>
                </div>

                <div class="mt-16">
                    <h2 class="sr-only">Recent orders</h2>

                    <div class="space-y-20">
                        <div v-for="order in allOrders">
                            <h3 class="sr-only">Order created <time>{{order.ordered_at}}</time></h3>

                            <div class="rounded-lg bg-gray-50 bg-gray-700 px-4 py-6 sm:space-x-6 sm:flex sm:items-center sm:justify-between sm:px-6 lg:space-x-8">
                                <dl class="flex-auto text-sm text-gray-600 divide-y divide-gray-200 space-y-6 dark:divide-gray-500 dark:text-gray-500 sm:divide-y-0 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-x-6 lg:w-1/2 lg:flex-none lg:gap-x-8">
                                    <div class="flex justify-between sm:block">
                                        <dt class="font-medium text-gray-900 dark:text-gray-300">Date placed</dt>
                                        <dd class="sm:mt-1">
                                            <time class="dark:text-gray-500" >{{order.ordered_at}}</time>
                                        </dd>
                                    </div>
                                    <div class="flex justify-between pt-6 sm:block sm:pt-0">
                                        <dt class="font-medium text-gray-900 dark:text-gray-300">Order number</dt>
                                        <dd class="dark:text-gray-500 sm:mt-1">
                                            {{ order.id }}
                                        </dd>
                                    </div>
                                    <div class="flex justify-between pt-6 font-medium text-gray-900 dark:text-gray-300 sm:block sm:pt-0">
                                        <dt>Total amount</dt>
                                        <dd class="dark:text-gray-500 sm:mt-1">
                                            {{ order.subtotal }} €
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <table class="mt-4 w-full text-gray-500 dark:text-gray-300 sm:mt-6">
                                <caption class="sr-only">
                                    Products
                                </caption>
                                <thead class="sr-only text-left text-sm text-gray-500 dark:text-gray-300 sm:not-sr-only">
                                <tr>
                                    <th scope="col" class="py-3 pr-8 font-normal sm:w-2/5 lg:w-1/3">Product</th>
                                    <th scope="col" class="hidden w-1/5 py-3 pr-8 font-normal sm:table-cell">Price</th>
                                    <th scope="col" class="hidden py-3 pr-8 font-normal sm:table-cell">Status</th>
                                    <th scope="col" class="w-0 py-3 text-right font-normal">Info</th>
                                </tr>
                                </thead>
                                <tbody class="border-b border-gray-200 text-sm divide-y divide-gray-200 sm:border-t">
                                <tr v-for="item in order.order_items">
                                    <td class="py-6 pr-8">
                                        <div class="flex items-center">
                                            <img :src="item.product.image.path" alt="Detail of mechanical pencil tip with machined black steel shaft and chrome lead tip." class="mr-6 h-16 w-16 rounded object-cover object-center">
                                            <div>
                                                <div class="font-medium text-gray-900 dark:text-gray-300">{{ item.product.name }}</div>
                                                <div class="text-sm text-gray-500">{{ `${item.product.brand} ${item.product.model}` }}</div>
                                                <div class="text-sm text-gray-500">{{ `${item.product.year_from} - ${item.product.year_to}` }}</div>
                                                <div class="mt-1 sm:hidden">{{item.product.price*item.quantity}}€</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="hidden py-6 pr-8 sm:table-cell">
                                        {{item.product.price*item.quantity}}€
                                    </td>
                                    <td class="hidden py-6 pr-8 sm:table-cell">
                                        Pending
                                    </td>
                                    <td class="whitespace-nowrap py-6 text-right font-medium">
                                        <Link :href="route('shop.productShow',{ product : item.product.id})" class="text-indigo-600 hover:text-indigo-700 dark:text-sky-500 dark:hover:text-sky-400">View<span class="hidden lg:inline"> Product</span></Link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="w-full px-4 py-16 sm:px-6 lg:px-8 lg:pb-24">
                <div class="flex w-full justify-center">
                    <h1 class="text-center text-2xl font-extrabold tracking-tight text-gray-900 dark:text-gray-300 sm:text-3xl">You haven't made any orders yet</h1>
                    </div>

            </div>
        </div>
    <div v-if="orders.meta.links.length > 3" class="mt-5 flex justify-center dark:text-gray-300">
        <InfiniteLoading  @infinite="load" />
    </div>
</template>
<script setup>
import InfiniteLoading from 'v3-infinite-loading';
import {router} from "@inertiajs/vue3";
import {ref} from "vue";

let props = defineProps({
    orders : {
        type: Object,
        required: true,
    },
})

let allOrders = ref(props.orders.data);
let page = ref(2);

const load = async (state) => {
    router.visit(route('orders.history',{page:page.value}), {
        preserveState: true,
        preserveScroll: true,
        replace: true,
        only: ['orders'],
        onSuccess: () => {
            if (props.orders.data.length === 0) {
                state.complete();
                return;
            }
            allOrders.value = allOrders.value.concat(props.orders.data);
            page.value++;
            state.loaded();
        },
    })
}
</script>
