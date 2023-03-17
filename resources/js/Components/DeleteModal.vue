<template>
    <div>
        <button @click="confirmDeletion" class="hover:text-gray-300 dark:hover:text-white">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                 stroke="currentColor" class="h-6 w-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
            </svg>
        </button>
        <Modal :show="confirmingDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-200">
                    Are you sure you want to delete?
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Once your delete it, all of its resources and data will be permanently deleted.
                </p>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel</SecondaryButton>
                    <DangerButton
                        class="ml-3"
                        :class="{ 'opacity-25': disabled }"
                        :disabled="disabled"
                        @click="deleteModel()"
                    >
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

let props = defineProps({
    url: {
        type: String,
        required: true
    }
});

let disabled = ref(false);
let confirmingDeletion = ref(false);
const confirmDeletion = () => {
    confirmingDeletion.value = true;
};

const deleteModel = () => {
    disabled.value = true;
    router.delete(props.url, {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            disabled.value = false;
        }
    });
};
const closeModal = () => {
    confirmingDeletion.value = false;
};

</script>
