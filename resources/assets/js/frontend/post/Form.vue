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
      <div class="post-body" placeholder="请输入正文" contenteditable="true"></div>
    </div>
  </div>
</template>

<script>
  export default {
    name: 'post-form',
    data() {
      return {
        cover: null,
        title: '',
        body: ''
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
</style>
