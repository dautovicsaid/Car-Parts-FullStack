<template>
    <div class="mt-4">
        <Component
            v-for="link in links"
            :is="link.url ? 'link' : 'span' "
            :href="link.url"
            v-html="link.label"
            class="px-1"
            :class="{
                'dark:text-gray-300' : true,
                'text-gray-500' : !link.url,
                'font-bold dark:text-white' : link.active
            }"/>
    </div>
</template>

<script setup>

defineProps({
    links: {
        type: Object,
        required: true,
    },
});

</script>
