<template>
    <div>
        <label :for="fieldName" class="form-label" :class="classes">
            {{ title }}

            <span v-if="!required" class="form-label-required text-danger">*</span>
        </label>
    </div>
</template>

<script>
    export default {
        props: {
            title: {
                type: String,
                required: true,
            },
            required: {
                type: Boolean,
                default: true,
            },
            fieldName: {
                type: String,
                required: false,
            },
            classes: {
                type: String,
                default: '',
            }
        }
    };
</script>
