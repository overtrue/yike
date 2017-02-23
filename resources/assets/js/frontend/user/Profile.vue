<template>
  <div class="user-profile">
    <navbar></navbar>
    <div class="text-center setting-box">
      <div class="setting-items">
        <img class="avatar img-circle" width="120" :src="user.avatar">

        <div class="setting-item row" v-for="item in items">
          <label class="col-form-label col-3">{{ item.label }}</label>
          <div class="col-9">
            <input type="text" class="form-control" @click="click(item)" :value="user[item.name]" :id="item.name" :placeholder="item.placeholder" />
          </div>
          <div class="actions col-3" v-if="item.isEdit">
            <span class="save" @click="save(item)">保存</span>
            <span class="cancel" @click="cancel(item)">取消</span>
          </div>
          <div class="actions col-3" v-else><i class="material-icons" @click="edit(item)">edit</i></div>
        </div>

        <div class="setting-item row">
          <label class="col-form-label col-3">社交账号</label>
          <div class="col-9">
            <div class="setting-social form-control">
              <a href=""><i class="ion-social-twitter"></i></a>
              <a href=""><i class="ion-social-github"></i></a>
              <a href=""><i class="ion-social-pinterest"></i></a>
              <a href=""><i class="ion-social-facebook"></i></a>
              <a href=""><i class="ion-social-reddit"></i></a>
              <a href=""><i class="ion-social-linkedin"></i></a>
              <a href=""><i class="ion-social-googleplus"></i></a>
            </div>
          </div>
        </div>
        <div class="setting-item row">
          <label class="col-form-label col-3">邮箱</label>
          <div class="col-9">
            <div class="form-control" v-html="user.email"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Navbar from 'home/Navbar'

export default {
  components: { Navbar },
  data() {
    return {
      items: [
        { label: '昵称', name: 'name', placeholder: '填写你的昵称', isEdit: false },
        { label: '个人简介', name: 'signature', placeholder: '填写你的个人简介', isEdit: false },
      ],
    }
  },
  computed: {
    ...mapGetters({
      user: 'currentUser'
    }),
  },
  methods: {
    ...mapActions(['setUser']),
    edit(item) {
      let value = $('#' + item.name).val()

      $('#' + item.name).val('').focus().val(value)

      item.isEdit = true
    },
    cancel(item) {
      $('#' + item.name).blur()

      item.isEdit = false
    },
    click(item) {
      item.isEdit = true
    },
    save(item) {
      let data = {
        [item.name]: $('#' + item.name).val()
      }

      this.$http.patch(this.$endpoints.me, data)
          .then((response) => {
            this.setUser(response.data.data)

            item.isEdit = false
          })
    },
  }
}
</script>

<style lang="scss" scoped>
  .setting-items {
    padding-bottom: 60px;
    font-size: .9rem;
  }
  .setting-item {
    position: relative;
    text-align: left;
    width: 80%;
    margin: 0 auto;
    padding: 1em 0;
    border-bottom: 1px solid #f1f1f1;
  }
  .col-form-label {
    text-align: left;
  }
  .form-control {
    border: none;
    color: #909090;
    font-size: .9rem;
  }
  .form-control:focus {
    outline: none;
    color: #4a4a4a;
  }
  .setting-social {
    display: inline-block;
    font-size: 16px;

    a {
      display: inline-block;
      width: 25px;
      height: 25px;
      line-height: 25px;
      text-align: center;
      border: 1px solid;
      border-radius: 50%;

      &:hover {
        color: #fff;
        background-color: #00ab6b;
      }
    }
  }
  .actions {
    cursor: pointer;
    position: absolute;
    right: 0;
    padding: 0;
    height: 35px;
    line-height: 35px;
    text-align: center;

    i {
      width: 14px;
      text-align: center;
    }
    .save {
      margin-right: .5em;
    }
    span {
      cursor: pointer;
    }
  }
  .setting-box {
    max-width: 550px;
    margin: 0 auto;
    margin-top: 50px;
    background-color: #fff;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
  }
  .avatar {
    margin: 30px 0;
  }
</style>
