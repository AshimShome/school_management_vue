<template>
    <div>
        <select class="form-control mb-0" :id="fieldId" @input="handleInput" @change="handleChange" :disabled="disabled"
            :class="[{ 'is-invalid': form.errors.has(field) }, classes]">
            <slot />
        </select>
        <has-error :form="form" :field="field" class="mt-0 pt-0"></has-error>
    </div>
</template>

<script>
    export default {
        props: {
            form: {
                type: Object,
                required: true,
            },
            field: {
                type: String,
                required: true,
            },
            value: {
                type: [String, Number],
                default: '',
            },
            id: {
                type: String,
                default: '',
            },
            classes: {
                type: String,
                default: '',
            },
            disabled: {
                type: Boolean,
                default: false,
            },
        },
        computed: {
            fieldId() {
                return this.id !== '' ? this.id : this.field
            }
        },
        methods: {
            handleInput(e) {
                this.$emit('input', e.target.value);
            },
            handleChange(e) {
                this.$emit('change', e.target.value);
            },
        }
    };
</script>
