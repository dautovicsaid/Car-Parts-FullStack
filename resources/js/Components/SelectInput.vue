<template>
    <div class="col-span-6 sm:col-span-3">
        <label :for="`${name}_id`" class="block text-sm font-medium leading-6 text-gray-900 dark:text-gray-300">{{name.charAt(0).toUpperCase()+name.slice(1)}}</label>
        <select @change="optionChange" :id="`${name}_id`" :name="`${name}_id`" :autocomplete="`${name}_id`" class="mt-2 block w-full rounded-md border-0 bg-white text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 py-1.5 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 sm:text-sm sm:leading-6">
            <option value="" selected disabled>Select</option>
            <option v-for="item in collection" :selected="selectedOption(item.id)" :value="item.id">{{ item.name }}</option>
        </select>
        <InputError class="mt-2" :message="error"/>
    </div>
</template>
<script>
    import InputError from "@/Components/InputError.vue";

    export default {
        components: {InputError},
        props: {
            name: {
                type: String,
                required: true
            },
            collection: {
                type: Array,
                required: true
            },
            error: {
                type: String,
                required: true
            },
            emit : {
                type: String,
                required: true
            },
            selected: {
                type: String,
                default: null
            }
        },
        methods: {
            optionChange(event) {

                this.$emit( this.emit , event.target.value)
            },
            selectedOption(id) {
                return this.selected === id
            }
        }
    }
</script>
