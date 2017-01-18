<template>
  <div class="user-articles row">
    <div class="container">
      <div class="col-md-12 offset-md-2">
        <div class="card" v-for="item in items">
          <img class="card-img-top" :src="item.image" :alt="item.title">
          <div class="card-block">
            <div class="card-title">{{ item.title }}</div>
            <div class="extras">
              <img class="avatar img-circle" :src="item.avatar">
              <div class="user-info">
                <span class="username">{{ item.username }}</span>
                <span class="times">{{ item.time }}</span>
              </div>
              <div class="actions">
                <div class="favour">
                  <i class="fa fa-heart-o"></i>
                  <span>123</span>
                </div>
                <div class="collect">
                  <i class="fa fa-bookmark-o"></i>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    computed: {
      items() {
        let array = []
        let item = {
          image: 'data:image/svg+xml;charset=UTF-8,%3Csvg%20width%3D%22241%22%20height%3D%22200%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20viewBox%3D%220%200%20241%20200%22%20preserveAspectRatio%3D%22none%22%3E%3Cdefs%3E%3Cstyle%20type%3D%22text%2Fcss%22%3E%23holder_159861d78eb%20text%20%7B%20fill%3Argba(255%2C255%2C255%2C.75)%3Bfont-weight%3Anormal%3Bfont-family%3AHelvetica%2C%20monospace%3Bfont-size%3A12pt%20%7D%20%3C%2Fstyle%3E%3C%2Fdefs%3E%3Cg%20id%3D%22holder_159861d78eb%22%3E%3Crect%20width%3D%22241%22%20height%3D%22200%22%20fill%3D%22%23777%22%3E%3C%2Frect%3E%3Cg%3E%3Ctext%20x%3D%2289.8046875%22%20y%3D%22105.55%22%3E241x200%3C%2Ftext%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E',
          title: '圣诞节到了，你们希望收到什么礼物？',
          avatar: 'https://dn-phphub.qbox.me/uploads/avatars/76_1451276555.png?imageView2/1/w/200/h/200',
          username: 'Overtrue',
          time: '4 Minutes Ago',
        }

        for (var i = 0; i < 10; i++) {
          array.push(item)
        }

        return array
      }
    }
  }
</script>

<style lang="scss" scoped>
  .user-articles {
    margin-bottom: 50px;
  }
  .card {
    width:32%;
    margin-right:.6666%;
    margin-left:.6666%;
    margin-top: 30px;
    display:inline-block;
  }
  .card-img-top {
    width: 100%;
    height: 160px;
  }
  .extras{
    margin-top: 15px;
    position: relative;

    img {
      float: left;
    }
    .avatar {
      width: 39px;
    }
    .actions {
      display: inline-block;
      font-size: 16px;
      position: absolute;
      bottom: 0;
      right: 0;

      .favour, .collect{
        position: relative;
        padding: 0 5px;
        cursor: pointer;
        display: inline-block;
        opacity: .6;

        span {
          font-size: 14px;
          font-weight: 200;
        }
      }
      .favour i {
        color: #7ED321;
      }
      .favour:not(:last-child):after {
        content: '';
        position: absolute;
        left: 100%;
        top: 50%;
        width: 1px;
        height: 1em;
        background-color: #2b445d;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
        opacity: .1;
      }
    }
  }
  .extras .user-info {
    display: inline-block;
    margin-left: 10px;

    span {
      display: block;
      padding: 0;
      font-size: 13px;
      font-weight: 200;
    }
    .times {
      font-size: 11px;
    }
  }
  .card-block {
    padding: 1rem;
  }
  .card {
    border-radius: 4px;
    background-color: #fff;
    border: 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);

    .card-title {
      font-size: 13px;
      font-weight: 400;
    }
    .card-body {
      font-size: 13px;
      font-weight: 200;
      padding: 10px;

      .content {
        margin-top: 8px;

        .user, .user-info {
          display: inline-block;
        }
        .user-info {
          padding-top: 8px;
        }
      }
    }
  }
</style>
