<template>
  <transition name="fade" mode="out-in" appear>
    <i v-show="visible" class="material-icons back-top" @click.prevent="backTop">arrow_drop_down_circle</i>
  </transition>
</template>

<script>
  export default {
    props: {
      speed: {
        type: Number,
        default: 0.2
      }
    },
    data() {
      return {
        visible: false
      }
    },
    mounted() {
      window.addEventListener('scroll', this.handleScroll)
    },
    methods: {
      backTop() {
        let that = this
        let top = document.body.scrollTop

        let timer = setInterval(function () {
          top -= Math.abs(top * that.speed);

          if (top <= 1) {
            top = 0;
            clearInterval(timer);
          }

          document.body.scrollTop = top;
        }, 20);
      },
      handleScroll() {
        let clientHeight = document.body.clientHeight
        let top = document.body.scrollTop

        this.visible = top > clientHeight
      }
    }
  }
</script>

<style lang="scss" scoped>
.back-top {
  position: fixed;
  bottom: 30px;
  right: 30px;
  width: 38px;
  height: 38px;
  line-height: 38px;
  font-size: 2.5em;
  color: #dce7f4;
  text-align: center;
  -moz-transform:scaleY(-1);
  -webkit-transform:scaleY(-1);
  -o-transform:scaleY(-1);
  transform:scaleY(-1);
  cursor: pointer;
  z-index: 1000000;

  &:hover {
    color: #bfcbd9;
  }
}
</style>
