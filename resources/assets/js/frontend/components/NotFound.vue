<template>
  <div class="not-found">
    <navbar></navbar>

    <div class="container text-center">
        <div class="content">
            <div class="title">404 Not Found.</div>
        </div>
    </div>
  </div>
</template>

<script>
import Navbar from "home/Navbar"

export default {
  components: { Navbar },
}
</script>

<style lang="scss" scoped>
.not-found {
  margin: 0;
  padding: 0;
  width: 100%;
  color: #B0BEC5;
  font-weight: 100;
  font-family: 'Lato', sans-serif;
}
.title {
  font-size: 72px;
  margin-bottom: 40px;
}
</style>
