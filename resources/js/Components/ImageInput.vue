<template>
    <div class="w-full space-y-6">
        <div v-if="src" class="grid place-content-center">
            <img class="mt-3 h-80 rounded border border-gray-100 object-cover shadow-sm w-160"
                 :src="src" alt="user image"/>
        </div>
        <div class="flex items-center justify-center">
            <div class="w-full">
                <label for="image"
                       class="flex h-32 w-full cursor-pointer flex-col items-center justify-center rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 hover:bg-gray-100 dark:border-gray-600 dark:bg-gray-700 dark:hover:bg-bray-800 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                        <svg aria-hidden="true" class="mb-3 h-10 w-10 text-gray-400" fill="none"
                             stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span
                            class="font-semibold">Click to upload</span>
                            or drag and drop</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG (MAX. 2MB)</p>
                    </div>
                    <input @change="onImageChange" id="image" name="image" type="file"
                           accept="image/png, image/gif, image/jpeg"
                           class="hidden"/>
                </label>
                <InputError class="mt-2 text-center" :message="error"/>
            </div>
        </div>
    </div>
</template>
<script setup>
import {defineEmits, ref} from "vue";
import InputError from "@/Components/InputError.vue";

let props = defineProps({
    image: {
        type: Object,
        default: null
    },
    error: {
        type: String,
        default: null
    }
})

let src = ref(props.image ? props.image.path : null);

const emit = defineEmits(['update-image']);
let onImageChange = (event) => {
    emit('update-image', event.target.files[0]);
    src.value = URL.createObjectURL(event.target.files[0]);
}
</script>
