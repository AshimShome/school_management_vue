<template>
    <div class="page-loading">
        <span class="input-icon-addon text-center">
            <div class="spinner-border spinner-border-sm text-dark mr-3" role="status"></div>
        </span>
    </div>
</template>

<style scoped>
.page-loading {
    height: 50px;
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.page-loading span{
    display: contents
}

.page-loading span div{
    width: 30px;
    height: 30px;
    border-width: 2px;
}
</style>
