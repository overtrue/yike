<template>
  <div class="image-box d-flex justify-content-center align-items-center">
    <img :src="src" :alt="alt" @error="onImageLoadFail">
  </div>
</template>

<script>
export default {
  props: {
    src: {
      type: String,
      required: true
    },
    alt: {
      type: String,
      default() {
        return 'image'
      }
    }
  },
  methods: {
    onImageLoadFail() {
      console.error('image load fail:' + this.src)
      this.$emit('loadFail');
      document.querySelector('.image-box [src="'+this.src+'"]').parentNode.remove()
    }
  }
}
</script>

<style lang="scss" scoped>
  .image-box {
    position: relative;
    height: 100%;
    overflow: hidden;

    img {
      width: 100%;
    }
  }
</style>
