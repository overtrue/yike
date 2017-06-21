<template>
  <transition name="el-message-fade">
    <div
      class="el-message"
      :class="customClass"
      v-show="visible"
      @mouseenter="clearTimer"
      @mouseleave="startTimer">
      <img class="el-message__img" :src="typeImg" alt="" v-if="!iconClass">
      <div class="el-message__group" :class="{ 'is-with-icon': iconClass }">
        <i class="el-message__icon" :class="iconClass" v-if="iconClass"></i>
        <p v-html="message"></p>
        <div v-if="showClose" class="el-message__closeBtn el-icon-close" @click="close"></div>
      </div>
    </div>
  </transition>
</template>

<script type="text/babel">
  import {default as images} from "./images"

  export default {
    data() {
      return {
        visible: false,
        message: '',
        duration: 3000,
        type: 'info',
        iconClass: '',
        customClass: '',
        onClose: null,
        showClose: false,
        closed: false,
        timer: null
      };
    },

    computed: {
      typeImg() {
        return images[this.type]
      }
    },

    watch: {
      closed(newVal) {
        if (newVal) {
          this.visible = false;
          this.$el.addEventListener('transitionend', this.destroyElement);
        }
      }
    },

    methods: {
      destroyElement() {
        this.$el.removeEventListener('transitionend', this.destroyElement);
        this.$destroy(true);
        this.$el.parentNode.removeChild(this.$el);
      },

      close() {
        this.closed = true;
        if (typeof this.onClose === 'function') {
          this.onClose(this);
        }
      },

      clearTimer() {
        clearTimeout(this.timer);
      },

      startTimer() {
        if (this.duration > 0) {
          this.timer = setTimeout(() => {
            if (!this.closed) {
              this.close();
            }
          }, this.duration);
        }
      }
    },

    mounted() {
      this.startTimer();
    }
  };
</script>

<style lang="scss">
  .el-message {
    display: flex;

    img {
      width: 20px;
      height: 20px;
      border-radius: 100%;
      vertical-align: middle;
      display: flex;
      position: relative;
    }
    .el-message__group {
      margin-left: 15px;
      display: flex;
      height: auto;
    }
  }
</style>
