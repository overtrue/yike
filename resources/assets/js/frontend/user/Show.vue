<template>
  <div class="user-show">
    <navbar></navbar>
    <div class="container-fluid">
      <info></info>
      <posts></posts>
    </div>
  </div>
</template>

<script>
import Navbar from 'home/Navbar'
import Info from './components/Info'
import Posts from './components/Posts'

export default {
  components: {
    Navbar,
    Info,
    Posts
  }
}
</script>
