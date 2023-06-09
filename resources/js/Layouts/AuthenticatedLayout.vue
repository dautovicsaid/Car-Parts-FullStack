<script setup>
import {ref, watchEffect, onMounted, computed, watch, onUnmounted} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link, usePage} from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import Cart from "@/Components/Cart.vue";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

if (usePage().props.auth.user.id === 3)
{
    Echo.private('orders')
        .listen('OrderConfirmedEvent', (e) => {
            orderId.value = e.order.id;
            order.value = e.order;
        });
}
const orderId = ref(null);
const options = {
    key: 'PUSHER_APP_KEY',
    authEndpoint: '/broadcasting/auth',
}
const showingNavigationDropdown = ref(false);
const showingCartSlider = ref(false);
const props = defineProps({
    flash: {
        type: Object,
        default: () => ({})
    },
})
const theme = ref(window.localStorage.getItem('theme') || 'light')

if (usePage().props.auth.user.id !== 3)
{
    Echo.private('orders')
        .listen('OrderConfirmedEvent', (e) => {
            orderId.value = e.order.id;
            order.value = e.order;
        });
}
watchEffect(
    () => {
        const newFlash = props.flash
        if (newFlash.success) {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: newFlash.success,
            })
        } else if (newFlash.error) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: newFlash.error
            })
        }
        if (theme.value === 'dark') {
            document.documentElement.classList.add('dark')
            window.localStorage.setItem('theme', 'dark')
        } else {
            document.documentElement.classList.remove('dark')
            window.localStorage.setItem('theme', 'light')
        }
    }
)

watch(
    () => orderId.value,
    (newValue,oldValue) => {
        if(newValue !== oldValue) {
            if (orderId.value) {
                toast.success('New order has been placed');
            }
        }
    })

const insertBetween = (items, insertion) => {
    return items.flatMap(
        (value, index, array) =>
            array.length - 1 !== index
                ? [value, insertion]
                : value,
    )
}

const breadcrumbs = computed(() => insertBetween(usePage().props.breadcrumbs || [], '/'))

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
    Echo.join('users');
})


onUnmounted(() => {
    Echo.leave('users');
})
</script>
<template>
    <div class="min-h-screen bg-gray-100">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <nav class="border-b border-gray-100 bg-white dark:border-gray-700 dark:bg-gray-800">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
                                    />
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink v-if="$page.props.auth.user.can.superAdmin" :href="route('users.index')"
                                         :active="route().current('users.*')">
                                    Users
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.can.shop" :href="route('shop.index')"
                                         :active="route().current('shop.*')">
                                    Shop
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.can.shop" :href="route('orders.history')"
                                         :active="route().current('orders.*')">
                                    History
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.can.admin" :href="route('brands.index')"
                                         :active="route().current('brands.*')">
                                    Brands
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.can.admin" :href="route('car-models.index')"
                                         :active="route().current('car-models.*')">
                                    Car Models
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.can.admin"
                                         :href="route('product-categories.index')"
                                         :active="route().current('product-categories.*')">
                                    Product Categories
                                </NavLink>
                                <NavLink v-if="$page.props.auth.user.can.admin" :href="route('products.index')"
                                         :active="route().current('products.*')">
                                    Products
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:ml-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative">
                            <button class="ml-3 rounded-lg text-sm text-gray-500 p-2.5 hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                                    v-if="$page.props.auth.user.can.shop">
                                <svg @click="showingCartSlider = true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                     viewBox="0 0 24 24"
                                     class="h-5 w-5"
                                     stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/>
                                </svg>
                                <span v-if="$page.props.order.items_count > 0" class="absolute top-2 left-8 h-5 w-5 -translate-y-1/2 transform rounded-full border-2 border-white bg-red-600 text-xs text-white dark:border-gray-800 dark:text-gray-300">{{ $page.props.order.items_count }}</span>
                            </button>
                                <button
                                    id="theme-toggle"
                                    type="button"
                                    @click="theme = theme === 'light' ? 'dark' : 'light'"
                                    class="ml-3 rounded-lg text-sm text-gray-500 p-2.5 hover:bg-gray-100 focus:outline-none dark:text-gray-400 dark:hover:bg-gray-700"
                                >
                                    <svg
                                        id="theme-toggle-dark-icon"
                                        class="h-5 w-5"
                                        :class="{ 'hidden': theme === 'light' }"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"
                                        ></path>
                                    </svg>
                                    <svg
                                        id="theme-toggle-light-icon"
                                        class="h-5 w-5"
                                        :class="{ 'hidden': theme === 'dark' }"
                                        fill="currentColor"
                                        viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                    >
                                        <path
                                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                                            fill-rule="evenodd"
                                            clip-rule="evenodd"
                                        ></path>
                                    </svg>
                                </button>
                                </div>
                            <div class="relative ml-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none dark:bg-gray-800 dark:text-gray-400 dark:hover:text-gray-300"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ml-2 h-4 w-4 -mr-0.5"
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
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none dark:hover-bg-gray-900 dark:focus-bg-gray-900 dark:text-gray-400 dark:hover:text-gray-400 dark:focus:text-gray-400"
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
                    <div class="border-t border-gray-200 pt-4 pb-1 dark:border-gray-600">
                        <div class="px-4">
                            <div class="text-base font-medium text-gray-800 dark:text-gray-200">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">{{ $page.props.auth.user.email }}</div>
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
            <header class="bg-white shadow dark:bg-gray-800">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-300">
                        <ol class="flex gap-1">
                            <li v-for="page in breadcrumbs">
                                <div>
                                    <span v-if="page ==='/'">/</span>
                                    <Link
                                        v-else
                                        :href="page.url"
                                        :class="{ 'text-indigo-700 dark:text-gray-100': page.current }"
                                    >{{ page.title }}</Link>
                                </div>
                            </li>
                        </ol>
                    </h2>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <section class="p-12">
                    <div class="container mx-auto">
                        <slot/>
                    </div>
                    <Cart @closeCartSlider="showingCartSlider = false" :showingCartSlider="showingCartSlider"/>
                </section>
            </main>
        </div>
    </div>
</template>
