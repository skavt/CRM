<template>
  <div class="channel-card">
    <b-card no-body>
      <b-card-header>
        <b-button class="float-right" variant="secondary" size="sm" @click="onAddChannelClick">
          <i class="fas fa-plus"/>
          Add Channel
        </b-button>
      </b-card-header>
    </b-card>
    <div class="page-content">
      <div class="row ml-0">
        <div class="card-wrapper mt-3 ml-3">
          <channel-card/>
        </div>
      </div>
    </div>
    <channel-modal/>
  </div>
</template>

<script>
import {createNamespacedHelpers} from "vuex";
import ChannelCard from "./components/ChannelCard";
import ChannelModal from "./modals/ChannelModal";

const {mapActions} = createNamespacedHelpers('channel')
export default {
  name: "Channel",
  components: {ChannelModal, ChannelCard},
  methods: {
    ...mapActions(['setData', 'showChannelModal']),
    onAddChannelClick() {
      this.showChannelModal(null)
    },
  },
  async mounted() {
    await this.setData()
  },
}
</script>

<style lang="scss" scoped>

.channel-card {
  height: 5.6%;
  width: 100%;
  margin-top: 0 !important;
}

.page-content {
  position: relative;
}

</style>