<template>
  <div class="post-new">
    <navbar>
      <div class="page-actions" slot="page-actions" v-if="mode == 'new'">
        <a href="#" class="nav-item text-success" :disabled="!canSubmit" @click="handleSubmit('发布')">发布</a>
        <a href="#" class="nav-item text-secondary" :disabled="!canSubmit" @click="handleSubmit('文章草稿发布', false)">存为草稿</a>
      </div>
      <div class="page-actions" slot="page-actions" v-else>
        <a href="#" class="nav-item text-success" @click="handleCancel()">取消</a>
        <a href="#" class="nav-item text-success" :disabled="!canSubmit" @click="handleSubmit('更新')">保存</a>
      </div>
    </navbar>
    <div class="container post-container pt-5">
      <div class="cover-picker">
        <div class="picker">&plus; 设置封面</div>
      </div>
      <input class="post-title" placeholder="请输入标题" v-model="form.title" />
      <textarea class="post-content" id="post-content" placeholder="请输入内容"></textarea>
    </div>
  </div>
</template>

<script>
import CodeMirror from "codemirror"
import localforage from "localforage"
import Navbar from "home/Navbar"
import { getData } from 'utils/get'

require("./theme/yike.css")
require("codemirror/mode/gfm/gfm")
require("codemirror/addon/display/placeholder")
require("codemirror/keymap/sublime")

export default {
  name: 'post-form',
  components: { Navbar },
  props: {
    post: {
      type: Object,
      default() {
         return {
          cover: null,
          title: '',
          content: '',
        }
      }
    }
  },
  data() {
    return {
      form: {
        cover: null,
        title: '',
        content: '',
      },
      editor: {},
      publishing: false
    }
  },
  computed: {
    mode: function() {
      return this.form.id ? 'edit' : 'new'
    },
    canSubmit: function() {
      return !this.publishing && this.form.title.trim().length > 0 && this.form.content.trim().length > 0
    }
  },
  watch: {
    post: function(post) {
      this.form = post
      this.editor.setValue(post.content || '')
    },
    form: {
      handler: function(form) {
        localforage.setItem("post.cache", form)
      },
      deep: true
    }
  },
  mounted() {
    var vm = this
    this.editor = CodeMirror.fromTextArea(document.getElementById('post-content'), {
      keyMap: "sublime",
      mode:  "markdown",
      lineWrapping: true,
      autoCloseBrackets: true,
      matchBrackets: true,
      value: vm.form.content || '',
      profile: 'html'
    })

    this.editor.on('change', function(editor){
      vm.form.content = editor.getValue()
    })

    localforage.getItem("post.cache").then(post => {
      if (!post) { return }
      if (vm.mode == 'new' && post.id) {
        return localforage.removeItem("post.cache")
      }
      vm.form = Object.assign(vm.form, post)
      vm.editor.setValue(post.content || '')
    })
  },
  methods: {
    handleCancel() {
      localforage.removeItem("post.cache")
      this.$router.push({name: 'post.show', params: this.$route.params})
    },
    handleSubmit(messageType = '发布', publish = true) {
      if (this.form.title.trim().length <= 0 || this.form.content.trim().length <= 0) {
        return
      }

      let url = this.$config.entrypoints.posts + (this.form.id || '')
      let method = this.mode == 'new' ? 'post' : 'patch'

      this.form.is_draft = publish
      this.form.type = 'markdown'

      this.$http[method](url, this.form).then((post) => {
        localforage.removeItem("post.cache")

        this.form.title = this.form.content = ''
        this.editor.setValue('')

        this.$message.success(messageType + '成功!')
        this.$router.push(getData(post).data.url)
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
    min-height: 300px;
    color: black;
  }
</style>
