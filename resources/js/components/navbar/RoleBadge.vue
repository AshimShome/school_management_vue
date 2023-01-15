<template>
    <div class="collapse navbar-collapse" id="navbar-menu">
        <div>
            <div class="badge bg-primary">{{ role | capitalize }}</div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        role: {
            type: String,
            required: true
        }
    },
}
</script>
