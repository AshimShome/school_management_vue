<template>
    <div>
        <input class="form-control" :type="inputType" :value="value" :readonly="readonly" :id="fieldId"
            :placeholder="placeholderText" :class="[{ 'is-invalid': form.errors.has(field) }, inputSize, classes]"
            @input="handleInput" :disabled="disabled" :autofocus="autofocus" />
        <has-error :form="form" :field="field"></has-error>
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
            placeholder: {
                type: String,
                default: '',
            },
            inputType: {
                type: String,
                default: 'text',
            },
            readonly: {
                type: Boolean,
                default: false,
            },
            classes: {
                type: String,
                default: '',
            },
            size: {
                type: String,
                default: '',
            },
            disabled: {
                type: Boolean,
                default: false,
            },
            autofocus: {
                type: Boolean,
                default: false,
            },
        },
        computed: {
            inputSize() {
                return this.size == '' ? '' : this.size;
            },
            fieldId() {
                return this.id !== '' ? this.id : this.field
            },
            placeholderText() {
                return this.placeholder !== '' ? this.placeholder : `Enter ${this.field.replace("_", " ")}`
            }
        },
        methods: {
            handleInput(e) {
                this.$emit('input', e.target.value);
            },
        }
    };
</script>
