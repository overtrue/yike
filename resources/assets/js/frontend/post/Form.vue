<navbar>
    <span slot="page-actions">
      <a class="text-success">发布</a>
    </span>
</navbar>

<template>
  <div class="post-new">
    <div class="container pt-5">
      <div class="cover-picker">
        <div class="picker">&plus; 设置封面</div>
      </div>
      <input class="post-title" placeholder="请输入标题" v-model="title" />
      <textarea class="post-body" id="post-body" placeholder="请输入内容"></textarea>
    </div>
    <div class="page-actions">
      <a href="#" class="btn btn-sm btn-outline-success" @click="handleSubmit()">发布</a>
      <a href="#" class="btn btn-sm btn-outline-secondary" @click="handleSubmit(false)">存为草稿</a>
    </div>
  </div>
</template>

<script>
import CodeMirror from "codemirror"
import localforage from "localforage"
import { mapActions, mapGetters } from 'vuex'

require("./theme/yike.scss")
require("codemirror/mode/gfm/gfm")
require("codemirror/addon/display/placeholder")
require("codemirror/keymap/sublime")

export default {
  name: 'post-form',
  data() {
    return {
      cover: null,
      title: '',
      body: '',
    }
  },
  watch: {
    title: function(value) {
      console.log(value)
      localforage.setItem("post.cache.title", value);
    },
    body: function(content) {
      console.log(content)
      localforage.setItem("post.cache.body", content);
    }
  },
  mounted() {
    var vm = this;
    localforage.getItem("post.cache.title").then(title => vm.title = title);

    const editor = CodeMirror.fromTextArea(document.getElementById('post-body'), {
      keyMap: "sublime",
      mode:  "markdown",
      lineWrapping: true,
      autoCloseBrackets: true,
      matchBrackets: true,
      value: vm.body,
    });

    localforage.getItem("post.cache.body").then(body => editor.setValue(body || ''));

    editor.on('change', function(editor){
        vm.body = editor.getValue();
      });

    var pageActionsBox = document.querySelector('.page-actions-wrapper');
    pageActionsBox.appendChild(document.querySelector('.page-actions'));
  },
  methods: {
    ...mapActions(['createPost']),
    handleSubmit(publish = true) {
      this.createPost({
        title: this.title,
        content: this.body,
        type: 'markdown',
      }).then((post) => {
        localforage.removeItem("post.cache.body")
        localforage.removeItem("post.cache.title")
        this.$router.push(post.data.url);
      }).catch((err) => {
        alert(err);
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
