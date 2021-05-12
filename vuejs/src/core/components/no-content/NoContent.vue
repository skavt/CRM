<template>
  <div class="no-data-exists d-flex flex-column justify-content-center align-items-center" v-if="show">
    <p class="text-muted m-0">{{ text }}</p>
  </div>
</template>

<script>
export default {
  name: "NoContent",
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    text: {
      type: String,
      default: 'No Data Available'
    },
  },
}
</script>

<style scoped>

.no-data-exists {
  height: 100px;
  font-size: 18px;
}

</style>