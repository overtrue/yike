<template>
    <img :src="user.avatar" alt="" class="avatar rounded-circle" :class="size">
</template>

<script>
    export default {
        props: {
          user: {
              type: Object,
              default: function(){
                return {
                  avatar: '/img/default-avatar.png'
                }
              }
          },
          size: {
              type: String,
              default() {
                  return 'xs';
              },
              validator(value) {
                  return ["xxs", "xs", "sm", "md", "lg", "xlg"].indexOf(value) >= 0;
              }
          }
        }
    }
</script>

<style lang="scss">
    .avatar {
        border-radius: 50%;

        &.xlg {
            height: 150px;
        }

        &.lg {
            height: 120px;
        }

        &.md {
            height: 80px;
        }

        &.sm {
            height: 60px;
        }

        &.xs {
            height: 48px;
        }

        &.xxs {
            height: 40px;
        }

        &.xxxs {
            height: 35px;
        }
    }
</style>
