<template>
    <input type="file" @change="upload" class="hidden" id="file">
    <PrimaryButton :disabled="form.processing"><label for="file">Import</label></PrimaryButton>
</template>
<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import {useForm} from "@inertiajs/vue3";

let props = defineProps(
    {
        modelName: {
            type: String,
            required: true,
        },
    }
)

let form = useForm({
    file: null,
});


let upload = async(event) => {
    form.file = event.target.files[0];
    form.post(route(`import.${props.modelName}`), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('file');
        },
    });
}

</script>
