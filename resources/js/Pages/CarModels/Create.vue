<template>
    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6">
        <form @submit.prevent="form.post(route('car-models.store'))" class="space-y-5">
            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div>
                <InputLabel for="description" value="Description"/>

                <TextInput
                    id="description"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.description"
                />

                <InputError class="mt-2" :message="form.errors.description"/>
            </div>
            <div class="col-span-6 sm:col-span-3">
                <label for="brand_id" class="block text-sm font-medium leading-6 text-gray-900">Brand</label>
                <select v-model="form.brand_id" id="brand_id" name="brand_id" autocomplete="brand_id" class="mt-2 block w-full rounded-md border-0 bg-white py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <option value="" disabled>Select</option>
                    <option v-for="brand in brands" :value="brand.id">{{ brand.name }}</option>
                </select>
                <InputError class="mt-2" :message="form.errors.brand_id"/>
            </div>
            <div>
                <div class="flex items-center justify-center w-full">
                    <label for="image"
                           class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none"
                                 stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span>
                                or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG (MAX. 2MB)</p>
                        </div>
                        <input @input="form.image = $event.target.files[0]" id="image" name="image" type="file"
                               class="hidden"/>
                    </label>
                </div>
                <InputError class="mt-2" :message="form.errors.image"/>
            </div>

            <div class="flex items-center">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
            </div>
        </form>
    </div>
</template>
<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import {useForm} from "@inertiajs/vue3";

let props = defineProps({
    brands: {
        type: Object,
        required: true,
    },
})
let form = useForm(
    {
        name: '',
        description: '',
        brand_id: '',
        image: ''
    }
)


</script>
