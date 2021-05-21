<template>
  <b-card class="card-table" no-body>
    <b-card-body class="pb-0">
      <b-card-title>
        <i class="fas fa-layer-group"/>
        Text
      </b-card-title>
      <b-card-text class="description">
        Description Description Description Description Description Description
      </b-card-text>
    </b-card-body>
  </b-card>
</template>

<script>
export default {
  name: "ChannelCard"
}
</script>

<style lang="scss" scoped>

.card-table {
  position: relative;
  cursor: pointer;
  transition: all 0.3s;
  border-radius: 0;
  height: 100%;
  width: 300px;
  min-height: 10rem;
  min-width: 16rem;

  &:hover {
    box-shadow: 0 0 0 2px #003349;
  }

  .description {
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
  }
}
</style>