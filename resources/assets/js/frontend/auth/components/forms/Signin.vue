<template>
  <form @submit.prevent="submit">
    <div class="form-group text-center">
      <logo size="medium" :showSlogan="true"></logo>
    </div>
    <div class="form-group">
      <input type="email" class="form-control" id="email" v-model="email" placeholder="邮箱">
    </div>
    <div class="form-group">
      <input type="password" class="form-control" id="password" v-model="password" placeholder="密码">
    </div>
    <div class="form-group">
      <button class="btn btn-primary btn-block" type="submit">登录</button>
    </div>
  </form>
</template>

<script>
  import { mapActions } from 'vuex'
  import Logo from 'home/general/Logo'

  export default {
    /**
    * Component's local state
    */
    data() {
      return {
        email: 'happy.developer@vuejsisawesome.com',
        password: '123456',
      }
    },
    components: {
      Logo
    },
    methods: {
      /**
      * Map the actions from Vuex to this component.
      * https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Operators/Spread_operator
      */
      ...mapActions(['attemptLogin', 'setMessage']),

      /**
      * Handle form's submit event
      */
      submit() {
        const { email, password } = this // http://wesbos.com/destructuring-objects/
        this.attemptLogin({ email, password }) // this is a Vuex action
          .then(() => {
            this.setMessage({ type: 'error', message: [] }) // this is a Vuex action
            this.$router.push({ name: 'dashboard.index' })
          })
      },
      /**
      * Reset component's local state
      */
      reset() {
        this.email = ''
        this.password = ''
      },
    },
  }
</script>

<style lang="scss" scoped>
    .form-group {
        margin-top: 30px;
        .form-control {
            padding: 10px 2px;
            border:none;
            border-radius: 0;
            border-bottom: 1px solid rgba(155, 155, 155, .5);
        }
    }
</style>