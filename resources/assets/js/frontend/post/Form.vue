<template>
  <div class="post-form">
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
    <div class="container w760 pt-5">
      <div class="post-cover" v-if="form.cover">
        <img :src="form.cover">
        <div class="toolbox d-flex align-items-center justify-content-center">
          <a class="btn-reupload" @click.prevent="reUploadCover()"><i class="material-icons">cloud_upload</i> 重新上传</a>
          <a class="btn-remove" @click.prevent="removeCover()"><i class="material-icons">delete</i> 移除</a>
        </div>
      </div>
      <div class="cover-picker" id="cover-picker"  v-show="!form.cover">
        <div class="picker"><i class="material-icons">image</i> 设置封面</div>
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
import FineUploader from 'fine-uploader/lib/core'
import { userTokenStorageKey } from 'src/config'

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
          image_id: null,
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
    this.setupEditor()
    this.setupUploader()
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

      let url = this.$endpoints.posts + (this.form.id || '')
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
    },
    reUploadCover() {
      document.querySelector('#cover-picker input').click()
    },
    removeCover() {
      this.form.cover = null
    },
    setupEditor() {
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
    setupUploader() {
      var vm = this
      localforage.getItem(userTokenStorageKey, (err, token) => {
        const uploader = new FineUploader.FineUploaderBasic({
          button: document.getElementById("cover-picker"),
          request: {
            endpoint: '/files/upload',
            inputName: 'file',
            customHeaders: {
              Authorization: `Bearer ${token}`
            },
          },
          validation: {
            acceptFiles: 'image/jpeg',
          },
          sizeLimit: 4294967296, // 4096 * 1024 * 1024
          retry: {
             enableAuto: true, // defaults to false
             maxAutoAttempts: 2,
          },
          callbacks: {
            onComplete(id, name, responseJSON) {
              vm.form.image_id = responseJSON.image_id
              vm.form.cover = '/' + responseJSON.relative_url
            }
          }
        })
      })
    }
  }
}
</script>


<style lang="scss" scoped>
  $placeholder-color: #bbb;

  input, textarea {
    outline: none;
    border: none;
  }

  .post-cover {
    position: relative;
    img {
      width: 100%;
    }

    .toolbox {
      position: absolute;
      top:0;
      height: 100%;
      width: 100%;
      opacity: 0;
      text-align: center;

      a {
        padding: 8px 15px;
        color: #eee;
        cursor: pointer;
        border-radius: 3px;
        &:hover {
          background: rgba(0,0,0, .3);
        }
      }
    }

    &:hover .toolbox {
      opacity: 1;
      background: rgba(0,0,0, .4);
    }
  }

  .cover-picker {
    cursor: pointer;
    text-align: center;
    padding: 15px;
    margin: 15px 0;
    border-radius: 2px;
    color: $placeholder-color;
    background: rgba(216, 216, 216, .2);
    border:1px dashed rgba(151, 151, 151, .5);
  }

  .post-title {
    font-size: 2em;
    margin: 15px 0;
    width: 100%;
  }

  .post-form .CodeMirror {
    min-height: 300px;
    color: black;
  }
</style>
