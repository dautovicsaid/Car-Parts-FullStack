<script setup>
import {ref, watchEffect, onMounted} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link, usePage} from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const showingNavigationDropdown = ref(false);
const showingCartSlider = ref(false);
const order = ref({});
const props = defineProps({
    flash: {
        type: Object,
        default: () => ({})
    }
})


onMounted(() => {
    if (props.flash.success) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: props.flash.success
        })
    } else if (props.flash.error) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: props.flash.error
        })
    }
})

watchEffect(() => {
    const newFlash = props.flash

    if (newFlash.success) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: newFlash.success
        })
    } else if (newFlash.error) {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: newFlash.error
        })
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
    showingCartSlider.value = true;
}

let closeCartSlider = () => {
    showingCartSlider.value = false;
}

let removeOrderItem = async (id) => {
    let response = await axios.delete(route('orders.removeFromCart', {
        order : order.value.data.id,
        orderItem : id
    }));
    let data = await response.data;
    if (data.success) {
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
    let response = await axios.post(route('orders.confirm', {order: order.value.data.id}),{
        total_price: order.value.data.subtotal
    });
    let data = await response.data;
    if (data.success) {
        showingCartSlider.value = false;
        order.value.data.status = 'confirmed';
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: data.message
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

<template>
    <div class="min-h-screen bg-gray-100">
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink v-if="$page.props.auth.user.can.shop" :href="route('shop.index')"
                                         :active="route().current('shop.*')">
                                    Shop
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.can.admin" :href="route('brands.index')" :active="route().current('brands.*')">
                                    Brands
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.can.admin" :href="route('car-models.index')" :active="route().current('car-models.*')">
                                    Car Models
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.can.admin" :href="route('product-categories.index')"
                                         :active="route().current('product-categories.*')">
                                    Product Categories
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.can.admin" :href="route('products.index')"
                                         :active="route().current('products.*')">
                                    Products
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6">
                            <!-- Settings Dropdown -->
                            <button v-if="$page.props.auth.user.can.shop" class="cursor-pointer">
                                <svg @click="openCartSlider" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                                </svg>
                            </button>
                            <div class="ml-3 relative">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ml-2 -mr-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink :href="route('profile.edit')"> Profile</DropdownLink>
                                        <DropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = true"
                                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                            >
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :href="route('brands.index')" :active="route().current('brands.*')">
                            Brands
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('car-models.index')" :active="route().current('car-models.*')">
                            Car Models
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('product-categories.index')"
                                           :active="route().current('product-categories.*')">
                            Product Categories
                        </ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('products.index')"
                                           :active="route().current('products.*')">
                            Products
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"> Profile</ResponsiveNavLink>
                            <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ $page.component.split('/')[0] }}</h2>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <section class="p-12">
                    <div class="container mx-auto">
                        <slot/>
                    </div>
                    <div :class="['relative z-10', { 'hidden' : !showingCartSlider}]" aria-labelledby="slide-over-title"
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
                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

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
                                        <div class="flex h-full flex-col overflow-y-scroll bg-white shadow-xl">
                                            <div class="flex-1 overflow-y-auto py-6 px-4 sm:px-6">
                                                <div class="flex items-start justify-between">
                                                    <h2 class="text-lg font-medium text-gray-900" id="slide-over-title">
                                                        Shopping cart</h2>
                                                    <div class="ml-3 flex h-7 items-center">
                                                        <button type="button"
                                                                class="-m-2 p-2 text-gray-400 hover:text-gray-500">
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
                                                        <ul v-if="order.data" role="list"
                                                            class="-my-6 divide-y divide-gray-200">
                                                            <li v-for="orderItem in order.data.order_items"
                                                                class="flex py-6">
                                                                <div
                                                                    class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                                                    <img :src="orderItem.product.image.path"
                                                                         alt="Salmon orange fabric pouch with match zipper, gray zipper pull, and adjustable hip belt."
                                                                         class="h-full w-full object-cover object-center">
                                                                </div>

                                                                <div class="ml-4 flex flex-1 flex-col">
                                                                    <div>
                                                                        <div
                                                                            class="flex justify-between text-base font-medium text-gray-900">
                                                                            <h3>
                                                                                <a href="#">{{
                                                                                        orderItem.product.name
                                                                                    }}</a>
                                                                            </h3>
                                                                            <p class="ml-4">
                                                                                {{ orderItem.product.price*orderItem.quantity }} €</p>
                                                                        </div>
                                                                        <p class="mt-1 text-sm text-gray-500">{{
                                                                                `${orderItem.product.brand} ${orderItem.product.model}`
                                                                            }}</p>
                                                                        <p class="mt-1 text-sm text-gray-500">{{
                                                                                `${orderItem.product.year_from} - ${orderItem.product.year_to}`
                                                                            }}</p>
                                                                    </div>
                                                                    <div
                                                                        class="flex flex-1 items-end justify-between text-sm">
                                                                        <p class="text-gray-500">Qty
                                                                            {{ orderItem.quantity }}</p>

                                                                        <div class="flex">
                                                                            <button @click="removeFromCart(orderItem.id)" type="button"
                                                                                    class="font-medium text-indigo-600 hover:text-indigo-500">
                                                                                Remove
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                                                <div v-if="order.data"
                                                     class="flex justify-between text-base font-medium text-gray-900">
                                                    <p>Subtotal</p>
                                                    <p>{{ order.data.subtotal }} €</p>
                                                </div>
                                                <div class="mt-6">
                                                    <a @click="confirmOrder"
                                                       class="flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-indigo-700">Confirm</a>
                                                </div>
                                                <div class="mt-6 flex justify-center text-center text-sm text-gray-500">
                                                    <p>
                                                        or
                                                        <button @click="closeCartSlider" type="button"
                                                                class="font-medium text-indigo-600 hover:text-indigo-500">
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

                </section>
            </main>
        </div>
    </div>
</template>
