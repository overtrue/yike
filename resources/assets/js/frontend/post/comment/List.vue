<template>
  <div class="container">
    <div class="header">
      <span class="title">{{ list.length }} 条评论</span>
      <span class="line"></span>
    </div>
    <div class="editor d-flex align-items-start my-4">
      <template v-if="isLogged">
        <avatar :user="currentUser" size="xxs" class="mx-4"></avatar>
        <div class="editor-input">
          <el-input
            type="textarea"
            resize="none"
            autosize
            placeholder="请输入内容"
            v-model="form.content"
            @focus="onFocus">
          </el-input>
          <div class="buttons text-right mt-3" v-if="showButton">
            <button class="btn btn-link" @click="onCancel">取消</button>
            <button v-if="form.content.trim().length > 0" class="btn-outline-info btn" @click="handleSubmit">评论</button>
            <button v-else class="btn-outline-info btn" disabled>评论</button>
          </div>
        </div>
      </template>
      <template v-else>
        请先登录后再评论
      </template>
    </div>
    <div class="comment-list">
      <div class="item mt-4 d-flex align-items-start" v-for="comment in list">
        <avatar :user="comment.user.data" size="xxs" class="mx-4"></avatar>
        <section class="comment-body" v-html="comment.content"></section>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex'
import Avatar from "home/Avatar"

export default {
  components: { Avatar },
  props: {
    list: {
      type: Array,
      default() {
        return []
      }
    }
  },
  data() {
    return {
      showButton: false,
      form: {
        content: ''
      },
    }
  },
  computed: {
    ...mapGetters(['isLogged', 'currentUser']),
  },
  methods: {
    onFocus() {
      this.showButton = true
    },
    onCancel() {
      this.showButton = false
    },
    handleSubmit() {
      if (this.form.content.trim().length <= 0) {
        return
      }

      this.form.type = 'markdown'

      this.$http.post(this.$endpoints.posts + this.$route.params.slug + '/comment', this.form)
          .then((response) => {
            this.form.content = ''
            this.showButton = false
            this.list.push(response.data.data)
          })
    },
  }
}
</script>

<style lang="scss" scoped>
.header {
  position: relative;
  display: block;
  margin-top: 16px;
  margin-bottom: 16px;
  line-height: 22px;

  .title {
    position: relative;
    display: inline;
    padding-right: 16px;
    font-weight: 700;
    background-color: #fff;
    z-index: 1;
  }
  .line {
    content: '';
    position: absolute;
    left: 0;
    right: 0;
    top: 50%;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
  }
}
.editor-input {
  width: 85%;
}
.btn-link:hover {
  text-decoration: none;
  cursor: pointer;
}
.comment-list .item:last-child, .comment-list .item:first-child {
  margin-bottom: 1.5rem;
}
</style>
