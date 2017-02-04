<template>
  <div class="bg-white full-height">
    <post-form></post-form>
  </div>
</template>

<script>
import PostForm from "./Form"

export default {
  name: 'post-new',
  components: { PostForm }
}
</script>
