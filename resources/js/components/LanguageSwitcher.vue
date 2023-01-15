<template>
    <div class="switch-button">
        <input v-model="german" class="switch-button-checkbox" type="checkbox">
        <label class="switch-button-label" for=""><span class="switch-button-label-span">EN</span></label>
    </div>
</template>

<script>
export default {
    data(){
        return {
            german: false,
        }
    },
    watch: {
        german(value) {
            let language = value ? 'de' : 'en';

            this.$i18n.locale = language;
            localStorage.setItem('lang', language);
        }
    },
    created(){
        let code = localStorage.getItem('lang') || 'en';

        code == 'en' ? this.german = false : this.german = true;
    }
}
</script>

<style lang='scss' scoped>
    .switch-button {
        background: rgba(0, 0, 0, 0.3);
        color: white;
        &-checkbox {
            & + .switch-button-label {
                &:before {
                    background: #307fdd;
                    // background: #1f242b;
                }
            }
        }
    }
    body.theme-dark {
        .switch-button {
            background: rgba(255, 255, 255, 0.56);
            color: black;
            &-checkbox {
                & + .switch-button-label {
                    &:before {
                        background: #fff;
                    }
                }
            }
        }
    }
    .switch-button {
        border-radius: 30px;
        overflow: hidden;
        width: 100%;
        text-align: center;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        padding-right: 50px;
        position: relative;
        margin-right: 10px;

        &:before {
            content: "DE";
            position: absolute;
            top: 0;
            bottom: 0;
            right: 0;
            width: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
            pointer-events: none;
        }

        &-checkbox {
            cursor: pointer;
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            z-index: 2;

            &:checked + .switch-button-label:before {
                transform: translateX(50px);
                transition: transform 300ms linear;
            }
            & + .switch-button-label {
            position: relative;
            padding: 5px 0;
            display: block;
            user-select: none;
            pointer-events: none;
            width: 50px;
                &:before {
                    content: "";
                    height: 100%;
                    width: 100%;
                    position: absolute;
                    left: 0;
                    top: 0;
                    border-radius: 30px;
                    transform: translateX(0);
                    transition: transform 300ms;
                }
                .switch-button-label-span {
                    position: relative;
                }
            }
        }
    }
</style>
