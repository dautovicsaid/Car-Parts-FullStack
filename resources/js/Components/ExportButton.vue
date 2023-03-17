<template>
    <PrimaryButton @click="download">Export</PrimaryButton>
</template>
<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";

let props = defineProps(
    {
        modelName: {
            type: String,
            required: true,
        },
    }
)
let download = async() => {
    const response = await axios.get(route(`export.${props.modelName}`), {
        responseType: 'blob',
    });

    const url = window.URL.createObjectURL(new Blob([response.data]));
    const link = document.createElement('a');
    link.href = url;
    link.setAttribute('download', `${props.modelName}-sheet.xlsx`);
    document.body.appendChild(link);
    link.click();
    link.remove();
}
</script>
