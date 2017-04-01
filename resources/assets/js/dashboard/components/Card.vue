<template>
  <div class="card">
    <div class="card-block d-flex">
      <div class="d-inline-flex icon">
        <i class="material-icons">{{ icon }}</i>
      </div>
      <div class="content d-inline-flex justify-content-center flex-column w-100 text-center" style="display:inline-block;">
        <h1>{{ total }}</h1>
        <p class="card-text">{{ description }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    icon: { type: String, default: 'report_problem' },
    total: { type: Number, default: 0 },
    description: { type: String, default: null },
  }
}
</script>

<style lang="scss" scoped>
.card {
  border-radius: 10px;
  box-shadow: 2px 5px 10px rgba(0, 0, 0, 0.05);
  color: #888;
}
.icon {
  font-size: 60px;
  color: #eee;
}
</style>
