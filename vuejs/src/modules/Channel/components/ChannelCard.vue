<template>
  <b-card class="card-table" no-body>
    <b-card-body class="pb-0" @click="$router.push({name: 'channel.timeline',  params: {channelId: item.id}})">
      <b-card-title>
        <i class="fab fa-battle-net"/>
        {{ item.name }}
      </b-card-title>
      <b-card-text class="description">
        {{ item.description }}
      </b-card-text>
    </b-card-body>
    <b-card-body class="action-wrapper">
      <div class="d-flex justify-content-end">
        <b-button size="sm" variant="outline-secondary" class="ml-1" @click="onAddUserClick">
          <i class="fas fa-plus"/>
          Add User
        </b-button>
        <b-button size="sm" variant="outline-primary" class="ml-1" @click="onEditClick">
          <i class="fas fa-pencil-alt"/>
          Edit
        </b-button>
        <b-button size="sm" variant="outline-danger" class="ml-1" @click="onDeleteClick">
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
  methods: {
    onAddUserClick() {
      this.$emit('on-add-user-click', this.item)
    },
    onEditClick() {
      this.$emit('on-channel-edit-click', this.item)
    },
    onDeleteClick() {
      this.$emit('on-channel-delete-click', this.item)
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