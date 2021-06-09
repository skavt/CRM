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
      <no-content :show="!loading && !postData.length"/>
      <div v-if="!loading && postData.length" class="page-content">
        <b-card class="mt-3" no-body v-for="data in postData" :key="`post-${data.id}`">
          <b-card-body class="pt-5">
            {{ data.body }}
          </b-card-body>
          <b-card-footer>
            <like-unlike-button
                class="mr-2" :item="data.userLikes" :liked="data.myLikes.length > 0" @on-like-click="onLikeClick(data)">
            </like-unlike-button>
            <b-button size="sm" pill variant="light" :pressed.sync="showComments">
              <i class="far fa-comments fa-lg"/>
              <b-badge v-if="data.postComments" class="ml-2" pill variant="secondary">
                {{ data.postComments.length }}
              </b-badge>
            </b-button>
          </b-card-footer>
          <add-comment v-if="showComments" :post_id="data.id" :current-user="currentUser"/>
          <b-card-body v-if="showComments && data.postComments && data.postComments.length" class="pt-1 pb-1">
            <comment-item v-for="(comment, index) in data.postComments" :comment="comment" :index="index"
                          :key="`post-comment-${index}`" :current-user="currentUser">
            </comment-item>
          </b-card-body>
          <div class="action-buttons p-2">
            <i class="fas fa-pencil-alt m-2 hover-pointer" @click="onPostEdit(data)" :id="`edit-post-${data.id}`"/>
            <b-tooltip :target="`edit-post-${data.id}`">
              <span class="text-sm px-2">Edit Post</span>
            </b-tooltip>
            <i class="far fa-trash-alt text-danger m-2 hover-pointer" @click="onPostDelete(data)"
               :id="`delete-post-${data.id}`">
            </i>
            <b-tooltip :target="`delete-post-${data.id}`">
              <span class="text-sm px-2">Delete Post</span>
            </b-tooltip>
          </div>
        </b-card>
      </div>
    </b-card-body>
    <post-modal/>
    <channel-modal/>
    <channel-user-modal/>
  </b-card>
</template>

<script>
import ViewSpinner from "../../core/components/view-spinner/view-spinner";
import {createNamespacedHelpers} from "vuex";
import ChannelModal from "./modals/ChannelModal";
import ChannelUserModal from "./modals/ChannelUserModal";
import PostModal from "./modals/PostModal";
import {getPostData} from "../../store/modules/channel/actions";
import LikeUnlikeButton from "./components/LikeUnlikeButton";
import NoContent from "../../core/components/no-content/NoContent";
import AddComment from "./components/comment/AddComment";
import CommentItem from "./components/comment/CommentItem";

const {mapState, mapActions} = createNamespacedHelpers('channel')
const {mapState: mapUserState} = createNamespacedHelpers('employee')
export default {
  name: "Post",
  components: {
    CommentItem,
    AddComment,
    NoContent,
    LikeUnlikeButton,
    PostModal,
    ChannelUserModal,
    ChannelModal,
    ViewSpinner
  },
  data() {
    return {
      loading: false,
      channelData: {},
      postData: [],
      showComments: true,
    }
  },
  computed: {
    ...mapState(['channel', 'post']),
    ...mapUserState(['currentUser']),
  },
  watch: {
    async ['$route.params.channelId']() {
      await this.initialData()
    },
    ['channel.data']() {
      this.channelData = this.channel.data.find(ch => ch.id === parseInt(this.$route.params.channelId))
    },
    ['post.data']() {
      this.postData = [...this.post.data]
    },
  },
  methods: {
    ...mapActions(['deleteChannel', 'showChannelModal', 'showChannelUserModal', 'getChannelData', 'getActiveUsers',
      'showPostModal', 'getPostData', 'like', 'unlike', 'deletePost']),
    onCreatePostClick() {
      this.showPostModal(null)
    },
    async onChannelNewUserClick() {
      await this.getActiveUsers(this.channelData.id)
      this.showChannelUserModal(this.channelData)
    },
    onChannelEditClick() {
      this.showChannelModal(this.channelData)
    },
    async onChannelDeleteClick() {
      let channelName = this.channelData.name
      const result = await this.$confirm(`Are you sure you want to delete ${this.channelData.name} channel?`, `Deleting Channel...`)
      if (result) {
        const {success, body} = await this.deleteChannel(this.channelData.id)
        if (success) {
          this.$toast(`Channel ${channelName} deleted successfully`)
          this.$router.push({name: 'channel'})
        } else {
          this.$toast(body.message, 'danger')
        }
      }
    },
    async onLikeClick(item) {
      let data = {}
      data.post_id = item.id;

      if (item.myLikes.length > 0) {
        data.id = item.myLikes[0].id;
        await this.unlike(data);
      } else {
        await this.like(data);
      }
    },
    async initialData() {
      this.loading = true
      await this.getChannelData()
      await this.getPostData(this.$route.params.channelId)
      this.channelData = this.channel.data.find(ch => ch.id === parseInt(this.$route.params.channelId))
      this.loading = false
    },
    onPostEdit(item) {
      this.showPostModal(item)
    },
    async onPostDelete(item) {
      const result = await this.$confirm(`Are you sure you want to delete post?`, `Deleting Post...`)
      if (result) {
        const {success, body} = await this.deletePost(item.id)
        if (success) {
          this.$toast(`Post deleted successfully`)
        } else {
          this.$toast(body.message, 'danger')
        }
      }
    },
  },
  async mounted() {
    await this.initialData()
  }
}
</script>

<style lang="scss" scoped>
.hover-pointer {
  &:hover {
    cursor: pointer;
  }
}

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
  margin-left: 15%;
  margin-right: 15%;
  position: relative;
}

.action-buttons {
  position: absolute;
  right: 0;
  top: 0;
}

</style>