<template>
  <div class="post-new">
    <navbar>
      <div class="page-actions" slot="page-actions">
        <a href="#" class="nav-item text-success" :disabled="!canSubmit" @click="handleSubmit()">发布</a>
        <a href="#" class="nav-item text-secondary" :disabled="!canSubmit" @click="handleSubmit(false)">存为草稿</a>
      </div>
    </navbar>
    <div class="container post-container pt-5">
      <div class="cover-picker">
        <div class="picker">&plus; 设置封面</div>
      </div>
      <input class="post-title" placeholder="请输入标题" v-model="title" />
      <textarea class="post-body" id="post-body" placeholder="请输入内容"></textarea>
    </div>
  </div>
</template>

<script>
import CodeMirror from "codemirror"
import localforage from "localforage"
import Navbar from "home/Navbar"
import { mapActions, mapGetters } from 'vuex'

require("./theme/yike.scss")
require("codemirror/mode/gfm/gfm")
require("codemirror/addon/display/placeholder")
require("codemirror/keymap/sublime")

export default {
  name: 'post-form',
  components: { Navbar },
  data() {
    return {
      cover: null,
      title: '',
      body: '',
      publishing: false
    }
  },
  computed: {
    canSubmit: function() {
      return !this.publishing && this.title.trim().length > 0 && this.body.trim().length > 0
    }
  },
  watch: {
    title: function(value) {
      localforage.setItem("post.cache.title", value)
    },
    body: function(content) {
      localforage.setItem("post.cache.body", content)
    }
  },
  mounted() {
    var vm = this
    localforage.getItem("post.cache.title").then(title => vm.title = title || '')

    const editor = CodeMirror.fromTextArea(document.getElementById('post-body'), {
      keyMap: "sublime",
      mode:  "markdown",
      lineWrapping: true,
      autoCloseBrackets: true,
      matchBrackets: true,
      value: vm.body,
      profile: 'html'
    })

    localforage.getItem("post.cache.body").then(body => editor.setValue(body || ''))

    editor.on('change', function(editor){
        vm.body = editor.getValue()
      })
  },
  methods: {
    ...mapActions(['createPost']),
    handleSubmit(publish = true) {
      if (this.title.trim().length <= 0 || this.body.trim().length <= 0) {
        return
      }
      this.createPost({
        title: this.title,
        content: this.body,
        is_draft: !publish,
        type: 'markdown',
      }).then((post) => {
        localforage.removeItem("post.cache.body")
        localforage.removeItem("post.cache.title")
        this.title = ''
        this.body = ''

        this.$router.push(post.data.url)
      }).catch((err) => {
        console.error(err)
      })
    }
  }
}
</script>


<style lang="scss" scoped>
  $placeholder-color: #ccc;

  .post-new {
    background: #fff;
    position: relative;
    height: 100%;
  }

  input, textarea {
    outline: none;
    border: none;
  }

  .cover-picker {
    text-align: center;
    padding: 15px;
    margin: 15px 0;
    color: $placeholder-color;
    font-weight: 300;
    background: rgba(216, 216, 216, .2);
    border:1px dashed rgba(151, 151, 151, .5);
  }

  .post-title {
    font-size: 2em;
    margin: 15px 0;
    width: 100%;
  }

  .post-new .CodeMirror {
    font-family: inherit !important;
    min-height: 300px;
    color: black;
  }
</style>
