<template>
    <Head title="Show Product Category"/>
    <ShowCard :can="can">
        <div class="px-6 py-4">
            <div class="mb-2 text-xl font-bold">{{ productCategory.data.name }}</div>
        </div>
    </ShowCard>
</template>
<script setup>
import ShowCard from "@/Components/ShowCard.vue";

defineProps({
    productCategory: {
        type: Object,
        required: true
    },
    can: {
        type: Object,
        required: true
    }
});
</script>
