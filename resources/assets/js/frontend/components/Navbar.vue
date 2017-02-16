<template>
  <div class="nav-bar">
    <header>
      <div class="container">
        <div class="row">
          <div class="nav-left col-md-8">
            <router-link :to="{name:'home'}" class="logo"><logo></logo></router-link>
          </div>
          <div class="nav-right col-md-8 d-flex flex-row align-items-center justify-content-end" v-if="!isAuthPage">
            <slot name="page-actions" v-if="!isAuthPage && isLogged">
              <router-link :to="{name:'post.new'}" class="nav-item" v-if="$route.name != 'post.new'"><i class="material-icons">add</i></router-link>
            </slot>
            <template v-if="!isLogged" scope>
            <a href="#" data-toggle="modal" data-target="#login-modal" @click="isSignin=true">登 录</a> <span class="p-1 text-primary"> / </span> <a href="#" data-toggle="modal" data-target="#login-modal" @click="isSignin=false">注 册</a>
            </template>
            <template v-else scope>
              <a href="#" class="nav-item"><i class="material-icons">notifications</i></a>
              <div class="nav-item">
                <div class="dropdown">
                  <div class="dropdown-toggle" id="nav-right-action-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <avatar size="xxs"></avatar>
                  </div>
                  <div class="dropdown-menu text-center dropdown-menu-right" aria-labelledby="nav-right-action-dropdown">
                      <router-link class="dropdown-item" :to="{ name:'user.show', params: { username: currentUser.username }}">个人主页</router-link>
                      <router-link class="dropdown-item" :to="{ name:'user.profile' }">账号设置</router-link>
                      <a class="dropdown-item" href="/dashboard" v-if="currentUser.is_admin">管理中心</a>
                      <a class="dropdown-item" href="/topics" v-if="currentUser.is_admin">我的专栏</a>
                      <div class="dropdown-divider"></div>
                      <a class="dropdown-item" href="#" @click="logout">注销</a>
                  </div>
                </div>
              </div>
            </template>
          </div>
        </div>
      </div>
    </header>
    <alerts></alerts>
    <div class="modal" id="login-modal" v-if="!isAuthPage">
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
import Signin from "app/auth/components/Signin"
import Signup from "app/auth/components/Signup"
import Logo from "./Logo"
import Avatar from "./Avatar"
import Alerts from './Alerts'
import Headroom from "headroom.js/dist/headroom.js"

export default {
  name:"navbar",
  components: { Alerts, Signin, Signup, Logo, Avatar },
  data() {
    return {
        isSignin: true
    }
  },
  computed: {
    ...mapGetters(['currentUser', 'isLogged', 'isAuthPage']),
  },
  watch: {
    isLogged(value) { // isLogged changes when the token changes
      if (value === false) {
        this.$router.push({ name: 'home' })
      }

      $('#login-modal').modal('hide')
    },
  },
  methods: {
    ...mapActions(['logout']),
  },
  mounted() {
    (new Headroom(document.querySelector("header"))).init()
  }
}
</script>

<style lang="scss" scoped>
  .nav-bar {
    height: 60px;

    .nav-item {
      justify-content: center;
      cursor: pointer;
      color: #555;
      text-align: center;
      white-space: nowrap;
      vertical-align: middle;
      user-select: none;
      padding: 0 0.8rem;
      font-size: 1rem;
      transition: all 0.2s ease-in-out;

      .material-icons {
        color: #888;
        font-size: 1.4em;
      }
    }
  }
  header {
    position: fixed;
    z-index: 5;
    top: 0;
    left: 0;
    right: 0;
    padding: 15px 0;
    background: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, .04);
  }

  .dropdown {
    .name {
      padding: 0 10px;
      font-size: 1em;
    }
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
