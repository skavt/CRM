<template>
  <p v-if="show" class="alert alert-danger">
    {{ errorMessage }}
  </p>
</template>

<script>
export default {
  name: "ErrorContent",
  props: {
    show: {
      type: Boolean,
      default: false,
    },
    errorMessage: String,
  },
}
</script>

<style scoped>

</style>