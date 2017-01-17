<template>
  <div class="container-fulid">
    <div class="bitmap" :style="background">
      <div id="bitdim"></div>
    </div>
    <div class="row">
      <div class="col-md-8 offset-md-4">
        <div class="title">
          <h3>{{ article.title }}</h3>
        </div>
        <div class="content" v-html="article.content"></div>
        <div class="footer">
          <div class="user">
            <div class="info-left">
              <img class="avatar img-circle" width="60" :src="article.avatar">
            </div>
            <div class="info">
              <p class="username">{{ article.username }}</p>
              <p class="description">{{ article.description }}</p>
            </div>
            <button class="follow btn btn-outline-secondary btn-sm">关注</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        background: {
          backgroundImage: 'url(https://images.unsplash.com/photo-1449023859676-22e61b0c0695?dpr=2&auto=format&fit=crop&w=1500&h=844&q=80&cs=tinysrgb&crop=)'
        },
        article: {
          title: '字符串和字符（Strings and Characters）',
          content: `
          字符串可变性 (String Mutability)
          您可以通过将一个特定字符串分配给一个变量来对其进行修改，或者分配给一个常量来保证其不会被修改：
          var variableString = "Horse"
          variableString += " and carriage"
          // 🐶`,
          avatar: 'https://pigjian.com/uploads/default_avatar.png',
          username: '小小程序员',
          description: '一只走在编程这条不归路上的小北漂南方小伙，单身一枚！',
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  .row > div {
    display: block;
  }
  .title {
    margin-top: 30px;
    margin-bottom: 30px;

    h3 {
      font-weight: 300;
    }
  }
  .content {
    font-weight: 200;
    margin-bottom: 60px;
  }
  .footer {
    height: 80px;
    margin-bottom: 50px;
    border-top: 1px solid rgba(0, 0, 0, 0.04);
  }
  .user {
    position: relative;

    .info-left, .info {
      display: inline-block;
    }
    .info-left {
      position: absolute;
      left: 0;
      display: inline-block;
      margin: 10px 11px;
      line-height: 20px;
    }
    .info {
      position: absolute;
      left: 80px;
      display: inline-block;
      margin: 10px;
      height: 60px;
      line-height: 20px;

      p {
        margin: 9px 0;
      }
      .username {
        font-weight: 200;
      }
      .description {
        font-size: 12px;
        font-weight: 200;
      }
    }
    .follow {
      position: absolute;
      right: 0;
      top: 26.6667px;
    }
  }
  #bitdim {
    width: 100%;
    height: 100%;
    position: absolute;
    top: 0px;
    left: 0px;
    background: -moz-radial-gradient(center, ellipse cover, rgba(36,44,51,0) -1%, rgba(36,44,51,0.01) 0%, rgba(32,39,47,0.2) 22%, rgba(19,19,35,0.65) 100%);
    background: -webkit-radial-gradient(center, ellipse cover, rgba(36,44,51,0) -1%,rgba(36,44,51,0.01) 0%,rgba(32,39,47,0.2) 22%,rgba(19,19,35,0.65) 100%);
    background: radial-gradient(ellipse at center, rgba(36,44,51,0) -1%,rgba(36,44,51,0.01) 0%,rgba(32,39,47,0.2) 22%,rgba(19,19,35,0.65) 100%);
    filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00242c33', endColorstr='#a6131323',GradientType=1 );
  }
  .bitmap {
    background-attachment: fixed;
    background-size: cover;
    background-position: 50% 100%;
    overflow: hidden;
    padding-top: 30px;
    -webkit-animation: article-bg 8s ease-in;
    -moz-animation: article-bg 8s ease-in;
    -o-animation: article-bg 8s ease-in;
    animation: article-bg 8s ease-in;
    position: relative;
    height: 500px;
    overflow: hidden;
  }
  @-webkit-keyframes article-bg {
    0%   { background-position: 50% 0%; }
    100% { background-position: 50% 100%; }
  }
  @-moz-keyframes article-bg {
    0%   { background-position: 50% 0%; }
    100% { background-position: 50% 100%; }
  }
  @-o-keyframes article-bg {
    0%   { background-position: 50% 0%; }
    100% { background-position: 50% 100%; }
  }
  @keyframes article-bg {
    0%   { background-position: 50% 0%; }
    100% { background-position: 50% 100%; }
  }
</style>
