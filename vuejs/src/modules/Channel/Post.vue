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
  </b-card>
</template>

<script>
import ViewSpinner from "../../core/components/view-spinner/view-spinner";
import {createNamespacedHelpers} from "vuex";

const {mapState, mapActions} = createNamespacedHelpers('channel')
export default {
  name: "Post",
  components: {ViewSpinner},
  data() {
    return {
      loading: false,
    }
  },
  computed: {
    ...mapState(['channel']),
  },
  methods: {
    ...mapActions(['deleteChannel']),
    onCreatePostClick() {

    },
    async onChannelDeleteClick() {
      let channel = this.channel.data.find(ch => ch.id === parseInt(this.$route.params.channelId))
      const result = await this.$confirm(`Are you sure you want to delete ${channel.name} channel?`, `Deleting Channel...`)
      if (result) {
        const {success, body} = await this.deleteChannel(channel.id)
        if (success) {
          this.$toast(`Channel ${channel.name} deleted successfully`)
          this.$router.push({name: 'channel'})
        } else {
          this.$toast(body.message, 'danger')
        }
      }
    },
  },
  mounted() {
    this.loading = true
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