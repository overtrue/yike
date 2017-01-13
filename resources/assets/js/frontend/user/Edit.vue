<template>
  <div class="container">
    <div class="row">
      <div class="text-center col-md-8 offset-md-4">
        <div class="box">
          <div class="setting-items">
            <img class="avatar img-circle" width="120" src="https://pigjian.com/uploads/default_avatar.png">
            <div class="setting-item">
              <label class="setting-label">昵称</label>
              <input type="text" class="setting-input" @click="click('username')" :value="user.username" id="username" placeholder="填写你的昵称">
              <div class="setting-edit" v-if="isEdit">
                  <span class="save">保存</span>
                  <span class="cancel" @click="cancel('username')">取消</span>
              </div>
              <div class="setting-edit" v-else>
                  <i class="fa fa-pencil" @click="edit('username')"></i>
              </div>
            </div>
            <div class="setting-item">
              <label class="setting-label">个人简介</label>
              <input type="text" class="setting-input" :value="user.description" id="description" placeholder="填写你的个人简介">
              <div class="setting-edit" v-if="isEdit">
                  <span class="save">保存</span>
                  <span class="cancel" @click="cancel('description')">取消</span>
              </div>
              <div class="setting-edit" v-else>
                  <i class="fa fa-pencil" @click="edit('description')"></i>
              </div>
            </div>
            <div class="setting-item">
              <label class="setting-label">社交账号</label>
              <div class="setting-social">
                <a href=""><i class="fa fa-twitter"></i></a>
                <a href=""><i class="fa fa-github"></i></a>
                <a href=""><i class="fa fa-skype"></i></a>
                <a href=""><i class="fa fa-plus-circle"></i></a>
              </div>
            </div>
            <div class="setting-item">
              <label class="setting-label">邮箱</label>
              <input type="text" class="setting-input" :value="user.email" id="email" placeholder="填写你的邮箱">
              <div class="setting-edit" v-if="isEdit">
                  <span class="save">保存</span>
                  <span class="cancel" @click="cancel('email')">取消</span>
              </div>
              <div class="setting-edit" v-else>
                  <i class="fa fa-pencil" @click="edit('email')"></i>
              </div>
            </div>
            <div class="setting-item">
              <label class="setting-label">手机号</label>
              <input type="text" class="setting-input" :value="user.phone" id="phone" placeholder="填写你的手机号">
              <div class="setting-edit" v-if="isEdit">
                  <span class="save">保存</span>
                  <span class="cancel" @click="cancel('phone')">取消</span>
              </div>
              <div class="setting-edit" v-else>
                  <i class="fa fa-pencil" @click="edit('phone')"></i>
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
    data() {
      return {
        isEdit: false,
        user: {
          username: 'Jiajian Chan',
          description: 'Nothing is impossible.',
          email: 'changejian@gmail.com',
          phone: '13112772627',
        },
      }
    },
    methods: {
      edit(el) {
        console.log('asdadas');
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
    padding: 1em 0 0;
    border-bottom: 1px solid #f1f1f1;
  }
  .setting-label {
    text-align: left;
    padding: .7em 0;
    width: 7em;
    font-size: .9em;
  }
  .setting-input {
    padding: .7em 6em;
    border: none;
    color: #909090;
    font-size: .9em;
    margin-bottom: .5rem;
  }
  .setting-input:focus {
    outline: none;
    color: #4a4a4a;
  }
  .setting-edit {
    cursor: pointer;
    padding: .7em;
    display: inline-block;
    margin-bottom: .5rem;
    float: right;

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
  .box {
    font-size: .8rem;
    margin-top: 50px;
    background-color: #fff;
    border-radius: 4px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
  }
  .avatar {
    margin: 30px 0;
  }
</style>
