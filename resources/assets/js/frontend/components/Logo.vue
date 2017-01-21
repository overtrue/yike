<template>
    <div class="logo">
        <img src="/img/logo.png" alt="" class="logo-img" :class="size">
        <p class="slogan" v-if="showSlogan">分享知识，收获精彩</p>
    </div>
</template>

<script>
    export default {
        props: {
            size: {
                type: String,
                default() {
                    return 'small';
                },
                validator(value) {
                    return ["small", "medium", "large"].indexOf(value) >= 0;
                }
            },
            showSlogan: {
                type: Boolean,
                default() {
                    return false
                }
            }
        }
    }
</script>

<style lang="scss">
    .logo-img {
        &.larage {
            height: 150px;
        }

        &.medium {
            height: 40px;
        }

        &.small {
            height: 30px;
        }
    }
    p.slogan {
        margin-top: 20px;
    }
</style>
