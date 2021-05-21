<template>
  <b-card no-body class="channel-card">
    <b-card-header>
      <b-button class="float-right" variant="secondary" size="sm" @click="onAddChannelClick">
        <i class="fas fa-plus"/>
        Add Channel
      </b-button>
    </b-card-header>

    <b-card-body class="channel-card-body">
      <view-spinner :show="loading"/>
      <div v-if="!loading" class="page-content">
        <div class="row ml-0">
          <div class="card-wrapper mt-3 ml-3" v-for="item in channelData" :key="`channel-card-${item.id}`">
            <channel-card :item="item"/>
          </div>
        </div>
      </div>
    </b-card-body>
    <channel-modal/>
  </b-card>
</template>

<script>
import {createNamespacedHelpers} from "vuex";
import ChannelCard from "./components/ChannelCard";
import ChannelModal from "./modals/ChannelModal";
import {getChannelData} from "../../store/modules/channel/actions";
import ViewSpinner from "../../core/components/view-spinner/view-spinner";

const {mapState, mapActions} = createNamespacedHelpers('channel')
export default {
  name: "Channel",
  components: {ViewSpinner, ChannelModal, ChannelCard},
  data() {
    return {
      loading: false,
    }
  },
  computed: {
    ...mapState({
      channelData: state => state.channel.data,
    }),
  },
  methods: {
    ...mapActions(['getChannelData', 'showChannelModal']),
    onAddChannelClick() {
      this.showChannelModal(null)
    },
  },
  async mounted() {
    this.loading = true
    await this.getChannelData()
    this.loading = false
  },
}
</script>

<style lang="scss" scoped>

.channel-card {
  height: 100%;
  width: 100%;
  margin-top: 0 !important;
  overflow-x: hidden;
  overflow-y: auto;
}

.channel-card-body {
  background: #E8E8E8;
  padding: 0;
}

.page-content {
  position: relative;
}

</style>