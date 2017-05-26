<template>
  <div class="qrcode"></div>
</template>

<script>
import QRCode from 'qrcode-js-package/qrcode.js'

export default {
  props: {
    text: {type: String, required: true},
    size: {type: Number, required: false, default: 100},
    color: {type: String, required: false, default: '#000'},
    bgColor: {type: String, required: false, default: '#FFF'},
    errorLevel: {
      type: String,
      validator: function (value) {
        return value === 'L' || value === 'M' || value === 'Q' || value === 'H'
      },
      required: false,
      default: 'H'
    }
  },
  data() {
    return{
      qrCode: {}
    }
  },
  mounted() {
    this.qrCode = new QRCode(this.$el, {
      text: this.text,
      width: this.size,
      height: this.size,
      colorDark : this.color,
      colorLight : this.bgColor,
      correctLevel : QRCode.CorrectLevel[this.errorLevel]
    });
  },
}
</script>

<style lang="scss" scoped>
.qrcode {
  width: 100px;
  margin: 11px auto;
}
</style>
