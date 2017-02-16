<template>
  <time :datetime="datetime" :class="classes" v-html="placeholder" :id="id"></time>
</template>

<script>
import Timeago from 'timeago.js'
export default {
  props: {
    datetime: {
      type: String
    },
    placeholder: {
      type: String,
      default() {
        return '--'
      }
    },
    classes: {
      type: String,
      default() {
        return 'text-gray-light'
      }
    }
  },
  data() {
    return {
      id: '_'+Math.random().toString(36).substr(15)
    }
  },
  mounted() {
    let id = this.id
    let timeagoInstance = new Timeago()
    // use render to render it in real time
    setTimeout(function(){
      timeagoInstance.render(document.querySelectorAll('#'+id), 'zh_CN');
    }, 500)
  }
}
</script>
