<template>
    <Head title="Edit Brand"/>
    <div class="mx-auto max-w-xl rounded-lg bg-white dark:bg-gray-800 p-6 shadow-md">
        <form @submit.prevent="form.post(route('brands.update', {
            brand : brand.data.id
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
            <ImageInput :error="form.errors.image"
                        :image="props.brand.data.image.hasOwnProperty('id') ? props.brand.data.image : null"
                        @update-image="(file) => {form.image = file}"/>
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
import ImageInput from "@/Components/ImageInput.vue";

let props = defineProps({
    brand: {
        type: Object,
        required: true,
    },
})
let form = useForm(
    {
        name: props.brand.data.name,
        description: props.brand.data.description,
        image: ''
    }
)


</script>
