<template>
    <div class="relative">
        <input v-model="search" type="text" placeholder="Search..."
               class="rounded-lg border border-gray-400 px-3 py-2 pr-8 focus:border-blue-500 focus:outline-none"/>
        <button
            class="absolute top-1/2 right-2 -translate-y-1/2 transform text-gray-500 hover:text-gray-700 focus:outline-none"
            @click="clearSearch">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>
</template>
<script setup>

</script>
