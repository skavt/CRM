<template>
  <b-card no-body class="post-card">
    <b-card-header>
      <b-button variant="light" class="mr-3" @click="$router.push({name: 'channel'})">
        <i class="fas fa-chevron-left"/>
        Back
      </b-button>
      <div class="float-right">
        <b-button class="mr-1" variant="secondary" size="sm" @click="onCreatePostClick">
          <i class="fas fa-plus"/>
          Create Post
        </b-button>
        <b-button class="mr-1" variant="outline-secondary" size="sm" @click="onChannelNewUserClick">
          <i class="fas fa-plus"/>
          Add User
        </b-button>
        <b-button class="mr-1" variant="outline-primary" size="sm" @click="onChannelEditClick">
          <i class="fas fa-pencil-alt"/>
          Edit Channel
        </b-button>
        <b-button variant="outline-danger" size="sm" @click="onChannelDeleteClick">
          <i class="fas fa-trash"/>
          Delete Channel
        </b-button>
      </div>
    </b-card-header>

    <b-card-body class="post-card-body">
      <view-spinner :show="loading"/>
      <div v-if="!loading" class="page-content">

      </div>
    </b-card-body>
    <channel-modal/>
    <channel-user-modal/>
  </b-card>
</template>

<script>
import ViewSpinner from "../../core/components/view-spinner/view-spinner";
import {createNamespacedHelpers} from "vuex";
import ChannelModal from "./modals/ChannelModal";
import ChannelUserModal from "./modals/ChannelUserModal";

const {mapState, mapActions} = createNamespacedHelpers('channel')
export default {
  name: "Post",
  components: {ChannelUserModal, ChannelModal, ViewSpinner},
  data() {
    return {
      loading: false,
      channelData: {},
    }
  },
  computed: {
    ...mapState(['channel']),
  },
  watch: {
    async ['$route.params.channelId']() {
      await this.getChannelData()
      this.channelData = this.channel.data.find(ch => ch.id === parseInt(this.$route.params.channelId))
    },
  },
  methods: {
    ...mapActions(['deleteChannel', 'showChannelModal', 'showChannelUserModal', 'getChannelData', 'getActiveUsers']),
    onCreatePostClick() {

    },
    async onChannelNewUserClick() {
      await this.getActiveUsers(this.channelData.id)
      this.showChannelUserModal(this.channelData)
    },
    onChannelEditClick() {
      this.showChannelModal(this.channelData)
    },
    async onChannelDeleteClick() {
      const result = await this.$confirm(`Are you sure you want to delete ${this.channelData.name} channel?`, `Deleting Channel...`)
      if (result) {
        const {success, body} = await this.deleteChannel(this.channelData.id)
        if (success) {
          this.$toast(`Channel ${this.channelData.name} deleted successfully`)
          this.$router.push({name: 'channel'})
        } else {
          this.$toast(body.message, 'danger')
        }
      }
    },
  },
  async mounted() {
    this.loading = true
    await this.getChannelData()
    this.channelData = this.channel.data.find(ch => ch.id === parseInt(this.$route.params.channelId))
    this.loading = false
  }
}
</script>

<style lang="scss" scoped>

.post-card {
  height: 100%;
  width: 100%;
}

.post-card-body {
  background: #E8E8E8;
  padding: 0;
  overflow-x: hidden;
  overflow-y: auto;
}

.page-content {
  position: relative;
}

</style>