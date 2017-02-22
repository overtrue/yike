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
import FineUploader from 'fine-uploader/lib/traditional'
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
      publishing: false,
      uploadConfig: {
          request: {
            endpoint: '/files/upload',
            inputName: 'file',
            customHeaders: {
              Authorization: ''
            },
          },
          validation: {
            acceptFiles: 'image/*',
          },
          sizeLimit: 4194304, // 4 * 1024 * 1024
      }
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
    this.fetchAuthToken().then(this.setupCoverUploader).then(this.setupContentImageUploader)
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
    fetchAuthToken() {
      return localforage.getItem(userTokenStorageKey, (err, token) => {
        this.uploadConfig.request.customHeaders.Authorization = `Bearer ${token}`
      })
    },
    getPlaceholderOfContentImage(name) {
      return '\n![Uploading '+name+'...]()\n'
    },
    createdContentImagePlaceholder(name) {
      this.editor.getDoc().replaceSelection(this.getPlaceholderOfContentImage(name))
    },
    replaceContentImagePlaceholder(name, url) {
      let result = ''

      if (url) {
        result = '\n!['+name+'](/'+url+')\n'
      }

      this.editor.setValue(this.editor.getValue().replace(this.getPlaceholderOfContentImage(name), result))
    },
    setupCoverUploader() {
      var vm = this

      const coverUploader = new FineUploader.FineUploaderBasic(Object.assign({}, this.uploadConfig, {
        callbacks: {
          onComplete(id, name, responseJSON) {
            if (typeof responseJSON['image_id'] == 'undefined') {
              return vm.$store.dispatch('setMessage', { type: 'error', message: ['图片上传失败'] })
            }
            vm.form.image_id = responseJSON.image_id
            vm.form.cover = '/' + responseJSON.relative_url
          }
        }
      }))
    },

    setupContentImageUploader() {
      var vm = this
      vm.editor.on('paste', function(editor, event){
        event.preventDefault()
      })
      const contentUploader = new FineUploader.FineUploaderBasic(Object.assign({}, this.uploadConfig, {
        paste: {
          targetElement: document.querySelector('.CodeMirror')
        },
        callbacks: {
          onPasteReceived(file) {
            var promise = new FineUploader.Promise();

            if (typeof file.type == 'undefined' || file.type.indexOf('image/')) {
              return promise.failure('not a image.')
            }
            if (file.size > 4 * 1024 * 1024) {
              vm.$store.dispatch('setMessage', {type: 'error', message: ['您粘贴的图片过大']})
              return promise.failure('您粘贴的图片过大')
            }

            return promise.then(() => {
              vm.createdContentImagePlaceholder('image.png')
            }).success('image')
          },
          onComplete(id, name, responseJSON) {
            let url = ''
            if (typeof responseJSON['relative_url'] !== 'undefined') {
              url = responseJSON.relative_url
            }
            vm.replaceContentImagePlaceholder(name, url)
          },
          onError() {
            vm.$store.dispatch('setMessage', {type: 'error', message: ['图片上传失败']})
            vm.replaceContentImagePlaceholder(name, '')
          }
        }
      }))

      let dragAndDropModule = new FineUploader.DragAndDrop({
        dropZoneElements: [document.querySelector('.CodeMirror')],
        callbacks: {
          processingDroppedFilesComplete(files, dropTarget) {
            files.forEach((file) => {
              vm.createdContentImagePlaceholder(file.name)
            })
            contentUploader.addFiles(files); //this submits the dropped files to Fine Uploader
          }
        }
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
