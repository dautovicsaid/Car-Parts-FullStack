<template>
    <Head title="Edit Product Category"/>
    <div class="mx-auto max-w-xl rounded-lg bg-white p-6 shadow-md dark:bg-gray-800">
        <form @submit.prevent="form.post(route('product-categories.update',{
            productCategory: props.productCategory.data.id
        }))" class="space-y-5">
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
    productCategory: {
        type: Object,
        required: true,
    },
})
let form = useForm(
    {
        name: props.productCategory.data.name,
    }
)
</script>
