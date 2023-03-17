<template>
    <Head title="Edit Product"/>
    <div class="mx-auto w-3/4 rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
        <form @submit.prevent="form.post(route('products.update', { product: product.data.id }))">
            <div class="flex justify-between">
                <div class="w-full pr-6 space-y-5">
                    <div class="flex justify-between">
                        <div class="mr-3 w-1/2">
                            <InputLabel for="name" value="Name"/>
                            <TextInput
                                id="name"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.name"
                                autofocus
                                autocomplete="name"
                            />

                            <InputError class="mt-2" :message="form.errors.name"/>
                        </div>
                        <div class="w-1/2">
                            <InputLabel for="price" value="Price"/>

                            <TextInput
                                id="price"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.price"
                                autofocus
                                autocomplete="price"
                            />
                            <InputError class="mt-2" :message="form.errors.price"/>
                        </div>
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
                    <SelectInput
                        :selected="product.data.category_id"
                        name="category"
                        :collection="categories"
                        :error="form.errors.category_id"
                        emit="update-value-category"
                        @update-value-category="(value) => {form.category_id = value}
                    "/>
                    <SelectInput
                        :selected="product.data.brand_id"
                        name="brand"
                        :collection="brands"
                        :error="form.errors.brand_id"
                        emit="update-value-brand"
                        @update-value-brand="(value) => {form.brand_id = value}"
                    />
                    <div v-if="carModels.length" class="col-span-6 sm:col-span-3">
                        <label for="model_id" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">Model</label>
                        <select v-model="form.model_id" id="model_id" name="model_id" autocomplete="model_id"
                                class="mt-2 block w-full rounded-md border-0 bg-white text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 py-1.5 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:border-gray-500 dark:bg-gray-900 dark:text-gray-300 sm:text-sm sm:leading-6">
                            <option value="" disabled>Select</option>
                            <option v-for="carModel in carModels"
                                    :value="carModel.id">
                                {{ carModel.name }}
                            </option>
                        </select>
                        <InputError class="mt-2" :message="form.errors.model_id"/>
                    </div>
                    <div>
                        <div class="my-1">
                    <span
                        class="text-xs uppercase text-gray-400">Year must be between 1900 and {{
                            new Date().getFullYear()
                        }} </span>
                        </div>
                        <div class="flex items-center gap-3">
                            <InputLabel for="min_applicable_year" value="From"/>
                            <TextInput
                                id="min_applicable_year"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.min_applicable_year"
                                autocomplete="min_applicable_year"
                            />
                            <InputError class="mt-2" :message="form.errors.min_applicable_year"/>
                            <InputLabel for="max_applicable_year" value="To"/>
                            <TextInput
                                id="max_applicable_year"
                                type="number"
                                class="mt-1 block w-full"
                                v-model="form.max_applicable_year"
                                autocomplete="max_applicable_year"
                            />
                            <InputError class="mt-2" :message="form.errors.max_applicable_year"/>
                        </div>
                    </div>
                </div>
                <ImageInput :error="form.errors.image"
                            :image="props.product.data.image.hasOwnProperty('id') ? props.product.data.image : null"
                            @update-image="(file) => {form.image = file}"/>
            </div>
            <div class="mt-4 flex items-center">
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
import {onBeforeMount, ref, watch} from "vue";
import axios from "axios";
import SelectInput from "@/Components/SelectInput.vue";
import ImageInput from "@/Components/ImageInput.vue";

let props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    brands: {
        type: Object,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    }
})
let carModels = ref([])
let form = useForm(
    {
        name: props.product.data.name,
        description: props.product.data.description,
        price: props.product.data.price,
        brand_id: props.product.data.brand_id,
        category_id: props.product.data.category_id,
        model_id: '',
        image: '',
        min_applicable_year: props.product.data.year_from,
        max_applicable_year: props.product.data.year_to,
    })

watch(() => form.brand_id, async (newValue, oldValue) => {
        if (newValue !== oldValue) {
            let response = await axios.get(`/brands/${newValue}/car-models`)
            carModels.value = response.data
            form.model_id = ''
        }
    }
)
onBeforeMount(async () => {
    let response = await axios.get(`/brands/${form.brand_id}/car-models`)
    carModels.value = response.data
    form.model_id = props.product.data.model_id
})
</script>
