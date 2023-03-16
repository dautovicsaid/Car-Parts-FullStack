<template>
    <Head title="Order history" />
        <div class="bg-white dark:bg-gray-800">
            <div v-if="orders.data.length > 0" class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:pb-24 lg:px-8">
                <div class="max-w-xl">
                    <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 dark:text-gray-300 sm:text-3xl">Order history</h1>
                    <p class="mt-2 text-sm text-gray-500">Here are all orders you made.</p>
                </div>

                <div class="mt-16">
                    <h2 class="sr-only">Recent orders</h2>

                    <div class="space-y-20">
                        <div v-for="order in orders.data">
                            <h3 class="sr-only">Order created <time>{{order.ordered_at}}</time></h3>

                            <div class="bg-gray-50 bg-gray-700 rounded-lg py-6 px-4 sm:px-6 sm:flex sm:items-center sm:justify-between sm:space-x-6 lg:space-x-8">
                                <dl class="divide-y divide-gray-200 dark:divide-gray-500 space-y-6 text-sm text-gray-600 dark:text-gray-500 flex-auto sm:divide-y-0 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-x-6 lg:w-1/2 lg:flex-none lg:gap-x-8">
                                    <div class="flex justify-between sm:block">
                                        <dt class="font-medium text-gray-900 dark:text-gray-300">Date placed</dt>
                                        <dd class="sm:mt-1">
                                            <time class="dark:text-gray-500" >{{order.ordered_at}}</time>
                                        </dd>
                                    </div>
                                    <div class="flex justify-between pt-6 sm:block sm:pt-0">
                                        <dt class="font-medium text-gray-900 dark:text-gray-300">Order number</dt>
                                        <dd class="sm:mt-1 dark:text-gray-500">
                                            {{ order.id }}
                                        </dd>
                                    </div>
                                    <div class="flex justify-between pt-6 font-medium text-gray-900 dark:text-gray-300 sm:block sm:pt-0">
                                        <dt>Total amount</dt>
                                        <dd class="sm:mt-1 dark:text-gray-500">
                                            {{ order.subtotal }} €
                                        </dd>
                                    </div>
                                </dl>
                            </div>

                            <table class="mt-4 w-full text-gray-500 dark:text-gray-300 sm:mt-6">
                                <caption class="sr-only">
                                    Products
                                </caption>
                                <thead class="sr-only text-sm text-gray-500 dark:text-gray-300 text-left sm:not-sr-only">
                                <tr>
                                    <th scope="col" class="sm:w-2/5 lg:w-1/3 pr-8 py-3 font-normal">Product</th>
                                    <th scope="col" class="hidden w-1/5 pr-8 py-3 font-normal sm:table-cell">Price</th>
                                    <th scope="col" class="hidden pr-8 py-3 font-normal sm:table-cell">Status</th>
                                    <th scope="col" class="w-0 py-3 font-normal text-right">Info</th>
                                </tr>
                                </thead>
                                <tbody class="border-b border-gray-200 divide-y divide-gray-200 text-sm sm:border-t">
                                <tr v-for="item in order.order_items">
                                    <td class="py-6 pr-8">
                                        <div class="flex items-center">
                                            <img :src="item.product.image.path" alt="Detail of mechanical pencil tip with machined black steel shaft and chrome lead tip." class="w-16 h-16 object-center object-cover rounded mr-6">
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
                                    <td class="py-6 font-medium text-right whitespace-nowrap">
                                        <a href="#" class="text-indigo-600 dark:text-sky-500 hover:text-indigo-700 dark:hover:text-sky-400">View<span class="hidden lg:inline"> Product</span></a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else class="w-full  py-16 px-4 sm:px-6 lg:pb-24 lg:px-8">
                <div class="flex w-full justify-center">
                    <h1 class="text-2xl text-center font-extrabold tracking-tight text-gray-900 dark:text-gray-300 sm:text-3xl">You haven't made any orders yet</h1>
                    </div>

            </div>
        </div>
</template>

<script setup>
defineProps({
    orders : {
        type: Object,
        required: true,
    },
})
</script>
