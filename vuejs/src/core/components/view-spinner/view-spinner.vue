<template>
  <div v-if="show" class="view-spinner d-flex flex-column justify-content-center align-items-center"
       :class="{'fullscreen-spinner': fullscreen}">
    <b-spinner/>
    <div v-if="text" class="mt-3">{{ text }}</div>
  </div>
</template>

<script>
export default {
  name: "view-spinner",
  props: {
    show: {
      type: Boolean,
      require: true,
    },
    fullscreen: {
      type: Boolean,
      default: false,
    },
    text: {
      type: String,
      default: 'Please Wait...',
    },
  },
}
</script>

<style lang="scss" scoped>

.view-spinner {
  min-height: 100px;
}

.fullscreen-spinner {
  position: absolute;
  background-color: #FFF;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  z-index: 100;
}

</style>