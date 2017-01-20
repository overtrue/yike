<template>
    <img src="/img/default-avatar.png" alt="" class="avatar" :class="size">
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
            }
        }
    }
</script>

<style lang="scss">
    .avatar {
        border-radius: 50%;

        &.larage {
            height: 150px;
        }

        &.medium {
            height: 60px;
        }

        &.small {
            height: 35px;
        }
    }
</style>