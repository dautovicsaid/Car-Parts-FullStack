<template>
    <Head title="Show Car Model"/>
    <ShowCard :can="can">
        <img class="w-full" :src="carModel.data.image.path" alt="Brand image">
        <div class="px-6 py-4">
            <div class="mb-2 text-xl font-bold">{{ carModel.data.name }}</div>
            <p v-if="carModel.data.description" class="text-base text-gray-700">
                {{ carModel.data.description }}
            </p>
        </div>
    </ShowCard>
</template>
<script setup>
import ShowCard from "@/Components/ShowCard.vue";

defineProps({
    carModel: {
        type: Object,
        required: true
    },
    can: {
        type: Object,
        required: true
    }
});
</script>
