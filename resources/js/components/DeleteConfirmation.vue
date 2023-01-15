<template>
    <div class="d-inline">
        <a v-if="!deleteConfirm" href="#" @click="deleteConfirm = true" class="btn btn-danger">
            {{ $t("delete") }}
        </a>
        <template v-else>
            <a href="javascript:void(0)" @click="deleteDataa" class="btn btn-danger">
                {{ $t("yes") }}, {{ $t("delete_it") }}
            </a>
            <a href="javascript:void(0)" @click="deleteConfirm = false" class="btn btn-light">
                {{ $t("no") }}
            </a>
        </template>
    </div>
</template>

<script>
    export default {
        name: "DeleteConfirmation",
        props: {
            id: {
                type: Number,
                required: true,
            },
            index: {
                required: false,
            },
            i: {
                required: false,
            },
        },
        data() {
            return {
                deleteConfirm: false,
            };
        },
        methods: {
            deleteDataa() {
                this.$emit("delete-data", this.id,this.index,this.i);
            },
        },
    };
</script>
