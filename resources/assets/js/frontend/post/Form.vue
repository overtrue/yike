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
      <div class="post-title" placeholder="请输入标题" contenteditable="true"></div>
      <textarea class="post-body" id="post-body" placeholder="请输入内容"></textarea>
    </div>
    <div class="page-actions">
      <a href="#" class="btn btn-outline-success" @click="handleSubmit()">发布</a>
      <a href="#" class="btn btn-outline-secondary" @click="handleSubmit(false)">存为草稿</a>
    </div>
  </div>
</template>

<script>
import CodeMirror from "codemirror"

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
      body: ''
    }
  },
  mounted() {
    var that = this

    const editor = CodeMirror.fromTextArea(document.getElementById('post-body'), {
      keyMap: "sublime",
      mode:  "markdown",
    });

    editor.on('change', function(editor){
        that.body = editor.getValue();
      });

    var pageActionsBox = document.querySelector('.page-actions-wrapper');
    pageActionsBox.appendChild(document.querySelector('.page-actions'));
  },
  methods: {
    handleSubmit(publish = true) {
      console.log(publish, this.title, this.body);
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

  [contenteditable] {
    outline: none;
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
  }

  [placeholder]:empty:before {
    content: attr(placeholder);
    color: $placeholder-color;
    font-weight: 300;
  }

  [placeholder]:empty:focus:before {
      content: "";
  }


  .post-new .CodeMirror {
    font-family: inherit !important;
    min-height: 300px;
    color: black;
  }
</style>
