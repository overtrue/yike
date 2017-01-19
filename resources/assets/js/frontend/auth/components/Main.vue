<template>
  <div class="container">
    <div class="nav-bar">
      <header>
        <div class="container">
          <div class="row">
            <div class="logo col-md-8">
              <router-link :to="{name:'home'}"><logo></logo></router-link>
            </div>
          </div>
        </div>
      </header>
    </div>
    <div class="row">
      <div class="col-md-6 offset-md-5 login">
        <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  components: {
    Logo: require("home/general/Logo"),
  }
}
</script>

<style lang="css">
.nav-bar {
  height: 60px;
  line-height: 35px;
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
.login {
  margin-top: 60px;
  padding: 30px;
  background-color: #fff;
  border-radius: 4px;
}
</style>
