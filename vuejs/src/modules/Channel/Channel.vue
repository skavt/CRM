<template>
  <b-card no-body class="channel-card">
    <b-card-header v-permission="'createChannel'">
      <b-button class="float-right" variant="secondary" size="sm" @click="onAddChannelClick">
        <i class="fas fa-plus"/>
        Add Channel
      </b-button>
    </b-card-header>

    <b-card-body class="channel-card-body">
      <view-spinner :show="loading"/>
      <no-content :show="!loading && !channelData.length"/>
      <div v-if="!loading && channelData.length" class="page-content">
        <div class="row ml-0">
          <div class="card-wrapper mt-3 ml-3" v-for="item in channelData" :key="`channel-card-${item.id}`">
            <channel-card :item="item" @on-add-user-click="onAddUser" @on-channel-edit-click="onChannelEdit"
                          @on-channel-delete-click="onChannelDelete">
            </channel-card>
          </div>
        </div>
      </div>
    </b-card-body>
    <channel-modal/>
    <channel-user-modal/>
  </b-card>
</template>

<script>
import {createNamespacedHelpers} from "vuex";
import ChannelCard from "./components/ChannelCard";
import ChannelModal from "./modals/ChannelModal";
import {getActiveUsers, getChannelData} from "../../store/modules/channel/actions";
import ViewSpinner from "../../core/components/view-spinner/view-spinner";
import ChannelUserModal from "./modals/ChannelUserModal";
import NoContent from "../../core/components/no-content/NoContent";

const {mapState, mapActions} = createNamespacedHelpers('channel')
export default {
  name: "Channel",
  components: {NoContent, ChannelUserModal, ViewSpinner, ChannelModal, ChannelCard},
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
    ...mapActions(['getChannelData', 'showChannelModal', 'deleteChannel', 'showChannelUserModal', 'getActiveUsers']),
    onAddChannelClick() {
      this.showChannelModal(null)
    },
    async onAddUser(item) {
      await this.getActiveUsers(item.id)
      this.showChannelUserModal(item)
    },
    onChannelEdit(item) {
      this.showChannelModal(item)
    },
    async onChannelDelete(item) {
      const result = await this.$confirm(`Are you sure you want to delete ${item.name} channel?`, `Deleting Channel...`)
      if (result) {
        const {success, body} = await this.deleteChannel(item.id)
        if (success) {
          this.$toast(`Channel ${item.name} deleted successfully`)
        } else {
          this.$toast(body.message, 'danger')
        }
      }
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
}

.channel-card-body {
  background: #E8E8E8;
  padding: 0;
  overflow-x: hidden;
  overflow-y: auto;
}

.page-content {
  position: relative;
}

</style>