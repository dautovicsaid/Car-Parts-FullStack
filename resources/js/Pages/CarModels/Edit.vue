<template>
    <Head title="Edit Car Model"/>
    <div class="mx-auto max-w-xl rounded-lg bg-white p-6 shadow-md">
        <form @submit.prevent="form.post(route('car-models.update',{carModel : carModel.data.id}))" class="space-y-5">
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
            <SelectInput :selected="carModel.data.brand_id" name="brand" :collection="brands"
                         :error="form.errors.brand_id" emit="update-value"
                         @update-value="(value) => {form.brand_id = value}"/>
            <ImageInput :image="carModel.data.image.hasOwnProperty('id') ? carModel.data.image : null"
                        :error="form.errors.image" @update-image="(file) => {form.image = file}"/>
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
import SelectInput from "@/Components/SelectInput.vue";

let props = defineProps({
    brands: {
        type: Object,
        required: true,
    },
    carModel: {
        type: Object,
        required: true,
    }
})

let form = useForm(
    {
        name: props.carModel.data.name,
        description: props.carModel.data.description,
        brand_id: props.carModel.data.brand_id,
        image: ''
    }
)


</script>
