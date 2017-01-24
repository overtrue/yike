<template>
  <div class="user-profile">
    <navbar></navbar>
    <div class="text-center setting-box">
      <div class="setting-items">
        <img class="avatar img-circle" width="120" :src="user.avatar">
        <div class="setting-item row">
          <label class="col-form-label col-4">昵称</label>
          <div class="col-9">
            <input type="text" class="form-control" @click="click('name')" :value="user.name" id="name" placeholder="填写你的昵称" />
          </div>
          <div class="actions col-3" v-if="isEdit">
            <span class="save">保存</span>
            <span class="cancel" @click="cancel('name')">取消</span>
          </div>
          <div class="actions col-3" v-else><i class="material-icons" @click="edit('name')">edit</i></div>
        </div>
        <div class="setting-item row">
          <label class="col-form-label col-4">个人简介</label>
          <div class="col-9">
            <input type="text" class="form-control" :value="user.description" id="description" placeholder="填写你的个人简介" /></div>
          <div class="actions col-3" v-if="isEdit">
            <span class="save">保存</span>
            <span class="cancel" @click="cancel('description')">取消</span>
          </div>
          <div class="actions col-3" v-else><i class="material-icons" @click="edit('description')">edit</i></div>
        </div>
        <div class="setting-item row">
          <label class="col-form-label col-4">社交账号</label>
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
          <div class="actions col-3">
            <i class="material-icons">add</i>
          </div>
        </div>
        <div class="setting-item row">
          <label class="col-form-label col-4">邮箱</label>
          <div class="col-9">
            <input type="text" class="form-control" :value="user.email" id="email" placeholder="填写你的邮箱" />
          </div>
          <div class="actions col-3" v-if="isEdit">
            <span class="save">保存</span>
            <span class="cancel" @click="cancel('email')">取消</span>
          </div>
          <div class="actions col-3" v-else>
            <i class="material-icons" @click="edit('email')">edit</i>
          </div>
        </div>
        <div class="setting-item row">
          <label class="col-form-label col-4">手机号</label>
          <div class="col-9">
            <input type="text" class="form-control" :value="user.phone" id="phone" placeholder="填写你的手机号"></div>
          <div class="actions col-3" v-if="isEdit">
            <span class="save">保存</span>
            <span class="cancel" @click="cancel('phone')">取消</span>
          </div>
          <div class="actions col-3" v-else><i class="material-icons" @click="edit('phone')">edit</i></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import Navbar from 'home/Navbar'

export default {
  data() {
    return {
      isEdit: false,
    }
  },
  components: { Navbar},
  computed: {
    ...mapGetters({
      user: 'currentUser'
    }),
  },
  methods: {
    edit(el) {
      let value = $('#' + el).val()

      $('#' + el).val('').focus().val(value)

      this.isEdit = true
    },
    cancel(el) {
      $('#' + el).blur()

      this.isEdit = false
    }
  }
}
</script>

<style lang="scss" scoped>
  .setting-items {
    padding-bottom: 60px;
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
  }
  .form-control:focus {
    outline: none;
    color: #4a4a4a;
  }
  .setting-social {
    display: inline-block;
    font-size: 16px;
  }
  .actions {
    cursor: pointer;
    text-align: right;
    i {
      width: 14px;
      height: 14px;
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
