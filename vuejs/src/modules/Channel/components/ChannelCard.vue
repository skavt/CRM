<template>
  <b-card class="card-table" no-body>
    <b-card-body class="pb-0">
      <b-card-title>
        <i class="fas fa-layer-group"/>
        {{ item.name }}
      </b-card-title>
      <b-card-text class="description">
        {{ item.description }}
      </b-card-text>
    </b-card-body>
    <b-card-body class="action-wrapper">
      <div class="d-flex justify-content-end">
        <b-button size="sm" variant="outline-primary" class="ml-1">
          <i class="fas fa-pencil-alt"/>
          Edit
        </b-button>
        <b-button size="sm" variant="outline-danger" class="ml-1">
          <i class="fas fa-trash"/>
          Delete
        </b-button>
      </div>
    </b-card-body>
  </b-card>
</template>

<script>
export default {
  name: "ChannelCard",
  props: {
    item: {
      type: Object,
      require: true,
    },
  },
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

.action-wrapper {
  flex-direction: column;
  display: flex;
  justify-content: flex-end;
  align-items: flex-end;
}
</style>