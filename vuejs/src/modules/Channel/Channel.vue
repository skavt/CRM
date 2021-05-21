<template>
  <b-card no-body class="invitation-card">
    <b-card-header>
      <b-button class="float-right" variant="secondary" size="sm" @click="onAddChannelClick">
        <i class="fas fa-plus"/>
        Add Channel
      </b-button>
    </b-card-header>

  </b-card>
</template>

<script>
import {createNamespacedHelpers} from "vuex";

const {mapActions} = createNamespacedHelpers('channel')
export default {
  name: "Channel",
  methods: {
    ...mapActions(['setData']),
    onAddChannelClick() {

    },
  },
  async mounted() {
    await this.setData()
  },
}
</script>

<style scoped>

</style>