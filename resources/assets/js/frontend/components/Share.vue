<template>
  <div class="share-dropdown">
    <span @click="toggleShow"><i class="material-icons">share</i> 分享</span>
    <ul class="dropdown-list" v-if="show">
      <div class="dropdown-hint">分享到...</div>
      <li><a :href="weiboUrl" target="_blank">新浪微博</a></li>
    </ul>
  </div>
</template>

<script>
export default {
  props: {
    url: { type: String, default: null },
    title: { type: String, default: null },
    image: { type: String, default: null },
    weiboKey: { type: String, default: null },
  },
  data() {
    return {
      show: false,
    }
  },
  computed: {
    weiboUrl() {
      let query = 'url=' + this.url + '&title=' + this.title + '&pic=' + this.image + '&appkey=' + this.weiboKey

      return 'http://service.weibo.com/share/share.php?' + query
    }
  },
  methods: {
    toggleShow() {
      this.show = !this.show
    },
  },
}
</script>

<style lang="scss" scoped>
.share-dropdown {
  position: relative;

  span {
    cursor: pointer;
  }
  ul.dropdown-list {
    position: absolute;
    list-style: none;
    left: -1rem;
    padding-left: 0;
    width: 6rem;
    background: #fff;
    border: 1px solid #dce7f4;
    border-radius: 3px;
    font-size: 14px;

    .dropdown-hint {
      padding: .3rem .5rem;
      color: #dce7f4;
    }
    li {
      a {
        display: block;
        color: #464a4c;
        padding: .3rem .5rem;
        cursor: pointer;
      }
      &:hover {
        background-color: #dce7f4;
      }
    }
  }
}
</style>
