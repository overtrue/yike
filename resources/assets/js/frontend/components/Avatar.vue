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

        &.large {
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
