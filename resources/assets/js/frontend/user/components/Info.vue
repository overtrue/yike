<template>
  <div class="wrapper row">
    <div class="header">
      <div class="container">
        <div class="row">
          <div class="col-md-2 offset-md-1">
            <img :src="user.avatar" class="avatar img-circle">
          </div>
          <div class="user-info col-md-9">
            <h3 class="username">{{ user.username }}</h3>
            <p class="description">{{ user.description }}</p>
            <div class="place">
              {{ user.place }}
              <div class="social">
                <a href=""><i class="fa fa-twitter"></i></a>
                <a href=""><i class="fa fa-github"></i></a>
                <a href=""><i class="fa fa-skype"></i></a>
              </div>
            </div>
          </div>
          <div class="col-md-3 text-right">
            <a href="#" class="btn btn-outline-secondary btn-sm">编辑资料</a><br>
            <a href="#" class="btn btn-outline-secondary btn-sm" style="margin-top: 30px;">关注</a>
          </div>
        </div>
      </div>
    </div>

    <div class="footer">
      <div class="container">
        <ul class="col-md-14 offset-md-1">
          <li>
            <span>文章</span>
            <span class="number">{{ user.article_count }}</span>
          </li>
          <li>
            <span>收藏</span>
            <span class="number">{{ user.collection_count }}</span>
          </li>
          <li>
            <span>关注</span>
            <span class="number">{{ user.follow_count }}</span>
          </li>
          <li>
            <span>粉丝</span>
            <span class="number">{{ user.fans_count }}</span>
          </li>
        </ul>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        user: {
          avatar: 'https://dn-phphub.qbox.me/uploads/avatars/76_1451276555.png?imageView2/1/w/200/h/200',
          username: '安正超',
          description: '在空气中窒息 我忘了我自己',
          place: '中国 . 北京',
          article_count: 2324,
          collection_count: 3534,
          follow_count: 865,
          fans_count: 64533,
        }
      }
    }
  }
</script>

<style lang="scss" scoped>
  ul {
    list-style: none;
    margin-bottom: 0;

    li {
      float: left;
    }
  }
  a {
    margin-top: 5px;
    font-size: 12px;
    font-weight: 200;
  }
  span {
    display: inline-block;
    padding: 12px 2px;
  }
  .wrapper {
    background-color: #fff;
    font-size: 14px;
    font-weight: 200;

    .header {
      padding-top: 40px;
      padding-bottom: 30px;
      margin: 0 auto;
    }
    .footer {
      width: 100%;
      border-top: 1px solid rgba(0, 0, 0, 0.04);
      border-bottom: 1px solid rgba(0, 0, 0, 0.04);
    }
  }
  .user-info {
    padding-left: 20px;

    .username {
      margin:10px 0 20px;
    }
  }
  .social {
    display: inline-block;
    margin-left: 20px;

    a {
      font-size: 18px;
      margin-right: 10px;
    }
  }
  .avatar {
    width: 100%;
  }
  .number {
    margin-right: 30px;
  }
</style>
