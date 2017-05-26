<template>
  <div class="share-dropdown">
    <span @click="toggleShow"><i class="material-icons">share</i> 分享</span>
    <ul class="dropdown-list" v-if="show">
      <div class="dropdown-hint">分享到...</div>
      <li><a :href="weiboUrl" target="_blank">新浪微博</a></li>
      <li class="wechat-share">
        <a href="javascript:;">微信</a>
        <div class="wechat-qrcode">
          <qr-code :text="url"></qr-code>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import QrCode from 'home/QrCode'

export default {
  components: { QrCode },
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
    },
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
.wechat-share {
  position: relative;

  .wechat-qrcode {
    display: none;
  }
  &:hover .wechat-qrcode {
    display: block;
    position: absolute;
    z-index: 9;
    top: 0;
    left: 110%;
    width: 120px;
    height: 120px;
    color: #666;
    font-size: 12px;
    text-align: center;
    background-color: #fff;
    border-radius: 3px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
    transition: all .2s;
    -webkit-tansition: all 350ms;
    -moz-transition: all 350ms;

    &:after {
      content: '';
      position: absolute;
      left: -6px;
      top: 10px;
      margin-left: -6px;
      width: 0;
      height: 0;
      border-width: 8px 6px 6px;
      border-style: solid;
      border-color: #fff transparent transparent;
      -moz-transform: rotate(90deg);
      -webkit-transform: rotate(90deg);
      -o-transform: rotate(90deg);
      transform: rotate(90deg);
    }
  }
}

</style>
