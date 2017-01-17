<template>
  <div class="nav-bar">
    <header>
      <div class="container">
        <div class="row">
          <div class="logo col-md-8">
            <logo></logo>
          </div>
          <div class="nav-right col-md-8">
            <slot name="page-actions"></slot>
            <div class="user-btn float-right">
              <div v-if="!isLogged">
                <a href="#" data-toggle="modal" data-target="#login-modal" @click="isSignin=true">登录</a> / <a href="#" data-toggle="modal" data-target="#login-modal" @click="isSignin=false">注册</a>
              </div>
              <div class="dropdown open" v-else>
                <div class="dropdown-toggle" id="nav-right-action-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <avatar size="small"></avatar>
                  {{ currentUser.name }}
                </div>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="nav-right-action-dropdown">
                    <router-link class="dropdown-item" :to="{name:'user.show', params:{username:currentUser.username}}">个人主页</router-link>
                    <a class="dropdown-item" href="#">账号设置</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" @click="logout">注销</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <div class="modal fade" id="login-modal">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body">
            <div v-if="isSignin">
              <signin></signin>
              <div class="form-group custom-actions text-center">
                <a href="#" class="social-login">其它方式登录</a>
              </div>
            </div>
            <div v-else>
              <signup></signup>
              <div class="form-group custom-actions text-center">
                <a href="#" class="social-login" @click="isSignin=true">已有账号？去登录</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex'
import {Signin, Signup} from "../../auth/routes/components";

export default {
  data() {
    return {
        isSignin: true
    }
  },
  computed: {
    ...mapGetters(['isLogged', 'currentUser']),
  },
  watch: {
    isLogged(value) { // isLogged changes when the token changes
      if (value === false) {
        this.$router.push({ name: 'home' })
      }

      $('#login-modal').modal('hide');
    },
  },
  methods: {
    ...mapActions(['logout']),
  },
  components: {
    Signin,
    Signup,
    Logo: require("home/general/Logo"),
    Avatar: require("home/general/Avatar"),
  }
}
</script>

<style lang="scss" scoped>
  .nav-bar {
    height: 60px;
  }
  header {
    position: fixed;
    z-index: 5;
    left: 0;
    right: 0;
    padding: 15px 0;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
  }

  .custom-actions {
    margin-top: 40px;
  }

  .social-login {
    border-top: 1px solid #444;
    padding: 8px;
  }

  #login-modal {
    .modal-dialog {
      margin-top: 80px;
      max-width: 400px;
    }
    .modal-body {
      padding: 30px 60px;
    }
  }
</style>
