<template>
  <transition v-if="show" name="modal">
    <div class="modal" @click.self="clickMask">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header" v-if="$slots.header">
            <slot name="header"></slot>
            <a href="javascript:void(0);" class="float-right" @click="cancel"><i class="material-icons">close</i></a>
          </div>
          <div class="modal-body">
            <slot name="body"></slot>
          </div>
          <div class="modal-footer" v-if="$slots.footer">
            <slot name="footer"></slot>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    show: { type: Boolean, default: false },
    title: {
      type: String,
      default: ''
    },
  },
  methods: {
    cancel () {
      this.$emit('cancel');
    },
    clickMask () {
      this.cancel();
    }
  }
}
</script>

<style lang="scss" scoped>
.modal {
  display: block;
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(250, 250, 250, .5);
  transition: opacity .3s ease;

  .modal-dialog {
    margin-top: 80px;
    max-width: 400px;
  }
  .modal-body {
    padding: 30px 60px;
  }
}
</style>
