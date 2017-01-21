<template>
  <div class="home">
    <navbar></navbar>
    <div class="container pt-3">
      <h1>Welcome.</h1>
    </div>
  </div>
</template>

<script>
import Navbar from "home/Navbar"

export default {
  name: 'home',
  components: { Navbar }
}
</script>
