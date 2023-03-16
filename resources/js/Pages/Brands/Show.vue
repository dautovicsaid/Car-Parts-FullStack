<template>
    <Head title="Show Brand"/>
    <ShowCard :can="can">
        <img class="w-full" :src="brand.data.image.path" alt="Brand image">
        <div class="px-6 py-4">
            <div class="mb-2 text-xl font-bold">{{ brand.data.name }}</div>
            <p v-if="brand.data.description" class="text-base text-gray-700 dark:text-gray-500">
                {{ brand.data.description }}
            </p>
        </div>
    </ShowCard>
</template>
<script setup>
import ShowCard from "@/Components/ShowCard.vue";

defineProps({
    brand: {
        type: Object,
        required: true
    },
    can: {
        type: Object,
        required: true
    }
});
</script>
