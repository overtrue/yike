<template>
  <div class="bg-white fh-100">
    <post-form :post="post"></post-form>
  </div>
</template>

<script>
import PostForm from "./Form"
import {getData} from "utils/get"

export default {
  name: 'post-edit',
  components: { PostForm },
  data() {
    return {
      post: {}
    }
  },
  created() {
    this.$http.get(this.$endpoints.posts + this.$route.params.slug)
              .then((post) => {
                post = getData(post).data

                if (post.type === 'markdown') {
                  post.content = post.raw_content
                }

                this.post = post
              }).catch(function(err){
                console.log(err)
              });
  }
}
</script>
