<template>
  <div class="login-page">
    <navbar></navbar>
      <div class="login">
        <router-view></router-view>
      </div>
  </div>
</template>

<script>
import Navbar from "home/Navbar"

export default {
  components: { Navbar }
}
</script>
<style>
.login {
  max-width: 350px;
  margin: 0 auto;
  margin-top: 60px;
  padding: 40px;
  background-color: #fff;
  border-radius: 4px;
  background: #fff;
  box-shadow: 0 3px 5px rgba(0, 0, 0,.12);
}
</style>
